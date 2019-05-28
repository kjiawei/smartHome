<?php
include("conn.php");
while(list($name,$value)=each($_POST))
{
   mysql_query("delete from leaveword where id='".$value."'",$conn);

}
header("location:lookleaveword.php");
?>