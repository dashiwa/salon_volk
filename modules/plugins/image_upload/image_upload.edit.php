<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <link href="<?php echo http_path('catalog'); ?>admin/themes/default/styles/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugurl(); ?>default.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <a style="text-decoration:underline;padding-top:5px;padding-left:5px;" href="<?php echo page_admin('upload_tab_page').'&lkey='.$_GET['lkey'].'&products_id='.(int)$_GET['products_id']; ?>">Загрузка картинок</a><br />
        <div id="content">
            <form action="<?php echo 'plugins_page.php?page=upload_images_edit_page&products_id='.(int)$_GET['products_id'].'&action=save_image_alt"'; ?>" method="post">

            <span class="button" style="position:absolute; left:40%;top:0px;"><button type="submit"/>Сохранить</button></span>
            <?php  
                global $db;
                if ( isset($_GET['action']) && $_GET['action'] == 'remove' )
                {

                    $__products = $db->query('select products_id, image_name from '.DB_PREFIX.'products_images where image_id='.(int)$_GET['image_id'].';'); 
                    $_pro = $db->fetch_array($__products, false);

                    if ( isset($_pro['image_name']) )
                    {
                        os_delete_file( dir_path('images_popup') . $_pro['image_name'] );
                        os_delete_file( dir_path('images_thumbnail').$_pro['image_name'] );
                        os_delete_file( dir_path('images_original').$_pro['image_name'] );
                        os_delete_file( dir_path('images_info').$_pro['image_name'] );
                        $db->query('delete from '.DB_PREFIX.'products_images where image_id='.(int)$_GET['image_id'].';'); 

                        echo '<font color="red">Картинка '.$_pro['image_name'].' удалена</font><br>';
                    }
                }

                //remove_main
                if ( isset($_GET['action']) && $_GET['action'] == 'remove_main' )
                {
                    $_products = $db->query('select products_id, products_image from '.DB_PREFIX.'products where products_id='.(int)$_GET['products_id'].';');
                    $_pro = $db->fetch_array($_products, false);

                    if ( !empty(  $_pro['products_image'] ))
                    {
                        if ( is_file(dir_path('images_popup') . $_pro['products_image']) )
                        {
                            @ os_delete_file( dir_path('images_popup') . $_pro['products_image']);
                        }

                        if ( is_file(dir_path('images_thumbnail').$_pro['products_image']) )
                        {
                            @ os_delete_file(dir_path('images_thumbnail').$_pro['products_image']);
                        }

                        if ( is_file(dir_path('images_original').$_pro['products_image']) )
                        {
                            @ os_delete_file(dir_path('images_original').$_pro['products_image']);
                        }

                        if ( is_file(dir_path('images_info').$_pro['products_image']) )
                        {
                            @os_delete_file(dir_path('images_info').$_pro['products_image']);
                        }

                        $db->query('update '.DB_PREFIX.'products set products_image="" where products_id='.(int)$_GET['products_id'].';'); 

                        echo '<font color="red">Картинка '.$_pro['products_image'].' удалена</font><br>';
                    }
                }

                //меняем главную картинку
                if ( isset($_GET['action']) && $_GET['action'] == 'main' )
                {
                    $_products = $db->query('select products_id, products_image from '.DB_PREFIX.'products where products_id='.(int)$_GET['products_id'].';');
                    $_pro = $db->fetch_array($_products, false);

                    $main_image= '';
                    if ( !empty( $_pro['products_image'] ))
                    {
                        $main_image =  @$_pro['products_image'];
                    }

                    $main_image = @trim($main_image);

                    $__products = $db->query('select products_id, image_name from '.DB_PREFIX.'products_images where image_id='.(int)$_GET['image_id'].' limit 1;');
                    $pro = $db->fetch_array($__products, false);

                    if ( !empty($pro['image_name']) ) 
                    {

                        $db->query('update '.DB_PREFIX.'products set products_image="'.$pro['image_name'].'" where products_id='.(int)$_GET['products_id'].';'); 

                        if ( !empty($main_image) )
                        {
                            $db->query('update '.DB_PREFIX.'products_images set image_name="'.$main_image.'" where image_id='.(int)$_GET['image_id'].' limit 1;');
                            //echo 'update '.DB_PREFIX.'products_images set image_name="'.$main_image.'" where image_id='.(int)$_GET['image_id'].' limit 1;';
                        } 
                        else
                        {
                            $db->query('delete from '.DB_PREFIX.'products_images where image_id='.(int)$_GET['image_id']);
                            // echo 'delete from '.DB_PREFIX.'products_images where image_id='.(int)$_GET['image_id'];
                        }

                        echo 'Главная картинка установлена<br>';
                    }
                    else
                    {
                        echo 'Главная картинка не установлена<br>';
                    }
                }   

                //сохраняем комментарии к картинкам
                if ( isset($_GET['action']) && $_GET['action'] == 'save_image_alt' ) 
                {
                    if ( is_array($_POST['image_edit']) && count($_POST['image_edit']) > 0 )
                    {
                        $i=0;
                        foreach ($_POST['image_edit'] as $id => $value)
                        {
                            if ( $id != 'main')
                            {
                                $i++;
                                $db->query('update '.DB_PREFIX.'products_images set image_alt="'.$db->input($value).'" where image_id='.(int)$id.';');
                            }
                            else
                            {
                                $i++;
                                $db->query('update '.DB_PREFIX.'products set image_alt="'.$db->input($value).'" where products_id='.(int)$_GET['products_id'].';');

                            }

                        }  

                        echo '<font color="green"><b>Сохранены описания картинок ('.$i.')</b></font><br>';
                    } 
                }

                if ( isset($_GET['products_id']))
                {
                    $_products = $db->query('select products_id, products_image, image_alt from '.DB_PREFIX.'products where products_id='.(int)$_GET['products_id'].';');
                    $pro = $db->fetch_array($_products, false);

                    if ( empty($pro['products_image']))
                    {
                        echo '<font color="red"><b>Главная картинка не установлена</b></font><br>';
                    }
                    else
                    {
                        echo '<b>Главная:</b> <font color="red"><b>'.$pro['products_image'].'</b></font><br>';
                        echo '<table cellspacing="6" cellpadding="6" border="1">';

                        if ( is_file( dir_path('images_thumbnail'). $pro['products_image'] ) )
                        {

                            echo '<tr><td><img width="150px" src="'.http_path('images_thumbnail'). $pro['products_image'].'" /><br><br></td><td valign="middle">&nbsp;<a href="plugins_page.php?page=upload_images_edit_page&image_id='.$pro['image_id'].'&products_id='.$_GET['products_id'].'&action=remove_main"><font color="red">Удалить</font></a>

                            <br><br>&nbsp;<i>Описание</i><br /><input class="round" name="image_edit[main]" value="'.$pro['image_alt'].'">


                            </td></tr>'; 
                        }  
                        else if ( is_file( dir_path('images_popup'). $pro['products_image'] ) )
                            {
                                echo '<tr><td><img width="150px" src="'.http_path('images_popup'). $pro['products_image'].'" /><br><br></td><td valign="middle">&nbsp;<a href="plugins_page.php?page=upload_images_edit_page&image_id='.$pro['image_id'].'&products_id='.$_GET['products_id'].'&action=remove_main"><font color="red">Удалить</font></a>

                                <br><br>&nbsp;<i>Описание</i><br /><input class="round" name="image_edit[main]" value="'.$pro['image_alt'].'">
                                </td></tr>'; 
                            }


                            echo '</table>';    
                    }

                    $_products = $db->query('select products_id, image_name, image_id, image_alt from '.DB_PREFIX.'products_images where products_id='.(int)$_GET['products_id'].';');

                    if ( $db->num_rows($_products) > 0)
                    {
                        echo '<br><b>Доп. картинки:</b>';
                    }

                    echo '<table cellspacing="6" cellpadding="6" border="1">';


                    while ($pro = $db->fetch_array($_products, false))
                    {
                        if ( is_file( dir_path('images_thumbnail'). $pro['image_name'] ) )
                        {

                            echo '<tr><td><i>'.$pro['image_name'].'</i><br><img width="100px" src="'.http_path('images_thumbnail'). $pro['image_name'].'" /><br><br></td><td valign="middle"><br />&nbsp;<a href="plugins_page.php?page=upload_images_edit_page&image_id='.$pro['image_id'].'&products_id='.$_GET['products_id'].'&action=remove"><font color="red">Удалить</font></a>

                            <br>&nbsp;<a href="plugins_page.php?page=upload_images_edit_page&image_id='.$pro['image_id'].'&products_id='.$_GET['products_id'].'&action=main"><font color="blue">Главная</font></a>
                            <br><br>&nbsp;<i>Описание</i><br /><input class="round" name="image_edit['.$pro['image_id'].']" value="'.$pro['image_alt'].'">
                            </td></tr>'; 
                        }
                        else
                        {
                            echo '<tr><td><i>'.$pro['image_name'].'</i><br><img width="100px" src="'.http_path('images_popup'). $pro['image_name'].'" /><br><br></td><td valign="middle"><br />&nbsp;<a href="plugins_page.php?page=upload_images_edit_page&image_id='.$pro['image_id'].'&products_id='.$_GET['products_id'].'&action=remove"><font color="red">Удалить</font></a>

                            <br>&nbsp;<a href="plugins_page.php?page=upload_images_edit_page&image_id='.$pro['image_id'].'&products_id='.$_GET['products_id'].'&action=main"><font color="blue">Главная</font></a>
                            <br><br>&nbsp;<i>Описание</i><br /><input class="round" name="image_edit['.$pro['image_id'].']" value="'.$pro['image_alt'].'">
                            </td></tr>'; 
                        }


                    }
                    echo '</table>

                    <span class="button" style="position:absolute; left:40%;"><button type="submit"/>Сохранить</button></span>
                    </form>';

                }
                else
                {

                }
            ?>
        </div>
    </body>
</html>
