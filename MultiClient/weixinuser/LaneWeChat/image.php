<?php
namespace LaneWeChat;

//use LaneWeChat\Core\Wechat;
use LaneWeChat\Core\ResponseInitiative;
use LaneWeChat\Core\Media;


//引入配置文件
include_once __DIR__.'/config.php';
//引入自动载入函数
include_once __DIR__.'/autoloader.php';
//调用自动载入函数
AutoLoader::register();
$type='image';

echo "type is ".$type; 

 $tousername = "ojc-5s1P4gUzEAN1v-1-aAwopkb8";
 echo '<p>';
 echo "tousername is ".$tousername;   

//$menuId=Media::upload('/var/www/weixin/LaneWeChat/test.jpg', 'image');
//$menuId=Media::upload('./test.jpg', 'image');
$menuId=Media::upload('/var/www/weixinuser/upload/'.$filename, 'image');




//$menuId = \LaneWeChat\Core\Media::upload('/var/www/baidu_jgylogo3.jpg', 'image');
if (empty($menuId['media_id'])) {
    die('error');
}
$mediaId = $menuId['media_id'];
echo "mediaId is ".$mediaId;



try {   

	ResponseInitiative::image($tousername, $mediaId);

} catch (Exception $e) {  

echo "catch Exception";  
echo  $e->getMessage();    
}   
 
            echo "send message end";
			

