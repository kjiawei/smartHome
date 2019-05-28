#include <avr/io.h>
#include <util/delay.h>
//Offset of LED PIN in port (PORTB pin 1 for Arduino Eth)
#define STATUS_PIN 	PINB1

void tftp_main(void);

void updateLed(void);
uint8_t timedOut(void);
void ResetTick(void);
