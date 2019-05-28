<?php

define('ACC',true);
require('../include/init.php');


// 接POST
// 判断合法性,同学们自己做.


$data = array();
if(empty($_POST['cat_name'])) {
    exit('栏目名不能为空');
}
$data['cat_name'] = $_POST['cat_name'];
$data['parent_id'] = $_POST['parent_id'] + 0;
$data['intro'] = $_POST['intro'];

$cat_id = $_POST['cat_id'] + 0;

/*
一个栏目A,不能修改成为A的子孙栏目的子栏目.

思考: 如果B是A的后代,则A不能成为B的子栏目.
反之, B是A的后代,则A是B的祖先


因此,我们为A设定一个新的父栏目时,设为N
我们可以先查N的 家谱树,N的家谱树里,如果有A

则子孙差辈了. 
*/



// 调用model 来更改
$cat = new CatModel();

// 查找新父栏目的家谱树
$trees = $cat->getTree($data['parent_id']);

// 判断自身是否在新父栏目的家谱树里面
$flag = true;
foreach($trees as $v) {
    if($v['cat_id'] == $cat_id) {
        $flag = false;
        break;
    }
}

if(!$flag) {
    echo '父栏目选取错误';
    exit;
}


if($cat->update($data,$cat_id)) {
    echo '修改成功';
} else {
    echo '修改失败';
}