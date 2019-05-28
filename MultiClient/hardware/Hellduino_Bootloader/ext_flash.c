/* Name: ext_flash.c
 * Author: Hell Prototypes    http://www.hellprototypes.com/
 * Copyright: Hell Prototypes
 * License: GPL http://www.gnu.org/licenses/gpl-2.0.html
 * Project: Hellduino
 * Function:
 * Version: 0.1
 */
#include <avr/io.h>
#include <string.h>
#include <avr/pgmspace.h>

#include "tftp.h"
#include "ihex.h"
#include "debug.h"
#include "validate.h"
#include "ext_flash.h"
#include "tftp_main.h"
#include "net.h"

asm(	".section .ext_flash_api,\"ax\",@progbits\n"
		".global _flashapitab\n"
		"_flashapitab:\n"
		"rjmp ext_flash_read_system_data\n"
		"rjmp ext_flash_write_system_data\n"
		"rjmp ext_flash_erase_sector\n"
		"rjmp ext_flash_write_page\n"
		"rjmp ext_flash_read_data\n"
		"rjmp ext_flash_init\n"
		".section .text\n");

#define EF_SS_LOW()  { PORTB &= ~_BV(EXT_FLASH_SS_PIN); }
#define EF_SS_HIGH() { PORTB |= _BV(EXT_FLASH_SS_PIN);}

extern void watchdogConfig(uint8_t x);
extern void Update_from_ext_flash(uint8_t start_sector);

void ext_flash_init(void)
{
	DDRB |= _BV(EXT_FLASH_SS_PIN) | _BV(SCK_PIN) | _BV(MOSI_PIN); //set pins as output
	DDRB &= ~_BV(MISO_PIN);
	PORTB|= _BV(EXT_FLASH_SS_PIN) | _BV(SCK_PIN) | _BV(MISO_PIN) | _BV(MOSI_PIN); //set pins UP

	SPSR = (1<<SPI2X); //Set SPI Clock to max
	SPCR = _BV(SPE) | _BV(MSTR);
}

uint8_t ext_flash_RW_byte(uint8_t data)
{
	SPDR = data;
	while(!(SPSR & _BV(SPIF)));
	return SPDR;
}

uint8_t _ext_flash_wait_busy(void)
{
	uint8_t status, busy = 1, retry = 200;//1S

	EF_SS_HIGH();
	while(retry--) {
		_delay_ms(5);
		EF_SS_LOW();
		ext_flash_RW_byte(0x05);
		status = ext_flash_RW_byte(0x00);
		EF_SS_HIGH();
		if(!(status & 0x01)) {
			busy = 0;
			break;
		}
	}

	return busy;
}

void _ext_flash_write_enable(void)
{
	EF_SS_LOW();
	ext_flash_RW_byte(0x06);
	EF_SS_HIGH();

	EF_SS_LOW();
}

void _ext_flash_cmd_head(uint8_t* cmd_head)
{
	uint8_t len = 4;
	while(len--) {
		ext_flash_RW_byte(*cmd_head++);
	}
}

void ext_flash_read_data(uint32_t addr, uint8_t *rd_buff, uint16_t len)
{
	uint8_t cmd_head[4];

	cmd_head[0]= 0x03;
	cmd_head[1]= (uint8_t)(addr >> 16);
	cmd_head[2]= (uint8_t)(addr >> 8);
	cmd_head[3]= (uint8_t) addr;

	EF_SS_LOW();

	_ext_flash_cmd_head(cmd_head);

	while(len--) {
		*rd_buff++ = ext_flash_RW_byte(0x00);
	}

	EF_SS_HIGH();
}

void ext_flash_write_page(uint32_t offset, uint8_t *page)
{
	uint8_t bytes[4], count=0;

	bytes[0] = 0x02;
	bytes[1] = (offset >> 16) & 0xff;
	bytes[2] = (offset >> 8)  & 0xff;
	bytes[3] =	0x00;

	_ext_flash_write_enable();
	_ext_flash_cmd_head(bytes);
	do {
		ext_flash_RW_byte(*page++);
	} while(++count);
	_ext_flash_wait_busy();
}

void _ext_flash_do_cmd(uint8_t *cmd)
{
	_ext_flash_write_enable();
	_ext_flash_cmd_head(cmd);
	_ext_flash_wait_busy();
}

void ext_flash_erase_sector(uint32_t offset)
{
	uint8_t bytes[4];

	bytes[0] = 0x20;
	bytes[1] = (offset >> 16) & 0xff;
	bytes[2] = (offset >> 8)  & 0xff;
	bytes[3] =	0x00;

	_ext_flash_do_cmd(bytes);
}

void ext_flash_write_system_data(uint8_t index, uint8_t *sys_data, uint16_t len)
{
	uint8_t bytes[4];

	if((index > 2) || (len > 256)) {
		return;
	}

	bytes[0] = 0x44;
	bytes[1] = 0x00;
	bytes[2] = (index+1) << 4;
	bytes[3] =	0x00;
	_ext_flash_do_cmd(bytes);

	bytes[0] = 0x42;
	_ext_flash_write_enable();

	_ext_flash_cmd_head(bytes);
	while(len--) {
		ext_flash_RW_byte(*sys_data++);
	}
	_ext_flash_wait_busy();
}

void ext_flash_read_system_data(uint8_t index, uint8_t *rd_buff, uint16_t len)
{
	uint8_t cmd_head[4];

	if((index > 2) || (len > 256)) {
		return;
	}

	cmd_head[0] = 0x48;
	cmd_head[1] = 0x00;
	cmd_head[2] = (index+1) << 4;
	cmd_head[3] = 0x00;

	EF_SS_LOW();

	_ext_flash_cmd_head(cmd_head);
	ext_flash_RW_byte(0x00);//dummy byte

	while(len--) {
		*rd_buff++ = ext_flash_RW_byte(0x00);
	}

	EF_SS_HIGH();

}


#ifdef DEBUG
void dbg_str(char *msg) {
	if(!GPIOR0) trace2(msg);
}
void dbg_num(uint16_t num) {
	if(!GPIOR0) tracenum2(num);
}
#else
#define dbg_str(msg)
#define dbg_num(num)
#endif

void ext_flash_main(uint8_t start_section)
{
	uint32_t start_addr = (uint32_t)start_section * (uint32_t)4096;
	uint8_t buffer[512], package_max = 157;//(28*1024/16 + 2)*45/512
	int8_t status;

#ifdef DEBUG
	if(!GPIOR0) {
		debugInit();
	}
#endif
	ext_flash_init();

	dbg_str("\r\nStart load app from section: 0x");
	dbg_num(start_section);
	start_addr = start_addr;

	do {
		dbg_str("\r\nAddr=0x");
		dbg_num(start_addr>>16);
		dbg_num(start_addr&0xFFFF);
		if(!(package_max--)) {//file size check
			status = -3;
			break;
		}
		ext_flash_read_data(start_addr, buffer, 512);
		status = ihex_package_process(buffer, 512);
		start_addr += 512;
	}while(status == 0);

	if(status < 0) {
		uint8_t count;
		for(count=0; count<0x34; count++) {
			buffer[count] = pgm_read_byte_near((uint16_t)count);
		}
		if (!validImage(buffer)) {//if app image ok then boot app
			//invalid image, try load default app from section
			dbg_str("\r\nInvalid IMG");
			if(start_section != 0) {
				Update_from_ext_flash(0);
			} else {
				while(1) {
					dbg_str("\r\nEndless loop, Err: 0x");
					dbg_num((uint8_t)status);
					PORTB |= _BV(STATUS_PIN);
					_delay_ms(250);
					PORTB &= ~_BV(STATUS_PIN);
					_delay_ms(250);
				}
			}
		}
	}

	dbg_str("\r\nStart APP");
	watchdogConfig(_BV(WDE));//reboot to app
	while(1);
}

