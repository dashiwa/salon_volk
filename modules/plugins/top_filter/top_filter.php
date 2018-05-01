<?php
/*
    Plugin Name: top filter
    Version: 1.5
    Author: Матецкий Евгений
    Author URI: http://www.shopos.ru/
    Description: Если выбран вариант показа по метке {$top_filter} - нужно добавить эту метку в шаблон themes/ваш_шаблон/index.html
*/

    add_filter('main_content', 'main_content_filter');

    add_action('box', 'box_top_filter');
    global $box_top_filter;

    function box_top_filter()
    {
        global $osTemplate;
        global $box_top_filter;

        ob_start();
        include_once( plugdir(). 'categories.php');
        $box_top_filter = ob_get_contents();
        ob_end_clean();

        if ( get_option('top_filter_output') == 'top_filter_output_box')
        {
            $osTemplate->assign('top_filter', $box_top_filter);
        }
    }

    function main_content_filter($_cont)
    {
        global $box_top_filter;
        if ( get_option('top_filter_output') == 'top_filter_output_filter')
        {
            return $box_top_filter.$_cont ;
        }
        else
        {
            return $_cont ;
        }
    }


    function top_filter_install()
    {
        include(dirname(__FILE__).'/config.php');

        add_option('top_filter_cat', 'top_filter_cat_true', 'checkbox', "array('top_filter_cat_true', 'top_filter_cat_false')");

        add_option('top_filter_output', 'top_filter_output_filter', 'checkbox', "array('top_filter_output_filter', 'top_filter_output_box')");



        //стили
        add_option('top_filter_style', $top_filter_style, 'textarea');

        //разделитель между блоком категорий и блоком main_content
        add_option('top_filter_hr_check', 'top_filter_hr_check_true', 'radio', "array('top_filter_hr_check_true', 'top_filter_hr_check_false')");
        //разделитель между блоком категорий и блоком main_content
        add_option('top_filter_hr', $top_filter_hr);

    }
?>