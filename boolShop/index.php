<?php
/*
首页
*/

define('ACC',true);
require('./include/init.php');


//判断是否已经登陆

//取出新品
$goods = new GoodsModel();
$newlist=$goods->getNew(5);

//取出指定栏目的商品
//女士大栏目下的商品
$female_id = 4;
$felist = $goods->catGoods($female_id);

//男士大栏目下的商品





include(ROOT . 'view/front/index.html');