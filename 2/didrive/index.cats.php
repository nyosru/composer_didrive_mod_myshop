<?php

// добавление каталога
if (isset($_POST['new_cat'])) {

    try {

        $res = Nyos\mod\MyShop::addCat($db, $vv['shop']['id'], $_POST['name'], $_POST);

        if (isset($res) && is_numeric($res)) {
            $vv['warn'] = 'Каталог добавлен';
        }
    } catch (\NyosEx $ex) {
        $vv['warn'] = $ex->getMessage();
    }
}