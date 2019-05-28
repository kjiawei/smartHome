<?php

/*
regAct.php

接收用户注册的表单信息，完成注册
*/

//print_r($_POST);  //测试数据的传递

define('ACC',true);
require('./include/init.php');
header('content-type:text/html;charset=utf-8');

$user = new UserModel();


/*
调用自动检验

*/
if(!$user->_validate($_POST)){
	$msg = implode('<br />', $user->getErr());
	include(ROOT . 'view/front/msg.html');
	exit;
}

/*
检验用户名是否已存在
*/
if($user->checkuser($_POST['username'])){
	$msg = "用户名已存在！";
	include(ROOT . 'view/front/msg.html');
	exit;
}




//调用自动填充
$data = $user->_autoFill($_POST);

$data = $user->_facade($data);  //自动过滤


if($user->reg($data)){
	$msg= '用户注册成功';
}else{
	$msg= '注册失败，请重新注册';
}

//引入view
include(ROOT . 'view/front/msg.html');



