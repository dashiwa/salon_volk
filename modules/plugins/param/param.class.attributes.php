<?php
//класс для работы с атрибутами товаров

    class attributes extends db
    {
        //возвращает массив атрибутов
        function get_attributes_name()
        {

            $products = os_db_query("SELECT products_options_id, products_options_name FROM `".DB_PREFIX."products_options`");
            
            while ($_products = $this->fetch_array($products))
            {
                $attr_array[ $_products['products_options_id'] ] = $_products['products_options_name'];
            }
            
            return $attr_array;
        }
        
        //выдает варианты атрибутов
        function get_attributes_value ()
        {
            $products = os_db_query("SELECT  products_options_values_id, products_options_values_name FROM `os_products_options_values` ");
            
            while ($_products = $this->fetch_array($products))
            {
                $attr_array[ $_products['products_options_values_id'] ] = $_products['products_options_values_name'];
            }
            
            return $attr_array;
        }
        
        function get_attributes()
        {
        
            $products = os_db_query("SELECT products_id, options_id, options_values_id FROM `os_products_attributes` ");
            
            while ($_products = $this->fetch_array($products))
            {
                $attr_array[ ] = $_products;
            }
            
            return $attr_array;
        }
        
        function get_options_values_to_products_options()
        {
           $products = os_db_query("SELECT products_options_id , products_options_values_id FROM `".DB_PREFIX."products_options_values_to_products_options ");
            
            while ($_products = $this->fetch_array($products))
            {
                $attr_array[ $_products['products_options_values_id' ] ] = $_products['products_options_id'];
            }
            
            return $attr_array;
        }
    }
?>