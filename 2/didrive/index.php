<?php

// $vv['types_sert'] = Nyos\mod\items::getItems($db, $vv['folder'], '010.sert_types', null, 50);

// $_SESSION['status1'] = true;
//$status = '';

// $vv['shop0'] = Nyos\mod\myshop::getShop( $db, $vv['now_mod']['shop_id']);

$vv['shop'] = Nyos\mod\myshop::getShopFromDomain($db);
//\f\pa($vv['shop']);

if( file_exists( dir_serv_mod.'00start.php') )
require_once dir_serv_mod.'00start.php';

// $vv['shop'] = $v['data'];
// f\pa($vv['shop']);
//f\pa($vv['now_level']);

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

if( isset($_GET['option']) && isset($vv['menu01'][$_GET['option']]) ){

    if( file_exists(dir_serv_mod_didr.'index.'.$_GET['option'].'.php') )
    require_once dir_serv_mod_didr.'index.'.$_GET['option'].'.php';

    $vv['body2tpl'] = dir_serv_mod_didr_tpl . 'body.'.$_GET['option'].'.htm';
}

$vv['tpl_body'] = dir_serv_mod_didr_tpl . 'body.htm';
