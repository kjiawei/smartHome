<?php
include("conn.php");
$title=$_POST[title];
$content=$_POST[content];
$spid=$_GET[id];
$time=date("Y-m-j");
session_start();
$sql=mysql_query("select * from user where name='".$_SESSION[username]."'",$conn);
$info=mysql_fetch_array($sql);
$userid=$info[id];
mysql_query("insert into pingjia (userid,spid,title,content,time) values ('$userid','$spid','$title','$content','$time') ",$conn);
echo "<script>alert('���۷���ɹ�!');history.back();</script>";
?>