<?php
if (!defined('ROOT')) exit('SmartHome');
/*
 * ģ�飺�ڵ�
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
	//��ʾ���нڵ�
	public function onshow () {
		$userid=getgpc('smartid','C');
		$this->sql->query('node','select','node',array('row'=>'*','where'=>array(array('name'=>'userid','type'=>'eq','val'=>$userid))));
		$this->view->set('node',$this->sql->GetAll('node'));
		include(TPL.'node_show.html');
	}
	//���ƽڵ�
	public function oncommand () {
		global $smartid;
		$id=intval(getgpc('id','P'));
		$command=getgpc('command','P');
		if (empty($id) || empty($command)) redirect(lang('node','command_inputerror'),'-1');
		$one=$this->sql->GetOne('select','node',array('row'=>'*','where'=>array(array('name'=>'id','type'=>'eq','val'=>$id))));
		if ($one['userid']!=$smartid) redirect(lang('common','ban'),'-1'); //�ڵ�ǵ�ǰ��¼�û�����
		// $this->sql->query('command','update','node',array('update'=>array('')));
		// $credis_string=sprintf('exec/credis-php hset %s command %s',$nodeid,$command);
		// exec($credis_string);
		redirect(lang('node','command_ok'),'index.php?m=node&a=show');
	}
}
?>