<?php
 include("top.php");
?>
<table width="800" height="438" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" height="438" valign="top" bgcolor="#E8E8E8"><div align="center">
	<?php include("left.php");?>
    </div></td>
    <td width="10" background="images/line2.gif">&nbsp;</td>
    <td width="590" valign="top"><table width="550" height="15" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
      <table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="25" bgcolor="#555555"><div align="center" style="color: #FFFFFF">�ջ�����Ϣ</div></td>
        </tr>
        <tr>
          <td height="300" bgcolor="#555555"><table width="550" height="300" border="0" align="center" cellpadding="0" cellspacing="1">
           <script language="javascript">
		     function chkinput(form)
			 {
			   if(form.name.value=="")
			    {
				  alert("�������ջ�������!");
				  form.name.select();
				  return(false);
				
				}
				if(form.dz.value=="")
			    {
				  alert("�������ջ��˵�ַ!");
				  form.dz.select();
				  return(false);
				
				}
				if(form.yb.value=="")
			    {
				  alert("�������ջ����ʱ�!");
				  form.yb.select();
				  return(false);
				
				}
				if(form.tel.value=="")
			    {
				  alert("�������ջ�����ϵ�绰!");
				  form.tel.select();
				  return(false);
				
				}
				if(form.email.value=="")
			    {
				  alert("�������ջ���E-mail��ַ!");
				  form.email.select();
				  return(false);
				
				}
				if(form.email.value.indexOf("@")<0)
				 {
				    alert("�ջ���E-mail��ַ��ʽ�������!");
				    form.email.select();
				    return(false);
				 
				 }
				return(true);
			 
			 }
		   
		   </script>
		   <form name="form1" method="post" action="savedd.php" onSubmit="return chkinput(this)">
		    <tr>
              <td width="100" height="25" bgcolor="#FFFFFF"><div align="center">�ջ���������</div></td>
              <td width="183" bgcolor="#FFFFFF"><div align="left"><input type="text" name="name" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'"></div></td>
              <td width="86" bgcolor="#FFFFFF"><div align="center">�Ա�</div></td>
              <td width="176" bgcolor="#FFFFFF"><div align="left">
                <select name="sex">
                  <option selected value="��">��</option>
                  <option value="Ů">Ů</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td height="25" bgcolor="#FFFFFF"><div align="center">��ϸ��ַ��</div></td>
              <td height="25" colspan="3" bgcolor="#FFFFFF"><div align="left"><input name="dz" type="text" class="inputcss" id="dz" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'" size="25">
              </div></td>
            </tr>
            <tr>
              <td height="25" bgcolor="#FFFFFF"><div align="center">�������룺</div></td>
              <td height="25" colspan="3" bgcolor="#FFFFFF"><div align="left"><input type="text" name="yb" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'"></div></td>
            </tr>
            <tr>
              <td height="25" bgcolor="#FFFFFF"><div align="center">��ϵ�绰��</div></td>
              <td height="25" colspan="3" bgcolor="#FFFFFF"><div align="left"><input type="text" name="tel" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'"></div></td>
            </tr>
            <tr>
              <td height="25" bgcolor="#FFFFFF"><div align="center">�������䣺</div></td>
              <td height="25" colspan="3" bgcolor="#FFFFFF"><div align="left"><input type="text" name="email" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'"></div></td>
            </tr>
            <tr>
              <td height="25" bgcolor="#FFFFFF"><div align="center">�ͻ���ʽ��</div></td>
              <td height="25" colspan="3" bgcolor="#FFFFFF"><div align="left">
                <select name="shff" id="shff">
                  <option selected value="��ͨƽ��">��ͨƽ��</option>
                  <option value="�ؿ�ר��">�ؿ�ר��</option>
                  <option value="�ͻ�����">�ͻ�����</option>
                  <option value="�����ͻ�">�����ͻ�</option>
                  <option value="E-mail">E-mail</option>
                      </select>
</div></td>
            </tr>
            <tr>
              <td height="25" bgcolor="#FFFFFF"><div align="center">֧����ʽ��</div></td>
              <td height="25" colspan="3" bgcolor="#FFFFFF"><div align="left">
                <select name="zfff" id="zfff">
                  <option selected value="�������л��">�������л��</option>
                  <option value="��ͨ���л��">��ͨ���л��</option>
                  <option value="�ʾֻ��">�ʾֻ��</option>
                  <option value="����֧��">����֧��</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td height="100" bgcolor="#FFFFFF"><div align="center">�����ԣ�</div></td>
              <td height="100" colspan="3" bgcolor="#FFFFFF"><div align="left">
                <textarea name="ly" cols="60" rows="8" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'"></textarea>
</div></td>
            </tr>
            <tr>
              <td height="25" colspan="4" bgcolor="#FFFFFF"><div align="center"><input type="submit" value="�ύ����" class="buttoncss">
              </div></td>
            </tr>
			</form>
          </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
 include("bottom.php");
 if($_GET[dingdanhao]!="")
  {  $dd=$_GET[dingdanhao];
     session_start();
	 
     $array=explode("@",$_SESSION[producelist]);
	 $sum=count($array)*20+260;
    echo" <script language='javascript'>";
	echo" window.open('showdd.php?dd='+'".$dd."','newframe','top=150,left=200,width=600,height=".$sum.",menubar=no,toolbar=no,location=no,scrollbars=no,status=no ')";
	echo "</script>";

  }
?>