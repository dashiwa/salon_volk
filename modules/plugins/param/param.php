<?php
    /*
    Plugin Name: Параметры товаров
    Plugin URI: http://www.shopos.ru/plugins/
    Description: Добавляет параметры товаров
    Version: 1.4
    Author: Матецкий Евгений
    Author URI: http://www.shopos.ru/
    */

    global $p;
    $plug_array = $p->info;

    if ( isset($plug_array['param']) && $plug_array['param']['status'] == 1 )
    {
        define('BOX_PARAMETERS_PLUG','Параметры');
        define('BOX_PARAMETERS_OPTIONS_PLUG','Варианты параметра');
        define('BOX_PARAMETERS_TOOLS_PLUG','Инструменты');
    }
    //  add_action('body', 'param_body');
    add_action('box', 'param_box');

    add_action('breadcrumb_trail', 'param_breadcrumb_trail');
    //страница добавления параметров категории
    add_action('main_page_admin', 'param_add');    

    //магазин. резальтат поиска по параметрам
    add_action('main_page', 'param_find');

    //сохраняем параметры при вставке товара
    add_action('insert_product', 'param_insert_product');

    //удаляем параметры при удалении товара
    add_action('delete_product', 'param_remove_product');

    //удаляем параметры при удалении катеогории
    add_action('remove_category', 'param_remove_category');

    add_filter('param_filter', 'param_filter_func');
    //
    add_action('page_admin', 'param_product');

    //добавление дополнителных полей на страницу товара
    add_action('products_info', 'param_products_info');

    //страница редактирования вариантов параметров
    add_action('main_page_admin', 'param_options');    

    //страница копирования дополнительных полей в параметры
    add_action('main_page_admin', 'param_generator');   

    //страница копирования атрибутов товаров в параметры 
    add_action('main_page_admin', 'param_generator_option');    

    //страница tools
    add_action('main_page_admin', 'param_tools');

    //добавляем таб с параметрами при добавлении-редактировании товара
    add_filter('news_product_add_tabs', 'param_news_product_add_tabs');

    //добавляем таб с параметрами при добавлении-редактировании категорий
    //  add_filter('news_category_add_tabs', 'param_news_category_add_tabs');

    //подключаем класс param
    include ( dirname(__FILE__) . '/param.class.php');
    //подключаем функции 
    include ( dirname(__FILE__) . '/param.func.php');

    //установка плагина
    function param_install()
    { 
        $param = new param();
        $param->install();
        add_option('param', '', 'readonly');
    }

    //удалить все данные о парметрах
    function param_remove()
    {
        global $db;

        $db->query('drop table if exists '.DB_PREFIX.'param;');
        $db->query('drop table if exists '.DB_PREFIX.'param_name;');      
        $db->query('drop table if exists '.DB_PREFIX.'param_value;');            
    }

    function param_body()
    {
        $param = new param();
        include( dirname(__FILE__) . '/param.page.php');
    }

    //страница добавления параметров для категории
    function param_options()
    {
        $param = new param();
        include( dirname(__FILE__) . '/param.page.options.php');
    }    

    //страница редактирования вариантов параметров
    function param_add()
    {
        $param = new param();
        include( dirname(__FILE__) . '/param.page.add.php');
    }

    //страница копирования доп. полей в параметры
    function param_generator()
    {
        $param = new param();
        include( dirname(__FILE__) . '/param.page.convert.php');
    }    

    //страница копирования доп. полей в параметры
    function param_tools()
    {
        $param = new param();
        include( dirname(__FILE__) . '/param.page.tools.php');
    }

    //добавление блока поиска по параметрам
    function param_box()
    {
        include( dirname(__FILE__) . '/param.box.find.php');

        return array('title' => $title, 'content' => $content);
    }

    function param_readonly()
    {
        _e('<center>'.add_button('main_page', 'param_add', 'Параметры для категорий' ).'</center>');
        _e('<center>'.add_button('main_page', 'param_options', 'Варианты параметров' ).'</center>');
        _e('<center>'.add_button('main_page', 'param_tools', 'Инструменты' ).'</center>');
    }

    //добавление таба параметры в редактор товаров
    function param_news_product_add_tabs($array)
    { 
        global $param;
        if ( !is_object($param)) $param = new param();

        if ( isset($_GET['pID']) )
        {
            $frame = '<iframe width="1000" height="400px" name="content" src="plugins_page.php?page=param_product&product_id='.$array['param']['products_id'].'&category_id='.$array['param']['category_id'].'" frameborder="0"></iframe>';
            $a = apply_filter( 'param_add_tabs_func', array(
            'tab_name' => 'Параметры', 
            'tab_content' => $frame ));

            if (!empty($a)) $array['values'][] = $a; 
        }
        else
        {
            $a = apply_filter( 'param_add_tabs_func', array(
            'tab_name' => 'Параметры', 
            'tab_content' => $param->form_product_edit( $_GET['cPath']) ));

            if (!empty($a)) $array['values'][] = $a; 
        }

        return $array;
    }

    function param_news_category_add_tabs($array)
    {
        global $param;
        if ( !is_object($param)) $param = new param();

        $array['values'][] =  array(
        'tab_name' => 'Параметры', 
        'tab_content' => '<b>Редактор параметров:</b> ');



        return $array;
    }

    //вывод параметров на странице карточки товаров
    function param_products_info ()
    {
        $val = true;
        if ( apply_filter('param_to_extra_fields', $val) == false ) return false;
        
        global $param;
        if ( !is_object($param)) $param = new param();

        global $product;

        $product_id = $product->data['products_id'];

        $value = $param->get_param_id ($product_id );

        if ( count ($value) > 0)
        {

            foreach ($value as $num => $val)
            {
                //не показываются параметры с пустями значениями
                if ( !empty( $val['value']) )
                {
                    $extra_fields_data[] = array (
                    'NAME' => $val['name_value'], 
                    'VALUE' => $val['value']
                    );
                }

            }

            return array('name' => 'extra_fields_data', 'value' => $extra_fields_data);
        }
        else
        {
            return false;
        }


    }

    //страница с результатом поиска по параметрам
    function param_find()
    {
        if (isset($_GET['param']) && count($_GET['param']) > 0 )
        {
            global $param;
            if ( !is_object($param)) $param = new param();

            global $param_where ;
            global $param_join;

            $_where_filter =  get_where_param_filter_box();

            if ( !empty($_where_filter) )
            {

                $param_join = "left join 
                (
                select p3.product_id, count(*) as param_count from os_param p3 where ".$_where_filter['where']." group by p3.product_id

                ) t
                ON t.product_id = p.products_id";


                $param_select = '';
                $param_heving  = '';
                $param_where = 'param_count ='.($_where_filter['count']);
                $param_where .=' and';

                include( dirname(__FILE__) .'/param.page.find.php' );
            }
            else
            {
                echo '<b>Укажите хотябы один параметр для поиска товаров.</b>';
            }

        }
        else
        {
            echo 'Не заданы параметры для поиска.'; 
        }

    }

    //редактор параметров товара
    function param_product()
    {
        global $param;
        if ( !is_object($param)) $param = new param();

        echo '<html>';
        echo '<body>';

        //сохраняем параметры
        if ( isset($_POST['param']) )
        {
            foreach ($_POST['param'] as $name_id => $value_id)
            {
                $array_param[] = array(
                'name_id'=> $name_id,
                'value_id'=> $value_id,
                'product_id'=> @ $_POST['product_id'],
                'category_id'=> @ $_POST['category_id']
                );
            }


            if ( $param->save_param($array_param ) )
            {
                echo '<font color="green"><b>Сохранено</b></font>';
            } 
            else
            {
                echo '<font color="red"><b>Не сохранено</b></font>';
            }


        }

        echo $param->form_product_edit($_GET['category_id'], array('type'=>'frame') );

        echo '</body>';
        echo '</html>';
    }

    //сохраняем параметры при сохранении товара
    function param_insert_product()
    {
        global $param;
        if ( !is_object($param)) $param = new param();

        //сохраняем параметры
        if ( isset($_POST['param']) )
        {
            foreach ($_POST['param'] as $name_id => $value_id)
            {
                $array_param[] = array(
                'name_id'=> $name_id,
                'value_id'=> $value_id,
                'product_id'=> @ $_POST['product_id'],
                'category_id'=> @ $_POST['category_id']
                );
            }

            //сохраняем
            $param->save_param($array_param);
        }
    }

    //добавляем фильтры в категории
    function param_filter_func()
    { 
        global $param;
        if ( !is_object($param)) $param = new param();

        return apply_filter('param_filter_func', $param->form_cat_filter($_GET['cat']) );
    }

    //возвращает часть запроса для фильтра товаров
    function get_where_param_filter()
    {
        global $param;
        if ( !is_object($param)) $param = new param();

        return $param->get_filter_string( $_POST['param_filter'] );
    }

    //возвращает часть запроса для фильтра товаров
    function get_where_param_filter_box()
    {
        global $param;
        if ( !is_object($param)) $param = new param();

        return $param->get_filter_string( $_GET['param'] );
    }

    //удаляем параметры при удалении товаров
    function param_remove_product()
    {
        global $products_id;

        global $param;
        if ( !is_object($param)) $param = new param();

        $param->remove_param($products_id);
    }

    //удаляем параметры и варинатты параметров
    function param_remove_category()
    {
        global $categories_id;

        global $param;
        if ( !is_object($param)) $param = new param();

        $param->remove_param_name_cat($categories_id);
    }

    function param_generator_option()
    {
        global $param;
        if ( !is_object($param)) $param = new param();

        include( dirname(__FILE__) . '/param.page.convert.option.php');
    }

    //добавляем хлебную крошку при поиске
    if (isset($_GET['main_page']) && $_GET['main_page'] == 'param_find')
    {
        function param_breadcrumb_trail()
        {
            global $breadcrumb;
            $breadcrumb->add('Поиск по параметрам', http_path('catalog').'index.php?'.$_SERVER['QUERY_STRING']);
        }
    }

?>