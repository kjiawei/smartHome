<?php
 include("conn.php");
  while(list($name,$value)=each($_POST))
  {
    mysql_query("delete from gonggao where id='".$value."'",$conn);
  
  }
 header("location:admingonggao.php");  
?>