/* Name: ihex.c
 * Author: Hell Prototypes          http://www.hellprototypes.com/
 * Copyright: Hell Prototypes
 * License: GPL http://www.gnu.org/licenses/gpl-2.0.html
 * Project: Hellduino
 * Function: hex file converter
 * Version: 0.1
 */
#include <avr/io.h>
#include <string.h>

#include "tftp.h"
#include "ihex.h"
#include "debug.h"
#include "validate.h"

#include "../boot.h"

#define RING_BUFFER_LEN		(TFTP_MAX_PAYLOAD +80)

uint8_t  g_ring_buffer[RING_BUFFER_LEN];
uint16_t g_buffer_head, g_buffer_trail, g_read_trail;

#define PAGE_FIFO_LEN		(SPM_PAGESIZE * 2)
uint8_t  g_page_fifo[PAGE_FIFO_LEN];
uint8_t  g_fifo_head, g_fifo_trail;

uint16_t g_writeAddr;

void ihex_init(void) {
	TRACE1("\r\nTFTP hex mode start\r\n");
	g_buffer_head = 0;
	g_buffer_trail = 0;
	g_fifo_head = 0;
	g_fifo_trail = 0;
	g_writeAddr = 0;
}

void ihex_push_back(uint8_t* new_data, uint16_t len) {
	while(len--) {
		g_ring_buffer[g_buffer_head++] = *new_data++;
		if(g_buffer_head >= RING_BUFFER_LEN) {
			g_buffer_head = 0;
		}
	#ifdef DEBUG
		if(g_buffer_head == g_buffer_trail) {
			TRACE1("\r\n###Head = trail\r\n");
		}
	#endif
	}
}

int8_t xtod(char x) {
 	if((x >= '0') && (x <= '9')){
		return (x-'0');
	}
	if((x >= 'A') && (x <= 'F')){
		return (x-'A'+10);
	}
	if((x >= 'a') && (x <= 'f')){
		return (x-'a'+10);
	}
	return -1;
}

uint8_t _ascii2bin(char h, char l) {
	return ((uint8_t)xtod(h) << 4) | (uint8_t)xtod(l);
}

void ihex_line_take(void) {
	g_buffer_trail = g_read_trail;
}

uint8_t ihex_get_line(uint8_t* read_data) {
 	uint8_t line_len = 0;
	TRACE1("\r\nhead=");
	tracenum1(g_buffer_head);
	TRACE1(" read=");
	tracenum1(g_read_trail);

	char c=0;
 	while(g_read_trail != g_buffer_head) {
 		c = (char)g_ring_buffer[g_read_trail++];
		//g_read_trail %= RING_BUFFER_LEN;
		if(g_read_trail >= RING_BUFFER_LEN) {
			g_read_trail = 0;
		}
		if((c >= '0') && (c <= 'f')) {//0~9, A-F, a~f
			//TRACE1("\r\n%");
			//tracenum1((uint8_t)c);
			read_data[line_len++] = c;
			if(line_len >= HEX_LINE_MAX_LEN) {
				return HEX_READ_LINE_ERR;
			}
		} else if(c == '\n') {
			if(line_len > 0) {
				break;
			}
		} else if(c == '\r') {
			//continue
		} else {
			TRACE1("\r\n===");
			tracenum1((uint8_t)c);
			return HEX_READ_LINE_ERR;
		}
	}
	TRACE1("\r\n#line_len=");
	tracenum1(line_len);

	return line_len;
}

uint8_t ihex_get_page(uint8_t* page_data, int8_t *err_code)
{
	uint8_t line_buffer[HEX_LINE_MAX_LEN];
	uint8_t line_len;
	uint8_t page_len = 0;

	*err_code = HEX_ERR_EMPTY;
	g_read_trail = g_buffer_trail;
	while((line_len = ihex_get_line(line_buffer))) {
		if(line_len > HEX_LINE_MAX_LEN) {
			*err_code = HEX_ERR_FORMAT;
			break;
		}
		*err_code = HEX_ERR_NONE;
	#ifdef DEBUG
		TRACE1("\r\n* Line=");
		line_buffer[line_len] = '\0';
		TRACE1((char *)line_buffer);
	#endif
		if(line_buffer[0] != ':') {
			*err_code = HEX_ERR_FORMAT;
			break;
		}
		uint8_t  len  = _ascii2bin(line_buffer[1], line_buffer[2]);
		if((line_len < 11)||((len*2 + 11) != line_len)) {
			*err_code = HEX_ERR_LINE;
			break;
		}
		ihex_line_take();
		uint8_t type = _ascii2bin(line_buffer[7], line_buffer[8]);
		if(type == 0x00) {
			uint8_t addr_H = _ascii2bin(line_buffer[3], line_buffer[4]);
			uint8_t addr_L = _ascii2bin(line_buffer[5], line_buffer[6]);
			uint8_t checksum = len + addr_H + addr_L;
			TRACE1("\r\nlen=");
			tracenum1(len);

			uint8_t i,j;
			for(i=0,j = 9; j < 9 + (2*len); i++,j+=2) {
				uint8_t d = _ascii2bin(line_buffer[j], line_buffer[j+1]);
				g_page_fifo[g_fifo_head++] = d;
				g_fifo_head %= PAGE_FIFO_LEN;
			#ifdef DEBUG
				if(g_fifo_head == g_fifo_trail) {
					TRACE1("\r\n***Head = trail");
				}
			#endif
				checksum += d;
			}
			checksum += _ascii2bin(line_buffer[j], line_buffer[j+1]);
			TRACE1("\r\nchecksum=");
			tracenum1(checksum);
			if(checksum != 0x00){
				*err_code = HEX_ERR_CHECK;
				break;
			}
			page_len = g_fifo_head - g_fifo_trail;//FIXME: if buffer not 256B len
			if(page_len >= SPM_PAGESIZE) {
				break;
			}
		} else {
			if(type == 0x01) {
				*err_code = HEX_FILE_END;
				break;
			} 
		}
	}
	if((line_len == 0) && (page_len > 0)) {
		TRACE1("\r\n#######");
		*err_code = HEX_ERR_LINE;
	}
	if(*err_code >= HEX_ERR_NONE) {
		if(page_len > SPM_PAGESIZE) {
			page_len = SPM_PAGESIZE;
		}
		for(uint8_t i=0; i<page_len; i++) {
			page_data[i] = g_page_fifo[g_fifo_trail++];
			g_fifo_trail %= PAGE_FIFO_LEN;
		}
	} else {
		page_len = 0;
	}
	return page_len;
}

int8_t ihex_package_process(uint8_t* package, uint16_t package_len)
{
	uint8_t page_len;
	int8_t  err_code;
	ihex_push_back(package, package_len);
	do {
		memset(package, 0xFF, SPM_PAGESIZE);
		page_len = ihex_get_page(package, &err_code);
		TRACE1("\r\npage_len=");
		tracenum1(page_len);
		if(page_len > 0) {
			if (g_writeAddr == 0) {
				// First sector - validate
				if (!validImage(package)) {
					TRACE1("Invalid Image!\r\n");
					return -1;
				}
			}
			TRACE1("\r\ng_writeAddr=");
			tracenum1(g_writeAddr);

			boot_page_erase(g_writeAddr);
			boot_spm_busy_wait();
			// Flash packets
			for (uint8_t offset=0; offset < SPM_PAGESIZE; offset+=2) {
				uint16_t wv = (package[offset]) | (package[offset+1]<<8);
			#ifdef DEBUG
				if(offset%16 == 0) TRACE1("\r\n");
				tracenum1(wv);
				TRACE1(" ");
			#endif
				boot_page_fill(g_writeAddr+offset, wv);
			}
			boot_page_write(g_writeAddr);
			boot_spm_busy_wait();
			boot_rww_enable();
			if(err_code == HEX_FILE_END) {
				return 1;
			}
			g_writeAddr += page_len;
		}else {
			TRACE1("\r\nget page err=-");
			tracenum1(-err_code);
			TRACE1("\r\n");
			if((err_code == HEX_ERR_LINE) || (err_code == HEX_ERR_EMPTY)) {
				break;
			} else {
				//HEX_ERR_CHECK
				//HEX_ERR_FORMAT
				return -2;
			}
		}
	}while(page_len > 0);
	return 0;
}
