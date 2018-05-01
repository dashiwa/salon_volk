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
    $param->remove_param_all();

    include( dirname(__FILE__) . '/param.class.attributes.php');
    $attr = new attributes();
    
    $attr_name_array = $attr->get_attributes_name();
    $attr_name_array_id = array();
    
    //добавляем атрибуты в параметры
    if ( count($attr_name_array) )
    {
        foreach ($attr_name_array as $num => $_name)
        {
            echo '<b>Добавлен параметр</b> '.$_name.'<br>';
            $param->add_param_name($_name);
            $name_id = $param->insert_id();
            $attr_name_array_id [ $num ] = array('name'=>$_name, 'id'=>$name_id);
        }
    }
    
    //products_options_values_id
    
    $attr_value_array = $attr->get_attributes_value();
    $attr_value_array_id = array();
    
    $options_values_to_products_options = $attr->get_options_values_to_products_options();

    //добавляем варианты атрибутов
    if ( count($attr_value_array) )
    {
        foreach ($attr_value_array as $num => $_name)
        {
                $id = $attr_name_array_id[ $options_values_to_products_options[$num] ]['id'];
               echo '<b>Добавлен вариант параметра</b> '.$_name.'<br>';
                $param->add_param_value($id, $_name);
                $value_id = $param->insert_id();
                $attr_value_array_id[$num] = array('id'=>$value_id);
        }
    }
    
    
    $attr_param = $attr->get_attributes();
    
    if ( count($attr_param) > 0 )
    {
        foreach ($attr_param as $num => $value)
        {
            $options_values_id  = $value['options_values_id']; 
            $options_id  = $value['options_id']; 
            $_value_id = $attr_value_array_id[ $options_values_id ]['id'];
            $_name_id = $attr_name_array_id[ $options_id ]['id'];
            $_products_id = $value['products_id'];

            $_array_param = array('product_id' => $_products_id, 'value_id'=> $_value_id, 'name_id' => $_name_id);
            $param->add_param ($_array_param);
        }
    }
    
    


?>
