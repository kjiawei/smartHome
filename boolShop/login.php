<?php

/*
用户登录页面
*/

define('ACC',true);
require('./include/init.php');

if(isset($_POST['act'])){  //说明点击了登录按钮后传过来的
	$u = $_POST['username'];
	$p = $_POST['passwd'];

	//合法性检测

	//核对用户名密码
	$user = new UserModel();
	$row = $user->checkUser($u, $p);
	if(empty($row)){
		$msg = '用户名密码错误';
	}else{
		$msg = '登陆成功';

		session_start();
		$_SESSION = $row;

		if(isset($_POST['remember'])){
			//记住用户名两周
			setcookie('remuser', $u, time()*14*24*3600);
		}else{
			setcookie('remuser', '', 0);
		}
		
	}
	
	include(ROOT . 'view/front/msg.html');

}else{  //准备登陆

	$remuser = isset($_COOKIE['remuser'])?$_COOKIE['remuser']:'';
	include(ROOT . 'view/front/denglu.html');
}

