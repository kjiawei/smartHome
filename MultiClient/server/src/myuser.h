#ifndef __MY_USER_H
#define __MY_USER_H

#include "mychat.h"

#define  MYNODE_ARRAY_SEARCH_USER  0
#define  MYNODE_DICT_SEARCH_USER  1


#define  MY_NAME_LENGTH  256

extern void myuser_init();

extern void   insertUserInfo(char * userid , char * name);
extern int    insertNodeToUserInfo(char * username , char * nodename);
extern int    getUserNodeSize(char * username );
extern void   chatUserInfo(redisClient *c);
extern void   getAllNodeInfo(redisClient *c );
extern char *   getUseridByName(redisClient *c);
extern char *   getNameByUserid(char * userid);
extern void   chatUpdateUserInfo(char * username,char * state);
extern void   chatUpdateNodeInfo(char * username,char * nodename,char * state);


extern void   chatSetOrGetNodeInfo(char * username,char * nodename,char * state, int operation);
extern void   chatSetOrGetUserInfo(char * username,char * state,int operation);


#define  MY_NAME_LENGTH  256

typedef struct _MyNodeInfo {
    char   name[MY_NAME_LENGTH]; 
    char   line[10]; 
} MyNodeInfo;

typedef struct _MyNodeUserInfo {
    char   name[MY_NAME_LENGTH]; 
    char   userid[MY_NAME_LENGTH]; 
    char   line[MY_NAME_LENGTH]; 
    MyNodeInfo nodes[MYNODE_MAX_NODES];
    unsigned int index;
    struct  _MyNodeUserInfo * next;
} MyNodeUserInfo;

typedef struct _MyAllNodeUserInfo {
    struct _MyNodeUserInfo  * userInfo; 
    unsigned int index;
} MyAllNodeUserInfo;

#endif
