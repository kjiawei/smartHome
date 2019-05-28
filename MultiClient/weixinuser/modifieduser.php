<?php
$myid=$_GET["myid"];
$myname=$_GET["myname"];

echo "myid is ".$myid."and name is ".$myname;

$con = mysql_connect('localhost', 'root', '123456');
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }

mysql_select_db("chaoyang", $con);

//$sql="SELECT * FROM user WHERE id = '".$q."'";
//$sql="SELECT * FROM Role WHERE RoleID = '".$q."'";

$sql="UPDATE Role SET RoleName = '".$myname."'" ." WHERE RoleID = '".$myid."'" ;

echo $sql;

$result = mysql_query($sql);


mysql_close($con);
?>
