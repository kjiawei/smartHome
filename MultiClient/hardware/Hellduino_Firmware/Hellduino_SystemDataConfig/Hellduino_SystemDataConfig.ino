#include <SPI.h>
#include <Ethernet.h>

/*** Bootload API define ***/
//void Update_from_ext_flash(uint8_t start_sector);  //sector size: 4KB
#define Update_from_ext_flash       (*((void(*)(uint8_t))(0x7ffc/2)))
//void Update_from_TFTP(void);
#define Update_from_TFTP            (*((void(*)(void))(0x7ffa/2)))

//void ext_flash_init(void);
#define ext_flash_init              (*((void(*)(void))(0x7ff8/2)))

//void ext_flash_write_system_data(uint8_t index, uint8_t *sys_data, uint16_t len)	//index:0~2
#define ext_flash_write_system_data (*((void(*)(uint8_t, uint8_t *, uint16_t))(0x7ff0/2)))
//void ext_flash_read_system_data(uint8_t index, uint8_t *rd_buff, uint16_t len)	//index:0~2
#define ext_flash_read_system_data  (*((void(*)(uint8_t, uint8_t *, uint16_t))(0x7fee/2)))

#define EXT_FLASH_PAGE_SIZE			((uint16_t)256)

#define CFG_ONLINE_UPDATE_APP_URL_IDX			0
#define CFG_TFTP_IP_ADDR_IDX					1

void print_hex(uint8_t *buffer, uint16_t len) {
	char str[16];
	for(uint16_t i=0; i<len; i++) {
		if(i%45 == 0) {
			Serial.println("");
		}
		sprintf(str, "%02x", buffer[i]);
		Serial.print(str);
	}
	Serial.println("");
}

void print_ascii(uint8_t *buffer, uint16_t len) {
	for(uint16_t i=0; i<len; i++) {
		uint8_t c= buffer[i];
		if(c & 0x80)
			;//Serial.print(c, HEX);
		else
			Serial.print((char)c);
	}
}

void read_online_update_app_url(void) {
	char url[EXT_FLASH_PAGE_SIZE];
	ext_flash_read_system_data(CFG_ONLINE_UPDATE_APP_URL_IDX, (uint8_t *)url, EXT_FLASH_PAGE_SIZE);
	uint8_t url_len = strnlen(url, 256);
	if((url_len<256)&& (url_len > 4)) {
		if(strcasecmp(".hex", &url[url_len-4]) == 0) {
			Serial.print(F("URL: "));
			Serial.println(url);
			return;
		}
	}
	Serial.println(F("URL not configed"));
}

void print_ip(uint8_t *ip_raw) {
	char ip_ascii[24];
	sprintf_P(ip_ascii, PSTR("%d.%d.%d.%d"), ip_raw[0],ip_raw[1],ip_raw[2],ip_raw[3]);
	Serial.println(ip_ascii);
}

void print_mac(uint8_t *ip_raw) {
	char ip_ascii[32];
	sprintf_P(ip_ascii, PSTR("%02x:%02x:%02x:%02x:%02x:%02x"), ip_raw[0],ip_raw[1],ip_raw[2],ip_raw[3],ip_raw[4],ip_raw[5]);
	Serial.println(ip_ascii);
}

void print_tftp_cfg(uint8_t* tftp_cfg) {
	Serial.print(F("#     IP: "));
	print_ip(&tftp_cfg[15]);
	Serial.print(F("#   Mask: "));
	print_ip(&tftp_cfg[5]);
	Serial.print(F("#Gateway: "));
	print_ip(&tftp_cfg[1]);
	Serial.print(F("#    MAC: "));
	print_mac(&tftp_cfg[9]);
}

//TFTP config format(20B): 0x55, Gateway(4B), Subnet Mask(4B), MAC(6B), IP(4B), 0xAA
void read_tftp_update_ip_config(void) {
	uint8_t tftp_cfg[20];

	ext_flash_read_system_data(CFG_TFTP_IP_ADDR_IDX, tftp_cfg, 20);
	if((tftp_cfg[0] == 0x55) && (tftp_cfg[19] == 0xAA)) {
		print_tftp_cfg(tftp_cfg);
		return;
	}
	Serial.println(F("TFTP IP not configed"));
}

void main_menu(void) {
	Serial.println(F("\r\nSelect:"));
	Serial.println(F("0.Erase ALL System data config"));
	Serial.println(F("1.Read URL and TFTP config"));
	Serial.println(F("2.Config online update URL"));
	Serial.println(F("3.Config TFTP update IP&MAC"));
	Serial.println(F("4.Online Update "));
	Serial.println(F("5.TFTP Update\r\n"));
}

uint8_t read_line(char *line_buff, uint16_t buff_len) {
	uint16_t index = 0;
	int c;
	do{
		c = Serial.read();
		if((c=='\r')||(c=='\n')) {
			break;
		} if(c == '\b') {
			if(index>0) {
				index--;
			}
		} else if(c < 0) {
			continue;
		} else {
			if((c>' ') && (c<'~')) {
				line_buff[index++] = (char)c;
			}
		}
		Serial.print((char)c);
	} while(index<(buff_len-1));
	line_buff[index] = '\0';
	while(Serial.read()>0);

	return index;
}

void online_update_url_config() {
	char url[256];
	delay(500);
	while(Serial.read()>0);
	Serial.println(F("\r\nGive me new URL data(ENTER:Abort)"));
	Serial.print(F("    Example: www.hellprototypes.com/Hellduino/Hellduino_SystemDataConfig.hex\r\n>"));
	if(read_line(url, 256)>0) {
		Serial.println(F("\r\nNew URL is:"));
		Serial.println(url);
		Serial.println(F("Confirm? [y/n])"));
		int c;
		do {
			c = Serial.read();
			if((c == 'y')|| (c == 'Y')) {
				ext_flash_write_system_data(CFG_ONLINE_UPDATE_APP_URL_IDX, (uint8_t *)url, strlen(url)+1);
				Serial.println(F("Read back to verify:"));
				read_online_update_app_url();
				break;
			}
		} while(c<0);
		Serial.println(F("DONE..."));
		return;
	}
	Serial.println(F("\r\nAbort"));
}

void tftp_ip_config() {
	char ip[20];
	char mask[20];
	char gateway[20];
	char mac[20];
	delay(500);
	while(Serial.read()>0);
	Serial.print(F("\r\nGive me the IP(ENTER:Abort)"));
	Serial.print(F("    Example: 192.168.0.110\r\n>"));
	if(read_line(ip, 20)== 0) {
		return;
	}
	Serial.print(F("\r\nGive me the Subnet Mask(ENTER:Abort)"));
	Serial.print(F("    Example: 255.255.255.0\r\n>"));
	if(read_line(mask, 20)== 0) {
		return;
	}
	Serial.print(F("\r\nGive me Gateway IP(ENTER:Abort)"));
	Serial.print(F("    Example: 192.168.0.1\r\n>"));
	if(read_line(gateway, 20)== 0) {
		return;
	}
	Serial.print(F("\r\nGive me the MAC Address(ENTER:Abort)"));
	Serial.print(F("    Example: 11:22:33:AA:BB:CC\r\n>"));
	if(read_line(mac, 20)== 0) {
		return;
	}
	Serial.println("");

	//TFTP config format(20B): 0x55, Gateway(4B), Subnet Mask(4B), MAC(6B), IP(4B), 0xAA
	uint8_t tftp_cfg[20];
	bool status = true;
	do {
		tftp_cfg[0] = 0x55;

		if(sscanf_P(gateway, PSTR("%d.%d.%d.%d"), &tftp_cfg[1],&tftp_cfg[2],&tftp_cfg[3],&tftp_cfg[4]) != 4) {
			Serial.println(F("IP format error"));
			status = false;
			break;
		}

		if(sscanf_P(mask, PSTR("%d.%d.%d.%d"), &tftp_cfg[5],&tftp_cfg[6],&tftp_cfg[7],&tftp_cfg[8]) != 4) {
			Serial.println(F("Gateway format error"));
			status = false;
			break;
		}

		if(sscanf_P(mac, PSTR("%02x:%02x:%02x:%02x:%02x:%02x"), 
							 &tftp_cfg[9],&tftp_cfg[10],&tftp_cfg[11],&tftp_cfg[12],&tftp_cfg[13],&tftp_cfg[14]) != 6) {
			Serial.println(F("MAC format error"));
			status = false;
			break;
		}

		if(sscanf_P(ip, PSTR("%d.%d.%d.%d"), &tftp_cfg[15],&tftp_cfg[16],&tftp_cfg[17],&tftp_cfg[18]) != 4) {
			Serial.println(F("IP format error"));
			status = false;
			break;
		}

		tftp_cfg[19] = 0xAA;
	}while(0);

	if(status) {
		Serial.println(F("==================\r\nNew TFTP Config:"));
		print_tftp_cfg(tftp_cfg);

		Serial.println(F("Confirm? [y/n])"));
		int c;
		do {
			c = Serial.read();
			if((c == 'y')|| (c == 'Y')) {
				ext_flash_write_system_data(CFG_TFTP_IP_ADDR_IDX, (uint8_t *)tftp_cfg, 20);
				Serial.println(F("\r\nRead back to verify:"));
				read_tftp_update_ip_config();
				break;
			}
		} while(c<0);		
	}

	Serial.println(F("DONE..."));
}

void erase_all_system_data(void) {
	uint8_t all_0xFF[EXT_FLASH_PAGE_SIZE];
	memset(all_0xFF, 0xFF, EXT_FLASH_PAGE_SIZE);
	Serial.print(F("Start ERASE all system data..."));
	ext_flash_write_system_data(0, all_0xFF, EXT_FLASH_PAGE_SIZE);
	ext_flash_write_system_data(1, all_0xFF, EXT_FLASH_PAGE_SIZE);
	ext_flash_write_system_data(2, all_0xFF, EXT_FLASH_PAGE_SIZE);
	Serial.println(F("DONE"));
}

void setup() {
	Serial.begin(115200);
	delay(100);
	ext_flash_init();
	main_menu();
}

void loop() {
	if(Serial.available()) {
		int c = Serial.read();
		delay(100);
		bool update_menu = true;
		switch(c) {
		case '0':
			erase_all_system_data();
			break;
		case '1':
			Serial.println(F("URL config:"));
			read_online_update_app_url();
			Serial.println(F("TFTP config:"));
			read_tftp_update_ip_config();
			break;
		case '2':
			online_update_url_config();
			break;
		case '3':
			tftp_ip_config();
			break;
		case '4':
			Serial.println(F("Call bootloader to load online updater APP"));
			Serial.println(F("Please Wait ..."));
			delay(500);
			Update_from_ext_flash(0);
			break;
		case '5':
			Serial.println(F("Call bootloader TFTP update API"));
			Serial.println(F("You have about 10 second to start TFTP update"));
			delay(500);
			Update_from_TFTP();
			break;
		default:
			if(c == 'r') {
				update_menu = true;
			} else {
				if(c != '\n') {
					//Serial.print("Unuse key pressed : 0x");
					//Serial.println(c, HEX);
				}
				update_menu = false;
			}
			break;
		}
		if(update_menu)	main_menu();
	}
}

