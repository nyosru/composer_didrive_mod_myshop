<?php

//namespace Nyos\mod;
//
//use Nyos\mod\lk as lk;
// $_SESSION['status1'] = true;

if (1 == 1 || ( isset($_SESSION['status1']) && $_SESSION['status1'] === true )) {
    ini_set('display_errors', 'On'); // сообщения с ошибками будут показываться
    error_reporting(E_ALL); // E_ALL - отображаем ВСЕ ошибки
}

if (isset($start_action) && $start_action == 'scan_new_datafile') {
    
} else {

    date_default_timezone_set("Asia/Yekaterinburg");
    define('IN_NYOS_PROJECT', true);
    require_once( $_SERVER['DOCUMENT_ROOT'] . '/all/0.start.php' );
}

// echo '<pre>'; print_r($_REQUEST); echo '<pre>'; die();
// сканирование дата файлов магазинов
if (isset($start_action) && $start_action == 'scan_new_datafile' || ( isset($_GET['action']) && $_GET['action'] == 'scan_new_datafile' )) {

    // f\pa($now);
    // \f\pa($now, 2);
    // \f\pa($vv, 2);
    // \Nyos\Nyos:: getMenu();
    // \f\pa($amnu);
    // \f\pa($amnu);

    foreach (\Nyos\Nyos::$menu as $k1 => $v1) {

        // echo '<br/>'.__LINE__.' '.$k1;
        // \f\pa($v1);

        if (isset($v1['type']) && $v1['type'] == 'myshop' && isset($v1['version']) && $v1['version'] == 2) {

            // echo '<br/>' . __LINE__ . ' ' . $k1;

            if (isset($v1['datain_name_file']) && file_exists(dir_serv_site_sd . 'datain' . DS . $v1['datain_name_file'])) {

                require_once $_SERVER['DOCUMENT_ROOT'] . '/module/myshop/class.php';

                $e = \Nyos\mod\myshop::getShopFromDomain($db);
                // \f\pa($e);

                if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/site'))
                    $e['id'] = 1;

                $e2 = \Nyos\mod\myshop::loadDataFileForShop($db, $e['id'], dir_serv_site_sd . 'datain' . DS . $v1['datain_name_file']);

                \Nyos\mod\myshop::deleteCash($db, $e['id']);

                if (isset($start_action) && $start_action == 'scan_new_datafile')
                    \f\redirect('/', 'index.php', $_GET);
            }
        }
    }

    if (isset($start_action) && $start_action == 'scan_new_datafile') {
        \f\redirect('/', 'index.php', $_GET);
    }

    die(' обработка завершена #' . __LINE__);
}

// проверяем секрет
if (
        (
        isset($_REQUEST['id']{0}) && isset($_REQUEST['s']{5}) &&
        Nyos\nyos::checkSecret($_REQUEST['s'], $_REQUEST['id']) === true
        ) || (
        isset($_REQUEST['show']{0}) &&
        isset($_REQUEST['id']{0}) && isset($_REQUEST['s']{5}) &&
        Nyos\nyos::checkSecret($_REQUEST['s'], $_REQUEST['show'] . $_REQUEST['id']) === true
        ) || (
        isset($_REQUEST['action']{0}) &&
        isset($_REQUEST['id']{0}) && isset($_REQUEST['s']{5}) &&
        Nyos\nyos::checkSecret($_REQUEST['s'], $_REQUEST['action'] . $_REQUEST['id']) === true
        )
) {
    
}
//
else {
    f\end2('Произошла неописуемая ситуация #' . __LINE__ . ' обратитесь к администратору ' // . $_REQUEST['id'] . ' && ' . $_REQUEST['secret']
            , 'error');
}

//require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/sql.start.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/all/sql.start.php');
//require( $_SERVER['DOCUMENT_ROOT'] . '/0.site/0.cfg.start.php');
//require( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'class' . DS . 'mysql.php' );
//require( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'db.connector.php' );


if (isset($_REQUEST['show']) && $_REQUEST['show'] == 'show_admin_option_cat') {

    /*
      require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'db.2.php' );
     * */
    require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'txt.2.php' );
    /*
      // $_SESSION['status1'] = true;
      // $status = '';
      \f\db\db_edit2($db, 'mitems', array('id' => (int) $_POST['id']), array($_POST['pole'] => $_POST['val']));

      // f\end2( 'новый статус ' . $status);
      f\end2('новый статус ' . $_POST['val']);
     */

//$_SESSION['status1'] = true;
//$status = '';
    $sql = $db->sql_query('SELECT
        m_myshop_cats_option.id AS option_id,
        m_myshop_cats_option_var.id,
        m_myshop_cats_option.name,
        
        `m_myshop_cats_option`.`status` AS `opt_status`,
        `m_myshop_cats_option_var`.`status`,
        
        `m_myshop_cats_option`.`sort` AS `opt_sort`,
        `m_myshop_cats_option_var`.`sort`,
        
        m_myshop_cats_option_var.var,
        m_myshop_cats_option_var.var_number,
        m_myshop_cats_option_var.var_number2
      FROM m_myshop_cats
        INNER JOIN m_myshop_cats_option
          ON m_myshop_cats_option.id_cat = m_myshop_cats.id
        INNER JOIN m_myshop_cats_option_var
          ON m_myshop_cats_option_var.id_option = m_myshop_cats_option.id
      WHERE m_myshop_cats.id = \'' . addslashes($_REQUEST['id']) . '\'
      ORDER BY 
        m_myshop_cats_option.sort DESC
        ,m_myshop_cats_option_var.sort DESC
      ;');
//echo $status;

    $va = array(
        'cat' => $_REQUEST['id']
        , 'res_div' => '#option_' . $_REQUEST['id']
        , 'res_key' => $_REQUEST['id']
        , 'res_s' => $_REQUEST['s']
    );

    // $t = '';

    while ($r = $db->sql_fr($sql)) {
        $va['items'][] = $r;
        /*
          $t .= '<hr>';

          foreach ($r as $k1 => $v1) {
          $t .= $k1 . ' - ' . $v1 . '<br/>';
          }
         */
    }

    // f\pa($res);
    // body.cats.ajax.option.htm

    f\end2(\f\compileSmarty(dirname(__FILE__) . DS . 'didrive' . DS . 't' . DS . 'body.cats.ajax.option.htm', $va), true);
}
//
elseif (isset($_REQUEST['types']) && $_REQUEST['types'] == 'send_order') {

    //require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.site/exe/myshop/class.php');
    require_once( $_SERVER['DOCUMENT_ROOT'] . '/module/myshop/class.php');
    require_once( $_SERVER['DOCUMENT_ROOT'] . DS . 'include' . DS . 'f' . DS . 'txt.php' );

    Nyos\mod\myshop::getItems($db, $_REQUEST['id']);
    // f\pa(Nyos\mod\myshop::$items);

    $vv['folder'] = Nyos\nyos::getFolder($db);

    // $amnu = Nyos\nyos::get_menu($vv['folder']);
    \Nyos\Nyos::getMenu();
    //f\pa($amnu);


    if (isset($_SESSION['now_user']['phone']) && isset($_REQUEST['phone']) && $_SESSION['now_user']['phone'] != $_REQUEST['phone']) {

        // $db->sql_query('UPDATE `gm_user` SET `phone` = \'' . addslashes($_REQUEST['phone']) . '\' WHERE `id` = ' . $_SESSION['now_user']['id'] . ' ;');
        $_SESSION['now_user']['phone'] = $_REQUEST['phone'];
    }

    //\f\pa(Nyos\mod\myshop::$items,2);

    //\f\pa(\Nyos\Nyos::$menu);

    foreach (\Nyos\Nyos::$menu as $k => $v) {

//        echo '<br/>'.$k.' '.__LINE__;
//        \f\pa($v,2);
//
//        echo '<br/>';
        
        $cfg = null;

        if ( $v['type'] == 'myshop' && $v['version'] == 2 ) {
            $cfg = $v;
            //echo '<br/>#'.__LINE__;
            //break;
        }

        if (empty($cfg))
            continue;

//        echo '<br/>#'.__LINE__;
//        echo '<pre>'; print_r($cfg); echo '</pre>';


        // $emailer->ns_new($sender2, $adrsat);
        // $emailer->ns_send('сайт ' . domain . ' > новое сообщение', str_replace($r1, $r2, $ctpl->tpl_files['bw.mail.body']));
        //$status = '';

        $info = 'ФИО: ' . $_REQUEST['fio'] . ( isset($_REQUEST['user_type']{1}) ? ' (' . $_REQUEST['user_type'] . ')' : '' ) . '<br/>'
                . 'Тел: ' . $_REQUEST['phone']
                . '<br/>'
                . '<br/>'
                . '<style>'
                . 'table.list td{ padding: 10px; }'
                . 'table.list tr:nth-child(2n) td{ background-color: #efefef; }'
                . '</style>'
                . '<table width="100%" class="list" >'
                . '<tr>'
                . '<th>Наименование</th>'
                . '<th>Количество</th>'
                . '<th>Цена</th>'
                . '<th>Сумма</th>'
                . '</tr>';
        $sum = 0;

        $in_csv = '';



        if (isset($_SESSION['now_user']['now_price'])) {
            $now_price = $_SESSION['now_user']['now_price'];
        } else {
            $now_price = 0;
        }

//        echo '<pre>'; print_r(Nyos\mod\myshop::$items); echo '</pre>';
        
        foreach ($_REQUEST['item'] as $k => $v) {
            if (isset(Nyos\mod\myshop::$items[$k]) && $v['kolvo'] > 0) {



                if ($now_price == 2 && Nyos\mod\myshop::$items[$k]['price'] > 0) {
                    $price = Nyos\mod\myshop::$items[$k]['price'];
                } elseif ($now_price == 1 && Nyos\mod\myshop::$items[$k]['price1'] > 0) {
                    $price = Nyos\mod\myshop::$items[$k]['price1'];
                } elseif ($now_price == 0 && Nyos\mod\myshop::$items[$k]['price2'] > 0) {
                    $price = Nyos\mod\myshop::$items[$k]['price2'];
                } else {
                    $price = 0;
                }


                $info .= '<tr>'
                        . '<td>' . Nyos\mod\myshop::$items[$k]['name'] . ( strlen(Nyos\mod\myshop::$items[$k]['opis']) < 150 ? '( ' . Nyos\mod\myshop::$items[$k]['opis'] . ' )' : '' ) . '</td>'
                        . '<td style="text-align:right;" >' . $v['kolvo'] . '</td>'
                        . '<td style="text-align:right;" >' . number_format($price, 2, '.', '`') . '</td>'
                        . '<td style="text-align:right;" >' . number_format(( $v['kolvo'] * $price), 2, '.', '`') . '</td>'
                        . '</tr>';

                $sum += $v['kolvo'] * $price;

                $in_csv .= date('ymdhis', $_SERVER['REQUEST_TIME']) . ';"'
                        . $_REQUEST['fio'] . ' ( ' . ( isset($_SESSION['now_user']['name']) ? $_SESSION['now_user']['name'] . ' ' . $_SESSION['now_user']['family'] : '' )
                        . ' | ' . ( isset($_SESSION['now_user']['soc_web_link']) ? $_SESSION['now_user']['soc_web_link'] : '' )
                        . ' | ' . $_REQUEST['user_type']
                        . ')";"' . $_REQUEST['phone'] . '";"' . Nyos\mod\myshop::$items[$k]['name'] . '";"' . Nyos\mod\myshop::$items[$k]['opis'] . '";"' . Nyos\mod\myshop::$items[$k]['articul'] . '";' . $v['kolvo'] . ';;' . $price . ';' . ( $price * $v['kolvo']) . ';' . PHP_EOL;
            }
        }

        $info .= '<tr>'
                . '<th style="text-align:right;" colspan="3" >Итого:</th>'
                . '<th>' . number_format($sum, 2, '.', '`') . '</th>'
                . '</tr>';

        $info .= '</table>';

    // echo $cfg['mail_for_order'];

    require_once( $_SERVER['DOCUMENT_ROOT'] . '/include/mail.php' );
    
    if ( class_exists('Nyos\mod\mailpost')) {
        Nyos\mod\mailpost::addNewFile('zakaz_' . date('Y-m-d-h-i-s', $_SERVER['REQUEST_TIME']) . '.csv', iconv('utf-8', 'windows-1251', 'НомерДокП;Заказчик;Телефон;Наименование;Добавка;КодТ;Количество;Упаковок;Цена;Сумма' . PHP_EOL
            . ( isset($in_csv) ? $in_csv : '' )   )
        );
    }

    /*
      НомерДокП ; Заказчик ; Телефон ; Наименование ; Добавка ; КодТ ; Количество ; Упаковок ; Цена ; Сумма
      датаивремятранзакции, лучше лдни чисоа;ФИО;922-0222-02-54;Масло сливочное;в развес;46)1*22%1+1=0(18;1;0;320;320
      датаивремятранзакции, лучше лдни чисоа;ФИО;922-0222-02-55;Мед;алтайский;46)1*22%1+4=0(18;3;0;200;600
      датаивремятранзакции, лучше лдни чисоа;ФИО;922-0222-02-56;Сыр;Адыгейский;46)1*22%1+2=0(18;4;0;210;840
      678837637367;ФИО;922-0222-02-57;Сыр;Сулугуни;46)1*22%1+3=0(18;4;0;310;1240
     */

//  [dop] => Array
//        (
//            [logo_img] => logo_img..180426090816.png
//            [email_to_order] => mr.maxb
    //$status = '';
    //echo '<pre>'; print_r($cfg); echo '</pre>';

    $vars = array('text' => ( isset($info{5}) ? $info : 'xxx' ) ) ;

    // \f\pa($cfg);

    foreach ($cfg as $k1 => $v1) {
        if (strpos($k1, 'for_mail_') !== false) {
            $vars[$k1] = $v1;
            //echo $k1.'<br/>';
        }
    }

    //echo '<pre>'; print_r($vars); echo '</pre>';

    \Nyos\mod\mailpost::sendNow($db, 'support@uralweb.info', 'support-shop@uralweb.info,sergej.baklanov.1@mail.ru,' . trim($cfg['mail_for_order']), 'Заказ в интернет магазине ' . ( isset($cfg['name_shop']) ? $cfg['name_shop'] : $_SERVER['HTTP_HOST'] ), 'nexit_myshop.smarty', $vars);
    // Nyos\mod\mailpost::sendNow($db, 'support@uralweb.info', 'support-shop@uralweb.info,sergej.baklanov.1@mail.ru,' . trim($cfg['mail_for_order']), 'Заказ в интернет магазине ' . ( isset($cfg['name_shop']) ? $cfg['name_shop'] : $_SERVER['HTTP_HOST'] ), 'nexit_myshop.smarty', $vars);
    //Nyos\mod\mailpost::sendNow($db, 'support@uralweb.info', 'support-shop@uralweb.info,sergej.baklanov.1@mail.ru', 'Заказ в интернет магазине ' . ( isset($cfg['name_shop']) ? $cfg['name_shop'] : $_SERVER['HTTP_HOST'] ), 'nexit_myshop', array('text' => $info));
    //Nyos\mod\mailpost::sendNow($db, 'support@uralweb.info', 'support-shop@uralweb.info', 'Заказ в интернет магазине ' . ( isset($cfg['name_shop']) ? $cfg['name_shop'] : $_SERVER['HTTP_HOST'] ), 'nexit_myshop', array('text' => $info));
    //echo $status;

    \f\end2('Заявка отправлена, в ближайшее время позвоним уточнить заказ');
    }

    //f\end2('Произошла неописуемая ситуация #' . __LINE__ . ' обратитесь к администратору', 'error');
}

// добавление каталога с опциями для товаров в каталог
elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'add_cat_options') {

    if (isset($_REQUEST['opt_name']{2}) && isset($_REQUEST['opt_vars']{3})) {

        $vars = explode(PHP_EOL, $_REQUEST['opt_vars']);

        $e = array();

        foreach ($vars as $k => $v) {
            // $e .= ' '.$v;    
            $e[] = array('var' => $v);
        }


        // $_SESSION['status1'] = true;
        // $status = '';

        $indb1 = array(
            'id_cat' => $_REQUEST['id']
            , 'name' => $_REQUEST['opt_name']
            , 'hand_select' => $_REQUEST['hand_select']
        );

        if (isset($_REQUEST['change_price']))
            $indb1['change_price'] = 'yes';

        $new_opt = \f\db\db2_insert($db, 'm_myshop_cats_option', $indb1, 'da', 'last_id');
        //echo $status;
        \f\db\sql_insert_mnogo($db, 'm_myshop_cats_option_var', $e, array('id_option' => $new_opt), true);

        f\end2('ОКЕЙ, добавили. Перезагружаю список опций.', true, array(
            //f\end2('ОКЕЙ, добавили. Перезагружаю список опций.'.$status, false , array(
            'res_div' => ( isset($_REQUEST['res_div']{0}) ? $_REQUEST['res_div'] : null )
            , 'res_key' => ( isset($_REQUEST['res_key']{0}) ? $_REQUEST['res_key'] : null )
            , 'res_s' => ( isset($_REQUEST['res_s']{0}) ? $_REQUEST['res_s'] : null )
        ));
    }

    f\end2('Произошла неописуемая ситуация #' . __LINE__ . ' обратитесь к администратору', 'error');
}
//
elseif (isset($_POST['action']) && $_POST['action'] == 'edit_pole') {

    require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'db.2.php' );
    require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'txt.2.php' );

    // $_SESSION['status1'] = true;
    // $status = '';
    \f\db\db_edit2($db, 'mitems', array('id' => (int) $_POST['id']), array($_POST['pole'] => $_POST['val']));

    // f\end2( 'новый статус ' . $status);
    f\end2('новый статус ' . $_POST['val']);
}
//
f\end2('Произошла неописуемая ситуация #' . __LINE__ . ' обратитесь к администратору', 'error');








// печать купона
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'print' && isset($_REQUEST['kupon']{0}) && is_numeric($_REQUEST['kupon']{0})) {
    
}

if (1 == 2) {

// печать купона
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'print' && isset($_REQUEST['kupon']{0}) && is_numeric($_REQUEST['kupon']{0})) {

        require( $_SERVER['DOCUMENT_ROOT'] . DS . '0.site' . DS . 'exe' . DS . 'kupons' . DS . 'class.php' );

        $folder = Nyos\nyos::getFolder($db);
        // echo $folder;

        die(Nyos\mod\kupons::showHtmlPrintKupon($db, $folder, $_REQUEST['kupon']));
    }

//<input type='hidden' name='get_cupon' value='da' />
    elseif (isset($_REQUEST['get_cupon']) && $_REQUEST['get_cupon'] == 'da') {

        require( $_SERVER['DOCUMENT_ROOT'] . DS . '0.site' . DS . 'exe' . DS . 'kupons' . DS . 'class.php' );
        require( $_SERVER['DOCUMENT_ROOT'] . '/0.all/f/txt.2.php' );

        $get = $_REQUEST;

        $get['phone'] = f\translit($get['phone'], 'cifr');
        $get['kupon'] = $get['id'];
        $get['email'] = trim(strtolower($get['email']));

        $res = Nyos\mod\kupons::addPoluchatel($db, $get);

        if (isset($_COOKIE['fio']{0}) && $_COOKIE['fio'] != $get['fio'])
            setcookie("fio", $get['fio'], time() + 24 * 31 * 3600, '/');

        if (isset($_COOKIE['tel']{0}) && $_COOKIE['tel'] != $get['phone'])
            setcookie("tel", $get['phone'], time() + 24 * 31 * 3600, '/');

        if (isset($_COOKIE['email']{0}) && $_COOKIE['email'] != $get['email'])
            setcookie("email", $get['email'], time() + 24 * 31 * 3600, '/');

        setcookie("cupon" . $get['kupon'], $res['number_kupon'], time() + 24 * 31 * 3600, '/');

        if ($_REQUEST['id'] == 2) {
            f\end2('<h3>Добро пожаловать</h3>'
                    . '<Br/>'
                    . '<p>Регистрация проведена успешно</p>'
                    . '<Br/>'
                    . '<Br/>'
                    , 'ok');
        } else {
            // f\pa($res);
            f\end2('<h3>Липон получен !<br/><br/>№' . $res['number_kupon'] . '</h3>'
                    . '<Br/>'
                    . '<p>Сообщите номер липона в магазине и воспользуйтесь скидкой!</p>'
                    . '<Br/>'
                    . '<Br/>'
                    , 'ok', array('number_kupon' => $res['number_kupon'])
            );
        }
    }

// получение купона по новому (сразу по кнопе)
    elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'get_cupon17711') {

        // echo '<pre>'; print_r($_COOKIE); echo '</pre>';    exit;

        $vname = 'fio';
        if (isset($_REQUEST[$vname]{0})) {
            $$vname = $_REQUEST[$vname];
        } elseif (isset($_COOKIE[$vname]{0})) {
            $$vname = $_COOKIE[$vname];
        }

        $vname = 'tel';
        if (isset($_REQUEST[$vname]{0})) {
            $$vname = $_REQUEST[$vname];
        } elseif (isset($_COOKIE[$vname]{0})) {
            $$vname = $_COOKIE[$vname];
        }

        $vname = 'email';
        if (isset($_REQUEST[$vname]{0})) {
            $$vname = $_REQUEST[$vname];
        } elseif (isset($_COOKIE[$vname]{0})) {
            $$vname = $_COOKIE[$vname];
        }

        $vname = 'kupon';
        if (isset($_REQUEST[$vname]{0})) {
            $$vname = $_REQUEST[$vname];
        }

        if (
                isset($fio{0}) &&
                isset($tel{0}) &&
                isset($email{0}) &&
                isset($kupon{0})
        ) {

            require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.site' . DS . 'exe' . DS . 'kupons' . DS . 'class.php' );
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/f/txt.2.php' );

            $get['fio'] = $fio;
            $get['phone'] = f\translit($tel, 'cifr');
            $get['kupon'] = $kupon;
            $get['email'] = trim(strtolower($email));

            //получаем менюшку
            if (1 == 1) {
                $folder = Nyos\nyos::getFolder($db);
                $mnu = Nyos\nyos::creat_menu($folder);
                // f\pa($mnu);

                foreach ($mnu[1] as $k => $v) {
                    //f\pa($v);
                    if ($v['type'] == 'kupons') {
                        $get['now_level'] = $v;
                        break;
                    }
                }
            }

            //f\pa($get);

            $res = Nyos\mod\kupons::addPoluchatel($db, $get, $folder);
            // f\pa($res);

            if ($res['status'] == 'error') {
                f\end2($res['html'], 'error', array('line' => __LINE__));
            }

            // echo '<pre>'; print_r($res); echo '</pre>';

            foreach ($_COOKIE as $k => $v) {
                if ($k == 'fio' || $k == 'tel' || $k == 'email')
                    setcookie($k, $v, time() + 24 * 31 * 3600, '/');
            }

            //setcookie("cupon" . $get['kupon'], $res['number_kupon'], time() + 24 * 31 * 3600, '/');

            if (isset($res['number_kupon']{0})) {

                // отправяляем письмо сданными липона пользователю
                // $vars = Nyos\mod\kupons::getItem($folder, $db, $res['number_kupon'], null);

                setcookie("cupon" . $kupon, $res['number_kupon'], time() + 24 * 31 * 3600, '/');

                //f\pa($vars);

                foreach ($_COOKIE as $k => $v) {
                    if ($k == 'fio' || $k == 'tel' || $k == 'email')
                        $vars[$k] = $v;
                }

                /*
                  require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/class/mail.2.php' );
                  //require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/f/smarty.php' );
                  // Nyos\mod\mailpost::$body = f\compileSmarty( 'lipon_get_lipon.smarty.htm', $vars, $_SERVER['DOCUMENT_ROOT'].DS.'template-mail' );
                  Nyos\mod\mailpost::$sendpulse_id = $_ss['sendpulse_id'];
                  Nyos\mod\mailpost::$sendpulse_id = '1';
                  Nyos\mod\mailpost::$sendpulse_key = $_ss['sendpulse_key'];
                  Nyos\mod\mailpost::sendNow($db, $_ss['mail_from'], $email, ( isset($_ss['mail_head_newcupon']{2}) ? $_ss['mail_head_newcupon'] : 'Получен купон'), 'lipon_get_lipon.smarty.htm', $vars);
                 */

                // sleep(3);
                // f\pa($res);
                f\end2('<h3>Липон получен !<br/><br/>№' . $res['number_kupon'] . '</h3>'
                        . '<Br/>'
                        . '<p>Сообщите номер липона в магазине и воспользуйтесь скидкой!</p>'
                        . '<Br/>'
                        . '<Br/>'
                        , 'ok', array('number_kupon' => $res['number_kupon'])
                );
            }
        }
        else {

            //require_once($_SERVER['DOCUMENT_ROOT'] . '/0.all/f/smarty.php');
            //f\end2(f\compileSmarty('ajax_form_enter.htm', array(), dirname(__FILE__) . '/../../lk/3/tpl_smarty/')
            /*
              f\end2( '1111111111111'
              , 'ok', array(
              'need_reg' => 'yes',
              'line' => __LINE__
              ));
             */

            //return false;
        }

        f\end2('Нужно войти в лк или зарегистрироваться'
                . '<Br/>'
                . '<Br/>'
                , 'error', array(
            'need_reg' => 'yes',
            'line' => __LINE__
        ));
    }

//<input type='hidden' name='get_cupon' value='da' />
    elseif (isset($_REQUEST['reg']) && $_REQUEST['reg'] == 'da') {

        require( $_SERVER['DOCUMENT_ROOT'] . DS . '0.site' . DS . 'exe' . DS . 'kupons' . DS . 'class.php' );
        require( $_SERVER['DOCUMENT_ROOT'] . '/0.all/f/txt.2.php' );

        $get = $_REQUEST;

        // $get['kupon'] = $get['id'];
        $get['name'] = $get['fio'];
        $get['mail'] = trim(strtolower($get['email']));
        $get['phone'] = f\translit($get['phone'], 'cifr');
        $get['pass'] = Nyos\nyos::creat_pass(5, 2);

        // $res = Nyos\mod\kupons::addPoluchatel($db, $get);

        setcookie("fio", $get['fio'], $_SERVER['REQUEST_TIME'] + 24 * 31 * 3600, '/');
        setcookie("tel", $get['phone'], $_SERVER['REQUEST_TIME'] + 24 * 31 * 3600, '/');
        setcookie("email", $get['mail'], $_SERVER['REQUEST_TIME'] + 24 * 31 * 3600, '/');

        // setcookie("cupon" . $get['kupon'], $get['number_kupon'], $_SERVER['REQUEST_TIME'] + 24 * 31 * 3600, '/');
        // шлём майл, шаблон такой-то
        // $get['send_reg_mail'] = 'kupon_reg';

        require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.site' . DS . 'exe' . DS . 'lk' . DS . 'class.php' );
        require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'db.2.php' );

        /*
         * $indb['reg_mail_head'] - тема письма о регистрации,
         * $indb['reg_mail_template'] - шаблон письма о регистрации
         * $indb['reg_mail_from_mail'] - майл отправителя
         * $indb['reg_mail_sendpulse_id'] - id sendpulse api
         * $indb['reg_mail_sendpulse_key'] - key sendpulse api
         */


        require_once( DirAll . 'class' . DS . 'nyos.2.php' );
        $now = Nyos\nyos::domain($db, $_SERVER['HTTP_HOST']);

        require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $now['folder'] . DS . 'index.php' );

        foreach ($_ss as $k => $v) {
            if (!isset($get[$k]))
                $get[$k] = $v;
        }

        $get['head'] = 'Регистрация';
        $ee = Nyos\mod\lk::regUser($db, $now['folder'], $get, 'array');

        if (isset($ee['reg_mail_sendpulse_id']))
            unset($ee['reg_mail_sendpulse_id']);

        if (isset($ee['reg_mail_sendpulse_key']))
            unset($ee['reg_mail_sendpulse_key']);

        if ($ee['status'] == 'ok') {
            f\end2($ee['html'], 'ok', $ee);
        } else {
            f\end2($ee['html'], $ee['status'], $ee);
        }
    }

// удалить город
    elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'del_city') {

        //$status = '';
        $db->sql_query('UPDATE `g_city` SET `show` = \'no\' WHERE `id` = \'' . $_REQUEST['id'] . '\' LIMIT 1 ;');
        // $db->sql_query('DELETE FROM `mpeticii_cat` WHERE `id` = 2 LIMIT 1;');

        f\end2('Город удалён');
    }

// удаляем каталог в дидрайве
    elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'del1') {

        //$status = '';
        $db->sql_query('UPDATE `gm_katalogi` SET `status` = \'hide\' WHERE `id` = \'' . $_REQUEST['id'] . '\' LIMIT 1 ;');
        // $db->sql_query('DELETE FROM `mpeticii_cat` WHERE `id` = 2 LIMIT 1;');

        f\end2('Каталог удалён');
    }
//
    elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'del_item') {

        $db->sql_query('UPDATE `mpeticii_item` SET `status` = \'cancel\' WHERE `id` = \'' . $_REQUEST['id'] . '\' LIMIT 1 ;');
        // $db->sql_query('DELETE FROM `mpeticii_cat` WHERE `id` = 2 LIMIT 1;');

        f\end2('Петиция удалёна');
    }
//
    elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'activated') {

        $db->sql_query('UPDATE `gm_katalogi` SET `status` = \'show\' WHERE `id` = \'' . $_REQUEST['id'] . '\' LIMIT 1 ;');
        // $db->sql_query('DELETE FROM `mpeticii_cat` WHERE `id` = 2 LIMIT 1;');

        f\end2('Восстановлен');
    }
    /**
     * удаление каталога совсем
     */ elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'del2') {

        $db->sql_query('DELETE FROM `gm_katalogi` WHERE `id` = \'' . $_REQUEST['id'] . '\' LIMIT 1;');

        f\end2('Каталог удалён совсем');
    }
}

f\end2('Произошла неописуемая ситуация #' . __LINE__ . ' обратитесь к администратору', 'error');
exit;
