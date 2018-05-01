<?php
/*
Plugin Name: Social
Plugin URI: http://www.shopos.ru/plugins/
Version: 1.1
Author: Матецкий Евгений
Author URI: http://www.shopos.ru/
*/

defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

include( plugdir() . 'func.php' );

//соц. закладки на странице новостейэ
if ( isset($_GET['news_id']) && get_option('articles_filter') == 'true' )
{
   add_filter ('news_content', 'news_social_filter');
   add_action ('head', 'social_head');
}

//соц. закладки на странице статей
if ( isset($_GET['articles_id']) && get_option('news_filter') == 'true' )
{
   add_filter ('article_info', 'articles_social_filter');
   add_action ('head', 'social_head');
}

add_action('page', 'social_send');

//добавление соц. закладок на страницу товара
if ( is_page('product_info') && get_option('products_filter') == 'true')
{
   add_filter('products_added', 'products_added_filter');
   add_action ('head', 'social_head');
}

function products_added_filter($value)
{
   global $product;

   $title = $product->data['products_name'];
   
   $url = http_path('server').$_SERVER['REQUEST_URI'];
   $url_plug = social_page(); 
   
   $_script = '<script type="text/javascript" language="JavaScript">
<!--
var socialTitle="'.$title.'&quot;";
var socialUrl="'.$url.'";
var socialplug="'.$url_plug.'";
//--></script>';


   return $value.'<br />'._social_icons($url, $title).$_script;
}

//для новостей					
function news_social_filter ($value)
{

   $title =  strip_tags($value['NEWS_HEADING']);
   $url =  $value['NEWS_LINK_MORE'];
   $url_plug = social_page(); 
   
   $_script = '<script type="text/javascript" language="JavaScript">
<!--
var socialTitle="'.$title.'&quot;";
var socialUrl="'.$url.'";
var socialplug="'.$url_plug.'";
//--></script>';
   $value['NEWS_CONTENT'] .= '<br />'._social_icons($url, $title).$_script;
   
   return $value;
}

//для статей
/* фильтр информации о статье */
/*
массив $value, передается в качестве параментра функции фильтра, указанную при добавлении фильтра
//add_filter ('article_info', 'articles_social_filter');
Array
(
    [ARTICLE_NAME] => Название статьи
    [ARTICLE_DESCRIPTION] => Содержимое статьи
    [ARTICLE_VIEWED] => 5  //кол. просмотров статьи 
    [ARTICLE_DATE] => Среда, 02 Июня 2010  //дата добавления статьи 
    [ARTICLE_URL] => acer.ru 
    [AUTHOR_NAME] =>   //название автотора 
    [AUTHOR_LINK] => http://shopos/2.5.1/upload/articles.php?authors_id=0
    [ARTICLE_PAGE_URL] => http://shopos/2.5.1/upload/4444444444.html
) 
*/					
function articles_social_filter ($value)
{ 
   //название статьи с удаленными метатегами
   $title =  strip_tags($value['ARTICLE_NAME']);
   //ссылка на статью
   $url =  $value['ARTICLE_PAGE_URL'];
   //ссылка на страницу, которая обрабатывает отправку информации о статье на сайты
   $url_plug = social_page(); 
   
   $_script = '<script type="text/javascript" language="JavaScript">
<!--
var socialTitle="'.$title.'&quot;";
var socialUrl="'.$url.'";
var socialplug="'.$url_plug.'";
//--></script>';

   //Добавляем в конец статьи, с отступами блок-закладочник
   $value['ARTICLE_DESCRIPTION'] .= '<br /><br />'._social_icons($url, $title).$_script.'<br /><br />';
   
   return $value;
}

function social_install()
{
    add_option('articles_filter', 'true', 'radio', "array('true','false')");
    add_option('news_filter', 'true', 'radio', "array('true','false')");
    add_option('products_filter', 'true', 'radio', "array('true','false')");
}

?>