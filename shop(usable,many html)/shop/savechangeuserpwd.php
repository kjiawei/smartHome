<?php
session_start();
$p1=md5(trim($_POST[p1]));
$p2=trim($_POST[p2]);

$name=$_SESSION[username];
class chkchange
   {
	   var $name;
	   var $p1;
	   var $p2;
	   function chkchange($x,$y,$z)
	    {
		  $this->name=$x;
		  $this->p1=$y;
		  $this->p2=$z;
		
		}
	   function changepwd()
	   {include("conn.php");
	    $sql=mysql_query("select * from user where name='".$this->name."'",$conn);
	    $info=mysql_fetch_array($sql);
		if($info[pwd]!=$this->p1)
		 {
		   echo "<script>alert('ԭ�����������!');history.back();</script>";
		   exit;
		 }
		 else
		 {
		   mysql_query("update user set pwd='".md5($this->p2)."' ,pwd1='$this->p2' where name='$this->name'",$conn);
		   echo "<script>alert('�����޸ĳɹ�!');history.back();</script>";
		   exit;
		 }
	   }
  }
 $obj=new chkchange($name,$p1,$p2); 
 $obj->changepwd() 
?>