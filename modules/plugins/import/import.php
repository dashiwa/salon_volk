<?php
    /*
    Plugin Name: Импорт товаров
    Plugin URI: http://www.shopos.ru/
    Description: Импорт товаров из csv.
    Version: 2.0
    Author: Матецкий Евгений
    Author URI: http://www.shopos.ru/
    */

    defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

    add_action('page_admin', 'import_page1');  
    add_action('main_page_admin', 'import_page1');  
    add_action('page_admin', 'import_page2');  
    add_action('main_page_admin', 'import_page2');  
    add_action('page_admin', 'import_page3');  
    add_action('page_admin', 'import_page4');  
    //перезапускаем импорт
    add_action('page_admin', 'import_restart');  

	//страницы для вывода логов
    add_action('page_admin', 'import_get_log_txt');  
    add_action('page_admin', 'import_get_mysql_log');  

    //лог
    add_action('page', 'import_get_log');  

    //дпоплнительнфе функции
    include_once( 'import.func.php' );

    //установка плагина
    include_once( 'import.install.php' );

    //удаление плагина
    include_once( 'import.remove.php' );

    //первая страница импорта
    //выбор товара
    function import_page1()
    {
	    unset( $_SESSION['file_name'] );
        unset( $_SESSION['import_count'] );
        unset( $_SESSION['get_cols_count'] );
        unset( $_SESSION['ftell'] );
        unset( $_SESSION['task'] );
        unset( $_SESSION['finish'] );
        unset( $_SESSION['progress'] );
        unset( $_SESSION['import_log'] );
        unset( $_SESSION['log_info'] );


        include('import.class.php');
        $import = new import2();
        include( 'import.page1.php' );
    }

    //сопоставляем столбики
    function import_page2()
    {
        include('import.class.php');

        $import = new import2();

        include( 'import.page2.php' );
    }    

    //ajax скрипт импорта
    function import_page3()
    {
        include('import.class.php');

        $import = new import2();

        include( 'import.page3.php' );
    }    

    //импорт
    function import_page4()
    {
        global $import;

        include('import.class.php');

        $import = new import2();

        include( 'import.page4.php' );
    }    

    //возвращаем лог импорта по ajax запросу 
    function import_get_log()
    { 
        if ( !isset( $_SESSION['log_tmp'] ) )
        {
            $_SESSION['log_tmp'] = 1; 
        }

        if ( isset( $_SESSION['get_cols_count'] ) )
        {	   
            $s = ( $_SESSION['progress'] / $_SESSION['get_cols_count'])*100;

            if ( $_SESSION['log_tmp'] == 1)
            {
                import_stat(); 
            }
            else
            {
                echo 'no';
                unset($_SESSION['log_tmp']);
            }

            if ( $s >=100 && $_SESSION['log_tmp'] ==1 )
            {
                $_SESSION['log_tmp'] = 0;
            }
        }
    }

    //перезапускаем импорт
    function import_restart()
    {
	    unset( $_SESSION['import_log'] );
        unset( $_SESSION['ftell'] );
        unset( $_SESSION['progress'] );
        unset( $_SESSION['finish']);
        unset( $_SESSION['log_info']);
    }

    //добалвение пункта в меню
    add_action('admin_menu', 'import_menu');

    function import_menu()
    {
        add_plug_menu('Импорт', 'plugins_page.php?main_page=import_page1');
    }
	
	function import_get_log_txt()
	{		
	   $_file2 = dir_path('catalog').'tmp/log.txt';
	   $f = @ fopen( $_file2 , "r");
	   
       $color = '';
	   $i = 0;
	   while (!feof ($f)) 
	   { 
	       $i++;
	       $color = $color == '#f9f9ff' ? '#f0f1ff':'#f9f9ff';
           $buffer = fgets($f, 4096); 
		
           if ( !empty($buffer) )
           {		   
              echo '<div style="padding: 3px;background-color:'.$color.'"><i>'.$i.'.</i> '.$buffer."</div>"; 
		   }
       }
	   
       @ fclose($f);
	}
	
	function import_get_mysql_log()
	{
	   $_file1 = dir_path('catalog').'tmp/log_mysql.txt';
	   $f = @ fopen( $_file1 , "r");
	   
       $color = '';
	   $id = 0;
       @ header('Content-Type: text/html; charset=utf-8');
	   
	   while (!feof ($f)) 
	   {   
	       $id++;
	       $color = $color == '#f9f9ff' ? '#f0f1ff':'#f9f9ff';
           $buffer = fgets($f, 4096); 
           $buffer = iconv('windows-1251', 'utf-8', $buffer);
           $buffer = htmlspecialchars($buffer);
		   $buffer = strtolower( $buffer );
		   $buffer = str_replace('select', '<font color="#ff1493">select</font>', $buffer );
		   $buffer = str_replace('from', '<font color="#ff1493">from</font>', $buffer );
		   $buffer = str_replace('where', '<font color="#ff1493">where</font>', $buffer );
		   $buffer = str_replace('insert', '<font color="#ff1493">insert</font>', $buffer );
		   $buffer = str_replace('into', '<font color="#ff1493">into</font>', $buffer );
		   $buffer = str_replace('values', '<font color="#ff1493">values</font>', $buffer );
		   $buffer = str_replace('update', '<font color="#ff1493">update</font>', $buffer );
		   $buffer = str_replace(' set ', '<font color="#ff1493"> set </font>', $buffer );
		   $buffer = str_replace(' limit ', '<font color="#ff1493"> limit </font>', $buffer );
		   $buffer = str_replace(' left join ', '<font color="#ff1493"> left join </font>', $buffer );
		   $buffer = str_replace(' on ', '<font color="#ff1493"> on </font>', $buffer );
		   $buffer = str_replace(' and ', '<font color="blue"> and </font>', $buffer );
		   
		   if (!empty($buffer))
		   {
              echo '<div style="padding:5px;background-color:'.$color.'"><i>'.$id.'</i>: '.$buffer."</div>"; 
           }			 
       }
	   
       @ fclose($f);
	}

	//кнопочка Импорт
	function import_readonly()
	{
	    _e('<center>'.add_button('main_page', 'import_page1', 'Импорт' ).'</center>');
	}
?>