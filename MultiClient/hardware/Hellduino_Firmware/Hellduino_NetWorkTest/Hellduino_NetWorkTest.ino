#include <avr/pgmspace.h>
#include <SPI.h>
#include <HttpClient.h>
#include <Ethernet.h>
#include <EthernetClient.h>

//void ext_flash_init(void);
#define ext_flash_init              (*((void(*)(void))(0x7ff8/2)))
//void ext_flash_read_system_data(uint8_t index, uint8_t *rd_buff, uint16_t len)	//index:0~2
#define ext_flash_read_system_data  (*((void(*)(uint8_t, uint8_t *, uint16_t))(0x7fee/2)))

uint32_t g_last_millis;

// Name of the server we want to connect to
char kHostname[64];
// Path to download (this is the bit after the hostname in the URL
// that you want to download
char kPath[128];

const char defaultHostname[] PROGMEM = "www.hellprototypes.com";
const char defaultPath[] PROGMEM = "/Hellduino/Hellduino_Application.hex";

const char Hostname_0[] PROGMEM = "www.baidu.com";
const char Path_0[] PROGMEM = "/";

const char Hostname_1[] PROGMEM = "192.168.2.5";
const char Path_1[] PROGMEM = "/";

byte mac[] = {0x12, 0x34, 0x45, 0x78, 0x9A, 0xBC};

// Number of milliseconds to wait without receiving any data before we give up
#define kNetworkTimeout (10*1000)
// Number of milliseconds to wait if no data is available before trying again
#define kNetworkDelay  1000

void get_url(uint8_t index) {
  if (index == 0) {
    strcpy_P(kHostname, Hostname_0);
    strcpy_P(kPath, Path_0);
  } else if (index == 1) {
    strcpy_P(kHostname, Hostname_1);
    strcpy_P(kPath, Path_1);
  } else {
    strcpy_P(kHostname, defaultHostname);
    strcpy_P(kPath, defaultPath);
  }
}

void print_mac(uint8_t *mac_raw) {
  char ip_ascii[32];
  sprintf_P(ip_ascii, PSTR("MAC: %02x:%02x:%02x:%02x:%02x:%02x"), mac_raw[0], mac_raw[1], mac_raw[2], mac_raw[3], mac_raw[4], mac_raw[5]);
  Serial.println(ip_ascii);
}

void get_MAC(void) {
  uint8_t tftp_cfg[20];

  ext_flash_init();
  ext_flash_read_system_data(1, tftp_cfg, 20);
  if ((tftp_cfg[0] == 0x55) && (tftp_cfg[19] == 0xAA)) {
    memcpy(mac, &tftp_cfg[9], 6);
    Serial.println(F("Use MAC address int system config:"));
  } else {
    Serial.println(F("Use default MAC address"));
  }

  print_mac(mac);
}

uint16_t print_elapse_time(void) {
  unsigned long curr_millis;
  uint16_t elapse_time;

  Serial.print(F(">>> Elapse time:"));
  curr_millis = millis();
  elapse_time = curr_millis - g_last_millis;
  Serial.print(elapse_time);
  g_last_millis = curr_millis;
  Serial.println(F("ms"));
  return elapse_time;
}
void setup()
{
  uint8_t dly = 5;

  Serial.begin(115200);
  Serial.print(F("\r\nHellduino Network Test"));
  for (uint8_t i = 0; i < 10; i++) {
    Serial.print(".");
    delay(100);
  }
  Serial.println(F("Go"));

  get_MAC();
  Serial.println(F("Ethernet begin"));
  g_last_millis = millis();
  while (Ethernet.begin(mac) != 1) {
    Serial.println(F("Error getting IP address via DHCP, trying again..."));
    delay(3000);
  }
  print_elapse_time();
}


void loop() {
  int err = 0;

  uint8_t url_idx = 0;
  do {
    get_url(url_idx);
    Serial.print(F("\r\nURL: "));
    Serial.print(kHostname);
    Serial.println(kPath);
    EthernetClient c;
    HttpClient http(c);

    Serial.print(F("Http GET request"));
    err = http.get(kHostname, kPath);
    Serial.println(F("...Done"));
    print_elapse_time();
    if (err == 0) {
      Serial.print(F("Wait response"));
      err = http.responseStatusCode();
      Serial.println(F("...Done"));
      print_elapse_time();
      if (err == 200) {
        err = http.skipResponseHeaders();
        Serial.print(F("skipResponseHeaders: "));
        Serial.println(err);
        print_elapse_time();
        if (err >= 0) {
          uint32_t bodyLen = http.contentLength();
          Serial.print(F("Content length is: "));
          Serial.println((uint16_t)bodyLen);

          // Now we've got to the body, so we can print it out
          unsigned long timeoutStart = millis();
          char c;
          bool self_lock = false;
          uint8_t feed = 0;
		  uint32_t read_len = 0;
          Serial.println(F("Start download file data:"));
          // Whilst we haven't timed out & haven't reached the end of the body
          while (http.connected() || http.available() ) {
            if (!self_lock) {
              self_lock = true;
              print_elapse_time();
              Serial.println(F("Start read http data"));
            }
            if ((millis() - timeoutStart) > kNetworkTimeout) {
              Serial.println(F("Wait timeout, break"));
              break;
            }
            if (http.available()) {
              c = http.read();
			  read_len++;
              // Print out this character
              //Serial.print(c);

              bodyLen--;
              if ((bodyLen % 128) == 0) {
                Serial.print("*");
                if (++feed == 48) {
                  feed = 0;
                  Serial.println("");
                }
              }
              // We read something, reset the timeout counter
              timeoutStart = millis();
            } else {
              // We haven't got any data, so let's pause to allow some to
              // arrive
              delay(kNetworkDelay);
            }
          }
          Serial.println(F("\r\nHttp end"));
          uint16_t elapse_time = print_elapse_time();
		  Serial.print(F("Network speed:"));
		  char str[24];
		  sprintf(str, "%dB/S",((uint16_t)(read_len*1000/elapse_time)));
          Serial.println(str);
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

    delay(3000);
  } while (url_idx++ < 2);


  // And just stop, now that we've tried a download
  Serial.println(F("\r\nProcess DONE"));

  DDRB |= 0x02;
  while (1) {
    delay(100);
    PINB = 0x02;//Flash LED
  }
}


