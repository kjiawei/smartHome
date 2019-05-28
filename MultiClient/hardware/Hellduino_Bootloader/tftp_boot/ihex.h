#ifndef _IHEX_H_
#define  _IHEX_H_

#define HEX_FILE_END		1
#define HEX_ERR_NONE		0
#define HEX_ERR_FORMAT		(-1)
#define HEX_ERR_CHECK		(-2)
#define HEX_ERR_LINE		(-3)
#define HEX_ERR_EMPTY		(-4)

#define HEX_LINE_MAX_LEN		80
#define HEX_READ_LINE_ERR		0xFF
void ihex_init(void);
int8_t ihex_package_process(uint8_t* package, uint16_t package_len);
#endif