
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�һ�����</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
</head>
<?php
 include("conn.php");
?>
<body topmargin="0" leftmargin="0" bottommargin="0">
<table width="200" height="100" border="0" align="center" cellpadding="0" cellspacing="0">
 <script language="javascript">
   function chkinput(form)
   {
     if(form.da.value=="")
	 {
	  alert('������������ʾ��!');
	  form.da.select();
	  return(false);
	 }
	  return(true);
   }
 </script>
  <form name="form1" method="post" action="showpwd.php" onSubmit="return chkinput(this)">
  <tr>
    <td height="25" colspan="2"><div align="center">�һ�����</div></td>
  </tr>
  <tr>
    <td width="60" height="25"><div align="center">������ʾ��</div></td>
    <td width="140"><div align="left">
	<?php
	  $nc=$_POST[nc];
	  $sql=mysql_query("select * from user where name='".$nc."'",$conn);
	  $info=mysql_fetch_array($sql);
	  if($info==false)
	   {
	     echo "<script>alert('�޴��û�!');history.back();</script>";
		 exit;
	   }
	   else
	   {
	     echo $info[tishi];
	   }
	   
	?>
	</div></td>
  </tr>
  <tr>
    <td height="25"><div align="center">��ʾ�𰸣�</div></td>
    <td height="25"><div align="left"><input type="text" name="da" class="inputcss" size="20">
	  <input type="hidden" name="nc" value="<?php echo $nc;?>">
	</div></td>
  </tr>
  <tr>
    <td height="25" colspan="2"><div align="center"><input type="submit" value="ȷ��" class="buttoncss"></div></td>
  </tr>
  </form>
</table>
</body>
</html>
