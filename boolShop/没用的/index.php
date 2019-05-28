<?php
define('ACC',true);
require("include/init.php");

require(ROOT .'tool/UpTool.class.php');

$uptool = new UpTool();
if($uptool->up('pic')){
	echo 'OK';
}else{
	echo 'false<br>';
	echo $uptool->getErr();
}