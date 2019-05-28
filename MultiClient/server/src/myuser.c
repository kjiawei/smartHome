// this file added by yongming.li for user data
#include "redis.h"
#include <string.h>
#include <stdio.h>
#include <unistd.h>
#include <stdlib.h>
#include "credis.h"
#include "myuser.h"
#include "mydump.h"
#include "mychat.h"

#if   MYNODE_ARRAY_SEARCH_USER

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

MyAllNodeUserInfo myAllNodeUserInfo={NULL,0};

void myuser_init()
{
    // do nothing now
    return;
}

struct _MyNodeUserInfo * newMyNodeUserInfo()
{
      MyNodeUserInfo * nodeuseinfo= zmalloc(sizeof(MyNodeUserInfo));
      nodeuseinfo->next=NULL;
      nodeuseinfo->index=0;
      memset(nodeuseinfo->name,0X00,MY_NAME_LENGTH);
      memset(nodeuseinfo->userid,0X00,MY_NAME_LENGTH);
      memset(nodeuseinfo->line,0X00,MY_NAME_LENGTH);
      return nodeuseinfo;
}

void   insertUserInfo(char * userid , char * name)
{
    MyNodeUserInfo * nodeuseinfo = newMyNodeUserInfo();
    printf("nodeuseinfo is %p   \r\n",nodeuseinfo);
    MyNodeUserInfo * tempnodeuseinfo = myAllNodeUserInfo.userInfo;
    strcpy(nodeuseinfo->name,name);
    strcpy(nodeuseinfo->userid,userid);
    strcpy(nodeuseinfo->line,"off");
    // init something
    nodeuseinfo->index=0;
    myAllNodeUserInfo.index=myAllNodeUserInfo.index+1;

    myAllNodeUserInfo.userInfo=nodeuseinfo;
    nodeuseinfo->next = tempnodeuseinfo;
    return;
}

//   1 : means a new node
//   0 : means has exits
int    insertNodeToUserInfo(char * username , char * nodename)
{

    MyNodeUserInfo * nodeuseinfo = NULL;
    for(nodeuseinfo=myAllNodeUserInfo.userInfo;nodeuseinfo!=NULL;nodeuseinfo=nodeuseinfo->next)
    {
         if(!strcmp(username,nodeuseinfo->name))
         {
               int nodeIndex =nodeuseinfo->index;
               for(int j=0;j<nodeIndex;j++)
              {
                      if(!strcmp(nodename,nodeuseinfo->nodes[j].name))
                     {
                           return 0;
                     }
              }
              if(nodeuseinfo->index>=MYNODE_MAX_NODES)
             {
                   return -1;
             }
             strcpy(nodeuseinfo->nodes[nodeIndex].name,nodename);
             strcpy(nodeuseinfo->nodes[nodeIndex].line,"off");
             nodeuseinfo->index=nodeIndex+1;
             printf("insertNodeToUserInfo  %s  %s  index is %d\r\n",username,nodename,nodeuseinfo->index);
             return 1;
         }
    }
    return 0;
}

int    getUserNodeSize(char * username )
{

    MyNodeUserInfo * nodeuseinfo = NULL;
    for(nodeuseinfo=myAllNodeUserInfo.userInfo;nodeuseinfo!=NULL;nodeuseinfo=nodeuseinfo->next)
    {
         if(!strcmp(username,nodeuseinfo->name))
         {
               return  nodeuseinfo->index;
         }
    }
    return 0;
}


void   chatUserInfo(redisClient *c)
{

   char buf[256]={0x00};

    MyNodeUserInfo * nodeuseinfo = NULL;
    for(nodeuseinfo=myAllNodeUserInfo.userInfo;nodeuseinfo!=NULL;nodeuseinfo=nodeuseinfo->next)
    {
         sprintf(buf,"userinfo ok %s %s\r\n",nodeuseinfo->name,nodeuseinfo->line);
         addReplyString(c,buf,strlen(buf));
    }
    return;
}

void   getAllNodeInfo(redisClient *c )
{
    char buf[256]={0x00};

    MyNodeUserInfo * nodeuseinfo = NULL;
    for(nodeuseinfo=myAllNodeUserInfo.userInfo;nodeuseinfo!=NULL;nodeuseinfo=nodeuseinfo->next)
    {
         if(!strcmp(c->username,nodeuseinfo->name))
         {
               int nodeIndex =nodeuseinfo->index;
               for(int j=0;j<nodeIndex;j++)
              {
                     sprintf(buf,"nodeinfo ok %s %s\r\n",nodeuseinfo->nodes[j].name,nodeuseinfo->nodes[j].line);
                     addReplyString(c,buf,strlen(buf));
              }
             break;
         }
    }
    return;
}

char *   getUseridByName(redisClient *c)
{

    MyNodeUserInfo * nodeuseinfo = NULL;
    for(nodeuseinfo=myAllNodeUserInfo.userInfo;nodeuseinfo!=NULL;nodeuseinfo=nodeuseinfo->next)
    {
			        if(!strcmp(c->username,nodeuseinfo->name))
			        {
			             return nodeuseinfo->userid;
			        }
		 }
	  return "no_such_userid";
		//return NULL;
}

char *   getNameByUserid(char * userid)
{
    MyNodeUserInfo * nodeuseinfo = NULL;
    for(nodeuseinfo=myAllNodeUserInfo.userInfo;nodeuseinfo!=NULL;nodeuseinfo=nodeuseinfo->next)
    {
     if(!strcmp(userid,nodeuseinfo->userid))
			        {
			             return nodeuseinfo->name;
			        }
		 }
	  return NULL;
		//return NULL;
}

void   chatUpdateUserInfo(char * username,char * state)
{
    MyNodeUserInfo * nodeuseinfo = NULL;
    for(nodeuseinfo=myAllNodeUserInfo.userInfo;nodeuseinfo!=NULL;nodeuseinfo=nodeuseinfo->next)
    {
         if(!strcmp(username,nodeuseinfo->name))
         {
             strcpy(nodeuseinfo->line,state);
             break;
         }
    }
    return;
}

void   chatUpdateNodeInfo(char * username,char * nodename,char * state,)
{
    MyNodeUserInfo * nodeuseinfo = NULL;
    for(nodeuseinfo=myAllNodeUserInfo.userInfo;nodeuseinfo!=NULL;nodeuseinfo=nodeuseinfo->next)
    {
         if(!strcmp(username,nodeuseinfo->name))
         {
               int nodeIndex =nodeuseinfo->index;
               for(int j=0;j<nodeIndex;j++)
              {
                      if(!strcmp(nodename,nodeuseinfo->nodes[j].name))
                     {
                           sprintf(nodeuseinfo->nodes[j].line,"%s",state);
                           return ;
                     }
              }
             break;
         }
    }
    return
}

#endif


