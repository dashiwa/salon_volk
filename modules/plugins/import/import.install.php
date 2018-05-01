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

    function import_install()
    {
        add_option('import', '', 'readonly');
		add_option('import_detect', 'true', 'radio', "array('true','false')");
		add_option('import_count', '100');
		add_option('import_delay', '1000');
		add_option('import_delay_log', '4000');
	}
?>