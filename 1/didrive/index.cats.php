<?php

/*
[up_id] => 
[name] => Овощи
[new_cat] => Добавить каталог
[shop] => 12
[s] => bd6d62487f3977df1f9cece105525f8a
*/
// добавление каталога
if( isset($_POST['new_cat']) ){
    
    require_once $_SERVER['DOCUMENT_ROOT'].DS.'0.site'.DS.'exe'.DS.'myshop_admin'.DS.'class.php';
    // $status = '';
    $res = Nyos\mod\MyShopAdmin::addCat($db, $vv['shop']['id'], $_POST['name'], $_POST );   
    // echo $status;
    
    $vv['warn'] = $res['html'];
    
}