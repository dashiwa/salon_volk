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

$data = $product->getAlsoPurchased();
if (count($data) >= MIN_DISPLAY_ALSO_PURCHASED) {

	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $data);
	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/also_purchased.html');

	$info->assign('MODULE_also_purchased', $module);

}
?>