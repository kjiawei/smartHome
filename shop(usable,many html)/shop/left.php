<?php if($username==""&&$password==""){?>
<table width="180" height="10" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="180" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" bgcolor="#555555"><div align="center" style="color: #FFFFFF">用户登录</div></td>
        </tr>
        <tr>
          <td height="100" bgcolor="#555555"><table width="180" height="100" border="0" align="center" cellpadding="0" cellspacing="1">
              <tr>
                <td bgcolor="#FFFFFF"><table width="180" height="100" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td><table width="180" border="0" cellpadding="0" cellspacing="0">
					  <script language="JavaScript" type="text/javascript">
					     function chkuserinput(form)
						 {
						   if(form.username.value=="")
                            {
							  alert("请输入用户名!");
							  form.username.select();
							  return(false);
							}		
							if(form.userpwd.value=="")
                            {
							  alert("请输入用户密码!");
							  form.userpwd.select();
							  return(false);
							}	
							if(form.yz.value=="")
                            {
							  alert("请输入验证码!");
							  form.yz.select();
							  return(false);
							}	
						   return(true);				 
						 }
					  
					  </script>
					  <script language="JavaScript" type="text/javascript">
					   function openfindpwd()
					   {
					    window.open("openfindpwd.php","newframe","left=200,top=200,width=200,height=100,menubar=no,toolbar=no,location=no,scrollbars=no,location=no");
					   
					   }
					  </script>
					     <form action="chkuser.php" method="post" name="form2" id="form2" onsubmit="return chkuserinput(this)">
                          <tr>
                            <td height="10" colspan="3">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="50" height="20"><div align="right">用户：</div></td>
                            <td height="20" colspan="2"><div align="left">
                                <input type="text" name="username" size="19" class="inputcss" style="background-color:#e8f4ff " onmouseover="this.style.backgroundColor='#ffffff'" onmouseout="this.style.backgroundColor='#e8f4ff'" />
                            </div></td>
                          </tr>
                          <tr>
                            <td height="20"><div align="right">密码：</div></td>
                            <td colspan="2"><div align="left">
                                <input type="password" name="userpwd" size="19" class="inputcss" style="background-color:#e8f4ff " onmouseover="this.style.backgroundColor='#ffffff'" onmouseout="this.style.backgroundColor='#e8f4ff'" />
                            </div></td>
                          </tr>
                          <tr>
                            <td height="20"><div align="right">验证：</div></td>
                            <td width="66" height="20"><div align="left">
                                <input type="text" name="yz" size="10" class="inputcss" style="background-color:#e8f4ff " onmouseover="this.style.backgroundColor='#ffffff'" onmouseout="this.style.backgroundColor='#e8f4ff'" />
                            </div></td>
                            <td width="64"><div align="left">
						&nbsp;<?php
							   $num=intval(mt_rand(1000,9999));
							   
							   for($i=0;$i<4;$i++)
							   {
							    echo "<img src=images/code/".substr(strval($num),$i,1).".gif>";
							   }
							?>
						    </div></td>
                          </tr>
                          <tr>
                            <td height="20" colspan="3">
						        <div align="right">
                                  <input type="hidden" value="<?php echo $num;?>" name="num" />
                                  <input type="submit" class="buttoncss" value="提交" />
&nbsp;<a href="agreereg.php">注册</a>&nbsp;<a href="javascript:openfindpwd()">找回密码</a></div></td></tr>
                          <tr>
                            <td height="10" colspan="3">&nbsp;</td>
                          </tr>
					    </form>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="180" height="10" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="180" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" bgcolor="#555555"><div align="center" style="color: #FFFFFF">本站公告</div></td>
        </tr>
        <tr>
          <td  bgcolor="#555555"><table width="180" height="30" border="0" align="center" cellpadding="0" cellspacing="1">
              <tr>
                <td bgcolor="#FFFFFF"><table width="180"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td><table width="180"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td height="5" colspan="3"></td>
                        </tr>
						<?php
						   
						 $sql=mysql_query("select * from gonggao order by time desc limit 0,5",$conn);
						 
						 $info=mysql_fetch_array($sql);
						 if($info==false)
						 {
						?>
                        <tr>
                          <td width="10" height="5">&nbsp;</td>
                          <td height="20" colspan="2"><div align="left">本站暂无公告!</div></td>
                        </tr>
						<?php
						 }
						 else
						 {
						   do{
						?>
						 <tr>
                          <td width="10" height="5"><div align="center">-</div></td>
                          <td width="109" height="20"><div align="left">
						  <a href="showgg.php?id=<?php echo $info[id];?>">
						  <?php 
						     echo substr($info[title],0,14);
						      if(strlen($info[title])>14)
							  {
							    echo "...";
							  } 
						   ?>
						   </a>
						  </div></td>
                          <td width="61"><div align="right"><?php echo $info[time];?></div></td>
						 </tr>
						<?php
						     }
						   while($info=mysql_fetch_array($sql));
						 }
						?>
                        <tr>
                          <td width="10" height="15">&nbsp;</td>
                          <td height="15" colspan="2"><div align="right" style=""><a href="showgonggao.php">更多&gt;&gt;</a></div></td>
                        </tr>
                        
                      </table></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
	  
	  <?php
}else{
?>
<table width="180" height="10" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="180" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" bgcolor="#555555"><div align="center" style="color: #FFFFFF">商品分类</div></td>
        </tr>
                 
  </table>
  <table width="180" border="0" cellpadding="1" cellspacing="1" >
  <?php	
  $type=mysql_query("select * from type where id");
  $info=mysql_fetch_object($type);
  if($type){
  do
	{
	?>
	<tr>
	<td bgcolor="#FFFFFF" align="center">
	<?php
  echo "<a href='showfenlei.php?id=".$info->id."'>".$info->typename." &nbsp;</a>"; 
  ?>
  </td>
  </tr>
  
  <?php }
  while ($info=mysql_fetch_object($type));
 
  }
  ?>
 
  </table>
  
  
  
  
  
  
      <table width="180" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" bgcolor="#555555"><div align="center" style="color: #FFFFFF">本站公告</div></td>
        </tr>
        <tr>
          <td  bgcolor="#555555"><table width="180" height="30" border="0" align="center" cellpadding="0" cellspacing="1">
              <tr>
                <td bgcolor="#FFFFFF"><table width="180"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td><table width="180"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td height="5" colspan="3"></td>
                        </tr>
						<?php
						   
						 $sql=mysql_query("select * from gonggao order by time desc limit 0,5",$conn);
						 
						 $info=mysql_fetch_array($sql);
						 if($info==false)
						 {
						?>
                        <tr>
                          <td width="10" height="5">&nbsp;</td>
                          <td height="20" colspan="2"><div align="left">本站暂无公告!</div></td>
                        </tr>
						<?php
						 }
						 else
						 {
						   do{
						?>
						 <tr>
                          <td width="10" height="5"><div align="center">-</div></td>
                          <td width="109" height="20"><div align="left">
						  <a href="showgg.php?id=<?php echo $info[id];?>">
						  <?php 
						     echo substr($info[title],0,14);
						      if(strlen($info[title])>14)
							  {
							    echo "...";
							  } 
						   ?>
						   </a>
						  </div></td>
                          <td width="61"><div align="right"><?php echo $info[time];?></div></td>
						 </tr>
						<?php
						     }
						   while($info=mysql_fetch_array($sql));
						 }
						?>
                        <tr>
                          <td width="10" height="15">&nbsp;</td>
                          <td height="15" colspan="2"><div align="right" style=""><a href="showgonggao.php">更多&gt;&gt;</a></div></td>
                        </tr>
                        
                      </table></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
	  <?php 
	  }
	  ?>

