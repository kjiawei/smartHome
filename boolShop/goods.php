<?php
/*
商品页
*/

define('ACC',true);
require('./include/init.php');

$goods_id = isset($_GET['goods_id'])?$_GET['goods_id']+0:0;  //判断是否传送了goods_id

//先查询商品信息
$goods = new GoodsModel();
$g = $goods->find($goods_id);
if(empty($g)){
	header('location: index.php');
	exit;
}
//展示

//找家谱树
$cat = new CatModel();
$nav = $cat->getTree($g['cat_id']);


include(ROOT . 'view/front/shangpin.html');