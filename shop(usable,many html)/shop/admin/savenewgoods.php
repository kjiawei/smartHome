<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
include("conn.php");
if(is_numeric($_POST[shichangjia])==false || is_numeric($_POST[huiyuanjia])==false)
 {
   echo "<script>alert('�۸�ֻ��Ϊ���֣�');history.back();</script>";
   exit;
 }
if(is_numeric($_POST[shuliang])==false)
 {
   echo "<script>alert('����ֻ��Ϊ���֣�');history.back();</script>";
   exit;
 }
$mingcheng=$_POST[mingcheng];
$nian=$_POST[nian];
$yue=$_POST[yue];
$ri=$_POST[ri];
$shichangjia=$_POST[shichangjia];
$huiyuanjia=$_POST[huiyuanjia];
$typeid=$_POST[typeid];
$dengji=$_POST[dengji];
$xinghao=$_POST[xinghao];
$pinpai=$_POST[pinpai];
$tuijian=$_POST[tuijian];
$shuliang=$_POST[shuliang];
$upfile=$_POST[upfile];

if(ceil(($huiyuanjia/$shichangjia)*100)<=80)
 {
 
    $tejia=1;
 }
 else
 {
    $tejia=0;
 }


function getname($exname){
   $dir = "upimages/";
   $i=1;
   if(!is_dir($dir)){
      mkdir($dir,0777);
   }
   
   while(true){
       if(!is_file($dir.$i.".".$exname)){
	       $name=$i.".".$exname;
	       break;
	   }
	   $i++;
	 }

   return $dir.$name;
}

$exname=strtolower(substr($_FILES['upfile']['name'],(strrpos($_FILES['upfile']['name'],'.')+1)));
$uploadfile = getname($exname);

move_uploaded_file($_FILES['upfile']['tmp_name'], $uploadfile);
if(trim($_FILES['upfile']['name']!=""))
 { 
  $uploadfile="admin/".$uploadfile;
}
else
 {
  $uploadfile="";
 }

$jianjie=$_POST[jianjie];
$addtime=$nian."-".$yue."-".$ri;
mysql_query("insert into shangpin(mingcheng,jianjie,addtime,dengji,xinghao,tupian,typeid,shichangjia,huiyuanjia,pinpai,tuijian,shuliang,cishu,tejia)values('$mingcheng','$jianjie','$addtime','$dengji','$xinghao','$uploadfile','$typeid','$shichangjia','$huiyuanjia','$pinpai','$tuijian','$shuliang','0','$tejia')",$conn);
echo "<script>alert('��Ʒ".$mingcheng."��ӳɹ�!');window.location.href='addgoods.php';</script>";
?>