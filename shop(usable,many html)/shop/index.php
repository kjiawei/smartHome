<?php
 include("top.php");
?>
<table width="800" height="438" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" height="438" valign="top" bgcolor="#E8E8E8"><div align="center">
      <?php include("left.php");?>
    </div></td>
    <td width="10" background="images/line2.gif">&nbsp;</td>
    <td width="590" valign="top">
      
      <table width="556" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td  height="25"><img src="images/tjsp.gif" width="500" height="25"></td>
        </tr>
      </table>
      <table width="590" border="00" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="110"><table width="530" height="110" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="265">
			  <?php
			  $sql=mysql_query("select * from shangpin where tuijian=1 order by addtime desc limit 0,1");
			  $info=mysql_fetch_array($sql);
			  if($info==false)
			  {
			   echo "��վ�����Ƽ���Ʒ!";
			  }
			  else
			  {
			  ?>
			  <table width="255"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="130" rowspan="6"><div align="center">
				  <?php
				    if(trim($info[tupian]==""))
					{
					  echo "����ͼƬ";
					}
					else
					{
				  ?>
				    <img src="<?php echo $info[tupian];?>" width="130" height="100" border="0">
				  <?php
				     }
				  ?>
				  </div></td>
                  <td width="20" height="16">&nbsp;</td>
                  <td width="113"><font color="EF9C3E">��<?php echo $info[mingcheng];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="910800">���г��ۣ�<?php echo $info[shichangjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="DD4679">����Ա�ۣ�<?php echo $info[huiyuanjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="lookinfo.php?id=<?php echo $info[id];?>">�鿴��Ϣ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="addgouwuche.php?id=<?php echo $info[id];?>">���빺�ﳵ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="13589B">��ʣ��������
				  <?php 
				  if(($info[shuliang]-$info[cishu])>0)
				  {
				     echo ($info[shuliang]-$info[cishu]);
				  }
				  else
				  {
				     echo "������";
				  }
				  ?>��</font></td>
                </tr>
              </table>
			  <?php
			   }
			  ?>			  </td>
              <td width="265">
			  <?php
			  $sql=mysql_query("select * from shangpin where tuijian=1 order by addtime desc limit 1,1");
			  $info=mysql_fetch_array($sql);
			  if($info==true)
			  {
			  ?>
			    <table width="255"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="130" rowspan="6"><div align="center">
				  <?php
				    if(trim($info[tupian]==""))
					{
					  echo "����ͼƬ";
					}
					else
					{
				  ?>
				    <img src="<?php echo $info[tupian];?>" width="130" height="100" border="0">
				  <?php
				     }
				  ?>
				  </div></td>
                  <td width="20" height="16">&nbsp;</td>
                  <td width="113"><font color="EF9C3E">��<?php echo $info[mingcheng];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="910800">���г��ۣ�<?php echo $info[shichangjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="DD4679">����Ա�ۣ�<?php echo $info[huiyuanjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="lookinfo.php?id=<?php echo $info[id];?>">�鿴��Ϣ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="addgouwuche.php?id=<?php echo $info[id];?>">���빺�ﳵ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                      <td><font color="13589B">��ʣ��������
                        <?php 
				  if(($info[shuliang]-$info[cishu])>0)
				  {
				     echo ($info[shuliang]-$info[cishu]);
				  }
				  else
				  {
				     echo "������";
				  }
				  ?>��</font></td>
                </tr>
              </table>
			   <?php
			    }
			   ?>			  </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10" background="images/line1.gif"></td>
        </tr>
      </table>
      <table width="556" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="25"><img src="images/zxsp.gif" width="500" height="25"></td>
        </tr>
      </table>
      <table width="590" border="00" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="110"><table width="530" height="110" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="265">
			  <?php
			  $sql=mysql_query("select * from shangpin order by addtime desc limit 0,1");
			  $info=mysql_fetch_array($sql);
			  if($info==false)
			  {
			   echo "��վ�����Ƽ���Ʒ!";
			  }
			  else
			  {
			  ?>
			  <table width="255"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="130" rowspan="6"><div align="center">
				  <?php
				    if(trim($info[tupian]==""))
					{
					  echo "����ͼƬ";
					}
					else
					{
				  ?>
                  <img src="<?php echo $info[tupian];?>" width="130" height="100" border="0">                  <?php
				     }
				  ?>
				  </div></td>
                  <td width="20" height="16">&nbsp;</td>
                  <td width="113"><font color="EF9C3E">��<?php echo $info[mingcheng];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="910800">���г��ۣ�<?php echo $info[shichangjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="DD4679">����Ա�ۣ�<?php echo $info[huiyuanjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="lookinfo.php?id=<?php echo $info[id];?>">�鿴��Ϣ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="addgouwuche.php?id=<?php echo $info[id];?>">���빺�ﳵ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                      <td><font color="13589B">��ʣ��������
                        <?php 
				  if(($info[shuliang]-$info[cishu])>0)
				  {
				     echo ($info[shuliang]-$info[cishu]);
				  }
				  else
				  {
				     echo "������";
				  }
				  ?>��</font></td>
                </tr>
              </table>
			  <?php
			   }
			  ?>
			  </td>
              <td width="265">  <?php
			  $sql=mysql_query("select * from shangpin order by addtime desc limit 1,1");
			  $info=mysql_fetch_array($sql);
			  if($info==true)
		
			  {
			  ?>
			  <table width="255"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="130" rowspan="6"><div align="center">
				  <?php
				    if(trim($info[tupian]==""))
					{
					  echo "����ͼƬ";
					}
					else
					{
				  ?>
				    <img src="<?php echo $info[tupian];?>" width="130" height="100" border="0">
				  <?php
				     }
				  ?>
				  </div></td>
                  <td width="20" height="16">&nbsp;</td>
                  <td width="113"><font color="EF9C3E">��<?php echo $info[mingcheng];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="910800">���г��ۣ�<?php echo $info[shichangjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="DD4679">����Ա�ۣ�<?php echo $info[huiyuanjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="lookinfo.php?id=<?php echo $info[id];?>">�鿴��Ϣ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="addgouwuche.php?id=<?php echo $info[id];?>">���빺�ﳵ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                      <td><font color="13589B">��ʣ�������� 
                        <?php 
				  if(($info[shuliang]-$info[cishu])>0)
				  {
				     echo ($info[shuliang]-$info[cishu]);
				  }
				  else
				  {
				     echo "������";
				  }
				  ?>��</font></td>
                </tr>
              </table>
			  <?php
			   }
			  ?>			  </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10" background="images/line1.gif"></td>
        </tr>
      </table>
      <table width="556" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="25"><img src="images/rmsp.gif" width="500" height="25"></td>
        </tr>
      </table>
      <table width="590" border="00" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="110"><table width="530" height="110" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="265">
			 <?php
			  $sql=mysql_query("select * from shangpin order by cishu desc limit 0,1");
			  $info=mysql_fetch_array($sql);
			  if($info==false)
			  {
			   echo "��վ�����Ƽ���Ʒ!";
			  }
			  else
			  {
			  ?>
			  <table width="255"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="130" rowspan="6"><div align="center">
				  <?php
				    if(trim($info[tupian]==""))
					{
					  echo "����ͼƬ";
					}
					else
					{
				  ?>
				    <img src="<?php echo $info[tupian];?>" width="130" height="100" border="0">
				  <?php
				     }
				  ?>
				  
				  </div></td>
                  <td width="20" height="16">&nbsp;</td>
                  <td width="113"><font color="EF9C3E">��<?php echo $info[mingcheng];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="910800">���г��ۣ�<?php echo $info[shichangjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="DD4679">����Ա�ۣ�<?php echo $info[huiyuanjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="lookinfo.php?id=<?php echo $info[id];?>">�鿴��Ϣ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="addgouwuche.php?id=<?php echo $info[id];?>">���빺�ﳵ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                      <td><font color="13589B">��ʣ��������
                        <?php 
				  if(($info[shuliang]-$info[cishu])>0)
				  {
				     echo ($info[shuliang]-$info[cishu]);
				  }
				  else
				  {
				     echo "������";
				  }
				  ?>��</font></td>
                </tr>
              </table>
			  <?php
			   }
			  ?>			  </td>
              <td width="265">
			 <?php
			  $sql=mysql_query("select * from shangpin order by cishu desc limit 1,1 ");
			  $info=mysql_fetch_array($sql);
			  if($info==true)
			  
			  {
			  ?>
			  <table width="255"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="130" rowspan="6"><div align="center">
				  <?php
				    if(trim($info[tupian]==""))
					{
					  echo "����ͼƬ";
					}
					else
					{
				  ?>
                  <img src="<?php echo $info[tupian];?>" width="130" height="100" border="0">                  <?php
				     }
				  ?>
				  </div></td>
                  <td width="20" height="16">&nbsp;</td>
                  <td width="113"><font color="EF9C3E">��<?php echo $info[mingcheng];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="910800">���г��ۣ�<?php echo $info[shichangjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td><font color="DD4679">����Ա�ۣ�<?php echo $info[huiyuanjia];?>��</font></td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="lookinfo.php?id=<?php echo $info[id];?>">�鿴��Ϣ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                  <td>��<a href="addgouwuche.php?id=<?php echo $info[id];?>">���빺�ﳵ</a>��</td>
                </tr>
                <tr>
                  <td height="16">&nbsp;</td>
                      <td><font color="13589B">��ʣ��������
                        <?php 
				  if(($info[shuliang]-$info[cishu])>0)
				  {
				     echo ($info[shuliang]-$info[cishu]);
				  }
				  else
				  {
				     echo "������";
				  }
				  ?>��</font></td>
                </tr>
              </table>
			  <?php
			   }
			  ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10" background="images/line1.gif"></td>
        </tr>
      </table>
	 <table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="15" rowspan="2">&nbsp;</td>
          <td height="25" colspan="2"><div align="left"><img src="images/yqlj.gif" width="250" height="25"></div></td>
        </tr>
        <tr>
          <td width="22" height="50">&nbsp;</td>
          <td width="553"><table width="93%" border="0" cellpadding="0" cellspacing="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="65" rowspan="2" valign="top"><img src="images/1_1.gif" width="65" height="40"></td>
              <td width="75" height="21">
                <div align="center"><a href="http://user.qzone.qq.com/282915629">ѾѾ�ռ�</a> </div></td>
              <td width="75"><div align="center"><a href="http://www.163.com">����</a></div></td>
              <td width="75"><div align="center"> <a href="http://www.163.com">����</a> </div></td>
              <td width="75"><div align="center"><a href="http://www.163.com">����</a></div></td>
              <td width="75"><div align="center"><a href="http://http://www.163.com">����</a></div></td>
              <td width="75"><div align="center"><a href="http://www.163.com">����</a></div></td>
            </tr>
            <tr>
              <td height="18" valign="top"><div align="center"> <a href="http://user.qzone.qq.com/282915629">ѾѾ�ռ�</a> </div></td>
              <td valign="top"><div align="center"> <a href="http://user.qzone.qq.com/282915629">ѾѾ�ռ�</a><br>
              </div></td>
              <td valign="top"><div align="center"><a href="http://user.qzone.qq.com/282915629">ѾѾ�ռ�</a></div></td>
              <td valign="top">
                <div align="center"><a href="http://www.baidu.com">�ٶ�����</a> </div></td>
              <td valign="top"><div align="center"><a href="http://cn.yahoo.com">�Ż�</a></div></td>
              <td valign="top"><div align="center"><a href="http://www.hao123.com">��123</a></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10" colspan="3" background="images/line1.gif"></td>
        </tr>
      </table> </td>
  </tr>
</table>
<?php
 include("bottom.php");
?>