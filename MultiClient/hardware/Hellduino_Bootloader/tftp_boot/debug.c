/* Name: debug.c
 * Author: .
 * Copyright: Arduino
 * License: GPL http://www.gnu.org/licenses/gpl-2.0.html
 * Project: eboot
 * Function: Utility routines for bootloader debugging
 * Version: 0.1 tftp / flashing functional
 */

#include "debug.h"

#ifdef DEBUG
void debugInit() {
	UCSR0A = _BV(U2X0); //Double speed mode USART0
	UCSR0B = _BV(RXEN0) | _BV(TXEN0);
	UCSR0C = _BV(UCSZ00) | _BV(UCSZ01);
	UBRR0L = (uint8_t)( (F_CPU + BAUD_RATE * 4L) / (BAUD_RATE * 8L) - 1 );
	DDRD |= 0x02;
}

void _putchar(uint8_t c) {
  UDR0=c;
  while(!(UCSR0A & _BV(UDRE0)));
}

void _trace(const char* msg) {

  uint8_t c;
  while ((c = *msg++)) {
	_putchar(c);
  }
}

void puthex(uint8_t c) {
  c &= 0xf;
  if (c>9) c+=7;
  _putchar(c+'0');
}

void _tracenum(uint16_t num) {
#if DBG_LEVEL != 2
  _putchar('0');
  _putchar('x');
#endif
  //if(num > 255) {
	  puthex(num>>12);
	  puthex(num>>8);
  //}
  puthex(num>>4);
  puthex(num);
}
#endif
