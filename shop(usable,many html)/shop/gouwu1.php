<?php
 session_start();
 if($_SESSION[username]=="")
  {
    echo "<script>alert('���ȵ�¼������!');history.back();</script>";
	exit;
  }
  
?>
<?php
 include("top.php");
?>
<table width="800" height="438" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" height="438" valign="top" bgcolor="#E8E8E8"><div align="center">
	<?php include("left.php");?>
    </div></td>
    <td width="10" background="images/line2.gif">&nbsp;</td>
    <td width="590" valign="top"><table width="550" height="10" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
      <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
        <form name="form1" method="post" action="gouwu1.php">
          <tr>
            <td height="25" bgcolor="#555555"><div align="center" style="color: #FFFFFF"><?php echo $_SESSION[username];?>�Ĺ��ﳵ</div></td>
          </tr>
          <tr>
            <td  bgcolor="#555555"><table width="500" border="0" align="center" cellpadding="0" cellspacing="1">
                <?php
		 
			  session_start();
			  session_register("total");
			  if($_GET[qk]=="yes")
			  {
			     $_SESSION[producelist]="";
				 $_SESSION[quatity]=""; 
			  }
			   $arraygwc=explode("@",$_SESSION[producelist]);
			   $s=0;
			   for($i=0;$i<count($arraygwc);$i++)
			   {
			       $s+=intval($arraygwc[$i]);
			   }
			  if($s==0 )
			    {
				   echo "<tr>";
                   echo" <td height='25' colspan='6' bgcolor='#FFFFFF' align='center'>���Ĺ��ﳵΪ��!</td>";
                   echo"</tr>";
				}
			  else
			   { 
			?>
                <tr>
                  <td width="125" height="25" bgcolor="#FFFFFF"><div align="center">��Ʒ����</div></td>
                  <td width="52" bgcolor="#FFFFFF"><div align="center">����</div></td>
                  <td width="64" bgcolor="#FFFFFF"><div align="center">�г���</div></td>
                  <td width="64" bgcolor="#FFFFFF"><div align="center">��Ա��</div></td>
                  <td width="51" bgcolor="#FFFFFF"><div align="center">�ۿ�</div></td>
                  <td width="66" bgcolor="#FFFFFF"><div align="center">С��</div></td>
                  <td width="71" bgcolor="#FFFFFF"><div align="center">����</div></td>
                </tr>
                <?php
			    $total=0;
			    $array=explode("@",$_SESSION[producelist]);
				$arrayquatity=explode("@",$_SESSION[quatity]);
				
				
				
				
				 while(list($name,$value)=each($_POST))
				    {
					  for($i=0;$i<count($array)-1;$i++)
					  {
					    if(($array[$i])==$name)
						{
						  $arrayquatity[$i]=$value;  
						}
					  }
					  
					}
				  
			    $_SESSION[quatity]=implode("@",$arrayquatity);
				
				
				for($i=0;$i<count($array)-1;$i++)
				 { 
				 
				   $id=$array[$i];
				   $num=$arrayquatity[$i];
				  
				  if($id!="")
				   {
				   $sql=mysql_query("select * from shangpin where id='".$id."'",$conn);
				   $info=mysql_fetch_array($sql);
				   $total1=$num*$info[huiyuanjia];
				   $total+=$total1;
				   $_SESSION["total"]=$total;
			?>
                <tr>
                  <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info[mingcheng];?></div></td>
                  <td height="25" bgcolor="#FFFFFF"><div align="center">
                      <input type="text" name="<?php echo $info[id];?>" size="2" class="inputcss" value=<?php echo $num;?>>
                  </div></td>
                  <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info[shichangjia];?>Ԫ</div></td>
                  <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info[huiyuanjia];?>Ԫ</div></td>
                  <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo @(ceil(($info[huiyuanjia]/$info[shichangjia])*100))."%";?></div></td>
                  <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info[huiyuanjia]*$num."Ԫ";?></div></td>
                  <td height="25" bgcolor="#FFFFFF"><div align="center"><a href="removegwc.php?id=<?php echo $info[id]?>">�Ƴ�</a></div></td>
                </tr>
                <?php
			      
			      }
				 }
			 ?>
                <tr>
                  <td height="25" colspan="8" bgcolor="#FFFFFF"><div align="right">
                      <table width="500" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="125"><div align="center">
                              <input type="submit" value="������Ʒ����" class="buttoncss">
                          </div></td>
                          <td width="125"><div align="center"><a href="gouwu2.php">ȥ����̨</a></div></td>
                          <td width="125"><div align="center"><a href="gouwu1.php?qk=yes">��չ��ﳵ</a></div></td>
                          <td width="125"><div align="left">�ܼƣ�<?php echo $total;?></div></td>
                        </tr>
                      </table>
                  </div></td>
                </tr>
                <?php
			 }
			?>
            </table></td>
          </tr>
        </form>
    </table></td>
  </tr>
</table>
<?php
 include("bottom.php");
?>