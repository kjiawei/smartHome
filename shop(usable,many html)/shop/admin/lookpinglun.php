
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>查看评论</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
</head>
<?php
include("conn.php");
include("function.php");
$sql=mysql_query("select * from pingjia where id='".$_GET[id]."'",$conn);
$info1=mysql_fetch_array($sql);


?>
<body topmargin="0" leftmargin="0" bottommargin="0">
 <table width="750" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="25" colspan="4" bgcolor="#666666"><div align="center" style="color: #FFFFFF">商品评论</div></td>
        </tr>
		<tr>
          <td width="70" height="20"><div align="center">商品名称：</div></td>
          <td width="181"><div align="left">
		  <?php 
		     $spid=$info1[spid];
			 $sql2=mysql_query("select mingcheng from shangpin where id=".$spid."",$conn);
			 $info2=mysql_fetch_array($sql2);
			 echo $info2[mingcheng];
		  ?>
		  </div></td>
          <td width="70"><div align="center">评论时间：</div></td>
          <td width="229"><div align="left"><?php echo $info1[time];?></div></td>
        </tr>
        <tr>
          <td height="20"><div align="center">评论者：</div></td>
          <td height="20" colspan="3"><div align="left">
		   <?php 
		     $spid=$info1[userid];
			 $sql3=mysql_query("select name from user where id=".$spid."",$conn);
			 $info3=mysql_fetch_array($sql3);
			 echo $info3[name];
			
		  ?>
		  </div></td>
        </tr>
        <tr>
          <td height="20"><div align="center">评论主题：</div></td>
          <td height="20" colspan="3"><div align="left"><?php echo unhtml($info1[title]);?></div></td>
        </tr>
        <tr>
          <td height="40"><div align="center">评论内容：</div></td>
          <td height="40" colspan="3" valign="bottom"><div align="left"><?php echo unhtml($info1[content]);?></div></td>
        </tr>
        <tr>
          <td height="10" colspan="4" background="images/line1.gif"><div align="center">
            <label>
            <input type="button" value="返回" class="buttoncss" onClick="javascript:history.back();">
            </label>
          </div></td>
        </tr>

		
</table>



</body>
</html>
