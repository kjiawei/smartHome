<?php
if (!function_exists('get_magic_quotes_gpc')) {
	function get_magic_quotes_gpc () {
		return FALSE;
	}
}
function nowurl () {
	static $nowurl='';
	if (!empty($nowurl)) return $nowurl;
	if (!empty($_SERVER['REQUEST_URI'])) {
		$scriptName=$_SERVER['REQUEST_URI'];
		$nowurl=$scriptName;
	} else {
		$scriptName=$_SERVER['PHP_SELF'];
		if (empty($_SERVER['QUERY_STRING'])) {
			$nowurl=$scriptName;
		} else {
			$nowurl=$scriptName.'?'.$_SERVER['QUERY_STRING'];
		}
	}
	return $nowurl;
}
function curl_get ($url,$data=array()) {
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_HEADER,0);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
	if (isset($data['header'])) curl_setopt($ch,CURLOPT_HTTPHEADER,$data['header']);
	if (isset($data['cookie'])) curl_setopt($ch,CURLOPT_COOKIE,$data['cookie']);
	if (isset($data['post'])) {
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data['post']);
	}
	$result=curl_exec($ch);
	@curl_close($ch);
	return $result;
}
function randstr ($num,$rmyc=FALSE) { //随机字符串
	if ($rmyc) $str='abdefhjkmnpqrstuvwxyz23456789ABDEFHJKLMNPQRSTUVWXYZ';
	else $str='abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$fullstr='';
	do {
		$fullstr.=$str;
	} while (strlen($fullstr)<$num);
	return substr(str_shuffle($fullstr),0,$num);
}

function getgpc ($k,$t='R') {
	switch ($t) {
		case 'P':$var=$_POST;break;
		case 'G':$var=$_GET;break;
		case 'C':$var=$_COOKIE;break;
		case 'R':$var=$_REQUEST;break;
	}
	return isset($var[$k])?(is_array($var[$k])?$var[$k]:trim($var[$k])):NULL;
}
function ispost () {
	if (count($_POST)>0) return TRUE;
	else return FALSE;
}
function authcode ($str,$option) {
	$ckey_length = 4;
	$key=md5(ENKEY);
	$keya=md5(substr($key,0,16));
	$keyb=md5(substr($key,16,16));
	$keyc=$ckey_length?($option=='DECODE'?substr($string,0,$ckey_length):substr(md5(microtime()),-$ckey_length)):'';
	$cryptkey=$keya.md5($keya.$keyc);
	$key_length=strlen($cryptkey);
	$string=$option=='DECODE'?base64_decode(substr($string,$ckey_length)):sprintf('%010d',$expiry?$expiry+time():0).substr(md5($string.$keyb),0,16).$string;
	$string_length=strlen($string);
	$result='';
	$box=range(0,255);
	$rndkey=array();
	for ($i=0;$i<=255;$i++) {
		$rndkey[$i]=ord($cryptkey[$i%$key_length]);
	}
	for ($j=$i=0;$i<256;$i++) {
		$j=($j+$box[$i]+$rndkey[$i])%256;
		$tmp=$box[$i];
		$box[$i]=$box[$j];
		$box[$j]=$tmp;
	}
	for ($a=$j=$i=0;$i<$string_length;$i++) {
		$a=($a+1)%256;
		$j=($j+$box[$a])%256;
		$tmp=$box[$a];
		$box[$a]=$box[$j];
		$box[$j]=$tmp;
		$result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
	}
	if ($option=='DECODE') {
		if((substr($result,0,10)==0||substr($result,0,10)-time()>0)&&substr($result,10,16)==substr(md5(substr($result,26).$keyb),0,16)){
			return substr($result,26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=','',base64_encode($result));
	}
}
function pwdcode ($str) {
	$str=md5($str);
	$str=md5(ENKEY.$str);
	$str=md5($str.ENKEY);
	$str=md5('SmartHome'.$str);
	$str=md5($str.'SmartHome');
	return $str;
}
function getClass ($name) {
	if (!is_file(INC.$name.'.class.php')) return FALSE;
	if (isset($_ENV['class_'.$name])) return $_ENV['class_'.$name];
	if (!class_exists($name)) require(INC.$name.'.class.php');
	$c=$name::getInstance();
	$_ENV['class_'.$name]=$c;
	return $c;
}
?>