
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��ӹ���</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>
<script language="javascript">
  function chkinput(form)
   {
     if(form.title.value=="")
	 {
	   alert("�����빫������!");
	   form.title.select();
	   return(false);
	 }
     if(form.content.value=="")
	 {
	   alert("�����빫������!");
	   form.content.select();
	   return(false);
	 }
	 return(true);
   }
</script>
<body topmargin="0" leftmargin="0" bottommargin="0">
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" bgcolor="#666666"><div align="center" class="style1">��ӹ���</div></td>
  </tr>
  <tr>
    <td height="175" bgcolor="#666666"><table width="750" height="175" border="0" align="center" cellpadding="0" cellspacing="1">
      <form name="form1" method="post" action="savenewgonggao.php" onSubmit="return chkinput(this)">
	  <tr>
        <td width="80" height="25" bgcolor="#FFFFFF"><div align="center">�������⣺</div></td>
        <td width="667" bgcolor="#FFFFFF"><div align="left"><input type="text" name="title" size="50" class="inputcss"></div></td>
      </tr>
      <tr>
        <td height="125" bgcolor="#FFFFFF"><div align="center">�������ݣ�</div></td>
        <td height="125" bgcolor="#FFFFFF"><div align="left"><textarea name="content" rows="8" cols="70"></textarea>
        </div></td>
      </tr>
      <tr>
        <td height="25" colspan="2" bgcolor="#FFFFFF"><div align="center"><input type="submit" value="���" class="buttoncss">&nbsp;&nbsp;<input type="reset" value="��д" class="buttoncss"></div></td>
      </tr>
	  </form>
    </table></td>
  </tr>
</table>
</body>
</html>
