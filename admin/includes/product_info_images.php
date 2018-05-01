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

defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

if(PRODUCT_IMAGE_INFO_ACTIVE == 'true') {

	require_once(dir_path('func_admin') . 'trumbnails_add_funcs.php');

	os_mkdir_recursive(dir_path('images_info'), dirname($products_image_name));

	list($width, $height) = os_get_image_size(dir_path('images_original') . $products_image_name, PRODUCT_IMAGE_INFO_WIDTH, PRODUCT_IMAGE_INFO_HEIGHT);

	$a = new image_manipulation( dir_path('images_original') . $products_image_name, $width, $height, dir_path('images_info') . $products_image_name, IMAGE_QUALITY, '');
$array=clear_string(PRODUCT_IMAGE_INFO_BEVEL);
if (PRODUCT_IMAGE_INFO_BEVEL != ''){
$a->bevel($array[0],$array[1],$array[2]);}

$array=clear_string(PRODUCT_IMAGE_INFO_GREYSCALE);
if (PRODUCT_IMAGE_INFO_GREYSCALE != ''){
$a->greyscale($array[0],$array[1],$array[2]);}

$array=clear_string(PRODUCT_IMAGE_INFO_ELLIPSE);
if (PRODUCT_IMAGE_INFO_ELLIPSE != ''){
$a->ellipse($array[0]);}

$array=clear_string(PRODUCT_IMAGE_INFO_ROUND_EDGES);
if (PRODUCT_IMAGE_INFO_ROUND_EDGES != ''){
$a->round_edges($array[0],$array[1],$array[2]);}

$string=str_replace("'",'',PRODUCT_IMAGE_INFO_MERGE);
$string=str_replace(')','',$string);
$string=str_replace('(',dir_path('images'),$string);
$array=explode(',',$string);
if (PRODUCT_IMAGE_INFO_MERGE != ''){
$a->merge($array[0],$array[1],$array[2],$array[3],$array[4]);}

$array=clear_string(PRODUCT_IMAGE_INFO_FRAME);
if (PRODUCT_IMAGE_INFO_FRAME != ''){
$a->frame($array[0],$array[1],$array[2],$array[3]);}

$array=clear_string(@PRODUCT_IMAGE_INFO_DROP_SHADOW);
if (@PRODUCT_IMAGE_INFO_DROP_SHADOW != ''){
$a->drop_shadow(@$array[0],@$array[1],@$array[2]);}

$array=clear_string(PRODUCT_IMAGE_INFO_MOTION_BLUR);
if (PRODUCT_IMAGE_INFO_MOTION_BLUR != ''){
$a->motion_blur($array[0],$array[1]);}
	  $a->create();
}
?>