<?php
//  auther :  yongming.li
//$userid = md5($email.$name);
$userid = "222";
$userid_array=array();
$con = mysql_connect("localhost","root","123456");
mysql_select_db("mynode", $con);

$sql = sprintf("select * from alluser");
if ($result=mysql_query($sql,$con))
{
  echo " succssful \r\n";
}
else
{
  echo "Error : \r\n " . mysql_error();
}
while($row = mysql_fetch_array($result))
{
  //echo $row['userid'] ;
  //array_push($userid_array,$row['userid']);
  $userid_array[] =$row['userid'];
  //echo "\r\n";
}
$arrary_size = count($userid_array);
for($i=0;$i<$arrary_size;$i++)
{  

   $sql = sprintf("select * from node where userid='%s'",$userid_array[$i]);
   if ($result=mysql_query($sql,$con))
   {
      // echo " succssful \r\n";
   }
   else
   {
      echo "Error : \r\n " . mysql_error();
   }
   if(mysql_num_rows($result)==0)
   {
      continue;
   }
   echo "select userid is : ".$userid_array[$i];
   echo "\r\n";
   while($row = mysql_fetch_array($result))
   {
     echo $row['userid'].' '.$row['nodeid'].' '.$row['command'].' '.$row['value'];
     //$userid_array[] =$row['userid'];
     echo "\r\n";
   }
   echo "\r\n";
}
mysql_close($con);
?>


