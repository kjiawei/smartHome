#include <SPI.h>
#include <Ethernet.h>

/*** Bootload API define ***/
//void Update_from_ext_flash(uint8_t start_sector);  //sector size: 4KB
#define Update_from_ext_flash       (*((void(*)(uint8_t))(0x7ffc/2)))
//void Update_from_TFTP(void);
#define Update_from_TFTP            (*((void(*)(void))(0x7ffa/2)))

#define EXT_FLASH_PAGE_SIZE			256
#define EXT_FLASH_PAGE_NUM			4096
#define EXT_FLASH_SECTOR_SIZE		4096
#define EXT_FLASH_SECTOR_NUM		256

//void ext_flash_init(void);
#define ext_flash_init              (*((void(*)(void))(0x7ff8/2)))
//void ext_flash_read_data(uint32_t addr, uint8_t *rd_buff, uint16_t len);
#define ext_flash_read_data         (*((void(*)(uint32_t, uint8_t *, uint16_t))(0x7ff6/2)))
//void ext_flash_write_page(uint32_t offset, uint8_t *page)
#define ext_flash_write_page        (*((void(*)(uint32_t, uint8_t *))(0x7ff4/2)))
//void ext_flash_erase_sector(uint32_t offset);
#define ext_flash_erase_sector      (*((void(*)(uint32_t))(0x7ff2/2)))
//void ext_flash_write_system_data(uint8_t index, uint8_t *sys_data, uint16_t len)	//index:0~2
#define ext_flash_write_system_data (*((void(*)(uint8_t, uint8_t *, uint16_t))(0x7ff0/2)))
//void ext_flash_read_system_data(uint8_t index, uint8_t *rd_buff, uint16_t len)	//index:0~2
#define ext_flash_read_system_data  (*((void(*)(uint8_t, uint8_t *, uint16_t))(0x7fee/2)))

#define EXT_FLASH_ADDR_OFFSET		((uint32_t)64*1024)
#define EXT_FLASH_TEST_SECTOR_NUM	(EXT_FLASH_SECTOR_NUM - 16)
#define EXT_FLASH_TEST_PAGE_NUM		(EXT_FLASH_PAGE_NUM - 256)

void print_hex(uint8_t *buffer, uint16_t len) {
	for(uint16_t i=0; i<len; i++) {
		if(i%64 == 0) {
			Serial.println("");
		}
		Serial.print(buffer[i], HEX);
	}
	Serial.println("");
}

bool check_page(uint32_t offset, uint8_t *page_data)
{
	uint8_t buffer[EXT_FLASH_PAGE_SIZE];
	ext_flash_read_data(offset, buffer, EXT_FLASH_PAGE_SIZE);
	for(uint16_t i=0; i<EXT_FLASH_PAGE_SIZE; i++) {
		if(buffer[i] != page_data[i]) {
			Serial.print(F("error offset=0x"));
			Serial.println(i, HEX);
			return false;
		}
	}
	if(0) { //print raw data, very slow
		Serial.print(F("Offset=0x"));
		Serial.println(offset, HEX);
		print_hex(buffer, EXT_FLASH_PAGE_SIZE);
	}
	return true;
}

void ext_flash_test(void)
{
	uint8_t format_data[EXT_FLASH_PAGE_SIZE];
	for(uint16_t i=0; i<EXT_FLASH_PAGE_SIZE; i++) {
		format_data[i] = 0xFF;
	}
	
	//erase all sector
	Serial.println(F("Erase all sector"));
	uint32_t offset = EXT_FLASH_ADDR_OFFSET;
	for(uint16_t i=0; i<EXT_FLASH_TEST_SECTOR_NUM; i++) {
		if(i%16==0) {
			Serial.print(F("Write sector:"));
			Serial.print(i);
			Serial.print("-");
			Serial.println(i+16);
		}
		ext_flash_erase_sector(offset);
		offset += EXT_FLASH_SECTOR_SIZE;
	}

	Serial.println(F("Check..."));
	offset = EXT_FLASH_ADDR_OFFSET;
	for(uint16_t i=0; i<EXT_FLASH_TEST_PAGE_NUM; i++) {
		if(i%32==0) {
			Serial.print(F("Check page:"));
			Serial.print(i);
			Serial.print("-");
			Serial.println(i+32);
		}
		if(!check_page(offset, format_data)) {
			Serial.println(F("2 page checkout error"));
			return;
		}
		offset += EXT_FLASH_PAGE_SIZE;
	}
	Serial.println(F("Check...DONE"));
	
	for(uint16_t i=0; i<EXT_FLASH_PAGE_SIZE; i++) {
		format_data[i] = i;
	}
	Serial.println(F("Write..."));
	offset = EXT_FLASH_ADDR_OFFSET;
	for(uint16_t i=0; i<EXT_FLASH_TEST_PAGE_NUM; i++) {
		if(i%32==0) {
			Serial.print(F("Write page:"));
			Serial.print(i);
			Serial.print("-");
			Serial.println(i+32);
		}
		ext_flash_write_page(offset, format_data);
		offset += EXT_FLASH_PAGE_SIZE;
	}
	Serial.println(F("Write...DONE"));

	Serial.println(F("Check write data..."));
	offset = EXT_FLASH_ADDR_OFFSET;
	for(uint16_t i=0; i<EXT_FLASH_TEST_PAGE_NUM; i++) {
		if(i%32==0) {
			Serial.print(F("Check page:"));
			Serial.print(i);
			Serial.print("-");
			Serial.println(i+32);
		}
		if(!check_page(offset, format_data)) {
			Serial.println(F("1 page checkout error"));
			return;
		}
		offset += EXT_FLASH_PAGE_SIZE;
	}
	Serial.println(F("Check write data...DONE"));
	
	Serial.println(F("Erase all sector again"));
	offset = EXT_FLASH_ADDR_OFFSET;
	for(uint16_t i=0; i<EXT_FLASH_TEST_SECTOR_NUM; i++) {
		if(i%16==0) {
			Serial.print(F("Write sector:"));
			Serial.print(i);
			Serial.print("-");
			Serial.println(i+16);
		}
		ext_flash_erase_sector(offset);
		offset += EXT_FLASH_SECTOR_SIZE;
	}
}

bool check_sys_data(uint8_t index, uint8_t *page_data)
{
	uint8_t buffer[EXT_FLASH_PAGE_SIZE];

	ext_flash_read_system_data(index, buffer, EXT_FLASH_PAGE_SIZE);
	print_hex(buffer, EXT_FLASH_PAGE_SIZE);
	for(uint16_t i=0; i<EXT_FLASH_PAGE_SIZE; i++) {
		if(buffer[i] != page_data[i]) {
			Serial.print(F("error offset=0x"));
			Serial.println(i, HEX);
			return false;
		}
	}

	return true;
}

void ext_flash_sys_data_test(void)
{
	uint8_t format_data[EXT_FLASH_PAGE_SIZE];
	for(uint16_t i=0; i<EXT_FLASH_PAGE_SIZE; i++) {
		format_data[i] = i;
	}
	
	Serial.println(F("\r\nStart system data test"));
	ext_flash_write_system_data(0, format_data, EXT_FLASH_PAGE_SIZE);	//index:0~2
	ext_flash_write_system_data(1, format_data, EXT_FLASH_PAGE_SIZE);
	ext_flash_write_system_data(2, format_data, EXT_FLASH_PAGE_SIZE);

	check_sys_data(0, format_data);
	check_sys_data(1, format_data);
	check_sys_data(2, format_data);
	
	Serial.println(F("\r\nReset to default data"));
	for(uint16_t i=0; i<EXT_FLASH_PAGE_SIZE; i++) {
		format_data[i] = 0xFF;
	}
	ext_flash_write_system_data(0, format_data, EXT_FLASH_PAGE_SIZE);	//index:0~2
	ext_flash_write_system_data(1, format_data, EXT_FLASH_PAGE_SIZE);
	ext_flash_write_system_data(2, format_data, EXT_FLASH_PAGE_SIZE);

	check_sys_data(0, format_data);
	check_sys_data(1, format_data);
	check_sys_data(2, format_data);
}

void menu(void) {
	Serial.println(F("\r\nSelect:"));
	Serial.println(F(" 1.External SPI Flash R/W test"));
	Serial.println(F(" 2.System data R/W test"));
	Serial.println(F(" 3.Online Update "));
	Serial.println(F(" 4.TFTP Update"));
}

void setup() {
	Serial.begin(115200);
	menu();
}

void loop() {
	if(Serial.available()) {
		int c = Serial.read();
		bool update_menu = true;
		switch(c) {
		case '1':
			ext_flash_init();
			ext_flash_test();
			break;
		case '2':
			ext_flash_init();
			ext_flash_sys_data_test();
			break;
		case '3':
			Serial.println(F("Call bootloader to load online update app API"));
			Serial.println(F("Please Wait ..."));
			delay(500);
			Update_from_ext_flash(0);
			break;
		case '4':
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
		if(update_menu)	menu();
	}
}

