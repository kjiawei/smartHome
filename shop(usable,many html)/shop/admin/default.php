
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����̳�ϵͳ��̨����</title>
<script language="javascript">
  function showhidden()
  {
    if(document.all.lt.style.display=="")
	 {
	   document.all.lt.style.display="none"; 
	   document.all.img1.src="images/point1.gif";
	   document.all.img1.title="��";
	   document.all.mn.width="985";
	 }
	 else
	 {
	   document.all.lt.style.display="";
	   document.all.img1.src="images/point2.gif";
	   document.all.img1.title="�ر�";
	   document.all.mn.width="785";
	 }
  }

</script>
<link rel="stylesheet" type="text/css" href="css/font.css">
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" class="scrollbar">
<table width="1000" height="620" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" height="200" valign="top" bgcolor="#FF9966" id="lt" style="display:"><div align="center">
	<IFRAME frameBorder=0 id=left name=left scrolling=yes src="left.php" 
      style="HEIGHT: 100%; VISIBILITY: inherit; WIDTH: 200px; Z-INDEX: 2">
    </IFRAME>
	</div>
	</td>
    <td width="15" height="15" bgcolor="#999999"><div align="center"><img id="img1" src="images/point2.gif" width="10" height="10" onClick="showhidden()" title="�ر�"></div></td>
    <td width="785" id="mn"><div align="center">
	<IFRAME frameBorder=0 id=main name=main scrolling=yes src="addgoods.php" 
      style="HEIGHT: 100%; VISIBILITY: inherit; WIDTH: 100%; Z-INDEX: 1">
    </IFRAME>
	</div></td>
  </tr>
</table>
</body>
</html>
