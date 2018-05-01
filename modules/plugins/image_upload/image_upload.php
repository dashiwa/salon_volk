<?php


    add_action('insert_product', 'upload_insert_product');
    add_filter('news_product_add_tabs', 'upload_add_tabs');
    add_action('page_admin', 'upload_tab_page');
    add_action('page_admin', 'upload_file');
    add_action('page_admin', 'upload_images_edit_page');
    add_filter('check_image_tab', 'check_image_tab_func');

    add_filter('get_products_mo_images', 'get_products_mo_images_func');

    //add_filter('products_mo_image_block', 'products_mo_image_block_func', 100);
    add_filter('products_image_block', 'products_image_block_func');

    function products_mo_image_block_func($val)
    {
        global $img;
        global $products_mo_popup_link;
        global $product;

        $alt = $img['image_alt'];
        // if ( empty($alt) ) $alt =  $product->data['products_name'];

        $val['PRODUCTS_MO_IMAGE_BLOCK'] = '<a href="'.$products_mo_popup_link.'" title="'.$alt.'" class="zoom" rel="gallery-plants" target="_blank"><img src="'.http_path('images_info') . $img['image_name'].'" alt="'.$alt.'" /></a><br />'; 

        return $val;  
    }

    function products_image_block_func($_value)
    {
        global $image_pop;
        global $product;
        global $image;

        if ( !empty($image_pop) )
        {
            $_value = '<a href="'.$image_pop.'" title="'.$product->data['image_alt'].'" target="_blank" class="zoom" rel="gallery-plants"><img src="'.$image.'"  alt="'.$product->data['image_alt'].'" /></a>';
        }

        return $_value;
    }

    function get_products_mo_images_func($products_id)
    {
        $results = '';
        $mo_query = "select image_id, image_nr, image_name, image_alt from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . $products_id ."' ORDER BY image_nr";

        $products_mo_images_query = osDBquery($mo_query);

        while ($row = os_db_fetch_array($products_mo_images_query,true))
        {
            $results[ ($row['image_nr']-1) ] = $row;
        }

        return $results;
    }

    function check_image_tab_func($val)
    {
        if ( get_option('check_image_tab') == 'true')
        {
            return 'true';
        }
        else
        {

            return 'false';
        }
    }

    //установка плагина
    function image_upload_install()
    {
        global $db;

        add_option('check_image_tab', 'false','radio',  'array("false", "true")'); 

        //поля для комментариев 
        $field_query = $db->query('SHOW COLUMNS FROM '.DB_PREFIX.'products_images;');

        $fields = array();

        while ($field = $db->fetch_array($field_query, false) )
        {
            $fields[ $field['Field'] ] = 1;
        }                  

        if ( !isset($fields['image_alt']) )
        {
            //добавляем поле для комментария
            $db->query('ALTER TABLE `'.DB_PREFIX.'products_images` ADD `image_alt` VARCHAR( 255 ) NOT NULL;');
        }

        //поля для комментариев    
        $field_query = $db->query('SHOW COLUMNS FROM '.DB_PREFIX.'products;');

        $fields = array();

        while ($field = $db->fetch_array($field_query, false) )
        {
            $fields[ $field['Field'] ] = 1;
        }          

        if ( !isset($fields['image_alt']) )
        {
            //добавляем поле для комментария
            $db->query('ALTER TABLE `'.DB_PREFIX.'products` ADD `image_alt` VARCHAR( 255 ) NOT NULL;');
        }

    }

    function upload_insert_product()
    {
        global $db;
        if ( isset($_POST['se']) )
        {
            if ( isset($_SESSION['r'.$_POST['se']]) )
            {
                $i=0;
                foreach ($_SESSION['r'.$_POST['se']] as $name => $val )
                {
                    if ( $i == 0)
                    {
                        $db->query('update '.DB_PREFIX.'products set products_image="'.$db->input($name).'" where products_id='.(int)$_POST['product_id']);
                    }
                    else
                    {
                        $query = $db->query('select max(image_nr) as total from '.DB_PREFIX.'products_images where products_id="'.$db->input($_POST['product_id']).'"' );
                        $image_nr = $db->fetch_array($query, false);

                        $image_nr =  @$image_nr['total'];
                        $image_nr = (int)$image_nr;
                        $image_nr++;

                        $db->query('insert into '.DB_PREFIX.'products_images (products_id, image_name, image_nr) values ('.$db->input($_POST['product_id']).', "'.$db->input( $name ).'", "'.$image_nr.'");');

                    }
                    $i++;
                }

                unset($_SESSION['r'.$_POST['se']]);
            }
        }

    }

    function upload_images_edit_page()
    {
        include('image_upload.edit.php');
    }

    function upload_file()
    {
        include('image_upload.save.php');
    }

    function upload_tab_page()
    {
        include('image_upload.frame.php');
    }

    add_action('page_admin', 'image_upload_page');

    function upload_add_tabs($value)
    {
        $content = '';

        $_GET['lkey']= rand(1,10000000);

        $products_id= '';
        if ( isset($_GET['pID']) )
        {
            $products_id = '&products_id='.$_GET['pID'];    
        }

        $frame = '<input type="hidden" name="se" value="'.@$_GET['lkey'].'"><iframe width="1000" height="400px" name="content" src="plugins_page.php?page=upload_tab_page&lkey='.@$_GET['lkey'].$products_id.'" frameborder="0"></iframe>';
        $text = '

        <div id="tabs">
        <ul>
        <li><a href="#upload_image">Загрузка картинок</a></li>
        <li><a href="#edit_image">Редактор картинок</a></li>
        </ul>
        <div id="upload_image">
        '.        $frame.'
        </div>
        <div id="edit_image">
        Редактор
        </div>
        </div>    
        ';


        $value['values'][] = array(
        'tab_name' => 'Загрузка картинок', 
        'tab_content' => $frame);
        return  $value;  
    }

?>