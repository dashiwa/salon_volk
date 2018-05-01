<?php
/*
#####################################
# ShopOS: Скрипты интернет-магазина
#  Copyright (c) 2008-2010
# http://www.shopos.ru
# Ver. 1.0.1
#####################################
*/

  if (isset($osPrice) && is_object($osPrice)) 
  {

  $currencies_string = '';
  $count_cur='';
  reset($osPrice->currencies);
  while (list($key, $value) = each($osPrice->currencies)) {
  $count_cur++;
    if ($_SESSION['currency'] == $key) 
	{
       $currencies_string .= ' <a class="current" href="' . os_href_link(basename($PHP_SELF), 'currency=' . $key.'&'.os_get_all_get_params(array('language', 'currency')), $request_type) . '">' . $value['title'] . '</a> ';
	}
	else
	{
	   $currencies_string .= ' <a href="' . os_href_link(basename($PHP_SELF), 'currency=' . $key.'&'.os_get_all_get_params(array('language', 'currency')), $request_type) . '">' . $value['title'] . '</a> '; 
	}
  }

    $hidden_get_variables = '';
    reset($_GET);
    while (list($key, $value) = each($_GET)) 
	{
      if ( ($key != 'currency') && ($key != os_session_name()) && ($key != 'x') && ($key != 'y') ) {
        $hidden_get_variables .= os_draw_hidden_field($key, $value);
      }
    }


  }


  // dont show box if there's only 1 currency
  if ($count_cur > 1 ) {

  $box->assign('BOX_CONTENT', $currencies_string . $hidden_get_variables);
  $box->assign('language', $_SESSION['language']);
    	  // set cache ID
   if (!CacheCheck()) {
  $box->caching = 0;
  $box_currencies= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_currencies.html');
  } else {
  $box->caching = 1;	
  $box->cache_lifetime=CACHE_LIFETIME;
  $box->cache_modified_check=CACHE_CHECK;
  $cache_id = $_SESSION['language'].$_SESSION['currency'];
  $box_currencies= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_currencies.html',$cache_id);
  }

  $osTemplate->assign('box_CURRENCIES',$box_currencies);

  }
 ?>