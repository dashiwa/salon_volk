<?php
/*
#####################################
# ShopOS: Скрипты интернет-магазина
#  Copyright (c) 2008-2010
# http://www.shopos.ru
# Ver. 1.0.1
#####################################
*/

$box = new osTemplate;
$box->assign('tpl_path', _HTTP_THEMES_C); 
$box_content='';


$box->assign('FORM_ACTION', os_draw_form('sign_in', os_href_link(FILENAME_NEWSLETTER, '', 'NONSSL')));
$box->assign('FIELD_EMAIL',os_draw_input_field('email', '', 'size="15" maxlength="50"'));
$box->assign('BUTTON',os_image_submit('button_login_small.gif', IMAGE_BUTTON_LOGIN));
$box->assign('FORM_END','</form>');
	$box->assign('language', $_SESSION['language']);
       	  // set cache ID
   if (!CacheCheck()) {
  $box->caching = 0;
  $box_newsletter= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_newsletter.html');
  } else {
  $box->caching = 1;	
  $box->cache_lifetime=CACHE_LIFETIME;
  $box->cache_modified_check=CACHE_CHECK;
  $cache_id = $_SESSION['language'];
  $box_newsletter= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_newsletter.html',$cache_id);
  }

    $osTemplate->assign('box_NEWSLETTER',$box_newsletter);
?>