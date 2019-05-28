<?php
/*
退出
只要销毁session即可
*/

define('ACC',true);
require('./include/init.php');

session_destroy();

$msg = '退出成功';

include(ROOT . 'view/front/msg.html');