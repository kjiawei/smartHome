#include <avr/pgmspace.h>
#include <SPI.h>
#include <HttpClient.h>
#include <Ethernet.h>
#include <EthernetClient.h>

/* Bootloader API define START*/

#define EXT_FLASH_PAGE_SIZE			256
#define EXT_FLASH_PAGE_NUM			4096
#define EXT_FLASH_SECTOR_SIZE		4096
#define EXT_FLASH_SECTOR_NUM		256

#define CFG_ONLINE_UPDATE_APP_URL_IDX			0
#define CFG_TFTP_IP_ADDR_IDX					1

//void Update_from_ext_flash(uint8_t start_sector);  //sector size: 4KB
#define Update_from_ext_flash       (*((void(*)(uint8_t))(0x7ffc/2)))

//void ext_flash_init(void);
#define ext_flash_init              (*((void(*)(void))(0x7ff8/2)))
//void ext_flash_read_data(uint32_t addr, uint8_t *rd_buff, uint16_t len);
#define ext_flash_read_data         (*((void(*)(uint32_t, uint8_t *, uint16_t))(0x7ff6/2)))
//void ext_flash_write_page(uint32_t offset, uint8_t *page)
#define ext_flash_write_page        (*((void(*)(uint32_t, uint8_t *))(0x7ff4/2)))
//void ext_flash_erase_sector(uint32_t offset);
#define ext_flash_erase_sector      (*((void(*)(uint32_t))(0x7ff2/2)))
//void ext_flash_read_system_data(uint8_t index, uint8_t *rd_buff, uint16_t len)	//index:0~2
#define ext_flash_read_system_data  (*((void(*)(uint8_t, uint8_t *, uint16_t))(0x7fee/2)))

/* Bootloader API define END*/

// Name of the server we want to connect to
char kHostname[64];
// Path to download (this is the bit after the hostname in the URL
// that you want to download
char kPath[128];

const char defaultHostname[] PROGMEM = "www.hellprototypes.com";
const char defaultPath[] PROGMEM = "/Hellduino/Hellduino_Application.hex";

byte mac[] = {0x12,0x34,0x45,0x78,0x9A,0xBC};

// Number of milliseconds to wait without receiving any data before we give up
#define kNetworkTimeout (10*1000)
// Number of milliseconds to wait if no data is available before trying again
#define kNetworkDelay  1000

#define APP_ADDRESS_OFFSET		((uint32_t)64*1024)

uint8_t  g_page_buffer[EXT_FLASH_PAGE_SIZE];
uint32_t g_address_offset;

void erase_pgm_space(uint32_t offset, uint32_t size)
{
	uint8_t sector = size/EXT_FLASH_SECTOR_SIZE + 1;
	Serial.print(F("Need "));
	Serial.print(sector);
	Serial.println(F(" Sector"));
	for(uint8_t i=0; i<sector; i++) {
		ext_flash_erase_sector(offset);
		offset += EXT_FLASH_SECTOR_SIZE;
	}
}

void write_page(void)
{
	ext_flash_write_page(g_address_offset, g_page_buffer);
	g_address_offset += EXT_FLASH_PAGE_SIZE;
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

void ext_flash_print(uint32_t offset, uint32_t len) {
	uint8_t buffer[EXT_FLASH_PAGE_SIZE];

	for(uint32_t i=0; i<len; i += EXT_FLASH_PAGE_SIZE) {
		ext_flash_read_data(offset, buffer, EXT_FLASH_PAGE_SIZE);
		offset += EXT_FLASH_PAGE_SIZE;
		print_ascii(buffer, EXT_FLASH_PAGE_SIZE);
	}
	Serial.println("");
}

void get_url(void) {
	char url[EXT_FLASH_PAGE_SIZE];
	
	ext_flash_read_system_data(CFG_ONLINE_UPDATE_APP_URL_IDX, (uint8_t *)url, EXT_FLASH_PAGE_SIZE);
	uint8_t url_len = strnlen(url, 256);
	//Serial.print(F("url len="));
	//Serial.println(url_len);
	if(url_len<(sizeof(kHostname) + sizeof(kPath))) {
		if(strcasecmp(".hex", &url[url_len-4]) == 0) {
			Serial.println(F("Suffix OK"));
			char* p_path = strchr(url, '/');
			if(p_path != NULL) {
				*p_path++ = '\0';
				if((strlen(url)<sizeof(kHostname)) && (strlen(p_path) < sizeof(kPath))) {
					Serial.println(F("URL size check OK, use URL from system data"));
					strcpy(kHostname, url);
					p_path--;
					*p_path = '/';
					strcpy(kPath, p_path);
					return;
				}
			}
		}
	}
	Serial.println(F("Use default URL"));
	strcpy_P(kHostname, defaultHostname);
	strcpy_P(kPath, defaultPath);
}

bool verify_ihex_file(uint32_t file_size) {
	uint8_t buffer[32];

	ext_flash_read_data(APP_ADDRESS_OFFSET+file_size-32, buffer, 31);
	buffer[31] = '\0';
	if(strstr((const char*)buffer, ":00000001FF") == NULL) {
		Serial.println(F("Verify iHex format file fail"));
		Serial.println(F("The last 31B of the file was:"));
		Serial.println((char*)buffer);
		return false;
	}
	Serial.println(F("iHex format file verify SUCC"));
	return true;
}
/*
void print_address_offset(void) {
	char hex[16];
	sprintf(hex, "0x%04x%04x", (uint16_t)(g_address_offset>>16), (uint16_t)g_address_offset);
	Serial.println(hex);
}
*/
void print_mac(uint8_t *mac_raw) {
	char ip_ascii[32];
	sprintf_P(ip_ascii, PSTR("%02x:%02x:%02x:%02x:%02x:%02x"), mac_raw[0],mac_raw[1],mac_raw[2],mac_raw[3],mac_raw[4],mac_raw[5]);
	Serial.println(ip_ascii);
}

void get_MAC() {
	uint8_t tftp_cfg[20];

	ext_flash_read_system_data(CFG_TFTP_IP_ADDR_IDX, tftp_cfg, 20);
	if((tftp_cfg[0] == 0x55) && (tftp_cfg[19] == 0xAA)) {
		memcpy(mac, &tftp_cfg[9], 6);
		Serial.println(F("Use MAC address int system config:"));
	} else {
		Serial.println(F("Use default MAC address"));
	}
	print_mac(mac);
}
void setup()
{
  uint8_t dly = 5;

  Serial.begin(115200); 
  Serial.print(F("\r\nHellduino Online Updater V1.0"));
  for(uint8_t i=0; i<10; i++) {
	Serial.print(".");
	delay(100);
  }
  Serial.println(F("Go"));
  ext_flash_init();
  
  get_MAC();
  Serial.println(F("Ethernet begin"));
  while (Ethernet.begin(mac) != 1) {
    Serial.println(F("Error getting IP address via DHCP, trying again..."));
    delay(3000);
  }
}

void loop()
{
  int err =0;
  uint8_t retry = 5;
  uint32_t pgm_size=0;
  
  get_url();
  Serial.print(F("URL: "));
  Serial.print(kHostname);
  Serial.println(kPath);
  do {
	  EthernetClient c;
	  HttpClient http(c);
	  g_address_offset = APP_ADDRESS_OFFSET;
	  
	  Serial.print(F("Http get hostname"));
	  err = http.get(kHostname, kPath);
	  Serial.println(F("...Done"));
	  if (err == 0) {
		Serial.print(F("Wait response"));
		err = http.responseStatusCode();
		Serial.println(F("...Done"));
		if (err == 200) {
		  err = http.skipResponseHeaders();
		  Serial.print(F("skipResponseHeaders: "));
		  Serial.println(err);
		  if (err >= 0) {
			uint32_t bodyLen = http.contentLength();
			Serial.print(F("Content length is: "));
			Serial.println(bodyLen);

			pgm_size = bodyLen;

			erase_pgm_space(g_address_offset, pgm_size);
			memset(g_page_buffer, 0xFF, EXT_FLASH_PAGE_SIZE);
			uint16_t rec_index = 0;
			bool timeout = false;
			uint32_t progress_count=0;
			uint8_t feed = 0;
			// Now we've got to the body, so we can print it out
			unsigned long timeoutStart = millis();
			char c;
			Serial.println();
			Serial.println(F("Start download file data:"));
			// Whilst we haven't timed out & haven't reached the end of the body
			while (http.connected() || http.available() ) {
				if((millis() - timeoutStart) > kNetworkTimeout) {
					Serial.println(F("Wait timeout, break"));
					timeout = true;
					break;
				}
				if (http.available()) {
					c = http.read();
					// Print out this character
					//Serial.print(c);
					g_page_buffer[rec_index++] = (uint8_t)c;
					if(rec_index >= EXT_FLASH_PAGE_SIZE) {
						//Serial.print(F("Write page, offset="));
						//print_address_offset();
						Serial.print(progress_count*100/pgm_size);
						Serial.print("% ");
						if(++feed == 8) {
							Serial.println("");
							feed = 0;
						}
						progress_count += EXT_FLASH_PAGE_SIZE;
						write_page();
						rec_index = 0;
						memset(g_page_buffer, 0xFF, EXT_FLASH_PAGE_SIZE);
					}
				   
					bodyLen--;
					// We read something, reset the timeout counter
					timeoutStart = millis();
				} else {
					// We haven't got any data, so let's pause to allow some to
					// arrive
					delay(kNetworkDelay);
				}
			}
			if(!timeout) {
				//write last small page
				if(rec_index > 0) {
					Serial.println(F("\r\nWrite last page"));
					write_page();
				}
				Serial.println(F("\r\n100%"));
				http.stop();
				break;
			}
		  } else {
			Serial.print(F("Failed to skip response headers: "));
			Serial.println(err);
		  }
		} else {    
		  Serial.print(F("Getting response failed: "));
		  Serial.println(err);
		}
	  }
	  else
	  {
		Serial.print(F("Connect failed: "));
		Serial.println(err);
	  }
	  http.stop();
	  Serial.println(F("\r\nwait 3S to retry ..."));
	  delay(3000);
	}while(retry--);

	if(retry > 0) {
		Serial.println(F("\r\nProcess DONE\r\nReadback all data"));
		ext_flash_print(APP_ADDRESS_OFFSET, pgm_size);
		if(verify_ihex_file(pgm_size)) {
			Serial.println(F("\r\nCall bootloader to load the new app"));
			delay(500);
			Update_from_ext_flash(APP_ADDRESS_OFFSET/EXT_FLASH_SECTOR_SIZE);
		} else {
			Serial.println(F("File verify fail, please try again..."));
		}
	}

  // And just stop, now that we've tried a download
  Serial.println(F("\r\nProcess DONE"));

  DDRB |= 0x02;
  while(1) {
	delay(100);
	PINB = 0x02;//Flash LED
  }
}


