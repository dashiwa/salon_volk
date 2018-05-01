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

    if ( isset( $_GET['gID'] ) &&  $_GET['gID'] == 99 )
    {
        define('BOX_CONFIGURATION_99', 'Плагины / Импорт');      

        define('IMPORT_DETECT_TITLE', 'Автоопределение полей');
        define('IMPORT_DETECT_DESC', '');         

        define('IMPORT_COUNT_TITLE', 'Импорт кол. товаров за шаг');
        define('IMPORT_COUNT_DESC', '');		 

        define('IMPORT_DELAY_TITLE', 'Задержка между шагами импорта');
        define('IMPORT_DELAY_DESC', '');		 

        define('IMPORT_DELAY_LOG_TITLE', 'Задержка между шагами импорта');
        define('IMPORT_DELAY_LOG_DESC', '');
    }
?>