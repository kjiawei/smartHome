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
        <td><img src="images/rmsp.gif" width="500" height="25"></td>
      </tr>
    </table>
      <table width="550" height="10" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td background="images/line1.gif"></td>
        </tr>
      </table>
      <table width="550" height="70" border="0" align="center" cellpadding="0" cellspacing="0">
	   <?php
	     $sql=mysql_query("select * from shangpin order by cishu desc limit 0,10",$conn); 
		 $info=mysql_fetch_array($sql);
		 if($info==false)
		  {
		   echo "��վ�������Ų�Ʒ!";
		  } 
		 else
		 { 
		    do
			 { 
	   ?>
	   <tr>
          <td width="89"  rowspan="6"><div align="center">
		    <?php
			 if($info[tupian]=="")
			 {
			   echo "����ͼƬ!";
			 }
			 else
			 {
			?>
		   <a href="lookinfo.php?id=<?php echo $info[id];?>"><img  border="0" width="80" height="80" src="<?php echo $info[tupian];?>"></a>
		    <?php
			 }
			?>
		  </div></td>
          <td width="93" height="20"><div align="center" style="color: #000000">��Ʒ���ƣ�</div></td>
          <td colspan="5"><div align="left"><a href="lookinfo.php?id=<?php echo $info[id];?>"><?php echo $info[mingcheng];?></a></div></td>
        </tr>
        <tr>
          <td width="93" height="20"><div align="center" style="color: #000000">��ƷƷ�ƣ�</div></td>
          <td width="101" height="20"><div align="left"><?php echo $info[pinpai];?></div></td>
          <td width="62"><div align="center" style="color: #000000">��Ʒ�ͺţ�</div></td>
          <td colspan="3"><div align="left"><?php echo $info[xinghao];?></div></td>
        </tr>
        <tr>
          <td width="93" height="20"><div align="center" style="color: #000000">��Ʒ��飺</div></td>
          <td height="20" colspan="5"><div align="left"><?php echo $info[jianjie];?></div></td>
        </tr>
        <tr>
          <td height="20"><div align="center" style="color: #000000">�������ڣ�</div></td>
          <td height="20"><div align="left"><?php echo $info[addtime];?></div></td>
          <td height="20"><div align="center" style="color: #000000">ʣ��������</div></td>
          <td width="69" height="20"><div align="left"><?php echo $info[shuliang]-$info[cishu];?></div></td>
          <td width="63"><div align="center" style="color: #000000">��Ʒ�ȼ���</div></td>
          <td width="73"><div align="left"><?php echo $info[dengji];?></div></td>
        </tr>
        <tr>
          <td height="20"><div align="center" style="color: #000000">�̳��ۣ�</div></td>
          <td height="20"><div align="left"><?php echo $info[shichangjia];?>Ԫ</div></td>
          <td height="20"><div align="center" style="color: #000000">��Ա�ۣ�</div></td>
          <td height="20"><div align="left"><?php echo $info[huiyuanjia];?>Ԫ</div></td>
          <td height="20"><div align="center" style="color: #000000">�ۿۣ�</div></td>
          <td height="20"><div align="left"><?php echo (ceil(($info[huiyuanjia]/$info[shichangjia])*100))."%";?></div></td>
        </tr>
        <tr>
          <td height="20" colspan="6" width="461"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;<a href="addgouwuche.php?id=<?php echo $info[id];?>"><img src="images/in_gwc.gif" width="100" height="18" border="0" style=" cursor:hand"></a></div></td>
        </tr>
        <tr>
          <td height="10" colspan="7" background="images/line1.gif"></td>
        </tr>
		<?php
	    	}
		   while($info=mysql_fetch_array($sql));
		 
		 }
		?>
		
    </table></td>
  </tr>
</table>
<?php
 include("bottom.php");
?>