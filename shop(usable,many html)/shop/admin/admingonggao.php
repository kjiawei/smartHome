
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�������</title>
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
       $sql=mysql_query("select count(*) as total from gonggao ",$conn);
	   $info=mysql_fetch_array($sql);
	   $total=$info[total];
	   if($total==0)
	   {
	     echo "��վ���޹���!";
	   }
	   else
	   {
	       $pagesize=20;
		   if ($total<=$pagesize){
		      $pagecount=1;
			} 
			if(($total%$pagesize)!=0){
			   $pagecount=intval($total/$pagesize)+1;
			
			}else{
			   $pagecount=$total/$pagesize;
			
			}
			if(($_GET[page])==""){
			    $page=1;
			
			}else{
			    $page=intval($_GET[page]);
			
			}
			 
           $sql1=mysql_query("select * from gonggao order by time desc limit ".($page-1)*$pagesize.",$pagesize",$conn);
?>
<form name="form1" method="post" action="deletegonggao.php">
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" bgcolor="#666666"><div align="center" class="style1">�������</div></td>
  </tr>
  <tr>
    <td height="50" bgcolor="#666666"><table width="750" height="25" border="0" align="center" cellpadding="0" cellspacing="1">
	
      <tr>
        <td width="50" height="25" bgcolor="#FFFFFF"><div align="center">��ѡ</div></td>
        <td width="621" bgcolor="#FFFFFF"><div align="center">��������</div></td>
        <td width="75" bgcolor="#FFFFFF"><div align="center">����</div></td>
      </tr>
	    <?php
	
		   while($info1=mysql_fetch_array($sql1))
		    {
	  ?>
	  <tr>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><input type="checkbox" name=<?php echo $info1[id];?> value=<?php echo $info1[id];?>></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="left"><?php echo $info1[title];?></div></td>
	    <td height="25" bgcolor="#FFFFFF"><div align="center"><a href="editgonggao.php?id=<?php echo $info1[id];?>">�鿴�༭</a></div></td>
	  </tr>
	  <?php
	       }
	  
	  ?>
    </table></td>
  </tr>
</table>
<table width="750" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="203"><div align="left"><input type="submit" value="ɾ����ѡ��" class="buttoncss">&nbsp;&nbsp;<input type="reset" value="ȡ��ɾ��" class="buttoncss"></div></td>
    <td width="547"><div align="right">
	
	  ��վ���й���
	 <?php
		   echo $total;
		  ?>
        &nbsp;��&nbsp;ÿҳ��ʾ&nbsp;<?php echo $pagesize;?>&nbsp;��&nbsp;��&nbsp;<?php echo $page;?>&nbsp;ҳ/��&nbsp;<?php echo $pagecount; ?>&nbsp;ҳ
        <?php
		  if($page>=2)
		  {
		  ?>
        <a href="admingonggao.php?id=<?php echo $id;?>&page=1" title="��ҳ"><font face="webdings"> 9 </font></a> 
		<a href="admingonggao.php?id=<?php echo $id;?>&page=<?php echo $page-1;?>" title="ǰһҳ"><font face="webdings"> 7 </font></a>
        <?php
		  }
		   if($pagecount<=4){
		    for($i=1;$i<=$pagecount;$i++){
		  ?>
        <a href="admingonggao.php?id=<?php echo $id;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
        <?php
		     }
		   }else{
		   for($i=1;$i<=4;$i++){	 
		  ?>
        <a href="admingonggao.php?id=<?php echo $id;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
        <?php }?>
        <a href="admingonggao.php?id=<?php echo $id;?>&page=<?php echo $page-1;?>" title="��һҳ"><font face="webdings"> 8 </font></a>
		 <a href="admingonggao.php?id=<?php echo $id;?>&page=<?php echo $pagecount;?>" title="βҳ"><font face="webdings"> : </font></a>
        <?php }?>
		</div></td>
  </tr>
</table>
<?php
 }
?>
</form>
</body>
</html>
