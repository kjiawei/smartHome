<?php
 session_start();
 if($_SESSION[username]=="")
 {
   echo "<script>alert('您还没有登录,请先登录!');history.back();</script>";
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
    <td width="590" valign="top"><table width="500" height="10" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td></td>
      </tr>
    </table>
      <table width="550" height="20" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><div align="left">当前用户&nbsp;<span style="color: #0000FF">》&nbsp;</span><?php echo $_SESSION[username];?>&nbsp;<span style="color: #0000FF">》</span><a href="usercenter.php">修改个人信息</a>&nbsp;<span style="color: #0000FF">》</span><a href="userleaveword.php">用户留言</a>&nbsp;<span style="color: #0000FF">》</span><a href="changeuserpwd.php">修改密码</a>&nbsp;<span style="color: #0000FF">》</span><a href="logout.php">注销离开&nbsp;</a></div></td>
        </tr>
      </table>
      <table width="500" height="10" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" bgcolor="#555555"><div align="center" style="color: #FFFFFF"><?php echo $_SESSION[username];?>的所有信息</div></td>
        </tr>
        <tr>
          <td height="160" bgcolor="#555555"><table width="500" height="160" border="0" align="center" cellpadding="0" cellspacing="1">
		  <script language="javascript">
		     function chkinput1(form)
			  {
			    if(form.email.value=="")
				{
				  alert("电子邮箱不能为空!");
				  form.email.select();
				  return(false);
				}
				if(form.email.value.indexOf('@')<0)
				{
				  alert("电子邮箱输入错误!");
				  form.email.select();
				  return(false);
				}
				if(form.truename.value=="")
				{
				  alert("真实姓名不能为空!");
				  form.truename.select();
				  return(false);
				}
				if(form.sfzh.value=="")
				{
				  alert("身份证号不能为空!");
				  form.sfzh.select();
				  return(false);
				}
				if(form.tel.value=="")
				{
				  alert("联系电话不能为空!");
				  form.tel.select();
				  return(false);
				} 
				if(form.dizhi.value=="")
				{
				  alert("联系地址不能为空!");
				  form.dizhi.select();
				  return(false);
				}         
			   
				return(true);
			  }
		   </script>
		  <form name="form1" method="post" action="changeuser.php" onSubmit="return chkinput1(this)">
		  <?php
		   $sql=mysql_query("select * from user where name='".$_SESSION[username]."'",$conn);
		   $info=mysql_fetch_array($sql);
		  
		  ?>
            <tr>
              <td width="100" height="20" bgcolor="#FFFFFF"><div align="center">昵称：</div></td>
              <td width="397" bgcolor="#FFFFFF"><div align="left"><?php echo $_SESSION[username];?></div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">真实姓名：</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="truename" size="25" class="inputcssnull" value="<?php echo $info[truename];?>">
              *</div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">E-mail：</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="email" size="25" class="inputcssnull" value="<?php echo $info[email];?>">
              *</div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">QQ号码：</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="qq" size="25" class="inputcssnull" value="<?php echo $info[qq];?>">
              *</div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">联系电话：</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="tel" size="25" class="inputcssnull" value="<?php echo $info[tel];?>">
              *</div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">家庭住址：</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="dizhi" size="25" class="inputcssnull" value="<?php echo $info[dizhi];?>">
              *</div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">邮政编码：</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="youbian" size="25" class="inputcssnull" value="<?php echo $info[youbian];?>">
              *</div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">身份证号：</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="sfzh" size="25" class="inputcssnull" value="<?php echo $info[sfzh];?>">
              *</div></td>
            </tr>
			<tr>
              <td height="20" colspan="2" bgcolor="#FFFFFF"><div align="center"><input type="submit" value="更改" class="buttoncss">&nbsp;&nbsp;<input type="reset" value="取消更改" class="buttoncss"></div></td>
            </tr>
			</form>
          </table></td>
        </tr>
      </table>
      <table width="500" height="20" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><div align="center" style="color: #0000FF">带*的为可修改项</div></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
 include("bottom.php");
?>