// this file added by yongming.li for new user register

#include "redis.h"
#include <math.h>
#include <string.h>
#include <stdio.h>
#include <unistd.h>
#include <stdlib.h>
#include <errno.h>  
#include <unistd.h>  
#include <sys/types.h>  
#include <sys/ipc.h>  
#include <sys/stat.h>  
#include <sys/msg.h> 

#include "mydump.h"
#include "credis.h"
#include "mychat.h"
#include "myuser.h"
#include "mydebug.h"

// ref 
static char *errRegisterInvalidEmail = "register fail  invalidEmail\r\n";
static char *errRegisterEmailIsExist = "register fail  emailIsExist\r\n";
static char *errRegisterUsernameIsExist = "register fail  usernameIsExist\r\n";
static char *errRegisterInvalidUserid = "register fail  invalidUserid\r\n";
static char *okRegister = "register ok\r\n";

extern   int  mymd5(  char * buf , char *  str );

//  register  getuserid  email   n  n  n (n means no care , reserver)
//  register  adduser   name password  userid  email

void   registerCommand(redisClient *c) 
{
  char buf[256]={0x00};
  char cmd[256]={0x00};
  char myrandom[256]={0x00};
  unsigned char md5buf[256]={0x00};
  char * email=NULL;
  char * username;
  char *	password ;
  char *	userid;
  
      if(!strcmp(c->argv[1]->ptr,"getuserid") )
     {
        email=c->argv[2]->ptr;
        char *   p = strchr(email,'@');
        if (!p) 
        {
        	    addReplyString(c,errRegisterInvalidEmail,strlen(errRegisterInvalidEmail));
        	    return;
        }
        sprintf(cmd,"select  *  from alluser where email='%s';",email);
        if(mysql_is_exist(cmd))
        	{
        	    addReplyString(c,errRegisterEmailIsExist,strlen(errRegisterEmailIsExist));
        	    return;
        	}

         extern int32_t redisLrand48() ;
         sprintf(myrandom,"%d",redisLrand48());
         sprintf(buf,"%s%s",email,myrandom);
         redisLog(REDIS_VERBOSE,"md5 buf  is %s \r\n",buf);
         mymd5( md5buf , buf );
         
         sprintf(buf,"register ok   %s  %s\r\n",md5buf,myrandom);
                 	addReplyString(c,buf,strlen(buf));


         sprintf(cmd,"select  *  from emailmd5 where email='%s';",email);
         if(mysql_is_exist(cmd))
        	{
        	    sprintf(cmd,"update  emailmd5 set saltmd5='%s' where email='%s'",md5buf,email);  
        	    mysqlRunCommand(cmd);
        	}
         else
         {  
             sprintf(cmd,"insert into emailmd5 values('%s','%s')",email,md5buf);  
             mysqlRunCommand(cmd);
         }
         
     }
      
     if(!strcmp(c->argv[1]->ptr,"adduser"))
     {
         username=c->argv[2]->ptr;
         password=c->argv[3]->ptr;
         userid=c->argv[4]->ptr;
         email=c->argv[5]->ptr;


         sprintf(cmd,"select  *  from emailmd5 where saltmd5='%s';",userid);
         if(!mysql_is_exist(cmd))
        	{
        	    addReplyString(c,errRegisterInvalidUserid,strlen(errRegisterInvalidUserid));
        	    return;
        	}

        sprintf(cmd,"select  *  from alluser where name='%s';",username);
        if(mysql_is_exist(cmd))
        	{
        	    addReplyString(c,errRegisterUsernameIsExist,strlen(errRegisterUsernameIsExist));
        	    return;
        	}
         //mysql_query(sprintf("insert into alluser values('%s', '%s','%s','%s')",md5($email),$name,$name,$email),$con);
         sprintf(cmd,"insert into alluser values('%s', '%s',  '%s','%s');",userid,username,password,email);
         mysqlRunCommand(cmd);
         addReplyString(c,okRegister,strlen(okRegister));

         // also added it to memory , avoid to reset the sever
         insertUserInfo(userid , username);
         
         
     	    return;
     }
}




