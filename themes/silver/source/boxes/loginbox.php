<?php
/*
#####################################
# ShopOS: Скрипты интернет-магазина
#  Copyright (c) 2008-2010
# http://www.shopos.ru
# Ver. 1.0.1
#####################################
*/

$box = new osTemplate;
$box->assign('tpl_path', _HTTP_THEMES_C);
$box_content = '';

if (!os_session_is_registered('customer_id')) {

	$box->assign('FORM_ACTION', '<form id="loginbox" method="post" action="'.os_href_link(FILENAME_LOGIN, 'action=process', 'SSL').'">');
	$box->assign('FIELD_EMAIL', os_draw_input_field('email_address', '', 'size="15" maxlength="30"'));
	$box->assign('FIELD_PWD', os_draw_password_field('password', '', 'size="15" maxlength="30"'));
	$box->assign('BUTTON', os_image_submit('button_login_small.gif', IMAGE_BUTTON_LOGIN));
	$box->assign('LINK_LOST_PASSWORD', os_href_link(FILENAME_PASSWORD_DOUBLE_OPT, '', 'SSL'));
	$box->assign('LINK_NEW_ACCOUNT', os_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
	$box->assign('FORM_END', '</form>');

	$box->assign('BOX_CONTENT', isset($loginboxcontent)?$loginboxcontent:'');

	$box->caching = 0;
	$box->assign('language', $_SESSION['language']);
	$box_loginbox = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_login.html');
	$osTemplate->assign('box_LOGIN', $box_loginbox);
}
?>