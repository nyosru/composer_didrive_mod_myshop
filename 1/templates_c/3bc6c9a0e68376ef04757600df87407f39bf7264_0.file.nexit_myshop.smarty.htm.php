<?php
/* Smarty version 3.1.29, created on 2018-06-24 02:33:40
  from "/var/www/acms3/data/www/site/template-mail/nexit_myshop.smarty.htm" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5b2ebcb4381233_33160909',
  'file_dependency' => 
  array (
    '3bc6c9a0e68376ef04757600df87407f39bf7264' => 
    array (
      0 => '/var/www/acms3/data/www/site/template-mail/nexit_myshop.smarty.htm',
      1 => 1529789598,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b2ebcb4381233_33160909 ($_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!--  --> <meta name="viewport" content="width=device-width, initial-scale=1.0"/> <title>Ручной магазин</title> </head> <body style="width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;"> <center> <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['uri']->value;?>
" style="display:block;text-align:center;text-decoration: none; margin: 20px;"> <nobr> <font style="font-family: arial; font-weight: 500; font-size: 30px;color:#006ac3;" ><?php if (isset($_smarty_tpl->tpl_vars['for_mail_head']->value) && mb_strlen($_smarty_tpl->tpl_vars['for_mail_head']->value, 'UTF-8') > 2) {
echo $_smarty_tpl->tpl_vars['for_mail_head']->value;
} else { ?>Ручной&nbsp;<span style="color:#ee3f58;" >магазин</span><?php }?></font> </nobr> </a> <table width="600" style="margin-top:20px; display: inline-block; width: 600px; height: 10px; background-color: blue;"><tr><td style="background-color: blue;"></td></tr></table> <!-- End of Header --> <br clear="all"/> <br/> <table width="600" cellpadding="0" cellspacing="0" border="0" > <tbody> <!-- Title --> <tr> <td style="font-family: Helvetica, arial, sans-serif; font-size: 20px;font-weight:bold; color: #000000; text-align:left; line-height: 24px;"><?php if (isset($_smarty_tpl->tpl_vars['for_mail_head2']->value) && mb_strlen($_smarty_tpl->tpl_vars['for_mail_head2']->value, 'UTF-8') > 2) {
echo $_smarty_tpl->tpl_vars['for_mail_head2']->value;
} else {
echo $_smarty_tpl->tpl_vars['head']->value;
}?><br/> <br/> </td> </tr> <!-- End of Title --> <!-- content --> <tr> <td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #797979; text-align:left; line-height: 24px;"><?php echo $_smarty_tpl->tpl_vars['text']->value;?>
</td> </tr> <!-- End of content --> </tbody> </table> <!-- end of text --> <br/> <br/> <br/> <br/> <font color="gray">Вы можете отписаться от рассылки, обратившись в службу поддержки</font> </center> <!--  -->
    </body>

</html><?php }
}
