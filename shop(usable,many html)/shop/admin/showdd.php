<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ʒ����</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {color: #000000}
-->
</style>
</head>
<?php
  
  include("conn.php");
  $id=$_GET[id];
  $sql=mysql_query("select * from dingdan where id='".$id."'",$conn);
  $info=mysql_fetch_array($sql);
  $spc=$info[spc];
  $slc=$info[slc];
  $arraysp=explode("@",$spc);
  $arraysl=explode("@",$slc);
?>
<body topmargin="0" leftmargin="0" bottommargin="0">
<table width="600"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" colspan="2" bgcolor="#666666"><div align="center" class="style1">��Ʒ����</div></td>
  </tr>
  <tr>
    <td width="448" height="20"><div align="left"><span class="style2">�����ţ�</span><?php echo $info[dingdanhao];?></div></td>
    <td width="152"><div align="right">
  <script>     
  function prn()     
  {     
  document.all.WebBrowser1.ExecWB(7,1);  
  }     
  </script>     
  <object   ID='WebBrowser1'   WIDTH=0   HEIGHT=0   CLASSID='CLSID:8856F961-340A-11D0-A96B-00C04FD705A2'></object>
	<input type="button" value="��ӡԤ��" class="buttoncss" onClick="prn()">&nbsp;
	<input type="button" value="��ӡ" class="buttoncss" onClick="window.print()"></div></td>
  </tr>
  <tr>
    <td height="20" colspan="2"><div align="left" class="style2">��Ʒ�б�(����)��</div></td>
  </tr>
</table>
<table width="500" height="60" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#666666"><table width="500" border="0" align="center" cellpadding="0" cellspacing="1">
      <tr>
        <td width="153" height="20" bgcolor="#666666"><div align="center" class="style1">��Ʒ����</div></td>
        <td width="80" bgcolor="#666666"><div align="center" class="style1">�г���</div></td>
        <td width="80" bgcolor="#666666"><div align="center" class="style1">��Ա��</div></td>
        <td width="80" bgcolor="#666666"><div align="center" class="style1">����</div></td>
        <td width="101" bgcolor="#666666"><div align="center" class="style1">С��</div></td>
      </tr>
	  <?php
	  $total=0;
	  for($i=0;$i<count($arraysp)-1;$i++)
	   { if($arraysp[$i]!="")
	     {
	     $sql1=mysql_query("select * from shangpin where id='".$arraysp[$i]."'",$conn);
	     $info1=mysql_fetch_array($sql1);
		 $total=$total+=$arraysl[$i]*$info1[huiyuanjia];
	  ?>
	  <tr bgcolor="#FFFFFF">
        <td height="20"><div align="center"><?php echo $info1[mingcheng];?></div></td>
        <td height="20"><div align="center"><?php echo $info1[shichangjia];?></div></td>
        <td height="20"><div align="center"><?php echo $info1[huiyuanjia];?></div></td>
        <td height="20"><div align="center"><?php echo $arraysl[$i];?></div></td>
        <td height="20"><div align="center"><?php echo $arraysl[$i]*$info1[huiyuanjia];?></div></td>
     </tr>
	 <?php
	    }
	   }
	 ?>
	 
      <tr bgcolor="#FFFFFF">
        <td height="20" colspan="5">
          <div align="right">�ܼƷ���:<?php echo $total;?>
          </div></td>
        </tr>
    </table></td>
  </tr>
</table>
<table width="460" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="81" height="20"><div align="left" class="style2">�µ��ˣ�</div></td>
    <td colspan="3"><div align="left"><?php echo $info[xiadanren];?></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left" class="style2">�ջ��ˣ�</div></td>
    <td height="20" colspan="3"><div align="left"><?php echo $info[shouhuoren];?></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left" class="style2">�ջ��˵�ַ��</div></td>
    <td height="20" colspan="3"><div align="left"><?php echo $info[dizhi];?></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left" class="style2">��&nbsp;&nbsp;�ࣺ</div></td>
    <td width="145" height="20"><div align="left"><?php echo $info[youbian];?></div></td>
    <td width="66"><div align="left" class="style2">��&nbsp;&nbsp;����</div></td>
    <td width="158"><div align="left"><?php echo $info[tel];?></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left" class="style2">E-mail:</div></td>
    <td height="20"><div align="left"><?php echo $info[email];?></div></td>
    <td height="20">&nbsp;</td>
    <td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td height="20"><div align="left" class="style2">�ͻ���ʽ��</div></td>
    <td height="20"><div align="left"><?php echo $info[shff];?></div></td>
    <td height="20"><div align="left" class="style2">֧����ʽ��</div></td>
    <td height="20"><div align="left"><?php echo $info[zfff];?></div></td>
  </tr>
  <tr>
    <td height="20" colspan="4"><div align="left" class="style2">������һ���ڰ�����֧����ʽ���л��,���ʱע�����Ķ�����!�����뼰ʱ֪ͨ����</div></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
    <td height="20"><div align="center"><input type="button" onClick="window.close()" value="�رմ���" class="buttoncss"></div></td>
    <td height="20"><div align="center" class="style2">����ʱ�䣺</div></td>
    <td height="20"><div align="left"><?php echo $info[time];?></div></td>
  </tr>
</table>
</body>
</html>
