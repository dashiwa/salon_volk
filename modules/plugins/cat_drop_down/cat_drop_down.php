<?php
/*
Plugin Name: Выпадающее меню категорий
Plugin URI: http://www.shopos.ru/
Description: Создает выпадающее меню категорий
Version: 1.1
Author: Матецкий Евгений
Author URI: http://www.shopos.ru/
*/

defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

if (get_option('cat_drop_down_tpl') == 'cat_drop_down_tpl_false')
{
     add_action('box', 'cat_drop_down');
}
else
{
     rewrite_action('box', 'box_CATEGORIES', 'cat_drop_down');
}

function cat_drop_down()
{
    $title = get_option('cat_drop_down_name');
    $content = os_draw_form('goto', FILENAME_DEFAULT, 'get', '') . os_draw_pull_down_menu('cat', os_get_categories(array (array ('id' => '', 'text' => get_option('cat_drop_down_select')))), $current_category_id, 'onChange="this.form.submit();"') . '</form>';
	
	return array('title' => $title, 'content' =>$content);
}

function cat_drop_down_install()
{
    add_option('cat_drop_down_select', 'Выбрать');
    add_option('cat_drop_down_name', 'Категории');
	add_option('cat_drop_down_tpl', 'cat_drop_down_tpl_true', 'checkbox', "array('cat_drop_down_tpl_true', 'cat_drop_down_tpl_false')");
}


?>