<?php
   session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��������ϵͳ</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
</head>
<?php
 include("conn.php");
 
?>

<body topmargin="0" leftmargin="0" bottommargin="0" class="scrollbar" onLoad="chkscreen()">

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td  width="202" height="72"><img src="images/banner.jpg" width="202" height="72" border="0" usemap="#Map"></td>
    <td width="598" height="72"><img src="images/dh_index.gif" width="598" height="72"></td>
  </tr>
</table>
<table width="800" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="136"><div align="left">&nbsp;&nbsp;
	<?php
	  
	
	  if($_SESSION[username]!="")
	  {
	    echo "��ǰ�û�:$_SESSION[username]";
	  
	  }
	
	?></div></td>
    <td width="67"><div align="center">
	<?php if($_SESSION[username]!="")
	  {
	    echo "<a href='logout.php'>ע���뿪</a>";
	  }
	?></div></td>
    <td width="58"><div align="center"><a href="index.php">��վ��ҳ</a></div></td>
    <td width="65"><div align="center"><a href="shownew.php">������Ʒ</a></div></td>
    <td width="65"><div align="center"><a href="showtuijian.php">�Ƽ���Ʒ</a></div></td>
    <td width="65"><div align="center"><a href="showhot.php">������Ʒ</a></div></td>
    <td width="67"><div align="center"><a href="showfenlei.php">��Ʒ����</a></div></td>
    <td width="66"><div align="center"><a href="agreereg.php">�û�ע��</a></div></td>
    <td width="64"><div align="center"><a href="usercenter.php">�û�����</a></div></td>
    <td width="65"><div align="center"><a href="mydd.php">�ҵĶ���</a></div></td>
    <td width="82"><div align="center"><a href="gouwu1.php">�ҵĹ��ﳵ</a></div></td>
  </tr>
</table>
<table width="800" height="10" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td background="images/line1.gif"></td>
  </tr>
</table>

<table width="800" height="20" border="0" align="center" cellpadding="0" cellspacing="0">
<script language="javascript">
  function chkinput1(form)
  { if(form.name.value=="")
     {
      alert("��������Ʒ����!");
      form.name.select();
	  return(false);
	  }
	 return(true); 
  }

</script>
  <form name="form0" method="post" action="findsp.php" onSubmit="return chkinput1(this)"> 
  <tr>
    <td width="220" bgcolor="#E8E8E8"><div align="left">&nbsp;&nbsp;����ʱ�䣺
   <script language=JavaScript>
   today=new Date();
   function initArray(){
   this.length=initArray.arguments.length
   for(var i=0;i<this.length;i++)
   this[i+1]=initArray.arguments[i]  }
   var d=new initArray(
     "������",
     "����һ",
     "���ڶ�",
     "������",
     "������",
     "������",
     "������");
document.write(
     "<font color=##000000 style='font-size:9pt;font-family: ����'> ",
     today.getYear(),"��",
     today.getMonth()+1,"��",
     today.getDate(),"��",
	  "&nbsp;&nbsp;",
     d[today.getDay()+1],
	"</font>" ); 
</script></div></td>
    <td width="580" bgcolor="#E8E8E8"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;�������Ʒ���ƣ�&nbsp;
          <input type="text" name="name" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'">
          <input type="hidden" name="jdcz" value="jdcz">
          <input type="submit" value="��������" class="buttoncss">
          &nbsp;
          <input type="button" value="�߼�����" class="buttoncss" onClick="javascript:window.location='highfind.php';">
      </div></td>
  </tr>
  </form>
</table>
<table width="800" height="10" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td background="images/line1.gif"></td>
  </tr>
</table>
<map name="Map">
  <area shape="rect" coords="0,3,26,31" href="admin/index.php">
</map>
