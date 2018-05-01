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

    //класс для работы с параметрами для категорий и товаров
    class param extends db 
    {
        //типы полей параметров
        var  $type_array = array();
        //реверс $type_array 
        var  $type_array_reverse = array();

        //    
        function param ()
        {
            $this->type_array = array('text' => 0, 'select' => 1, 'radio' => 2, 'checkbox'=>3, 'boolean' => 4);
            $this->type_array_reverse = array('text', 'select', 'radio', 'checkbox', 'boolean' );

        }

        //устанавливаем класс
        function install()
        {
            $this->query('drop table if exists '.DB_PREFIX.'param');      

            $this->query("CREATE TABLE ".DB_PREFIX."param (
            param_id int NOT NULL auto_increment,
            product_id int NOT NULL,
            name_id int NOT NULL,
            sort_order int NOT NULL,
            group_id int NOT NULL,
            group_type varchar(255) NOT NULL default '',
            group_value varchar(255) NOT NULL default '',
            value_id int NOT NULL,
            PRIMARY KEY (param_id),
            KEY `product_id` (`product_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");

            $this->query('drop table if exists '.DB_PREFIX.'param_name');      

            //type id 1= text; 2-chaeck
            /*
            category_id  - id категории
            type_id  - тип поля. от 0 до 4ех
            name_value - имя параметра
            value_id - id значения параметра по умолчанию из вариантов param_value
            sort_order - сортировка полей
            name_alt - описание поля
            status - статус параметра
            */

            $this->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."param_name` (
            `name_id` int(11) NOT NULL auto_increment,
            `category_id` int(11) NOT NULL,
            `type_id` int(11) NOT NULL,
            `name_value` varchar(255) NOT NULL default '',
            `name_label` varchar(255) NOT NULL default '',
            `value_id` int(11) NOT NULL, 
            `group_id` int(11) NOT NULL default 0, 
            `sort_order` int NOT NULL,
            `name_alt` varchar(255) NOT NULL default '',
            `status` int(1) NOT NULL default '1',
            PRIMARY KEY  (`name_id`),
            KEY `name_value` (`name_value`),
            KEY `category_id` (`category_id`),
            KEY `status` (`status`)   
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");

            $this->query('drop table if exists '.DB_PREFIX.'param_value');      

            //варианты параметров
            $this->query("CREATE TABLE ".DB_PREFIX."param_value (
            value_id int NOT NULL auto_increment,
            name_id int NOT NULL,
            value varchar(255) NOT NULL default '',
            PRIMARY KEY (value_id),
            KEY `param_id` (`name_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");

            //установить тестовую базу параметров
            // $this->create_test_base(); 
        }

        //добавить вариант параметра
        function add_param_value ($name_id, $value)
        {
            $array =  array('name_id' => (int)$name_id,
            'value' => $value
            );

            if (!empty($value))
            {
                $this->perform (DB_PREFIX.'param_value', $array)   ;

                return  $this->insert_id();
            }
            else
            {
                return 0;
            }
        }

        //позвращает параметры по id категории
        function get_parambyCatId ($catid = 0)
        {
            $query =  $this->query('select * from '.DB_PREFIX.'param_name' );

            while ($param = $this->fetch_array($query, false) )
            {
                $params[ $param['name_id'] ] = $param['name_value'];
                $select_param []  = $param['name_id'];
            }

            $select_param = implode(',', $select_param);

            //print_r($select_param);

            $query =  $this->query('select * from '.DB_PREFIX.'param_value where param_id in ('.$select_param.')' );

            while ($param2 = $this->fetch_array($query,false) )
            {
                $params2 [ $param2['param_id'] ] [  $param2['value_id'] ]  =  $param2['value'];
            }

            //   print_r($params2); 
            //foreach ()

            //print_r($params);

            return array('name'=> $params, 'value' =>$params2 );
        }

        function find_form($cat_id = 0)
        {
            $form = '<form>';
            print_r($this->get_parambyCatId () );

            $form .= '</form>';


            return $form;
        }

        //наполнение базы тестовыми данными
        function create_test_base()
        {
            include( dirname(__FILE__). '/param.test.base.php'  );
        }

        //возвращает параметры товара по id товара
        function get_param_id ($product_id)
        {
            if (!empty($product_id))
            {
                $query = $this->query('select * from '.DB_PREFIX.'param p left join '.DB_PREFIX.'param_name pn on (pn.name_id = p.name_id) left join '.DB_PREFIX.'param_value pv on (pv.value_id = p.value_id) where product_id='.$product_id.' order by p.sort_order'); 

                while ( $_param = $this->fetch_array($query, false) )
                {
                    $params[ $_param['param_id'] ] =  $_param;
                }

                return  $params;
            }
            else
            {
                return false;
            }
        }

        //добавление параметра
        function add_param ($param)
        {
            $this->perform (DB_PREFIX.'param', $param)   ;

        }

        /*
        $name - имя параметра
        $cat_id - id категории к которой относится параметр
        $type - тип параметра
        0 - text
        1 - select
        2 - radio
        3 - checkbox
        4 - boolean (true | false) 

        $default_value
        */
        function add_param_name($name, $cat_id = 0,  $type = '0', $default_value = '')
        {

            $name = $this-> input($name) ;

            if (!empty($name))
            {
                $this->query('insert into '.DB_PREFIX.'param_name (name_value, category_id, type_id) values ("'.$name.'", "'.$cat_id.'", "'.(int)$type.'")');

                $name_id = $this->insert_id();

                if (!empty($default_value))
                {
                    //добавляем вариант параметра, если есть
                    $value_id = $this->add_param_value ($name_id, $default_value);

                    //изменяем поле по умоланию в параметре на только что добавленное
                    $this->query('update '.DB_PREFIX.'param_name set value_id='.$value_id.' where name_id='.$name_id);

                }
            }

            //  name_id     category_id     type_id     name_value     value_id     name_alt
        }

        //проверка. есть ли вариант параметра с данными значением
        function is_param_value($value, $name_id=0)
        {
            if ( !empty( $value))
            {
                $value = $this->input($value);

                if ($name_id == 0)
                { 
                    $_query = $this->query('select value_id from '.DB_PREFIX.'param_value where value="'.$value.'"');
                }
                else
                {
                    $name_id = (int)$name_id; 
                    $_query = $this->query('select value_id from '.DB_PREFIX.'param_value where name_id="'.$name_id.'" and value="'.$value.'"'); 
                }

                if ( mysql_num_rows ($_query) > 0) 
                {
                    $p = $this->fetch_array($_query, false);
                    //echo '<b>'.$p['value_id'].'</b><br>';
                    return $p['value_id'];
                }
                else 
                {

                    return 0; 
                }
            }
            else
            {
                return 0;
            }

        }

        //проверяет. есть ли параметр с заданными критериями
        function is_param ($value)
        {
            if ( count($value) > 0 )
            {
                $where = '';
                foreach ($value as $key => $name)
                {
                    if ( empty($where) )
                    {
                        $where = $key.'="'.$name.'"';
                    } 
                    else
                    {
                        $where .= ' and '.$key.'="'.$name.'"';
                    }
                }

                $_query = $this->query('select param_id from '.DB_PREFIX.'param where '.$where);

                if ( mysql_num_rows ($_query) > 0) 
                {
                    $p = $this->fetch_array($_query, false);

                    return $p['param_id'];
                }
                else 
                {
                    return 0; 
                }
            }
            else
            {
                return 0;
            }
        }

        //удаляем параметр по id товара
        function remove_param($product_id )
        {
            $product_id  = (int)$product_id;
            $this->query('delete from '.DB_PREFIX.'param where product_id = '.$product_id);
        }       

        //удаляем параметр
        function remove_param_name($name_id )
        {
            $name_id  = (int)$name_id;
            $this->query('delete from '.DB_PREFIX.'param_name where name_id = '.$name_id);

        }   

        //удаляем параметры и варианты параметров по id категории
        function remove_param_name_cat($category_id)
        {
            if ($category_id != 0)
            {
                $array = $this->get_param_name ( array('category_id'=>$category_id) );

                if ( count($array) > 0 )
                {
                    foreach ($array as $value)
                    {
                        //print_r($value);
                        $name_id = $value['name_id'];
                        $this->remove_param_name( $name_id );
                        $this->remove_param_value_nameid( $name_id );
                    }
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }     

        //удаляем вариант параметра
        function remove_param_value($value_id )
        {
            $value_id  = (int)$value_id;
            $_query = $this->query('delete from '.DB_PREFIX.'param_value where value_id = '.$value_id);

            return $this->affected_rows();
        }

        //удаляем вариант параметра по name_id
        function remove_param_value_nameid($name_id )
        {
            $name_id  = (int)$name_id;
            $_query = $this->query('delete from '.DB_PREFIX.'param_value where name_id = '.$name_id);

            return $this->affected_rows();
        }

        //удалить все параметры и варианты параметров
        function remove_param_all()
        {
            $this->query('TRUNCATE '.DB_PREFIX.'param;');
            $this->query('TRUNCATE '.DB_PREFIX.'param_name;');
            $this->query('TRUNCATE '.DB_PREFIX.'param_value;');
        }

        function get_param_name( $param = array() )
        {      
            $where = '';
            $value_id = array();
            $params = array();
            //если есть  category_id - фильтруем параметры по category_id
            if ( isset($param['category_id']) )  $where = ' where category_id='.$param['category_id'];

            $query = $this->query('select * from '.DB_PREFIX.'param_name'.$where);   

            while ( $_param = $this->fetch_array($query, false) )
            {
                $params[ ] =  $_param;

                if ($_param['value_id'] != 0)
                {
                    $value_id [] = $_param['value_id'];
                }
            }

            if ( count($value_id) > 0)
            {
                $param_value_array = $this->get_param_name_default($value_id);

                //добавляем поле value_default
                foreach ($params as $num => $value)
                {
                    if (isset( $param_value_array [ $value['value_id'] ] ))
                    {
                        $params[$num]['value_default'] = $param_value_array [ $value['value_id'] ];
                    }
                }
            }


            //            print_r($param_value_array);

            return  $params;
        }

        /*

        array( name_id1, name_id2, name_id3, ...); 
        */
        function get_param_value_group($array)
        {
            if ( count ($array) > 0 )
            { 
                $where = implode (',', $array);

                //  print_r($where);
                $_query = $this->query('select name_id, value, value_id from '.DB_PREFIX.'param_value where name_id in ('.$where.') order by value');

                $name_value = array();

                while( $query = $this->fetch_array($_query, false)  ) 
                {
                    if (!isset( $name_value[ $query['name_id'] ][0] ) )
                    {
                        $name_value[ $query['name_id'] ][0] = array('text' => 'Не важно', 'id' => 0);
                    }
                    $name_value[ $query['name_id'] ][]  = array(  'text' => $query['value'], 'id' => $query['value_id'] );
                }  

                return $name_value;
            }
            else
            {
                return false;
            }
        }        

        
        /*

        array( name_id1, name_id2, name_id3, ...); 
        */
        function get_param_name_group($array, $product_id)
        {
            if ( count ($array) > 0 )
            { 
                $where = implode (',', $array);

                //  print_r($where);
                $_query = $this->query('select * from '.DB_PREFIX.'param  where name_id in ('.$where.')');

                $name_value = array();

                while( $query = $this->fetch_array($_query, false)  ) 
                {
                        $name_value[ $query['name_id'] ] =  $query;
                }  

                return $name_value;
            }
            else
            {
                return false;
            }
        }        

        /*
        input 
        value id array
        output
        return array( value_id => value )
        */
        function get_param_group_value($array)
        {
            if ( count ($array) > 0 )
            { 
                $where = implode (',', $array);

                //  print_r($where);
                $_query = $this->query('select name_id, value, value_id from '.DB_PREFIX.'param_value where value_id in ('.$where.') order by value');

                $name_value = array();

                while( $query = $this->fetch_array($_query, false)  ) 
                {

                    $name_value[ $query['value_id'] ] = $query['value'];

                }  

                return $name_value;
            }
            else
            {
                return false;
            }
        }


        function get_product_array($array)
        {
            if (count($array) > 0)
            {
                //если один параметр
                if ( count($array) == 1 )
                {
                    foreach ($array as $name_id => $value_id)
                    {
                        $where = 'name_id='.$name_id.' and value_id='.$value_id;
                    }
                }
                //если 2 и больше
                else
                {

                    $sql_param_array = array();

                    foreach ($array as $name_id => $value_id)
                    {
                        $sql_param_array[] = '(name_id='.$name_id.' and value_id='.$value_id.')';
                    }

                    $where  = implode(' and ', $sql_param_array );


                }

                $_query = $this->query('select product_id from '.DB_PREFIX.'param where '.$where);

                if ( mysql_num_rows ($_query) > 0) 
                {
                    $data_array = array();

                    while ($data = $this->fetch_array($_query, false) )
                    {
                        $data_array[] =  $data['product_id'];
                    }

                    return $data_array;
                }
                else 
                {
                    return 0; 
                }

            }
            else
            {
                return 0;
            }

        }

        function get_filter_string($array)
        {
            if ( count($array) > 0 ) 
            {
                $param_filter = array();

                foreach ($array as $num => $value)
                {
                    if ( $value != 0) $param_filter[$num]  =$value;
                }
            }  

            $array = $param_filter;

            if (count($array) > 0)
            {
                //если один параметр
                if ( count($array) == 1 )
                {
                    foreach ($array as $name_id => $value_id)
                    {
                        $where = 'p3.name_id='.$name_id.' and p3.value_id='.$value_id;
                    }
                }
                //если 2 и больше
                else
                {

                    $sql_param_array = array();

                    foreach ($array as $name_id => $value_id)
                    {
                        $sql_param_array[] = '(p3.name_id='.$name_id.' and p3.value_id='.$value_id.')';
                    }

                    $where  = implode(' or ', $sql_param_array );


                }

                return array('where'=>$where, 'count'=> count($array));

            }
            else
            {
                return false;
            }

        }
        //
        function get_param_name_default($value_id)
        {
            //удаляем повторы
            $value_id =  array_unique ($value_id);

            if (count($value_id) > 0)
            {
                $where = implode (',',$value_id);
                $_query = $this->query('select value, value_id from '.DB_PREFIX.'param_value where value_id in ('.$where.')');

                $name_value = array();

                while( $query = $this->fetch_array($_query, false)  ) 
                {
                    $name_value[ $query['value_id'] ]  =   $query['value'];
                }  

                return $name_value;
            }
            else
            {
                return 0;    
            }
        }

        //смена статуса параметра
        function set_param_status($id, $status)
        {      
            $this->query('update '.DB_PREFIX.'param_name set status='.$status.' where name_id = '.$id);
        }

        //сохранение параметров и поле по умолчанию для параметра
        function save_param_name($array)
        {
            foreach ($array as $name_id => $value)
            {
                $_param = $value;

                if ( isset($_param['value_default']) )
                {
                    $value_default = $_param['value_default'];

                    unset($_param['value_default']);
                }

                $this->perform (DB_PREFIX.'param_name', $_param, 'update', 'name_id='.$name_id);

                if ( isset($value_default) )
                {
                    $this->perform (DB_PREFIX.'param_value', array('value' => $value_default), 'update', 'value_id='.$value['value_id']);

                }

            }
        }

        //сохраняем параметры
        function save_param ($array, $param = array() )
        {
            if ( count($array) )
            {
                foreach ($array as $value)
                {
                    $param_id = $this->is_param( array('name_id'=>$value['name_id'], 'product_id'=>$value['product_id'] ) );
                    if ($param_id != 0)
                    {

                        if (!empty($value['product_id']))
                        {
                            $this->query('update '.DB_PREFIX.'param SET value_id='.$value['value_id'].' where name_id='.$value['name_id'].' and product_id='.$value['product_id']);

                        }

                    }
                    else
                    {
                        //добавляем параметры
                        $p = array('value_id' =>$value['value_id'], 'name_id'=> $value['name_id'],'product_id'=> $value['product_id']);
                        $this->add_param ($p);
                    }
                }

                return 1;
            }
            else
            {
                return 0;
            }
        }

        //сохранение варианта параметра
        /*
        array (
        value_id =>  array( value => param_name ),
        )
        */
        function save_param_value($array)
        {
            if ( count ($array) > 0)
            {
                foreach ($array as $value_id => $value)
                {
                    $this->perform (DB_PREFIX.'param_value', $value, 'update', 'value_id='.$value_id)   ;
                }
            }
        }

        //возвращаем варианты параметра по $name_id
        function get_param_option ($name_id)
        {
            $params = array();

            $query = $this->query('select value_id, value from '.DB_PREFIX.'param_value where name_id='.(int)$name_id );   

            while ( $_param = $this->fetch_array($query, false) )
            {
                $params[ $_param['value_id'] ] =  $_param['value'];
            }

            return $params;
            //        value_id     param_id     value
        }

        //форма для редактирования параметров продуктов
        function form_product_edit($category_id = 0, $p = array())
        {
            $content = ''; 

            global $category_cache;

            $current_cat = (int)$category_id;

            $_array_cat = array(0);

            while ($current_cat != 0)
            {
                $_array_cat[] = $current_cat;
                $current_cat = $category_cache[$current_cat];
            }

            //   print_r($_array_cat);
            //если товар уже существует - фрейм.

            //делаем выборку корневых параметров
            // $value = $this->get_param_name( array('category_id' => $category_id) );
            $value = array();

            foreach ($_array_cat as $cat_id)
            {
                $value_tmp = $this->get_param_name( array('category_id' => $cat_id) );

                if ( count($value_tmp) > 0 )
                {
                    foreach ($value_tmp as $val)
                    {
                        $value[] = $val;
                    }
                }
            }

            ///////////////////////////////////////////////

            if ( count($value) > 0 )
            {
                foreach ($value as $_value)
                {
                    $value_id_array[] = $_value['name_id'];

                    $value_id_default[ $_value['name_id'] ] = $_value['value_id'];
                }

                $param_value_group = $this->get_param_value_group ($value_id_array);

                if (isset($p['type']) && $p['type'] == 'frame' )
                {
                    $content .= '<form action="plugins_page.php?page=param_product&category_id='.@$_GET['category_id'].'&product_id='.@$_GET['product_id'].'" method="post">'."\n";
                }

                if ( empty($_GET['category_id']) )
                {
                    $_GET['category_id'] = $_GET['cPath'];
                }

                $content .= '<input type="submit" value=" Сохранить "><br />'."\n";

                $content .= '<input type="hidden" name="product_id" value="'.@$_GET['product_id'].'"><br />'."\n";
                $content .= '<input type="hidden" name="category_id" value="'.@$_GET['category_id'].'"><br />'."\n";
                $content .= '<table width="" border="0">';
                //рисуем меню

                $param_array = $this->get_param_id ( $_GET['product_id']) ;

                if (!empty($param_array))
                {
                    foreach ($param_array as $val)
                    {
                        $_param_array[ $val['name_id'] ]  =  $val['value_id'];
                    }
                } 

                $value  = apply_filter('param_add_tabs_array_func', $value);

                foreach ($value as $_value)
                {
                    if (isset($_param_array[ $_value['name_id'] ])) 
                    {
                        $def_val = $_param_array[ $_value['name_id'] ];
                    }
                    else
                    {
                        $def_val = $_value['value_id'];
                    }

                    $content .=  '<tr>'."\n";
                    $content .= '<td><b>'.$_value['name_value'].':</b></td>'."\n";
                    $content .= '<td>'.os_draw_pull_down_menu('param['.$_value['name_id'].']', $param_value_group [ $_value['name_id'] ], $def_val , 'style="width:150px"' ).'</td>'."\n";
                    $content .= '</tr>'."\n";
                }

                $content .= '</table>';

                if (isset($p['type']) && $p['type'] == 'frame' )
                {
                    $content .= '</form>';
                }

                return $content;
            }
            else
            {
                return '';
            }
        }


        function form_cat_filter ($category_id = 0, $p = array())
        {
            $content = ''; 

            global $category_cache;

            $current_cat = (int)$category_id;

            $_array_cat = array(0);

            while ($current_cat != 0)
            {
                $_array_cat[] = $current_cat;
                $current_cat = $category_cache[$current_cat];
            }

            //   print_r($_array_cat);
            //если товар уже существует - фрейм.

            //делаем выборку корневых параметров
            // $value = $this->get_param_name( array('category_id' => $category_id) );
            $value = array();

            foreach ($_array_cat as $cat_id)
            {
                $value_tmp = $this->get_param_name( array('category_id' => $cat_id) );

                if ( count($value_tmp) > 0 )
                {
                    foreach ($value_tmp as $val)
                    {
                        $value[] = $val;
                    }
                }
            }
            
            $value = apply_filter('param_filter_array_func', $value);

            if ( count($value) > 0 )
            {
                foreach ($value as $_value)
                {
                    $value_id_array[] = $_value['name_id'];

                    $value_id_default[ $_value['name_id'] ] = $_value['value_id'];
                }

                $param_value_group = $this->get_param_value_group ($value_id_array);


                $content .= '<table><tr>'."\n";
                $content .= '<form action="" method="post">'."\n";


                if ( empty($_GET['category_id']) )
                {
                    $_GET['category_id'] = $_GET['cPath'];
                }

                //рисуем меню

                $param_array = $this->get_param_id ( $_GET['product_id']) ;

                if (!empty($param_array))
                {
                    foreach ($param_array as $val)
                    {
                        $_param_array[ $val['name_id'] ]  =  $val['value_id'];
                    }
                } 



                foreach ($value as $_value)
                {
                    $param_value_group [ $_value['name_id'] ][0]['text'] = $_value['name_value'];
                    $content .= '<td><span>'.os_draw_pull_down_menu('param_filter['.$_value['name_id'].']', $param_value_group [ $_value['name_id'] ], '' , 'style="width:150px"' ).'</span></td>'."\n";
                }


                $content .= '<td><input type="submit" value="  OK  "></td>'."\n";
                $content .= '</form></tr></table>';

                return $content;
            }
            else
            {
                return '';
            }
        }
    }

    global $param;

    $param = new param();
?>