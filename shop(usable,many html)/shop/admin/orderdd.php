
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
<?php
 include("conn.php");
 $id=$_GET[id];
 $sql=mysql_query("select * from dingdan where id='".$id."'",$conn);
 $info=mysql_fetch_array($sql);
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {color: #f2ab5b}
.style2 {color: #FF0000}
.style3 {color: #000000}
-->
</style>
</head>

<body topmargin="0" leftmargin="0" bottommargin="0">
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20"><div align="left"><input type="button" value="����" class="buttoncss" onClick="javascript:history.back();"></div></td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" bgcolor="#666666"><div align="center" class="style1">ִ�д���</div></td>
  </tr>
  <tr>
    <td bgcolor="#333333"><table width="750" border="0" align="center" cellpadding="0" cellspacing="1">
     <form name="form1" method="post" action="saveorder.php?id=<?php echo $info[id];?>">
	  <tr>
        <td width="70" height="25" bgcolor="#FFFFFF"><div align="center" class="style3">������ţ�</div></td>
        <td width="271" bgcolor="#FFFFFF"><div align="left"><?php echo $info[dingdanhao];?></div></td>
        <td width="100" bgcolor="#FFFFFF"><div align="center"><span class="style3">���տ�</span>
          <input type="checkbox" value="���տ�" name="ysk"></div></td>
        <td width="101" bgcolor="#FFFFFF"><div align="center"><span class="style3">�ѷ���</span>
          <input name="yfh" type="checkbox" value="�ѷ���"  >
        </div></td>
        <td width="100" bgcolor="#FFFFFF"><div align="center"><span class="style3">���ջ�</span>
          <input name="ysh" type="checkbox" value="���ջ�" >
        </div></td>
        <td width="101" bgcolor="#FFFFFF"><div align="center"><input type="submit" value="�޸�" class="buttoncss"></div></td>
	  </tr>
	  </form>
    </table></td>
  </tr>
</table>
<table width="750" height="20" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="13"><div align="left">
      <div align="center" class="style2">ע��һ����Ʒȷ������������Ʒ�������Զ��ӿ������Ӧ���٣����Ҳ��ɸ��ģ�</div>
    </div></td>
  </tr>
</table>
<table width="750" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#333333"><table width="750" border="0" align="center" cellpadding="0" cellspacing="1">
      <tr>
        <td width="106" height="20" bgcolor="#666666"><div align="center" class="style1">�� Ʒ �� ��</div></td>
        <td width="106" bgcolor="#666666"><div align="center" class="style1">����</div></td>
        <td width="106" bgcolor="#666666"><div align="center" class="style1">�г���</div></td>
        <td width="106" bgcolor="#666666"><div align="center" class="style1">��Ա��</div></td>
        <td width="106" height="20" bgcolor="#666666"><div align="center" class="style1">�ɽ���</div></td>
        <td width="106" bgcolor="#666666"><div align="center" class="style1">�ۿ�</div></td>
        <td bgcolor="#666666"><div align="center" class="style1">С ��</div></td>
      </tr>
	 <?php
	   $array=explode("@",$info[spc]);
	   $arraysl=explode("@",$info[slc]);
	   $total=0;
	   for($i=0;$i<count($array)-1;$i++)
	    {
		  if($array[$i]!="")
		  {
	       $sql1=mysql_query("select * from shangpin where id='".$array[$i]."'",$conn);
		   $info1=mysql_fetch_array($sql1);
		   $total=$total+$info1[huiyuanjia]*$arraysl[$i];
	 ?>
      <tr>
        <td height="25" bgcolor="#FFFFFF"><div align="left"> <?php echo $info1[mingcheng];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php if($info1[shuliang]<0) echo "����"; else echo $info1[shuliang];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[shichangjia];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[huiyuanjia];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[huiyuanjia];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo ceil(($info1[huiyuanjia]/$info1[shichangjia])*100);?>%</div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[huiyuanjia]*$arraysl[$i];?></div></td>
      </tr>
	 <?php
	     }
	   }
	 ?> 
    </table></td>
  </tr>
</table>
<table width="750" height="20" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="right" class="style3">�ϼƣ�<?php echo $total;?></div></td>
  </tr>
</table>
<table width="750" height="195" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr>
    <td height="193" bgcolor="#333333"><table width="750" height="151" border="0" align="center" cellpadding="0" cellspacing="1">
      <tr>
        <td height="20" colspan="2" bgcolor="#666666"><div align="center" class="style1">�ջ�����Ϣ</div></td>
      </tr>
      <tr>
        <td width="120" height="25" bgcolor="#FFFFFF"><div align="center" class="style3">�ջ���������</div></td>
        <td width="627" bgcolor="#FFFFFF"><div align="left"><?php echo $info[shouhuoren];?></div></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF"><div align="center" class="style3">��ϸ��ַ��</div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="left"><?php echo $info[dizhi];?></div></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF"><div align="center" class="style3">�ʡ����ࣺ</div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="left"><?php echo $info[youbian];?></div></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF"><div align="center" class="style3">�硡������</div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="left"><?php echo $info[tel];?></div></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF"><div align="center" class="style3">�����ʼ���</div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="left"><?php echo $info[email];?></div></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF"><div align="center" class="style3">�ͻ���ʽ��</div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="left"><?php echo $info[shff];?></div></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFFF"><div align="center" class="style3">֧����ʽ��</div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="left"><?php echo $info[zfff];?></div></td>
      </tr>
	  <tr>
        <td height="25" bgcolor="#FFFFFF"><div align="center" class="style3">�����ԣ�</div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="left"><?php echo $info[leaveword];?></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
