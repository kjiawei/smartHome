 <?php
            echo "begin";
            include 'lanewechat/lanewechat.php';
            $menuList = array(
                array('id'=>'1', 'pid'=>'0', 'name'=>'我要提问', 'type'=>'', 'code'=>''),
                array('id'=>'2', 'pid'=>'0', 'name'=>'个人中心', 'type'=>'', 'code'=>''),
                array('id'=>'3', 'pid'=>'0', 'name'=>'大讲坛', 'type'=>'location_select', 'code'=>'key_7'),
                array('id'=>'4', 'pid'=>'1', 'name'=>'点击推事件', 'type'=>'click', 'code'=>'key_1'),
                array('id'=>'5', 'pid'=>'1', 'name'=>'跳转URL', 'type'=>'view', 'code'=>'http://www.lanecn.com/'),
                array('id'=>'6', 'pid'=>'2', 'name'=>'扫码推事件', 'type'=>'scancode_push', 'code'=>'key_2'),
                array('id'=>'7', 'pid'=>'2', 'name'=>'扫码等收消息', 'type'=>'scancode_waitmsg', 'code'=>'key_3'),
                array('id'=>'8', 'pid'=>'2', 'name'=>'系统拍照发图', 'type'=>'pic_sysphoto', 'code'=>'key_4'),
                array('id'=>'9', 'pid'=>'2', 'name'=>'弹拍照或相册', 'type'=>'pic_photo_or_album', 'code'=>'key_5'),
                array('id'=>'10', 'pid'=>'2', 'name'=>'弹微信相册', 'type'=>'pic_weixin', 'code'=>'key_6'),

            );
            echo "setmenu";
            $result = \LaneWeChat\Core\Menu::setMenu($menuList);
			

