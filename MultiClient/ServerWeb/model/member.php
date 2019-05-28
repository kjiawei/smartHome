<?php
if (!defined('ROOT')) exit('SmartHome');
/*
 * 模块：用户相关
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
	public function onlogin () {
		include(TPL.'member_login.html');
	}
	//进行登录，检查用户名和密码
	public function oncheck () {
		$name=getgpc('name','P');
		$pwd=getgpc('password','P');
		// $pwd=pencode($pwd); 对密码进行加密运算，暂未使用
		if (empty($name) || empty($pwd)) redirect(lang('member','userpwd_empty'),'-1');
		$one=$this->sql->GetOne('select','user',array(row=>'*','where'=>array(array('name'=>'name','type'=>'eq','val'=>$name))));
		if ($one['password']==$pwd) { //登录成功
			$userid=$one['userid'];
			setcookie('smartid',$userid,time()+24*3600,'/');
			redirect(lang('member','login_success').'<br>Userid:'.$userid,'index.php?m=node&a=show');
		} else { //登录失败
			redirect(lang('member','login_fail'),'-1');
		}
	}
	//退出
	public function onloginout () {
		setcookie('smartid','out',time()-3600,'/');
		redirect(lang('member','login_out'),'index.php?m=member&a=login');
	}
	//emailuserid，暂未启用
	public function onemailuserid () {
		return FALSE;
		if (ispost()) {
			$email=getgpc('email','P');
			$userid=md5($email);
			$sql = sprintf("select * from alluser where email='%s'",$email);  
			if(mysql_num_rows($result)>0) {
			die("sorry the email has been used");
			}
			$sql = sprintf("insert into emailmd5 values('%s','%s')",$email,$userid);  
		} else {
			include(TPL.'member_emailuserid.html');
		}
	}
	//注册
	public function onregister () {
		return FALSE;
		if (ispost()) {
			$name=getgpc('name','P');
			$familyname=getgpc('familyname','P');
			$pwd=getgpc('password','P');
			$email=getgpc('email','P');
			// $pwd=pencode($pwd); 对密码进行加密运算，暂未使用
			if (empty($name) || empty($pwd) || empty($email)) redirect(lang('member','userpwd_empty'),'-1');
			if (!preg_match('/^[A-Za-z0-9_]+$/',$name) && strlen($name)>20) redirect(lang('member','reg_namefail'),'-1');
			if (!preg_match('/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/',$email)) redirect(lang('member','reg_emailfail'),'-1');
			$num=$this->sql->GetNum('user',array('row'=>'*','where'=>array(array('name'=>'name','type'=>'eq','va;'=>$name))));
			if ($num!=0) redirect(lang('member','reg_userexists'),'-1');
			$num=$this->sql->GetNum('user',array('row'=>'*','where'=>array(array('name'=>'email','type'=>'eq','va;'=>$email))));
			if ($num!=0) redirect(lang('member','reg_emailexists'),'-1');
			$this->sql->query('adduser','insert','user',array('insert'=>array('row'=>array('host','hostname','userid','name','password','email','nickname'),'val'=>array('false',$name,md5($email),$familyname,$pwd,$email,$familyname))));
			redirect(lang('common','ok'),'index.php?m=member&a=login');
		} else {
			include(TPL.'member_register.html');
		}
	}
}
?>