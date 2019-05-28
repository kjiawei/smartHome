<?php
/*
 * 最新数据库设计，包括SQL和NoSQL部分
*/
$sql=array();
/*
 * 节点表：node
 * id bigint(10) 自动生成的节点ID
 * type smallint(6) 所属节点组
*/
$sql['node']='CREATE TABLE `#@__node` (
	`id` bigint(10) AUTO_INCREMENT,
	`type` smallint(6) NOT NULL,
	PRIMARY KEY(`id`),
	INDEX(`type`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
/*
 * NoSQL节点：node_id
 * name string 名称
 * command ??
 * value ??
*/
/*
 * 用户表：user
 * id bigint(10) 用户ID
 * type smallint(6) 对应的用户组
 * name varchar(20) 用户名
 * email varchar(255) 邮箱
 * isAdmin int(1) 是否为管理员，1为是
*/
$sql['user']='CREATE TABLE `#@__user` (
	`id` bigint(10) AUTO_INCREMENT,
	`type` smallint(6) NOT NULL,
	`name` varchar(50) NOT NULL,
	`password` char(32) NOT NULL,
	`email` varchar(255) NOT NULL,
	`isAdmin` int(1) NOT NULL DEFAULT \'0\',
	PRIMARY KEY(`id`),
	INDEX(`type`),
	INDEX(`name`),
	INDEX(`isAdmin`),
	INDEX(`email`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
/*
 * Auth表：auth
 * auth char(32) 不解释
 * uid bigint(10) 用户ID
 * overdue date 过期时间
*/
$sql['auth']='CREATE TABLE `#@__auth` (
	`auth` char(32) NOT NULL,
	`uid` bigint(10) NOT NULL,
	`overdue` date NOT NULL,
	PRIMARY KEY(`auth`),
    INDEX(`uid`),
	INDEX(`overdue`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;';
/*
 * 用户组表：usergroup
 * id smallint(6) 用户组ID
 * name varchar(255) 名称
 * view longtext 允许查看的节点组，例如|1|3|8|
 * control longtext 允许控制的节点组，例如|1|3|8|
*/
$sql['usergroup']='CREATE TABLE `#@__usergroup` (
	`id` smallint(6) AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`view` varchar(255) DEFAULT NULL,
	`control` varchar(255) DEFAULT NULL,
	PRIMARY KEY(`id`),
	INDEX(`view`),
	INDEX(`control`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
/*
 * 节点组表：nodegroup
 * id smallint(6) 节点组ID
 * name varchar(255) 名称
*/
$sql['nodegroup']='CREATE TABLE `#@__nodegroup` (
	`id` smallint(6) AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY(`id`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
/*
 * NoSQL节点组：nodegroup_id
 * string 特定格式的所有节点
 * 例如1,2,5,3
*/
$sqldata=array();
//基本数据：初始用户组
$sqldata[]="INSERT INTO `#@__usergroup` (`id`,`name`,`view`,`control`) VALUES ('1','Administrator','|*|','|*|')";
?>