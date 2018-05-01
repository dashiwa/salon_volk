<?php

    class seller extends db
    {
        //Админка - Покупатели - Группы клиентов
        var $seller_group_id = 4;
        var $seller = array();
        var $seller_products_count = array();

        function seller()
        {
            //получаем список продавцов
            $this->seller_list(); 
            $this->seller_products_count();
        }

        function add_products_seller($array, $seller_id)
        {
            if ( count($array) > 0 )
            {
                $i = 0;

                foreach ($array as $id)
                {
                    $this->query('replace into '.DB_PREFIX.'seller (seller_id, products_id) values ('.$seller_id.', '.$id.');');
                    $i = $i + (int)$this->affected_rows();
                }

                return $i;
            }  
            else
            {
                return 0;
            }
        }

        function remove_products_seller($array,  $seller_id)
        {
            if ( count($array) > 0 )
            {
                $i = 0;

                foreach ($array as $id)
                {
                    $this->query('delete from '.DB_PREFIX.'seller where seller_id='.$seller_id.' and products_id='.$id.';');
                    $i = $i + (int)$this->affected_rows();
                }

                return $i;
            }  
            else
            {
                return 0;
            }
        }

        function seller_list()
        {
            $seller_obj = $this->query('SELECT * FROM  `'.DB_PREFIX.'products_to_categories` pc left join `'.DB_PREFIX.'products_description` pd on (pc.products_id=pd.products_id) left join `'.DB_PREFIX.'products` p on (p.products_id=pd.products_id) WHERE pc.categories_id=29;');

            while ($_seller = $this->fetch_array($seller_obj, false) )
            {
                $this->seller[] = $_seller;
                $this->seller_products_count['tmp'][] = $_seller['products_id'];
            }
        }

        function get_products ($seller_id)
        {
            $seller_obj = $this->query('SELECT seller_id,s.price, s.desc, p.products_id, pd.products_name, p.products_page_url  FROM  `'.DB_PREFIX.'seller` s  left join `'.DB_PREFIX.'products_description` pd on (s.products_id=pd.products_id) left join '.DB_PREFIX.'products p on (p.products_id=pd.products_id) WHERE p.products_status=1 and s.seller_id='.(int)$seller_id.';');
            
            $s = array();
            while ($_seller = $this->fetch_array($seller_obj, false) )
            {
                $s[] = $_seller; 
            }

            return $s;
        }
        
        function products_remove($seller_id, $id)
        {
            $this->query('delete from '.DB_PREFIX.'seller where seller_id='.$seller_id.' and products_id='.$id.';');
        }

        function seller_products_count()
        {
            if ( count($this->seller) )
            {
                $where = implode(',', $this->seller_products_count['tmp']);
                $query = $this->query('select seller_id, count(*) as total from '.DB_PREFIX.'seller where  seller_id in ('.$where.') group by seller_id;');

                while ($_q = $this->fetch_array($query, false) )
                {
                    $this->seller_products_count[ $_q['seller_id'] ]  = $_q['total']; 
                }

            }
        }
    }
?>