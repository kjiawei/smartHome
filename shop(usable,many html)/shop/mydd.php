<?php
 include("top.php");
?>
<table width="800" height="438" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="208" height="438" valign="top" bgcolor="#E8E8E8"><div align="center">
	<?php include("left.php");?>
    </div></td>
    <td width="10" background="images/line2.gif">&nbsp;</td>
    <td width="585" valign="top">&nbsp;
       
      <table width="550" height="13" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="13">&nbsp;</td>
        </tr>
      </table>
	  <?php
	    if($_SESSION[username]=="")
		
		 {
   echo "<script>alert('����û�е�¼,���ȵ�¼!');history.back();</script>";
   exit;
  }
		  else
		  {
		  {
		      $sql=mysql_query("select * from dingdan where xiadanren='".$_SESSION[username]."'",$conn);
		  }
		  $info1=mysql_fetch_array($sql);
		  if($info1==false)
		   {
		      echo "<div algin='center'>�Բ���,�㻹δ�¶���!</div>";    
		   }
		   else
		   {
		   
	  ?>
	  <table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="25" bgcolor="#555555"><div align="center" style="color: #FFFFFF">��Ķ���</div></td>
        </tr>
        <tr>
          <td height="50" bgcolor="#555555"><table width="576" height="50" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td width="67" height="25" bgcolor="#FFFFFF"><div align="center">������</div></td>
              <td width="67" bgcolor="#FFFFFF"><div align="center">�µ��û�</div></td>
              <td width="67" bgcolor="#FFFFFF"><div align="center">�ջ���</div></td>
              <td width="67" bgcolor="#FFFFFF"><div align="center">����ܼ�</div></td>
              <td width="89" bgcolor="#FFFFFF"><div align="center">���ʽ</div></td>
              <td width="72" bgcolor="#FFFFFF"><div align="center">�տʽ</div></td>
              <td width="85" bgcolor="#FFFFFF"><div align="center">����״̬</div></td>
			  <td width="53" bgcolor="#FFFFFF"><div align="center">����</div></td>
            </tr>
			
			<?php
			
			  do
			  {
			$array=explode("@",$info1[spc]);
		      $sum=count($array)*20+260;
			?>
            <tr>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[dingdanhao];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[xiadanren];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[shouhuoren];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[total];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[zfff];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[shff];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info1[zt];?></div></td>
            <td height="25" bgcolor="#FFFFFF"><div align="center">
		    <input type="button" value="�鿴" onClick="javascript:window.open('admin/showdd?id=<?php echo $info1[id];?>','newframe','width=600,height=<?php echo $sum;?>,left=100,top=100,menubar=no,toolbar=no,location=no,scrollbars=no')" class="buttoncss">&nbsp;
		    </div></td>
			</tr>
		
			<?php
			   }while($info=mysql_fetch_array($sql));
			?>
          </table></td>
        </tr>
      </table>
	    <?php
		   }
		  }
		?>
</td>
  </tr>
</table>
</td>
  </tr>
</table>
<?php
 include("bottom.php");
?>