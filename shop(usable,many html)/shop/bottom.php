<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="10" colspan="10" background="images/line1.gif"></td>
  </tr>
  <tr bgcolor="#E8E8E8">
    <td width="65" height="20"><div align="center"><a href="showph.php">销售排行</a></div></td>
    <td width="74"><div align="center"><a href="shownew.php">最新商品</a></div></td>
    <td width="90"><div align="center"><a href="showtejia.php">特价商品</a></div></td>
    <td width="83"><div align="center"><a href="gwlc.php">购物流程</a></div></td>
    <td width="80"><div align="center">
	<a href='http://wpa.qq.com/msgrd?V=1&Uin=282915629&Site=在线咨询&Menu=no' title='在线即时交谈'>QQ帮助</a>
	</div></td>
    <td width="88"><div align="center"> <a href="showpl.php">商品评论</a></div></td>
	<td width="80"><div align="center"><a href="userleaveword.php">用户留言</a></div></td>
    <td width="80"><div align="center">
	<a href=# onClick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://www.yayar77.com');">设为首页</a>
	</div></td>
    <td width="80"><div align="center"><a href="javascript:window.external.addFavorite('http://www.mingrisoft.com/about.asp','吉林明日科技有限公司');">加入收藏</a></div></td>
    <td width="80"><div align="center"><a href="mailto:yayar77@126.com">联系我们</a></div></td>
    
  </tr>
  <tr >
    <td height="10" colspan="10" background="images/line1.gif"><div align="center"></div></td>
  </tr>
  <tr>
    <td height="50" colspan="10"><div align="center"><br>
    『网上商城系统』 Powered by &nbsp;<a href="http://user.qzone.qq.com/282915629">王志宇</a><br>
    <br>
    您是本站第&nbsp;
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
 &nbsp;位访客</div></td>
  </tr>
</table>
<?php
  include("endconn.php");
?>
</body>
</html>
