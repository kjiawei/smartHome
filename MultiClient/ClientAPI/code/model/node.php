<?php
if (!defined('ROOT')) exit('SmartHome');
/*
 * 模块：节点
 * @package Model
*/
class node extends base {
	static private $_instance=NULL;
	static public function getInstance () {
		if (!self::$_instance) self::$_instance=new self;
		return self::$_instance;
	}
	public function __construct () {
		parent::init();
	}
	//获取某一节点组下的所有节点
	public function ongetNodeByGroup () {
		global $isLogin,$uid;
		
	}
	//获取所有节点组
	public function ongetAllGroup () {
		global $isLogin,$uid;
		if (!$isLogin) return array('success'=>0,'errcode'=>1,'errmsg'=>'Auth is not exists');
		$this->sql->query('allgroup','select','nodegroup',array('row'=>'*'));
		$r=array('success'=>1,'group'=>$this->sql->GetAll('allgroup'));
		return $r;
	}
	//控制节点
	public function oncommand () {
		global $smartid;
		$id=intval(getgpc('id','P'));
		$command=getgpc('command','P');
		if (empty($id) || empty($command)) redirect(lang('node','command_inputerror'),'-1');
		$one=$this->sql->GetOne('select','node',array('row'=>'*','where'=>array(array('name'=>'id','type'=>'eq','val'=>$id))));
		if ($one['userid']!=$smartid) redirect(lang('common','ban'),'-1'); //节点非当前登录用户名下
		// $this->sql->query('command','update','node',array('update'=>array('')));
		// $credis_string=sprintf('exec/credis-php hset %s command %s',$nodeid,$command);
		// exec($credis_string);
		redirect(lang('node','command_ok'),'index.php?m=node&a=show');
	}
}
?>