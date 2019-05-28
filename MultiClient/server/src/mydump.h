

#ifndef __MY_DUMP_H
#define __MY_DUMP_H
extern int mynode_init();
extern void redisLog(int level, const char *fmt, ...) ;
#define   MY_REDIS_ROOT_NAME    "root"

int    is_valid_node(redisClient * c);

int   is_valid_user(char * name ,char * password);



extern void  mysqlRunCommand(char * cmd);
extern int  mysql_is_exist(char * cmd);

extern int mysql_dump_to_memory();

#endif
