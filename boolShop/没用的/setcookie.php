<?php

/*
setcookie()函数
第1个参数：cookie名
第2个参数：cookie值
*/

setcookie('age',22);  //重启浏览器后就销毁了

/*
让cookie延长有效期
用第3参数设置，第3个参数就是cookie的生命周期
已时间戳为单位
*/

setcookie('school','XTU',time()+15);  //到生命周期后销毁

//第4个路径来指定cookie有效路径
setcookie('school','kefeng',time()+5,'/');

//cookie不能跨域名，用地5个参数来让其在二级域名下使用

echo 'cookie set ok';