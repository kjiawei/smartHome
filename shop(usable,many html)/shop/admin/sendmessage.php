<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>短信管理</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {color: #FF0000}
-->
</style>
</head>
<?php
include("conn.php");
$id=$_GET[id];
$sql=mysql_query("select * from user where id=".$id."",$conn);
$info=mysql_fetch_array($sql);
?>
<script language="javascript">
 function chkinput(form)
  { 
    if(form.regtel.value=="")
	 {
	   alert("请输入注册手！");
	   form.regtel.select();
	   return(false);
	 }
	 if(form.regpwd.value=="")
	 {
	   alert("请输入注册手机密码！");
	   form.regpwd.select();
	   return(false);
	 } 
	if(form.tel.value=="")
	 {
	   alert("请输入手机号！");
	   form.tel.select();
	   return(false);
	 }
     if(form.mess.value=="")
	 {
	   alert("请输入短信内容！");
	   form.mess.select();
	   return(false);
	 }
	 return(true);
  }
</script>
<body topmargin="0" leftmargin="0" bottommargin="0">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" bgcolor="#666666"><div align="center" class="style1">发送短信</div></td>
  </tr>
  <tr>
    <td height="102" bgcolor="#666666">
	<table width="650" border="0" cellpadding="0" cellspacing="1">
      <form name="form1" method="post" action="send.php" onSubmit="return chkinput(this)">
	  <tr>
        <td width="101" height="20" bgcolor="#FFFFFF"><div align="center">&nbsp;用户昵称：</div></td>
        <td width="546" bgcolor="#FFFFFF"><div align="left"><?php echo $info[name];?></div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF"><div align="center">真实姓名：</div></td>
        <td height="20" bgcolor="#FFFFFF"><div align="left"><?php echo $info[truename];?></div></td>
      </tr>
	  <tr>
        <td height="20" bgcolor="#FFFFFF"><div align="center">注册手机号：</div></td>
        <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="regtel" size="25" class="inputcss"></div></td>
      </tr>
	  <tr>
        <td height="20" bgcolor="#FFFFFF"><div align="center">注册手机密码：</div></td>
        <td height="20" bgcolor="#FFFFFF"><div align="left"><input name="regpwd" type="password" class="inputcss" id="regpwd" size="25" >
        </div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF"><div align="center">用户手机号码：</div></td>
        <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="tel" size="25" class="inputcss" value="<?php echo $info[tel];?>"></div></td>
      </tr>
      <tr>
        <td height="80" bgcolor="#FFFFFF"><div align="center">短信内容：</div></td>
        <td height="80" bgcolor="#FFFFFF"><div align="left">
          <textarea name="mess" cols="50" rows="6" class="inputcss"></textarea>
          <span class="style2">短信内容限定在30字以内</span></div></td>
      </tr>
      <tr>
        <td height="20" colspan="2" bgcolor="#FFFFFF"><div align="center"><input type="submit" value="发送" class="buttoncss"></div></td>
      </tr>
	  </form>
    </table></td>
  </tr>
</table>
</body>
</html>
