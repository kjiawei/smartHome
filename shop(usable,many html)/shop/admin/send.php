<?php
$carrier="����ʡ���տƼ����޹�˾";
$userid=trim($_POST[regtel]);
$password=trim($_POST[regpwd]);
$mobilenumber=trim($_POST[tel]);
$content=trim($_POST[mess]);
$msgtype="Text";
include("conn.php");
include('nusoap/lib/nusoap.php');
$s=new soapclient('http://smsinter.sina.com.cn/ws/smswebservice0101.wsdl','WSDL');
$p=$s->getProxy();
$p->call('sendXml',array('parameters' =>array('carrier' => $carrier,'userid'=> $userid,'password' => $password,'mobilenumber' => $mobilenumber,'content' => $content,'msgtype' => $msgtype)));
echo "<script>alert('���ŷ��ͳɹ�!');history.back();</script>";
?>