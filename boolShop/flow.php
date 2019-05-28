<?php

/*
购物流程页面

核心
*/

define('ACC',true);
require('./include/init.php');


// 设置一个动作参数,判断用户想干什么,比如是下订单/写地址/提交/清空购物车等
$act = isset($_GET['act'])?$_GET['act']:'buy';



$cart = CartTool::getCart(); // 获取购物车实例
$goods = new GoodsModel();

if($act == 'buy') { // 这是把商品加到购物车
    $goods_id = isset($_GET['goods_id'])?$_GET['goods_id']+0:0;
    $num = isset($_GET['num'])?$_GET['num']+0:1;

    if($goods_id) { // $goods_id为真,是想把商品放到购物车里
        $g = $goods->find($goods_id);
        if(!empty($g)) { // 有此商品


            // 需要判断此商品,是否在回收站
            // 此商品是否已下架
            if($g['is_delete'] == 1 || $g['is_on_sale'] == 0) {
                $msg = '此商品不能购买';
                include(ROOT . 'view/front/msg.html');
                exit;
            }

            // 先把商品加到购物车
            $cart->addItem($goods_id,$g['goods_name'],$g['shop_price'],$num);

            // 判断库存够不够
            $items = $cart->all();
            
            if($items[$goods_id]['num'] > $g['goods_number']) {
                // 库存不够了,把刚才加到购物车的动作撤回!
                $cart->decNum($goods_id,$num);
                
                $msg = '库存不足';
                include(ROOT . 'view/front/msg.html');
                exit;
            }

        }

        
        //print_r($cart->all());
    }

    $items = $cart->all();
    
    if(empty($items)) { // 如果购物车为空,返回首页
        header('location: index.php');
        exit;
    }

    // 把购物车里的商品详细信息取出来
    $items = $goods->getCartGoods($items);

    //print_r($items);exit;

    $total = $cart->getPrice(); //获取购物车中的商品总价格
    $market_total = 0.0;
    foreach($items as $v) {
        $market_total += $v['market_price'] * $v['num'];
    }

    $discount = $market_total - $total;
    $rate = round(100 * $discount/$total,2);

    include(ROOT . 'view/front/jiesuan.html');
} else if($act == 'clear') {
    $cart->clear();
    $msg = '购物车已清空';
    include(ROOT . 'view/front/msg.html');    
} else if($act == 'tijiao') {
    
    $items = $cart->all(); // 取出购物车中的商品

    // 把购物车里的商品详细信息取出来
    $items = $goods->getCartGoods($items);

    //print_r($items);exit;

    $total = $cart->getPrice(); //获取购物车中的商品总价格
    $market_total = 0.0;
    foreach($items as $v) {
        $market_total += $v['market_price'] * $v['num'];
    }

    $discount = $market_total - $total;
    $rate = round(100 * $discount/$total,2);


    include(ROOT . 'view/front/tijiao.html'); 
} else if($act == 'done') {
    /*
    订单入库, 最重要的一个环节
    
    从表单读取送货地址,手机等信息
    从购物车读取总价格信息,
    写入orderinfo表
    */




    //print_r($_POST);
    $OI = new OIModel();
    if(!$OI->_validate($_POST)) { // 如果数据检验没通过,报错退出.
        $msg = implode(',',$OI->getErr());
        include(ROOT . 'view/front/msg.html');
        exit;
    }

    
    // 自动过滤
    $data = $OI->_facade($_POST);

    // 自动填充
    $data = $OI->_autoFill($data);

    // 写入总金额
    $total = $data['order_amount'] = $cart->getPrice();

    // 写入用户名,从session读
    $data['user_id'] = isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
    $data['username'] = isset($_SESSION['username'])?$_SESSION['username']:'匿名';

    // 写入订单号
    $order_sn = $data['order_sn'] = $OI->orderSn();


    if(!$OI->add($data)) {
        $msg = '下订单失败';
        include(ROOT . 'view/front/msg.html');
        exit;
    }

    // 获取刚刚产生的order_id的值
    $order_id = $OI->insert_id();

    // echo '订单写入成功';

    /*
    要把订单的商品写入数据库
    1个订单里有N个商品,我们可以循环写入ordergoods表
    */
    $items = $cart->all(); // 返回订单中所有的商品
    $cnt = 0;  // cnt用来记录插入ordergoods成功的次数

    $OG = new OGModel(); // 获取ordergoods的操作model

    foreach($items as $k=>$v) {  // 循环订单中的商品,写入ordergoods表
        $data = array();
        
        $data['order_sn'] = $order_sn;
        $data['order_id'] = $order_id;
        $data['goods_id'] = $k;
        $data['goods_name'] = $v['name'];
        $data['goods_number'] = $v['num'];
        $data['shop_price'] = $v['price'];
        $data['subtotal'] = $v['price']*$v['num'];
        
        if($OG->addOG($data)) {
            $cnt += 1;  // 插入一条og成功,$cnt+1.
            // 因为,1个订单有N条商品,必须N条商品,都插入成功,才算订单插入成功!
        }
    }



    if(count($items) !== $cnt) { // 购物车里的商品数量,并没有全部入库成功.
        // 撤消此订单
        $OI->invoke($order_id);
        $msg = '下订单失败';
        include(ROOT . 'view/front/msg.html');
        exit;
    }


    // 下订单成功了
    // 清空购物车
    $cart->clear();


    /*
    计算在线支付的md5值
    */
    $v_url = 'http://localhost/boolshop/recive.php'; //回调地址
    $md5key= '#(%#WU)(UFGDKJGNDFG'; //md5加密密钥
    $v_md5info = md5($total . 'CNY' . $order_sn . '1009001' . $v_url . $md5key);
    $v_md5info = strtoupper($v_md5info);  //转换成大写



    include(ROOT . 'view/front/order.html');
}