
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�༭��Ʒ</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>
<?php
  include("conn.php");
?>
<body topmargin="0" leftmargin="0" bottommargin="0">
<?php
	   $sql=mysql_query("select count(*) as total from shangpin ",$conn);
	   $info=mysql_fetch_array($sql);
	   $total=$info[total];
	   if($total==0)
	   {
	     echo "��վ������Ʒ!";
	   }
	   else
	    {
?>
<form name="form1" method="post" action="deletefxhw.php">
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="75" bgcolor="#666666"><table width="750" height="86" border="0" cellpadding="0" cellspacing="1">
      
	  <tr>
        <td height="20" colspan="10" bgcolor="#666666"><div align="center" class="style1">��Ʒ��Ϣ�༭</div></td>
      </tr>
      <tr>
        <td width="59" height="28" bgcolor="#FFFFFF"><div align="center">��ѡ</div></td>
        <td width="102" bgcolor="#FFFFFF"><div align="center">����</div></td>
        <td width="86" bgcolor="#FFFFFF"><div align="center">Ʒ��</div></td>
        <td width="71" bgcolor="#FFFFFF"><div align="center">�ͺ�</div></td>
        <td width="60" bgcolor="#FFFFFF"><div align="center">ʣ��</div></td>
        <td width="60" bgcolor="#FFFFFF"><div align="center">�г���</div></td>
        <td width="61" bgcolor="#FFFFFF"><div align="center">��Ա��</div></td>
        <td width="60" bgcolor="#FFFFFF"><div align="center">����</div></td>
        <td width="112" bgcolor="#FFFFFF"><div align="center">����ʱ��</div></td>
        <td width="68" bgcolor="#FFFFFF"><div align="center">����</div></td>
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
			 
           $sql1=mysql_query("select * from shangpin order by addtime desc limit ".($page-1)*$pagesize.",$pagesize",$conn);
		   while($info1=mysql_fetch_array($sql1))
		    {
	  ?>
      <tr>
        <td height="25" bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" name="<?php echo $info1[id];?>" value=<?php echo $info1[id];?>>
        </div></td>
        <td height="25" bgcolor="#FFFFFF">
          
          <div align="center"><?php echo $info1[mingcheng];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[pinpai];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[xinghao];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php if($info1[shuliang]<0) {echo "����";}else {echo $info1[shuliang];}?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[shichangjia];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[huiyuanjia];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[cishu];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[addtime];?></div></td>
        <td height="25" bgcolor="#FFFFFF"><div align="center"><a href="changegoods.php?id=<?php echo $info1[id];?>">����</a></div></td>
      </tr>
	 <?php
	    }
        
      ?>
	 
    </table></td>
  </tr>
</table>
<table width="750" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="165">
	  <div align="left"><input type="submit" value="ɾ��ѡ��" class="buttoncss">&nbsp;<input type="reset" value="����ѡ��" class="buttoncss"></div></td>
    <td width="585"><div align="right">&nbsp;��վ���л���
        <?php
		   echo $total;
		  ?>
        &nbsp;��&nbsp;ÿҳ��ʾ&nbsp;<?php echo $pagesize;?>&nbsp;��&nbsp;��&nbsp;<?php echo $page;?>&nbsp;ҳ/��&nbsp;<?php echo $pagecount; ?>&nbsp;ҳ
        <?php
		  if($page>=2)
		  {
		  ?>
        <a href="editgoods.php?page=1" title="��ҳ"><font face="webdings"> 9 </font></a> <a href="editgoods.php?id=<?php echo $id;?>&page=<?php echo $page-1;?>" title="ǰһҳ"><font face="webdings"> 7 </font></a>
        <?php
		  }
		   if($pagecount<=4){
		    for($i=1;$i<=$pagecount;$i++){
		  ?>
        <a href="editgoods.php?page=<?php echo $i;?>"><?php echo $i;?></a>
        <?php
		     }
		   }else{
		   for($i=1;$i<=4;$i++){	 
		  ?>
        <a href="editgoods.php?page=<?php echo $i;?>"><?php echo $i;?></a>
        <?php }?>
        <a href="editgoods.php?page=<?php echo $page-1;?>" title="��һҳ"><font face="webdings"> 8 </font></a> <a href="editgoods.php?id=<?php echo $id;?>&page=<?php echo $pagecount;?>" title="βҳ"><font face="webdings"> : </font></a>
        <?php }?>
    </div></td>
  </tr>
</table>
</form>
  <?php
	}
    
  ?>
</body>
</html>
