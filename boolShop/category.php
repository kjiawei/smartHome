<?php
/*
栏目页
*/

define('ACC',true);
require('./include/init.php');

//得到id
$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']+0:0;
//接收page
$page = isset($_GET['page'])?$_GET['page']+0:1;
//判断page
if($page < 1){
	$page = 1;
}


//取出总条目
$goodsModel = new GoodsModel();
$total = $goodsModel->catGoodsCount($cat_id);

//每页取两条
$perpage = 2;
if($page > ceil($total/$perpage)){
	$page = 1;
}
$offset = ($page-1)*$perpage;

$pagetool = new PageTool($total,$page,$perpage);
$pagecode = $pagetool->show();


//判断id是否存在
$cat = new CatModel();
$category = $cat->find($cat_id);
if(empty($category)){
	header('location: index.php');
	exit;
}

/*
取出树状导航
*/
$cats = $cat->select();  //获取所有的栏目
$sort = $cat->getCatTree($cats,0,1);  //调用，排序并列出


/*
取出面包屑导航
*/
$nav = $cat->getTree($cat_id);  //调用


/*
取出栏目下的商品
*/
//实例化
$goods = new GoodsModel();
$goodslist = $goods->catGoods($cat_id,$offset,$perpage);


include(ROOT . 'view/front/lanmu.html');