<?php

    add_action('session_start', 'seller_session_start');

    add_action('main_page_admin', 'seller_page_list');

    //add_filter('news_product_add_tabs', 'seller_news_product_add_tabs');
    add_filter('param_filter_func', 'seller_param_filter', 1);
    add_filter('param_filter_array_func', 'seller_param_array_filter', 1);


    //вкладка параметров
    add_filter('param_add_tabs_func', 'seller_param_news_product_add_tabs', 1);  

    add_filter('param_add_tabs_array_func', 'seller_param_add_tabs_array_func', 1);

    add_action('insert_product', 'seller_param_insert_product');
    add_filter('products_listing', 'seller_products_listing');


    add_filter('news_product_add_tabs', 'seller_param_add_tabs');
    // видео
    add_filter('news_product_add_tabs', 'seller_param_add_tabs_video');
    //Схема проезда
    add_filter('news_product_add_tabs', 'seller_param_add_tabs_directions');
    //список продуктов
    add_filter('news_product_add_tabs', 'seller_param_add_tabs_products');

    add_action('products_info', 'seller_param_products_info');

    add_action('page_admin', 'seller_page');
    add_action('main_page_admin', 'seller_add_page');

    add_filter('categories_view_default_block', 'categories_view_default_block_func');

    add_action('multi_action', 'seller_multi_action');
    add_filter('param_to_extra_fields', 'param_to_extra_fields_func');

    add_action('page', 'seller_zone_page');
    add_action('page', 'seller_cur_page');

    add_action('page', 'seller_offers_page_products_info');

    add_action('main_page', 'seller_zone_select_page');
    add_action('main_page', 'seller_offers_page');

    add_filter('tpl_vars', 'seller_zone_filter');

    add_filter('param_filter', 'zone_id_param_filter');

    //импорт
    add_filter('import_page1', 'import_page1_func', 1);
    add_action('import_page2', 'import_page2_func', 1);
    add_action('import_page3', 'import_page3_func', 1);
    add_filter('import_page1_action', 'import_page1_action_func', 1);

    //меняем action 
    function import_page1_action_func($val)
    {
        $val = 'plugins_page.php?page=import_page2';
        return  $val;
    }

    function import_page2_func()
    {
        if ( isset($_POST['seller_id']) && $_POST['seller_id'] != 0)
        {
            $_SESSION['seller_id'] = (int)$_POST['seller_id'];
            os_redirect('plugins_page.php?page=import_page3');
        }
    }

    function import_page3_func()
    {
        /*$_POST['field'] = array();
        $_POST['field'][0] = 'num1';
        $_POST['field'][1] = 'num2';
        $_POST['field'][2] = 'num3';
        $_POST['field'][3] = 'num4';
        $_POST['field'][4] = 'num5';
        $_POST['field'][5] = 'num6';
        $_POST['field'][6] = 'num7';

        $_POST['field_1'] = array();
        $_POST['field_1'][0] = 'products_id';
        $_POST['field_1'][1] = 'products_model';
        $_POST['field_1'][2] = 'products_name';
        $_POST['field_1'][3] = 'products_price';
        $_POST['field_1'][3] = 'products_image';

        $_POST['field_1'] = 'products_image';
        $_POST['general'] = 'products_name';
        $_POST['action'] = 'seller';
        $_POST['file_name'] = $_SESSION['file_name'];
        $_POST['delimeter'] = ';';
        $_POST['charset'] = 'cp1251';
        $_POST['sub'] = '';

        */



    }


    function import_page1_func($val)
    {
        global $seller;

        if ( !is_object($seller)) 
        {
            include('seller.class.php');
            $seller = new seller();  
        } 


        $seller_array = array();
        $seller_array[] = array('text'=> 'Выбрать продавца', 'id'=>'0');

        if ( count($seller->seller) > 0 )
        {
            foreach ($seller->seller as $value)
            {
                if ( !empty( $value['products_name'] ) )
                {
                    $seller_array[] = array('text' => $value['products_name'], 'id' => $value['products_id']) ; 
                }
            }
        }

        $form =  os_draw_pull_down_menu('seller_id', $seller_array, $current_category_id, 'style="width:80%"');

        $val = '<tr>';
        $val .= '<td>';
        $val .= '<b><font color="red">Выбор продавца</font></b>';
        $val .= '</td>';        

        $val .= '<td>';
        $val .= $form;
        $val .= '</td>';

        $val .= '</tr>';

        return $val;    
    }

    function seller_session_start()
    {
        if ( isset($_GET['zone_id']) )
        {
            if ($_GET['page'] != 'seller_offers_page_products_info')
            {
                $_SESSION['zone_id'] = (int)$_GET['zone_id'];
                unset($_GET['zone_id']); 
            }

        }
    }

    function zone_id_param_filter($val)
    {
          if ( get_cat( array(21,29) ) == true )
          {
        $cat = $_GET['cat'];
        $zone_id = (int)$_GET['zone_id'];

        $jquery =  '<script type="text/javascript">
        $(document).ready(function(){

        $("#zone_id").change(

        function (){


        id = $("#zone_id option:selected").val();
        window.location.replace("index.php?cat='.$cat.'&zone_id="+id);
        }
        );

        });

        </script>';

        $val = $jquery.'&nbsp;Регион <span>'.os_draw_pull_down_menu('zone_id', get_zone_block('array'), @(int)$_SESSION['zone_id'], 'id="zone_id"').'</span>';
        }

        return $val;   
    }

    function get_zone($id)
    {
        return $id;
    }

    function seller_offers_page_products_info()
    {
        include('seller.offers.page.info.php');

    }

    if ( !function_exists('get_zone_block') ) 
    {
        include('seller.zone.php');
    }     

    function seller_param_news_product_add_tabs($val)
    {
        if ( get_cat( array(29,21) ) == false )
        {
            return  $val;
        }
    }

    function  seller_offers_page()
    {
        include('seller.offers.page.php');
    }
    //выбор валюты
    function seller_cur_page()
    {
        if ( isset($_GET['currencies_id']) )
        {
            $_SESSION['currency'] = $_GET['currencies_id'];
        }  
    }

    function seller_zone_filter($array)
    {
        global $zone;
        global $seller;

        if ( !is_object($seller)) 
        {
            include('seller.class.php');
            $seller = new seller();  
        } 

        if ( !function_exists('get_zone_block') ) 
        {
            include('seller.zone.php');
        } 

        if ( empty($zone) )
        {
            $zone =  get_zone_block('text');
            $array['zone'] = $zone;
        }
        else
        {
            $array['zone'] = $zone;
        }

        return $array;  
    } 

    // 0,0 - всяеларусь
    function seller_zone_page()
    {
        if ( isset($_GET['zone_id']) ) 
        {
            $_SESSION['zone_id'] = $_GET['zone_id']; 
        }

        echo get_zone_block('text');

        if ( !function_exists('get_zone_block') ) 
        {
            include('seller.zone.php');
        } 

    }

    //выбор региона для пользователя
    function seller_zone_select_page()
    {
        include('seller.zone.php');

        echo get_zone_block();
    }

    //не выводить параметры вместо доп. полей
    function param_to_extra_fields_func($v)
    {
        return false;
    }

    function seller_param_products_info()
    {
        global $param;
        global $info;
        global $seller;

        if ( !is_object($param)) $param = new param();

        if ( !is_object($seller)) 
        {
            include('seller.class.php');
            $seller = new seller();  
        }

        global $product;

        $product_id = $product->data['products_id'];

        $array = get_param_group($product_id);

        $param_label_array = $array['param_label_array'];
        $array = $array['param_array'];

        $value = array();
        if ( count($array) > 0 && isset($array[ $product_id ]) )
        {

            foreach ($array as $id => $_value)
            {
                if ( count($_value) > 0 )
                {
                    foreach ($_value as $group_id => $val)
                    {   
                        if ( !empty( $val['name_label']) )
                        {
                            $value[ $val['name_label'] ] = $val;

                            //$info->assign($val['name_label'], );
                        }
                        else
                        {
                            if ($group_id == 0) 
                            {

                                $info->assign('param', $val);
                            }
                            else
                            {
                                $info->assign('param_'.$group_id, $val);
                            }
                        }

                    }
                }
            }

        }

        if ( count($param_label_array) > 0 && isset( $param_label_array[ $product_id ]) )
        {        
            foreach ($param_label_array[ $product_id ] as $val)
            {           
                $info->assign($val['name_label'], $val['value']);
            }
        }

        $products_array = $seller->get_products( $product_id);

        if ( count( $products_array ) )
        {
            $val = array();

            foreach ($products_array as $value)
            {
                if ( !empty( $value['products_page_url'] ) )
                {
                    $url =  http_path('catalog').$value['products_page_url'];
                }
                else
                {
                    $url =  http_path('catalog').'product_info.php?products_id='.$value['products_id']; 
                }

                if ( !empty($value['products_name']) )
                {

                    $val[] = array(
                    'name' => $value['products_name'],
                    'url' => $url,
                    );
                } 
            } 

            $info->assign('products_array', $val);
            $info->assign('products_array_count', count( $products_array ));
        }
    }

    function seller_multi_action()
    {       

        global $category_cache;
        global $cat_array;
        global $seller;

        if ( isset($_POST['action_a']) && ($_POST['action_a'] == 'attach' or $_POST['action_a'] == 'detach' ) ) 
        {

            if (!is_object($seller)) 
            {
                include('seller.class.php');

                $seller = new seller();
            }

            $set = '';
            if ($_POST['action_a'] == 'attach') 
            {
                $set = 'add';
            }
            else
            {
                $set = 'remove';
            }

            global $heading;
            global $contents;
            global $db;

            $heading[]  = array('text' => '<b>Прикрепить товары к продавцу</b>');
            $contents[] = array('text' => '<table width="100%" border="0">');

            if ( !isset($_POST['seller_id']) or $_POST['seller_id'] == 0) 
            {
                $contents[] = array('text' => '<tr><td>Не выбран продавец для привязки<br /> <a href="javascript:history.back(1)">Назад</a></td></tr>'); 
            }   
            else
            {    
                if ( isset( $_POST['multi_categories'] ) && count($_POST['multi_categories']) > 0 )
                {
                    $__array = array();

                    foreach ($_POST['multi_categories'] as $id)
                    {
                        $cat_array[] = $id;
                        os_get_products_cat ($id);
                    } 

                    if ( count($cat_array)  > 0)
                    {
                        $where = implode(',', $cat_array);   
                        $i = 0;
                        $products_id = array();

                        $q = $db->query('select products_id from '.DB_PREFIX.'products_to_categories where categories_id in ('.$where.')');

                        while ( $_q = $db->fetch_array($q, false) )
                        {
                            $products_id[]  = $_q['products_id']; 
                        }

                        if ( !empty($set) )
                        {
                            if ($set == 'add')
                            {
                                $__id = $seller->add_products_seller( $products_id, $_POST['seller_id'] ) ;
                                $contents[] = array('text' => '<tr><td>Прикреплено '.$__id.' товаров из категорий <br /><a href="javascript:history.back(1)">Назад</a></td></tr>'); 
                            }
                            elseif ($set == 'remove') 
                            {
                                $__id = $seller->remove_products_seller( $products_id, $_POST['seller_id'] ) ;
                                $contents[] = array('text' => '<tr><td>Откреплено '.$__id.' товаров из категорий <br /><a href="javascript:history.back(1)">Назад</a></td></tr>'); 
                            }
                        }   
                    }



                }

                if ( isset($_POST['multi_products']) && count($_POST['multi_products']) > 0  )  
                {
                    if ( !empty($set) )
                    {
                        if ($set == 'add')
                        {
                            $__id = $seller->add_products_seller( $_POST['multi_products'], $_POST['seller_id'] ) ;
                            $contents[] = array('text' => '<tr><td>Прикреплено '.count($_POST['multi_products']).' товаров <br /><a href="javascript:history.back(1)">Назад</a></td></tr>'); 
                        }
                        elseif ($set == 'remove') 
                        {
                            $__id = $seller->remove_products_seller( $_POST['multi_products'], $_POST['seller_id'] ) ;
                            $contents[] = array('text' => '<tr><td>Откреплено '.count($_POST['multi_products']).' товаров <br /><a href="javascript:history.back(1)">Назад</a></td></tr>'); 
                        }
                    }   
                } 
            } 

            //$contents[] = array('text' => '<tr><td>нет товаров для привязки</td></tr>');


            $contents[] = array('text' => '</table>');
        }

    }

    function os_get_products_cat ($id)
    {
        global $category_cache;
        global $cat_array;

        foreach ($category_cache as $sub_id => $_id)
        {
            if ( $_id == $id )
            {
                $cat_array[] =  $sub_id; 
                os_get_products_cat ($sub_id);
            }
        }          

        //unset($cat_array);
        return $cat_array;
    }

    function categories_view_default_block_func($val)
    {     
        if ( get_cat( array(29, 21) ) == false )
        {

            if (!is_object($seller)) 
            {
                include('seller.class.php');

                $seller = new seller();   
            }

            $seller_array = array();
            $seller_array[] = array('text'=> 'Выбрать продавца', 'id'=>'0');

            if ( count($seller->seller) > 0 )
            {
                foreach ($seller->seller as $value)
                {
                    if ( !empty( $value['products_name'] ) )
                    {
                        $seller_array[] = array('text' => $value['products_name'], 'id' => $value['products_id']) ; 
                    }
                }
            }

            $form =  os_draw_pull_down_menu('seller_id', $seller_array, $current_category_id, 'style="width:80%"');
            $jquery =  '<script type="text/javascript">
            $(document).ready(function(){

            $("#seller_attach").click(
            function (){
            $("#action_a").val("attach");
            $("#multi_action_form").submit();
            }
            );

            $("#seller_detach").click(
            function (){
            $("#action_a").val("detach");
            $("#multi_action_form").submit();
            }
            );


            });

            </script>';

            $val = '<tr><td><hr style="border-color: #7B68EE;border-style: dotted;" /> </td></tr>';
            $val .= '<tr><td align="center">'.$form.'<input type="hidden" id="action_a" name="action_a" value="111"></td></tr>';
            $val .= '<tr><td align="center">'.$jquery.'<a class="button" id="seller_attach"><span>Прикрепить</span></a><br><a class="button" id="seller_detach"><span>Открепить</span></a></td></tr>';
            $val .= '<tr><td><hr style="border-color: #7B68EE;border-style: dotted;" /> </td></tr>';

        }
        return $val; 

    }

    ///список файлов
    function seller_page()
    {
        //echo '<form action="'.page_admin('seller_page').'">
        ///</form>';

        global $db;

        if (!is_object($seller)) 
        {
            include('seller.class.php');

            $seller = new seller();

        }

        if ($_GET['action'] == 'save' )

        {
            if ( count($_POST['seller_info']) > 0 )
            {
                foreach ($_POST['seller_info'] as $id => $value)
                {
                    $price = @$value['price'];
                    $desc = @$value['desc'];

                    $db->query('update '.DB_PREFIX.'seller set `price`="'.$db->input($price).'", `desc`="'.$db->input($desc).'" where seller_id='.(int)$_GET['product_id'].' and products_id='.$id);


                }

                /* $m = $db->query('select * from '.DB_PREFIX.'seller');
                while ($b = $db->fetch_array($m, false))
                {
                $price = rand(1,10000);
                $db->query('update '.DB_PREFIX.'seller set price='.$price.' where seller_id='.$b['seller_id'].' and  	products_id='.$b['products_id']);
                }	

                */		  
            }

        }


        if ( ($_GET['action'] =='remove') && isset($_GET['product_id']) )
        {
            $seller->products_remove($_GET['product_id'], $_GET['id']);
            echo '<font color="red"><b>Товар с id='.$_GET['id'].' успешно удален</b></font>';
        }   

        $pro =  $seller->get_products($_GET['product_id']);

        if ( count($pro) > 0 )
        {
            echo '<form method="post" action="plugins_page.php?page=seller_page&action=save&product_id='.$_GET['product_id'].'&category_id='.$_GET['category_id'].'">';
            echo '<input type="submit" value="Сохранить">';
            echo '<table>';  

            echo '<tr><td><b>Имя</b></td><td width="100px"><b>Цена</b></td><td><b>Примечание</b></td><td>&nbsp;</td></tr>';

            foreach ($pro as $value)
            {
                echo '<tr><td>'.$value['products_name'].'</td>
                <td ><input name="seller_info['.$value['products_id'].'][price]" value="'.$value['price'].'" type="text" style="width:80%;" /></td>';
                echo '<td ><input name="seller_info['.$value['products_id'].'][desc]" value="'.$value['desc'].'" type="text" style="width:80%;" /></td>' ;
                echo '<td>&nbsp;&nbsp;<a href="'.page_admin('seller_page').'&action=remove&id='.$value['products_id'].'&product_id='.(int)$_GET['product_id'].'"><font color="red">X</font></a></a></td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '<input type="submit" value="Сохранить">';
            echo '</form>';
        }

    }

    function seller_add_page()
    {
        //  include( dirname( __FILE__) .'/func/ru.php' );
        // include( dirname( __FILE__) .'/func/categories.php');
        include('seller.edit.php');
    }

    //видео
    function seller_param_add_tabs_video($value)
    {
        if ( get_cat( array(29, 21) ) == true )
        {
            global $param;

            $___value = $param->get_param_name( array('category_id' => 0) );

            $a = array();
            if ( count($___value) > 0  )
            {
                foreach ($___value as $v)
                {
                    if ( $v['name_value'] == 'Видео')
                    {

                        $a = $v;
                    }  
                }

            }


            global $db;
            $query = $db->query('SELECT p.product_id, pn.name_value, pv.value, pn.group_id
            FROM '.DB_PREFIX.'param p
            LEFT JOIN '.DB_PREFIX.'param_name pn ON ( p.name_id = pn.name_id ) 
            LEFT JOIN '.DB_PREFIX.'param_value pv ON ( p.value_id = pv.value_id ) 
            WHERE p.name_id='.$a['name_id'].' and p.product_id='.(int)$_GET['pID']);

            $q = $db->fetch_array($query, false); 

            $_val = @ $q['value'];

            $form = '<textarea style="width:80%; height:200px;" class="round" id="seller_param['.$a['name_id'].']" name="seller_param['.$a['name_id'].']">'.$_val.'</textarea>';
            $value['values'][] = array(
            'tab_name' => 'Видео', 
            'tab_content' => '<b>Вставить код видео</b><br>'.$form.'<br><a href="javascript:toggleHTMLEditor(\'seller_param['.$a['name_id'].']\');" class="code">Редактировать в визуальном HTML редакторе</a>' );

        }

        return $value;
    }    

    //схема проезда
    function seller_param_add_tabs_directions($value)
    {
        if ( get_cat( array(29, 21) ) == true )
        {


            global $param;

            $___value = $param->get_param_name( array('category_id' => 0) );

            $a = array();
            if ( count($___value) > 0  )
            {
                foreach ($___value as $v)
                {
                    if ( $v['name_value'] == 'Схема проезда')
                    {

                        $a = $v;
                    }  
                }

            }


            global $db;
            $query = $db->query('SELECT p.product_id, pn.name_value, pv.value, pn.group_id
            FROM '.DB_PREFIX.'param p
            LEFT JOIN '.DB_PREFIX.'param_name pn ON ( p.name_id = pn.name_id ) 
            LEFT JOIN '.DB_PREFIX.'param_value pv ON ( p.value_id = pv.value_id ) 
            WHERE p.name_id='.$a['name_id'].' and p.product_id='.(int)$_GET['pID']);

            $q = $db->fetch_array($query, false); 

            $_val = @ $q['value'];

            $form = '<textarea style="width:80%; height:200px;" class="round" id="seller_param['.$a['name_id'].']" name="seller_param['.$a['name_id'].']">'.$_val.'</textarea>';
            $value['values'][] = array(
            'tab_name' => 'Схема проезда', 
            'tab_content' => '<b>Схема проезда</b><br>'.$form.'<br><a href="javascript:toggleHTMLEditor(\'seller_param['.$a['name_id'].']\');" class="code">Редактировать в визуальном HTML редакторе</a>' );

        }

        return $value;
    }    

    //товары в каталоге
    function seller_param_add_tabs_products($value)
    {
        if ( get_cat( array(29) ) == true )
        {

            $frame = '<iframe width="1000" height="400px" name="content" src="plugins_page.php?page=seller_page&product_id='.$value['param']['products_id'].'&category_id='.$value['param']['category_id'].'" frameborder="0"></iframe>';

            $url = '';

            if ( isset($_GET['pID']) and isset($_GET['cPath']) )
            {
                $url = '<i>(<a target="_blank" href="plugins_page.php?page=seller_page&product_id='.(int)$_GET['pID'].'&category_id='.(int)$_GET['cPath'].'">редактор</a>)</i>';
            }

            $value['values'][] = array(
            'tab_name' => 'Товары в каталоге', 
            'tab_content' => '<b>Товары в каталоге</b> '.$url.'<br>'.$frame  );
        }

        return $value;
    }

    function get_reviews_count($products_id)
    {
        global $db;
        global $reviews_count;


        if ( empty($reviews_count)  )
        {

            $query = $db->query('SELECT reviews_id, products_id, count(*) as total FROM `'.DB_PREFIX.'reviews` group by products_id;');

            while ($q = $db->fetch_array($query, false) )
            {
                $reviews_count[ $q['products_id'] ] = $q;
            }

            if ( count( $reviews_count) == 0)   $reviews_count = 1;

        }

        if ($reviews_count == 1) 
        {
            return array();
        }
        else
        {
            return $reviews_count[ $products_id ];
        }
    }

    //фильтруем список параметров
    function seller_param_array_filter($value)
    {
        /*
        global $db;

        if ( count($value) > 0) 
        {
        $a = array();

        foreach ($value as $id => $__value)
        {

        if ( $__value['group_id'] == 2 )
        {
        $a[ $id ]  = $__value;
        }
        }

        }
        */
        $a = array();

        if ( get_cat( array(29,21) ) == false ) 
        {
            if ( count($value) > 0 )
            {

                foreach ($value as $val)
                {
                    if ($val['group_id'] == 0)
                    {
                        $a[] = $val;
                    }
                }
            }
        }

        return $a; 
    }

    function get_param_group($product_id = '')
    {
        global $db;
        global $param_array;
        global $param_label_array;
        global $cat_array;
        $cat_array = '';


        if ( empty($param_array)  )
        {
            $cat_array = '';

            if ( !empty($product_id) )
            {  
                $query = $db->query('SELECT p.product_id, pn.name_value, pn.name_label,  pv.value, pn.group_id
                FROM '.DB_PREFIX.'param p
                LEFT JOIN '.DB_PREFIX.'param_name pn ON ( p.name_id = pn.name_id ) 
                LEFT JOIN '.DB_PREFIX.'param_value pv ON ( p.value_id = pv.value_id ) 
                WHERE p.product_id='.$product_id.';');
            }
            else
            {
                $query = $db->query('SELECT p.product_id, pn.name_value, pn.name_label, pv.value, pn.group_id
                FROM '.DB_PREFIX.'param p
                LEFT JOIN '.DB_PREFIX.'param_name pn ON ( p.name_id = pn.name_id ) 
                LEFT JOIN '.DB_PREFIX.'param_value pv ON ( p.value_id = pv.value_id );');
            }

            while ($q = $db->fetch_array($query, false) )
            {
                if ( !empty($q['name_label']) )
                {
                    $param_label_array[ $q['product_id'] ][ $q['name_label'] ] =  $q ;
                }
                else
                {
                    unset( $m['name_label'] );
                    $param_array[ $q['product_id'] ][ (int)$q['group_id'] ][] = $q;
                } 
            }

            if ( count( $param_array) == 0 and count($param_label_array) ==0 )   $param_array = 1;

        }

        if ($param_array == 1) 
        {
            return array();
        }
        else
        {
            return array('param_array'=>$param_array, 'param_label_array' => $param_label_array);
        }
    }

    function seller_products_listing($value)
    {
        global $db;
        global $get_param_group;

        if ( empty($get_param_group) )
        {
            $array = get_param_group();  
            $get_param_group = $array;  
            if ( empty($get_param_group) ) $get_param_group = 1;
        }
        else
        {
            if ( $get_param_group == 1) 
            {
                $array  = array();
            }
            else
            {
                $array = $get_param_group; 
            }
        }

        
        $param_label_array = $array['param_label_array'];
        $array = $array['param_array'] ;

        //кол. отзывов
        $_count =  get_reviews_count( $value['PRODUCTS_ID']);
        $_count = (int)$_count['total'];
        $value['reviews_count'] = $_count;

        if ( count($array) > 0 && isset($array[ $value['PRODUCTS_ID'] ]) )
        {

            foreach ($array as $id => $_value)
            {
                if ( count($_value) > 0 )
                {
                    foreach ($_value as $group_id => $val)
                    {   
                        if ( !empty( $val['name_label']) )
                        {
                            $value[ $val['name_label'] ] = $val;
                        }
                        else
                        {
                            if ($group_id == 0) 
                            {
                                $value['param']  = $val;
                            }
                            else
                            {
                                $value['param_'.$group_id]  = $val;
                            }
                        }

                    }
                }
            }
        }
        
        if ( count($param_label_array) > 0 && isset( $param_label_array[ $value['PRODUCTS_ID'] ]) )
        {
            foreach ($param_label_array[ $value['PRODUCTS_ID'] ] as $_id =>$val)
            {
                $value[ $_id ] = $val['value'];

               /* foreach ($val as $__id => $__val)
                {
                    $value[ $__id ] = $__val['value'];
                }
                 */


            }
        }
        
        if ( get_cat( array(21,29) ) == false )
        {
            if ( $_SESSION['zone_id'] == 0)
            {
                $__count = $db->query('select count(*) as total from '.DB_PREFIX.'seller where products_id='.$value['PRODUCTS_ID']); 
                $__count = $db->fetch_array($__count, false);
                $__count =  @(int)$__count['total'];
                $count = $db->query('select * from '.DB_PREFIX.'seller where products_id='.$value['PRODUCTS_ID']);   
            }
            else
            {
                $__count = $db->query('select count(*) as total from '.DB_PREFIX.'seller where products_id='.$value['PRODUCTS_ID']); 
                $__count = $db->fetch_array($__count, false);
                $__count =  @(int)$__count['total'];

                // $count = $db->query('select * from '.DB_PREFIX.'seller where products_id='.$value['PRODUCTS_ID'].get_zone_id( (int)$_GET['zone_id'] )); 
                $count = $db->query('SELECT * FROM  `'.DB_PREFIX.'products_to_categories` pc
                left join `'.DB_PREFIX.'products_description` pd on (pc.products_id=pd.products_id) 
                left join `'.DB_PREFIX.'seller` s on (s.seller_id=pd.products_id)
                left join `'.DB_PREFIX.'products` p on (p.products_id=pd.products_id) WHERE s.products_id='.$value['PRODUCTS_ID'].'  '.get_zone_id( (int)$_SESSION['zone_id'], 'and p.zone_id in' ).';');  
            
            }


            $coun = 0;
            $sum = 0;
            $min = 0;
            $max = 0;
            $_seller = array();
            $mcount = 0;

            while ($_count = $db->fetch_array($count, false) )
            {
                $_seller[] = $_count['seller_id'];

                $price = (int)$_count['price'];

                if ($coun == 0) 
                {
                    $min = $price;
                    $max = $price;
                }
                else
                {
                    if ($min > $price and $price != 0 ) $min = $price;
                    if ($max < $price) $max = $price;
                }

                if ( $price != 0 )
                {
                    $sum += $_count['price'];
                    $mcount++;
                }

                $coun++;
            }


            global $osPrice;
            if ( $mcount != 0)
            { 
                $sum = round($sum / $mcount);
            }

            $coun = count($_seller);
            $coun_c = $coun; 


            if ($coun == 1) $coun .= ' продавец'; 

            elseif ($coun >=2 and $coun <= 4) 
            {
                $coun .= ' продавца';
            }
            else  $coun .= ' продавцов';

            $value['PRODUCTS_PRICE_COUNT_ALL'] = $__count;
            $value['PRODUCTS_PRICE_COUNT'] =  $coun; 
            $value['PRODUCTS_PRICE_COUNT_P'] =  $coun_c ;
            $value['PRODUCTS_PRICE_MAX'] = $osPrice->Format($max*$osPrice->currencies[ $_SESSION['currency'] ]['value'], true);
            $value['PRODUCTS_PRICE_MIN'] = $osPrice->Format($min*$osPrice->currencies[ $_SESSION['currency'] ]['value'], true);
            $value['PRODUCTS_PRICE_S'] = $osPrice->Format($sum*$osPrice->currencies[ $_SESSION['currency'] ]['value'], true);
            $value['PRODUCTS_PRICE_S_P'] = $sum*$osPrice->currencies[ $_SESSION['currency'] ]['value'];

        } 
        

        return $value;    
    }

    function seller_param_add_tabs($____value)
    {
        global $param;

        $value = $param->get_param_name( array('category_id' => 29) );


        // print_r($value);
        $array_name_id_value  = array();

        if ( isset($_GET['pID']) ) 
        {


            $param_array = $param->get_param_id ( $_GET['pID']) ;

            if ( count($param_array) > 0 )
            {
                foreach ($param_array as $_value)
                {
                    $value_id_array[] = $_value['value_id'];
                    $array_name_id_value[ $_value['name_id'] ] = $_value['value_id'];
                    $param_value_group[  $_value['value_id'] ] = $_value['value']; 
                }
            }

            //$param_value_group = $param->get_param_group_value ($value_id_array);
        }



        $val = array();

        if ( count($value) > 0 )
        {        
            $form .= '<table border="0">';
            foreach ($value as $v)
            {    
                if ( $v['group_id'] == 1 )
                {
                    $val[] = $v; 

                    if ( isset($array_name_id_value[ $v['name_id'] ]) )
                    {

                        $form .= '<tr><td>'.$v['name_value'].'</td><td><input name="seller_param['.$v['name_id'].']" type="text" value="'.$param_value_group[ $array_name_id_value[  $v['name_id']  ] ].'"></td>'; 
                    }
                    else
                    {
                        $form .= '<tr><td>'.$v['name_value'].'</td><td><input name="seller_param['.$v['name_id'].']" type="text" value=""></td>'; 

                    }

                }
            }

            $form .= '</table>';
        }    






        global $category_cache;

        $current_cat = (int)$_GET['cPath'];

        $_array_cat = array(0);

        while ($current_cat != 0)
        {
            $_array_cat[] = $current_cat;
            $current_cat = $category_cache[$current_cat];
        }

        if ( count( $_array_cat) > 1 )
        {
            $level =  $_array_cat[ count( $_array_cat) - 1 ];  
        }

        $value['tab_name'] = 'Регион';

        if ( $level == 21 or $level == 29)
        {      
            $____value['values'][] = array(
            'tab_name' => 'Контакты', 
            'tab_content' => '<b>Контактные данные</b><br>'.$form );
        }


        return $____value;  

    }

    function seller_param_insert_product()
    {
        global $param;
        global $product_id;
        global $db;
        if ( !is_object($param)) $param = new param();

        //сохраняем параметры
        if ( isset($_POST['seller_param']) )
        {
            $name_id_array  = array();

            foreach ($_POST['seller_param'] as $name_id => $value)
            {
                $name_id_array [] = $name_id;
            }

            $name_array =  $param->get_param_name_group($name_id_array, $product_id);

            foreach ($_POST['seller_param'] as $name_id => $value)
            {

                if ( !empty($value) )
                {
                    $value_id = $param->is_param_value($value, $name_id);
                    if ( $value_id == 0 )
                    {     
                        $value_id = $param->add_param_value($name_id, $value);
                    }
                }
                else
                {
                    $value_id = 0;
                }

                $array_param[] = array(
                'name_id'=> $name_id,
                'value_id'=> $value_id,
                'product_id'=> @(int) $_POST['product_id'],
                'category_id'=> @(int) $_POST['category_id']
                );



            }

            $param->save_param($array_param);
        }

    }

    //фильтруем вывод параметров
    function seller_param_filter($value)
    {
        //if ( $_GET['cat'] == '29' or $_GET['cat'] == '21' )
        //  {
        return $value;
        //}
    }

    function seller_param_add_tabs_array_func($value)
    {
        $a = array();


        if ( count($value) > 0 )
        {


            foreach ($value as $val)
            {

                if ($val['group_id'] == 0)
                {
                    $a[] = $val;
                }
            }
        }


        return $a;
    }

    //
    function get_cat( $id )
    {
        global $category_cache;

        $current_cat = (int)$_GET['cPath'];

        $_array_cat = array(0);

        while ($current_cat != 0)
        {
            $_array_cat[] = $current_cat;
            $current_cat = $category_cache[$current_cat];
        }

        if ( count( $_array_cat) > 1 )
        {
            $level =  $_array_cat[ count( $_array_cat) - 1 ];  
        }

        if ( is_array($id) && count($id) > 0)
        {
            foreach ($id as $cat_id)
            {
                if ($level == $cat_id)
                {
                    return true;
                }
            }
        }

        return false;
    }

    function seller_install()
    {
        global $db;

        //создаем таблицу. для связки продавец - товар.
        $db->query('drop table if exists '.DB_PREFIX.'seller;');

        $db->query("CREATE TABLE `".DB_PREFIX."seller` (
        `seller_id` int(11) NOT NULL default '0',
        `products_id` int(11) NOT NULL default '0',
        PRIMARY KEY  (`products_id`, `seller_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");

        add_option('seller', '', 'readonly');
    }

    function seller_readonly()
    {
        _e('<a href="'.main_page_admin('seller_page_list').'">Список заказчиков</a><br>');
        _e('<a href="'.main_page_admin('seller_add_page').'">Листинг категорий</a>');
    }

    function seller_remove()
    {     
        global $db;
        $db->query('drop table if exists '.DB_PREFIX.'seller;');
    }

    function seller_page_list()
    {
        include('seller.class.php');

        $seller = new seller();


        if ( count($seller->seller) > 0 )
        {
            foreach ($seller->seller as $value)
            {
                if (!empty( $value['products_name'] ))
                {
                    echo  '<b>'.$value['products_name'].'</b> <i>('.$seller->seller_products_count[ $value ['products_id']].')</i><br />';
                }
            }
        }
        // print_r($seller->seller);
    }
?>