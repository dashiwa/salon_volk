<?php
/*
#####################################
# ShopOS: Скрипты интернет-магазина
#  Copyright (c) 2008-2010
# http://www.shopos.ru
# Ver. 1.0.1
#####################################
*/

$box = new osTemplate;
$box->assign('tpl_path', _HTTP_THEMES_C); 
$box_content='';

  if (isset($_SESSION['customer_id'])) {
    $orders_query = os_db_query("select distinct op.products_id from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p where o.customers_id = '" . (int)$_SESSION['customer_id'] . "' and o.orders_id = op.orders_id and op.products_id = p.products_id and p.products_status = '1' group by products_id order by o.date_purchased desc limit " . MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX);
    if (os_db_num_rows($orders_query)) {



      $product_ids = '';
      while ($orders = os_db_fetch_array($orders_query)) {
        $product_ids .= $orders['products_id'] . ',';
      }
      $product_ids = substr($product_ids, 0, -1);

      $customer_orders_string = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';
      $products_query = os_db_query("select products_id, products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id in (" . $product_ids . ") and language_id = '" . (int)$_SESSION['languages_id'] . "' order by products_name");
      while ($products = os_db_fetch_array($products_query)) {
        $customer_orders_string .= '  <tr>' .
                                   '    <td class="infoBoxContents"><a href="' . os_href_link(FILENAME_PRODUCT_INFO, os_product_link($products['products_id'],$products['products_name'])) . '">' . $products['products_name'] . '</a></td>' .
                                   '    <td class="infoBoxContents" align="right" valign="top"><a href="' . os_href_link(basename($PHP_SELF), os_get_all_get_params(array('action')) . 'action=cust_order&pid=' . $products['products_id']) . '">' . os_image(DIR_WS_ICONS . 'cart.gif', ICON_CART) . '</a></td>' .
                                   '  </tr>';
      }
      $customer_orders_string .= '</table>';


    }
  }


    $box->assign('BOX_CONTENT', @$customer_orders_string);

    $box->caching = 0;
    $box->assign('language', $_SESSION['language']);
    $box_order_history= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_order_history.html');
    $osTemplate->assign('box_HISTORY',$box_order_history);
    
  ?>