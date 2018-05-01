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

require('includes/top.php');
//$osTemplate = new osTemplate;


$breadcrumb->add(NAVBAR_TITLE, os_href_link(FILENAME_AFFILIATE, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_LOGOUT);

require(_INCLUDES . 'header.php');

$old_user = $_SESSION['affiliate_id'];  // store  to test if they *were* logged in
unset($_SESSION['affiliate_id']);
$old_user = $_SESSION['affiliate_id'];  // store  to test if they *were* logged in
unset($_SESSION['affiliate_id']);
if (isset($_SESSION['affiliate_id'])) {
	$result = 0;
}
else {
	$result = 1;
}

//session_destroy();

if (!empty($old_user)) {
	if ($result) { // if they were logged in and are not logged out
	    $info = 0;
	}
	else { // they were logged in and could not be logged out
    	$info = 1;
    }
}
else { // if they weren't logged in but came to this page somehow
	$info = 2;
}

$osTemplate->assign('info', $info);

$osTemplate->assign('LINK_DEFAULT', button_continue());
$osTemplate->assign('language', $_SESSION['language']);
$osTemplate->caching = 0;
$main_content=$osTemplate->fetch(CURRENT_TEMPLATE . '/module/affiliate_logout.html');
$osTemplate->assign('main_content',$main_content);
$osTemplate->assign('language', $_SESSION['language']);
$osTemplate->caching = 0;
 $osTemplate->load_filter('output', 'trimhitespace');
$osTemplate->display(CURRENT_TEMPLATE . '/index.html');

?>
