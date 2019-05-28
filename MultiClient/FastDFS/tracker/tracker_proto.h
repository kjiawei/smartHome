/**
* Copyright (C) 2008 Happy Fish / YuQing
*
* FastDFS may be copied only under the terms of the GNU General
* Public License V3, which may be found in the FastDFS source kit.
* Please visit the FastDFS Home Page http://www.csource.org/ for more detail.
**/

//tracker_proto.h

#ifndef _TRACKER_PROTO_H_
#define _TRACKER_PROTO_H_

#include "tracker_types.h"

#define TRACKER_PROTO_CMD_STORAGE_JOIN          81
#define FDFS_PROTO_CMD_QUIT			82
#define TRACKER_PROTO_CMD_STORAGE_BEAT          83  //heart beat
#define TRACKER_PROTO_CMD_STORAGE_REPORT        84  //report disk usage
#define TRACKER_PROTO_CMD_STORAGE_REPLICA_CHG   85  //repl new storage servers
#define TRACKER_PROTO_CMD_STORAGE_SYNC_SRC_REQ  86  //src storage require sync
#define TRACKER_PROTO_CMD_STORAGE_SYNC_DEST_REQ 87  //dest storage require sync
#define TRACKER_PROTO_CMD_STORAGE_SYNC_NOTIFY   88  //sync done notify
#define TRACKER_PROTO_CMD_STORAGE_SYNC_REPORT	89  //report src last synced time as dest server
#define TRACKER_PROTO_CMD_STORAGE_RESP          80

#define TRACKER_PROTO_CMD_SERVER_LIST_GROUP	91
#define TRACKER_PROTO_CMD_SERVER_LIST_STORAGE	92
#define TRACKER_PROTO_CMD_SERVER_DELETE_STORAGE	93
#define TRACKER_PROTO_CMD_SERVER_RESP      	90
#define TRACKER_PROTO_CMD_SERVICE_QUERY_STORE	101
#define TRACKER_PROTO_CMD_SERVICE_QUERY_FETCH	102
#define TRACKER_PROTO_CMD_SERVICE_QUERY_UPDATE  103
#define TRACKER_PROTO_CMD_SERVICE_RESP		100

#define STORAGE_PROTO_CMD_UPLOAD_FILE		11
#define STORAGE_PROTO_CMD_DELETE_FILE		12
#define STORAGE_PROTO_CMD_SET_METADATA		13
#define STORAGE_PROTO_CMD_DOWNLOAD_FILE		14
#define STORAGE_PROTO_CMD_GET_METADATA		15
#define STORAGE_PROTO_CMD_SYNC_CREATE_FILE	16
#define STORAGE_PROTO_CMD_SYNC_DELETE_FILE	17
#define STORAGE_PROTO_CMD_SYNC_UPDATE_FILE	18
#define STORAGE_PROTO_CMD_SYNC_CREATE_LINK	19
#define STORAGE_PROTO_CMD_CREATE_LINK		20
#define STORAGE_PROTO_CMD_RESP			10

//for overwrite all old metadata
#define STORAGE_SET_METADATA_FLAG_OVERWRITE	'O'
//for replace, insert when the meta item not exist, otherwise update it
#define STORAGE_SET_METADATA_FLAG_MERGE		'M'

#define FDFS_PROTO_PKG_LEN_SIZE		8
#define FDFS_PROTO_CMD_SIZE		1

#define TRACKER_QUERY_STORAGE_FETCH_BODY_LEN	FDFS_GROUP_NAME_MAX_LEN \
			+ IP_ADDRESS_SIZE - 1 + FDFS_PROTO_PKG_LEN_SIZE
#define TRACKER_QUERY_STORAGE_STORE_BODY_LEN	FDFS_GROUP_NAME_MAX_LEN \
			+ IP_ADDRESS_SIZE - 1 + FDFS_PROTO_PKG_LEN_SIZE + 1

typedef struct
{
	char pkg_len[FDFS_PROTO_PKG_LEN_SIZE];
	char cmd;
	char status;
} TrackerHeader;

typedef struct
{
	char group_name[FDFS_GROUP_NAME_MAX_LEN+1];
	char storage_port[FDFS_PROTO_PKG_LEN_SIZE];
	char store_path_count[FDFS_PROTO_PKG_LEN_SIZE];
	char subdir_count_per_path[FDFS_PROTO_PKG_LEN_SIZE];
} TrackerStorageJoinBody;


typedef struct
{
	char group_name[FDFS_GROUP_NAME_MAX_LEN + 1];
	char sz_free_mb[FDFS_PROTO_PKG_LEN_SIZE];  //free disk storage in MB
	char sz_count[FDFS_PROTO_PKG_LEN_SIZE];    //server count
	char sz_storage_port[FDFS_PROTO_PKG_LEN_SIZE];
	char sz_active_count[FDFS_PROTO_PKG_LEN_SIZE]; //active server count
	char sz_current_write_server[FDFS_PROTO_PKG_LEN_SIZE];
	char sz_store_path_count[FDFS_PROTO_PKG_LEN_SIZE];
	char sz_subdir_count_per_path[FDFS_PROTO_PKG_LEN_SIZE];
} TrackerGroupStat;

typedef struct
{
	char status;
	char ip_addr[IP_ADDRESS_SIZE];
	char sz_total_mb[8];
	char sz_free_mb[8];
	FDFSStorageStatBuff stat_buff;
} TrackerStorageStat;

typedef struct
{
	char src_ip_addr[IP_ADDRESS_SIZE];
	char until_timestamp[FDFS_PROTO_PKG_LEN_SIZE];
} TrackerStorageSyncReqBody;

typedef struct
{
	char sz_total_mb[8];
	char sz_free_mb[8];
} TrackerStatReportReqBody;

#ifdef __cplusplus
extern "C" {
#endif

int fdfs_validate_group_name(const char *group_name);
int metadata_cmp_by_name(const void *p1, const void *p2);

const char *get_storage_status_caption(const int status);

int fdfs_recv_header(TrackerServerInfo *pTrackerServer, int64_t *in_bytes);

int fdfs_recv_response(TrackerServerInfo *pTrackerServer, \
		char **buff, const int buff_size, \
		int64_t *in_bytes);
int fdfs_quit(TrackerServerInfo *pTrackerServer);

#define fdfs_split_metadata(meta_buff, meta_count, err_no) \
		fdfs_split_metadata_ex(meta_buff, FDFS_RECORD_SEPERATOR, \
		FDFS_FIELD_SEPERATOR, meta_count, err_no)

char *fdfs_pack_metadata(const FDFSMetaData *meta_list, const int meta_count, \
			char *meta_buff, int *buff_bytes);
FDFSMetaData *fdfs_split_metadata_ex(char *meta_buff, \
		const char recordSeperator, const char filedSeperator, \
		int *meta_count, int *err_no);

#ifdef __cplusplus
}
#endif

#endif

