<?php

include("conn.php");
mysql_query("delete from ip",$conn);
echo "<script>alert('�ÿͼ�¼����ɹ�!');history.back();</script>";
?>