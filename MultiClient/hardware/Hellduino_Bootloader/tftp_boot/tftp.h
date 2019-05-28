// TFTP Opcode values from RFC 1350
//
#define TFTP_OPCODE_RRQ   1
#define TFTP_OPCODE_WRQ   2
#define TFTP_OPCODE_DATA  3
#define TFTP_OPCODE_ACK   4
#define TFTP_OPCODE_ERROR 5

// TFTP Error codes from RFC 1350
//
#define TFTP_ERROR_UNDEF        0
#define TFTP_ERROR_NOT_FOUND    1
#define TFTP_ERROR_ACCESS       2
#define TFTP_ERROR_FULL         3
#define TFTP_ERROR_ILLEGAL_OP   4
#define TFTP_ERROR_UNKNOWN_XFER 4
#define TFTP_ERROR_EXISTS       6
#define TFTP_ERROR_NO_SUCH_USER 7


#define TFTP_PORT 69

// TFTP OP codes
#define ERROR_UNKNOWN     0
#define ERROR_INVALID     1
#define ACK               2
#define ERROR_FULL        3
#define FINAL_ACK         4   // Like an ACK, but for the final data packet.?????
#define INVALID_IMAGE     5

#define TFTP_DATA_SIZE    512

#define MAX_ADDR          0x7000 // For 328 with 2Kword bootloader

#define TFTP_HEADER_SIZE  12
#define TFTP_OPCODE_SIZE  2
#define TFTP_BLOCKNO_SIZE 2
#define TFTP_MAX_PAYLOAD  512
#define TFTP_PACKET_MAX_SIZE (  TFTP_HEADER_SIZE + TFTP_OPCODE_SIZE + TFTP_BLOCKNO_SIZE + TFTP_MAX_PAYLOAD )


void tftpInit(void);
uint8_t tftpPoll(void);
