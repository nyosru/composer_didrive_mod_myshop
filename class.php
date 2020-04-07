<?php

namespace Nyos\mod;

// use f as f;

//echo __FILE__.'<br/>';
// строки безопасности
if (!defined('IN_NYOS_PROJECT'))
    die('<center><h1><br><br><br><br>Cтудия Сергея</h1><p>Сработала защита <b>TPL</b> от злостных розовых хакеров.</p>
    <a href="http://www.uralweb.info" target="_blank">Создание, дизайн, вёрстка и программирование сайтов.</a><br />
    <a href="http://www.nyos.ru" target="_blank">Дизайн, вёрстка и программирование сайтов.</a>');

// require_once $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'dbi.php';


class myshop {

    public static $config_shop = array();
    public static $shop = array();
    public static $shop_id = null;
    public static $cats = array();
    public static $items = array();
    public static $items_img = array();
    public static $cash_file_items = '';

    public static function readDataFile(string $file_data, $type = '1c_win1251') {

        if ($type == '1c_win1251') {

            $handle = @fopen($file_data, "r");

            $t_head = null;
            $t_all = array();

            if ($handle) {

                $nn = 0;

                while (( $stroka = fgets($handle, 4096)) !== false) {

                    $nn++;

                    if (isset($r) && $r === true) {

                        $stroka = iconv('windows-1251', 'UTF-8', $stroka);

                        // обработка полученной строки

                        if ($t_head === null) {

                            $t_head_dop = $t_head = array();

                            $t = explode(';', $stroka);
                            // echo '<div style="background-color:gray;padding:5px;">'; f\pa($t); echo '</div>';

                            foreach ($t as $k => $v) {

                                $v = trim($v);

                                if ($v == 'Наименование') {
                                    $v1 = 'name';
                                } elseif ($v == 'Добавка') {
                                    $v1 = 'opis';
                                } elseif ($v == 'Организация') {
                                    $v1 = 'opis1';
                                } elseif ($v == 'Сайт') {
                                    $v1 = 'opis2';
                                } elseif ($v == 'СайтСделал') {
                                    $v1 = 'opis3';
                                } elseif ($v == 'КодТ') {
                                    $v1 = 'articul';
                                } elseif ($v == 'ЕдИзм') {
                                    $v1 = 'ed_izm';
                                } elseif ($v == 'Количество') {
                                    $v1 = 'onsklad';
                                } elseif ($v == 'Цена1') {
                                    $v1 = 'price';
                                } elseif ($v == 'Цена2') {
                                    $v1 = 'price1';
                                } elseif ($v == 'Цена3') {
                                    $v1 = 'price2';
                                } else {
                                    $v1 = '';
                                    $t_head_dop[$k] = $v;
                                }

                                if (isset($v1{1}))
                                    $t_head[$k] = $v1;

                                //echo '<br/>'.$v1;
                            }

                            // echo '<div style="background-color:#efefef;padding:5px;">'; f\pa($t_head); echo '</div>';
                        }
                        //
                        else {


                            $s = explode(';', trim($stroka));
                            // f\pa($s);

                            $s2 = $s1 = array();

                            foreach ($s as $k => $v) {

                                if (isset($t_head[$k]{1})) {

                                    // if( $k == 'price' || $k == 'price1' || $k == 'price2' )
                                    // $v = round($v,2);

                                    $s1[( isset($t_head[$k]) ? $t_head[$k] : $k )] = $v;
                                }

                                if (isset($t_head_dop[$k]{1})) {
                                    $t_all_dop[] = array(
                                        'name' => $t_head_dop[$k],
                                        'value' => $v,
                                        'id_item' => $nn
                                    );
                                }
                            }
                            // f\pa($s1);

                            $s1['id_item'] = $nn;
                            $t_all[] = $s1;

                            //$t_all[] = self::putKeyArray($t_head, explode(';', $stroka));
                        }

                        // // echo __LINE__.'<br/>';
                        // echo iconv('windows-1251', 'UTF-8', $buffer) . '<br/>';
                    }

                    if (( ( isset($r) && $r !== true ) || !isset($r) ) && substr($stroka, 0, 4) == '@@@=') {
                        //echo __LINE__.'<br/>';
                        $r = true;
                    }
                }

                // f\pa( $t_all_dop );

                if (!feof($handle)) {
                    echo "Ошибка чтения файла\n";
                }

                fclose($handle);
            }
        }

        return array('data' => $t_all, 'dop' => $t_all_dop);
    }

    public static function importData( $db, $type_data = 'shop_items', $shop_id, array $info, array $array_dop = [] ) {

        /**
         * записываем данные товаров
         */
//        echo '<br/>'.__LINE__.' '.$type_data;
        echo '<br/>'.__LINE__.' '.$shop_id;
//        exit;

        if ($type_data = 'shop_items') {

            // f\pa($inf2);
            // f\pa($shop);
            // $status = '';
            // $db->sql_query('DELETE FROM `m_myshop_items` WHERE `shop` = \'' . $shop . '\' ;');

            $sql = $db->prepare('DELETE FROM `m_myshop_items` WHERE `shop` = :shop ;');
            $sql->execute(array(':shop' => $shop_id));

            $sql = $db->prepare('SELECT * FROM `m_myshop_items` WHERE `shop` = :shop ;');
            $sql->execute(array(':shop' => $shop_id));
            
            $sql = $db->prepare('SELECT * FROM `m_myshop_items` ;');
            $sql->execute();
            $e = $sql->fetchAll();
            \f\pa($e);
            
            // \f\pa($t_all);
            // \f\db\sql_insert_mnogo2($db, 'm_myshop_items', $t_all, array('shop' => $shop), true);
            // \f\pa($info);
            // \f\pa($shop_id);
            \f\db\sql_insert_mnogo($db, 'm_myshop_items', $info, array('shop' => $shop_id), true);

            // $db->sql_query('DELETE FROM `m_myshop_items_dops` WHERE `shop` = \'' . $shop . '\' ;');
            $sql = $db->prepare('DELETE FROM `m_myshop_items_dops` WHERE `shop` = :shop ;');
            $sql->execute(array(':shop' => $shop_id));

            // \f\db\sql_insert_mnogo2($db, 'm_myshop_items_dops', $t_all_dop, array('shop' => $shop), true);
            // \f\pa($array_dop,'','','ar dop');
            \f\db\sql_insert_mnogo($db, 'm_myshop_items_dops', $array_dop, array('shop' => $shop_id), true);
            // echo $status;

            die('<br/>' . __LINE__ . ' ' . __FILE__);
        }
    }

    public static function loadDataFileForShop($db, int $shop, string $file_data, $type = '1c_win1251') {

        if ($type == '1c_win1251') {

            $handle = @fopen($file_data, "r");

            $t_head = null;
            $t_all = array();

            if ($handle) {

                $nn = 0;

                while (( $stroka = fgets($handle, 4096)) !== false) {

                    $nn++;

                    if (isset($r) && $r === true) {

                        $stroka = iconv('windows-1251', 'UTF-8', $stroka);

                        // обработка полученной строки

                        if ($t_head === null) {

                            $t_head_dop = $t_head = array();

                            $t = explode(';', $stroka);
                            // echo '<div style="background-color:gray;padding:5px;">'; f\pa($t); echo '</div>';

                            foreach ($t as $k => $v) {

                                $v = trim($v);

                                if ($v == 'Наименование') {
                                    $v1 = 'name';
                                } elseif ($v == 'Добавка') {
                                    $v1 = 'opis';
                                } elseif ($v == 'Организация') {
                                    $v1 = 'opis1';
                                } elseif ($v == 'Сайт') {
                                    $v1 = 'opis2';
                                } elseif ($v == 'СайтСделал') {
                                    $v1 = 'opis3';
                                } elseif ($v == 'КодТ') {
                                    $v1 = 'articul';
                                } elseif ($v == 'ЕдИзм') {
                                    $v1 = 'ed_izm';
                                } elseif ($v == 'Количество') {
                                    $v1 = 'onsklad';
                                } elseif ($v == 'Цена1') {
                                    $v1 = 'price';
                                } elseif ($v == 'Цена2') {
                                    $v1 = 'price1';
                                } elseif ($v == 'Цена3') {
                                    $v1 = 'price2';
                                } else {
                                    $v1 = '';
                                    $t_head_dop[$k] = $v;
                                }

                                if (isset($v1{1}))
                                    $t_head[$k] = $v1;


                                //echo '<br/>'.$v1;
                            }

                            // echo '<div style="background-color:#efefef;padding:5px;">'; f\pa($t_head); echo '</div>';
                        }
                        //
                        else {


                            $s = explode(';', trim($stroka));
                            // f\pa($s);

                            $s2 = $s1 = array();

                            foreach ($s as $k => $v) {

                                if (isset($t_head[$k]{1})) {

                                    // if( $k == 'price' || $k == 'price1' || $k == 'price2' )
                                    // $v = round($v,2);

                                    $s1[( isset($t_head[$k]) ? $t_head[$k] : $k )] = $v;
                                }

                                if (isset($t_head_dop[$k]{1})) {
                                    $t_all_dop[] = array(
                                        'name' => $t_head_dop[$k],
                                        'value' => $v,
                                        'id_item' => $nn
                                    );
                                }
                            }
                            // f\pa($s1);

                            $s1['id_item'] = $nn;
                            $t_all[] = $s1;

                            //$t_all[] = self::putKeyArray($t_head, explode(';', $stroka));
                        }

                        // // echo __LINE__.'<br/>';
                        // echo iconv('windows-1251', 'UTF-8', $buffer) . '<br/>';
                    }

                    if (( ( isset($r) && $r !== true ) || !isset($r) ) && substr($stroka, 0, 4) == '@@@=') {
                        //echo __LINE__.'<br/>';
                        $r = true;
                    }
                }

                // f\pa( $t_all );
                // f\pa( $t_all_dop );

                if (!feof($handle)) {
                    echo "Ошибка чтения файла\n";
                }

                fclose($handle);
            }


            // f\pa($inf2);
            // f\pa($shop);
            //$status = '';
            // $db->sql_query('DELETE FROM `m_myshop_items` WHERE `shop` = \'' . $shop . '\' ;');

            $sql = $db->prepare('DELETE FROM `m_myshop_items` WHERE `shop` = :shop ;');
            $sql->execute(array(':shop' => $shop));

            //\f\pa($t_all);
            //\f\db\sql_insert_mnogo2($db, 'm_myshop_items', $t_all, array('shop' => $shop), true);
            \f\db\sql_insert_mnogo($db, 'm_myshop_items', $t_all, array('shop' => $shop), true);

            // $db->sql_query('DELETE FROM `m_myshop_items_dops` WHERE `shop` = \'' . $shop . '\' ;');
            $sql = $db->prepare('DELETE FROM `m_myshop_items_dops` WHERE `shop` = :shop ;');
            $sql->execute(array(':shop' => $shop));

            //\f\db\sql_insert_mnogo2($db, 'm_myshop_items_dops', $t_all_dop, array('shop' => $shop), true);
            \f\db\sql_insert_mnogo($db, 'm_myshop_items_dops', $t_all_dop, array('shop' => $shop), true);
            //echo $status;

            $result = 'Добавлено товаров: ' . sizeof($t_all);
        }

        if (file_exists($file_data)) {

            if (file_exists($file_data . '.delete'))
                unlink($file_data . '.delete');

            rename($file_data, $file_data . '.delete');
        }

        return \f\end3($result, true);
    }

    /**
     * добавить новый каталог в магазин
     * 
     * @global \Nyos\mod\type $status
     * @param type $db
     * @param type $shop
     * @param type $name
     * @param type $data
     * @param type $file
     * @return type
     */
    public static function addCat($db, int $shop, string $name, $data = array(), $file = array()) {

        $new_cat_ar = array('shop' => $shop, 'name' => $name);

        if (isset($data['up_id']) && is_numeric($data['up_id'])) {

            // \f\pa(self::$cats);

            if (!isset(self::$cats[$data['up_id']]))
                self::getCats($db, $shop);

            if (isset(self::$cats[$data['up_id']])) {
                $new_cat_ar['up_id'] = $data['up_id'];
            } else {
                throw new \NyosEx('Неверно указан каталог родитель');
            }
        }

        if (isset($file['name']{3}) && isset($file['size']) && $file['size'] > 0 && isset($file['error']) && $file['error'] == 0) {


            if (!is_dir(dir_serv_site_sd . 'myshop_img_cat'))
                mkdir(dir_serv_site_sd . 'myshop_img_cat');

            $new_file = date('ymdhis', $shop . '_' . $_SERVER['REQUEST_TIME']) . '_' . substr(\f\translit($file['name'], 'uri2'), 0, 20) . '.' . \f\get_file_ext($file['name']);

            move_uploaded_file($file['tmp_name'], dir_serv_site_sd . 'myshop_img_cat' . DS . $new_file);

            if (file_exists(dir_serv_site_sd . 'myshop_img_cat' . DS . $new_file))
                $new_cat_ar['icon_file'] = $new_file;
        }

        return \f\db\db2_insert($db, 'm_myshop_cats', $new_cat_ar, true, 'last_id');
    }

    /**
     * получаем данные по магазину отталкиваясь от домена (PDO)
     * @param type $db
     * @param type $domain
     * @return type
     */
    public static function getShopFromDomain($db, $domain = null) {

        if ($domain === null)
            $domain = $_SERVER['HTTP_HOST'];

        $sql = $db->prepare('SELECT `shop` 
        FROM `m_myshop_domain` 
        WHERE `domain` = :domain OR `domain_uri` = :domain 
        LIMIT 1;');
        $sql->execute(array(':domain' => $domain));

        if ($a = $sql->fetch()) {

            if (isset($a['shop'])) {
                self::$shop = self::getShop($db, $a['shop']);
            }
        } else {

            $sql = $db->prepare('SELECT m_myshop.id
            FROM m_myshop
            INNER JOIN `2domain` ON m_myshop.folder = `2domain`.folder AND `2domain`.domain = :domain 
            LIMIT 1;');
            $sql->execute(array(':domain' => $domain));

            if ($a = $sql->fetch()) {
                if (isset($a['id'])) {
                    $res = self::getShop($db, $a['id']);
                    self::$shop = $res;
                }
            }
        }

        // echo '<br/>' . __FILE__ . ' #' . __LINE__;
        // \f\pa(self::$shop);


        /*
          $sql = $db->sql_query('SELECT `shop` FROM `m_myshop_domain` WHERE `domain` = \'' . addslashes($domain) . '\' OR `domain_uri` = \'' . addslashes($domain) . '\' LIMIT 1;');

          if ($db->sql_numrows($sql) == 1) {
          //echo __LINE__;
          $a = $db->sql_fr($sql);
          //f\pa($a);

          if (isset($a['shop'])) {
          $res = self::getShop($db, $a['shop']);
          self::$shop = $res['data'];
          // f\pa($res);
          }

          } else {
          //echo __LINE__;
          $sql = $db->sql_query('SELECT
          m_myshop.id
          FROM m_myshop
          INNER JOIN `2domain`
          ON m_myshop.folder = `2domain`.folder
          WHERE `2domain`.domain = \'' . addslashes($domain) . '\'
          LIMIT 1;');

          if ($db->sql_numrows($sql) == 1) {

          $a = $db->sql_fr($sql);
          //f\pa($a);

          if (isset($a['id'])) {
          $res = self::getShop($db, $a['id']);
          self::$shop = $res['data'];
          // f\pa($res);
          }
          }
          }
         */

        if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/site')) {
            self::$shop['cats'] = self::getCats($db, 1);
        } else {
            self::$shop['cats'] = self::getCats($db, self::$shop['id']);
        }

        return self::$shop;
    }

    /**
     * получение списка магазинов PDO
     * @global type $status
     * @param type $db
     * @param type $user
     * @return boolean
     */
    public static function getShop($db, int $id_shop) {

        $sql = $db->prepare('SELECT * FROM `m_myshop` WHERE `id` = :id_shop LIMIT 1;');
        $sql->execute(array(':id_shop' => $id_shop));
        $return = $sql->fetch();

        $sql = $db->prepare('SELECT `name`, `var`, `var_text` FROM `m_myshop_dop` WHERE `id_shop` = :id  ;');
        $sql->execute(array(':id' => $return['id']));
        while ($res = $sql->fetch()) {
            $return['dop'][$res['name']] = $res['var_text'] . $res['var'];
        }

        // пропускам так как не нашёл эту БД
//        $r = self::getOptionCatsShop($db, $return['id']);
//        $return['option'] = $r['data'];

        return $return;
    }

    public static function blank($db, $shop, $domain) {

// $show_status = true;

        if (isset($show_status) && $show_status === true) {
            $status = '';
            $_SESSION['status1'] = true;
        }

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            global $status;

            if (isset($show_status) && $show_status === true)
                $status = '';

            $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
        }

        if (isset($shop) && is_numeric($shop)) {
            
        } else {

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true)
                $status .= 'указан не верно пользователь<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            return f\end2('Ошибка в указании номера магазина', false, array(), 'array');
        }


        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            if (isset($show_status) && $show_status === true)
                echo $status;
        }

        return f\end3($res['summa'], true);
    }

    /**
     * удаление файла кеша данных
     * @global \Nyos\mod\type $status
     * @param type $db
     * @param type $shop
     * @return type
     */
    public static function deleteCash($db, int $shop) {

        // кеш файл
        self::$cash_file_items = dir_serv_site . 'shop.items.ar.tmp.json';
        // $filename = dir_serv_site_sd self::$cash_file_items . 'items.ar.tmp';

        if (file_exists(self::$cash_file_items))
            unlink(self::$cash_file_items);

        return true;
    }

    public static function removeCashItems($shop = null) {

// $show_status = true;

        if (isset($show_status) && $show_status === true) {
            $status = '';
            $_SESSION['status1'] = true;
        }

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            global $status;

            if (isset($show_status) && $show_status === true)
                $status = '';

            $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
        }



        if ($shop === null)
            $shop = self::$shop['id'];

        if (isset($shop) && is_numeric($shop)) {
            
        } else {

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true)
                $status .= 'указан не верно пользователь<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            return f\end2('Ошибка в указании номера магазина', false, array(), 'array');
        }

        $filename = $_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . 'shop_' . $shop . DS . 'download' . DS . 'items.ar.tmp';

        if (file_exists($filename)) {
            unlink($filename);
        }



        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            if (isset($show_status) && $show_status === true)
                echo $status;
        }

        return f\end3($res['summa'], true);
    }

    /**
     * 
     * @global \Nyos\mod\type $status
     * @param type $db
     * @param type $ar_options
     * @return type
     */
    public static function getItemOptionsData($db, $item1, $ar_options = false, $price_option = false) {

// $show_status = true;

        if (isset($show_status) && $show_status === true) {
            $status = '';
            $_SESSION['status1'] = true;
        }

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            global $status;

            if (isset($show_status) && $show_status === true)
                $status = '';

            $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
        }

        //f\pa($_SESSION);
        //echo $item1;

        if (isset($item1{0}) && isset($_SESSION['on_cart'][$item1])) {

            $item = $_SESSION['on_cart'][$item1]['id'];
            $option_price = (
                    (
                    isset($_SESSION['on_cart'][$item1]['price_opt']) && is_numeric($_SESSION['on_cart'][$item1]['price_opt'])
                    ) ? $_SESSION['on_cart'][$item1]['price_opt'] : null
                    );
        }

        if (isset($item) && is_numeric($item)) {
            
        } else {

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true)
                $status .= 'указан не верно пользователь<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            return f\end3('Ошибка в указании номера #' . __LINE__, false);
        }


        /*
          echo '<br/>self::$shop[\'option\'][self::$items[$item][\'cat\']]';
          f\pa( self::$shop['option'][self::$items[$item]['cat']] ,2 );
          echo '<br/>self::$items[$item][\'options\']';
          f\pa( self::$items[$item]['options'],2 );
         */
        // f\pa( self::$items[$item]['cat'] );
        // echo '<br/>1111-'.$item;
        // echo '<br/>1111-'.$option_price;
        //f\pa($_SESSION['on_cart'][$item1],2);

        foreach (self::$shop['option'][self::$items[$item]['cat']] as $k => $v) {

            //echo $v['name'].'<br/>';

            foreach ($v['items'] as $k1 => $v1) {
                if (isset($v['options']['change_price']) && $v['options']['change_price'] == 'yes') {

                    if (isset($_SESSION['on_cart'][$item1]['price_opt']{0}) && is_numeric($_SESSION['on_cart'][$item1]['price_opt']) && $k1 == $_SESSION['on_cart'][$item1]['price_opt']) {
                        $return[] = array('name' => $v['name'], 'val' => $v1);
                        //echo '<h2>'.$v1.'</h2>';
                        break;
                    }
                }
            }
        }

        foreach (self::$shop['option'][self::$items[$item]['cat']] as $k => $v) {
            foreach ($v['items'] as $k1 => $v1) {

                if (isset($v['options']['change_price']) && $v['options']['change_price'] == 'yes') {
                    continue;
                } else {
                    if (isset(self::$items[$item]['options'][$k1]) && self::$items[$item]['options'][$k1] == 'y') {

                        $return[] = array('name' => $v['name'], 'val' => $v1);
                        //echo $v1.'<br/>';
                    }
                }
            }
        }

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            if (isset($show_status) && $show_status === true)
                echo $status;
        }

        return f\end3('ok', true, $return);
    }

    /**
     * PDO
     * @param type $db
     * @param int $shop
     * @return type
     */
    public static function getOptionCatsShop($db, int $shop) {

//        $ee = \f\db\getSql($db, 'SELECT
//                m_myshop_cats_option.id as `option_id`,
//                m_myshop_cats_option.id_cat,
//                m_myshop_cats_option.name as `option_name`,
//                m_myshop_cats_option.change_price,
//                m_myshop_cats_option_var.id as `var_id`,
//                m_myshop_cats_option_var.var as `var_var`
//            FROM m_myshop_cats
//                INNER JOIN m_myshop
//                    ON m_myshop_cats.shop = m_myshop.id
//                INNER JOIN m_myshop_cats_option
//                    ON m_myshop_cats_option.id_cat = m_myshop_cats.id
//                INNER JOIN m_myshop_cats_option_var
//                    ON m_myshop_cats_option_var.id_option = m_myshop_cats_option.id
//            WHERE 
//                m_myshop.id = ' . $shop . ' ;', null);
        $sql = $db->prepare('SELECT
                m_myshop_cats_option.id as `option_id`,
                m_myshop_cats_option.id_cat,
                m_myshop_cats_option.name as `option_name`,
                m_myshop_cats_option.change_price,
                m_myshop_cats_option_var.id as `var_id`,
                m_myshop_cats_option_var.var as `var_var`
            FROM m_myshop_cats
                INNER JOIN m_myshop
                    ON m_myshop_cats.shop = m_myshop.id
                INNER JOIN m_myshop_cats_option
                    ON m_myshop_cats_option.id_cat = m_myshop_cats.id
                INNER JOIN m_myshop_cats_option_var
                    ON m_myshop_cats_option_var.id_option = m_myshop_cats_option.id
            WHERE 
                m_myshop.id = :shop ;');
        $sql->execute(array(':shop' => $shop));
        $ee = $sql->fetchAll();

        $res = array();
        foreach ($ee as $k => $v) {

            if (!isset($res[$v['id_cat']][$v['option_id']]))
                $res[$v['id_cat']][$v['option_id']] = array(
                    'name' => $v['option_name']
                    , 'items' => array()
                    , 'options' => array()
                );

            if (isset($v['change_price']) && $v['change_price'] == 'yes' && !isset($res[$v['id_cat']][$v['option_id']]['options']['change_price']))
                $res[$v['id_cat']][$v['option_id']]['options']['change_price'] = 'yes';

            $res[$v['id_cat']][$v['option_id']]['items'][$v['var_id']] = $v['var_var'];
        }

        return $res;
    }

    /**
     * получение всех опций товаров магазина
     * @global \Nyos\mod\type $status
     * @param type $db
     * @param type $shop
     * @return type
     */
    public static function getOptionItemsShop($db, $shop) {

// $show_status = true;

        if (isset($show_status) && $show_status === true) {
            $status = '';
            $_SESSION['status1'] = true;
        }

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            global $status;

            $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
        }

        if (isset($shop) && is_numeric($shop)) {
            
        } else {

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true)
                $status .= 'указан не верно пользователь<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            return f\end2('Ошибка в указании номера магазина', false, array(), 'array');
        }


        $res = \f\db\getSql($db, 'SELECT
  
            m_myshop_items.id as item_id,
            m_myshop_cats_option.id as option_id, '
                . ' m_myshop_cats_option_var.id as option_var_id '
                //.' m_myshop_cats_option_var.var, '
                //.' m_myshop_cats_option_var.var_number, '
                //.' m_myshop_cats_option_var.var_number2 '
                . ' FROM m_myshop_cats
              INNER JOIN m_myshop
                ON m_myshop_cats.shop = m_myshop.id
              INNER JOIN m_myshop_items
                ON m_myshop_items.cat = m_myshop_cats.id
              INNER JOIN m_myshop_items_options
                ON m_myshop_items_options.item = m_myshop_items.id
              INNER JOIN m_myshop_cats_option
                ON m_myshop_items_options.option_id = m_myshop_cats_option.id
              INNER JOIN m_myshop_cats_option_var
                ON m_myshop_items_options.var = m_myshop_cats_option_var.id
            WHERE m_myshop.id = ' . $shop, null);

        $res2 = array();

        foreach ($res as $k => $v) {
            if (!isset($res2[$v['item_id']][$v['option_id']])) {
                $res2[$v['item_id']][$v['option_id']] = $v['option_var_id'];
            } else {

                if (is_array($res2[$v['item_id']][$v['option_id']])) {

                    $res2[$v['item_id']][$v['option_id']][] = $v['option_var_id'];
                } else {

                    $k22 = $res2[$v['item_id']][$v['option_id']];
                    $res2[$v['item_id']][$v['option_id']] = array($k22 => 1,
                        $v['option_var_id'] => 1);
                }
            }
        }

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            if (isset($show_status) && $show_status === true)
                echo $status;
        }

        return f\end3('получили все опции магазина по итемам', true, $res2);
    }

    public static function getCatsOptions($db, $cat) {

// $show_status = true;

        if (isset($show_status) && $show_status === true) {
            $status = '';
            $_SESSION['status1'] = true;
        }

        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            global $status;

            $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
        }

        if (isset($cat) && is_numeric($cat)) {
            
        } else {

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true)
                $status .= 'указан не верно пользователь<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            return f\end2('Ошибка в указании номера магазина', false, array(), 'array');
        }


        $sql = $db->sql_query('SELECT
            m_myshop_cats_option.id AS option_id,
            m_myshop_cats_option_var.id,
            m_myshop_cats_option.name,
            m_myshop_cats_option.change_price,

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
          WHERE m_myshop_cats.id = \'' . $cat . '\'
          ORDER BY 
            m_myshop_cats_option.sort DESC
            ,m_myshop_cats_option_var.sort DESC
          ;');

        while ($r = $db->sql_fr($sql)) {
            if (!isset($a[$r['option_id']])) {
                $a[$r['option_id']] = $r;
                $a[$r['option_id']]['items'] = array();
            }

            $a[$r['option_id']]['items'][$r['id']] = $r;
        }





        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            if (isset($show_status) && $show_status === true)
                echo $status;
        }

        return f\end3('ok', true, $a);
    }

    /**
     * PDO
     * @param type $db
     * @param int $shop
     * @param type $and_del
     * @return type
     */
    public static function getCats($db, int $shop, $and_del = false) {


//        self::$cats = \f\db\getSql($db, 'SELECT * FROM `m_myshop_cats` WHERE `shop` = \'' . $shop . '\' ' . ( $and_del === false ? ' AND `status` != \'del\' ' : '' )
//                . ' ORDER BY `sort` DESC, `name` ASC ;');
        $sql = $db->prepare('SELECT * FROM `m_myshop_cats` WHERE `shop` = :shop ' . ( $and_del === false ? ' AND `status` != \'del\' ' : '' )
                . ' ORDER BY `sort` DESC, `name` ASC ;');
        $sql->execute(array(':shop' => $shop));
        self::$cats = $sql->fetchAll();

        foreach (self::$cats as $k => $v) {
            if (isset($v['up_id']{0}) && isset(self::$cats[$v['up_id']])) {
                self::$cats[$v['up_id']]['down'][$k] = 1;
            }
        }

//        $sql = $db->sql_query('SELECT `m_myshop_cats`.`id`, COUNT(`m_myshop_items`.`id`) as `kolvo` FROM `m_myshop_items`,`m_myshop_cats` '
//                . 'WHERE `m_myshop_cats`.`id` = `m_myshop_items`.`cat` '
//                . 'AND `m_myshop_cats`.`status` != \'del\' '
//                . 'AND `m_myshop_items`.`status` != \'del\' '
//                . 'GROUP BY `m_myshop_cats`.`id` ;');
//        while ($res = $db->sql_fr($sql)) {
//            // f\pa( $res );
//            if (isset(self::$cats[$res['id']]))
//                self::$cats[$res['id']]['items-kolvo'] = $res['kolvo'];
//        }

        $sql = $db->prepare('SELECT `m_myshop_cats`.`id`, COUNT(`m_myshop_items`.`id`) as `kolvo` FROM `m_myshop_items`,`m_myshop_cats` '
                . ' WHERE `m_myshop_cats`.`id` = `m_myshop_items`.`cat` '
                . ' AND `m_myshop_cats`.`status` != \'del\' '
                . ' AND `m_myshop_items`.`status` != \'del\' '
                . ' GROUP BY `m_myshop_cats`.`id` ;');
        $sql->execute();
        while ($res = $sql->fetch()) {
            // f\pa( $res );
            if (isset(self::$cats[$res['id']]))
                self::$cats[$res['id']]['items-kolvo'] = $res['kolvo'];
        }


        return self::$cats;
    }

    public static function getItem($db, $shop, $item) {

// $show_status = true;

        if (isset($show_status) && $show_status === true) {
            $status = '';
            $_SESSION['status1'] = true;
        }
        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            global $status;

            $status .= '<fieldset class="status" ><legend>' . __CLASS__ . ' #' . __LINE__ . ' + ' . __FUNCTION__ . '</legend>';
        }

        if (isset($shop) && is_numeric($shop)) {
            
        } else {

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true)
                $status .= 'номер магазина не номер<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            return f\end2('номер магазина не номер', false, array(), 'array');
        }


        $sql = $db->sql_query('SELECT * FROM `m_myshop_items` WHERE `id`=\'' . $item . '\' AND `shop`=\'' . $shop . '\' LIMIT 1;');

        // найден итем
        if ($db->sql_numrows($sql) == 1) {

            $item = $db->sql_fr($sql);
            $item['options'] = \f\db\getSql($db, 'SELECT `option_id`,`var`,`price` FROM `m_myshop_items_options` WHERE `item` = \'' . $item['id'] . '\' ;', 'option_id');
            $item['img'] = \f\db\getSql($db, 'SELECT `link`,`start` FROM `m_myshop_items_img` WHERE `item` = \'' . $item['id'] . '\' AND `status`=\'ok\' ;', null);
            $item['dops'] = \f\db\getSql($db, 'SELECT `name`,`value` FROM `m_myshop_items_dops` WHERE `id_item` = \'' . $item['id'] . '\' ;', 'name');
        }
        // не найден итем
        else {

            if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
                $status .= 'нет итема<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

                if (isset($show_status) && $show_status === true)
                    echo $status;
            }

            return f\end3('нет итема', false);
        }


        if (isset($_SESSION['status1']) && $_SESSION['status1'] === true) {
            $status .= '<span class="bot_line">#' . __LINE__ . '</span></fieldset>';

            if (isset($show_status) && $show_status === true)
                echo $status;
        }

        return f\end3('okey', true, $item);
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
    public static function getItems($db, int $shop = null, $dops = null) {

        if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/site')) {

            $shop = 1;
        } elseif (isset($shop) && is_numeric($shop)) {
            
        }
        //
        elseif (isset(self::$shop['id'])) {
            $shop = self::$shop['id'];
        }
        //
        else {
            //return \f\end2('неописуемая ситуация #' . __LINE__, false, array(), 'array');
            throw new \NyosEx('не выбран магазин при выборе товаров, обратитесь к администратору');
        }

        // кеш файл
        // self::$cash_file_items = dir_serv_site . 'shop.items.ar.tmp.json';
        self::$cash_file_items = dir_site_module . 'shop.items.ar.tmp.json';

        // достаём инфу из кеш файла и в работу
        if (1 == 1 && file_exists(self::$cash_file_items)) {

            self::$items = json_decode(file_get_contents(self::$cash_file_items), true);
            return self::$items;
        }
        // достаём инфу и сохраняем в кеш
        else {

            $sql = $db->prepare('SELECT * FROM `m_myshop_items` WHERE `m_myshop_items`.`shop` = :shop AND `m_myshop_items`.`status` = \'ok\' ;');
            $sql->execute(array(':shop' => $shop));
            self::$items = $sql->fetchAll();

            if (!empty(self::$items)) {

                // $item = $db->sql_fr($sql);
//                $options = \f\db\getSql($db, 'SELECT 
//                        `m_myshop_items_options`.`item`, 
//                        `m_myshop_items_options`.`option_id`, 
//                        `m_myshop_items_options`.`var`, 
//                        `m_myshop_items_options`.`price` 
//                        FROM 
//                        `m_myshop_items_options` 
//                        ,`m_myshop_items`
//                        WHERE 
//                        `m_myshop_items`.`shop`=\'' . $shop . '\' 
//                        AND `m_myshop_items`.`status`=\'show\' 
//                        AND `m_myshop_items`.`id`=`m_myshop_items_options`.`item` 
//                        ;', null);

                $sql = $db->prepare('SELECT 
                            `m_myshop_items_options`.`item`, 
                            `m_myshop_items_options`.`option_id`, 
                            `m_myshop_items_options`.`var`, 
                            `m_myshop_items_options`.`price` 
                        FROM 
                            `m_myshop_items_options` 
                            ,`m_myshop_items`
                        WHERE 
                            `m_myshop_items`.`shop`= :shop
                            AND `m_myshop_items`.`status`= \'show\' 
                            AND `m_myshop_items`.`id`=`m_myshop_items_options`.`item` 
                        ;');
                $sql->execute(array(':shop' => $shop));
                $options = $sql->fetchAll();

                if (sizeof($options) > 0) {
                    foreach ($options as $k => $v) {

                        if (!isset(self::$items[$v['item']]['options']))
                            self::$items[$v['item']]['options'] = array();

                        // self::$items[$v['item']]['options'][$v['option_id']][$v['var']] = ( isset($v['price']{0}) ? $v['price'] : 'y' );
                        self::$items[$v['item']]['options'][$v['var']] = ( isset($v['price']{0}) ? $v['price'] : 'y' );
                    }
                }


                $img = \f\db\getSql($db, 'SELECT '
                        . '`m_myshop_items_img`.`item`,'
                        . '`m_myshop_items_img`.`link`,'
                        . '`m_myshop_items_img`.`start` '
                        . 'FROM '
                        . '`m_myshop_items_img` '
                        . ',`m_myshop_items`'
                        . 'WHERE '
                        . '`m_myshop_items`.`shop`=\'' . $shop . '\' '
                        . 'AND `m_myshop_items`.`status`=\'show\' '
                        . 'AND `m_myshop_items`.`id`=`m_myshop_items_img`.`item` '
                        . 'AND `m_myshop_items_img`.`status`=\'ok\' '
                        . ';', null);

                //f\pa($img,2);

                if (sizeof($img) > 0) {
                    foreach ($img as $k => $v) {

                        if (!isset(self::$items[$v['item']]['imgs']))
                            self::$items[$v['item']]['imgs'] = array();

                        self::$items[$v['item']]['imgs'][] = array('link' => $v['link'], 'start' => $v['start']);
                    }
                }

                $dops = \f\db\getSql($db, 'SELECT '
                        . '`m_myshop_items_dops`.`id_item` as `item`,'
                        . '`m_myshop_items_dops`.`name`,'
                        . '`m_myshop_items_dops`.`value` '
                        . 'FROM '
                        . '`m_myshop_items_dops` '
                        . ',`m_myshop_items`'
                        . 'WHERE '
                        . '`m_myshop_items`.`shop`=\'' . $shop . '\' '
                        . 'AND `m_myshop_items`.`status`=\'show\' '
                        . 'AND `m_myshop_items`.`id`=`m_myshop_items_dops`.`id_item` '
                        . ';', null);

                //f\pa($dops,2);

                if (sizeof($dops) > 0) {
                    foreach ($dops as $k => $v) {

                        if (!isset(self::$items[$v['item']]['dops']))
                            self::$items[$v['item']]['dops'] = array();

                        self::$items[$v['item']]['dops'][$v['name']] = $v['value'];
                    }
                }

                file_put_contents(self::$cash_file_items, json_encode(self::$items));
                return self::$items;
            }
            // не найден итем
            else {

                return false;
            }
        }
    }

}
