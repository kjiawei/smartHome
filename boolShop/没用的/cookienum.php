<?php

header('content-type:text/html;charset=utf-8');

/*
cookie计数器

用cookie来记录本网站已经访问列多少页面
*/

//第一次访问，没有cookie信息
if(!isset($_COOKIE['num'])){   //第一次访问，没有cookie
	setcookie('num',1);
}else{  //有cookie信息
	$num = $_COOKIE['num'];
	setcookie('num',$num+1);

}

echo '这是你的第'.$num.'次访问';