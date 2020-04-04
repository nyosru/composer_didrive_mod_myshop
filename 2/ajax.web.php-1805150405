<?php

//namespace Nyos\mod;
//
//use Nyos\mod\lk as lk;
//$_SESSION['status1'] = true;

if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
    ini_set('display_errors', 'On'); // сообщения с ошибками будут показываться
    error_reporting(E_ALL); // E_ALL - отображаем ВСЕ ошибки
}

date_default_timezone_set("Asia/Yekaterinburg");
define('IN_NYOS_PROJECT', true);

// sleep(1);

require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.site/0.cfg.start.php' );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/index.session_start.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/class/nyos.2.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/f/ajax.php' );


// отправляем заказ админу
// send_order	y
if (isset($_REQUEST['send_order'])) {

    if (sizeof($_REQUEST['item_select']) == 0)
        f\end2('Обнаружен недочёт: В заказе нет товаров', false);

    // foreach( )
    require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/sql.start.php');

    require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.site/exe/myshop/class.php');
    require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'txt.2.php' );

    $list = \Nyos\mod\myshop::getItems($db, $_REQUEST['shop']);
    //f\pa($list);

    require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/class/mail.2.php' );

    // $emailer->ns_new($sender2, $adrsat);
    // $emailer->ns_send('сайт ' . domain . ' > новое сообщение', str_replace($r1, $r2, $ctpl->tpl_files['bw.mail.body']));
    //$status = '';

    $info = '<blockquote style="border;left: 3px solid gray; padding-left: 15px; color: black; line-height:30px;" >ФИО: ' . addslashes($_REQUEST['fio']) . '<br/>'
            . 'Тел: ' . addslashes($_REQUEST['phone'])
            . ( isset($_REQUEST['mail']{0}) ? '<br/>'
            . 'E-mail: <a href="mailto:' . addslashes($_REQUEST['mail']) . '">' . addslashes($_REQUEST['mail']) . '</a>' : '' )
            . ( isset($_REQUEST['adres']{0}) ? '<br/>'
            . 'Адрес: ' . addslashes($_REQUEST['adres']) : '' )
            . '</blockquote>'
            . '<br/>'
            . '<br/>'
            . '<style>'
            . 'table.list td{ padding: 10px; }'
            . 'table.list tr:nth-child(2n) td{ background-color: #f3f3f3; }'
            . '.r{ text-align:right; }'
            . '.w{background-color:white; padding:2px;}'
            . '</style>'
            . '<table width="100%" class="list" >'
            . '<tr>'
            . '<th>Наименование</th>'
            . '<th width="1%" >Цена</th>'
            . '<th width="1%" >Кол-во</th>'
            . '<th width="1%" >Сумма</th>'
            . '</tr>';

    $sum = 0;
    foreach ($_REQUEST['kolvo'] as $k => $v) {
        if ($v > 0 && isset($_REQUEST['item_select'][$k]) && isset(Nyos\mod\myshop::$items[$k])) {

            if (isset($_SESSION['on_cart'][$k]))
                unset($_SESSION['on_cart'][$k]);

            $info .= '<tr>'
                    . '<td><span class="w">#' . Nyos\mod\myshop::$items[$k]['id'] . '</span> <b>' . Nyos\mod\myshop::$items[$k]['name'] . '</b>'
                    . '<br/><small>' . Nyos\mod\myshop::$items[$k]['opis'] . '</small></td>'
                    . '<td class="r">' . number_format(Nyos\mod\myshop::$items[$k]['price'], 0, '', '`') . '</td>'
                    . '<td>' . $v . '</td>'
                    . '<td class="r">' . number_format(ceil($v * Nyos\mod\myshop::$items[$k]['price']), 0, '', '`') . '</td>'
                    . '</tr>';
            $sum += $v * Nyos\mod\myshop::$items[$k]['price'];
        }
    }

    $info .= '<tr>'
            . '<th style="text-align:right;" colspan="3" >Итого:</th>'
            . '<th>' . number_format($sum, 0, '', '`') . '</th>'
            . '</tr>';

    $info .= '</table>';

    Nyos\mod\mailpost::sendNow($db, 'support@uralweb.info', '1@uralweb.info', 'Новый заказ в интернет магазине', 'nexit_myshop', array('text' => $info));

    //echo $status;


    f\end2('Заказ сформирован, спасибо! в ближайшее время позвоним уточнить детали заказа');
}
// добавление в корзину
elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 'add_to_cart' && isset($_REQUEST['id'])) {
    
    $_SESSION['on_cart'][$_REQUEST['id']] = array( 'kolvo' => 1, 'options' => serialize($_REQUEST['select_option']) );
    
    \f\end2('ок', true);
}
// удаление из корзины
elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 'edit_kolvo_in_cart' && isset($_REQUEST['item'])) {

    if (isset($_SESSION['on_cart'][$_REQUEST['item']]))
        $_SESSION['on_cart'][$_REQUEST['item']]['kolvo'] = $_REQUEST['new_kolvo'];

    \f\end2('ок', true);
}
// удаление из корзины
elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 'remove_from_cart' && isset($_REQUEST['id'])) {

    if (isset($_SESSION['on_cart'][$_REQUEST['id']]))
        unset($_SESSION['on_cart'][$_REQUEST['id']]);

    \f\end2('ок', true);
}
// надпись для информера корзины
elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 'get_nadpis_for_cart') {

    if( !isset($_SESSION['on_cart']) )
    $_SESSION['on_cart'] = array();
    
    require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/f/txt.2.php' );
    $kolvo = sizeof($_SESSION['on_cart']);

    require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/sql.start.php');
    require_once $_SERVER['DOCUMENT_ROOT'] . '/0.site/exe/myshop/class.php';
    $items = Nyos\mod\myshop::getItems($db, $_REQUEST['shop']);
    // f\pa($items);
    // cart_price
    // f\pa($_REQUEST['active_items']);
    
        $sum = 0;
    
    if (isset($_REQUEST['active_items']{0})) {

        $r = explode(',', $_REQUEST['active_items']);
        $active = array();
        //echo '<pre>'; print_r($r); echo '</pre>';
        foreach ($r as $k => $v) {
            $active[$v] = 1;
        }

        foreach ($_SESSION['on_cart'] as $k => $v) {
            if (isset($active[$k]) && isset($items[$k]['price']))
                $sum += ceil($v['kolvo'] * $items[$k]['price']);
        }
    }else {

        if (isset($_SESSION['on_cart']) && sizeof($_SESSION['on_cart']) > 0) {
            foreach ($_SESSION['on_cart'] as $k => $v) {
                if (isset($items[$k]['price']))
                    $sum += ceil($v['kolvo'] * $items[$k]['price']);
            }
        }
    }

    // $_SESSION['on_cart'][$_REQUEST['id']] = 1;
    \f\end2('ок', true, array('nadpis' => $kolvo . ' товар' . \f\txt_okonchanie($kolvo), 'summa' => ( $sum == 0 ? '' : number_format($sum, 0, '', ' ') . ' Р') ) );
}

\f\end2('Неописуемая ситуация #' . __LINE__, false);

// проверяем секрет
if (
        isset($_REQUEST['id']{0}) && isset($_REQUEST['s']{5}) &&
        Nyos\nyos::checkSecret($_REQUEST['s'], $_REQUEST['id']) === true
) {
    
}
//
else {
    f\end2('Произошла неописуемая ситуация #' . __LINE__ . ' обратитесь к администратору ' // . $_REQUEST['id'] . ' && ' . $_REQUEST['secret']
            , 'error');
}


require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/sql.start.php');
//require( $_SERVER['DOCUMENT_ROOT'] . '/0.site/0.cfg.start.php');
//require( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'class' . DS . 'mysql.php' );
//require( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'db.connector.php' );


if (isset($_REQUEST['types']) && $_REQUEST['types'] == 'send_order') {

    require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.site/exe/myshop/class.php');
    require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'txt.2.php' );

    Nyos\mod\myshop::getItems($db, $_REQUEST['id']);
    // f\pa(Nyos\mod\myshop::$items);

    require_once( $_SERVER['DOCUMENT_ROOT'] . '/0.all/class/mail.2.php' );

    // $emailer->ns_new($sender2, $adrsat);
    // $emailer->ns_send('сайт ' . domain . ' > новое сообщение', str_replace($r1, $r2, $ctpl->tpl_files['bw.mail.body']));
    //$status = '';

    $info = 'ФИО: ' . $_REQUEST['fio'] . '<br/>'
            . 'Тел: ' . $_REQUEST['phone'] . '<br/>'
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
    foreach ($_REQUEST['item'] as $k => $v) {
        if (isset(Nyos\mod\myshop::$items[$k]) && $v['kolvo'] > 0) {
            $info .= '<tr>'
                    . '<td>' . Nyos\mod\myshop::$items[$k]['name'] . '( ' . Nyos\mod\myshop::$items[$k]['opis'] . ' )</td>'
                    . '<td>' . $v['kolvo'] . '</td>'
                    . '<td>' . Nyos\mod\myshop::$items[$k]['price'] . '</td>'
                    . '<td>' . ($v['kolvo'] * Nyos\mod\myshop::$items[$k]['price']) . '</td>'
                    . '</tr>';
            $sum += $v['kolvo'] * Nyos\mod\myshop::$items[$k]['price'];
        }
    }

    $info .= '<tr>'
            . '<th style="text-align:right;" colspan="3" >Итого:</th>'
            . '<th>' . $sum . '</th>'
            . '</tr>';

    $info .= '</table>';

    Nyos\mod\mailpost::sendNow($db, 'support@uralweb.info', '1@uralweb.info', 'Новый заказ в интернет магазине', 'nexit_myshop', array('text' => $info));

    //echo $status;

    f\end2('Заявка отправлена, в ближайшее время позвоним уточнить заказ');

    //f\end2('Произошла неописуемая ситуация #' . __LINE__ . ' обратитесь к администратору', 'error');
} elseif (isset($_POST['action']) && $_POST['action'] == 'edit_pole') {

    require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'db.2.php' );
    require_once( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'txt.2.php' );

    // $_SESSION['status1'] = true;
    // $status = '';
    \f\db\db_edit2($db, 'mitems', array('id' => (int) $_POST['id']), array($_POST['pole'] => $_POST['val']));

    // f\end2( 'новый статус ' . $status);
    f\end2('новый статус ' . $_POST['val']);
}


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
