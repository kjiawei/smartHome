<?php
//  auther :  yongming.li
$con = mysql_connect("localhost","root","123456");
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("mynode", $con);
echo "drop and create \r\n" ;
mysql_query("DROP TABLE weixinuser",$con);

/*
if (mysql_query("DROP TABLE weixinuser",$con))
{
  echo "DROP TABLE weixinuser succssful \r\n";
}
else
{
  echo "Error DROP table: \r\n " . mysql_error();
}
*/

mysql_query("CREATE  TABLE weixinuser (id INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT primary key, name VARCHAR(50) ,email VARCHAR(50),openid VARCHAR(50))",$con);
echo "Error CREATE table: \r\n " . mysql_error();
echo "close mysql connect \r\n" ;
mysql_close($con);

?>


