<?php
//抑制所有错误信息
@error_reporting(E_ALL &~ E_NOTICE);
@set_time_limit(0);
date_default_timezone_set('PRC');
if (!isset($_SERVER['PHP_SELF']) || empty($_SERVER['PHP_SELF'])) $_SERVER['PHP_SELF']=$_SERVER['SCRIPT_NAME'];
header('Content-type:text/html; charset=utf-8'); //强制语言
/*****************************************/
/*		 定义常用常量、引入必要文件		*/
/*****************************************/
define('ROOT',str_replace('\\','/',dirname(__FILE__)).'/');
define('INC',ROOT.'include/');
define('DATA',ROOT.'data/');
define('TPL',DATA.'template/');
define('EXEC',DATA.'exec/');
require(DATA.'db.inc.php');
require(DATA.'config.inc.php');
if (!isset($_COOKIE['smartlang'])) define('LANG',$cfg_lang);
else define('LANG',$_COOKIE['smartlang']);
require(INC.'lang.inc.php');
require(INC.'common.func.php');
require(INC.'pdo_mysql.class.php');
require(INC.'base.php');
/*****************************************/
/*				 初始变量				 */
/*****************************************/
$time=time();
$_ENV=array();
unset($HTTP_GET_VARS,$HTTP_POST_VARS,$HTTP_COOKIE_VARS,$HTTP_SERVER_VARS,$HTTP_ENV_VARS);
$m=getgpc('m');
$a=getgpc('a');
$m=empty($m)?'index':$m;
$a=empty($a)?'body':$a;
if (!isset($_COOKIE['smartid'])) {
	if ($m!='member') {
		redirect(lang('common','go_login'),'index.php?m=member&a=login');
	}
	if ($m=='member' && !in_array($a,array('login','check','loginout','register'),TRUE)) { //转到登录页面
		redirect(lang('common','go_login'),'index.php?m=member&a=login');
	}
}
$smartid=$_COOKIE['smartid'];
if (in_array($m,array('index','member','node'),TRUE)) {
	if(is_file('model/'.$m.'.php')) {
		require('model/'.$m.'.php');
	} else {
		exit('Model not found!');
	}
	$_ENV['_model']=$m::getInstance();
	$method='on'.$a;
	if(method_exists($_ENV['_model'],$method) && $a{0}!='_') {
		$_ENV['_model']->$method();
	} else {
		exit('Action not found!');
	}
} else {
	exit('Model not found!');
}
?>