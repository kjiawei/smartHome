<?php
if (!defined('ROOT')) exit('SmartHome');
/*
 * ฤฃฟ้ฃบสืาณ
 * @package Model
*/
class index extends base {
	static private $_instance=NULL;
	static public function getInstance () {
		if (!self::$_instance) self::$_instance=new self;
		return self::$_instance;
	}
	public function __construct () {
		parent::init();
	}
	public function onbody () {
		include(TPL.'index.html');
	}
}
?>