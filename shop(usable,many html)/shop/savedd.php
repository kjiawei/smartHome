<?php
include("conn.php");
session_start();
$sql=mysql_query("select * from user where name='".$_SESSION[username]."'",$conn);
$info=mysql_fetch_array($sql);
$dingdanhao=date("YmjHis").$info[id];
$spc=$_SESSION[producelist];
$slc= $_SESSION[quatity];
$shouhuoren=$_POST[name];
$sex=$_POST[sex];
$dizhi=$_POST[dz];
$youbian=$_POST[yb];
$tel=$_POST[tel];
$email=$_POST[email];
$shff=$_POST[shff];
$zfff=$_POST[zfff];
if(trim($_POST[ly])=="")
 {
   $leaveword="";
 }
 else
 {
   $leaveword=$_POST[ly];
 }
 $xiadanren=$_SESSION[username];
 $time=date("Y-m-j H:i:s");
 $zt="δ���κδ���";
 $total=$_SESSION[total];
 mysql_query("insert into dingdan(dingdanhao,spc,slc,shouhuoren,sex,dizhi,youbian,tel,email,shff,zfff,leaveword,time,xiadanren,zt,total) values ('$dingdanhao','$spc','$slc','$shouhuoren','$sex','$dizhi','$youbian','$tel','$email','$shff','$zfff','$leaveword','$time','$xiadanren','$zt','$total')",$conn); 
 header("location:gouwu2.php?dingdanhao=$dingdanhao");
?>
