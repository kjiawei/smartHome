<?php

define('ACC',true);
require('../include/init.php');



// 调用model
$cat = new CatModel();
$catlist = $cat->select();

$catlist = $cat->getCatTree($catlist,0);
//print_r($catlist);

include(ROOT . 'view/admin/templates/catelist.html');
