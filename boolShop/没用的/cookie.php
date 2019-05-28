<?php

header('content-type:text/html;charset=utf-8');

/*
cookie做浏览历史

用cookie来记录本网站已经访问列多少页面

$_SERVER['REQUEST_URI'];  记录url地址
*/

$uri = $_SERVER['REQUEST_URI'];
/*将uri放在cookie里
setcookie('his',array($uri));  这是错误
cookie只能存放字符串、数字，不能存档数组、资源

因此数组要转换成字符串
*/
if(!isset($_COOKIE['histroy'])){
	$his[] = $uri;
	
}else{
	$his = explode('|',$_COOKIE['histroy']);

	array_unshift($his, $uri);  //最新浏览的在上方
	$his=array_unique($his);  //将数组移除重复

	if(count($his)>5){  //个数不超过5个
		array_pop($his);
	}

}
setcookie('histroy',implode('|', $his));


$id = isset($_GET['id'])?$_GET['id']:0;

?>

<p>
	<a href="cookie.php?id=<?php echo $id-1; ?>">上一页</a><br>
</p>
<p>
	<a href="cookie.php?id=<?php echo $id+1; ?>">下一页</a><br>
</p>

<ul>
	<li>浏览历史</li>
	<?php foreach ($his as $v) { ?>
	<li><?php echo $v; ?></li>
	<?php } ?>
</ul>

