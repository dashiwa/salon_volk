<?php
/*
#####################################
#  ShopOS: Shopping Cart Software.
#  Copyright (c) 2008-2010
#  http://www.shopos.ru
#  http://www.shoposs.com
#  Ver. 1.0.2
#####################################
*/

require_once (_LIB.'smarty/smarty.class.php');

class osTemplate extends Smarty 
{
   function osTemplate()
   {
        $this->Smarty();
        $this->template_dir = _THEMES;
        $this->compile_dir = _CACHE;
        $this->config_dir   = _LANG;
        $this->cache_dir    = _CACHE;
        $this->plugins_dir = array(_LIB.'smarty/plugins',);
        
		global $p;
		$name = $p->name;
		$group = $p->group;
				
		$array = array('app_name' => 'osTemplate');
		
		$array = apply_filter('tpl_vars', $array);
		
		$p->name = $name;
		$p->group = $group;
		$p->set_dir();
		
		if ( count($array) > 0 )
		{
		   foreach ($array as $name => $value)
		   {
		       $this->assign($name, $value);
		   }
		}
		
		$this->assign('mainpage', http_path('catalog'));

	
		if ( is_file( _THEMES_C.'lang/'.$_SESSION['language_code'].'.conf') )
		{
		   $this->config_load(_THEMES_C.'lang/'.$_SESSION['language_code'].'.conf');
		}
   }
}
?>