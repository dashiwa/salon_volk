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
    
    function banner_status()
    {
        global $banner;

        if ( !is_object($banner)) $banner = new banner();
        
        $_var = 'main_page=banner_manager_page&';

        if ($_GET['action']) 
        {
            switch ($_GET['action']) 
            {
                case 'setflag':
                    if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) 
                    {
                        $banner->set_status( $_GET['bID'], $_GET['flag'] );

                    } 
                    else 
                    {

                    }

                    os_redirect( os_href_link(FILENAME_PLUGINS_PAGE, $_var.'_page=' . $_GET['_page'] . '&bID=' . (int)$_GET['bID']) );
                    break;
                case 'insert':
                case 'update':
                    $banners_id = os_db_prepare_input($_POST['banners_id']);
                    $banners_title = os_db_prepare_input($_POST['banners_title']);
                    $banners_url = os_db_prepare_input($_POST['banners_url']);
                    $new_banners_group = os_db_prepare_input($_POST['new_banners_group']);
                    $banners_group = (empty($new_banners_group)) ? os_db_prepare_input($_POST['banners_group']) : $new_banners_group;
                    $html_text = os_db_prepare_input($_POST['html_text']);
                    $banners_image_local = os_db_prepare_input($_POST['banners_image_local']);
                    $banners_image_target = os_db_prepare_input($_POST['banners_image_target']);
                    $db_image_location = '';

                    $banner_error = false;
                    if (empty($banners_title)) 
                    {
                        $banner_error = true;
                    }

                    if (empty($banners_group)) {
                        $banner_error = true;
                    }

                    if (empty($html_text)) 
                    {
                        if (!$banners_image = &os_try_upload('banners_image', dir_path('images').'banner/' . $banners_image_target) && $_POST['banners_image_local'] == '') {
                            $banner_error = true;
                        }
                    }

                    if (!$banner_error) {
                        $db_image_location = (os_not_null($banners_image_local)) ? $banners_image_local : $banners_image_target . $banners_image->filename;
                        $sql_data_array = array('banners_title' => $banners_title,
                        'banners_url' => $banners_url,
                        'banners_image' => $db_image_location,
                        'banners_group' => $banners_group,
                        'banners_html_text' => $html_text);

                        if ($_GET['action'] == 'insert') {
                            $insert_sql_data = array('date_added' => 'now()',
                            'status' => '1');
                            $sql_data_array = os_array_merge($sql_data_array, $insert_sql_data);
                            os_db_perform(TABLE_BANNERS, $sql_data_array);
                            $banners_id = os_db_insert_id();
                        } elseif ($_GET['action'] == 'update') {
                            os_db_perform(TABLE_BANNERS, $sql_data_array, 'update', 'banners_id = \'' . $banners_id . '\'');
                        }

                        if ($_POST['expires_date']) 
                        {
                            $expires_date = os_db_prepare_input($_POST['expires_date']);
                            list($day, $month, $year) = explode('/', $expires_date);

                            $expires_date = $year .
                            ((strlen($month) == 1) ? '0' . $month : $month) .
                            ((strlen($day) == 1) ? '0' . $day : $day);

                            os_db_query("update " . TABLE_BANNERS . " set expires_date = '" . os_db_input($expires_date) . "', expires_impressions = null where banners_id = '" . $banners_id . "'");
                        } 
                        elseif ($_POST['impressions']) {
                            $impressions = os_db_prepare_input($_POST['impressions']);
                            os_db_query("update " . TABLE_BANNERS . " set expires_impressions = '" . os_db_input($impressions) . "', expires_date = null where banners_id = '" . $banners_id . "'");
                        }

                        if ($_POST['date_scheduled']) {
                            $date_scheduled = os_db_prepare_input($_POST['date_scheduled']);
                            list($day, $month, $year) = explode('/', $date_scheduled);

                            $date_scheduled = $year .
                            ((strlen($month) == 1) ? '0' . $month : $month) .
                            ((strlen($day) == 1) ? '0' . $day : $day);

                            os_db_query("update " . TABLE_BANNERS . " set status = '0', date_scheduled = '" . os_db_input($date_scheduled) . "' where banners_id = '" . $banners_id . "'");
                        }

                        os_redirect(os_href_link(FILENAME_PLUGINS_PAGE, $_var.'_page=' . $_GET['_page'] . '&bID=' . $banners_id));
                    } else {
                        $_GET['action'] = 'new';
                    }
                    break;
                case 'deleteconfirm':
                    $banners_id = os_db_prepare_input($_GET['bID']);
                    $delete_image = os_db_prepare_input($_POST['delete_image']);

                    if ($delete_image == 'on') {
                        $banner_query = os_db_query("select banners_image from " . TABLE_BANNERS . " where banners_id = '" . os_db_input($banners_id) . "'");
                        $banner = os_db_fetch_array($banner_query);
                        if (is_file(dir_path('images') . $banner['banners_image'])) 
                        {
                            if (is_writeable(dir_path('images') . $banner['banners_image'])) 
                            {
                                unlink(dir_path('images') . $banner['banners_image']);
                            } 
                            else 
                            {
                                //
                            }
                        } else {
                            //
                        }
                    }

                    os_db_query("delete from " . TABLE_BANNERS . " where banners_id = '" . os_db_input($banners_id) . "'");
                    os_db_query("delete from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . os_db_input($banners_id) . "'");


                    os_redirect( os_href_link(FILENAME_PLUGINS_PAGE, $_var.'_page=' . $_GET['page']) );
                    break;
            }
        }

    }
?>