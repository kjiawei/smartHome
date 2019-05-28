/**
* Copyright (C) 2008 Happy Fish / YuQing
*
* FastDFS may be copied only under the terms of the GNU General
* Public License V3, which may be found in the FastDFS source kit.
* Please visit the FastDFS Home Page http://www.csource.org/ for more detail.
**/

//client_global.h

#ifndef _CLIENT_GLOBAL_H
#define _CLIENT_GLOBAL_H

#include "tracker_types.h"

#ifdef __cplusplus
extern "C" {
#endif

extern int g_tracker_server_count;
extern int g_tracker_server_index;  //server index for roundrobin
extern TrackerServerInfo *g_tracker_servers;

#ifdef __cplusplus
}
#endif

#endif
