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


?>