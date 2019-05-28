//  yongming.li

#include "beansdb.h"
#include <stdio.h>
#include <ctype.h>
#include <string.h>

extern struct Settings settings;
void readFromIni(void);

void settings_init(void) {
    settings.port = 8000;
    /* By default this string should be NULL for getaddrinfo() */
    settings.inter = NULL;
    settings.item_buf_size = 4 * 1024;     /* default is 4KB */
    settings.maxconns = 1024;         /* to limit connections-related memory to about 5MB */
    settings.verbose = 1;
   //settings.num_threads = 16;
    settings.num_threads = 1;
    settings.flush_limit = 1024; // 1M
    settings.flush_period = 60 * 10; // 10 min
    settings.slow_cmd_time = 0.1; // 100ms
    readFromIni();
}

typedef struct
{
    int version;
    const char* name;
    const char* email;
} configuration;

static int handler(void* user, const char* section, const char* name,
                   const char* value)
{
    configuration* pconfig = (configuration*)user;

    #define MATCH(s, n) strcmp(section, s) == 0 && strcmp(name, n) == 0
    if (MATCH("protocol", "version")) {
        pconfig->version = atoi(value);
    } else if (MATCH("user", "name")) {
        pconfig->name = strdup(value);
    } else if (MATCH("user", "email")) {
        pconfig->email = strdup(value);
    } else {
        return 0;  /* unknown section/name, error */
    }
    return 1;
}

void readFromIni(void)
{
    configuration config;

    if (ini_parse("dserver.ini", handler, &config) < 0) {
        printf("Can't load 'test.ini'\n");
        return 1;
    }
    printf("Config loaded from 'test.ini': version=%d, name=%s, email=%s\n",
        config.version, config.name, config.email);
    return 0;
}
