
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�һ�����</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
</head>
<?php
 include("conn.php");
 $nc=$_POST[nc];
 $da=$_POST[da];
 $sql=mysql_query("select * from user where name='".$nc."'",$conn);
 $info=mysql_fetch_array($sql);
 if($info[huida]!=$da)
 {
   echo "<script>alert('��ʾ���������!');history.back();</script>";
  exit;
 }
 else
 {
?>
<body topmargin="0" leftmargin="0" bottommargin="0">
<table width="200" height="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" colspan="2"><div align="center">�һ�����</div></td>
  </tr>
  <tr>
    <td width="76" height="25"><div align="center">�ǳƣ�</div></td>
    <td width="124"><div align="left"><?php echo $nc;?></div></td>
  </tr>
  <tr>
    <td height="25"><div align="center">���룺</div></td>
    <td height="25"><div align="left"><?php echo $info[pwd1];?></div></td>
  </tr>
  <tr>
    <td height="25" colspan="2"><div align="center"><input type="button"  value="ȷ��" onClick="window.close()"></div></td>
  </tr>
</table>
</body>
</html>
<?php
  }
?>