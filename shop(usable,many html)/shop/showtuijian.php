<?php
 include("top.php");
?>
<table width="800" height="438" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" height="438" valign="top" bgcolor="#E8E8E8"><div align="center">
	<?php include("left.php");?>
    </div></td>
    <td width="10" background="images/line2.gif">&nbsp;</td>
    <td width="590" valign="top"><table width="550" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><img src="images/tjsp.gif" width="500" height="25"></td>
      </tr>
    </table>
      <table width="550" height="10" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td background="images/line1.gif"></td>
        </tr>
      </table>
	  <?php
	   $sql=mysql_query("select count(*) as total from shangpin where tuijian=1 ",$conn);
	   $info=mysql_fetch_array($sql);
	   $total=$info[total];
	   if($total==0)
	   {
	     echo "��վ�����Ƽ���Ʒ!";
	   }
	   else
	   {
	  
	  ?>
	  
      <table width="550" height="70" border="0" align="center" cellpadding="0" cellspacing="0">
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
			 
             $sql1=mysql_query("select * from shangpin where tuijian=1 order by addtime desc limit ".($page-1)*$pagesize.",$pagesize ",$conn);
             while($info1=mysql_fetch_array($sql1))
		     {
		  ?>
        <tr>
          <td width="89"  rowspan="6"><div align="center">
              <?php
			 if($info1[tupian]=="")
			 {
			   echo "����ͼƬ!";
			 }
			 else
			 {
			?>
               <a href="lookinfo.php?id=<?php echo $info1[id];?>" ><img  border="0" width="80" height="80" src="<?php echo $info1[tupian];?>"></a>
              <?php
			 }
			?>
          </div></td>
          <td width="93" height="20"><div align="center" style="color: #000000">��Ʒ���ƣ�</div></td>
          <td colspan="5"><div align="left"> <a href="lookinfo.php?id=<?php echo $info1[id];?>"><?php echo $info1[mingcheng];?></a></div></td>
        </tr>
        <tr>
          <td width="93" height="20"><div align="center" style="color: #000000">��ƷƷ�ƣ�</div></td>
          <td width="101" height="20"><div align="left"><?php echo $info1[pinpai];?></div></td>
          <td width="62"><div align="center" style="color: #000000">��Ʒ�ͺţ�</div></td>
          <td colspan="3"><div align="left"><?php echo $info1[xinghao];?></div></td>
        </tr>
        <tr>
          <td width="93" height="20"><div align="center" style="color: #000000">��Ʒ��飺</div></td>
          <td height="20" colspan="5"><div align="left"><?php echo $info1[jianjie];?></div></td>
        </tr>
        <tr>
          <td height="20"><div align="center" style="color: #000000">�������ڣ�</div></td>
          <td height="20"><div align="left"><?php echo $info1[addtime];?></div></td>
          <td height="20"><div align="center" style="color: #000000">ʣ��������</div></td>
          <td width="69" height="20"><div align="left"><?php echo $info1[shuliang]-$info1[cishu];?></div></td>
          <td width="63"><div align="center" style="color: #000000">��Ʒ�ȼ���</div></td>
          <td width="73"><div align="left"><?php echo $info1[dengji];?></div></td>
        </tr>
        <tr>
          <td height="20"><div align="center" style="color: #000000">�̳��ۣ�</div></td>
          <td height="20"><div align="left"><?php echo $info1[shichangjia];?>Ԫ</div></td>
          <td height="20"><div align="center" style="color: #000000">��Ա�ۣ�</div></td>
          <td height="20"><div align="left"><?php echo $info1[huiyuanjia];?>Ԫ</div></td>
          <td height="20"><div align="center" style="color: #000000">�ۿۣ�</div></td>
          <td height="20"><div align="left"><?php echo (ceil(($info1[huiyuanjia]/$info1[shichangjia])*100))."%";?></div></td>
        </tr>
        <tr>
          <td height="20" colspan="6" width="461"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;<a href="addgouwuche.php?id=<?php echo $info1[id];?>"><img src="images/in_gwc.gif" width="100" height="18" border="0" style=" cursor:hand"></a></div></td>
        </tr>
        <tr>
          <td height="10" colspan="7" background="images/line1.gif"></td>
        </tr>
        <?php
	    }
		
		?>
      </table>
      <table width="550" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><div align="right">
		  &nbsp;��վ�����Ƽ���Ʒ&nbsp;<?php
		   echo $total;
		  ?>&nbsp;��&nbsp;ÿҳ��ʾ&nbsp;<?php echo $pagesize;?>&nbsp;��&nbsp;��&nbsp;<?php echo $page;?>&nbsp;ҳ/��&nbsp;<?php echo $pagecount; ?>&nbsp;ҳ
        <?php
		  if($page>=2)
		  {
		  ?>
        <a href="showtuijian.php?page=1" title="��ҳ"><font face="webdings"> 9 </font></a> 
		<a href="showtuijian.php?id=<?php echo $id;?>&page=<?php echo $page-1;?>" title="ǰһҳ"><font face="webdings"> 7 </font></a>
        <?php
		  }
		   if($pagecount<=4){
		    for($i=1;$i<=$pagecount;$i++){
		  ?>
        <a href="showtuijian.php?page=<?php echo $i;?>"><?php echo $i;?></a>
        <?php
		     }
		   }else{
		   for($i=1;$i<=4;$i++){	 
		  ?>
        <a href="showtuijian.php?page=<?php echo $i;?>"><?php echo $i;?></a>
        <?php }?>
        <a href="showtuijian.php?page=<?php echo $page-1;?>" title="��һҳ"><font face="webdings"> 8 </font></a> 
		<a href="showtuijian.php?id=<?php echo $id;?>&page=<?php echo $pagecount;?>" title="βҳ"><font face="webdings"> : </font></a>
        <?php }?>
		  </div></td>
        </tr>
      </table>
	   <?php
	    }
		
		?>
	  </td>
  </tr>
</table>
<?php
 include("bottom.php");
?>