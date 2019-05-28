<?php


defined('ACC')||exit('ACC Denied');

class GoodsModel extends Model{
    protected $table = 'goods';
    protected $pk = 'goods_id';
    protected $fields = array('goods_id','goods_sn','cat_id','brand_id','goods_name','shop_price','market_price','goods_number','click_count','goods_weight','goods_brief','goods_desc','thumb_img','goods_img','ori_img','is_on_sale','is_delete','is_best','is_new','is_hot','add_time','last_update');

    protected $_auto = array(
                            array('is_hot','value',0),
                            array('is_new','value',0),
                            array('is_best','value',0),
                            array('add_time','function','time')
                            );

    protected $_valid = array(
                            array('goods_name',1,'必须有商品名','require'),
                            array('cat_id',1,'栏目id必须是整型值','number'),
                            array('is_new',0,'is_new只能是0或1','in','0,1'),
                            array('goods_brief',2,'商品简介就在10到100字符','length','10,100')
    );


    /*
        作用:把商品放到回收站,即is_delete字段置为1
        parm int id
        return bool
    */
    public function trash($id) {
        return $this->update(array('is_delete'=>1),$id);
    }


    public function getGoods() {
        $sql = 'select * from goods where is_delete=0';
        return $this->db->getAll($sql);
    }

    public function getTrash() {
        $sql = 'select * from goods where is_delete=1';
        return $this->db->getAll($sql);
    }

    /*
    创建商品的货号

    利用递归生成随机不重复的随机货号
    **/
    public function createSn() {
        $sn = 'BL' . date('Ymd') . mt_rand(10000,99999);  //时间戳+随机数  生成随机货号

        $sql = 'select count(*) from ' . $this->table . " where goods_sn='" . $sn . "'";  //将sn拿到数据库查看，是否已经存在
        
        return $this->db->getOne($sql)?$this->createSn():$sn;  //如果sn已经存在再次调用自身(递归)
    }


    /*
    取出指定条数的新品
    */
    public function getNew($n=5) {
        $sql = 'select goods_id,goods_name,shop_price,market_price,thumb_img from ' . $this->table . ' order by add_time limit 5';

        return $this->db->getAll($sql);
    }


    /*
    取出指定栏目的商品
    */
    public function catGoods($cat_id,$offset=0,$limit=5){
        $category = new CatModel();
        $cats = $category->select();  //取出所有的栏目来
        $sons = $category->getCatTree($cats,$cat_id);  //取出子孙栏目

        $sub = array($cat_id);

        if(!empty($sons)) { // 没有子孙栏目
            foreach($sons as $v) {
                $sub[] = $v['cat_id'];
            }
        }
        $in = implode(',', $sub);

        $sql='select goods_id, goods_name,shop_price,market_price,thumb_img from '.$this->table.' where cat_id in ('.$in.') order by add_time limit '.$offset.','.$limit;

        return $this->db->getAll($sql);
    }


    /*
    取条数
    */
    public function catGoodsCount($cat_id){
        $category = new CatModel();
        $cats = $category->select();  //取出所有的栏目来
        $sons = $category->getCatTree($cats,$cat_id);  //取出子孙栏目

        $sub = array($cat_id);

        if(!empty($sons)) { // 没有子孙栏目
            foreach($sons as $v) {
                $sub[] = $v['cat_id'];
            }
        }
        $in = implode(',', $sub);

        $sql = 'select count(*) from goods where cat_id in ('.$in.')';
        return $this->db->getOne($sql);
    }


    /*
    获取购物车里商品的详细信息
    items为数组
    */
    public function getCartGoods($items) {
        foreach($items as $k=>$v) {  // 循环购物车中的商品,每循环一个,到数据查一下对应的详细信息

            $sql = 'select goods_id,goods_name,thumb_img,shop_price,market_price from ' . $this->table . ' where goods_id =' . $k;

            $row = $this->db->getRow($sql);

            $items[$k]['thumb_img'] = $row['thumb_img'];
            $items[$k]['market_price'] = $row['market_price'];
        
        }

        return $items;
       
    }

    

}

