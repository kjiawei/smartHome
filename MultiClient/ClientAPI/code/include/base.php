<?php
class view {
	static private $_instance=NULL;
	static public function getInstance () {
		if (!self::$_instance) self::$_instance=new self;
		return self::$_instance;
	}
	public function __construct () {
		$_ENV['view']=array();
	}
	public function set ($key,$val) {
		$_ENV['view'][$key]=$val;
	}
	public function get ($key) {
		return isset($_ENV['view'][$key])?$_ENV['view'][$key]:NULL;
	}
	public function show ($key,$strip=1) {
		$val=$this->get($key);
		if ($val!==NULL) {
			if ($strip==1) echo htmlspecialchars($val);
			elseif ($strip==2) echo urlencode($val);
			else echo $val;
		}
	}
	public function showall ($key,$style) {
		$datas=$this->get($key);
		$outs='';
		foreach ((array)$datas as $data) {
			$out=$style;
			foreach ($data as $key=>$val) {
				$out=str_replace('{$'.$key.'}',$val,$out);
			}
			$outs.=$out;
		}
		echo $outs;
	}
}
$view=view::getInstance();
/*
 * 基本类
 * 貌似现在就init
*/
class base {
	public $view;
	public $sql;
	public $nosql;
	public function init () {
		global $view,$sql,$nosql;
		$this->view=$view;
		$this->sql=$sql;
		if (class_exists('SimpleSSDB')) $this->nosql=new SimpleSSDB(NOSQLHOST,NOSQLPORT);
	}
	public function getClass ($name) {
		return getClass($name);
	}
}
?>