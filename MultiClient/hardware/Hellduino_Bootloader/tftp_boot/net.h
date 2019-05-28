#include <avr/io.h>


//Offset of pin INSIDE PORTB!! (not absolute)
#define SCK_PIN 5 //PB5
#define MISO_PIN 4 //PB4
#define MOSI_PIN 3 //PB3
#define SS_PIN 2 //PB2

#define REGISTER_BLOCK_SIZE 28

#define EEPROM_END		(1024-1)


#define EEPROM_SIG_1 ((uint8_t*)EEPROM_END)
#define EEPROM_SIG_2 ((uint8_t*)(EEPROM_END-1))
#define EEPROM_IMG_STAT ((uint8_t*)(EEPROM_END-2))
#define EEPROM_DATA ((uint8_t*)(EEPROM_END-3-REGISTER_BLOCK_SIZE))
#define EEPROM_SIG_1_VALUE (0x55)
#define EEPROM_SIG_2_VALUE (0xAA)
#define EEPROM_IMG_OK_VALUE (0xBB)
#define EEPROM_IMG_BAD_VALUE (0xFF)

#define EEPROM_GATEWAY ((uint8_t*)2)
#define EEPROM_MAC ((uint8_t*)6)
#define EEPROM_IP ((uint8_t*)12)

#define TFTP_REG_SIG_1_VALUE (0x55)
#define TFTP_REG_SIG_2_VALUE (0xAA)


void netWriteReg(uint16_t address, uint8_t value);
uint8_t netReadReg(uint16_t address);
uint16_t netReadWord(uint16_t address);
void netWriteWord(uint16_t address, uint16_t value);

void netInit(void);

#define SS_LOW()  { PORTB &= ~_BV(SS_PIN); _delay_us(1);}
#define SS_HIGH() { _delay_us(1); PORTB |= _BV(SS_PIN);}

#define SPI_WRITE (0xF0)
#define SPI_READ (0x0F)
