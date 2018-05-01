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

$module = new osTemplate;
$module->assign('tpl_path', _HTTP_THEMES_C);

$info->assign('options', $products_options_data);
if ($product->getReviewsCount() > 0) {

if ($_SESSION['customers_status']['customers_status_write_reviews'] != 0) 
{
	$_array = array('img' => 'button_write_review.gif', 
	                                'href' => os_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, os_product_link($product->data['products_id'],$product->data['products_name'])), 
									'alt' => IMAGE_BUTTON_WRITE_REVIEW,
                  /* ��� ������� ������, �� ��������� ����� */									
									'code' => ''
	);
	
	$_array = apply_filter('button_write', $_array);
	
	if (empty($_array['code']))
	{
	   $_array['code'] = '<a href="'.$_array['href'].'">'.os_image_button($_array['img'], $_array['alt']).'</a>';
	}
	
	$module->assign('BUTTON_WRITE', $_array['code']);
}

	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $product->getReviews());
	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/products_reviews.html');

if ($_SESSION['customers_status']['customers_status_read_reviews'] != 0) {
	$info->assign('MODULE_products_reviews', $module);
}

} else {

if ($_SESSION['customers_status']['customers_status_write_reviews'] != 0) 
{
	$_array = array('img' => 'button_write_review.gif', 
	                                'href' => os_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, os_product_link($product->data['products_id'],$product->data['products_name'])), 
									'alt' => IMAGE_BUTTON_WRITE_REVIEW,
                  /* ��� ������� ������, �� ��������� ����� */									
									'code' => ''
	);
	
	$_array = apply_filter('button_write', $_array);

	if (empty($_array['code']))
	{
	   $_array['code'] = '<a href="'.$_array['href'].'">'.os_image_button($_array['img'], $_array['alt']).'</a>';
	}
	
	$module->assign('BUTTON_WRITE', $_array['code']);
	
}

	$module->assign('TEXT_FIRST_REVIEW', TEXT_FIRST_REVIEW);

	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $product->getReviews());
	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/products_reviews.html');

if ($_SESSION['customers_status']['customers_status_read_reviews'] != 0) {
	$info->assign('MODULE_products_reviews', $module);
}

}
?>