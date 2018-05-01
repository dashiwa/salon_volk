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
$box_content='';
$box->assign('tpl_path', _HTTP_THEMES_C);

if (isset($_SESSION['affiliate_id'])) 
{
    $box_content .= '<a href="' . os_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'SSL') . '">' . BOX_AFFILIATE_SUMMARY . '</a><br />';
    $box_content .= '<a href="' . os_href_link(FILENAME_AFFILIATE_ACCOUNT, '', 'SSL'). '">' . BOX_AFFILIATE_ACCOUNT . '</a><br />';
    $box_content .= '<a href="' . os_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'SSL'). '">' . BOX_AFFILIATE_PAYMENT . '</a><br />';
    $box_content .= '<a href="' . os_href_link(FILENAME_AFFILIATE_CLICKS, '', 'SSL'). '">' . BOX_AFFILIATE_CLICKRATE . '</a><br />';
    $box_content .= '<a href="' . os_href_link(FILENAME_AFFILIATE_SALES, '', 'SSL'). '">' . BOX_AFFILIATE_SALES . '</a><br />';
    $box_content .= '<a href="' . os_href_link(FILENAME_AFFILIATE_BANNERS). '">' . BOX_AFFILIATE_BANNERS . '</a><br />';
    $box_content .= '<a href="' . os_href_link(FILENAME_AFFILIATE_CONTACT). '">' . BOX_AFFILIATE_CONTACT . '</a><br />';
    $box_content .= '<a href="' . os_href_link(FILENAME_CONTENT, 'coID=11'). '">' . BOX_AFFILIATE_FAQ . '</a><br />';
    $box_content .= '<a href="' . os_href_link(FILENAME_AFFILIATE_LOGOUT). '">' . BOX_AFFILIATE_LOGOUT . '</a>';
}
else 
{
	$box_content .= '<a href="' . os_href_link(FILENAME_CONTENT,'coID=10'). '">' . BOX_AFFILIATE_INFO . '</a><br />';
	$box_content .= '<a href="' . os_href_link(FILENAME_AFFILIATE, '', 'SSL') . '">' . BOX_AFFILIATE_LOGIN . '</a>';
}
$box->assign('BOX_CONTENT', $box_content);
$box->assign('language', $_SESSION['language']);

$box->caching = 0;
$box_affiliate = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_affiliate.html');
$osTemplate->assign('box_AFFILIATE',$box_affiliate);
?>