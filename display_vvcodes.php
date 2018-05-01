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
$visual_verify_code = os_random_charcode(6);
$_SESSION['vvcode'] = $visual_verify_code;
$vvimg = vvcode_render_code($visual_verify_code);
?>