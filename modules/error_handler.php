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

  $module= new osTemplate;
  $module->assign('tpl_path',_HTTP_THEMES_C);

  $module->assign('language', $_SESSION['language']);
  $module->assign('ERROR',$error);
  
   $_array = array('img' => 'button_back.gif', 
	                                'href' => 'javascript:history.back(1)', 
									'alt' => IMAGE_BUTTON_BACK,								
									'code' => ''
	);
	
	$_array = apply_filter('button_back', $_array);
	
	if (empty($_array['code']))
	{
	   $_array['code'] = '<a href="'.$_array['href'].'">'. os_image_button($_array['img'], $_array['alt']).'</a>';
	}
	
  $module->assign('BUTTON', $_array['code']);
	
  $module->assign('language', $_SESSION['language']);

  // search field
  $module->assign('FORM_ACTION',os_draw_form('new_find', os_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get').os_hide_session_id());
  $module->assign('INPUT_SEARCH',os_draw_input_field('keywords', '', 'size="30" maxlength="30"'));
  $module->assign('BUTTON_SUBMIT',os_image_submit('button_quick_find.gif', BOX_HEADING_SEARCH));
  $module->assign('LINK_ADVANCED',os_href_link(FILENAME_ADVANCED_SEARCH));
  $module->assign('FORM_END', '</form>');



  $module->caching = 0;
  $module->caching = 0;
  $module= $module->fetch(CURRENT_TEMPLATE.'/module/error_message.html');

  if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO))  $product_info=$module;

  $osTemplate->assign('main_content',$module);
  
  //header('HTTP/1.1 404 Not Found');
  
?>