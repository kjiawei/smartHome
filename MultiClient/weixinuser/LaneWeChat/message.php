<?php
namespace LaneWeChat;

//use LaneWeChat\Core\Wechat;
use LaneWeChat\Core\ResponseInitiative;

$message=$_GET["message"];
$openid=$_GET["openid"];

echo "lan openid is ".$openid.'  ';
echo " lan message is ".$message.'  ';


//引入配置文件
include_once __DIR__.'/config.php';
//引入自动载入函数
include_once __DIR__.'/autoloader.php';
//调用自动载入函数
AutoLoader::register();




 $tousername = "ojc-5s1P4gUzEAN1v-1-aAwopkb8";
 $tousername=$openid;
 echo "tousername is ".$tousername;   

try {   

ResponseInitiative::text($tousername, $message);

} catch (Exception $e) {  

echo "catch Exception";  
echo  $e->getMessage();    
}   

  echo "<br>";
    echo "getUserInfo";
$str = \LaneWeChat\Core\UserManage::getUserInfo($openid);
            echo "<br>";

            echo "get userinfo is :".$str;
            var_dump($str);
			

