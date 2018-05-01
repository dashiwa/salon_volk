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
   // $param->remove_param_all();

    $products_extra_fields_query = os_db_query("SELECT products_extra_fields_id as id, products_extra_fields_name as name FROM " . TABLE_PRODUCTS_EXTRA_FIELDS . " ORDER BY products_extra_fields_order");

    while ($extra_fields = os_db_fetch_array($products_extra_fields_query)) 
    { 
        $fields[ $extra_fields['id'] ] =  $extra_fields['name'];   
    }

    if (!empty($fields))
    {
        foreach ($fields as $id => $name)
        {
            $_p = os_db_query("SELECT * FROM ".DB_PREFIX."products_to_products_extra_fields where products_extra_fields_id=".$id);

            $param->add_param_name($name);

            echo 'Добавлен параметр '.$name.'<br>';

            $name_id = $param->insert_id();

            while ($p = os_db_fetch_array($_p)) 
            {  
                echo 'Добавлен вариант параметра '.$p['products_extra_fields_value'].'<br>';

                $value_id = $param->is_param_value ($p['products_extra_fields_value']); 

                $products_id = $p['products_id'];

                //если $value_id == 0  добавляем параметр 
                if ($value_id == 0 )
                {
                    $param->add_param_value($name_id, $p['products_extra_fields_value']);

                    $_value_id = $param->insert_id();

                    $_array_param = array('product_id' => $products_id, 'value_id'=> $_value_id, 'name_id' => $name_id);
                    $param->add_param ($_array_param);
                }
                else
                {
                    $_array_param = array('product_id' => $products_id, 'value_id'=> $value_id, 'name_id' => $name_id);
                    $param->add_param ($_array_param);
                }

            }

        }
    }


?>