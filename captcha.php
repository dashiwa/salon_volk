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

require ('includes/top.php');
require_once (_CLASS.'kcaptcha.php');

$captcha = new KCAPTCHA();
$_SESSION['captcha_keystring'] = $captcha->getKeyString();


?>