<?php

$username=$_POST[username];
$userpwd=md5($_POST[userpwd]);
$yz=$_POST[yz];
$num=$_POST[num];
if(strval($yz)!=strval($num))
 {
  echo "<script>alert('��֤���������!');history.go(-1);</script>";
  exit;
 }
class chkinput
 {
   var $name;
   var $pwd;
  

   function chkinput($x,$y)
    {
     $this->name=$x;
     $this->pwd=$y;
    }


   function checkinput()
   {
     include("conn.php");
     $sql=mysql_query("select * from user where name='".$this->name."'",$conn);
     $info=mysql_fetch_array($sql);
     if($info==false)
       {
          echo "<script language='javascript'>alert('�����ڴ��û���');history.back();</script>";
          exit;
       }
      else
       {
	      if($info[dongjie]==1)
		    {
			   echo "<script language='javascript'>alert('���û��Ѿ������ᣡ');history.back();</script>";
               exit;
			
			}
          
          if($info[pwd]==$this->pwd)
            {  $lastlogintime=date("Y-m-j"); 
			   mysql_query("update user set lastlogintime=''$lastlogintime",$conn);
			   session_start();
	           session_register("username");
	           $username=$name;
			   session_register("producelist");
			   $producelist="";
			   session_register("quatity");
			    $quatity="";
			   
               echo "<script>alert('��¼�ɹ�!');window.location='index.php';</script>";
               exit;
            }
          else
           {
             echo "<script language='javascript'>alert('�����������');history.back();</script>";
             exit;
           }

      }    
   }
 }


    $obj=new chkinput(trim($username),trim($userpwd));
    $obj->checkinput();

?>