<?php

/*
  [save_file] => save
  [table] => m_myshop_dop
  [pole] => var
  [k1] => id_shop
  [v1] => 14
  [k2] => name
  [v2] => logo_img
 */

// добавление каталога
if (isset($_POST['save_file'])) {

    /*
      require_once $_SERVER['DOCUMENT_ROOT'].DS.'0.site'.DS.'exe'.DS.'myshop_admin'.DS.'class.php';
      // $status = '';
      $res = Nyos\mod\MyShopAdmin::addCat($db, $vv['shop']['id'], $_POST['name'], $_POST );
      // echo $status;

      $vv['warn'] = $res['html'];
     */

    /*
      Array
      (
      [file] => Array
      (
      [name] =>
      [type] =>
      [tmp_name] =>
      [error] => 4
      [size] => 0
      )

      )
     */
    
    
    // echo $vv['sd'];
    
    if( !is_dir( $_SERVER['DOCUMENT_ROOT'].$vv['sd'].'shop_files' ) )
    mkdir( $_SERVER['DOCUMENT_ROOT'].$vv['sd'].'shop_files', 0755 );

    // echo $vv['shop']['dop'][$_REQUEST['v2']].'<Br/><Br/>';
    
    $new_file = $_REQUEST['v2'].'..'.date('ymdhis', $_SERVER['REQUEST_TIME']).'.'.\f\get_file_ext($_FILES['file']['name']);
    move_uploaded_file( $_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$vv['sd'].'shop_files'.DS.$new_file );

    if( file_exists($_SERVER['DOCUMENT_ROOT'].$vv['sd'].'shop_files'.DS.$new_file) ){

    // удалённые файлы переименоваваем
    // удалённые файлы удаляем
        if( isset($vv['shop']['dop'][$_REQUEST['v2']]{1}) && file_exists($_SERVER['DOCUMENT_ROOT'].$vv['sd'].'shop_files'.DS.$vv['shop']['dop'][$_REQUEST['v2']]) ){
        // rename( $_SERVER['DOCUMENT_ROOT'].$vv['sd'].'shop_files'.DS.$vv['shop']['dop'][$_REQUEST['v2']], $_SERVER['DOCUMENT_ROOT'].$vv['sd'].'shop_files'.DS.'delete-'.$vv['shop']['dop'][$_REQUEST['v2']] );
        unlink( $_SERVER['DOCUMENT_ROOT'].$vv['sd'].'shop_files'.DS.$vv['shop']['dop'][$_REQUEST['v2']] );
        }
        
    $db->sql_query('DELETE FROM `' . $_REQUEST['table'] . '` '
            . 'WHERE '
            . '`' . $_REQUEST['k1'] . '` = \'' . $_REQUEST['v1'] . '\' '
            . 'AND `' . $_REQUEST['k2'] . '` = \'' . $_REQUEST['v2'] . '\' '
            . ';');
    
    //$status = '';
    \f\db\db2_insert($db, $_REQUEST['table'], array(
        $_REQUEST['k1'] => $_REQUEST['v1'],
        $_REQUEST['k2'] => $_REQUEST['v2'],
        $_REQUEST['pole'] => $new_file
            ), true);
    //echo $status;

    // заменим переменную в полученной ранее инфе, чтобы сразу показывалась новая картинка 
    $vv['shop']['dop'][$_REQUEST['v2']] = $new_file;

    $vv['warn'] = 'Файл загружен';
    }
}