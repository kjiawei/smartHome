<?php
/*
 * SQL数据表结构和初始数据
 * 包含测试数据
*/
$sql=array();
$sql['emailmd5']='CREATE TABLE `#@__emailmd5` (
  email  varchar(50) NOT NULL,
  saltmd5 char(32)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;'; //AUTO_INCREMENT=1
$sql['node']='CREATE TABLE `#@__node` (
  userid varchar(50),
  nodeid varchar(50),
  command varchar(50),
  value varchar(50)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;';
$sql['alluser']='CREATE TABLE `#@__alluser` (
  userid varchar(50),
  name varchar(50),
  password varchar(50),
  email varchar(50)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;';
$sql['friends']='CREATE TABLE friends (
  name varchar(50),
  friendsname varchar(50)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;';
$sqldata=array();
/*
mysql_query(sprintf("insert into node values('%s', 'tv','0','0')",md5("yongming@gmail.com")),$con);
mysql_query(sprintf("insert into node values('%s', 'light','0','0')",md5("yongming@gmail.com")),$con);
mysql_query(sprintf("insert into node values('%s', 'air','0','0')",md5("yongming@gmail.com")),$con);


mysql_query(sprintf("insert into node values('%s', 'tv','0','0')",md5("shaohui@gmail.com")),$con);
mysql_query(sprintf("insert into node values('%s', 'light','0','0')",md5("shaohui@gmail.com")),$con);
mysql_query(sprintf("insert into node values('%s', 'air','0','0')",md5("shaohui@gmail.com")),$con);

mysql_query(sprintf("insert into node values('%s', 'tv','0','0')",md5("liyi@gmail.com")),$con);
mysql_query(sprintf("insert into node values('%s', 'light','0','0')",md5("liyi@gmail.com")),$con);
mysql_query(sprintf("insert into node values('%s', 'air','0','0')",md5("liyi@gmail.com")),$con);

mysql_query(sprintf("insert into node values('%s', 'tv','0','0')",md5("lihan@gmail.com")),$con);
mysql_query(sprintf("insert into node values('%s', 'light','0','0')",md5("lihan@gmail.com")),$con);
mysql_query(sprintf("insert into node values('%s', 'air','0','0')",md5("lihan@gmail.com")),$con);

mysql_query(sprintf("insert into node values('%s', 'tv','0','0')",md5("xiaoxiong@gmail.com")),$con);
mysql_query(sprintf("insert into node values('%s', 'light','0','0')",md5("xiaoxiong@gmail.com")),$con);
mysql_query(sprintf("insert into node values('%s', 'air','0','0')",md5("xiaoxiong@gmail.com")),$con);

mysql_query(sprintf("insert into alluser values('%s', 'yongming','yongming','yongming@gmail.com')",md5("yongming@gmail.com")),$con);
mysql_query(sprintf("insert into alluser values('%s', 'shaohui','shaohui','shaohui@gmail.com')",md5("shaohui@gmail.com")),$con);
mysql_query(sprintf("insert into alluser values('%s', 'liyi','liyi','liyi@gmail.com')",md5("liyi@gmail.com")),$con);
mysql_query(sprintf("insert into alluser values('%s', 'lihan','lihan','lihan@gmail.com')",md5("lihan@gmail.com")),$con);
mysql_query(sprintf("insert into alluser values('%s', 'xiaoxiong','xiaoxiong','xiaoxiong@gmail.com')",md5("xiaoxiong@gmail.com")),$con);
mysql_query(sprintf("insert into alluser values('%s', 'test','test','test@gmail.com')",md5("test@gmail.com")),$con);

mysql_query(sprintf("insert into emailmd5 values('%s','%s')","yongming@gmail.com",md5("yongming@gmail.com")),$con);
mysql_query(sprintf("insert into emailmd5 values('%s','%s')","shaohui@gmail.com",md5("shaohui@gmail.com")),$con);
mysql_query(sprintf("insert into emailmd5 values('%s','%s')","liyi@gmail.com",md5("liyi@gmail.com")),$con);
mysql_query(sprintf("insert into emailmd5 values('%s','%s')","lihan@gmail.com",md5("lihan@gmail.com")),$con);
*/
?>