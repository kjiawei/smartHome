<?php
 include("top.php");
?>
<script language="javascript">
  function chknc(nc)
  {
    window.open("chkusernc.php?nc="+nc,"newframe","width=200,height=10,left=500,top=200,menubar=no,toolbar=no,location=no,scrollbars=no,location=no");
  }
</script>
<script language="javascript">
  function chkinput(form)
  {
    if(form.usernc.value=="")
	{
	 alert("�������ǳ�!");
	 form.usernc.select();
	 return(false);
	}
	if(form.p1.value=="")
	{
	 alert("������ע������!");
	 form.p1.select();
	 return(false);
	}
    if(form.p2.value=="")
	{
	 alert("������ȷ������!");
	 form.p2.select();
	 return(false);
	 }	
	if(form.p1.value.length<6)
	 {
	 alert("ע�����볤��Ӧ����6!");
	 form.p1.select();
	 return(false);
	 }	
	if(form.p1.value!=form.p2.value)
	 {
	 alert("�������ظ����벻ͬ!");
	 form.p1.select();
	 return(false);
	 }
   if(form.email.value=="")
	{
	 alert("��������������ַ!");
	 form.email.select();
	 return(false);
	 }
	if(form.email.value.indexOf('@')<0)
	{
	 alert("��������ȷ�ĵ��������ַ!");
	 form.email.select();
	 return(false);
	 }
   if(form.tel.value=="")
	{
	 alert("��������ϵ�绰!");
	 form.tel.select();
	 return(false);
	 }
  if(form.truename.value=="")
	{
	 alert("��������ʵ����!");
	 form.truename.select();
	 return(false);
	 }
  if(form.sfzh.value=="")
	{
	 alert("���������֤��!");
	 form.sfzh.select();
	 return(false);
	 }
  if(form.dizhi.value=="")
	{
	 alert("�������ͥסַ!");
	 form.dizhi.select();
	 return(false);
	 }
  if(form.tsda.value=="")
	{
	 alert("����������ʾ��!");
	 form.tsda.select();
	 return(false);
	 }
   if((form.ts1.value==1)&&(form.ts2.value==""))	
     {
	 alert("��ѡ�������������ʾ��!");
	 form.ts2.select();
	 return(false);
	 }
   return(true);
  }
</script>
<table width="800" height="350" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" height="350" valign="top" bgcolor="#E8E8E8"><div align="center">
	<?php include("left.php");?>
    </div></td>
    <td width="10" background="images/line2.gif">&nbsp;</td>
    <td width="590" valign="top"><table width="500" height="15" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
      <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="25" bgcolor="#555555"><div align="center" style="color: #FFFFFF">�û�ע��</div></td>
        </tr>
        <tr>
          <td  bgcolor="#555555"><table width="500" border="0" align="center" cellpadding="0" cellspacing="1">
           <form name="form1" method="post" action="savereg.php" onSubmit="return chkinput(this)">
		    <tr>
              <td width="100" height="20" bgcolor="#FFFFFF"><div align="center">�û��ǳƣ�</div></td>
              <td width="397" bgcolor="#FFFFFF"><div align="left"><input type="text" name="usernc" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'">
                  <span style="color: #FF0000">&nbsp;*</span>&nbsp;
              <input type="button" value="�鿴�ǳ��Ƿ�����" class="buttoncss" onclick="chknc(form1.usernc.value)"></div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">ע�����룺</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="password" name="p1" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'">
                <span style="color: #FF0000">*</span></div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">ȷ�����룺</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="password" name="p2" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'">
                <span style="color: #FF0000">*</span></div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">E-mail��</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="email" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'">
                <span style="color: #FF0000">*</span></div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">QQ���룺</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="qq" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'"></div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">�������룺</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="yb" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'"></div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">��ϵ�绰��</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="tel" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'">
                <span style="color: #FF0000">(�ֻ���)*</span></div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">��ʵ������</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="truename" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'">
                <span style="color: #FF0000">*</span>              </div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">���֤�ţ�</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="sfzh" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'">
                <span style="color: #FF0000">*</span></div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">��ͥסַ��</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="dizhi" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'">
                <span style="color: #FF0000">*</span></div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">������ʾ��</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left">
                <select name="ts1" class="inputcss">
                  <option selected value=1>��ѡ������</option>
                  <option value="��������">��������</option>
                  <option value="��İ���">��İ���</option>
                  <option value="��ĸ�׵�����">��ĸ�׵�����</option>
                  <option value="�����׵�����">�����׵�����</option>
                  <option value="����ϲ���Ļ�">����ϲ���Ļ�</option>
                </select>
              &nbsp;&nbsp;����:&nbsp;&nbsp;<input type="text" name="ts2" class="inputcss" size="15" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'">
              <span style="color: #FF0000">*</span></div></td>
            </tr>
            <tr>
              <td height="20" bgcolor="#FFFFFF"><div align="center">��ʾ�𰸣�</div></td>
              <td height="20" bgcolor="#FFFFFF"><div align="left"><input type="text" name="tsda" size="25" class="inputcss" style="background-color:#e8f4ff " onMouseOver="this.style.backgroundColor='#ffffff'" onMouseOut="this.style.backgroundColor='#e8f4ff'">
                <span style="color: #FF0000">*</span></div></td>
            </tr>
            <tr>
              <td height="20" colspan="2" bgcolor="#FFFFFF"><div align="center"><input type="submit" value="�ύ" class="buttoncss">&nbsp;&nbsp;<input type="reset" value="��д" class="buttoncss"></div></td>
            </tr>
			</form>
          </table></td>
        </tr>
      </table>
      <table width="500" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><div align="center" style="color: #FF0000">ע�⣺��*Ϊ��������!</div></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
 include("bottom.php");
?>