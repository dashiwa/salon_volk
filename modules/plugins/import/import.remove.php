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
//удаление плагина
    function import_remove()
    {
        global $db;
        $db->query("DELETE FROM ".DB_PREFIX."configuration WHERE configuration_group_id=99");
    }
?>