
<?php
    global $db;
    //$seller_obj = $db->query('SELECT seller_id FROM '.DB_PREFIX.'seller where products_id='.$_GET['products_id']);

    if ( isset($_GET['find']) && $_GET['find'] == 'all' )
	{
	   $zone = '';
	}
	else
	{
	   $zone = get_zone_id( (int)$_SESSION['zone_id'], 'and p.zone_id in' );
	}
	
	$pro_info_obj = $db->query('SELECT products_name FROM `'.DB_PREFIX.'products_description` where products_id='.(int)$_GET['products_id'].' limit 1');
	$pro_info = $db->fetch_array($pro_info_obj, false);
	$pro_info = @$pro_info['products_name'];
	
	$seller_obj = $db->query('SELECT * FROM  `'.DB_PREFIX.'products_to_categories` pc
    left join `'.DB_PREFIX.'products_description` pd on (pc.products_id=pd.products_id) 
    left join `'.DB_PREFIX.'seller` s on (s.seller_id=pd.products_id)
    left join `'.DB_PREFIX.'products` p on (p.products_id=pd.products_id) WHERE s.products_id='.(int)$_GET['products_id'].' and pc.categories_id=29 '.$zone.';');
	
    $_seller = array();
    $seller = array();

    while ($__seller = $db->fetch_array($seller_obj, false) )
    {

        $seller[] = $__seller;
        $_seller[] = $__seller['seller_id'];

    }  

    $seller_array = array();

    foreach ($seller as $value)
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
            'products_name' => $value['products_name'],
            'desc' => $value['desc'],
            'price' => $value['price']
            );

        }
    }

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

        $query = $db->query('SELECT reviews_id, products_id, count(*) as total FROM `'.DB_PREFIX.'reviews` where  products_id in ('.implode(',', $_seller).')  group by products_id;');

        while ($q = $db->fetch_array($query, false) )
        {
            $seller_array[ $q['products_id'] ] ['reviews_count']  = $q['total'];
        }






    }

    if ( count($seller_array) > 0 )
    {
        global $osPrice;
		?>
<div class="mod_news">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td class="mod_blueleft"></td><td class="mod_bluecenter">
<div class="modtit_feat">
<?php 
echo 'Товар: '.$pro_info;  
 ?></div>
</td><td class="mod_blueright"></td></tr></table>
<div class="mod_moreinfo">

		<?php
		global $osPrice;
		echo 'Предложения от '.count($seller_array).' продавцов, '.get_zone_block('text').'<br><br>';  
        
        foreach ($seller_array as $seller_id => $value_seller)
        {
            $products_image = '';
            if ( !empty( $value_seller['products_image'] ) )
            {
                $products_image = $value_seller['products_image'];
            }
            else
            {
                $products_image = http_path('catalog').'images/product_images/noimage.gif';   
            }


            $price = $osPrice->Format($value_seller['price']*$osPrice->currencies[ $_SESSION['currency'] ]['value'], true);
            
            $reviews_count = $value_seller['reviews_count'];
            $reviews_count = (int)$reviews_count;

            echo '<div class="hr"></div><table border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
            <td style="text-align: center;" width="120px"><a href="product_info.php?products_id='.$seller_id.'"><img src="'.$products_image.'" border="0"/></a></td>
            
            <td style="text-align: center;" width="140"><div class="bl"><a href="product_info.php?products_id='.$seller_id.'">'.$value_seller['products_name'].'</a></div> <br /><span style="font-size: x-small;">'.$value_seller['param_address'].'<br /></span><a href="reviews.php?products_id='.$seller_id.'"><span style="font-size: x-small;">Отзывы ('.$reviews_count.')</span></a></td>
            <td width="120">
            <p align="center">'.$value_seller['param_phone'].'</p>

            </td>
            <td>
            <p><span style="font-size: x-small;">'.$value_seller['desc'].'  </span></p>
            </td>
            </tr>
            </tbody>
            </table>  
            
            <br />';
        }
		
		echo '
		<div class="mod_space">
 <div class="cont_tab">
  <div class="mod_row ">
  </div>
 </div>
</div>
</div>
		';
    }	
    else
    {
        echo 'нет предложений';
    }
	
?>		