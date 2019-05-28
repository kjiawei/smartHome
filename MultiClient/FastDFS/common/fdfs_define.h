/**
* Copyright (C) 2008 Happy Fish / YuQing
*
* FastDFS may be copied only under the terms of the GNU General
* Public License V3, which may be found in the FastDFS source kit.
* Please visit the FastDFS Home Page http://www.csource.org/ for more detail.
**/

//fdfs_define.h

#ifndef _FDFS_DEFINE_H_
#define _FDFS_DEFINE_H_

#include <pthread.h>
#include "common_define.h"

#define FDFS_TRACKER_SERVER_DEF_PORT		22000
#define FDFS_STORAGE_SERVER_DEF_PORT		23000
#define FDFS_DEF_STORAGE_RESERVED_MB		1024
#define TRACKER_ERROR_LOG_FILENAME      "trackerd"
#define STORAGE_ERROR_LOG_FILENAME      "storaged"

#define FDFS_RECORD_SEPERATOR	'\x01'
#define FDFS_FIELD_SEPERATOR	'\x02'

#ifdef __cplusplus
extern "C" {
#endif


#ifdef __cplusplus
}
#endif

#endif

