<?php

    //загрузка файла
    include('import3.class.php');
    $import3 = new import3();

    $import3->upload();
    $import3->get_fields();

    if ( $import3->file_size == 0)
    {
        die('Файл не найден или размер файла = 0. <a class="import" href="plugins_page.php?main_page=import_page1">Вернуться назад</a>');
    }

    global $seller;
    global $db;

    if ( !is_object($seller)) 
    {
        include( dir_path('catalog') .'modules/plugins/seller/seller.class.php');
        $seller = new seller();  
    } 

    global $osPrice;

    if ( !is_object($osPrice)) 
    {
        include( dir_path('class') . 'price.php' );
        $osPrice = new osPrice($_SESSION['currency'], $_SESSION['customers_status']['customers_status_id']);  
    } 

   // print_r($osPrice);
    echo '<span style="font-size: 10px;"><i><b> Файл:</b> '.$import3->file_name.', <b>Размер:</b> '. $import3->format ( $import3->file_size ) .'</b></i></span><br><br>';

    $_array = $import3->get_cols();       

    if ( !isset($_POST['seller_id'] ) or $_POST['seller_id']==0 )
    {
        die('не выбран продавец. <a href="plugins_page.php?main_page=seller_import_page1" class="import">назад</a>');
    }
     
    if ( count($_array) > 0 )
    {
        $i = 0;
        foreach ($_array as $value)
        {
            $i++;

            if ( !empty( $value[0] ) )
            {
                $a = is_products_name( $value[0]);

                $_cur =  @$value[2];
                $_cur = strtoupper( $_cur );


                if ($a == false )
                {
                    echo  '<font color="red">'.$i.'. <b>'.$value[0].'</b> - товара не существует</font><br>';
                }
                else
                {
                    if ( isset( $osPrice->currencies[ $_cur ] )) 
                    {

                        if ( !empty($value[1]) and !empty($_cur)  )
                        {          

                           $_price = $osPrice->ConvertCurr($value[1] ,$_cur , $_SESSION['currency'] );               
                        
                           $_desc = @$value[3];
                            echo  '<font color="green">'.$i.'. <b>'.$value[0].'</b> привязан к продавцу</b></font> ';
                            echo  '<i>цена = '.$value[1].' '.$_cur.'; ='.$_price['formated'].'</i><br>'; 
                            
                            $_query = 'replace into '.DB_PREFIX.'seller (`seller_id`, `products_id`, `price`, `desc`, `currencies_id`) values ('.(int)$_POST['seller_id'].', '.$a.', "'.$db->input( $_price['plain'] ).'", "'.$db->input( $_desc ).'", '.(int)$osPrice->currencies[  $_SESSION['currency'] ]['currencies_id'].'  )';
                            $db->query($_query);
                        }
                    }
                    else
                    {
                        echo  '<font color="red">'.$i.'. <b>'.$value[0].'</b>, "'. $_cur.'" - такой валюты не существует</font><br>';
                    }

                }
            }
        }
    }


    function is_products_name($name)
    {
        global $db;
        $__id = $db->query('select products_id FROM `'.DB_PREFIX.'products_description` where products_name="'.$db->input($name).'" limit 1');

        if ( $db->num_rows($__id) > 0 )
        {
            $data = $db->fetch_array($__id, false);
            return $data['products_id'];
        }
        else
        {
            return false;
        }    
    }

    /* 
    импорт
    $return = '';

    $import_count = (int)get_option('import_count');
    if ( !empty($import_count))
    {
    //сколько импортируем полей за раз
    $_SESSION['import_count'] = $import_count;
    if ( $_SESSION['import_count'] == 0) $_SESSION['import_count'] = 100;
    }
    else
    {
    $_SESSION['import_count'] = '100';
    }

    if ( !isset( $_SESSION['finish']) )
    {
    $_SESSION['get_cols_count'] = $import->get_cols_count() ;
    //finish 0/1. 0 - продолжаем ипорт. 1 - завершаем.
    $_SESSION['finish'] = 0;
    //смещение в файле для fseek
    $_SESSION['ftell'] = 0;
    //сколько строк уже импортировано
    $_SESSION['progress'] = 0;
    }

    if ( $_SESSION['finish'] == 0 )
    {
    start_timer();
    $_array = $import->get_cols ( $_SESSION['import_count'] ) ;

    print_r($_array);
    //выполнить импорт на основе данных
    $import->execute ($_array);
    $time = end_timer();

    $_SESSION['log_info'] = $import->log_info;

    // print_r($import->log);
    if ( $_SESSION['progress'] <= $_SESSION['get_cols_count'])
    {
    $_SESSION['progress'] = $_SESSION['progress'] + $_SESSION['import_count'];
    if ($_SESSION['progress'] > $_SESSION['get_cols_count'])  $_SESSION['progress'] = $_SESSION['get_cols_count'];
    $return = 'ok';
    }
    }


    //print_r($_array);

    $s = ( $_SESSION['progress'] / $_SESSION['get_cols_count'])*100;

    if ($s >= 100)
    {
    $_SESSION['finish'] = 1;
    $return = 'no';
    }


    if (  $_SESSION['finish'] == 1)
    {
    // $return = 'no';
    }

    echo $return;

    */
?>