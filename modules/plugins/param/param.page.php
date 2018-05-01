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
<style>
    .text table {
        font: 100% Verdana,Geneva,Arial,Helvetica,sans-serif;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    .pline2 td {
        border-bottom: 1px solid #CCCCCC;
    }

    .pdtable td {
        padding: 7px 10px;
    }

    .b-whbd-i a {
        color: #034B83;
        text-decoration: none;
    }


</style> 
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="pdtable">


    <?php                           
        $st = $param->get_param_id (154567);

        foreach ($st as $value)
        {

            echo '<tr class="pline2"><td class="pdinfohead"><a><img style="padding-right: 5px;margin-right: 5px;" src="http://catalog.onliner.by/pic/ico_que.gif" border="0"  /></a><a>'.$value['name_value'].'</a></td><td>'.$value['value'].'</td></tr>';  
        }
    ?>
</table>

<?php
 die();
?>