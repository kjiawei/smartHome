
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������ѯ</title>
<link rel="stylesheet" type="text/css" href="css/font.css">
</head>
<?php
  include("conn.php");
?>
<body topmargin="0" leftmargin="0" bottommargin="0">
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" bgcolor="#555555"><div align="center" style="color: #FFFFFF">������ѯ</div></td>
        </tr>
        <tr>
          <td height="50" bgcolor="#555555"><table width="550" height="50" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td bgcolor="#FFFFFF">
			  <table width="550" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
			   <script language="javascript">
			     function chkinput3(form)
				 {
				   if((form.username.value=="")&&(form.ddh.value==""))
				    {
				      alert("�������¶����˻򶩵���");
					  form.username.select();
					  return(false);
				    }
				   return(true);
				    
				 }
			   </script>
                <form name="form3" method="post" action="finddd.php" onSubmit="return chkinput3( this)">
				<tr>
                  <td height="25"><div align="center">�¶���������:<input type="text" name="username" class="inputcss" size="25" >
                    ������:<input type="text" name="ddh" size="25" class="inputcss" ></div></td>
                </tr>
                <tr>
                  <td height="25">
                    <div align="center">
					    <input type="hidden" value="show_find" name="show_find">
                        <input type="submit" value="�� ��" class="buttoncss">
                    </div></td>
                </tr>
			    </form>
              </table></td>
            </tr>
          </table></td>
        </tr>
</table>
      <table width="550" height="20" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
	  <?php
	    if($_POST[show_find]!="")
		 {
	      $username=trim($_POST[username]);
		  $ddh=trim($_POST[ddh]);
		  if($username=="")
		   {
		       $sql=mysql_query("select * from dingdan where dingdanhao='".$ddh."'",$conn);
		   }
		  elseif($ddh=="")
		  {
		      $sql=mysql_query("select * from dingdan where xiadanren='".$username."'",$conn);
		   }
		  else
		  {
		      $sql=mysql_query("select * from dingdan where xiadanren='".$username."'and dingdanhao='".$ddh."'",$conn);
		  }
		  $info=mysql_fetch_array($sql);
		  if($info==false)
		   {
		      echo "<div algin='center'>�Բ���,û�в��ҵ��ö���!</div>";    
		   }
		   else
		   {
	  ?>
	  <table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="20" bgcolor="#555555"><div align="center" style="color: #FFFFFF">��ѯ���</div></td>
        </tr>
        <tr>
          <td height="50" bgcolor="#555555"><table width="550" height="50" border="0" align="center" cellpadding="0" cellspacing="1">
            <tr>
              <td width="77" height="25" bgcolor="#FFFFFF"><div align="center">������</div></td>
              <td width="77" bgcolor="#FFFFFF"><div align="center">�µ��û�</div></td>
              <td width="77" bgcolor="#FFFFFF"><div align="center">������</div></td>
              <td width="77" bgcolor="#FFFFFF"><div align="center">����ܼ�</div></td>
              <td width="77" bgcolor="#FFFFFF"><div align="center">���ʽ</div></td>
              <td width="77" bgcolor="#FFFFFF"><div align="center">�տʽ</div></td>
              <td width="77" bgcolor="#FFFFFF"><div align="center">����״̬</div></td>
            </tr>
			<?php
			
			  do
			  {
			
			?>
            <tr>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info[dingdanhao];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info[xiadanren];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info[shouhuoren];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info[total];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info[zfff];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info[shff];?></div></td>
              <td height="25" bgcolor="#FFFFFF"><div align="center"><?php echo $info[zt];?></div></td>
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

</body>
</html>
