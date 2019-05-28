<?php


class CatModel extends Model{
    protected $table = 'category';

    /*
        你给我一个关键数组,键->表中的列,值-->表中的值,
        add()函数自动插入该行数据
    */
    public function add($data) {
        return $this->db->autoExecute($this->table,$data);
    }


    // 获取本表下面所有的数据
    public function select() {
        $sql = 'select cat_id,cat_name,parent_id from ' .  $this->table;
        return $this->db->getAll($sql);
    }

    // 根据主键 取出一行数据
    public function find($cat_id) {
        $sql = 'select * from category where cat_id=' . $cat_id;
        return $this->db->getRow($sql);
    }

    /*
        getCatTree
        pram: int $id
        return $id栏目的子孙树
    */
    public function getCatTree($arr,$id = 0,$lev=0) {
        $tree = array();

        foreach($arr as $v) {
            if($v['parent_id'] == $id) {
                $v['lev'] = $lev;
                $tree[] = $v;

                $tree = array_merge($tree,$this->getCatTree($arr,$v['cat_id'],$lev+1));
            }
        }

        return $tree;
    }

    /*
        parm: int $id
        return $id栏目下的子栏目
    */
    public function getSon($id) {
        $sql = 'select cat_id,cat_name,parent_id from ' . $this->table . ' where parent_id=' . $id;

        return $this->db->getAll($sql);
    }

    /*
        parm: int $id
        return array $id栏目的家谱树

        封装一个参数
    */
    public function getTree($id=0) {
        $tree = array();
        $cats = $this->select();
        
        while($id>0) {
            foreach($cats as $v) {
                if($v['cat_id'] == $id) {
                    $tree[] = $v;
                    
                    $id = $v['parent_id'];
                    break;
                }
            }
        }

        return array_reverse($tree);

    }

    // 删除栏目
    public function delete($cat_id=0) {
        $sql = 'delete from ' . $this->table . ' where cat_id=' . $cat_id;
        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    // 
    public function update($data,$cat_id=0) {
        $this->db->autoExecute($this->table,$data,'update',' where cat_id=' . $cat_id);
        return $this->db->affected_rows();
    }
}
