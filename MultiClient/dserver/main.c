#include <stdio.h>
#include <sys/stat.h>
#include <sys/socket.h>
#include <sys/un.h>
#include <signal.h>
#include <sys/resource.h>
#include <sys/uio.h>
#include <pwd.h>
#include <sys/mman.h>
#include <fcntl.h>
#include <netinet/tcp.h>
#include <arpa/inet.h>
#include <errno.h>
#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <time.h>
#include <assert.h>
#include <limits.h>
#include <inttypes.h>
#include <unistd.h>

#include "beansdb.h"
#include "credis.h"
#include "hiredis.h"

void conn_init(void) ;
void thread_init(int nthreads) ;
int server_socket(const int port, const bool is_udp) ;
void sig_handler(const int sig);
void settings_init(void) ;

struct Settings settings;



 /* for safely exit, make sure to do checkpoint*/
void sig_handler(const int sig)
{
    int ret;
    if (sig != SIGTERM && sig != SIGQUIT && sig != SIGINT) {
        return;
    }
    if (daemon_quit == 1){
        return;
    }
    daemon_quit = 1;
    fprintf(stderr, "Signal(%d) received, try to exit daemon gracefully..\n", sig);
}


void  redis_test(void)
{

unsigned int j;
    redisContext *c;
    redisReply *reply;

    struct timeval timeout = { 1, 500000 }; // 1.5 seconds
    c = redisConnectWithTimeout((char*)"127.0.0.1", 6379, timeout);
	
    reply = redisCommand(c,"SET %s %s", "foo", "hello world");
    printf("SET: %s\n", reply->str);
    freeReplyObject(reply);
    
     reply = redisCommand(c,"ZINCRBY %s  1 %s", "msgservers", "192.168.0.1:6000");
     printf("%s\n", reply->str);
     freeReplyObject(reply);
	 
     reply = redisCommand(c,"ZINCRBY %s  1 %s", "msgservers", "192.168.0.1:6001");
     freeReplyObject(reply);
     reply = redisCommand(c,"ZINCRBY %s  1 %s", "msgservers", "192.168.0.1:6002");
     freeReplyObject(reply);
	 
    printf("redis test end \r\n");
   /*
    ZINCRBY key increment member
    ZADD page_rank 10 google.com
    ZADD key score member 
   */

}
int main()
{
    int c;
    struct in_addr addr;
    bool daemonize = false;
    int maxcore = 0;
    char *pid_file = NULL;

    /* init settings */
    settings_init();
    //redis_test();
    //return 0;
    conn_init();
    /* set stderr non-buffering (for running under, say, daemontools) */
    setbuf(stderr, NULL);
    thread_init(settings.num_threads);
	
    /* create the listening socket, bind it, and init */
    if (server_socket(settings.port, false)) {
        fprintf(stderr, "failed to listen\n");
        exit(EXIT_FAILURE);
    }
	    /* register signal callback */
    if (signal(SIGTERM, sig_handler) == SIG_ERR)
        fprintf(stderr, "can not catch SIGTERM\n");
    if (signal(SIGQUIT, sig_handler) == SIG_ERR)
        fprintf(stderr, "can not catch SIGQUIT\n");
    if (signal(SIGINT,  sig_handler) == SIG_ERR)
        fprintf(stderr, "can not catch SIGINT\n");

        /* enter the event loop */
    printf("all ready.\n");
    loop_run(settings.num_threads);

   return 0;
}
