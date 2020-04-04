<?php

/*
  + _FILES

  Array
  (
  [load_file] => Array
  (
  [name] => InterMag51Spr.txt
  [type] => text/plain
  [tmp_name] => D:\OpenServer18-php7\userdata\temp\php68C9.tmp
  [error] => 0
  [size] => 122935
  )
 */

// echo '<br/>'.__FILE__.'['.__LINE__.']';
// f\pa($_FILES['load_file']);

if (isset($_FILES['load_file']) && $_FILES['load_file']['size'] > 100 && $_FILES['load_file']['error'] == 0) {

// f\pa($_FILES);

    $handle = @fopen($_FILES['load_file']['tmp_name'], "r");

    $inf = $inf2 = array();

    if ($handle) {
        while (( $buffer = fgets($handle, 4096) ) !== false) {

            $a = explode('=', trim(iconv('windows-1251', 'utf-8', $buffer)));

            // если пошли услуги то останавливаем обработку
            if ($a[1] == 'Услуги') {
                break;
            } elseif ($a[0] == '###') {

                if( isset( $e2['name']{1}) && isset( $e2['price']{0}) && $e2['price'] != 0 && is_numeric($e2['price']) ){
                $inf2[] = $e2;
                }
                // else{ f\pa($e2); }
                
                //$inf[] = $e;
                $e2 = array();
                // $e2 = $e = array();
            } elseif (isset($a[1]{0})) {

                if ($a[0] == 'Наим') {
                    $e2['name'] = $a[1];
                } elseif ($a[0] == 'ДобЦена') {
                    $e2['price'] = $a[1];
                    
                } elseif ($a[0] == 'ДобЦенаСС') {
                    $e2['price1'] = $a[1];
                } elseif ($a[0] == 'ДобЦенаПай') {
                    $e2['price2'] = $a[1];
                    
                } elseif ($a[0] == 'ЕдИзм') {
                    $e2['ed_izm'] = $a[1];
                } elseif ($a[0] == 'ДобСпр') {
                    $e2['opis'] = $a[1];
                }
//            else{
//            $e2[$a[0]] = $a[1];
//            }
            }



            // echo $buffer;
            // f\pa($buffer);
            // $e = strpos( $buffer , '=' );
            // f\pa($e);
        }
        if (!feof($handle)) {
            echo "Ошибка: fgets() неожиданно потерпел неудачу\n";
        }
        fclose($handle);

        // f\pa($inf,2);
        // f\pa($inf2);

        //$status = '';
        //\f\db\SqlMind_insert_mnogo( $db, 'm_myshop_items', array('shop' => $vv['now_mod']['shop_id']), $inf2, true);
        $db->sql_query( 'DELETE FROM `m_myshop_items` WHERE `shop` = \''.$vv['now_mod']['shop_id'].'\' ;' );
        \f\db\sql_insert_mnogo( $db, 'm_myshop_items', $inf2, array('shop' => $vv['now_mod']['shop_id']), true );
        //echo $status;
        
        $vv['warn'] .= 'Добавлено товаров: '.sizeof($inf2);
        
    }
}



if (1 == 2) {
// Nyos\mod\items::creatFolderImage($vv['folder']);

    if (isset($_POST['addnew']{1})) {

        //echo __LINE__;

        $d = $_POST;
        unset($d['addnew']);
        $d['files'] = $_FILES;

        //$_SESSION['status1'] = true;
        // $status = '';
        //echo '<br/>'.__FILE__.'['.__LINE__.']';
        $r = Nyos\mod\items::addNew($db, $vv['folder'], $vv['now_mod'], $d);
        //echo '<br/>'.__FILE__.'['.__LINE__.']';
        // f\pa($r);

        if (isset($r['status']) && $r['status'] == 'ok') {
            $vv['warn'] .= ( isset($vv['warn']{3}) ? '<br/>' : '' ) . $r['html'];
        }

        // echo $status;
    }

//$status = '';
//$vv['list'] = Nyos\mod\items::getItems( $db, $vv['folder'], $now_mod['lvl.config']);
//echo $status;
//f\pa($vv['list'],2);
// создание папки для картинок
// Nyos\mod\items::creatFolderImage($vv['folder']);

    $vv['tpl_body'] = didr_tpl . 'body.htm';





    if (1 == 2) {

// echo '<pre>'; print_r($vv); echo '</pre>';
// echo '<pre>'; print_r($_mn); echo '</pre>';

        if (
                isset($_mn['folder']{1}) && is_dir($_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $now['folder'] . DS . 'download' . DS . $_mn['folder'] . DS)
        ) {
            $vv['mod_folder'] = $_mn['folder'];
            $dirmod = $_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $now['folder'] . DS . 'download' . DS . $_mn['folder'] . DS;
        } else {
            //$vv['warn'] .= '<div class="warn" >папка не найдена, грузим всё в корень</div>';
            $dirmod = $_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $now['folder'] . DS . 'download' . DS;
        }








        if (isset($_POST['save']{2})) {


            if (isset($_mn['order_by']{0}) && $_mn['order_by'] == 'date') {
                krsort($_POST['datar']);
            }

            file_put_contents($_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $now['folder'] . DS . '_smartydata.' . $_mn['cfg.level'] . '.json', json_encode($_POST['datar']));
        } elseif (isset($_POST['addnew']{2})) {
            //echo '<pre>'; print_r($_FILES); echo '</pre>';
            //echo '<pre>'; print_r($_POST); echo '</pre>';
            // file_put_contents( $_SERVER['DOCUMENT_ROOT'].DS.'9.site'.DS.$now['folder'].DS.'_smartydata.'.$_mn['cfg.level'].'.json', json_encode($_POST['datar']) );
            // [dop_folder] => jobs

            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0 && $_FILES['file']['size'] > 100
            ) {

                if (isset($_POST['dop_folder']{1})) {
                    //echo $_SERVER['DOCUMENT_ROOT'].DS.'9.site'.DS.$now['folder'].DS.'download'.DS.$_POST['dop_folder'].'<br/>';

                    if (!is_dir($_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $now['folder'] . DS . 'download' . DS . $_POST['dop_folder']))
                        mkdir($_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $now['folder'] . DS . 'download' . DS . $_POST['dop_folder'], 0755);

                    if (!function_exists('translit'))
                        require( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'txt.php');

                    if (!function_exists('get_file_ext'))
                        require( $_SERVER['DOCUMENT_ROOT'] . DS . '0.all' . DS . 'f' . DS . 'file.php');

                    copy(
                            $_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $now['folder'] . DS
                            . 'download' . DS . $_POST['dop_folder'] . DS
                            . date('Ymdhis', $_SERVER['REQUEST_TIME']) . translit($_FILES['file']['name'], 'uri2') . '.' . rand(1, 9999) . '.' . strtolower(get_file_ext($_FILES['file']['name']))
                    );

                    $vv['warn'] .= '<div class="warn" >файл загружен</div>';
                }
            }
        }

        $vv['datar'] = array();

        for ($u = 10; $u >= 1; $u--) {
            if (isset($_mn['var_' . $u])) {
                $vv['datar'][$_mn['var_' . $u]['name']] = $_mn['var_' . $u];
            }
        }

        $vv['massa'] = ( file_exists($_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $now['folder'] . DS . '_smartydata.' . $_mn['cfg.level'] . '.json') ) ? json_decode(file_get_contents(
                                $_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $now['folder'] . DS . '_smartydata.' . $_mn['cfg.level'] . '.json'
                        ), true) : array();

// echo '<pre>'; print_r($vv['massa']); echo '</pre>';

        $i = scandir($dirmod);

        foreach ($i as $k => $v) {
            if (strpos($v, '.jpg') || strpos($v, '.png') || strpos($v, '.gif')) {
                $vv['massa_img'][$v] = 1;

                // order_by = date
                // $vv['massa_date'][ filectime($dirmod.$v) ][$v] = 1;
            }
        }

//krsort($vv['massa_date']);

        /*
          $dirmod = $_SERVER['DOCUMENT_ROOT'].DS.'9.site'.DS.$now['folder'].DS.'module'.DS.$vv['level'].DS.'tpl'.DS;

          if( isset( $_POST['editor'] ) )
          {
          $vv['warn'] .= '<div class="warn" >Данные записаны (<a href="/'.$vv['level'].'/" target="_blank" >страница на сайте</a>)</div>';
          file_put_contents( $dirmod.'page.txt.data.htm', $_POST['editor'] );
          }

          $vv['sys']['ckeditor'] = 112;
          $vv['sys']['ckeditor_in'][] = 'editor1';
         */

// $vv['html'] = ( file_exists( $dirmod.'page.txt.data.htm' ) ) ? file_get_contents( $dirmod.'page.txt.data.htm' ) : 'файл данных не обнаружен, записывайте новый' ;
    }
}