<?php

/**
 * установка баз данных и файлов для модуля при первом запуске (если не нашли нужных баз данных)
 */
if (!defined('IN_NYOS_PROJECT'))
    define('IN_NYOS_PROJECT', true);

echo '<br/>' . __FILE__ . ' #' . __LINE__;

$ff2 = $db->prepare('CREATE TABLE IF NOT EXISTS `m_myshop` ( '
// наверное в MySQL .' `id` int NOT NULL AUTO_INCREMENT, '
// в SQLlite
        . ' `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL ,
                    
                    `name` varchar NOT NULL,
                    `user` int NOT NULL,
                    `folder` varchar DEFAULT NULL, '
        . ' `d` INTEGER NOT NULL , '
        . ' `status` VARCHAR NOT NULL DEFAULT \'job\' '
        . ' );');
$ff2->execute();

$ff2 = $db->prepare('CREATE TABLE IF NOT EXISTS `m_myshop_domain` ( '
// наверное в MySQL .' `id` int NOT NULL AUTO_INCREMENT, '
// в SQLlite
        . ' `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL ,
                    
                    `shop` int(7) NOT NULL,
                    `domain` varchar(250) NOT NULL,
                    `domain_uri` varchar(250) DEFAULT NULL, '

        // .' `start_domain` set(\'y\') DEFAULT NULL, '
        . ' `start_domain` VARCHAR DEFAULT NULL, '
        . ' `data` text DEFAULT NULL, '

        //.' `d` date NOT NULL, '
        . ' `d` INTEGER NOT NULL , '
        // .' `t` time NOT NULL, '
        . ' `t` INTEGER NOT NULL , '

        // .' `need_reg` set(\'y\') DEFAULT NULL, '
        . ' `need_reg` VARCHAR DEFAULT NULL, '

        // .' `reg_date` date DEFAULT NULL, ' 
        . ' `reg_date` INTEGER DEFAULT NULL , '

        // .' `status` set(\'reg\',\'job\',\'delete\') NOT NULL DEFAULT \'job\' '
        . ' `status` VARCHAR NOT NULL DEFAULT \'job\' '
        // .'
//                        . ' `folder` VARCHAR(150) DEFAULT NULL, '
//                        . ' `module` VARCHAR(50) NOT NULL, '
//                        . ' `head` VARCHAR DEFAULT NULL, '
//                        . ' `sort` INTEGER(2) DEFAULT \'50\', '
//                . ' `status` VARCHAR(50) NOT NULL DEFAULT \'show\', '
//                . ' `add_d` INTEGER NOT NULL , '
//                . ' `add_t` INTEGER NOT NULL  '
        . ' );');
//$ff->execute([$domain]);
$ff2->execute();

//CREATE TABLE IF NOT EXISTS `m_myshop_dop` (
//  `id_shop` int(7) NOT NULL,
//  `name` varchar(250) NOT NULL,
//  `var` varchar(250) DEFAULT NULL,
//  `var_text` text
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='дополнения к магазину';
$ff2 = $db->prepare('CREATE TABLE IF NOT EXISTS `m_myshop_dop` ( 
                    `id_shop` int(7) NOT NULL,
                    `name` varchar(250) NOT NULL,
                    `var` varchar(250) DEFAULT NULL,
                    `var_text` TEXT DEFAULT NULL
            );');
$ff2->execute();


//CREATE TABLE IF NOT EXISTS `m_myshop_cats` (
//  `id` int(7) NOT NULL,
//  `shop` int(5) NOT NULL,
//  `up_id` int(5) DEFAULT NULL,
//  `name` varchar(250) NOT NULL,
//  `sort` int(2) NOT NULL DEFAULT '50',
//  `status` set('ok','hide','del') NOT NULL DEFAULT 'ok'
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
$ff2 = $db->prepare('CREATE TABLE IF NOT EXISTS `m_myshop_cats` ( 
        `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL ,
                    `shop` int(7) NOT NULL,
                    `up_id` int(7) DEFAULT NULL,
                    `name` varchar(250) NOT NULL,
                    `sort` int(2) DEFAULT \'50\',
                    `status` varchar(50) DEFAULT \'ok\'
            );');
$ff2->execute();

//CREATE TABLE IF NOT EXISTS `m_myshop_items` (
//  `id` int(11) NOT NULL,
//  `id_item` int(8) NOT NULL,
//  `shop` int(5) DEFAULT NULL,
//  `cat` int(7) DEFAULT NULL,
//  `name` varchar(250) NOT NULL,
//  `opis` text,
//  `opis1` varchar(255) DEFAULT NULL,
//  `opis2` varchar(255) DEFAULT NULL,
//  `opis3` varchar(255) DEFAULT NULL,
//  `opis4` varchar(255) DEFAULT NULL,
//  `price_old` double(8,2) DEFAULT NULL,
//  `price` double(8,2) DEFAULT NULL,
//  `price1` double(8,2) DEFAULT NULL,
//  `price2` double(8,2) DEFAULT NULL,
//  `onsklad` int(6) DEFAULT NULL,
//  `ed_izm` varchar(15) DEFAULT NULL COMMENT 'единица измерения',
//  `articul` varchar(50) DEFAULT NULL,
//  `sort` smallint(2) NOT NULL DEFAULT '50',
//  `status` set('show','hide','del') NOT NULL DEFAULT 'show'
//) ENGINE=InnoDB AUTO_INCREMENT=2321 DEFAULT CHARSET=utf8;
$ff2 = $db->prepare('CREATE TABLE IF NOT EXISTS `m_myshop_items` ( 
        `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL ,
        `id_item` int(8) NOT NULL,
        `shop` int(7) DEFAULT NULL,
        `cat` int(7) DEFAULT NULL,
        `name` varchar(250) NOT NULL,
        `opis` text,
        `opis1` varchar(250) DEFAULT NULL,
        `opis2` varchar(250) DEFAULT NULL,
        `opis3` varchar(250) DEFAULT NULL,
        `opis4` varchar(250) DEFAULT NULL,
                    
        `price_old` int(10) DEFAULT NULL,
        `price` int(10) DEFAULT NULL,
        `price1` int(10) DEFAULT NULL,
        `price2` int(10) DEFAULT NULL,
        `onsklad` int(6) DEFAULT NULL,

        `ed_izm` varchar(15) DEFAULT NULL,
        `articul` varchar(20) DEFAULT NULL,

        `sort` int(2) DEFAULT \'50\',
        `status` varchar(50) DEFAULT \'ok\'
        );');
$ff2->execute();




//CREATE TABLE IF NOT EXISTS `m_myshop_items_dops` (
//  `id` int(7) NOT NULL,
//  `shop` int(7) NOT NULL,
//  `id_item` int(8) NOT NULL,
//  `name` varchar(150) NOT NULL,
//  `value` varchar(250) NOT NULL
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;
$ff2 = $db->prepare('CREATE TABLE IF NOT EXISTS `m_myshop_items_dops` ( 

        `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL ,
        
        `shop` int(7) NOT NULL,
        `id_item` int(8) NOT NULL,
        
        `name` varchar(250) NOT NULL,
        `value` varchar(250) NOT NULL
        );');
$ff2->execute();

//CREATE TABLE IF NOT EXISTS `m_myshop_items_img` (
//  `id` int(11) NOT NULL,
//  `item` int(11) NOT NULL,
//  `link` varchar(250) NOT NULL,
//  `start` set('y') DEFAULT NULL,
//  `status` set('ok','delete') NOT NULL DEFAULT 'ok'
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='картинки товаров';
$ff2 = $db->prepare('CREATE TABLE IF NOT EXISTS `m_myshop_items_img` ( 

        `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL ,
        
        `item` int(8) NOT NULL,
        
        `link` varchar(250) NOT NULL,
        `start` varchar(10) DEFAULT NULL,
        `status` varchar(10) NOT NULL DEFAULT \'ok\'
        
        );');
$ff2->execute();


//. '`m_myshop_items_options`.`item`, '
//. '`m_myshop_items_options`.`option_id`, '
//. '`m_myshop_items_options`.`var`, '
//. '`m_myshop_items_options`.`price` '
$ff2 = $db->prepare('CREATE TABLE IF NOT EXISTS `m_myshop_items_options` ( 
        `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL ,
        `item` int(8) NOT NULL,
        `option_id` int(8) NOT NULL,
        `var` varchar(250) NOT NULL,
        `price` INTEGER DEFAULT NULL
        );');
$ff2->execute();

try {

    echo '<br/>' . __FILE__ . ' #' . __LINE__;
    echo '<br/>вставили запись myshop';

    $new_shop_id = \f\db\db2_insert($db, 'm_myshop', array(
        // 'id' => 1,
        'name' => 'start',
        'user' => 1,
        'folder' => $vv['folder'],
        'd' => date('Y.m.d', $_SERVER['REQUEST_TIME']),
        't' => date('H:i:s', $_SERVER['REQUEST_TIME'])
            ), true, 'last_id');

    echo '<br/>' . __FILE__ . ' #' . __LINE__;
    echo '<br/>вставили запись m_myshop_domain';

    \f\db\db2_insert($db, 'm_myshop_domain', array(
        'shop' => $new_shop_id,
        'domain' => $_SERVER['HTTP_HOST'],
        'domain_uri' => $_SERVER['HTTP_HOST'],
        'start_domain' => $_SERVER['HTTP_HOST'],
        'd' => date('Y.m.d', $_SERVER['REQUEST_TIME']),
        't' => date('H:i:s', $_SERVER['REQUEST_TIME'])
            ), true);

    echo '<br/>' . __FILE__ . ' #' . __LINE__;
    echo '<br/>закончили вставлять';
} catch (\PDOException $ex) {

    echo '<pre>--- ' . __FILE__ . ' ' . __LINE__ . '-------'
    . PHP_EOL . $ex->getMessage() . ' #' . $ex->getCode()
    . PHP_EOL . $ex->getFile() . ' #' . $ex->getLine()
    . PHP_EOL . $ex->getTraceAsString()
    . '</pre>';
}
