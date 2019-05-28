<?php

/*
分页类

总条数：$total
每页条数：$perpage
当前页：$page

总页数：$cnt = cell($total/$perpage); 相除向上取整

第$page页显示从($page-1)*$perpage+1取$perpage条
*/


defined('ACC')||exit('ACC Denied');

class PageTool{
	protected $total = 0;
	protected $perpage = 10;
	protected $page = 9;

	public function __construct($total, $page=false, $perpage=false){
		$this->total = $total;
		if($perpage){
			$this->perpage = $perpage;
		}
		if($page){
			$this->page = $page;
		}
	}


	//主要函数，创建分页导航
	public function show(){
		$cnt = ceil($this->total/$this->perpage); //得到总页数
		//保存地址栏地址
		$uri = $_SERVER['REQUEST_URI']; //打印出地址
		$parse = parse_url($uri);  //分离出query部分
		$param = array();  //存放地址信息
		if(isset($parse['query'])){
			parse_str($parse['query'],$param);
		}

		//unset一下，确保没有page单元,即保存除page之外的所有单元
		unset($param['page']);
		//print_r($param);

		$url = $parse['path'] . '?';
		if(!empty($param)){
			$param = http_build_query($param);  //去掉page
			$url = $url . $param . '&';
		}
		
		//计算页码导航
		$nav = array();
		$nav[0] = '<span class="page_now">'.$this->page.'</span>';
		for($left = $this->page-1, $right = $this->page+1; ($left>=1 || $right<=$cnt) && count($nav)<=5;){
			if($left>=1){
				array_unshift($nav, '<a href="' . $url. 'page=' . $left . '">[' . $left . ']</a>');  //放到数组的头部
				$left-=1;
			}

			if($right<=$cnt){
				array_push($nav, '<a href="' . $url. 'page=' . $right . '">[' . $right . ']</a>');  //放到数组的尾部
				$right+=1;
			}
		}
		return implode('', $nav);


		
	}
}

/*
//分页类调用测试：
$page = $_GET['page']?$_GET['page']:1;

$p = new PageTool(20,$page,6);  //传参数
echo $p->show();

*/


