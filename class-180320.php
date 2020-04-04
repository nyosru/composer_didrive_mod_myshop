<?php

namespace Nyos\mod;

//echo __FILE__.'<br/>';
// строки безопасности
if (!defined('IN_NYOS_PROJECT'))
    die('<center><h1><br><br><br><br>Cтудия Сергея</h1><p>Сработала защита <b>TPL</b> от злостных розовых хакеров.</p>
    <a href="http://www.uralweb.info" target="_blank">Создание, дизайн, вёрстка и программирование сайтов.</a><br />
    <a href="http://www.nyos.ru" target="_blank">Только отдельные услуги: Дизайн, вёрстка и программирование сайтов.</a>');

require_once $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'dbi.php';

class myshop {

    public static $config_shop = array();
    public static $cats = array();
    public static $items = array();

    /**
     * получение списка магазинов
     * @global type $status
     * @param type $db
     * @param type $user
     * @return boolean
     */
    public static function getShops($db, $id_shop) {

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            global $status;

            //$show_status = true;
            if (isset($show_status) && $show_status === true)
                $status = '';

            $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
        }

        // если пользователь
        if (isset($user) && ( $user === null || is_numeric($user) )) {
            
        }
        // если не пользователь
        else {
            return false;
        }

        $return = \f\db\getSql($db, 'SELECT * FROM `m_myshop` WHERE `id` = \'' . (int) $id_shop . '\' ;');

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            if (isset($show_status) && $show_status === true)
                echo $status;
        }

        return $return;
    }

    public static function getCats($db, $id_shop) {

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            global $status;

            //$show_status = true;
            if (isset($show_status) && $show_status === true)
                $status = '';

            $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
        }

        if (isset($id_shop) && is_numeric($id_shop)) {
            
        } else {
            return \f\end2('неописуемая ситуация #' . __LINE__, false, array(), 'array');
        }

        self::$cats = \f\db\getSql($db, 'SELECT * FROM `m_myshop_cats` WHERE `shop` = \'' . $id_shop . '\' AND `status` != \'del\' ;');

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            if (isset($show_status) && $show_status === true)
                echo $status;
        }

        return self::$cats;
    }

    /**
     * 
     * @global \Nyos\mod\type $status
     * @param type $db
     * @param type $id_shop
     * @param type $dops
     * no-cat - если магазин без каталогов
     * @return type
     */
    public static function getItems($db, $id_shop, $dops = null) {

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            global $status;

            //$show_status = true;
            if (isset($show_status) && $show_status === true)
                $status = '';

            $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
        }

        if (isset($id_shop) && is_numeric($id_shop)) {
            
        } else {
            return \f\end2('неописуемая ситуация #' . __LINE__, false, array(), 'array');
        }

            self::$items = \f\db\getSql($db, 'SELECT `m_myshop_items`.* FROM `m_myshop_items` '
                    . 'WHERE '
                    . '`m_myshop_items`.`shop` = \'' . $id_shop . '\' '
                    . 'AND `m_myshop_items`.`status` != \'del\' '
                    . 'ORDER BY `sort` DESC;');

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            if (isset($show_status) && $show_status === true)
                echo $status;
        }

        return self::$items;
    }

}
