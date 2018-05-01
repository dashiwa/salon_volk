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

function get_var($name, $default = 'none') {
  return (isset($_GET[$name])) ? $_GET[$name] : ((isset($_POST[$name])) ? $_POST[$name] : $default);
}

require('includes/top.php');

$inv_id = get_var('inv_id');
$out_summ = get_var('out_summ');
$crc = get_var('crc');

// checking and handling
if (strtoupper(md5("$out_summ:$inv_id:".MODULE_PAYMENT_ROBOXCHANGE_PASSWORD2)) == strtoupper($crc)) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_ROBOXCHANGE_ORDER_STATUS);
  os_db_perform(DB_PREFIX.'orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_ROBOXCHANGE_ORDER_STATUS,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'Roboxchange accepted this order payment');
  os_db_perform(DB_PREFIX.'orders_status_history', $sql_data_arrax);

  echo 'OK'.$inv_id;
}

else
{
   echo 'shopos error: payment is not confirmed.';
}
?>