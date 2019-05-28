/* Name: main.c
 * Author: Denis PEROTTO, from work published by Arduino
 * Copyright: Arduino
 * License: GPL http://www.gnu.org/licenses/gpl-2.0.html
 * Project: eboot
 * Function: Bootloader core
 * Version: 0.2 tftp functional on 328P
 */


#include "tftp_main.h"
#include "net.h"
#include "tftp.h"
#include <avr/pgmspace.h>
#include "debug.h"
#include <util/delay.h>
#include <avr/eeprom.h>
#include "ihex.h"

uint16_t tick;

#define TIMEOUT 28 //(about 12 seconds)
#define VERSION "0.3"

//void (*app_start)(void) = 0x0000;

extern void watchdogConfig(uint8_t x);

void updateLed() {
  if(TIFR1 & 0x01) {
      TIFR1 = 0x01;
	  tick++;
	  PINB = _BV(STATUS_PIN);
  }
}

uint8_t timedOut() {
  //Called from TFTP poll
  if (pgm_read_word(0x0000) == 0xFFFF){
	  // Never timeout if there is no code in Flash or if flash is corrupted
	  return 0;
  }
  if (tick > TIMEOUT){
	  return 1;
  }
  return 0;
}
void ResetTick(){
	tick=0;
}

void tftp_main(void) {
  ResetTick();
  debugInit();
  DDRB |= _BV(STATUS_PIN);
  _delay_ms(250); //be sure that W5100 has started (ATM starts in 65ms, W5100 150-200ms)
  /*
   Prescaler=0, ClkIO Period = 62,5ns

   TCCR1B values:
   0x01 -> ClkIO/1 -> 62,5ns period, 4ms max
   0x02 -> ClkIO/8 -> 500ns period, 32ms max
   0X03 -> ClkIO/64 -> 4us period, 256ms max
   0x04 -> ClkIO/256 -> 16us period, 1024ms max
   0x05 -> ClkIO/1024 -> 64us period, 4096ms max
   */

  TCCR1A = 0x00;
  TCCR1B = 0x03;
  SPSR = (1<<SPI2X); //Set SPI Clock to max
  SPCR = _BV(SPE) | _BV(MSTR);
  trace("\r\nTFTP Bootloader for Arduino Ethernet, Version ");
  trace(VERSION);
  // Initialise W5100 chip
  trace("\r\nNet init...\r\n");
  netInit();
  trace("Net init done\r\n");

  trace("TFTP Init...\r\n");
  //Open TFTP Socket 3 (Default UDP 69)
  tftpInit();
  trace("TFTP Init done\r\n");

  for(;;) {
    if (tftpPoll()==0) break;
    updateLed();
  }
  trace("Start user app\r\n");
  //app_start();

  watchdogConfig(_BV(WDE));//reboot to app
  while(1);
}
