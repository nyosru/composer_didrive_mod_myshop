<?php

/**
 * удаление таблиц модуля
 */
if (1 == 2 && !isset($_GET['warn'])) {

    $a = [
        'm_myshop',
        'm_myshop_dop',
        'm_myshop_domain',
        'm_myshop_cats',
        'm_myshop_items',
        'm_myshop_items_dops',
        'm_myshop_items_img',
        'm_myshop_items_options'
    ];

    foreach ($a as $k => $v) {
        $db->exec('DROP TABLE IF EXISTS `' . $v . '` ;');
        $vv['warn'] .= '<Br/>удалена таблица ' . $v;
    }

}



try {


//$vv['now_shop'] = Nyos\mod\myshop::getShopFromDomain($db);

    Nyos\mod\myshop::getShopFromDomain($db);

    // $vv['datain'] = \Nyos\mod\myshop::getItems($db, Nyos\mod\myshop::$shop_id);

    $sql = $db->prepare('SELECT * FROM `m_myshop_items` ;');
    $sql->execute();
    Nyos\mod\myshop::$items =
    $vv['datain'] = $sql->fetchAll();



    // \f\pa(Nyos\mod\myshop::$items);
} catch (\NyosEx $ex) {

    echo '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
    . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
    . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
    . PHP_EOL . $ex->getTraceAsString()
    . '</pre>';
} catch (\PDOException $ex) {

//    echo '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
//    . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
//    . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
//    . PHP_EOL . $ex->getTraceAsString()
//    . '</pre>';

    if (strpos($ex->getMessage(), 'no such table') !== false) {

//        echo '<br/>';
//        echo '<br/>';
//        echo 'начинаем добавлять таблички ';
//        echo '<br/>';
//        echo '<br/>';

        require_once dirname(__FILE__) . '/2/setup.php';
        //self::creatTable($db);
        //echo 'добавили таблички модуля';
        //exit;
        \f\redirect('/', 'index.php', array('warn' => 'Создали первые таблицы для магазина, действуйте!'));

        //echo '<br/>' . __FILE__ . ' #' . __LINE__;
    }
} catch (\Exception $ex) {

//    echo '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
//    . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
//    . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
//    . PHP_EOL . $ex->getTraceAsString()
//    . '</pre>';
}

//f\pa($vv['now_shop']);
// f\pa(Nyos\mod\myshop::$shop);
//Nyos\mod\myshop::getCats($db, Nyos\mod\myshop::$shop['id']);
//f\pa(Nyos\nyos::$menu[$_GET['level']]);
/*
  if (isset( $vv['now_level']['type']) && $vv['now_level']['type'] == 'myshop') {

  if (isset($_GET['option']) && $_GET['option'] == 'cats') { // && isset(Nyos\mod\myshop::$cats[$_GET['option']]['id']) ){
  //if( isset( $_GET['option'] ) && $_GET['option'] == 'cats' && isset(Nyos\mod\myshop::$cats[$_GET['option']]['id']) ){
  //f\pa(Nyos\mod\myshop::$cats);
  if (isset(Nyos\mod\myshop::$cats[$_GET['ext1']]['up_id']{0})) {
  $vv['breadcrumb'][] = array('name' => Nyos\mod\myshop::$cats[Nyos\mod\myshop::$cats[$_GET['ext1']]['up_id']]['name'], 'uri' => '/' . $_GET['level'] . '/' . $_GET['option'] . '/' . Nyos\mod\myshop::$cats[$_GET['ext1']]['up_id'] . '/');
  }

  $vv['breadcrumb'][] = array('name' => Nyos\mod\myshop::$cats[$_GET['ext1']]['name'], 'uri' => '/' . $_GET['level'] . '/' . $_GET['option'] . '/' . $_GET['ext1'] . '/');
  }
  }
 */

// \f\pa($vv['now_level']);
// \f\pa($vv['now_level']);

/**
 * нашли файл данных товаров для магазина
 */
if (isset($vv['now_level']['datain_name_file']) && file_exists(dir_serv_site_sd . 'datain' . DS . $vv['now_level']['datain_name_file'])) {

    if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/site'))
        \Nyos\mod\myshop::$shop_id = 1;

    //echo '<br/>' . __FILE__ . ' #' . __LINE__;
    $array = \Nyos\mod\myshop::readDataFile(dir_serv_site_sd . 'datain' . DS . $vv['now_level']['datain_name_file']);
    //\f\pa($array);

    $sql = $db->prepare('DELETE FROM `m_myshop_items` ;');
    $sql->execute();
    $sql = $db->prepare('REINDEX `m_myshop_items` ;');
    $sql->execute();

    $sql = $db->prepare('DELETE FROM `m_myshop_items_dops` ;');
    $sql->execute();
    $sql = $db->prepare('REINDEX `m_myshop_items_dops` ;');
    $sql->execute();

    $sql = $db->prepare('VACUUM;');
    $sql->execute();

//    $vv['datain'] = \Nyos\mod\myshop::getItems($db, \Nyos\mod\myshop::$shop_id);
//    \f\pa($vv['datain'], '', '', 'datain');

    \f\db\sql_insert_mnogo($db, 'm_myshop_items', $array['data'], array('shop' => \Nyos\mod\myshop::$shop_id), true);
    \f\db\sql_insert_mnogo($db, 'm_myshop_items_dops', $array['dop'], array('shop' => \Nyos\mod\myshop::$shop_id), true);

    $sql = $db->prepare('SELECT * FROM `m_myshop_items` ;');
    $sql->execute();
    $vv['datain'] = $sql->fetchAll();

    // \f\pa($vv['datain'], '', '', 'datain');



    if (1 == 2) {


        //die();
        //\f\pa($db);
//            $sql = $db->prepare('SELECT * FROM `m_myshop_items` ;');
//            $sql->execute();
//            $e = $sql->fetchAll();
//            \f\pa($e,2);
//    $ee = \Nyos\mod\myshop::importData($db, 'shop_items', \Nyos\mod\myshop::$shop_id, $array['data'], $array['dop']);

        $shop_id = \Nyos\mod\myshop::$shop_id;

//    $sql = $db->prepare('DELETE FROM `m_myshop_items` WHERE `shop` = :shop ;');
//    $sql->execute(array(':shop' => $shop_id));
//            $sql = $db->prepare('SELECT * FROM `m_myshop_items` ;');
//            $sql->execute();
//            $e = $sql->fetchAll();
//            \f\pa($e,2);
//            $sql = $db->prepare('SELECT * FROM `m_myshop_items` WHERE `shop` = :shop ;');
//            $sql->execute(array(':shop' => $shop_id));
//            
//            $sql = $db->prepare('SELECT * FROM `m_myshop_items` ;');
//            $sql->execute();
//            $e = $sql->fetchAll();
//            \f\pa($e);
        // \f\pa($t_all);
        // \f\db\sql_insert_mnogo2($db, 'm_myshop_items', $t_all, array('shop' => $shop), true);
        // \f\pa($info);
        // \f\pa($shop_id);
//    \f\db\sql_insert_mnogo($db, 'm_myshop_items', $array['data'], array('shop' => $shop_id), true);
//    $sql = $db->prepare('DELETE FROM `m_myshop_items_dops` WHERE `shop` = :shop ;');
//    $sql->execute(array(':shop' => $shop_id));
//    \f\db\sql_insert_mnogo($db, 'm_myshop_items_dops', $array['dop'], array('shop' => $shop_id), true);

        $sql = $db->prepare('VACUUM');
        $sql->execute();

//    $vv['datain'] = \Nyos\mod\myshop::getItems($db, Nyos\mod\myshop::$shop_id);
//    \f\pa($vv['datain'],'','','datain');

        $vv['datain'] = [1 => 1, 2 => 2];
        \f\pa($vv['datain'], '', '', 'datain');
    }

//    \f\pa($ee, '', '', '$ee');
//    die();
    rename(dir_serv_site_sd . 'datain' . DS . $vv['now_level']['datain_name_file'], dir_serv_site_sd . 'datain' . DS . $vv['now_level']['datain_name_file'] . '.delete');

    $msg = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $vv['level'] . '/' . PHP_EOL . PHP_EOL
            . 'Обработали файл данных ' . $vv['now_level']['datain_name_file'];

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/include/Nyos/nyos_msg.php')) {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/include/Nyos/nyos_msg.php';
        \Nyos\NyosMsg::sendTelegramm($msg);

        if (isset($vv['now_level']['send_telegram']) && $vv['now_level']['send_telegram'] == 'send') {
            for ($d = 1; $d <= 10; $d++) {
                if (isset($vv['now_level']['send_telegram_id_' . $d]) && is_numeric($vv['now_level']['send_telegram_id_' . $d])) {
                    \Nyos\NyosMsg::sendTelegramm($msg, $vv['now_level']['send_telegram_id_' . $d]);
                }
            }
        }
    }
}



// тащим дату обновления
if (file_exists(DirSite . 'download' . DS . 'datain' . DS . 'IMOst.csv.delete')) {
    $vv['datain_file_time'] = date('d.m.Y H:i:s', filemtime(DirSite . 'download' . DS . 'datain' . DS . 'IMOst.csv.delete'));
}



//echo '<br/>' . __FILE__ . ' #' . __LINE__;
//echo '<blockquote>';
// \f\readDataFile($vv, );
//\f\pa(\Nyos\mod\myshop::$items);



if (isset($vv['now_level']['no_cats'])) {
    $vv['tpl_0body'] = \f\like_tpl('sh-no.cat', dir_serv_mod_ver_tpl, dir_serv_site_mod_tpl);
} else {
    $vv['tpl_0body'] = \f\like_tpl('sh', dir_serv_mod_ver_tpl, dir_serv_site_mod_tpl);
}