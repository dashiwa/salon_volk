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

if ($_GET['articles_id']) {

$xsell_query = osDBquery("select distinct a.products_id, a.products_fsk18, ad.products_name, ad.products_short_description, a.products_image, a.products_price, a.products_vpe, a.products_quantity, a.products_vpe_status, a.products_vpe_value, a.products_tax_class_id, a.products_date_added from " . TABLE_ARTICLES_XSELL . " ax, " . TABLE_PRODUCTS . " a, " . TABLE_PRODUCTS_DESCRIPTION . " ad where ax.articles_id = '" . $_GET['articles_id'] . "' and ax.xsell_id = a.products_id and a.products_id = ad.products_id and ad.language_id = '" . $_SESSION['languages_id'] . "' and a.products_status = '1' order by ax.sort_order asc limit " . MAX_DISPLAY_ALSO_PURCHASED);
$num_products_xsell = os_db_num_rows($xsell_query, true); 
if ($num_products_xsell >= MIN_DISPLAY_ALSO_PURCHASED) {

$module_content = array ();

      while ($xsell = os_db_fetch_array($xsell_query,true)) {
			$module_content[] = $product->buildDataArray($xsell);
      }

$module = new osTemplate;
$module->assign('tpl_path', _HTTP_THEMES_C);
//выводит Также рекомендуем следующие товары:
if (sizeof($module_content) > 0) { 
    $module->assign('language', $_SESSION['language']);
    $module->assign('module_content', $module_content);
    $module->caching = 0;
    $module = $module->fetch(CURRENT_TEMPLATE.'/module/articles_xsell.html');
    $osTemplate->assign('MODULE_articles_xsell', $module);
  }
 }
}

?>