#ifndef __MY_CHAT_H
#define __MY_CHAT_H

extern void chatCommand(redisClient *c);
extern void addHashFieldToReply(redisClient *c, robj *o, robj *field) ;
extern void insertUserInfo(char * userid , char * name);

#define  MYNODE_TYPE_USER   0
#define  MYNODE_TYPE_NODE   1

#define  MYCHAT_MAX_MESSAGE 70

#define  MYNODE_MAX_USERS   100
#define  MYNODE_MAX_NODES   6

#define  OPERATION_GET_INFO  0
#define  OPERATION_SET_INFO  1


#endif
