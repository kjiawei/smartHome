
<html>
<head>
<title>�û����Թ���</title>
<link  rel="stylesheet" type="text/css" href="css/font.css">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>

<body topmargin="0" leftmargin="0" bottommargin="0">
 <?php
       include("conn.php");
	    include("function.php");
	   $sql=mysql_query("select count(*) as total from leaveword  ",$conn);
	   $info=mysql_fetch_array($sql);
	   $total=$info[total];
	   if($total==0)
	   {
	     echo "��վ�����û�����!";
	   }
	   else
	   {
	  
	  ?>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" method="post" action="deleteleaveword.php">
  <tr> 
    <td height="20" colspan="2" bgcolor="#666666"><div align="center"><font color="#FFFFFF">�û����Թ���</font></div></td>
  </tr>
  <tr> 
    <td height="40" colspan="2" bgcolor="#333333"><table width="750"  border="0" align="center" cellpadding="0" cellspacing="1">
        <tr> 
          <td width="357" height="20" bgcolor="#FFFFFF"><div align="center">��������</div></td>
          <td width="80" bgcolor="#FFFFFF"><div align="center">������</div></td>
          <td width="156" bgcolor="#FFFFFF"><div align="center">����ʱ��</div></td>
          <td width="93" bgcolor="#FFFFFF"><div align="center">����</div></td>
          <td width="58" bgcolor="#FFFFFF"><div align="center">ɾ��</div></td>
        </tr>
		 <?php
 
    
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
			 
            
			 $sql1=mysql_query("select * from leaveword  order by time desc limit ".($page-1)*$pagesize.",$pagesize ",$conn);
             while($info1=mysql_fetch_array($sql1))
		     {
		  ?>
        <tr> 
          <td height="20" bgcolor="#FFFFFF"><div align="left"><?php echo unhtml($info1[title]);?></div></td>
          <td height="20" bgcolor="#FFFFFF"><div align="center">
		  <?php
		   $sql2=mysql_query("select name from user where id='".$info1[userid]."'",$conn);
		   $info2=mysql_fetch_array($sql2);
		   echo $info2[name];
		  ?>
		  </div></td>
          <td height="20" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[time];?></div></td>
          <td height="20" bgcolor="#FFFFFF"><div align="center"><a href="showleaveword.php?id=<?php echo $info1[id];?>">�鿴</a></div></td>
          <td height="20" bgcolor="#FFFFFF"><div align="center">
              <input type="checkbox" name=<?php echo $info1[id];?> value=<?php echo $info1[id];?>>
            </div></td>
        </tr>
		<?php
		 }
		?>
      </table></td>
  </tr>
  <tr> 
    <td width="652" height="20" bgcolor="#FFFFFF"><div align="left">
	&nbsp;��վ�����û�����&nbsp;<?php
		   echo $total;
		  ?>&nbsp;��&nbsp;ÿҳ��ʾ&nbsp;<?php echo $pagesize;?>&nbsp;��&nbsp;��&nbsp;<?php echo $page;?>&nbsp;ҳ/��&nbsp;<?php echo $pagecount; ?>&nbsp;ҳ
        <?php
		  if($page>=2)
		  {
		  ?>
        <a href="lookleaveword.php?page=1" title="��ҳ"><font face="webdings"> 9 </font></a> 
		<a href="lookleaveword.php?id=<?php echo $id;?>&page=<?php echo $page-1;?>" title="ǰһҳ"><font face="webdings"> 7 </font></a>
        <?php
		  }
		   if($pagecount<=4){
		    for($i=1;$i<=$pagecount;$i++){
		  ?>
        <a href="lookleaveword.php?page=<?php echo $i;?>"><?php echo $i;?></a>
        <?php
		     }
		   }else{
		   for($i=1;$i<=4;$i++){	 
		  ?>
        <a href="lookleaveword.php?page=<?php echo $i;?>"><?php echo $i;?></a>
        <?php }?>
        <a href="lookleaveword.php?page=<?php echo $page-1;?>" title="��һҳ"><font face="webdings"> 8 </font></a> 
		<a href="lookleaveword.php?id=<?php echo $id;?>&page=<?php echo $pagecount;?>" title="βҳ"><font face="webdings"> : </font></a>
        <?php }?>
	
	</div></td>
    <td width="98" bgcolor="#FFFFFF"><div align="center"><input type="submit" value="ɾ��ѡ��" class="buttoncss"></div></td>
  </tr>
  </form>
</table>
	<?php
		 }
	?>
</body>
</html>
