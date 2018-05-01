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

 $i = 0;
            $this->add_param_name('Дата выхода на рынок');
            $this->add_param_name('Тип камеры');
            $this->add_param_name('Длина');
            $this->add_param_name('Ширина');
            $this->add_param_name('Толщина');
            $this->add_param_name('Пыле-, влаго-, ударопрочность');

            $array =  array('product_id' => 154567,
            'name_id' => 1,
            'sort_order' => 0,
            'group_id' => 0,
            'group_type' => 0,
            'group_value' => 0,
            'value_id' => 1
            );

            $i++;
            $value_id = $this->add_param_value(1, 'Параметр '.$i);
            $i++;
            $value_id = $this->add_param_value(1, 'Параметр '.$i);
            $i++;
            $value_id = $this->add_param_value(1, 'Параметр '.$i);
            $i++;
            $value_id = $this->add_param_value(1, 'Параметр '.$i);
            $i++;
            $value_id = $this->add_param_value(1, 'Параметр '.$i);

            $array['value_id']   =  $value_id; 
            $array['name_id']   = 1; 

            $this->add_param ($array);


            $i++;
            $value_id = $this->add_param_value(2, 'Параметр '.$i);
            $i++;
            $value_id = $this->add_param_value(2, 'Параметр '.$i);
            $i++;
            $value_id = $this->add_param_value(2, 'Параметр '.$i);
            $i++;
            $value_id = $this->add_param_value(2, 'Параметр '.$i);
            $i++;
            $value_id = $this->add_param_value(2, 'Параметр '.$i);

            $array['value_id']   =  $value_id; 
            $array['name_id']   = 2; 

            $this->add_param ($array);



            /* for ($i=1; $i<=100;$i++)
            {
            $array['value_id'] =   $this->add_param_value(1, 'Параметр '.$i);
            $this->add_param ($array);

            echo $value_id.'<br>';
            }

            */
            /* $array['param_value'] = 1;
            $array['param_name_id'] = '1';
            $this->add_param ($array); 

            $array['param_value'] = 'Параметр 2';
            $array['param_name_id'] = '2';
            $this->add_param ($array); 

            $array['param_value'] = 'Параметр 3';
            $array['param_name_id'] = '3';
            $this->add_param ($array);

            $array['param_value'] = 'Параметр 4';
            $array['param_name_id'] = '4';
            $this->add_param ($array); 

            $array['param_value'] = 'Параметр 5';
            $array['param_name_id'] = '5';
            $this->add_param ($array); 

            $array['param_value'] = 'Параметр 6';
            $array['param_name_id'] = '6';
            $this->add_param ($array); 

            */
?>
