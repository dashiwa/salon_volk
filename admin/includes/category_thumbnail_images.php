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

if(CATEGORIES_IMAGE_THUMBNAIL_ACTIVE == 'true') {

	require_once(dir_path('func_admin') . 'trumbnails_add_funcs.php');

	os_mkdir_recursive(dir_path('images_thumbnail'), dirname($products_image_name));

	list($width, $height) = os_get_image_size(dir_path('images').'categories/old_' . $categories_image_name, CATEGORIES_IMAGE_THUMBNAIL_WIDTH, CATEGORIES_IMAGE_THUMBNAIL_HEIGHT);

  $a = new image_manipulation(dir_path('images').'categories/old_' . $categories_image_name, $width, $height, dir_path('images').'categories/' . $categories_image_name, IMAGE_QUALITY, '');

$array=clear_string(CATEGORIES_IMAGE_THUMBNAIL_BEVEL);
if (CATEGORIES_IMAGE_THUMBNAIL_BEVEL != ''){
$a->bevel($array[0],$array[1],$array[2]);}

$array=clear_string(CATEGORIES_IMAGE_THUMBNAIL_GREYSCALE);
if (CATEGORIES_IMAGE_THUMBNAIL_GREYSCALE != ''){
$a->greyscale($array[0],$array[1],$array[2]);}

$array=clear_string(CATEGORIES_IMAGE_THUMBNAIL_ELLIPSE);
if (CATEGORIES_IMAGE_THUMBNAIL_ELLIPSE !== ''){
$a->ellipse($array[0]);}

$array=clear_string(CATEGORIES_IMAGE_THUMBNAIL_ROUND_EDGES);
if (CATEGORIES_IMAGE_THUMBNAIL_ROUND_EDGES != ''){
$a->round_edges($array[0],$array[1],$array[2]);}

$string=str_replace("'",'',CATEGORIES_IMAGE_THUMBNAIL_MERGE);
$string=str_replace(')','',$string);
$string=str_replace('(',dir_path('images'),$string);
$array=explode(',',$string);
if (CATEGORIES_IMAGE_THUMBNAIL_MERGE != ''){
$a->merge($array[0],$array[1],$array[2],$array[3],$array[4]);}

$array=clear_string(CATEGORIES_IMAGE_THUMBNAIL_FRAME);
if (CATEGORIES_IMAGE_THUMBNAIL_FRAME != ''){
$a->frame($array[0],$array[1],$array[2],$array[3]);}

$array=clear_string(CATEGORIES_IMAGE_THUMBNAIL_DROP_SHADOW);
if (CATEGORIES_IMAGE_THUMBNAIL_DROP_SHADOW != ''){
$a->drop_shadow($array[0],$array[1],$array[2]);}

$array=clear_string(CATEGORIES_IMAGE_THUMBNAIL_MOTION_BLUR);
if (CATEGORIES_IMAGE_THUMBNAIL_MOTION_BLUR != ''){
$a->motion_blur($array[0],$array[1]);}

	  $a->create();
}
?>