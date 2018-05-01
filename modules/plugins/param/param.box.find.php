<?php
    /*
    #####################################
    #  ShopOS: Shopping Cart Software.
    #  Copyright (c) 2008-2010
    #  http://www.shopos.ru
    #  http://www.shopos3.com
    #  http://www.shoposs.com
    #  Ver. 1.0.0
    #####################################
    */

    $param = new param();

    @$_SESSION['param'] = @$_GET['param'];

    $catid = $_GET['cat'];

    $content = ''; 
 
    //делаем выборку корневых параметров
    $value = $param->get_param_name( array('category_id' => 0) );

    if ( count($value) >0 )
    {
	    $content .=  '<form action="index.php" method="get">';
        $content .= '<input type="hidden" name="main_page" value="param_find" />';
		
        foreach ($value as $_value)
        {
            $value_id_array[] = $_value['name_id'];
        }

        $param_value_group = $param->get_param_value_group ($value_id_array);

        //рисуем меню
        foreach ($value as $_value)
        {
            $content .= '<b>'.$_value['name_value'].'</b><br />';
            $content .= os_draw_pull_down_menu('param['.$_value['name_id'].']', $param_value_group [ $_value['name_id'] ] , @$_SESSION['param'][ $_value['name_id'] ], 'style="width:100%"' ).'<br />';
        }
		
        $content .= '<br /><input type="submit" value=" Подобрать ">';
        $content .= '</form>';
		$title = 'Параметры';
    }
?>