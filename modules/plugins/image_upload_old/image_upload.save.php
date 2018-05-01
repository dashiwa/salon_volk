<?php
   // $f = fopen( plugdir().'log.txt', 'w');
   /// ob_start();
   //  print_r($_SESSION);
   // print_r($_POST);




    if ( isset($_POST['lkey']) && !empty($_POST['lkey']) )
    {
        $_SESSION['b'] ++;
        if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) 
        {
            header("HTTP/1.1 500 File Upload Error");
            if (isset($_FILES["Filedata"])) {
                echo $_FILES["Filedata"]["error"];
            }
            exit(0);
        }
        else
        {


            move_uploaded_file($_FILES["Filedata"]["tmp_name"], dir_path('catalog').'images/product_images/original_images/'.$_FILES["Filedata"]["name"]);

            include (dir_path_admin('class').FILENAME_IMAGEMANIPULATOR);  



            //	require_once(dir_path('func_admin') . 'trumbnails_add_funcs.php');

            //$files = os_get_files_in_dir( dir_path('images_original') );



            $products_image_name = $_FILES["Filedata"]["name"];

            @require(dir_path_admin('includes') . 'product_thumbnail_images.php');
            @require(dir_path_admin('includes') . 'product_info_images.php');
            @require(dir_path_admin('includes') . 'product_popup_images.php');

            global $db;
            
            if ( isset( $_POST['products_id']) )
            {
                $query = $db->query('select  max(image_nr) as total from '.DB_PREFIX.'products_images where products_id="'.$db->input($_POST['products_id']).'"' );
                $image_nr = $db->fetch_array($query, false);

                $image_nr =  @$image_nr['total'];
                $image_nr = (int)$image_nr;
                $image_nr++;

                $db->query('insert into '.DB_PREFIX.'products_images (products_id, image_name, image_nr) values ('.$db->input($_POST['products_id']).', "'.$db->input($_FILES["Filedata"]["name"]).'", "'.$image_nr.'");');
            }
            else
            {
                if (!isset($_SESSION[ 'r'.$_POST['lkey'] ]) )
                {
                    $_SESSION[ 'r'.$_POST['lkey'] ] = array();
                }

                $_SESSION[ 'r'.$_POST['lkey'] ][ $_FILES["Filedata"]["name"] ]  = 1;
            }


            // $_SESSION[ $_POST['lkey'] ] [] = $_FILES["Filedata"]["name"];
        }
    }
    else
    {
        header("HTTP/1.1 500 File Upload Error");
    }

   // $m_content = ob_get_contents();
   /// ob_end_clean();   

   // fwrite($f, $m_content);
   // fclose($f);
?>