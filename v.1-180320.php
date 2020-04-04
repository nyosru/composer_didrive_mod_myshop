<?php

//f\pa($vv['now_mod']);

if (isset($vv['now_mod']['no_cats']{1})) {
    $vv['tpl_0body'] = \f\like_tpl('sh-no.cat', $vv['dir_module_tpl'], $vv['dir_site_tpl']);
} else {
    $vv['tpl_0body'] = \f\like_tpl('sh', $vv['dir_module_tpl'], $vv['dir_site_tpl']);
}

if (1 == 2) {
//echo __FILE__.' '.__LINE__;

    $dirmod1 = $_SERVER['DOCUMENT_ROOT'] . DS . '0.site' . DS . 'exe' . DS . 'news' . DS . '7' . DS . 't' . DS;
    $dirmod2 = $_SERVER['DOCUMENT_ROOT'] . DS . '9.site' . DS . $now['folder'] . DS . 'module' . DS . level . DS . 'tpl' . DS;

// $vv['html'] = ( file_exists( $dirmod.'page.txt.data.htm' ) ) ? file_get_contents( $dirmod.'page.txt.data.htm' ) : 'файл данных не обнаружен, записывайте новый' ;
// $dirmod.'page.txt.data.htm'
// echo '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>'.__LINE__;
//echo '<pre>'; print_r($_GET); echo '</pre>';
//echo '<pre>'; print_r($_REQUEST); echo '</pre>';


    $asd = 0;

// проверяем если выбрана новость для показа, наша она или нет
    if (isset($_REQUEST['option']{0}) && $_REQUEST['option'] !== 'index' && is_numeric($_REQUEST['option'])) {

        //echo '//'.__LINE__;
        //$status = '';
        $MS3a = $db->sql_query('SELECT *
        FROM `mod_news_text`
        WHERE
            `folder` = \'' . $now['folder'] . '\'
            AND `id`= \'' . $_REQUEST['option'] . '\'
            AND `modul`= \'' . $vv['level'] . '\'
            AND
                (
                `status` = \'look\'
                OR `status` = \'mod\'
                )
        LIMIT 1;');
        //echo $status;
        $asd = $db->sql_numrows($MS3a);
    }

// если найдена новость для показа то её одну и показываем
    if ($asd == 1) {
        ///echo '//'.__LINE__;

        $ro3a = $db->sql_fr($MS3a);

        if (isset($ro3['full_text']{5}))
            $ro3a['look_one'] = 'da';

        $vv['news1look'] = 'da';
        $vv['news1'] = $ro3a;
    }


    else { // показываем список новостей, если не выбрана новость для просмотра
        //echo '//'.__LINE__;
        if (!function_exists('checkdates'))
            require(DirAll . 'f' . DS . 'txt.php' );

        //$status = '';
        $MS3nn = $db->sql_query('SELECT id
        FROM `mod_news_text`
        WHERE
            `folder` = \'' . $now['folder'] . '\'
            AND
            `modul`=\'' . $vv['level'] . '\'
            AND
                (
                `status` = \'look\'
                OR `status` = \'mod\'
                )
        ;');
        //echo $status;

        $mskolvo = $db->sql_numrows($MS3nn);

        if ($mskolvo > 0 && isset($vv['now_level']['on1page']) && is_numeric($vv['now_level']['on1page']) && $vv['now_level']['on1page'] < $mskolvo
        ) {
            //echo __FILE__.'['.__LINE__.']';
            $vv['pagination']['kolvo'] = ceil($mskolvo / $vv['now_level']['on1page']);
        }










        // $status = '';
        $MS3 = $db->sql_query('SELECT *
        FROM `mod_news_text`
        WHERE
            `folder` = \'' . $now['folder'] . '\'
            AND
            `modul`=\'' . $vv['level'] . '\'
            AND
                (
                `status` = \'look\'
                OR `status` = \'mod\'
                )
        ORDER BY
            `date` DESC,
            `time` DESC;');
        // echo $status;

        if ($db->sql_numrows($MS3) > 0) {

            while ($ro3 = $db->sql_fetchrow($MS3)) {

                if (isset($ro3['full_text']{5}))
                    $ro3['look'] = 'on';

                $dtn = checkdates($ro3['date'], 'text');

                $ro3['publick'] = (
                        $dtn !== false ?
                        $dtn :
                        ( round(substr($ro3['date'], 8, 2)) . ' ' . date_in_text(substr($ro3['date'], 5, 2), 'месяца') ) ) . ' в ' . substr($ro3['time'], 0, 5)
                ;

                $vv['newss'][] = $ro3;
            }
        }
    }

//f\pa( $vv['newss']);

    $vv['tpl_0body'] = $dirmod1 . 'news.body.htm';

    if (file_exists($dirmod2 . 'news.body.htm'))
        $vv['tpl_0body'] = $dirmod2 . 'news.body.htm';







    if (1 == 2) {

        if (defined('SMARTY_DIR')) {
            require('v.7.smarty.php');
        } else {

            $Navig = '<a href="/' . $_GET['level'] . '.htm" title="каталог ' . $AMCfg['name'] . '">' . $AMCfg['name'] . '</a>';

            $LevL2 = $LevL1 = false;


            /* $_GET['level'] = значение [w5.school.jquery]
              $_GET['option'] = значение [6]
              $_GET['extend'] = значение [19]
              $_GET['action'] = значение [3]
              $_GET['dop'] = значение [stena.jquery.css] */


            if (isset($_GET['option']) && is_numeric($_GET['option']) &&
                    isset($_GET['extend']) && is_numeric($_GET['extend']) &&
                    isset($_GET['action']) && is_numeric($_GET['action'])) {

                $MS3 = $db->sql_query("SELECT
                                `head`,
                                `date`,
                                `text_data`,
                                `autor`,
                                `istochnik`,
                                `istochnik_link`
                        FROM `mod_news_item`
                        WHERE `user`='" . $domen_info['login'] . "' AND
                                `folder` = '" . $domen_info['folder'] . "' AND
                                `module`= '" . $_GET['level'] . "' AND
                                `cat_id` = '" . $_GET['extend'] . "' AND
                                `id` = '" . $_GET['action'] . "' AND
                                `publick` = 'look'
                        LIMIT 1;");

                if ($MS3 && $db->sql_numrows($MS3) > 0)
                    $LevL3 = TRUE;
            }

            if (isset($LevL3) && $LevL3 === TRUE) {
                $RWup3 = $db->sql_fetchrow($MS3);

                $RWup3['text_data'] = stripslashes($RWup3['text_data']);
                $RWup3['www autor'] = '';

                if (isset($RWup3['autor']{2}))
                    $RWup3['www autor'] .= stripslashes($RWup3['autor']);

                if (isset($RWup3['istochnik_link']{7}) && isset($RWup3['istochnik']{2})) {
                    $RWup3['www autor'] .= ' <noindex><a href="' . $RWup3['istochnik_link'] . '" title="' . htmlspecialchars(stripslashes($RWup3['istochnik'])) . '">' . stripslashes($RWup3['istochnik']) . '</a></p>';
                } elseif (isset($RWup3['istochnik_link']{7}) && !isset($RWup3['istochnik']{2})) {
                    $RWup3['www autor'] .= ' <noindex><a href="' . $RWup3['istochnik_link'] . '" target="_blank" title="' . str_replace('http://', '', $RWup3['istochnik_link']) . '">' . $RWup3['istochnik_link'] . '</a></noindex></p>';
                } elseif (!isset($RWup3['istochnik_link']{7}) && isset($RWup3['istochnik']{2})) {
                    $RWup3['www autor'] .= ' <u>' . stripslashes($RWup3['istochnik']) . '</u></p>';
                }

                if (isset($RWup3['www autor']{2}))
                    $RWup3['www autor'] = 'Источник: ' . $RWup3['www autor'];

                // навигация +
                if (1 == 1) {
                    $MSq3 = $db->sql_query("SELECT `head` FROM `mod_news_cat`
                            WHERE `id`= '" . $_GET['option'] . "' OR `id` = '" . $_GET['extend'] . "'
                            ORDER BY `level` ASC
                            LIMIT 2;");
                    $row3 = $db->sql_fetchrow($MSq3);
                    $RWup3['navig'] = $Navig . ' > <a href="/' . $_GET['level'] . '/' . $_GET['option'] . '.htm" title="каталог ' . $row3['head'] . '">' . $row3['head'] . '</a>';
                    if ($_GET['option'] = !$_GET['extend']) {
                        $row3 = $db->sql_fetchrow($MSq3);
                        $RWup3['navig'] .= ' > <a href="/' . $_GET['level'] . '/' . $_GET['option'] . '/' . $_GET['extend'] . '.htm" title="каталог ' . $row3['head'] . '">' . $row3['head'] . '</a>';
                    }
                    unset($MSq3, $row3);
                }

                // навигация -




                $ctpl->ins_page('dn.body', 'list', 'dn.item.body');
                $ctpl->ins_loads_vars('dn.body', $RWup3);
            } else {

                if (isset($_GET['option']) && is_numeric($_GET['option']) &&
                        isset($_GET['extend']) && is_numeric($_GET['extend'])) {
                    $MS2 = $db->sql_query("SELECT * FROM `mod_news_cat`
                                WHERE `user`='" . $domen_info['login'] . "' AND
                                        `folder` = '" . $domen_info['folder'] . "' AND
                                        `module`='" . $_GET['level'] . "' AND
                                        `level` = '2' AND
                                        `up_id` = '" . $_GET['option'] . "' AND
                                        `id` = '" . $_GET['extend'] . "' AND
                                        `publick` = 'look'
                                ORDER BY `sort` DESC;");
                    if ($MS2) {
                        $NuS2 = $db->sql_numrows($MS2);
                        if ($NuS2 > 0) {
                            $LevL2 = TRUE;
                        }
                    }
                }

                if (isset($LevL2) && $LevL2 === TRUE) {
                    $RWup2 = $db->sql_fetchrow($MS2);

                    $MS3 = $db->sql_query("SELECT *
                                FROM `mod_news_item`
                                WHERE
                                        `user`='" . $domen_info['login'] . "' AND
                                        `folder` = '" . $domen_info['folder'] . "' AND
                                        `module`='" . $_GET['level'] . "' AND
                                        `cat_id` = '" . $_GET['extend'] . "' AND
                                        `publick` = 'look'
                                ORDER BY `sort` DESC;");

                    if ($db->sql_numrows($MS3) > 0) {
                        while ($ro3 = $db->sql_fetchrow($MS3)) {
                            if (!isset($ro3['image']{3}))
                                $ro3['img'] = '';

                            //if(!isset($ro3['id']{2}) )
                            //$ro3['id'] = $ro3['id'];

                            $ctpl->add_and_refresh('te_item_li4', 'dn.3cat.item', $ro3);
                        }
                        unsettpl($ctpl, 'dn.3cat.item');
                        $ctpl->ins_page('dn.3cat.body', 'list', 'te_item_li4');
                        unsettpl($ctpl, 'te_item_li4');
                    }

                    // навигация +
                    if (1 == 1) {

                        $MSq3 = $db->sql_query("SELECT `head` FROM `mod_news_cat`
                                WHERE `id`= '" . $_GET['option'] . "' OR `id` = '" . $_GET['extend'] . "'
                                ORDER BY `level` ASC
                                LIMIT 2;");
                        $row3 = $db->sql_fetchrow($MSq3);
                        $Navig .= ' > <a href="/' . $_GET['level'] . '/' . $_GET['option'] . '.htm" title="каталог ' . $row3['head'] . '">' . $row3['head'] . '</a>';

                        $row3 = $db->sql_fetchrow($MSq3);
                        $Navig .= ' > <a href="/' . $_GET['level'] . '/' . $_GET['option'] . '/' . $_GET['extend'] . '.htm" title="каталог ' . $row3['head'] . '">' . $row3['head'] . '</a>';

                        unset($MSq3, $row3);
                    }

                    // навигация -






                    $ctpl->ins_loads_vars('dn.3cat.body', array('site level' => $_GET['level']));
                    $ctpl->ins_loads_vars('dn.body', array('navig' => $Navig, 'list' => '<ul>{list}</ul>'));
                    $ctpl->ins_page('dn.body', 'list', 'dn.3cat.body');
                    unsettpl($ctpl, 'dn.3cat.body');
                    $ctpl->ins_loads_vars('dn.body', $RWup3);
                    unset($RWup3);
                } else { // если второй каталог не выбран или выбран не верно
                    if (isset($_GET['option']) && is_numeric($_GET['option'])) {
                        $MSl = $db->sql_query("SELECT * FROM `mod_news_cat`
                                        WHERE `user`='" . $domen_info['login'] . "' AND
                                                `folder` = '" . $domen_info['folder'] . "' AND
                                                `module`='" . $_GET['level'] . "' AND
                                                `level` = 1 AND
                                                `id` = '" . $_GET['option'] . "' AND
                                                `publick` = 'look'
                                        ORDER BY `sort` DESC;");

                        if ($MSl && $db->sql_numrows($MSl) > 0)
                            $LevL1 = TRUE;
                    }

                    // показ каталога 1 уровня
                    if (isset($LevL1) && $LevL1 === TRUE) {
                        $RWup = $db->sql_fetchrow($MSl);

                        // если разрешено статьи бросать в каталоги второго уровня то каталоги второго уровня показываем, иначе нет.
                        if ($AMCfg['ArticleInCat_2'] == 'da') {
                            $MS2 = $db->sql_query("SELECT * FROM `mod_news_cat`
                                                WHERE `user`='" . $domen_info['login'] . "' AND
                                                        `folder` = '" . $domen_info['folder'] . "' AND
                                                        `module`='" . $_GET['level'] . "' AND
                                                        `level` = 2 AND
                                                        `up_id` = '" . $RWup['id'] . "' AND
                                                        `publick` = 'look'
                                                ORDER BY `sort` DESC;");

                            if ($MS2 && $db->sql_numrows($MS2) > 0) {
                                while ($ro2 = $db->sql_fetchrow($MS2)) {
                                    if (!isset($ro2['image']{3}))
                                        $ro2['img'] = '';

                                    $ctpl->add_and_refresh('te_item_list654654', 'dn.2cat.item', $ro2);
                                }
                                unsettpl($ctpl, 'dn.2cat.item');

                                $ctpl->ins_page('dn.2cat.body', 'list', 'te_item_list654654');
                                unsettpl($ctpl, 'te_item_list654654');
                            }
                        }

                        // если разрешено показывать статьи в каталоге первого уровня, то показываем
                        if ($AMCfg['ArticleInCat_1'] == 'da') {

                            //$status = '';
                            $MS3 = $db->sql_query("SELECT *
                                                FROM `mod_news_item`
                                                WHERE
                                                        `user`='" . $domen_info['login'] . "' AND
                                                        `folder` = '" . $domen_info['folder'] . "' AND
                                                        `module`='" . $_GET['level'] . "' AND
                                                        `cat_id` = '" . $RWup['id'] . "' AND
                                                        `publick` = 'look'
                                                ORDER BY `sort` DESC;");
                            //echo $status;
                            if ($MS3 && $db->sql_numrows($MS3) > 0) {
                                while ($ro3 = $db->sql_fetchrow($MS3)) {
                                    if (!isset($ro3['image']{3}))
                                        $ro3['img'] = '';

                                    //if(!isset($ro3['id']{2}) )
                                    //$ro3['id'] = $ro3['id'];
                                    $ctpl->add_and_refresh('te_item_li4', 'dn.3cat.item', $ro3);
                                }
                                unsettpl($ctpl, 'dn.3cat.item');

                                $ctpl->ins_page('dn.3cat.body', 'list', 'te_item_li4');
                                unsettpl($ctpl, 'te_item_li4');

                                $ctpl->ins_loads_vars('dn.3cat.body', array(
                                    'site level' => $_GET['level'],
                                    'extend' => $RWup['id']));

                                $ctpl->ins_page('dn.body', 'listcat', 'dn.3cat.body');
                                unsettpl($ctpl, 'dn.3cat.body');
                            }
                        }

                        // верхняя строка навигации в каталоге первого уровня
                        if (1 == 1) {
                            $MSq3 = $db->sql_query("SELECT `head` FROM `mod_news_cat`
                                                WHERE `id`='" . $_GET['option'] . "'
                                                LIMIT 1;");
                            $row3 = $db->sql_fetchrow($MSq3);
                            $Navig .= ' > <a href="/' . $_GET['level'] . '/' . $_GET['option'] . '.htm" title="каталог ' . $row3['head'] . '">' . $row3['head'] . '</a>';
                        }

                        $ctpl->ins_loads_vars('dn.2cat.body', array('site level' => $_GET['level']));
                        $ctpl->ins_loads_vars('dn.body', array(
                            'navig' => $Navig,
                            'list' => '<ul>{list}</ul>'));
                        $ctpl->ins_page('dn.body', 'list', 'dn.2cat.body');
                    } else { // показ всех каталогов +
                        //echo __LINE__.'<br/>';
                        $_InTpl = array(); // вставим в конце в шаблон
                        $_InTpl['list cat'] = '';

                        $MSql = $db->sql_query("SELECT * FROM `mod_news_cat`
                                        WHERE `user`='" . $domen_info['login'] . "' AND
                                                `folder` = '" . $domen_info['folder'] . "' AND
                                                `module`='" . $_GET['level'] . "' AND
                                                `level` = 1 AND
                                                `publick` = 'look'
                                        ORDER BY `sort` DESC;");

                        if ($MSql && $db->sql_numrows($MSql) > 0) {
                            while ($row = $db->sql_fetchrow($MSql)) {
                                $row['head'] = stripslashes($row['head']);
                                $row['opis'] = stripslashes($row['opis']);

                                if (!isset($row['image']{3})) {
                                    $row['img'] = '111--------1111';
                                } else {
                                    $row['img'] = '222------------222222<img src="' . $row['image'] . '" alt="" border="0" />';
                                }


                                $ctpl->add_and_refresh('te_item_list', 'dn.1.list', $row);
                            }
                        } else {
                            $ctpl->ins_loads_vars('dn.body', array('list' => ''));
                        }


                        // $Navig .= '';


                        $ctpl->ins_loads_vars('te_item_list', array('site level' => $_GET['level']));
                        $ctpl->ins_loads_vars('dn.body', array('navig' => $Navig, 'list' => '<ul>{list}</ul>'));
                        $ctpl->ins_page('dn.body', 'list', 'te_item_list');
                    } // показ всех каталогов -
                }
            }

            // затирка ненужных перменных в шаблоне
            $ctpl->ins_loads_vars('dn.body', array('list' => '', 'listcat' => ''));
            $ctpl->ins_page('body', 'insert body body', 'dn.body');
            unsettpl($ctpl, 'dn.body');
        }
    }
}