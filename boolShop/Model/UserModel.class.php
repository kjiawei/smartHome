<?php

/*
user的model类
*/

defined('ACC')||exit('ACC Denied');
header('content-type:text/html;charset=utf-8');

class UserModel extends Model{
    protected $table = 'user';
    protected $pk = 'user_id';
    protected $fields = array('user_id','username','email','passwd','regtime','lastlogin');
    

    //验证规则
    protected $_valid = array(
        array('username',1,'用户名必须存在','require'),
        array('username',0,'用户名必须在4-16字符内','length','4,16'),
        array('email',1,'email格式错误','email'),
        array('passwd',1,'passwd不能为空','require')
    );

    //自动填充规则
    protected $_auto = array(
        
        array('regtime','function','time')
                            );
    /*
    用户注册
    */
    public function reg($data){
        if($data['passwd']){
            $data['passwd'] = $this->encPasswd($data['passwd']);  //如果传过来的数组有passwd,调用自身encPasswd方法加密，覆盖原值
            return $this->add($data);
        }
    }

    //对密码加密
    protected function encPasswd($p){
        return md5($p);
    }

    /*
    对用户名不能重名

    根据用户名查询用户信息
    */
    public function checkUser($username,$passwd=''){
        if($passwd == ''){
            $sql = 'select count(*) from '.$this->table." where username='".$username."'";
            return $this->db->getOne($sql);
        }else{
            $sql = "select user_id,username,email,passwd from ".$this->table." where username='".$username."'";
            $row = $this->db->getRow($sql);

            //比较用户名和密码
            if(empty($row)){  //用户名不存在
                return false;
            }
            if($row['passwd'] != $this->encPasswd($passwd)){  //用户名存在，密码不匹配
                return false;
            }
            unset($row['passwd']);  //去除密码
            return $row;
        }
    }



}