
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ʒ������</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>

<body topmargin="0" leftmargin="0" bottommargin="0">
<?php
include("conn.php");
$sql=mysql_query("select * from type order by id desc",$conn);
$info=mysql_fetch_array($sql);
 if($info==false)
  {
    echo "��վ������Ʒ���!";
   }
  else
  {
?>
<div align="center">
  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
   <form name="form1" method="post" action="deletelb.php">
    <tr>
      <td height="20" bgcolor="#666666"><div align="center" class="style1">��Ʒ������</div></td>
    </tr>
    <tr>
      <td height="20" bgcolor="#666666"><table width="400" border="0" align="center" cellpadding="0" cellspacing="1">
        <tr>
          <td width="253" height="20" bgcolor="#FFFFFF"><div align="center">�������</div></td>
          <td width="144" bgcolor="#FFFFFF"><div align="center">����</div></td>
        </tr>
		<?php
		  do
		  {
		?>
        <tr>
          <td height="20" bgcolor="#FFFFFF"><div align="center"><?php echo $info[typename];?></div></td>
          <td height="20" bgcolor="#FFFFFF"><div align="center"><input type="checkbox" value=<?php echo $info[id];?> name="<?php echo $info[id];?>"> </div></td>
        </tr>
		
		<?php
		 }
		 while($info=mysql_fetch_array($sql));
		?>
		<tr>
          <td height="20" bgcolor="#FFFFFF"><div align="center"></div></td>
          <td height="20" bgcolor="#FFFFFF"><div align="center"><input type="submit" value="ɾ��ѡ��" class="buttoncss"></div></td>
        </tr>
      </table></td>
    </tr>
	</form>
  </table>
</div>
<?php
 }
?>
</body>
</html>
