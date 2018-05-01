<?php

    if ( !function_exists('get_zone_block') )
    {
        function _get_zone_id($id)
        {
            $a = array();

            if ($id == 0)
            {
                $a[] = 0;
                return implode(',', $a);
            }

            $zone = array(1, 24, 41, 64, 86, 104); 

            if ( in_array ($id, $zone) )
            {
                $a[] = 0;
                $a[] = $id;
                return implode(',', $a); 
            }
            else
            {
                $a[] = 0;
                $a[] = $id;

                if ( $id > 1 && $id < 24)
                {
                    $a[] = 1; 
                }	
                elseif ( $id > 24 && $id < 41)	
                {
                    $a[] = 24; 
                }
                elseif ( $id > 41 && $id < 64)	
                {
                    $a[] = 41; 
                }	
                elseif ( $id > 64 && $id < 86)
                {
                    $a[] = 64;
                }
                elseif ( $id > 86 && $id < 104)
                {
                    $a[] = 86;
                }
                elseif ( $id > 104 && $id <= 125)
                {
                    $a[] = 104;
                }

                return implode(',', $a); 
            }


            /*	
            Минск и Минская область:1
            Брест и Брестская область:24
            Витебск и Витебская область:41
            Гомель и Гомельская область:64
            Гродно и Гродненская область:86
            Могилёв и Могилёвская область:104
            */


        }

        function for_zone_id($n1, $n2)
        {
            $n2 = $n2-1;
            $a = array();

            for ($i = $n1; $i <= $n2; $i++)
            {
                $a[] = $i; 
            }

            return $a;
        }

        function get_zone_id($id, $val = 'and zone_id in')
        {

            $a = array();

            if ($id == 0)
            {
                return '';
            }

            $zone = array(1, 24, 41, 64, 86, 104); 

            if ( in_array ($id, $zone) ) 
            {
                if ( $id == 1)
                {
                    $a = for_zone_id( 1, 24) ;
                }    
                elseif ( $id == 24 )    
                {
                    $a = for_zone_id( 24, 41) ;
                }
                elseif ( $id == 41 )    
                {
                    $a = for_zone_id( 41, 64) ;
                }    
                elseif ( $id == 64)
                {
                    $a = for_zone_id( 64, 86) ;
                }
                elseif ( $id == 86)
                {
                    $a = for_zone_id( 86, 104) ;
                }
                elseif ( $id == 104)
                {
                    $a = for_zone_id( 104, 126) ;
                }
				
				$a[] = 0;

                if ( count($a) > 0 )
                {
                    return  ' '.$val.' ('. implode(',', $a) .')';  
                }
                
            }
            else
            {
			    $a[] = 0;
			    $a[] = $id;
			    if ( $id > 1 && $id < 24)
                {
                    $a[] = 1; 
                }	
                elseif ( $id > 24 && $id < 41)	
                {
                    $a[] = 24; 
                }
                elseif ( $id > 41 && $id < 64)	
                {
                    $a[] = 41; 
                }	
                elseif ( $id > 64 && $id < 86)
                {
                    $a[] = 64;
                }
                elseif ( $id > 86 && $id < 104)
                {
                    $a[] = 86;
                }
                elseif ( $id > 104 && $id <= 125)
                {
                    $a[] = 104;
                }
				
                return  ' '.$val.' ('. implode(',', $a) .')';; 
            }

            // and s.zone_id in ('.get_zone_id( $_GET['zone_id'] ).')
        }

        function get_zone_block($type='', $js = '')
        {
            if ( isset($_GET['zone_id']) )
            {
                $zone_id = $_GET['zone_id']; 
            }
            elseif ( !isset($_SESSION['zone_id']) )
            {
                $_SESSION['zone_id'] = 0;
            }
            else
            {
                $zone_id  = $_SESSION['zone_id'];
            }

            //  print_r($_SESSION['zone_id']);
            $zone = array(
            0 => 'Вся Беларусь', 
            1 => 'Минская область', 
            2 => 'Брестская область',
            3 => 'Витебская область',
            4 => 'Гомельская область',
            5 => 'Гродненская область',
            6 => 'Могилёвская область'
            );
            $city = array();

            $city[1] = 
            array(
            "Березино",
            "Борисов",
            "Вилейка",
            "Воложин",
            "Дзержинск",
            "Клецк",
            "Копыль",
            "Крупский",
            "Логойск",
            "Любань",
            "Минск",
            "Молодечно",
            "Мядель",
            "Несвиж",
            "Пуховичи",
            "Слуцк",
            "Смолевичи",
            "Солигорск",
            "Старые Дороги",
            "Столбцы",
            "Узда",
            "Червень"
            );	  

            $city[2] = 
            array(
            "Барановичи",
            "Берёза",
            "Брест",
            "Ганцевичи",
            "Дрогичин",
            "Жабинка",
            "Иваново",
            "Ивацевичи",
            "Каменецк",
            "Кобрин",
            "Лунинец",
            "Ляховичи",
            "Малорита",
            "Пинск",
            "Пружаны",
            "Столин");

            $city[3] = array(
            "Бешенковичи",
            "Браслав",
            "Верхнедвинск",
            "Витебск",
            "Глубокое",
            "Городок",
            "Докшицы",
            "Дубровно",
            "Лепель",
            "Лиозно",
            "Миоры",
            "Новополоцк",
            "Орша",
            "Полоцк",
            "Поставы",
            "Россоны",
            "Сено",
            "Толочин",
            "Ушачи",
            "Чашники",
            "Шарковщина",
            "Шумилино");

            $city[4] = 
            array(
            "Брагин",
            "Буда-Кошелево",
            "Ветка",
            "Гомель",
            "Добруш",
            "Ельск",
            "Житковичи",
            "Жлобин",
            "Калинковичи",
            "Корма",
            "Лельчицы",
            "Лоев",
            "Мозырь",
            "Наровля",
            "Октябрьский",
            "Петриков",
            "Речица",
            "Рогачев",
            "Светлогорск",
            "Хойники",
            "Чечерск");

            $city[5] = 
            array(
            "Берестовица",
            "Волковыск",
            "Вороново",
            "Гродно",
            "Дятлово",
            "Зельва",
            "Ивье",
            "Кореличи",
            "Лида",
            "Мосты",
            "Новогрудок",
            "Островец",
            "Ошмяны",
            "Свислочь",
            "Слоним",
            "Сморгонь",
            "Щучин");

            $city[6] = 
            array(
            "Белыничи",
            "Бобруйск",
            "Быхов",
            "Глуск",
            "Горки",
            "Дрибин",
            "Киров",
            "Климовичи",
            "Кличев",
            "Костюковичи",
            "Краснополье",
            "Кричев",
            "Круглое",
            "Могилёв",
            "Мстиславль",
            "Осиповичи",
            "Славгород",
            "Хотимск",
            "Чаусы",
            "Чериков",
            "Шклов");

            $jquery =  '<script type="text/javascript">
            $(document).ready(function(){

            $("#zone_id").change(

            function (){

            var log = $("#log");
            var log_name = $("#cat_name");
            log.fadeIn();
            log_name.fadeIn(2000);
            id = $("#zone_id option:selected").val();
            $.ajax({
            type: "POST", url: "index.php?page=seller_zone_page&zone_id="+id, data: "",
            complete: function(data)
            {
            log_name.html(data.responseText);
            log.html("<font color=\"green\"><b>Сохранено</b></font>");
            log.fadeOut(2000);
            }
            });
            }
            );

            });

            </script>';

            $i = 0;
            $text = '';  

            if ( empty($js) )
            {
                $text .= $jquery;
            }
            else
            {
                $text .= $js;  

            }

            $param_array = array();

            $text .= '<select id="zone_id">';
            foreach ($zone as $id => $name)
            {

                if ($id == 0)
                {
                    if ( $zone_id == $i)
                    {
                        $param_array[] = array('id' => $i, 'text' => $name);
                        $text .= '<option value="'.$i.'" selected style="font-weight:bold;"> - '. $name.'</option>'."\n";
                    }
                    else
                    {
                        $param_array[] = array('id' => $i, 'text' => $name);
                        $text .= '<option value="'.$i.'" style="font-weight:bold;"> - '. $name.'</option>'."\n";
                    }

                    if ($type == 'text')
                    {
                        if ( $zone_id == $i)
                        {
                            return  $name;
                        }
                    }

                    $i++;
                }
                else
                {
                    if ($type == 'text')
                    {
                        if ( $zone_id == $i)
                        {
                            return  $name;
                        }
                    }

                    if ( $zone_id == $i)
                    {
                        $param_array[] = array('id' => $i, 'text' => $name);
                        $text .= '<option value="'.$i.'" selected style="font-weight:bold;"> - '. $name.'</option>'."\n";
                    }
                    else
                    {
                        $param_array[] = array('id' => $i, 'text' => $name);
                        $text .= '<option value="'.$i.'" style="font-weight:bold;"> - '. $name.'</option>'."\n";
                    }
                    $i++;

                    foreach ($city[ $id ] as $name2 ) 
                    {
                        if ($type == 'text')
                        {
                            if ( $zone_id == $i)
                            {
                                return  $name2;
                            }
                        }

                        if ( $zone_id == $i)
                        {
                            $param_array[] = array('id' => $i, 'text' => $name2);
                            $text .= '<option selected value="'.$i.'"> - '. $name2.'</option>'."\n";
                        }
                        else
                        {
                            $param_array[] = array('id' => $i, 'text' => $name2);
                            $text .= '<option value="'.$i.'"> - '. $name2.'</option>'."\n";  
                        }

                        $i++;
                    }
                }



            }

            if ($type == 'array')
            {
                return $param_array;
            }
            $text .= '</select>';
            $text .= '<span style="padding-left: 5px;" id="log"></span>';

            return $text;
        }

    }



?>