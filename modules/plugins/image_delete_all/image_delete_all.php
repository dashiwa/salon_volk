<?php
/*
Plugin Name: Удаление всех картинок товаров
Plugin URI: http://www.shopos.ru/plugins/
Description: Плагин удаляет все картинки товаров. 
Version: 1.0
*/

defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

add_action('process', 'image_delete_all');

    function image_delete_all() 
	{
         $_count_delete= 0;
		 
         @ os_set_time_limit(0);
        
		  $img_array = os_getFiles(dir_path('images_popup'));
		  

		   if (!empty($img_array))
		   {
		   foreach ($img_array as $_img)
	       {
	             $_count_delete++;
	             os_delete_file( dir_path('images_popup') . $_img['text']);
	       }
		   }
		   		 
		  $img_array = os_getFiles(dir_path('images_original'));
		   
		   if (!empty($img_array))
		   {
		   foreach ($img_array as $_img)
	       {
	             $_count_delete++;
	             os_delete_file(dir_path('images_original').$_img['text']);
	       }
		   }
		   
		   $img_array = os_getFiles(dir_path('images_thumbnail'));
		   
		   if (!empty($img_array))
		   {
		   foreach ($img_array as $_img)
	       {
	             $_count_delete++;
	             os_delete_file(dir_path('images_thumbnail').$_img['text']);
	       }
		   }
		   
		   $img_array = os_getFiles(dir_path('images_info'));
		   
		   if (!empty($img_array))
		   {
		   foreach ($img_array as $_img)
	       {
	             $_count_delete++;
	             os_delete_file(dir_path('images_info').$_img['text']);
	       }
		   }
		   global $messageStack;
			
		   $messageStack->add_session('ok. Удалено '.$_count_delete.' картинок.', 'success');

	}


?>