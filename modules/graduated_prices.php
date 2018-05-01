<?php
/*
#####################################
#  ShopOS: Shopping Cart Software.
#  Copyright (c) 2008-2010
#  http://www.shopos.ru
#  http://www.shoposs.com
#  Ver. 1.0.0
#####################################
*/

$module = new osTemplate;
$module->assign('tpl_path', _HTTP_THEMES_C);
$module_content = array ();

$staffel_data = $product->getGraduated();

if (sizeof($staffel_data) > 1) {
	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $staffel_data);
	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/graduated_price.html');

	$info->assign('MODULE_graduated_price', $module);
}
?>