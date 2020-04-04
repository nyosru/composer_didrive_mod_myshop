<?php

if( !isset( Nyos\mod\myshop::$shop['id'] ) ) {
    
    Nyos\mod\myshop::getShopFromDomain($db);
    //f\pa(Nyos\mod\myshop::$shop);
    
    Nyos\mod\myshop::getItems( $db );
    //f\pa(Nyos\mod\myshop::$items);

}









if( 1 == 2 && !isset($vv['shop']) ) {
    
    
    $t = Nyos\mod\myshop::getShopFromDomain($db);

    $vv['shop'] = $t['data'];
    $vv['shop']['cfg.level'] = $w['cfg.level'];

    if ( isset($vv['shop']['id']) )
        $vv['shop']['cats'] = Nyos\mod\myshop::getCats($db, $vv['shop']['id']);

    if ( isset( $vv['shop']['id'] ) ) {
        $vv['shop']['items'] = Nyos\mod\myshop::getItems($db, $vv['shop']['id']);
    }
}
