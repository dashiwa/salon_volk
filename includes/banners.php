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

if (VIS_BANNER == 'true')
{
  if ($banner = os_banner_exists('dynamic', 'banner')) 
  {
       $osTemplate->assign('BANNER', os_display_banner('static', $banner));
  }
} 
?>