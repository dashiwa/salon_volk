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

    class import3 extends db
    {
        //путь к загруженному файлу
        var $file = '';
        var $file_name = '';
        var $file_size = '';
        //массив полей импортируемого файла
        var $fields_array = array();
        var $fields_selected = array();
        //delimeter
        var $delimeter = "\t";
        var $default_fields = '';
        var $data_mapping_primary_col = '';

        //кодировка импортирования
        var $charset = 'cp1251';
        var $sub = '';
        //режим импортирования
        var $mode = 'mode1';

        var $products = array();
        var $products_desc = array();

        var $log_info = array('add' => 0, 'delete' => 0, 'update' => 0, 'no' => 0);

        //элементы локализации
        var $lang = array();

        var $auto_check = array();
        //link на файл для логов
        var $f = '';
        var $products_id = 0;


        function import3()
        {
            if ( isset ( $_SESSION['language'] ) )
            {
                $lang = $_SESSION['language'];
            }
            else
            {
                $lang = 'ru';
            }

            //подключение файла локализации
            if ( is_file(  dirname(__FILE__).'/lang/'.$_SESSION['language'].'.php' ) )
            {
                require_once( dirname(__FILE__).'/lang/'.$_SESSION['language'].'.php' );

                if ( isset($lang) )
                {
                    $this->lang = $lang;
                }
            }
            

            //установка режима импортирования
            if ( isset( $_POST['mode'] ) )
            {
                $this->mode = $_POST['mode'];
            }

            if ( isset( $_SESSION['mode'] ) && !empty($_SESSION['mode']) )
            {
                $this->mode = $_SESSION['mode'];
            }

            if ( isset( $_SESSION['delimeter'] ) )
            { 
                $this->delimeter = $_SESSION['delimeter'];
            }

            //указываем delimeter
            if ( isset( $_POST['delimeter'] ) )
            {
                if ($_POST['delimeter']=='tab') 
                {
                    $this->delimeter = "\t";
                }
                else 
                {
                    $this->delimeter = $_POST['delimeter'];
                }

                $_SESSION['delimeter'] = $this->delimeter;
            }

            if ( isset( $_POST['charset'] ) )
            {
                $this->charset = $_POST['charset'];
            }

            if ( isset($_POST['sub']) )
            { 
                $this->sub = $_POST['sub'];
            }

            //определение ключевого поля
            if ( isset( $_POST['general'] ) && !empty( $_POST['general'] ) ) 
            {
                $this->data_mapping_primary_col = $_POST['general']; 
                $_SESSION['data_mapping_primary_col'] = $this->data_mapping_primary_col;
            }
            else 
            {
                if ( isset( $_SESSION['data_mapping_primary_col'] ) )
                {
                    $this->data_mapping_primary_col = $_SESSION['data_mapping_primary_col'];
                }
                else
                {
                    $this->data_mapping_primary_col = 'products_id'; 
                }
            }

            if ( isset( $_GET['file_name'] ) )
            {
                $this->file_name = $_GET['file_name'];
                $this->file = _IMPORT . $this->file_name;
                $this->file_size = filesize ( $this->file );
                $this->get_fields();
            }           

            if ( isset( $_SESSION['file_name'] ) )
            {
                $this->file_name = $_SESSION['file_name'];
                $this->file = _IMPORT . $this->file_name;
                $this->file_size = filesize ( $this->file );
                $this->get_fields();
            }

            //page3
            if ( isset( $_POST['file_name'] ) )
            {
                $this->file_name = $_POST['file_name'];
                $this->file = _IMPORT . $this->file_name;
                $this->file_size = filesize ( $this->file );
                $this->get_fields();
                $_SESSION['file_name'] = $_POST['file_name'];
            }   

            $this->default_fields = array(
            'products_id' => $this->lang['import_id'],
            'products_model' => $this->lang['import_model'],
            'products_name' => $this->lang['import_name'],
            'products_price' => $this->lang['import_price'],
            'products_page_url' => $this->lang['import_page_url'],
            'products_image' => $this->lang['import_image'],
            'products_quantity' => $this->lang['import_quantity'],
            'products_description' => $this->lang['import_description'],
            'products_short_description' => $this->lang['import_short_description'],
            'products_keywords' => 'keywords',
            'products_url' => $this->lang['import_url'],
            'products_weight' => $this->lang['import_weight'],
            'date_added' => $this->lang['import_date_added'],
            'products_sort' => $this->lang['import_sort'],
            'manufacturers_name' => $this->lang['import_manufacturers_name'],
            'products_status' => $this->lang['import_status'],
            //   'products_ean' => $this->lang['import_ean'],
            'products_meta_title' => 'Meta Title',
            'products_meta_description' => 'Meta Description',
            'products_meta_keywords' => 'Meta Keywords',
            'action' => $this->lang['import_action'],
            'categories_name_1' => 'categories_name_1',
            'categories_name_2' => 'categories_name_2',
            'categories_name_3' => 'categories_name_3',
            'categories_name_4' => 'categories_name_4',
            'categories_name_5' => 'categories_name_5',
            'categories_name_6' => 'categories_name_6',
            'categories_name_7' => 'categories_name_7'
            );

            if ( isset( $_SESSION['field'] ) )
            {    
                $this->fields_selected = $_SESSION['field'];
            }   

            //какие поля импортировать в таблицу os_products
            $this->products  =   array(
            'products_id'=> 1,
            'products_quantity'=> 1,
            'products_model'=> 1,
            'products_sort'=> 1,
            'products_image'=> 1,
            'products_price'=> 1,
            'products_date_available'=> 1,
            'products_weight'=> 1,
            'products_status'=> 1,
            //   'products_ean'=> 1,
            'products_page_url'=> 1
            );

            //поля таблицы os_products_description
            $this->products_desc = array(
            'products_id'=> 1,
            'products_name'=> 1,
            'products_description'=> 1,
            'products_short_description'=> 1,
            'products_keywords'=> 1,
            'products_meta_title'=> 1,
            'products_meta_description'=> 1,
            'products_meta_keywords'=> 1,
            'products_url'=> 1
            );

            $this->auto_check = array(
            '0' => 'v_products_id',
            '1' => 'v_products_model',
            '2' => 'v_products_name_1',
            '3' => 'v_products_price',
            '4' => 'v_products_page_url',
            '5' => 'v_products_image',
            '6' => 'v_products_quantity',
            '7' => 'v_products_description_1',
            '8' => 'v_products_short_description_1',
            '9' => 'v_products_keywords_1',
            '10' => 'v_products_url_1',
            '11' => 'v_products_weight',
            '12' => 'v_date_added',
            '13' => 'v_products_sort',
            '14' => 'v_manufacturers_name',
            '15' => 'v_status',
            '16' => 'v_products_meta_title_1',
            '17' => 'v_products_meta_description_1',
            '18' => 'v_products_meta_keywords_1',
            '19' => 'v_action',
            '20' => 'v_categories_name_1',
            '21' => 'v_categories_name_2',
            '22' => 'v_categories_name_3',
            '23' => 'v_categories_name_4',
            '24' => 'v_categories_name_5',
            '25' => 'v_categories_name_6',
            '26' => 'v_categories_name_7'
            );

            //v_products_meta_title_1
            if ( isset( $_SESSION['log_info'] ) )
            {
                $this->log_info = $_SESSION['log_info'];
            }


        }


        //загрузка файла
        function upload()
        {
            if ( is_uploaded_file($_FILES['csv']['tmp_name']) && 
            isset($_POST['charset']) && isset($_POST['delimeter']))
            {
                $_explode = explode('.', $_FILES['csv']['name']);

                if ( count($_explode) == 1) 
                {
                    $_file_type = $_POST['sub'] == 'excel_import' ? 'csv' : 'txt';

                    $_FILES['csv']['name'] = $_FILES['csv']['name'] . '_' . date("Y-m-d") . '.' . $_file_type;
                }
                else 
                {
                    $_file_type = $_explode [ count( $_explode ) - 1];
                    unset( $_explode[ count( $_explode ) - 1] ); 
                    $_file_name = implode('.', $_explode);
                    $_FILES['csv']['name'] = $_file_name.'_'.date("Y-m-d").'.'.$_file_type;
                }


                $csv_upload = os_try_upload('csv', _IMPORT);

                $this->file = _IMPORT.$_FILES['csv']['name'];
                $this->file_name = $_FILES['csv']['name'];
                $this->file_size = filesize ( $this->file );
            }
            elseif ( isset($_POST['downloaded_file_name']) && !empty( $_POST['downloaded_file_name'] ) &&  is_file( _IMPORT.$_POST['downloaded_file_name'] ) )
            {
                $this->file = _IMPORT . $_POST['downloaded_file_name'];
                $this->file_name = $_POST['downloaded_file_name'];
                $this->file_size = filesize (_IMPORT. $_POST['downloaded_file_name']);
            }
            else
            {
                // $post_max = s(int)ini_get('post_max_size');
                // $max_filesize = (int)ini_get('upload_max_filesize');

                //  echo $max_filesize.$post_max ;
                //  echo 'error downloads!';
            }




        }

        //получение полей cvs файла
        function get_fields( ) 
        { 
            //если повторно вызываем. выдавать из массива
            if ( count( $this->fields_array ) == 0 )
            {
                $arr_csv_columns = '';
                $fpointer = @ fopen( $this->file, "r"); 

                if ( $fpointer ) 
                { 
                    $arr = fgetcsv($fpointer, 10*1024, $this->delimeter); 

                    fclose($fpointer); 

                    if (!empty($arr))
                    {
                        foreach ($arr as $_num =>$_value)
                        {
                            trim( $arr[ $_num ] );
                            if ( $_value == 'EOREOR') unset($arr[ $_num ]);
                        }
                    }

                    $this->fields_array =  $arr;

                } 
            }
        }

        function fields_default_select( $_num )
        {
            $name = 'name_';
            $value = '';
            $i = '0';

            foreach ( $this->default_fields as $_name => $_value)
            {
                if ($i == $_num)
                {
                    $value = '<input type="hidden" value="'.$_name.'" name="field_1['.$_num.']">'.$_value;
                }

                $i++;
            }   

            return $value;
        }

        function fields_select($_num)
        {
            $value = '';
            $value .= '<select name="field['.$_num.']">';
            $value .= '<option value="0" style="color:grey"> - пропустить этот столбец -</option>';
            $i = '0';

            //print_r($array);
            foreach ($this->fields_array as $_value)
            {
                //автоопределение колонок csv
                if ( get_option('import_detect') == 'true')
                {
                    if ( $this->auto_check[$_num] == $_value)
                    {
                        $value .= '<option selected value="'.$_value.'">'.$i.':'.' '.$_value.'</option>';
                    }
                    else
                    {
                        $value .= '<option value="'.$_value.'">'.$i.':'.' '.$_value.'</option>';
                    }
                }
                else
                {
                    $value .= '<option value="'.$_value.'">'.$i.':'.' '.$_value.'</option>';
                }

                $i++;
            }  
            $value .= '</select>';
            return $value;
        }

        function get_fields_list()
        {
            echo '<i style="font-size:12px;">';

            foreach ($this->fields_array as $_value)
            {
                echo $_value.', ';
            }

            echo '</i>';
        }

        //set_time_limit
        function set_time_limit()
        {
            if (!get_cfg_var('safe_mode') && function_exists('set_time_limit')) 
            {
                @ set_time_limit( 0 );
            }

            if (function_exists('ini_set')) 
            {
                @ ini_set("max_execution_time", 0);
            }
        }

        function csv_filter($buffer)
        {
            //   $buffer = str_replace('"', '&quot;', $buffer);
            return  $buffer;
        }

        //возврашает кол. строк в cvs файле
        function get_cols_count()
        {
            if ( empty( $this->file ) ) return 0;

            $handle = fopen( $this->file, "r");
            $i = 0;

            while (!feof($handle)) 
            {
                $buffer = fgets($handle, 4096);
                $i++;
            }
            fclose($handle);

            return $i;
        }

        //считываем $len строк с позиции $str_num
        function get_cols ( )
        {
            if ( empty( $this->file ) ) return 0;

            $handle = fopen( $this->file, "r");

            //кол. прочитанных строк
            $i = 0;

            $b = array();

            while ( !feof($handle) ) 
            {
                $i++;
                $buffer = fgetcsv($handle, 10*1024, $this->delimeter); 
                $buffer = $this->csv_filter($buffer);

                //читаем строку из csv
                //  $buffer = fgets($handle, 20096);
                // $buffer = explode ($this->delimeter, $buffer);

                //не читаем первую строчку
                $b[]  = $buffer;
           

            }

            fclose($handle);

            if ( count($b) > 0 )
            {
                foreach ($b as  $num => $value)
                {
                    if ( is_array( $value ) && count( $value ) > 0  )
                    {
                        foreach ( $value as $_num => $_col)
                        {

                            $_str = iconv( $this->charset, 'UTF-8',   trim($_col) );

                            /*     //удаляем "". сори за кривой код:)
                            if ( strlen( $_str ) > 2 && $_str[0] == '"' && $_str[ strlen( $_str ) -1 ] == '"' )
                            {
                            $_str = substr($_str, 1, strlen($_str)-2 );
                            $_str = str_replace('""', '&quot;', $_str);
                            }
                            //удалили кавычки

                            if ( $_str == '""')
                            {
                            $_str= '';
                            }
                            */
                            $b[ $num ][ $_num ] = $_str;
                        }
                    }

                }
            }

            return $b;
        }

        //проверяем. пустой массив анных или нет. есть ли ключевое поле
        function is_empty( $array )
        {
            if ( !isset( $array[ $this->data_mapping_primary_col ] ) )
            {
                return true;
            }

            if (  count( $array ) > 0  )
            {
                foreach ( $array as $value)
                {
                    $_value = trim( $value );
                    if ( !empty( $_value ) ) return false;
                }


                return true;
            }
            else
            {
                return true;
            }
        }

        function delete_products($array)
        {

            if ( isset( $array['action'] ) && isset( $array[ $this->data_mapping_primary_col ] ) && 
            !empty($array['action']) && !empty( $array[ $this->data_mapping_primary_col ] ) 
            )
            {

                $array['action'] = strtolower($array['action']);

                if ($array['action'] == 'delete' or $array['action'] == 'remove')
                {  

                    $product_id = $array[ 'products_id'];

                    $_query = 'delete from '.DB_PREFIX.'products where products_id='.$product_id.';';

                    //увеличиваем счетчик удаленных товаров
                    $this->log_info['delete']++;

                    $this->query($_query);
                    $this->save_query($_query);
                    $this->save_log('Удален товар, products_id'.'='.$product_id );

                    $_query = "delete from " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " where products_id=".$product_id.';';

                    $this->query($_query);
                    $this->save_query($_query);

                    $_query = "delete from ".DB_PREFIX."products_description where products_id=".$product_id.';';

                    $this->query($_query);
                    $this->save_query($_query);

                    $_query = "delete from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id=".$product_id."";

                    $this->query($_query);
                    $this->save_query($_query);

                    $_query = "delete from ".TABLE_SPECIALS." where products_id=".os_db_input($product_id)."";
                    $this->query($_query);
                    $this->save_query($_query);
                    $_query = "delete from ".TABLE_PRODUCTS_IMAGES." where products_id=".os_db_input($product_id)."";

                    $this->query($_query);
                    $this->save_query($_query);

                    $_query = "delete from ".TABLE_PRODUCTS_ATTRIBUTES." where products_id=".os_db_input($product_id)."";

                    $this->query($_query);
                    $this->save_query($_query);

                    $_query = "delete from ".TABLE_CUSTOMERS_BASKET." where products_id=".os_db_input($product_id)."";
                    $this->query($_query);
                    $this->save_query($_query);

                    $_query = "delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where products_id=".os_db_input($product_id)."";
                    $this->query($_query);
                    $this->save_query($_query);

                    return true;

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

        //выполнить импорт 
        function execute ( $array )
        {
            if ( is_array( $array ) && count( $array ) > 0 )
            {
                foreach ( $array as $_value )
                {

                    //удалить все лишнее из массива.
                    $clean_value =  $this->clean ( $_value );

                    //если массив не пустой
                    if (  !$this->is_empty( $clean_value ) )
                    {				
                        //удаляем продукт. если action = delete
                        if ( !$this->delete_products($clean_value) )
                        {
                            //импортруем только поля os_prodcuts, os_prodcuts_desc~
                            $products_id = $this->execute_products( $clean_value );

                            //если есть поле с производителем
                            if ( isset( $clean_value['manufacturers_name'] ) &&  $products_id != 0)
                            {
                                $this->execute_manufacturers( $clean_value['manufacturers_name'], $products_id );
                            }						

                            //обновление-добававление категорий
                            if ( isset( $clean_value['categories_name_1'] ) && $products_id != 0)
                            {
                                $this->execute_categories( $clean_value, $products_id);
                            }
                        }
                    }
                    else
                    {
                        $this->log_info['no']++;
                        $this->save_log('Пустая строка или ключевое поле не задано.');
                    }
                }
            }
        }


        //добавление-обновление категорий
        function execute_categories($categories_name, $products_id)
        {
            //проверяем первый уровень категорий
            if ( isset( $categories_name['categories_name_1'])  && !empty( $categories_name['categories_name_1'] ) )
            {
                $categories_id = $this->is_categories($categories_name['categories_name_1'], 0);

                if ( $categories_id == 0)
                {
                    $categories_id = $this->add_categories($categories_name['categories_name_1'], 0);
                    $this->save_log('Добавлена категория '.$categories_name['categories_name_1'].', categories_id='.$categories_id.', parent_id=0');
                }

                //2ой уровень категорий
                if ( isset( $categories_name['categories_name_2'])  && !empty( $categories_name['categories_name_2'] ) )
                {
                    $categories_id_2 = $this->is_categories($categories_name['categories_name_2'], $categories_id);

                    if ( $categories_id_2 == 0)
                    {
                        $categories_id_2 = $this->add_categories($categories_name['categories_name_2'], $categories_id);
                        $this->save_log('Добавлена подкатегория '.$categories_name['categories_name_2'].', categories_id='.$categories_id_2.', parent_id='.$categories_id);
                    }

                    //3ий уровень категории
                    if ( isset( $categories_name['categories_name_3'] )  && !empty( $categories_name['categories_name_3'] ) )
                    {
                        $categories_id_3 = $this->is_categories($categories_name['categories_name_3'], $categories_id_2);

                        if ( $categories_id_3 == 0)
                        {
                            $categories_id_3 = $this->add_categories($categories_name['categories_name_3'], $categories_id_2);
                            $this->save_log('Добавлена подкатегория '.$categories_name['categories_name_3'].', categories_id='.$categories_id_3.', parent_id='.$categories_id_2);
                        }

                        //4ый уровень категории
                        if ( isset( $categories_name['categories_name_4'] )  && !empty( $categories_name['categories_name_4'] ) )
                        {
                            $categories_id_4 = $this->is_categories($categories_name['categories_name_4'], $categories_id_3);

                            if ( $categories_id_4 == 0)
                            {
                                $categories_id_4 = $this->add_categories($categories_name['categories_name_4'], $categories_id_3);
                                $this->save_log('Добавлена подкатегория '.$categories_name['categories_name_4'].', categories_id='.$categories_id_4.', parent_id='.$categories_id_3);
                            }

                            //5ый уровень
                            if ( isset( $categories_name['categories_name_5'] )  && !empty( $categories_name['categories_name_5'] ) )
                            {
                                $categories_id_5 = $this->is_categories($categories_name['categories_name_5'], $categories_id_4);

                                if ( $categories_id_5 == 0)
                                {
                                    $categories_id_5 = $this->add_categories($categories_name['categories_name_5'], $categories_id_4);
                                    $this->save_log('Добавлена подкатегория '.$categories_name['categories_name_5'].', categories_id='.$categories_id_5.', parent_id='.$categories_id_4);
                                }

                                //6ый уровень
                                if ( isset( $categories_name['categories_name_6'] )  && !empty( $categories_name['categories_name_6'] ) )
                                {
                                    $categories_id_6 = $this->is_categories($categories_name['categories_name_6'], $categories_id_5);

                                    if ( $categories_id_6 == 0)
                                    {
                                        $categories_id_6 = $this->add_categories($categories_name['categories_name_6'], $categories_id_5);
                                        $this->save_log('Добавлена подкатегория '.$categories_name['categories_name_6'].', categories_id='.$categories_id_6.', parent_id='.$categories_id_5);
                                    }


                                    if ( isset( $categories_name['categories_name_7'] )  && !empty( $categories_name['categories_name_7'] ) )
                                    {
                                        $categories_id_7 = $this->is_categories($categories_name['categories_name_7'], $categories_id_6);

                                        if ( $categories_id_7 == 0)
                                        {
                                            $categories_id_7 = $this->add_categories($categories_name['categories_name_7'], $categories_id_6);
                                            $this->save_log('Добавлена подкатегория '.$categories_name['categories_name_7'].', categories_id='.$categories_id_7.', parent_id='.$categories_id_6);
                                        }

                                        $this->set_products_to_categories($products_id, $categories_id_7);

                                    }
                                    else
                                    {
                                        //если нет 4ого уровня - добавляем товар в категорию и завершаем
                                        $this->set_products_to_categories($products_id, $categories_id_6);
                                    } 
                                }
                                else
                                {
                                    //если нет 4ого уровня - добавляем товар в категорию и завершаем
                                    $this->set_products_to_categories($products_id, $categories_id_5);
                                } 


                            }
                            else
                            {
                                //если нет 4ого уровня - добавляем товар в категорию и завершаем
                                $this->set_products_to_categories($products_id, $categories_id_4);
                            } 

                        }
                        else
                        {
                            //если нет 3ого уровня - добавляем товар в категорию и завершаем
                            $this->set_products_to_categories($products_id, $categories_id_3);
                        }

                    }
                    else
                    {
                        //если нет 3ого уровня - добавляем товар в категорию и завершаем
                        $this->set_products_to_categories($products_id, $categories_id_2);
                    }
                }
                else
                {
                    //если нет 2ого уровня - добавляем товар в категорию и завершаем
                    $this->set_products_to_categories($products_id, $categories_id);
                }
            }
        }

        //проверка. существует ли категория
        function is_categories($categories_name, $parent_id = 0)
        {
            $_query = 'SELECT categories_name, c.categories_id, parent_id FROM '.DB_PREFIX.'categories c LEFT JOIN '.DB_PREFIX.'categories_description cd ON ( c.categories_id = cd.categories_id ) where parent_id='.$parent_id.' and categories_name="'.$this->input($categories_name).'" and language_id='.$_SESSION['languages_id'].' limit 1';

            $this->save_query($_query);

            $_query = $this->query($_query);

            $categories = $this->fetch_array($_query, false);

            if ( count($categories) == 0 ) 
            {
                return 0;
            }
            else
            {
                return $categories['categories_id'];
            }
        }

        //добавления записи  в products_to_categories
        function set_products_to_categories ($products_id, $categories_id)
        {
            $_query = 'insert into '.DB_PREFIX.'products_to_categories (products_id, categories_id) values ('.$products_id.', '.$categories_id.') ON DUPLICATE KEY UPDATE categories_id = "'.$categories_id.'";';

            $this->save_query($_query);

            $this->query($_query);
        }

        //добавление категории
        function add_categories($categories_name, $parent_id = 0)
        {
            $_query = 'insert into '.DB_PREFIX.'categories (parent_id, categories_status) values ('.$parent_id.', 1);';
            $this->save_query($_query);
            $this->query($_query);
            $categories_id = $this->insert_id();

            $_query = 'insert into '.DB_PREFIX.'categories_description (categories_id, language_id, categories_name) values ('.$categories_id.','.$_SESSION['languages_id'].', "'.$this->input( $categories_name ) .'");';
            $this->save_query($_query);
            $this->query($_query);

            return $categories_id;	
        }


        //работаем с произво
        function execute_manufacturers($manufacturers_name, $products_id)
        {
            //делаем выборку всех производителей в массив $this->manufacturers
            //$this->get_manufacturers();

            //определяем id производителя, если такой существует
            $manufacturers_id = $this->is_manufacturers( $manufacturers_name ) ;

            if ( empty( $manufacturers_name ) )  
            {
                $this->remove_products_manufacturers($products_id);
            }

            if ($manufacturers_id == 0)
            {
                //создаем производителя
                $_manufacturers_id = $this->add_manufacturers( $manufacturers_name );

                //устанавливаем произвоителя - товару
                $this->set_manufacturers_to_products($products_id, $_manufacturers_id);
            }
            else
            {
                //устанавливаем произвоителя - товару
                $this->set_manufacturers_to_products($products_id, $manufacturers_id);
            }

        }

        //устанавливаем произвоителя - товару
        function set_manufacturers_to_products($products_id, $manufacturers_id)
        {
            $_query = 'update '.DB_PREFIX.'products set manufacturers_id='.(int)$manufacturers_id.' where products_id='.$products_id;

            $this->query ($_query);

            $_col = $this->affected_rows();

            $this->save_query($_query.'('.$_col.')');

            $this->save_log('Обновлен произвоитель manufacturers_id='.$manufacturers_id.' для products_id='.$products_id);
        }

        //проверяем. есть ли такой товар
        function is_products ( $p )
        {
            $_query = 'select products_id from '.DB_PREFIX.'products where '.$this->data_mapping_primary_col.'="'.$p[ $this->data_mapping_primary_col ].'" limit 1;';
            $this->save_query($_query);

            $_query = $this->query ($_query);
            $__query = $this->fetch_array($_query, false);

            $this->products_id = $__query['products_id'];

            if ( $this->num_rows ( $_query ) == 1 )
            {
                return true;
            }
            else
            {            
                return false;
            }           
        }

        //определяем. есть ли производитель с данным именем
        function is_manufacturers ($name)
        {
            $_query = 'select manufacturers_id from '.DB_PREFIX.'manufacturers where manufacturers_name="'.$this->input($name).'";';

            $this->save_query($_query);

            $_query = $this->query($_query);

            $manufacturers = $this->fetch_array($_query, false);

            if ( count($manufacturers) == 0 ) 
            {
                return 0;
            }
            else
            {
                return $manufacturers['manufacturers_id'];
            }
        }

        //создаем произвоителя
        function add_manufacturers($name)
        {
            $_query = 'insert into '.DB_PREFIX.'manufacturers (manufacturers_name) values ("'.$this->input($name).'");';

            $this->query($_query);

            $_col = $this->affected_rows();

            $this->save_query($_query.'('.$_col.')');
            $insert_id = $this->insert_id();
            $this->save_log('Добавлен производитель '.$name.',id='.$insert_id);

            return $insert_id;
        }

        //удаляем проихводителя
        function remove_products_manufacturers($products_id)
        {
            $_query = 'update '.DB_PREFIX.'products set manufacturers_id="" where products_id='.$products_id;

            $this->query ($_query);

            $_col = $this->affected_rows();

            $this->save_query($_query.'('.$_col.')');

            $this->save_log('Обновлен произвоитель manufacturers_id="" для products_id='.$products_id);
        }

        function get_manufacturers()
        {
            $_query = 'select * from '.DB_PREFIX.'manufacturers';

            $this->save_query($_query);

            $__query = $this->query ($_query);

            while( $_query = $this->fetch_array($__query, false) )
            {
                $this->manufacturers[ $_query['manufacturers_name'] ] =  $_query['manufacturers_id'];
            }

        }

        //обновление данных в таблице os_products
        function products_update( $p )
        {   
            $data_mapping_primary_col =  $p[ $this->data_mapping_primary_col ];
            unset($p[ $this->data_mapping_primary_col ]);

            $update = '';

            foreach ($p as $name => $value)
            {
                $update[] = $name.'="'.$value.'"'; 
            }

            $update = implode(',', $update);
            //  $names = implode(',',  $name_array);
            $_query =  'update '.DB_PREFIX.'products set '.$update.' where '.$this->data_mapping_primary_col.'="'.$data_mapping_primary_col.'";';
            $this->save_query($_query);
            $this->query($_query);  

            return $data_mapping_primary_col;
        }        

        //обновление данных в таблице os_desc~
        function products_desc_update( $p )
        {   
            $data_mapping_primary_col = $p['products_id'];
            unset($p['products_id']);

            $update = '';

            foreach ($p as $name => $value)
            {
                $update[] = $name.'="'.$value.'"'; 
            }

            $update = implode(',', $update);

            $_query = 'update '.DB_PREFIX.'products_description set '.$update.' where products_id="'.$data_mapping_primary_col.'"';

            $this->save_query($_query);
            $this->query($_query );  

            return $data_mapping_primary_col;
        }

        function products_insert( $p,  $insert_id = '')
        {
            $name_array = array();
            $value_array = array();

            //если указан insert_id - прописываем его в массиве
            if ( !empty($insert_id) ) 
            {
                $p['products_id']  = $insert_id	;
            }

            foreach ($p as $name => $value)
            {
                $name_array[] = $name;
                $value_array[] = '"'.$value.'"';
            }

            $names = implode(', ', $name_array);
            $values = implode(', ', $value_array);

            $_query = 'insert into '.DB_PREFIX.'products ('.$names.') values ('.$values.');';
            $this->save_query($_query);
            $_query = $this->query ($_query);

            $__insert_id = $this->insert_id();

            $this->save_log ('Добавлена запись в  '.DB_PREFIX.'products с products_id='.$__insert_id);

            return $__insert_id;
        }        

        //добавляем данные в таблицу os_products_description
        function products_desc_insert( $p, $insert_id = '')
        {
            $name_array = array();
            $value_array = array();

            //если products_id пустое или =0. удаляем из массива для импорта
            if ( empty( $p['products_id'] ) or  $p['products_id'] == 0)
            {
                unset( $p['products_id'] );
            }

            if ( !empty( $insert_id ) )
            {
                $p['products_id'] = $insert_id;
            }

            foreach ($p as $name => $value)
            {
                $name_array[] = $name;
                $value_array[] = '"'.$value.'"';
            }

            $names = implode(', ', $name_array);
            $values = implode(', ', $value_array);

            $_query = 'insert into '.DB_PREFIX.'products_description ('.$names.') values ('.$values.');';

            $this->save_query($_query);
            $_query = $this->query ($_query);

            $__insert_id = $this->insert_id();
            $this->save_log('Добавлена запись в  '.DB_PREFIX.'products_description с id='.$__insert_id);

            return $__insert_id;

        }

        //импортруем только поля os_prodcuts
        function execute_products( $array )
        {
            $products_id = array();

            $array  = $this->filter ( $array );

            $p = array();
            $pd = array();

            foreach ($array as $name => $value)
            {

                if ( isset( $this->products[ $name ]) )
                {
                    $p[ $name ]  = $value;
                }

                if ( isset( $this->products_desc[ $name ]) )
                {
                    $pd[ $name ]  = $value;
                }
            }

            //проверяем. существует ли продукт
            if ( $this->is_products( $p ) )
            {
                $this->log_info['update']++;

                //определяем products_id по products_model
                if ( $this->data_mapping_primary_col == 'products_model')
                {
                    $_products_id = $this->products_id;

                    if ( count($p) == 1 && isset( $p['products_model'] ) )
                    {
                        unset( $p['products_model'] );
                    }    
                    else
                    {
                        $p['products_id'] = $_products_id;
                        unset( $p['products_model'] );
                    }

                    if ( count($pd) > 0 )
                    {
                        $pd['products_id'] = $_products_id;
                    } 
                }

                //если существует - обновляем его.
                if ( count($p) > 1 )
                {
                    $__id = $this->products_update( $p );
                    $this->save_log('Обновлен '.DB_PREFIX.'products, id='.$__id);
                }

                if ( count($pd) > 1 )
                {
                    $__id = $this->products_desc_update( $pd );

                    $this->save_log('Обновлен '.DB_PREFIX.'products_description, id='.$__id);
                }

                if ( empty( $__id) && empty( $this->products_id) ) 
                {
                    return 0;
                } 
                else 
                {
                    if ( empty( $__id) )
                    {
                        return $this->products_id;
                    }
                    else
                    {
                        return $__id;
                    }
                }
            }
            else
            {
                //проверяем наличия нужных столбиков для импорта
                if ( isset( $array[$this->data_mapping_primary_col] ) && 
                isset( $array['products_name'] ) && !empty( $array['products_name'] ) &&
                isset( $array['categories_name_1'])  && !empty( $array['categories_name_1'])  
                )
                {

                    if ( $this->data_mapping_primary_col == 'products_id')
                    {
                        $this->log_info['add']++;
                        $insert_id = $this->products_desc_insert( $pd );
                        $this->products_insert($p, $insert_id );

                        return $insert_id;

                    }elseif ( $this->data_mapping_primary_col == 'products_model' )
                    {
                        $this->log_info['add']++;  

                        $insert_id = $this->products_insert( $p );
                        $this->products_desc_insert( $pd, $insert_id );
                        //$this->products_insert($p, $insert_id );
                        print_r( $p);
                        print_r( $pd);


                    }
                    else
                    {
                        $this->log_info['no'] ++;
                        $this->save_log('Товар не обновлен, '.$this->data_mapping_primary_col.'='.$p[ $this->data_mapping_primary_col ] );
                        return 0;
                    }

                }
                else
                {
                    $this->log_info['no'] ++;
                    $this->save_log('Товар не обновлен, '.$this->data_mapping_primary_col.'='.$p[ $this->data_mapping_primary_col ] );
                    return 0;
                }

                //нужно проверить. есть ли уже созданный товар с ключевым полем
                //  }
                //  else
                // {
                //    echo 'нет ключевого поля<br>';
                //  }
                $this->save_log('Товар не обновлен, '.$this->data_mapping_primary_col.'='.$p[ $this->data_mapping_primary_col ] );
                $this->log_info['no']++;
                return 0;
            }
        }

        //удалить все лишнее из массива.
        function clean ($array)
        {
            $p = array();

            if ( is_array($array) && count( $array ) > 0 && count($this->fields_array) > 0 && count($this->fields_selected) > 0 )
            {
                $_array = array();
                //обходим массив с импортируемыми данными
                foreach ($array as $num => $val)
                {
                    if ( !empty( $this->fields_array[ $num ] ) )
                    {
                        $_array[ $this->fields_array[ $num ] ] = $val;
                    }
                }

                foreach ($this->fields_selected as $name => $value)
                {
                    $p[ $name ] = $_array[ $value ];
                }
            }

            return $p;
        }

        //фильтр данных полей
        function filter( $_value )
        {
            //фильтруем данные, приводим к нужным типам. все перепроверяем

            if (isset($_value['products_quantity'])) $_value['products_quantity'] = (int)$_value['products_quantity'];
            if (isset($_value['products_id'])) $_value['products_id'] = (int)$_value['products_id'];
            //сортировка
            if (isset($_value['products_sort'])) $_value['products_sort'] = (int)$_value['products_sort'];


            $array  = array('products_keywords', 'products_meta_title', 'products_meta_description', 'products_meta_keywords', 'products_url', 'products_description', 'products_short_description', 'products_name', 'products_page_url', 'products_model', 'products_image', 'products_price', 'products_date_available', 'products_weight');   

            foreach ($array as $name)
            {

                if ( isset( $_value[ $name ] ) ) 
                {
                    $_value[ $name ] = $this->input ( $_value[ $name ] );
                }
            }               

            //статус продукта
            if (isset($_value['products_status'])) 
            {
                $_value['products_status'] = strtolower( $_value['products_status'] );
                if ($_value['products_status'] == 'active') $_value['products_status'] = 1;
                elseif ($_value['products_status'] == 'inactive') $_value['products_status'] = 0;
                elseif($_value['products_status'] == 'true') $_value['products_status'] = 1;
                elseif($_value['products_status'] == 'false') $_value['products_status'] = 0;

                if ($_value['products_status'] != 1 && $_value['products_status'] != 0) $_value['products_status'] = 0;
            }


            if (isset($_value['action'])) $_value['action'] = trim(strtolower($_value['action']));

            return $_value;
        }

        //форматирует вывод размера файла
        function format( $size )
        {
            return os_format_filesize ($size);
        }

        ///сохраняем sql запрос
        function save_query ( $query )
        {
            if ( !isset( $_SESSION['import_log'] ) )
            {
                $_SESSION['import_log'] = rand(10000000,1000000000);

                $f = @ fopen( dir_path('catalog').'tmp/log_mysql.txt' , "w");
                $query =  iconv('utf-8', 'windows-1251', $query);
                @ fwrite($f, $query."\n");
                @ fclose($f);
            }
            else
            {
                if ( is_file( dir_path('catalog').'tmp/log_mysql.txt' ) )
                {
                    $f = @ fopen( dir_path('catalog').'tmp/log_mysql.txt' , "a+");
                }
                else
                {
                    $f = @ fopen( dir_path('catalog').'tmp/log_mysql.txt' , "w");
                }
                $query =  iconv('utf-8', 'windows-1251', $query);
                @ fwrite($f, $query."\n");
                @ fclose($f);
            }
        }        

        ///сохраняем запись в лог
        function save_log ( $text )
        {
            if ( !isset( $_SESSION['import_log'] ) )
            {
                $_SESSION['import_log'] = rand(10000000,1000000000);

                $f = @ fopen( dir_path('catalog').'tmp/log.txt' , "w");

                @ fwrite($f, $text."\n");
                @ fclose($f);
            }
            else
            {
                if ( is_file( dir_path('catalog').'tmp/log.txt' ) )
                {
                    $f = @ fopen( dir_path('catalog').'tmp/log.txt' , "a+");
                }
                else
                {
                    $f = @ fopen( dir_path('catalog').'tmp/log.txt' , "w");
                }

                @ fwrite($f, $text."\n");
                @ fclose($f);
            }
        }

        //возвращает id товара по $products_model
        function get_products_id(  )
        {
            return $this->products_id;
        }

    }
?>