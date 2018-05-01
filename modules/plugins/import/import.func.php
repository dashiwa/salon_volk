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

    //стартуем таймер
    function start_timer()
    {
        global  $tstart;

        $mtime = microtime(); 
        $mtime = explode(" ",$mtime); 
        $mtime = $mtime[1] + $mtime[0]; 
        $tstart = $mtime; 
    }

    //завершаем таймер
    function end_timer()
    {
        global  $tstart;

        $mtime = microtime(); 
        $mtime = explode(" ",$mtime); 
        $mtime = $mtime[1] + $mtime[0]; 
        $tend = $mtime; 
        $tpassed = ($tend - $tstart); 
        $tpassed = number_format($tpassed, 5);

        return $tpassed;
    }

    function import_stat()
    {
        global $import;
        global $query_counts;
        $_SESSION['log_info']['query_counts'] += $query_counts;
		//прогресс в %
        $s = ( $_SESSION['progress'] / $_SESSION['get_cols_count'])*100;
        echo "<b>Выполнено:</b> ". ceil( $s ) .'% ('.$_SESSION['progress'].' из '.$_SESSION['get_cols_count'].')<br>';

        echo '<font color="green"><b>Обновлено:</b></font> '.$_SESSION['log_info']['update'].'<br />';
        echo '<font color="blue"><b>Добавлено:</b></font> '.$_SESSION['log_info']['add'].'<br />';
        echo '<font color="red"><b>Удалено:</b></font> '.$_SESSION['log_info']['delete'].'<br />';
        echo '<font color="yollow"><b>Ничего:</b></font> '.$_SESSION['log_info']['no'].'<br />';

        echo 'sql запросов: '.$_SESSION['log_info']['query_counts'].'<br>';
        echo 'Потребление памяти: '.round(memory_get_usage()/1024/1024, 2) . 'MB<br />';
		
		$_file1 = dir_path('catalog').'tmp/log_mysql.txt';
		$_file2 = dir_path('catalog').'tmp/log.txt';
		
		if ( is_file($_file1) )
		{
		   $size = filesize( $_file1);
		   echo '<a target="_blank" class="import" href="plugins_page.php?page=import_get_mysql_log">Лог mysql запросов</a> (<i>'. os_format_filesize ($size).'</i>)';
	    }
		
		if ( is_file($_file2) )
		{
		   $size2 = filesize( $_file2 );
		   echo '<br /><a target="_blank" class="import" href="plugins_page.php?page=import_get_log_txt">Лог импорта</a> (<i>'. os_format_filesize ($size2).'</i>)';
        }
	}
	
	  //возврашает кол. строк в cvs файле
        function get_cols_count($file)
        {
            $handle = fopen( $file, "r");
            $i = 0;

            while (!feof($handle)) 
            {
                $buffer = fgets($handle, 4096);
                $i++;
            }
            fclose($handle);

            return $i;
        }

?>
