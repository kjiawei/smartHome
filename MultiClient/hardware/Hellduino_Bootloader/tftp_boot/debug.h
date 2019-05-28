#include <avr/pgmspace.h>
#include <avr/io.h>

//#define DEBUG
#define DBG_LEVEL		2 //0,1,2

#ifdef DEBUG
void debugInit(void);
void _trace(const char* );
void _tracenum(uint16_t);

#if DBG_LEVEL == 2
#define trace2( msg) _trace(msg)
#define tracenum2(num) _tracenum(num)
#else
#define trace2( msg)
#define tracenum2(num)
#endif

#if DBG_LEVEL == 1
#define TRACE1( msg) _trace(msg)
#define trace1( msg) _trace(msg)
#define tracenum1(num) _tracenum(num)
#else
#define TRACE1( msg)
#define trace1( msg)
#define tracenum1(num)
#endif

#if DBG_LEVEL == 0
#define TRACE(msg) _trace(msg)
#define trace( msg) _trace(msg)
#define tracenum(num) _tracenum(num)
#else
#define TRACE(msg)
#define trace( msg)
#define tracenum(num)
#endif

#else
#define trace2( msg)
#define tracenum2(num)
#define trace1( msg)
#define tracenum1(num)
#define TRACE1(msg)
#define TRACE(msg)
#define trace( msg)
#define tracenum(num)

#define  debugInit( )
#endif

