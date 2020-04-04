<?php


// $vv['types_sert'] = Nyos\mod\items::getItems($db, $vv['folder'], '010.sert_types', null, 50);


// $_SESSION['status1'] = true;
//$status = '';

// $vv['shop0'] = Nyos\mod\myshop::getShop( $db, $vv['now_mod']['shop_id']);

$v = Nyos\mod\myshop::getShopFromDomain($db);

// f\pa($vv['shop0']);

require_once $_SERVER['DOCUMENT_ROOT'].DS.'0.site'.DS.'exe'.DS.'myshop_admin'.DS.'00start.php';

$vv['shop'] = $v['data'];
// f\pa($vv['shop']);
// echo $status;

//f\pa($vv['shop']);
//f\pa($vv['now_mod']);

$vv['menu01'] = array(
    /*
    'index' => array(
        'name' => 'Обзор'
        )
    ,
    */
    'cats' => array(
        'name' => 'Каталоги'
        )
    ,'items' => array(
        'name' => 'Товары'
        )
    ,'cfg' => array(
        'name' => 'Настройки'
        )
    
    );

// велесмед
if( isset($vv['now_mod']['load_1c_1']) && file_exists(dirname(__FILE__).DS.'index.load_1c_1.php') ){
    $vv['menu01'] = array( 'load_1c_1' => array( 'name' => 'Загрузка товаров 1с' ) );
    require_once dirname(__FILE__).DS.'index.load_1c_1.php' ;
    $vv['body2tpl'] = didr_tpl . 'body.load_1c_1.htm';
}

if( isset($_GET['option']) && isset($vv['menu01'][$_GET['option']]) ){

    // echo '<Br/>'.__FILE__.' #'.__LINE__;
       

    if(file_exists(dirname(__FILE__).DS.'index.'.$_GET['option'].'.php'))
    require_once didr_f.'index.'.$_GET['option'].'.php' ;

    $vv['body2tpl'] = didr_tpl . 'body.'.$_GET['option'].'.htm';
}

$vv['tpl_body'] = didr_tpl . 'body.htm';
