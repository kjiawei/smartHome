<?php
           $conn=mysql_connect("localhost","root","850714") or die("���ݿ���������Ӵ���".mysql_error());
           mysql_select_db("shop",$conn) or die("���ݿ���ʴ���".mysql_error());
           mysql_query("set character set gb2312");
           mysql_query("set names gb2312");
?>
