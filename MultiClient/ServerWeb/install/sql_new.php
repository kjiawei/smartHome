<?php
/*
 * SQL数据表结构和初始数据
 * 这是一个新的设计，并不代表最终结果
 * 包含测试数据
*/
$sql=array();
mysql_query("CREATE TABLE emailmd5 (email VARCHAR(50) UNIQUE,saltmd5 VARCHAR(50))",$con);
$i=mysql_query("CREATE TABLE node (id bigint(10) AUTO_INCREMENT , userid VARCHAR(50) ,nodeid VARCHAR(50),command VARCHAR(50) , value VARCHAR(50), PRIMARY KEY(id) ,INDEX(userid) )",$con);
mysql_query("CREATE TABLE user (id bigint(10) AUTO_INCREMENT , host VARCHAR(10),hostname VARCHAR(50),userid VARCHAR(50) ,name VARCHAR(50) UNIQUE,password VARCHAR(50),email VARCHAR(50), nickname VARCHAR(50) , PRIMARY KEY(id) ,INDEX(name),INDEX(email) )",$con);

$sql['node']='CREATE TABLE `#@__node` (
	`id` bigint(10) AUTO_INCREMENT,
	`uid` bigint(10) NOT NULL,
	`name` varchar(255） NOT NULL,
	`command` varchar(255) DEFAULT \'0\',
	`value` varchar(255) DEFAULT \'0\',
	PRIMARY KEY(`id`),
	INDEX(`uid`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
$sql['user']='CREATE TABLE `#@__user` (
	`id` bigint(10) AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`password` char(32) NOT NULL,
	`email` varchar(255) NOT NULL,
	`type` int(1) NOT NULL,
	`host` int(1) DEFAULT \'0\',
	PRIMARY KEY(`id`),
	INDEX(`name`),
	INDEX(`email`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';

$sqldata=array();
$sqldata[]="INSERT INTO `#@__user`(`id`,`name`,`password`,`email`) VALUES ('1','yongming','".pwdcode('yongming')."','yongming@gmail.com'),('2','shaohui','".pwdcode('shaohui')."','shaohui@gmail.com'),('3','liyi','".pwdcode('liyi')."','liyi@gmail.com'),('4','lihan','".pwdcode('lihan')."','lihan@gmail.com'),('5','xiaoxiong','".pwdcode('xiaoxiong')."','xiaoxiong@gmail.com'),('6','shuangya','".pwdcode('shuangya')."','896640547@qq.com')";
$sqldata[]="INSERT INTO `#@__node` (`uid`,`name`) VALUES ('1','tv'),('1','light'),('1','air'),('2','tv'),('2','light'),('2','air'),('3','tv'),('3','light'),('3','air'),('4','tv'),('4','light'),('4','air'),('5','tv'),('5','light'),('5','air'),('6','tv'),('6','light'),('6','air')";
?>