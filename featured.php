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

include ('includes/top.php');
//$osTemplate = new osTemplate;


$breadcrumb->add(NAVBAR_TITLE_FEATURED, os_href_link(FILENAME_FEATURED));

require (dir_path('includes').'header.php');

$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}
$featured_query_raw = "select p.products_id,
                                pd.products_name,
                                pd.products_short_description,
                                p.products_price,
                                p.products_tax_class_id,p.products_shippingtime,
                                p.products_image,p.products_vpe_status,p.products_vpe_value,p.products_vpe,p.products_fsk18 from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_FEATURED." f
                                where p.products_status = '1'
                                and f.products_id = p.products_id
                                and p.products_id = pd.products_id
                                ".$group_check."
                                ".$fsk_lock."
                                and pd.language_id = '".(int) $_SESSION['languages_id']."'
                                and f.status = '1' order by f.featured_date_added DESC";
$featured_split = new splitPageResults($featured_query_raw, $_GET['page'], MAX_DISPLAY_FEATURED_PRODUCTS);

$module_content = '';
$row = 0;
$featured_query = os_db_query($featured_split->sql_query);
while ($featured = os_db_fetch_array($featured_query)) {
	$module_content[] = $product->buildDataArray($featured);
}

if (($featured_split->number_of_rows > 0)) {
	$osTemplate->assign('NAVBAR', TEXT_RESULT_PAGE.' '.$featured_split->display_links(MAX_DISPLAY_PAGE_LINKS, os_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$osTemplate->assign('NAVBAR_PAGES', $featured_split->display_count(TEXT_DISPLAY_NUMBER_OF_FEATURED));

}

$osTemplate->assign('language', $_SESSION['language']);
$osTemplate->assign('module_content', $module_content);
$osTemplate->caching = 0;
$main_content = $osTemplate->fetch(CURRENT_TEMPLATE.'/module/featured.html');

$osTemplate->assign('language', $_SESSION['language']);
$osTemplate->assign('main_content', $main_content);
$osTemplate->caching = 0;
 $osTemplate->load_filter('output', 'trimhitespace');
$template = (file_exists(_THEMES_C.FILENAME_FEATURED.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_FEATURED.'.html' : CURRENT_TEMPLATE.'/index.html');
$osTemplate->display($template);
include ('includes/bottom.php');
?>