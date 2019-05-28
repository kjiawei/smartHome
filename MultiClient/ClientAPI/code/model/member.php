<?php
if (!defined('ROOT')) exit('SmartHome');
/*
 * ģ�飺�û����
 * @package Model
*/
class member extends base {
	static private $_instance=NULL;
	static public function getInstance () {
		if (!self::$_instance) self::$_instance=new self;
		return self::$_instance;
	}
	public function __construct () {
		parent::init();
	}
	//���е�¼������û���������
	public function onlogin () {
		$user=getgpc('user','P');
		$pwd=getgpc('password','P');
		$pwd=pwdcode($pwd); //��������м�������
		if (empty($user) || empty($pwd)) return array('success'=>0,'errcode'=>100,'errmsg'=>'Parameter error');
		$one=$this->sql->GetOne('select','user',array(row=>'*','where'=>array(array('name'=>'name','type'=>'eq','val'=>$user))));
		if ($one===FALSE) return array('success'=>0,'errcode'=>2,'errmsg'=>'User not exists');
		if ($one['password']==$pwd) { //��¼�ɹ�������Auth
			$auth=join('|',array($one['id'],$ip=$_SERVER['REMOTE_ADDR'],$one['email'],microtime(TRUE)));
			$auth=md5($auth);
			$this->sql->query('addauth','insert','auth',array('insert'=>array('row'=>array('auth','uid','overdue'),'val'=>array($auth,$one['id'],date('Y-m-d',strtotime('+3 Month'))))));
			return array('success'=>1,'auth'=>$auth,'overdue'=>date('Y-m-d',strtotime('+3 Month')));
		} else { //��¼ʧ��
			return array('success'=>0,'errcode'=>1,'errmsg'=>'Wrong password');
		}
	}
	//��ȡ�û�������Ϣ
	public function onmyInfo () {
		global $isLogin,$uid;
		if (!$isLogin) return array('success'=>0,'errcode'=>1,'errmsg'=>'Auth is not exists');
		$user=$this->sql->GetOne('select','user',array('row'=>'*','where'=>array(array('name'=>'id','type'=>'eq','val'=>$uid))));
		$usertype=$user['type'];
		$usergroup=$this->sql->GetOne('select','usergroup',array('row'=>'*','where'=>array(array('name'=>'id','type'=>'eq','val'=>$usertype))));
		return array('success'=>1,'name'=>$user['name'],'group'=>$usertype,'isAdmin'=>intval($user['isAdmin']),'view'=>explode('|',trim($usergroup['view'],'|')),'control'=>explode('|',trim($usergroup['control'],'|')));
	}
}
?>