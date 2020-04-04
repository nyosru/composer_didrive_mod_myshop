<?php

//$vv['in_body_end'][] = '<script src="/0.didrive/js.js"></script>';

/*

  [name] => 11111111111111
  [price] => 222222
  [price_old] => 3333333
  [opis] =>

  2222222222223333333333344444444444444

  222222222222222222

  [new_item] => Добавить товар
  [shop] => 12
  [s] => 4298796b4f6100241e440a1f9c1a154d
 */

//echo __FILE__;
// \f\pa($_POST);
// добавление товара
if (isset($_POST['new_item'])) {

    require_once $_SERVER['DOCUMENT_ROOT'] . DS . '0.site' . DS . 'exe' . DS . 'myshop_admin' . DS . 'class.php';

    // echo __FILES__;

    if (\Nyos\nyos::checkSecret($_POST['s'], $vv['shop']['id']) === true) {

        $e = $_REQUEST;
        $e['files'] = $_FILES['f'];
        $e['dir_site_dl_uri'] = $vv['dir_site_dl_uri'];

        // $status='';
        $new = \Nyos\mod\MyShopAdmin::addItem($db, $vv['shop']['id'], $e);
        //echo $status;
        // f\pa($new);
        $vv['warn'] = $new['html'];
    } else {
        $vv['warn'] = 'Что то пошло не так, повторите';
    }

    /*
      $res = Nyos\mod\MyShopAdmin::addCat($db, $vv['shop']['id'], $_POST['name'], $_POST );
      $vv['warn'] = $res['html'];
     */
}
