package com.mysmarthome.mynode;

import java.lang.String;

public final class MyConfig {
     public static final int SERVER_PORT = 6379;
     public static final int MODE_USER = 0;
     public static final int MODE_DEVELOP = 1;
     public static final int MODE_DEBUG = 2;
     public static final int MODE = 6379;
     public static final String SERVER_IP = "115.29.235.211";
     public static  String USERID = "";
     //public static final String SERVER_FILE_VERSION = "http://"+SERVER_IP+"/download/android/version";
     //public static final String SERVER_FILE_CHANGELOG = "http://"+SERVER_IP+"/download/android/changelog";
     //public static final String SERVER_FILE_APK = "http://"+SERVER_IP+"/download/android/MyNode.apk";
     
     public static final String SERVER_FILE_VERSION = "http://git.oschina.net/xmeter/My-smart-home/raw/master/android_client/version.txt";
     public static final String SERVER_FILE_CHANGELOG = "http://git.oschina.net/xmeter/My-smart-home/raw/master/android_client/changelog.txt";
     public static final String SERVER_FILE_APK = "http://git.oschina.net/xmeter/My-smart-home/raw/master/android_client/bin/MyNode.apk";
     
     
     public static final String CURRENT_VERSION = "007";
     
     
     
     public static MyClient  myClient = new MyClient();
     public static MyHeartBeat  myHeartBeat = new MyHeartBeat();
     
     
     public  static final int MSG_SUCCESS = 0;
     public  static final int MSG_FAILURE = 1;
     
     public  static final int MSG_LOGIN_SUCCESS = 10;
     public  static final int MSG_LOGIN_FAILURE = 11;
     public  static final int MSG_LOGIN_USERID = 12;
     
     public  static final int MSG_USER_NODE_INFO_UPDATE = 20;
     
     public  static final int MSG_CHAT_UPDATE = 30;
     
     
     public  static final int MSG_ONLINEUPDATE_GET_VERSION = 40;
     public  static final int MSG_ONLINEUPDATE_GET_CHANGELOG = 41;
     public  static final int MSG_ONLINEUPDATE_GET_APK = 42;
     public  static final int MSG_ONLINEUPDATE_GET_APK_PROGRESS = 44;
     public  static final int MSG_ONLINEUPDATE_GET_FAIL = 45;
     

     public  static final int MSG_NET_FAIL = 50;
     public  static final int MSG_NET_NEXT_LOOP = 51;
     public  static final int MSG_NET_RUNCMD_FAIL = 52;
     
     
     public static final int  PROTOCOL_CODE_DO_NOTHING= 999;
     public static final int  PROTOCOL_CODE_LOGIN= 0;
     public static final int  PROTOCOL_CODE_ALLUSER= 1;
     public static final int  PROTOCOL_CODE_CHAT = 2;
     public static int   PROTOCOL_CODE = PROTOCOL_CODE_LOGIN;
}
