<?php
if (!defined('LANG')) exit('SYHM');
require(DATA.'language/'.LANG.'.lang.php');
function lang ($type,$key) {
	global $lang;
	if (isset($lang[$type][$key])) return $lang[$type][$key];
	else exit('Error:Can not read language setting in '.LANG.'=>'.$type.'=>'.$key);
}
?>