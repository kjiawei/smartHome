<?php
session_start();
include("conn.php");
$username=$_SESSION[username];
$sql=mysql_query("select * from user where name='".$username."'",$conn);
$info=mysql_fetch_array($sql);
$id=$info[id];
mysql_query("delete from gowuche where userid=".$id."",$conn);
header("location:gouwu1.php");
?>