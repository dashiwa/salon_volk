<?php
/*
Plugin Name: robots.txt
Plugin URI: http://www.shopos.ru/plugins/
Description: 
Version: 1.0
Author: Матецкий Евгений
Author URI: http://www.shopos.ru/
*/

defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

add_action('page_admin', 'page_robots'); /* сохранение товара */
add_action('main_page_admin', 'main_page_robots');

function robots_txt_readonly ($value)
{
  /* if (is_file( dir_path('catalog') . 'robots.txt'))
	{
	   $_robots = file_get_contents(dir_path('catalog') . 'robots.txt');
	   //$_robots = addslashes(Htmlspecialchars($_robots));
	   $robots = '<textarea class="round plugin" cols="26" rows="10">'.$_robots.'</textarea>';
	}
	else
	{
	   $robots = '<textarea class="round plugin" cols="26" rows="10">no file!</textarea>';
	}
	
	_e($robots);
	*/

	_e(add_button('main_page', 'main_page_robots', 'Редактировать файл robots.txt' ));
}

function page_robots()
{
     if (is_file( dir_path('catalog') . 'robots.txt') && is_writeable(dir_path('catalog') . 'robots.txt'))
	 {
         global $messageStack;
         $messageStack->add_session('robots.txt сохранен!', 'success');
		 $page_robots = $_POST['page_robots'];
		 
		 $f = fopen( dir_path('catalog') . 'robots.txt','w+'); 
         fwrite($f, $page_robots);   
         fclose($f);
	 }
	 else
	 {
	     global $messageStack;
         $messageStack->add_session('robots.txt не сохранен!', 'success'); 
	 }
	 
	 os_redirect(os_href_link(FILENAME_PLUGINS, 'module=robots'));
}

function main_page_robots()
{
   if (is_file( dir_path('catalog') . 'robots.txt'))
	{
	   $_robots = file_get_contents(dir_path('catalog') . 'robots.txt');
	   //$_robots = addslashes(Htmlspecialchars($_robots));
	  $robots = '';
	  
	  if (is_writeable(dir_path('catalog') . 'robots.txt'))
      {
           $robots .= "<font color='green'><b>файл открыт для записи</b></font><br />";
      }
      else
      {
            $robots .= "<font color='red'><b>файл закрыт для записи</b></font><br />";
      }
	  
	   $robots .= '<form action="'.FILENAME_PLUGINS_PAGE.'?page=page_robots" method="POST">';
	   $robots .= '<textarea class="round plugin" cols="26" name="page_robots" rows="10">'.$_robots.'</textarea>';
	   $robots .= '<br>'.add_button_send(TEXT_SAVE).'<br>';
	   $robots .='</form>';
	}
	else
	{
	   $robots = '<textarea class="round plugin" cols="26" rows="10">no file!</textarea>';
	}
	
	_e($robots);
}

function robots_install()
{
    add_option('robots_txt', '' , 'readonly');
}

add_action('admin_menu', 'robots_admin_menu');

function robots_admin_menu()
{
   add_plug_menu('Редактировать robots.txt', 'plugins_page.php?main_page=main_page_robots');
}
?>