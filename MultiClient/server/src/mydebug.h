#ifndef __MY_DEBUG_H
#define __MY_DEBUG_H

extern void  myDebugEntry(redisClient *c);
extern void  myAddUser(redisClient *c);

extern dict * myuserdict;


#endif
