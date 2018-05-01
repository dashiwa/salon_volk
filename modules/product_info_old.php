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

    $info = new osTemplate;
    $info->assign('tpl_path', _HTTP_THEMES_C);
    $group_check = '';



    if (!is_object($product) || !$product->isProduct()) 
    { // product not found in database
        $error = TEXT_PRODUCT_NOT_FOUND;
        include (_MODULES.FILENAME_ERROR_HANDLER);
    } 
    else 
    {
        if (ACTIVATE_NAVIGATOR == 'true')
            include (_MODULES.'product_navigator.php');

        os_db_query("update ".TABLE_PRODUCTS_DESCRIPTION." set products_viewed = products_viewed+1 where products_id = '".$product->data['products_id']."' and language_id = '".$_SESSION['languages_id']."'");

        $products_price = $osPrice->GetPrice($product->data['products_id'], $format = true, 1, $product->data['products_tax_class_id'], $product->data['products_price'], 1);


        if ($_SESSION['customers_status']['customers_status_show_price'] != '0') 
        {

            $_array = array('img' => 'button_in_cart.gif', 
            'href' => '', 
            'alt' => IMAGE_BUTTON_IN_CART, 
            'code' => '');

            $_array = apply_filter('button_in_cart', $_array);

            if (empty($_array['code']))
            {
                $_array['code'] = os_image_submit($_array['img'], $_array['alt']);
            }

            // fsk18
            if ($_SESSION['customers_status']['customers_fsk18'] == '1') {
                if ($product->data['products_fsk18'] == '0') {
                    $info->assign('ADD_QTY', os_draw_input_field('products_qty', '1', 'size="3"').' '.os_draw_hidden_field('products_id', $product->data['products_id']));

                    $info->assign('ADD_CART_BUTTON', $_array['code']);
                }
            } else {
                $info->assign('ADD_QTY', os_draw_input_field('products_qty', '1', 'size="3"').' '.os_draw_hidden_field('products_id', $product->data['products_id']));
                $info->assign('ADD_CART_BUTTON', $_array['code']);
            }
        }

        if ($product->data['products_fsk18'] == '1') {
            $info->assign('PRODUCTS_FSK18', 'true');
        }
        if (ACTIVATE_SHIPPING_STATUS == 'true') {
            $info->assign('SHIPPING_NAME', $main->getShippingStatusName($product->data['products_shippingtime']));
            $info->assign('SHIPPING_IMAGE', $main->getShippingStatusImage($product->data['products_shippingtime']));
        }

        $info->assign('FORM_ACTION', $_fancy_js.os_draw_form('cart_quantity', os_href_link(FILENAME_PRODUCT_INFO, os_get_all_get_params(array ('action')).'action=add_product')));
        $info->assign('FORM_END', '</form>');
        $info->assign('PRODUCTS_PRICE', $products_price['formated']);
        $info->assign('PRODUCTS_PRICE_PLAIN', $products_price['plain']);

        if ($product->data['products_vpe_status'] == 1 && $product->data['products_vpe_value'] != 0.0 && $products_price['plain'] > 0)
            $info->assign('PRODUCTS_VPE', $osPrice->Format($products_price['plain'] * (1 / $product->data['products_vpe_value']), true).TXT_PER.os_get_vpe_name($product->data['products_vpe']));
        $info->assign('PRODUCTS_ID', $product->data['products_id']);
        global $db;

        if ( $_SESSION['zone_id'] == 0)
        {
		   $__count = $db->query('select count(*) as total from '.DB_PREFIX.'seller where products_id='.$product->data['products_id']); 
			$__count = $db->fetch_array($__count, false);
			$__count = $__count['total'];
			
            $count = $db->query('select * from '.DB_PREFIX.'seller where products_id='.$product->data['products_id']);   
        }
        else
        {
		    $__count = $db->query('select count(*) as total from '.DB_PREFIX.'seller where products_id='.$product->data['products_id']); 
			$__count = $db->fetch_array($__count, false);
			$__count = $__count['total'];
			
           // $count = $db->query('select * from '.DB_PREFIX.'seller where products_id='.$product->data['products_id'].' and zone_id='.$_SESSION['zone_id']);   
			
			    $count = $db->query('SELECT * FROM  `'.DB_PREFIX.'products_to_categories` pc
    left join `'.DB_PREFIX.'products_description` pd on (pc.products_id=pd.products_id) 
    left join `'.DB_PREFIX.'seller` s on (s.seller_id=pd.products_id)
    left join `'.DB_PREFIX.'products` p on (p.products_id=pd.products_id) WHERE s.products_id='.$product->data['products_id'].'  '.get_zone_id( (int)$_SESSION['zone_id'], 'and p.zone_id in' ).';');
        }
	

        $coun = 0;
        $sum = 0;
        $min = 0;
        $max = 0;
        $_seller = array();
        $mcount = 0;
        while ($_count = $db->fetch_array($count, false) )
        {
            $_seller[] = $_count['seller_id'];

            $price = (int)$_count['price'];

            if ($coun == 0) 
            {
                $min = $price;
                $max = $price;
            }
            else
            {
                if ($min > $price and $price != 0 ) $min = $price;
                if ($max < $price) $max = $price;
            }

            if ( $price != 0 )
            {
                $sum += $_count['price'];
                $mcount++;
            }

            $coun++;
        }


        //  $sel = $db->query('select * from '.DB_PREFIX.'products_description pd join '.DB_PREFIX.'products p on (p.products_id=pd.products_id)  where pd.products_id in ('.$seller.')');
        /* while ($_sel = $db->fetch_array($sel, false) )
        {
        print_r($_sel);
        }
        */
        if ( !is_object($seller)) 
        {
            include(dir_path('catalog').'modules/plugins/seller/seller.class.php');
            $seller = new seller();  
        }

        $seller_array = array();

        foreach ($seller->seller as $value)
        {
            if  ( in_array( $value['products_id'], $_seller ) )
            {
                if ( !empty( $value['products_image'] ) )
                {
                    $image = http_path('images_thumbnail') . $value['products_image'];
                }
                else
                {
                    $image = '';
                }

                $seller_array [ $value['products_id'] ]  = array(

                'products_short_description' => $value['products_short_description'],
                'products_keywords' => $value['products_keywords'],
                'products_meta_title' => $value['products_meta_title'],
                'products_image' => $image,
                'products_meta_description' => $value['products_meta_description'],
                'products_meta_keywords' => $value['products_meta_keywords'],
                'products_name' => $value['products_name']
                );

            }
        }

        if ( $mcount != 0)
        { 
            $sum = round($sum / $mcount);
        }

        $coun = count($seller_array);
        $coun_c = $coun; 
        

        if ($coun == 1) $coun .= ' продавец'; 
        
        elseif ($coun >=2 and $coun <= 4) 
        {
            $coun .= ' продавца';
        }
        else  $coun .= ' продавцов';
        
        global $osPrice;
        $info->assign('PRODUCTS_PRICE_COUNT', $coun );
        $info->assign('PRODUCTS_PRICE_COUNT_ALL', $__count );
        $info->assign('PRODUCTS_PRICE_COUNT_P', $coun_c );
        $info->assign('PRODUCTS_PRICE_MAX', $osPrice->Format($max*$osPrice->currencies[ $_SESSION['currency'] ]['value'], true));
        $info->assign('PRODUCTS_PRICE_MIN', $osPrice->Format($min*$osPrice->currencies[ $_SESSION['currency'] ]['value'], true));
        $info->assign('PRODUCTS_PRICE_S', $osPrice->Format($sum*$osPrice->currencies[ $_SESSION['currency'] ]['value'], true));
        $info->assign('PRODUCTS_PRICE_S_P', $sum*$osPrice->currencies[ $_SESSION['currency'] ]['value']);

        $jquery =  '<script type="text/javascript">

        $(document).ready(function(){
        
        function get_info()
        {
           id = $("#zone_id option:selected").val();
           var off = $("#off");
           var pro = $("#pro");
        pro.fadeIn();
        off.fadeIn();

        id = $("#zone_id option:selected").val();

        $.ajax({
        type: "POST", url: "index.php?page=seller_offers_page_products_info&products_id='.$product->data['products_id'].'&zone_id="+id, data: "",
        complete: function(data)
        {
        off.html(data.responseText);
        pro.fadeOut();
        }
        });
        
        }
         
         $("#prod").click (

        function ()
        {
             get_info();
        }
        
        );
        
        $("#zone_id").change (
          function ()
        {
             get_info();
        }
        );
        


        }
        );


        </script>';


        $text = ' <table width="100%" cellpadding="5" cellspacing="0" border="0" >
        <tr>
        <td align="left" width="190">
        <div id="box_regionid">Регион:
        '. get_zone_block('', $jquery).'
        </div>
        </td> 
        </tr></tbody>
        </table>
        <div id="off" style="padding:10px;"></div>
        <div id="pro" style="padding:10px;display: none;"><font color="green">Загружается</font></div>
        ';

        $frame = '<iframe width="700" height="400px" name="content" src="index.php?page=seller_offers_page_products_info&products_id='.$product->data['products_id'].'" frameborder="0"></iframe>';

        $info->assign('buy', $text);


        if ( count( $_seller) > 0 )
        {
            $query = $db->query('SELECT p.product_id, pn.name_value, pn.name_label,  pv.value, pn.group_id
            FROM '.DB_PREFIX.'param p
            LEFT JOIN '.DB_PREFIX.'param_name pn ON ( p.name_id = pn.name_id ) 
            LEFT JOIN '.DB_PREFIX.'param_value pv ON ( p.value_id = pv.value_id ) 
            WHERE p.product_id in ('.implode(',', $_seller).') and pn.group_id=1;');

            while ($_query = $db->fetch_array($query, false) )
            {
                $seller_array[ $_query['product_id'] ] [ $_query['name_label'] ] = $_query['value'];  
            }   
        }     

        $info->assign('PRODUCTS_NAME', $product->data['products_name']);
        $info->assign('seller_array', $seller_array);
        if ($_SESSION['customers_status']['customers_status_show_price'] != 0) {
            // price incl tax
            $tax_rate = $osPrice->TAX[$product->data['products_tax_class_id']];				
            $tax_info = $main->getTaxInfo($tax_rate);
            $info->assign('PRODUCTS_TAX_INFO', $tax_info);
            $info->assign('PRODUCTS_SHIPPING_LINK',$main->getShippingLink());
        }
        $info->assign('PRODUCTS_MODEL', $product->data['products_model']);
        $info->assign('PRODUCTS_EAN', $product->data['products_ean']);
        $info->assign('PRODUCTS_QUANTITY', $product->data['products_quantity']);
        $info->assign('PRODUCTS_WEIGHT', $product->data['products_weight']);
        $info->assign('PRODUCTS_STATUS', $product->data['products_status']);
        $info->assign('PRODUCTS_ORDERED', $product->data['products_ordered']);
        $info->assign('PRODUCTS_PRINT', '<img src="'._HTTP_THEMES_C.'buttons/'.$_SESSION['language'].'/print.gif"  style="cursor:hand" onclick="javascript:window.open(\''.os_href_link(FILENAME_PRINT_PRODUCT_INFO, 'products_id='.$product->data['products_id']).'\', \'popup\', \'toolbar=0, scrollbars=yes, width=640, height=600\')" alt="" />');
        $info->assign('PRODUCTS_DESCRIPTION', stripslashes($product->data['products_description']));
        $info->assign('PRODUCTS_SHORT_DESCRIPTION', stripslashes($product->data['products_short_description']));
        $image = '';

        $info->assign('ASK_PRODUCT_QUESTION', '<img src="'._HTTP_THEMES_C.'buttons/'.$_SESSION['language'].'/button_ask_a_question.gif" style="cursor:hand" onclick="javascript:window.open(\''.os_href_link(FILENAME_ASK_PRODUCT_QUESTION, 'products_id='.$product->data['products_id']).'\', \'popup\', \'toolbar=0, width=640, height=600\')" alt="" />');

        /*$cat_query = osDBquery("SELECT
        categories_name
        FROM ".TABLE_CATEGORIES_DESCRIPTION." 
        WHERE categories_id='".$current_category_id."'
        and language_id = '".(int) $_SESSION['languages_id']."'"
        );
        $cat_data = os_db_fetch_array($cat_query, true);*/

        $cat_data = get_categories_info ($current_category_id);	

        $manufacturer_query = osDBquery("select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$_SESSION['languages_id'] . "'), " . TABLE_PRODUCTS . " p  where p.products_id = '" . $product->data['products_id'] . "' and p.manufacturers_id = m.manufacturers_id");
        $manufacturer = os_db_fetch_array($manufacturer_query,true);

        $info->assign('CATEGORY', $cat_data['categories_name']);
        $info->assign('MANUFACTURER',$manufacturer['manufacturers_name']);

        if ($product->data['products_image'] != '')
            $image = dir_path('images_info').$product->data['products_image'];

        $_check_image = 'true';

        if (!file_exists($image)) 
        {
            $image = http_path('images_info').'../noimage.gif';
            $_check_image = 'false';
        }
        else 
        {
            $image = http_path('images_info').$product->data['products_image'];
        }

        $info->assign('PRODUCTS_IMAGE', $image);

        $image_pop = http_path('images_popup').$product->data['products_image'];

        if ($_check_image=='true')
        {
            $_products_image_block = '<a href="'.$image_pop.'" title="'.$product->data['products_name'].'" class="zoom" target="_blank" rel="gallery-plants"><img src="'.$image.'"  alt="'.$product->data['products_name'].'" /><img src="'._HTTP_THEMES_C.'img/zoom.gif" alt="zoom" border="0" width="16" height="12" /></a>';
        }
        else
        {
            $_products_image_block = '<img src="'.$image.'"  alt="'.$product->data['products_name'].'" />';
        }

        $_products_image_block = apply_filter('products_image_block', $_products_image_block);
        $info->assign('PRODUCTS_IMAGE_BLOCK', $_products_image_block);

        $info->assign('PRODUCTS_POPUP_IMAGE', $image_pop);

        //mo_images - by Novalis@eXanto.de
        if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') {
            $connector = '/';
        }else{
            $connector = '&';
        }
        $products_popup_link = os_href_link(FILENAME_POPUP_IMAGE, 'pID='.$product->data['products_id'].$connector.'imgID=0');
        if (!is_file(dir_path('images_popup').$product->data['products_image'])) $products_popup_link = '';
        $info->assign('PRODUCTS_POPUP_LINK', $products_popup_link);

        $mo_images = os_get_products_mo_images($product->data['products_id']);

        if ($mo_images != false) 
        {
            $info->assign('PRODUCTS_MO_IMAGES', $mo_images);

            foreach ($mo_images as $img) 
            {
                $products_mo_popup_link = http_path('images_popup') . $img['image_name'];
                if (!file_exists(dir_path('images_popup').$img['image_name'])) $products_mo_popup_link = '';

                if ( is_file( dir_path('images_info') . $img['image_name'] ) )
                {
                    $_PRODUCTS_MO = array(
                    'PRODUCTS_MO_IMAGE' => http_path('images_info') . $img['image_name'],
                    'PRODUCTS_MO_POPUP_IMAGE' => $products_mo_popup_link,
                    'PRODUCTS_MO_IMAGE_BLOCK' => '<a href="'.$products_mo_popup_link.'" title="'.$product->data['products_name'].'" class="zoom" rel="gallery-plants" target="_blank"><img src="'.http_path('images_info') . $img['image_name'].'" alt="'.$product->data['products_name'].'" /><br /><img src="'._HTTP_THEMES_C.'img/zoom.gif" alt="zoom" border="0" width="16" height="12" /></a>',
                    'PRODUCTS_MO_POPUP_LINK' => $products_mo_popup_link);

                    $_PRODUCTS_MO = apply_filter('products_mo_image_block', $_PRODUCTS_MO);

                    $mo_img[] = $_PRODUCTS_MO;
                }

            }

            $info->assign('mo_img', $mo_img);
            $info->assign('mo_img_count', count($mo_img));
        }

        //mo_images EOF
        $discount = 0.00;
        if ($_SESSION['customers_status']['customers_status_public'] == 1 && $_SESSION['customers_status']['customers_status_discount'] != '0.00') 
        {
            $discount = $_SESSION['customers_status']['customers_status_discount'];
            if ($product->data['products_discount_allowed'] < $_SESSION['customers_status']['customers_status_discount'])
                $discount = $product->data['products_discount_allowed'];
            if ($discount != '0.00')
                $info->assign('PRODUCTS_DISCOUNT', $discount.'%');
        }

        include (_MODULES.'product_attributes.php');
        include (_MODULES.'product_reviews.php');

		$info->assign('reviews_count', $product->getReviewsCount());
		
        if (os_not_null($product->data['products_url']))
            $info->assign('PRODUCTS_URL', sprintf(TEXT_MORE_INFORMATION, os_href_link(FILENAME_REDIRECT, 'action=product&id='.$product->data['products_id'], 'NONSSL', true, false)));

        if ($product->data['products_date_available'] > date('Y-m-d H:i:s')) {
            $info->assign('PRODUCTS_DATE_AVIABLE', sprintf(TEXT_DATE_AVAILABLE, os_date_long($product->data['products_date_available'])));

        } else {
            if ($product->data['products_date_added'] != '0000-00-00 00:00:00')
            {
                $_padd  = sprintf(TEXT_DATE_ADDED, os_date_long($product->data['products_date_added']));
                $_padd = apply_filter('products_added', $_padd);
                $info->assign('PRODUCTS_ADDED', $_padd);
            }

        }

        if ($_SESSION['customers_status']['customers_status_graduated_prices'] == 1)
            include (_MODULES.FILENAME_GRADUATED_PRICE);

        $extra_fields_query = osDBquery("
        SELECT pef.products_extra_fields_status as status, pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value
        FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef
        LEFT JOIN  ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf
        ON ptf.products_extra_fields_id=pef.products_extra_fields_id
        WHERE ptf.products_id=". $product->data['products_id'] ." and ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".$_SESSION['languages_id']."')
        ORDER BY products_extra_fields_order");

        while ($extra_fields = os_db_fetch_array($extra_fields_query,true)) {
            if (! $extra_fields['status'])  // show only enabled extra field
                continue;

            $extra_fields_data[] = array (
            'NAME' => $extra_fields['name'], 
            'VALUE' => $extra_fields['value']
            );

        }

        $info->assign('extra_fields_data', $extra_fields_data);

        include(_MODULES.FILENAME_PRODUCTS_MEDIA);
        include(_MODULES.FILENAME_ALSO_PURCHASED_PRODUCTS);
        include(_MODULES.FILENAME_CROSS_SELLING);

        if ($product->data['product_template'] == '' or $product->data['product_template'] == 'default') 
        {
            $files = array ();
            if ($dir = opendir(_THEMES_C.'module/product_info/')) 
            {
                while ($file = readdir($dir)) 
                {
                    if (is_file(_THEMES_C.'module/product_info/'.$file) and ($file != "index.html") and (substr($file, 0, 1) !=".")) 
                    {
                        $files[] = $file;
                    } //if
                } // while

                sort($files);
                closedir($dir);
            }
            $product->data['product_template'] = $files[0];
        }

        $i = count($_SESSION['tracking']['products_history']);
        if ($i > 6) {
            array_shift($_SESSION['tracking']['products_history']);
            $_SESSION['tracking']['products_history'][6] = $product->data['products_id'];
            $_SESSION['tracking']['products_history'] = array_unique($_SESSION['tracking']['products_history']);
        } else {
            $_SESSION['tracking']['products_history'][$i] = $product->data['products_id'];
            $_SESSION['tracking']['products_history'] = array_unique($_SESSION['tracking']['products_history']);
        }

        $info->assign('language', $_SESSION['language']);

        //plugins
        if (isset($os_action['products_info']) && !empty($os_action['products_info']))
        {
            foreach ($os_action['products_info'] as $_info => $_pr)
            {
                if (function_exists($_info))
                {
                    $p->name = $os_action_plug[$_info];	
                    $p->group = $p->info[$p->name]['group'];
                    $p->set_dir();

                    $_products_info_val = $_info();

                    if (isset($_products_info_val['name']) && $_products_info_val['value'])
                    {
                        $info->assign($_products_info_val['name'] , $_products_info_val['value']);
                    }
                }
            }
        }
        //---////plugins
        // set cache ID

        if (!CacheCheck()) 
        {
            $info->caching = 0;
            $product_info = $info->fetch(CURRENT_TEMPLATE.'/module/product_info/'.$product->data['product_template']);
        } 
        else 
        {
            $info->caching = 1;
            $info->cache_lifetime = CACHE_LIFETIME;
            $info->cache_modified_check = CACHE_CHECK;
            $cache_id = $product->data['products_id'].$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
            $product_info = $info->fetch(CURRENT_TEMPLATE.'/module/product_info/'.$product->data['product_template'], $cache_id);
        }

    }
    $osTemplate->assign('main_content', $product_info);
?>