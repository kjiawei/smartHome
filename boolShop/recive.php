<?php

/*
在线支付的返回接收页面
*/
header('content-type:text/html;charset=utf-8');

$md5key = '#(%#WU)(UFGDKJGNDFG';

//自己计算出的md5info
$md5info = md5($_POST['v_oid'] . $_POST['v_pstatus'] . $_POST['v_amount'] . $_POST['v_moneytype'] . $md5key);
$md5info = strtoupper($md5info);

//拿计算出的md5info和表单发来的md5info对比
if($md5info !== $_POST['v_md5str']){
	echo '交易失败';
	exit;
}

echo '执行sql语句，把订单号'.$_POST['v_oid'];
echo '对应的订单改为已支付';