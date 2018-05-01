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
?>
<ul>
<li><a href="plugins_page.php?main_page=param_tools&page=remove_param_all">Удалить все параметры</a></li>
<li><a href="plugins_page.php?main_page=param_generator">Копирование данных доп. полей товаров в параметры товаров</a></li>
<li><a href="plugins_page.php?main_page=param_generator_option">Копирование данных атрибутов в параметры товаров</a></li>
</ul>
<?php  
    echo '<br>';

    if ( isset($_GET['page']) )
    {
        switch ($_GET['page'])
        {
            case 'remove_param_all':
                $param->remove_param_all();
                echo '<font color="red"><b>Удалены все параметры</b></font>';
                break;

        }
    }
?>