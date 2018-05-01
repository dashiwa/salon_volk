<?php
    /*
    Plugin Name: XML Sitemap
    Plugin URI: http://www.shopos.ru/
    Description: XML карта сайта для Google, Yandex. 
    Version: 1.6
    Author: Матецкий Евгений
    Author URI: http://www.shopos.ru/
    */

    defined( '_VALID_OS' ) or die( 'Direct Access to this location is not allowed.' );


    add_action('page', 'xml_sitemap');
    add_action('main_page_admin', 'xml_sitemap_ping');
    add_action('page_admin', 'xml_sitemap_send_ping');


    //вывод карты сайта
    function xml_sitemap ()
    {
        include(dirname(__FILE__).'/xml_sitemap.index.php');
    }

    //страница пинга поисковых систем
    function xml_sitemap_ping ()
    {
        $url = http_path('catalog').'admin/plugins_page.php?page=xml_sitemap_send_ping';
        $tpl =  file_get_contents ( plugdir() . 'xml_sitemap.ping.html' ); 
        $tpl = str_replace('{$title}', $title, $tpl); 
        $tpl = str_replace('{$url}', $url, $tpl); 
        $tpl = str_replace('{$img}', plugurl(), $tpl); 

        echo $tpl;
    }

    //отправил карта сайта на $url
    function send_url($url, $map) {

        $data = false;

        $file = $url.urlencode($map);
        
        if( function_exists( 'curl_init' ) ) {

            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $file );
            curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
          //  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 6 );

            $data = curl_exec( $ch );
            curl_close( $ch );

            return $data;

        } else {

            return @file_get_contents( $file );

        }

    }

    function xml_sitemap_url_readonly ()
    {
         _e('<style>
         div.ping a {
         background-image: url('.plugurl().'xml_sitemap.icon.gif); 
         background-repeat: no-repeat;
         padding-left: 15px;
         }
    
         </style>');
         
        _e('<div class="ping"><a href="'.http_path('catalog').'index.php?page=xml_sitemap'.'">Ссылка на карту сайта</a></div>');
        _e('<div class="ping"><a href="'.http_path('catalog').'admin/plugins_page.php?main_page=xml_sitemap_ping'.'">Уведомить поисковые системы о наличии новой версии карты сайта.</a></div>');
    }

    function xml_sitemap_install()
    {
        add_option('xml_sitemap_url', '', 'readonly');
    }

    function xml_sitemap_send_ping()
    {

        $buffer = '';
        
        $lang = '';
        $lang['sitemap_send'] = 'Уведомление поисковой системы'; 
        $lang['nl_finish'] = '<font color="green"><b>отправка завершена</b></font>';
        $lang['nl_error'] = '<font color="red"><b>ошибка отправки</b></font>';
        
        $map_link = http_path('catalog').'index.php?page=xml_sitemap';
        $map_link2 = http_path('catalog').'sitemap.xml';
        
        if (strpos ( send_url("http://google.com/webmasters/sitemaps/ping?sitemap=", $map_link), "successfully added" ) !== false) 
        {

            $buffer .= $lang['sitemap_send']." Google: ".$lang['nl_finish'];

        } else {

            $buffer .= $lang['sitemap_send']." Google: ".$lang['nl_error']." URL: <a href=\"http://google.com/webmasters/sitemaps/ping?sitemap=".urlencode($map_link)."\" target=\"_blank\">http://google.com/webmasters/sitemaps/ping?sitemap={$map_link}</a>";

        }

        if (strpos ( send_url("http://ping.blogs.yandex.ru/ping?sitemap=", $map_link), "OK" ) !== false) {

            $buffer .= "<br />".$lang['sitemap_send']." Yandex: ".$lang['nl_finish'];

        } else {

            $buffer .= "<br />".$lang['sitemap_send']." Yandex: ".$lang['nl_error']." URL: <a href=\"http://ping.blogs.yandex.ru/ping?sitemap=".urlencode($map_link)."\" target=\"_blank\">http://ping.blogs.yandex.ru/ping?sitemap={$map_link}</a>";

        }

        if (strpos ( send_url("http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=SitemapWriter&url=", $map_link), "successfully submitted" ) !== false) {

            $buffer .= "<br />".$lang['sitemap_send']." Yahoo: ".$lang['nl_finish'];

        } else {

            $buffer .= "<br />".$lang['sitemap_send']." Yahoo: ".$lang['nl_error']." URL: <a href=\"http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=SitemapWriter&url=".urlencode($map_link)."\" target=\"_blank\">http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=SitemapWriter&url={$map_link}</a>";

        }

        if (strpos ( send_url("http://www.bing.com/webmaster/ping.aspx?siteMap=", $map_link), "Thanks for submitting your sitemap." ) !== false) {

            $buffer .= "<br />".$lang['sitemap_send']." Bing: ".$lang['nl_finish'];

        } else {

            $buffer .= "<br />".$lang['sitemap_send']." Bing: ".$lang['nl_error']." URL: <a href=\"http://www.bing.com/webmaster/ping.aspx?siteMap=".urlencode($map_link)."\" target=\"_blank\">http://www.bing.com/webmaster/ping.aspx?siteMap={$map_link}</a>";

        }

        if (strpos ( send_url("http://rpc.weblogs.com/pingSiteForm?name=InfraBlog&url=", $map_link), "Thanks for the ping" ) !== false) {

            $buffer .= "<br />".$lang['sitemap_send']." Weblogs: ".$lang['nl_finish'];

        } else {

            $buffer .= "<br />".$lang['sitemap_send']." Weblogs: ".$lang['nl_error']." URL: <a href=\"http://rpc.weblogs.com/pingSiteForm?name=InfraBlog&url=".urlencode($map_link)."\" target=\"_blank\">http://rpc.weblogs.com/pingSiteForm?name=InfraBlog&url={$map_link}</a>";

        }

        if (strpos ( send_url("http://submissions.ask.com/ping?sitemap=", $map_link2), "submission was successful" ) !== false) {

            $buffer .= "<br />".$lang['sitemap_send']." Ask: ".$lang['nl_finish'];

        } else {

            $buffer .= "<br />".$lang['sitemap_send']." Ask: ".$lang['nl_error']." URL: <a href=\"http://submissions.ask.com/ping?sitemap=".urlencode($map_link2)."\" target=\"_blank\">http://submissions.ask.com/ping?sitemap={$map_link}</a>";
        }
        
         echo $buffer;
    }
?>