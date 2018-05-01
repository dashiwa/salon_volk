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

define('AJAX_APPLICATION_RUNNING', true);

require('includes/classes/JsHttpRequest.php');

unset($JsHttpRequest);
$JsHttpRequest = new JsHttpRequest('');
require('includes/top.php');
$JsHttpRequest->setEncoding($_SESSION['language_charset']);

if (!isset($_GET['ajax_page']) || !os_not_null($_GET['ajax_page']) || !is_file(_MODULES . 'ajax/' . $_GET['ajax_page'] . '.php')) die('***ERROR*** Ajax page "' . $_GET['ajax_page'] . '" not define or not exist!!!');
if(is_file(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $_GET['ajax_page'] . '.php'))
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $_GET['ajax_page'] . '.php');
require(_MODULES . 'ajax/' . $_GET['ajax_page'] . '.php');
exit;
?>