// yongming.li 

/*
   try to find least connects message server
*/

#include "beansdb.h"
#include "dserver.h"
#include "hiredis.h"

char serverip [100]={0x00};
void porcess_get_msgserver(conn *c, token_t *tokens, size_t ntokens)
{
     getLazyMsgServer(c);
}

void  getLazyMsgServer(conn * client)
{

    unsigned int j=0;
    redisContext *c;
    redisReply *reply;

    struct timeval timeout = { 1, 500000 }; // 1.5 seconds
    c = redisConnectWithTimeout((char*)"127.0.0.1", 6379, timeout);

     // ZREVRANGE msgservers  0 -1 WITHSCORES
     //reply = redisCommand(c,"ZREVRANGE msgservers 0  -1  WITHSCORES");
     reply = redisCommand(c,"ZREVRANGE msgservers 0  0");
   
      for (j = 0; j < reply->elements; j++) 
    {
            printf("%u) %s\n", j, reply->element[j]->str);
     }

     if (reply->elements==1)
     {
         //strcpy(serverip,reply->element[0]->str);
         out_string(client,reply->element[0]->str);
     }
     else
     {
     	  out_string(client,"NOT_FOUND_MSGSERVER");
     }
     freeReplyObject(reply);

      
}
