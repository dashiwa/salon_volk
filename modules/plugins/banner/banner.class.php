<?php
    class banner extends db
    { 
        var $banners = '';
        var $banners_info = array();

        //возвращает массив  всех баннеров
        function all()
        {
            if ( empty($this->banners) )
            {
                //группы баннеров
                $_group = $this->get_group();

                if ( count($_group) > 0 )
                {
                    foreach ($_group as $value)
                    {
                        if ( $banner = $this->exists( $value) ) 
                        {
                            $m = strtolower( $value );
                            if ( $m == 'banner' )
                            {
                                $this->banners [ strtoupper($m) ] = $this->display('static', $banner);   
                            }
                            else
                            {
                                $m = 'banner_'.$m;
                                $this->banners [ $m ] = $this->display ('static', $banner);   
                            }

                        }
                    }
                }

                if ( count( $this->banners ) == 0 ) 
                {
                    $this->banners = 1;
                    return array ();
                }
                else
                {
                    return $this->banners;
                }
            }
            else
            {
                if ( $this->banners == 1 )
                {
                    return array();
                }
                else
                {
                    return $this->banners;
                }
            }
        }

        //проверяет. существует ли баннер
        function exists ($group) 
        {
            if ( $this->banners_info == 1) return false;
            
            $banner_count = count( $this->banners_info[$group] );

            if ( $banner_count == 1)
            {
                return $this->banners_info[$group][0];
            }
            elseif ($banner_count == 0)
            {
                return false;
            }
            else
            {
                //выводим случайны баннер
                return $this->banners_info[$group][ os_rand(0, $banner_count-1) ]; 
            }
            /* elseif ($action == 'static') 
            {
            $banner_query = $this->query("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . $identifier . "'");

            return $this->fetch_array($banner_query);
            } 
            */

        }

        //вывод код баннера
        function display($action, $identifier) 
        {
            if ($action == 'dynamic') 
            {
                $banners_query = $this->query("select count(*) as count from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
                $banners = $this->fetch_array($banners_query);

                if ($banners['count'] > 0) 
                {
                    $banner = os_random_select("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
                } 
                else 
                {
                    return '<b>ShopOS ERROR! (os_display_banner(' . $action . ', ' . $identifier . ') -> No banners with group \'' . $identifier . '\' found!</b>';
                }
            } 
            elseif ($action == 'static') 
            {
                if (is_array($identifier)) 
                {
                    $banner = $identifier;
                } 
                else 
                {
                    $banner_query = $this->query("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . $identifier . "'");

                    if ( $this->num_rows($banner_query)) 
                    {
                        $banner = $this->fetch_array($banner_query);
                    } 
                }
            } 

            if (os_not_null($banner['banners_html_text'])) 
            {
                $banner_string = $banner['banners_html_text'];
            } 
            else 
            {
                $banner_string = '<a href="' . os_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner['banners_id']) . '" onclick="window.open(this.href); return false;">' . os_image(http_path('images').'banner/' . $banner['banners_image'], $banner['banners_title']) . '</a>';
            }

            $this->update_display_count($banner['banners_id']);

            return $banner_string;
        }


        //подсчет кол. показов
        function update_display_count($banner_id) 
        {
            //если включен посчет кол. показов баннера - считаем
            if ( get_option('banner_display_count') == 'true' )
            {
                $banner_check_query = $this->query("select count(*) as count from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . $banner_id . "' and date_format(banners_history_date, '%Y%m%d') = date_format(now(), '%Y%m%d')");

                $banner_check = $this->fetch_array($banner_check_query);

                if ($banner_check['count'] > 0) 
                {
                    $this->query("update " . TABLE_BANNERS_HISTORY . " set banners_shown = banners_shown + 1 where banners_id = '" . $banner_id . "' and date_format(banners_history_date, '%Y%m%d') = date_format(now(), '%Y%m%d')");
                } 
                else 
                {
                    $this->query("insert into " . TABLE_BANNERS_HISTORY . " (banners_id, banners_shown, banners_history_date) values ('" . $banner_id . "', 1, now())");
                }
            }
        }

        //переход с баннера на нужный адрес
        function redirect()
        {
            $banner_query = $this->query("select banners_url from ".TABLE_BANNERS." where banners_id = '".(int) $_GET['goto']."'");

            if ( $this->num_rows( $banner_query ) ) 
            {
                $banner = $this->fetch_array( $banner_query );
                //обновляем кол. кликов по баннеру
                $this->update_click_count( $_GET['goto'] );
                // print_r($banner['banners_url']);
                //die();
                os_redirect( $banner['banners_url'] );
            } 
            else 
            {
                os_redirect( os_href_link( FILENAME_DEFAULT ) );
            }

        }

        //считаем кол. кликов
        function update_click_count($banner_id) 
        {
            if ( get_option('banner_click_count') == 'true' )
            {
                $this->query("update " . TABLE_BANNERS_HISTORY . " set banners_clicked = banners_clicked + 1 where banners_id = '" . $banner_id . "' and date_format(banners_history_date, '%Y%m%d') = date_format(now(), '%Y%m%d')");
            }
        }

        //возвращает группы баннеров
        function get_group()
        {

            $group_banner = array();

            if ( $this->banners_info != 1 )
            {
                $query = $this->query("select banners_id, banners_title, banners_image, banners_html_text, banners_group from " . TABLE_BANNERS . " where status = '1'");
                while ( $_banner = $this->fetch_array($query, false) )
                {
                    $this->banners_info[ $_banner[ 'banners_group' ] ][] = $_banner;
                }
                
                if ( count($this->banners_info) == 0 ) $this->banners_info = 1;
            }


            if ( count( $this->banners_info ) > 0 && $this->banners_info != 1 )
            {
                foreach ($this->banners_info as $group => $name )
                {
                    $group_banner[] = $group;
                }
            }


            return $group_banner;
        }

        function activate() 
        {
            $banners_query = $this->query("select banners_id, date_scheduled from " . TABLE_BANNERS . " where date_scheduled != ''");

            if ( $this->num_rows($banners_query) ) 
            {
                while ($banners = $this->fetch_array($banners_query) ) 
                {
                    if (date('Y-m-d H:i:s') >= $banners['date_scheduled'])
                    {
                        $this->set_status($banners['banners_id'], '1');
                    }
                }
            }
        }


        function set_status($banners_id, $status) 
        {
            if ($status == '1') {
                return $this->query("update " . TABLE_BANNERS . " set status = '1', date_status_change = now(), date_scheduled = NULL where banners_id = '" . $banners_id . "'");
            } elseif ($status == '0') {
                return $this->query("update " . TABLE_BANNERS . " set status = '0', date_status_change = now() where banners_id = '" . $banners_id . "'");
            } else {
                return -1;
            }
        }

        function expire() 
        {
            $banners_query = $this->query("select b.banners_id, b.expires_date, b.expires_impressions, sum(bh.banners_shown) as banners_shown from " . TABLE_BANNERS . " b, " . TABLE_BANNERS_HISTORY . " bh where b.status = '1' and b.banners_id = bh.banners_id group by b.banners_id");

            if ( $this->num_rows($banners_query) ) 
            {
                while ($banners = $this->fetch_array($banners_query) ) 
                {
                    if ( os_not_null( $banners['expires_date'] ) ) 
                    {
                        if (date('Y-m-d H:i:s') >= $banners['expires_date']) 
                        {
                           // $this->set_status($banners['banners_id'], '0');
                        }
                    } 
                    elseif ( os_not_null($banners['expires_impressions']) && $banners['expires_impressions'] != 0) 
                    {
                        if ($banners['banners_shown'] >= $banners['expires_impressions']) 
                        {
                           $this->set_status($banners['banners_id'], '0');
                        }
                    }
                }
            }
        }




    }
?>