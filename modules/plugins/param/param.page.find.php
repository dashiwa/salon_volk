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

    global $breadcrumb;
    global $osTemplate;
    global $listing_split;
    global $product;
    global $osPrice;
    global $PHP_SELF;
    global $_products_array;
    
    $listing_sql = "SELECT distinct p.products_id, p.products_price, p.products_model, p.products_quantity, p.products_shippingtime, p.products_fsk18, p.products_image, p.products_weight, p.products_tax_class_id, pd.products_name, pd.products_short_description, pd.products_description FROM ".DB_PREFIX."products AS p LEFT JOIN ".DB_PREFIX."products_description AS pd ON (p.products_id = pd.products_id) LEFT OUTER JOIN ".DB_PREFIX."products_attributes AS pa ON (p.products_id = pa.products_id) LEFT OUTER JOIN ".DB_PREFIX."products_options_values AS pov ON (pa.options_values_id = pov.products_options_values_id) LEFT OUTER JOIN ".DB_PREFIX."specials AS s ON (p.products_id = s.products_id) AND s.status = '1' LEFT OUTER JOIN ".DB_PREFIX."products_to_products_extra_fields AS pe ON (p.products_id = pe.products_id) left join ".DB_PREFIX."param pm on p.products_id = pm.product_id ".$param_join." WHERE ".$param_where." p.products_status = '1' AND pd.language_id = '1' GROUP BY p.products_id ORDER BY p.products_id";

    // print_r($listing_sql);
    //get_where_param_filter
    require (DIR_WS_MODULES.FILENAME_PRODUCT_LISTING);

    echo $module;

?>