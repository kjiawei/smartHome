<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="10" colspan="10" background="images/line1.gif"></td>
  </tr>
  <tr bgcolor="#E8E8E8">
    <td width="65" height="20"><div align="center"><a href="showph.php">��������</a></div></td>
    <td width="74"><div align="center"><a href="shownew.php">������Ʒ</a></div></td>
    <td width="90"><div align="center"><a href="showtejia.php">�ؼ���Ʒ</a></div></td>
    <td width="83"><div align="center"><a href="gwlc.php">��������</a></div></td>
    <td width="80"><div align="center">
	<a href='http://wpa.qq.com/msgrd?V=1&Uin=282915629&Site=������ѯ&Menu=no' title='���߼�ʱ��̸'>QQ����</a>
	</div></td>
    <td width="88"><div align="center"> <a href="showpl.php">��Ʒ����</a></div></td>
	<td width="80"><div align="center"><a href="userleaveword.php">�û�����</a></div></td>
    <td width="80"><div align="center">
	<a href=# onClick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://www.yayar77.com');">��Ϊ��ҳ</a>
	</div></td>
    <td width="80"><div align="center"><a href="javascript:window.external.addFavorite('http://www.mingrisoft.com/about.asp','�������տƼ����޹�˾');">�����ղ�</a></div></td>
    <td width="80"><div align="center"><a href="mailto:yayar77@126.com">��ϵ����</a></div></td>
    
  </tr>
  <tr >
    <td height="10" colspan="10" background="images/line1.gif"><div align="center"></div></td>
  </tr>
  <tr>
    <td height="50" colspan="10"><div align="center"><br>
    �������̳�ϵͳ�� Powered by &nbsp;<a href="http://user.qzone.qq.com/282915629">��־��</a><br>
    <br>
    ���Ǳ�վ��&nbsp;
<?php
  $countfile="count.txt";
   if(!file_exists($countfile))
	{
	 exec("echo 0 > $countfile");
	} 
 function displaycount($countfile)
  {
  include("conn.php");
  $fp=fopen($countfile,"rw");
  $sum=fgets($fp,5);
  $ip=getenv("REMOTE_ADDR");
  $sql=mysql_query("select * from ip where ip='".$ip."'",$conn);
  $info=mysql_fetch_array($sql);
  if($info==false)
  { 
     mysql_query("insert into ip(ip) values ('$ip')",$conn);
	 $sum+=1;
  }	 
	 
	 echo $sum;
	 
	 exec("rm -rf $countfile");
	 exec("echo $sum > $countfile");
   }
   
   displaycount($countfile);
 

?>
 &nbsp;λ�ÿ�</div></td>
  </tr>
</table>
<?php
  include("endconn.php");
?>
</body>
</html>
