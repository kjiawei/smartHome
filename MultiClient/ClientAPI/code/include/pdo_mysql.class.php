<?php
if (!defined('ROOT')) exit('SmartHome');
/*
 * PDO_MySQL数据库核心类 pdo_mysql.class.php
 * @category Libraries
*/
/*
 * 注意：调用这个类前，请先设定这些常量
 * SQLHOST,SQLUSER,SQLPWD,SQLNAME,DBPREFIX
*/

// 在工程所有文件中均不需要单独初始化这个类，可直接用$sql进行操作
// 为了防止错误，操作完后不必关闭数据库
$sql=pdosysql::getInstance();
class pdosysql {
	static private $_instance=NULL;
	private $linkID;
	private $dbHost;
	private $dbUser;
	private $dbPwd;
	private $dbName;
	private $dbPrefix;
	private $result;
	private $sql;
	private $comparison=array('eq'=>'=','neq'=>'<>','gt'=>'>','egt'=>'>=','lt'=>'<','elt'=>'<=','notlike'=>'NOT LIKE','like'=>'LIKE','in'=>'IN','notin'=>'NOT IN');
	private $sqlGrammar=array('select'=>'SELECT {$row} FROM `{$table}`{$join}{$where}{$group}{$order}{$limit}','update'=>'UPDATE `{$table}` SET {$update}{$where}','delete'=>'DELETE FROM `{$table}`{$where}','insert'=>'INSERT INTO `{$table}`{$row} VALUES {$vals}',);
	static public function getInstance () {
		if (!self::$_instance) self::$_instance=new self;
		return self::$_instance;
	}
	/*
	 * 初始化
	 * @access public
	*/
	public function __construct () {
		$this->linkID=0;
		$this->dbHost=SQLHOST;
		$this->dbUser=SQLUSER;
		$this->dbPwd=SQLPWD;
		$this->dbName=SQLNAME;
		$this->dbPrefix=DBPREFIX;
		$dsn='mysql:host='.SQLHOST.';dbname='.$this->dbName.';charset=utf8';
		try {
			$this->linkID=new PDO($dsn,$this->dbUser,$this->dbPwd); //初始化PDO
		} catch (PDOException $e) {
			$this->DisplayError('Fail to connect to Database Server','Because of System\'s	Safe,the program won\'t show the SQL',$this->linkID);
		}
	}
	/*
	 * 获取所有结果
	 * @access public
	 * @param string $key 结果Key，查询时传递
	 * @return array
	*/
	public function GetAll ($key) {
		$rs=$this->result[$key];
		$rs->setFetchMode(PDO::FETCH_ASSOC);
		$rs=$rs->fetchAll();
		return $rs;
	}
	/*
	 * 获取数量，相当于SQL里的count()
	 * @access public
	 * @param string $table 表名
	 * @param array $datas SQL参数，将处理row后传给query()
	 * @return int
	*/
	public function GetNum ($table,$datas) {
		$type='select';
		$datas['row']='count('.$datas['row'].') as num';
		$this->query('num',$type,$table,$datas);
		$r=$this->GetArray('num');
		$this->free('num');
		return intval($r['num']);
	}
	/*
	 * 查询出一个结果
	 * @access public
	 * @param string $type 查询类型，可选select,show
	 * @param string $table 表名
	 * @param array $datas SQL参数，将处理limit后传给query
	 * @return array
	*/
	public function GetOne ($type,$table,$datas) {
		if (!isset($datas['limit'])) $limit=array('start'=>0,'end'=>1);
		$this->query('one',$type,$table,$datas);
		$r=$this->GetArray('one');
		$this->free('one');
		return $r;
	}
/*
	 * 释放结果
	 * @access public
	 * @param string $key 结果Key
	 * @return NULL
	*/
	public function free ($key) {
		$this->result[$key]=NULL;
	}
	/*
	 * 获取最后产生的ID
	 * @access public
	 * @param NONE
	 * @return int
	*/
	public function GetLastId () {
		return intval($this->linkID->lastInsertId());
	}
	/*
	 * 获取结果集中的一个结果
	 * @access public
	 * @param string $key 结果Key
	 * @return array/NULL
	*/
	public function GetArray ($key) {
		if (!isset($this->result[$key]) || empty($this->result[$key])) return NULL;
		$rs=$this->result[$key];
		$rs->setFetchMode(PDO::FETCH_ASSOC);
		$rs=$rs->fetch();
		return $rs;
	}
	/*
	 * 查询主函数
	 * @access public
	 * @param string $key 结果Key
	 * @param string $type 查询类型，可选select,delete,update,insert
	 * @param string $table 表名
	 * @param array $datas SQL参数
	 * @return NULL
	*/
	public function query ($key,$type,$table,$datas) {
		$sql=$this->sqlGrammar[$type];
		$sql=str_replace('{$table}',$this->dbPrefix.$table,$sql);
		$where=$this->mkWhere($datas['where']);
		$limit=$this->mkLimit($datas['limit']);
		$order=$this->mkOrder($datas['order']);
		$group=$this->mkGroup($datas['group']);
		$join=$this->mkJoin($datas['join']);
		$sql=str_replace('{$where}',$where['sql'],$sql);
		$sql=str_replace('{$limit}',$limit,$sql);
		$sql=str_replace('{$order}',$order,$sql);
		$sql=str_replace('{$group}',$group,$sql);
		$sql=str_replace('{$join}',$join,$sql);
		switch ($type) {
			case 'update':
				$update=$this->mkUpdate($datas['update']);
				$sql=str_replace('{$update}',$update,$sql);
				break;
			case 'insert':
				$insertrow=$this->mkInsertRow($datas['insert']['row']);
				$insertval=$this->mkInsertVal($datas['insert']['val']);
				$sql=str_replace('{$vals}',$insertval,$sql);
				$sql=str_replace('{$row}',$insertrow,$sql);
				break;
			default:
				if (isset($datas['row'])) $sql=str_replace('{$row}',$datas['row'],$sql);
				break;
		}
		// var_dump($where);
		// var_dump($sql);
		// exit;
		$st=$this->linkID->prepare($sql);
		foreach ($where['bind'] as $keyid=>$val) $st->bindValue($keyid+1,$val);
		try {
			$r=$st->execute(); //执行
			if (!$r) $this->DisplayError('SQL error',$sql,$st);
		} catch (PDOException $e) {
			$this->DisplayError('Fail to Execute',$sql,$st);
		}
		if (in_array($type,array('select','show'),TRUE)) $this->result[$key]=$st;
	}
	/*
	 * 生成insert语句中的列
	 * @access private
	 * @param array $rows 列，类似(0=>'name',1=>'title',...)
	 * @return string
	*/
	private function mkInsertRow ($rows) {
		if (empty($rows) || !is_array($rows) || count($rows)==0) return ' ';
		$str='(';
		foreach ($rows as $val) $str.="`$val`,";
		$str=trim($str,',');
		$str.=')';
		return $str;
	}
	/*
	 * 生成insert中的值
	 * @access private
	 * @param array $vals 值，类似(0=>'admin',1=>'123456',...)
	 * @return string
	*/
	private function mkInsertVal ($vals) {
		if (empty($vals) || !is_array($vals) || count($vals)==0) return ' ';
		$str='(';
		foreach ($vals as $val) $str.="'$val',";
		$str=trim($str,',');
		$str.=')';
		return $str;
	}
	/*
	 * 生成update语句
	 * @access private
	 * @param array $update 参数，类似('name'=>'xxx''price'=>10,...)
	 * @return string
	*/
	private function mkUpdate ($update) {
		if (empty($update) || !is_array($update) || count($update)==0) return ' ';
		$str='';
		foreach ($update as $key=>$val) $str.=$key."='$val',";
		$str=trim($str,',');
		return $str;
	}
	/*
	 * 生成where语句中的一项
	 * @access private
	 * @param array $where 一项where，类似('name'=>'id','type'=>'eq','val'=>1)
	 * @return string
	*/
	private function parseMkWhere ($where) {
		if (!isset($this->comparison[$where['type']])) return '';
		if ($where['type']=='between') return array('sql'=>$where['name'].' BETWEEN ? AND ?','bind'=>array($where['val'],$where['val2']));
		else return array('sql'=>$where['name'].' '.$this->comparison[$where['type']].' ?','bind'=>$where['val']);
	}
	/*
	 * 生成where语句
	 * @access private
	 * @param array $where where参数(0=>Array('name'=>'id','type'=>'eq','val'=>1),...)
	 * @return string
	*/
	private function mkWhere ($where) {
		if (empty($where) || !is_array($where) || count($where)==0) return array('sql'=>' ','bind'=>array());
		if (count($where)==1) { //只有一个where就不需要下面那么麻烦了
			$wherearr=$this->parseMkWhere($where[0]);
			return array('sql'=>' WHERE '.$wherearr['sql'],'bind'=>(is_array($wherearr['bind'])?$wherearr['bind']:array($wherearr['bind'])));
		}
		$str=' WHERE ';
		$bind=array();
		foreach ($where as $val) {
			$wherearr=$this->parseMkWhere($val);
			$str.=$wherearr['sql'].' AND ';
			if (is_array($wherearr['bind'])) { //BETWEEN的bind是array
				$bind[]=$wherearr['bind'][0];
				$bind[]=$wherearr['bind'][1];
			} else { //否则是字符串
				$bind[]=$wherearr['bind'];
			}
		}
		$str=trim($str);
		$str=trim($str,'AND');
		$str=trim($str);
		$str=' '.$str;
		return array('sql'=>$str,'bind'=>$bind);
	}
	/*
	 * 生成limit语句
	 * @access private
	 * @param array $limit LIMIT参数，类似('start'=>开始,'end'=>数量)
	 * @return string
	*/
	private function mkLimit ($limit) {
		if (empty($limit) || !is_array($limit)) return ' ';
		return ' LIMIT '.$limit['start'].','.$limit['end'];
	}
	/*
	 * 生成order语句
	 * @access private
	 * @param array $order ORDER参数，类似('row'=>'time','by'=>'desc')
	 * @return string
	*/
	private function mkOrder ($order) {
		if (empty($order) || !is_array($order)) return ' ';
		return ' ORDER BY '.$order['row'].' '.strtoupper($order['by']);
	}
	/*
	 * 生成group语句
	 * @access private
	 * @param string $group GROUP参数
	 * @return string
	*/
	private function mkGroup ($group) {
		if (empty($group)) return ' ';
		return ' GROUP BY '.$group;
	}
	/*
	 * 生成join语句，暂未使用
	 * @access private
	 * @param string $join
	 * @return string
	*/
	private function mkJoin ($join) {
		return ' ';
		// if (empty($join) || !is_array($join)) return ' ';
		// return ' GROUP BY '.$order['row'];
	}
	/*
	 * 显示SQL错误
	 * @access private
	 * @param string $info 错误说明
	 * @param string $sql 出错的SQL语句
	 * @return NULL
	*/
	private function DisplayError ($info,$sql,$error) {
		exit(json_encode(array('success'=>0,'errcode'=>101,'errmsg'=>'Internal Server Error','sqlmsg'=>$error->errorInfo())));
	}

}
?>