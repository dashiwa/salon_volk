<?php
/*
#####################################
#  ShopOS: Shopping Cart Software.
#  Copyright (c) 2008-2010
#  http://www.shopos.ru
#  http://www.shoposs.com
#  Ver. 1.0.1
#####################################
*/

require_once (_LIB.'smarty/smarty.class.php');

class osTemplate extends Smarty {
   function osTemplate()
   {
        $this->Smarty();
        $this->template_dir = _THEMES;
        $this->compile_dir = _CACHE;
        $this->config_dir   = _LANG;
        $this->cache_dir    = _CACHE;
        $this->plugins_dir = array(_LIB.'smarty/plugins',);
        $this->assign('app_name', 'osTemplate');
   }
}

?>