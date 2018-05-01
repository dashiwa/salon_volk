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

    $orders_query = os_db_query("select orders_id from " . TABLE_ORDERS . " where customers_id = '" . (int)$_SESSION['customer_id'] . "' order by date_purchased desc limit 1");
    $orders = os_db_fetch_array($orders_query);
	$order_id = $orders['orders_id'];

	$analytics_affiliation = '';


// Get info for "city", "state", "country"
    $orders_query = os_db_query("select customers_city, customers_state, customers_country from " . TABLE_ORDERS . " where orders_id = '" . $order_id . "' AND customers_id = '" . (int)$_SESSION['customer_id'] . "'");
    $orders = os_db_fetch_array($orders_query);

    $totals_query = os_db_query("select value, class from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' order by sort_order");
// Set values for "total", "tax" and "shipping"
    $analytics_total = '';
    $analytics_tax = '';
    $analytics_shipping = '';
    
     while ($totals = os_db_fetch_array($totals_query)) 
	 {

        if ($totals['class'] == 'ot_total') 
		{
            $analytics_total = $totals['value'];
            $total_flag = 'true';
        } 
		else if ($totals['class'] == 'ot_tax') 
		{
            $analytics_tax = $totals['value'];
            $tax_flag = 'true';
        } else if ($totals['class'] == 'ot_shipping') 
		{
            $analytics_shipping = $totals['value'];
			{ if ($analytics_shipping === "0.0000") $analytics_shipping = ''; }
            $shipping_flag = 'true';
        }

     }

// Prepare the Analytics "Transaction line" string

	$transaction_string = '"' . $order_id . '"," ' . $analytics_affiliation . '","' . $analytics_total . '","' . $analytics_tax . '","' . $analytics_shipping . '","' . $orders['customers_city'] . '","' . $orders['customers_state'] . '","' . $orders['customers_country'] . '"';

// Get products info for Analytics "Item lines"

	$item_string = '';
    $items_query = os_db_query("select products_id, products_model, products_name, final_price, products_quantity from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $order_id . "' order by products_name");
    while ($items = os_db_fetch_array($items_query)) {
		$category_query = os_db_query("select p2c.categories_id, cd.categories_name from " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where p2c.products_id = '" . $items['products_id'] . "' AND cd.categories_id = p2c.categories_id AND cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
		$category = os_db_fetch_array($category_query);
		
	  $item_string .=  'pageTracker._addItem(' . '"' . $order_id . '","' . $items['products_id'] . '","' . $items['products_name'] . '","' . $category['categories_name'] . '","' . $items['final_price'] . '","' . $items['products_quantity'] . '"' . ');' . "\n";
    }

// ############## Google Analytics - end ###############

?>