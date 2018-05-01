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

defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

if (!get_cfg_var('safe_mode') && function_exists('set_time_limit')) 
{
   @ set_time_limit(0);
}

if (function_exists('ini_set')) 
{
   @ ini_set("max_execution_time", 0);
}
?>
<?php
if (isset($_POST['field']) && isset($_POST['file_name']))
{
   global $_fields;
   global $_charset;
   global $_delimeter;
   
   $_fields = array();
   $_charset = $_POST['charset'];
   
   //delimeter
   if (isset($_POST['delimeter']))
   {
       if ($_POST['delimeter']=='tab') $_delimeter = "	";
       else $_delimeter = $_POST['delimeter'];
   }
   else
   {
       die('no delimeter!');
   }
   
   //главное поле
   if (isset($_POST['general'])) $data_mapping_primary_col = $_POST['general']; else $data_mapping_primary_col = 'products_id'; 

   foreach ($_POST['field'] as $_num => $_value)
   {
      if (trim($_value) != '0') 
	  {
	      $_fields[$_value] = $_POST['field_1'][$_num];
		
	  }
   }

    //продукты разделяются. какие нужно обновлять, добавлять, удалять
    $_products_group = get_group_products_array($data_mapping_primary_col);
   ?>
   <div id="products_process" class="round" style="width: 600px; height: 140px; border: 1px solid #7F9DB9; padding: 3px; overflow: auto;"></div>
   <?php
    $log_delete = set_products_delete($_products_group['delete'], $data_mapping_primary_col);
	unset($_products_group['delete']);

    $log_update = set_products_update($_products_group['update'], $data_mapping_primary_col); /* обновляем нужные продукты*/
    unset($_products_group['update']);

	
   $log_insert = set_products_insert($_products_group['insert'], $data_mapping_primary_col); /* добавляем нужные продукты, если primary_col еще не существует*/
	
	if ( !empty($log_update['count']) )
	{
	   echo '<div class="layer" style="color:green"><b>Обновлены товары ('.$log_update['count'].')</b><br><br>';
	   echo '</div>';
	}	
	
	if ( !empty($log_insert['count']) )
	{
	   echo '<div class="layer"  style="color:blue"><br><b>Добавлены товары ('.$log_insert['count'].')</b><br><br>';
	   echo '</div>';
	}
    
	if ( !empty($log_delete['count']))
	{
	   echo '<div class="layer" style="color:red"><br><b>Удалены товары ('.$log_delete['count'].')</b><br><br>';
	   echo '</div>';
	}
?>
<script>

</script>
<?php

}else
{
  echo 'error! no values!';
}
?>