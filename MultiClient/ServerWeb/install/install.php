<?php
/*
 * 安装文件
 * 建立MySQL数据库
*/
//抑制所有错误信息
@error_reporting(E_ALL &~ E_NOTICE);
@set_time_limit(0);
date_default_timezone_set('PRC');
if (!isset($_SERVER['PHP_SELF']) || empty($_SERVER['PHP_SELF'])) $_SERVER['PHP_SELF']=$_SERVER['SCRIPT_NAME'];
header('Content-type:text/html; charset=utf-8'); //强制语言
//判断是否为CLI模式
if (strtolower(php_sapi_name())!=='cli') exit('请在cli模式下安装');
//开始连接MySQL
require('../data/db.inc.php');
@list($dbhost,$dbport)=explode(':',SQLHOST);
!$dbport && $dbport=3306;
$link=mysqli_init();
mysqli_real_connect($link,$dbhost,SQLUSER,SQLPWD,FALSE,$dbport);
mysqli_errno($link)!=0 && exit('错误警告： 链接到MySQL发生错误');
//处理错误，成功连接则选择数据库
if (!$link) exit('连接数据库失败，可能数据库密码不对或数据库服务器出错！');
mysqli_query($link,"SET character_set_connection=utf8,character_set_results=utf8,character_set_client=binary");
mysqli_query($link,"SET sql_mode=''");
if (mysqli_query($link,'CREATE DATEBASE '.SQLNAME)) echo '建立数据库 ',SQLNAME,' 成功'."\n";
else echo '建立数据库 ',SQLNAME,' 失败，可能数据库已经存在'."\n";
if (SQLNAME && !@mysqli_select_db($link,SQLNAME)) exit('无法使用数据库');
//开始安装
require('sql.php');
foreach ($sql as $key=>$val) {
	mysqli_query($link,'DROP TABLE IF EXISTS '.DBPREFIX.$key; //如果表存在则先drop掉
	if (mysqli_query($link,str_replace('#@__',DBPREFIX,$val))) echo '建立数据表 ',$val,' 成功'."\n"; //建表
	else echo '建立数据表 ',$val,' 失败'."\n";
}
//插入初始数据
echo '初始化数据，请稍后'."\n";
foreach ($sqldata as $val) {
	mysqli_query($link,str_replace('#@__',DBPREFIX,$val));
}
echo '初始化数据完成'."\n";
echo '安装成功."\n"';
?>