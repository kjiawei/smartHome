/**
* Copyright (C) 2008 Happy Fish / YuQing
*
* FastDFS may be copied only under the terms of the GNU General
* Public License V3, which may be found in the FastDFS source kit.
* Please visit the FastDFS Home Page http://www.csource.org/ for more detail.
**/

#include "tracker_global.h"

int g_server_port = FDFS_TRACKER_SERVER_DEF_PORT;
int g_max_connections = DEFAULT_MAX_CONNECTONS;
int g_sync_log_buff_interval = SYNC_LOG_BUFF_DEF_INTERVAL;

FDFSGroups g_groups;
int g_storage_stat_chg_count = 0;
int g_storage_sync_time_chg_count = 0; //sync timestamp
int g_storage_reserved_mb = 0;

int g_allow_ip_count = 0;
in_addr_t *g_allow_ip_addrs = NULL;

