<?php

/*
购物车类

1、全局有效性：
   把购物车的信息放在数据库、session或cookie里
2、全局有效暗示购物车的实例只能有1个：
   单例模式

 总体：session+单例

 功能：
 判断商品是否存在
 添加商品
 删除商品
 修改商品数量
 
 某商品数量加1
 某商品数量减1

 查询购物车的商品种类
 查询购物车的商品数量
 查询购物车的总金额
 返回购物车里所有商品

 清空购物车

*/

defined('ACC') || exit('Acc Deined');

 class CartTool{
 	private static $ins = null;
 	private $items = array();  //存商品

 	final protected function __construct(){

 	}
 	final protected function __clone(){

 	}

 	//获取实例
 	protected static function getIns(){  //单例方法
 		if(!(self::$ins instanceof self)){  //如果自身的实例不是我的实例
 			self::$ins = new self();
 		}
 		return self::$ins;
 	}

 	//把单例对象放到session里
 	public static function getCart(){
 		if(!isset($_SESSION['cart']) || !($_SESSION['cart'] instanceof self)){
 			$_SESSION['cart'] = self::getIns();
 		}
 		return $_SESSION['cart'];
 	}

 	/*
 	加入功能
 	*/
 	//添加商品
 	public function addItem($id,$name,$price,$num=1){
 		
 		if($this->hasItem($id)){  //如果商品已经存在则直接加其数量
 			$this->incNum($id,$num);
 			return;
 		}


 		$item = array();
 		
 		$item['name'] = $name;
 		$item['price'] = $price;
 		$item['num'] = $num;

 		//将商品放入数组中,用id作为数组的下标
 		$this->items[$id] = $item;
 	}
 	
 	

 	//修改商品数量,num: 某个商品修改后的数量，直接把某商品的数量改为$num
 	public function modNum($id,$num=1){
 		if(!$this->hasItem($id)){  //调用hasItem方法判断不存在
 			return false;
 		}
 		$this->items[$id]['num'] = $num;  //此id下的num等于传过来的num
 	}

 	//商品添加或删除(改变数量为1)
 	public function incNum($id,$num=1){  //加
 		if($this->hasItem($id)){
 			$this->items[$id]['num']+=$num;
 		}
 	}
 	public function decNum($id,$num=1){  //减
 		if($this->hasItem($id)){
 			$this->items[$id]['num']-=$num;
 		}
 		//减少到0,则把商品从购物车移除
 		if($this->items[$id]['num']<1){
 			$this->delItem($id);
 		}
 	}

 	//判断某商品是否存在
 	public function hasItem($id){
 		return array_key_exists($id, $this->items);  //判断此id是否存在于数组中
 	}

 	//删除商品
 	public function delItem($id){
 		unset($this->items[$id]);
 	}




 	//查询商品种类
 	public function getCnt(){
 		return count($this->items);  //输出items数量
 	}

 	//查询商品个数
 	public function getNum(){
 		if($this->getCnt() == 0){
 			return 0;
 		}
 		$sum = 0;
 		foreach ($this->items as $item) {
 			$sum += $item['num'];
 		}
 		return $sum;
 	}

 	//查询商品总金额: 数量*单价
 	public function getPrice(){
 		if($this->getCnt() == 0){
 			return 0;
 		}
 		$price = 0;
 		foreach ($this->items as $item) {
 			$price += $item['num'] * $item['price'];
 		}
 		return $price;
 	}

 	//返回购物车所有商品
 	public function all(){
 		return $this->items;
 	}

 	//清空购物车,即将数组变空
 	public function clear(){
 		$this->items = array();
 	}
 }


/*
session_start();

$cart = CartTool::getCart();
if($_GET['test']=='add'){
	$cart->addItem(1,'1ffds',23,1);
	echo 'OK';
}else if($_GET['test']=='clear'){
	$cart->clear();
}else if($_GET['test']=='show'){
	print_r($cart->all());
	echo '<br>';
	echo '共'.$cart->getCnt().'种, '.$cart->getNum().'商品<br>';
	echo '共'.$cart->getPrice().'元';
}else{
	print_r($cart);
}
// print_r(CartTool::getCart());  //测试

*/


