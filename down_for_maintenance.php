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

require (dir_path('includes').'header.php');

$osTemplate->assign('language', $_SESSION['language']);
$osTemplate->caching = 0;
$main_content = $osTemplate->fetch(CURRENT_TEMPLATE.'/module/down_for_maintenance.html');
$osTemplate->assign('main_content', $main_content);

$osTemplate->load_filter('output', 'trimhitespace');
$osTemplate->display(CURRENT_TEMPLATE.'/module/down_for_maintenance.html');

?>