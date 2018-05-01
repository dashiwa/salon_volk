<?php
    /*
    Plugin Name: Управление баннерами
    Plugin URI: http://www.shopos.ru/
    Version: 1.0
    Author: Матецкий Евгений
    Author URI: http://www.shopos.ru/
    */


    //add_action('main_page_admin', 'banner_statistics_page');
    add_action('main_page_admin', 'banner_manager_page');
    add_action('page_admin', 'banner_status');
    add_action('redirect', 'banner_redirect');

    define('TABLE_BANNERS', DB_PREFIX.'banners');
    define('TABLE_BANNERS_HISTORY', DB_PREFIX.'banners_history');

    //подключаем класс banner
    include_once('banner.class.php');
    //banner_status page
    include_once('banner.status.php');

    //проверяем. включен ли вывод баннеров
    if ( get_option('banner_status') == 'true')
    {
        add_filter('tpl_vars', 'banner_filter');
        add_action('session_start', 'banner_start');
    }

    //добавялем метки баннеров в шаблоны
    function banner_filter ($array)
    {
        global $banner;

        if ( !is_object($banner)) $banner = new banner();

        $_array = $banner->all ();

        if ( is_array($_array) && count($_array) > 0 )
        {
            foreach ($_array as $name => $value)
            {
                $array[ $name ] = $value;
            }
        }

        return $array;
    }

    function banner_start ()
    {
        global $banner;

        if ( !is_object($banner)) $banner = new banner();

         $banner->activate();
         $banner->expire();
    }

    //добалвение пункта в меню
    add_action('admin_menu', 'banner_menu');

    //strpos($PHP_SELF, 'plugins_page.php') === false

    if ( $_GET['main_page'] == 'banner_manager_page' or $_GET['main_page'] == 'banner_statistics_page'  )
    {
        add_action('head_admin', 'banner_head_manager');
        include_once('banner.const.php');
    }

    function banner_head_manager ()
    {
        _e('<script type="text/javascript" src="'.http_path('catalog').'jscript/jquery/jquery.js"></script>
        <link rel="stylesheet" href="'.http_path('catalog').'jscript/jquery/plugins/fancybox/jquery.fancybox-1.2.5.css" type="text/css" />
        <script type="text/javascript" src="'.http_path('catalog').'jscript/jquery/plugins/fancybox/jquery.fancybox-1.2.5.pack.js"></script>
        <script type="text/javascript"><!--
        $(document).ready(function() {
        $("a.zoom").fancybox({
        "zoomOpacity"			: true,
        "overlayShow"			: false,
        "zoomSpeedIn"			: 500,
        "zoomSpeedOut"			: 500
        });
        });
        //--></script>');
    }

    function banner_manager_page()
    {
        include('banner.manager.php');
    }

    function banner_redirect()
    {
        if ( isset($_GET['action']) &&  $_GET['action'] == 'banner' )
        {
            global $banner;

            if ( !is_object($banner)) $banner = new banner();
			
            $banner->redirect();
        }
    }

    //   function banner_statistics_page()
    // {
    //     include('banner.statistics.php');
    // }

    //добалвение элемента меню
    function banner_menu()
    {
        add_plug_menu('Управление баннерами', 'plugins_page.php?main_page=banner_manager_page');
    }

    function banner_install()
    {

        global $db;
        
        $db->query("CREATE TABLE IF NOT EXISTS ".DB_PREFIX."banners (
        banners_id int NOT NULL auto_increment,
        banners_title varchar(255) NOT NULL,
        banners_url varchar(255) NOT NULL,
        banners_image varchar(255) NOT NULL,
        banners_group varchar(10) NOT NULL,
        banners_html_text text,
        expires_impressions int(7) DEFAULT '0',
        expires_date datetime DEFAULT NULL,
        date_scheduled datetime DEFAULT NULL,
        date_added datetime NOT NULL,
        date_status_change datetime DEFAULT NULL,
        status int(1) DEFAULT '1' NOT NULL,
        PRIMARY KEY  (banners_id)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");

        $db->query("CREATE TABLE IF NOT EXISTS ".DB_PREFIX."banners_history (
        banners_history_id int NOT NULL auto_increment,
        banners_id int NOT NULL,
        banners_shown int(5) NOT NULL DEFAULT '0',
        banners_clicked int(5) NOT NULL DEFAULT '0',
        banners_history_date datetime NOT NULL,
        PRIMARY KEY  (banners_history_id)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");

        add_option('banner_status', 'true', 'radio', 'array("true", "false")');
        add_option('banner_display_count', 'true', 'radio', 'array("true", "false")');
        add_option('banner_click_count', 'true', 'radio', 'array("true", "false")');
        add_option('banner', '', 'readonly');
    }

    function banner_readonly()
    {
        _e('<center>'.add_button('main_page', 'banner_manager_page', 'Управление баннерами' ).'</center>'); 
    }
?>