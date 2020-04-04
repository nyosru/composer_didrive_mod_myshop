<?php

//f\pa($vv['now_mod']);


if( file_exists( DirSite . 'download' . DS . 'datain' . DS .'IMOst.csv.delete' ) ){
    $vv['datain_file_time'] = date('d.m.Y H:i:s',filemtime( DirSite . 'download' . DS . 'datain' . DS .'IMOst.csv.delete' ) );
}

//$vv['now_shop'] = Nyos\mod\myshop::getShopFromDomain($db);
Nyos\mod\myshop::getShopFromDomain($db);
//f\pa($vv['now_shop']);
// f\pa(Nyos\mod\myshop::$shop);

//Nyos\mod\myshop::getCats($db, Nyos\mod\myshop::$shop['id']);

    //f\pa(Nyos\nyos::$menu[$_GET['level']]);
    
    if( isset(Nyos\nyos::$menu[$_GET['level']]['type']) && Nyos\nyos::$menu[$_GET['level']]['type'] == 'myshop' ){
    
        if( isset( $_GET['option'] ) && $_GET['option'] == 'cats' ){ // && isset(Nyos\mod\myshop::$cats[$_GET['option']]['id']) ){
        //if( isset( $_GET['option'] ) && $_GET['option'] == 'cats' && isset(Nyos\mod\myshop::$cats[$_GET['option']]['id']) ){
            
        //f\pa(Nyos\mod\myshop::$cats);

        if( isset(Nyos\mod\myshop::$cats[$_GET['ext1']]['up_id']{0}) ){
            $vv['breadcrumb'][] = array( 'name' => Nyos\mod\myshop::$cats[Nyos\mod\myshop::$cats[$_GET['ext1']]['up_id']]['name'], 'uri' => '/'.$_GET['level'].'/'.$_GET['option'].'/'.Nyos\mod\myshop::$cats[$_GET['ext1']]['up_id'].'/' );
        }
        
            $vv['breadcrumb'][] = array( 'name' => Nyos\mod\myshop::$cats[$_GET['ext1']]['name'], 'uri' => '/'.$_GET['level'].'/'.$_GET['option'].'/'.$_GET['ext1'].'/' );
            
        }
            
    }





if (isset($vv['now_mod']['no_cats']{1})) {
    $vv['tpl_0body'] = \f\like_tpl('sh-no.cat', $vv['dir_module_tpl'], $vv['dir_site_tpl']);
} else {
    $vv['tpl_0body'] = \f\like_tpl('sh', $vv['dir_module_tpl'], $vv['dir_site_tpl']);
}


