
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>用户登录</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
</head>

<body topmargin="0" leftmargin="0" bottommargin="0">
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#FF9966">
    <td height="169" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="214" height="146" background="images/back5.gif"  valign="bottom"><table width="214" height="100" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><script language=JavaScript>     
var index = 5    
    
text = new Array(4);     
text[0] ='&nbsp;&nbsp;&nbsp;&nbsp;◆&nbsp;&nbsp;不得违反国家的法律法规;'     
text[1] ='&nbsp;&nbsp;&nbsp;&nbsp;◆&nbsp;&nbsp;诚实进行商品交易;' 
text[2] ='&nbsp;&nbsp;&nbsp;&nbsp;◆&nbsp;&nbsp;管理员有权删除您的信息等;'     
text[3] ='&nbsp;&nbsp;&nbsp;&nbsp;◆&nbsp;&nbsp;不得发表不文明的言论;'     
text[4] ='&nbsp;&nbsp;&nbsp;&nbsp;◆&nbsp;&nbsp;不得非法登录本站;'  	 

     
document.write ("<marquee scrollamount='1' scrolldelay='60' direction= 'up' width='210' id=xiaoqing height='110' onmouseover=xiaoqing.stop() onmouseout=xiaoqing.start()>");     
for (i=0;i<index;i++){     
document.write ("<font color=#0c4a9d>");     
document.write (text[i] + "</font></A><br><br>");     
}  document.write ("</marquee>")     
</script>
</td>
      </tr>
    </table></td>
    <td width="554" height="146"><img src="images/back6.gif" width="554" height="146"></td>
    <td width="232" height="146"><img src="images/back7.gif" width="232" height="146"></td>
  </tr>
  <tr>
    <td height="128" colspan="2"><img src="images/back8.gif" width="768" height="128"></td>
    <td width="232" height="128" background="images/back9.gif"><table width="200" height="100" border="0" cellpadding="0" cellspacing="0">
	<script language="javascript">
	  function chkinput(form)
	  {
	    if(form.name.value=="")
		{
		  alert("请输入用户名!");
		  form.name.select();
		  return(false);
		}
		if(form.pwd.value=="")
		{
		  alert("请输入用户密码!");
		  form.pwd.select();
		  return(false);
		}
		return(true);
	  }
	
	
	</script>
	
	<form name="form1" method="post" action="chkadmin.php" onSubmit="return chkinput(this)">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20"><div align="left">
        </div></td>
      </tr>
      <tr>
        <td height="20"><div align="left"><img src="images/BgUserName.gif"><input type="text" name="name" size="20" maxlength="20" class="inputcss"></div></td>
      </tr>
      <tr>
        <td height="20"><div align="left"><img src="images/BgPassWord.gif"><input type="password" name="pwd" size="20" maxlength="20" class="inputcss"></div></td>
      </tr>
      <tr>
        <td height="20"><div align="center"><input type="submit" value="提交"  class="buttoncss">&nbsp;&nbsp;<input type="reset" value="重置" class="buttoncss"></div></td>
      </tr>
      <tr>
        <td height="20"><div align="center">&nbsp;</div></td>
      </tr></form>
    </table></td>
  </tr>
  <tr bgcolor="#FF9966">
    <td height="169" colspan="3"><div align="center"><br>
    『网上商城系统』 Powered by <a href="http://user.qzone.qq.com/282915629">王志宇</a></div></td>
  </tr>
</table>
</body>
</html>
