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

    function get_param_type ($_param, $name_id,  $current = 0)
    {
        $form = '';
        $form .= '<select name ="params['.$name_id.'][type_id]">';           
        foreach ($_param->type_array as $name => $value)
        {
            if ($value == $current) 
            {

                $form  .='<option selected value="'.$value.'">'.$name.'</option>';
            }
            else
            {
                $form  .='<option value="'.$value.'">'.$name.'</option>';
            }

        }
        $form .= '</select>';

        return  $form;
    }

    function add_hidden_value($id, $par, $val)
    {
        return '<input type="hidden" name="params['.$id.']['.$par.']" value="'.$val.'">';
    }

    function get_form_save_param($array, $action)
    {
        $form = '';
        global $param;

        $option_array = $param->get_param_option( $array['name_id'] );

        $_array = array();

        if (count($option_array) > 0)
        {
            $_array [] = array('id' => '0', 'text' => 'Не установлен');

            foreach ($option_array as $num => $value)
            {
                $_array[] = array('id' => $num , 'text' =>$value );  
            }

        }

        $form .= '<table class="contentTable" border="0" width="237px" cellspacing="0" cellpadding="0"><tr><td class="infoBoxHeading">'.$array['name_value'].'</td></tr></table>

        <table class="contentTable2" border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr><td class="infoBoxContent2">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;margin-bottom:5px;">';

        $form .= '<form method="post" action="'.$action.'&action=save_param_edit&id='.$array['name_id'].'">';
        $form .= '<a href="plugins_page.php?main_page=param_options&name_id='.$array['name_id'].'" class="code">Варианты параметра ('.count( $option_array ).')</a><br />';
        $form  .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;margin-bottom:5px;">';

        //категория
        $form .=  '<tr><td><b>Категория</b></td></tr>';
        $form .=  '<tr><td>'.os_draw_pull_down_menu('params['.$array['name_id'].'][category_id]', os_get_categories(array (array ('id' => '0', 'text' => 'Начало'))), $array['category_id'], 'style="width:100%"' ).'</td></tr>';    

        $form .=  '<tr><td><b>Вариант по умолчанию</b></td></tr>';

        $form .=  '<tr><td>'.os_draw_pull_down_menu('params['.$array['name_id'].'][value_id]', $_array , $array['value_id'], 'class="round" style="width:100%"' ).'</td></tr>';  

        //вариант по умолчанию
        $form .=  '<tr><td><b>Тип параметра</b></td></tr>';
        $form .=  '<tr><td>'.get_param_type( $param, $array['name_id'], $array['type_id']  ).'</td></tr>';  



        $form .=  '<tr><td><b>Описание</b></td></tr>';
        $form .=  '<tr><td><textarea id="name_alt" name="params['.$array['name_id'].'][name_alt]" class="round" rows="10" >'.$array['name_alt'].'</textarea><br />
        <a href="javascript:toggleHTMLEditor(\'name_alt\');" class="code">HTML редактор</a>
        </td></tr>';

        $form .=  '</table><span class="button"><button type="submit" value="Сохранить"/>Сохранить</button></span> '.'</form>';

        $form .= '</td></tr></table>';

        return $form;
    }

    //выводит урезанный tiny_mce
    function tiny_mce_param()
    {
        $js_src = http_path('includes_admin') .'javascript/tiny_mce/tiny_mce.js';

        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
        <script type="text/javascript">
        tinyMCE.init({
        mode : "none",
        language : "ru",
        paste_create_paragraphs : false,
        paste_create_linebreaks : false,
        paste_use_dialog : true,
        convert_urls : false,

        plugins : "safari",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true

        });

        function toggleHTMLEditor(id) {
        if (!tinyMCE.get(id))
        tinyMCE.execCommand("mceAddControl", false, id);
        else
        tinyMCE.execCommand("mceRemoveControl", false, id);
        }
        </script>';

        return $val;
    }

    function get_categories_name ($array)
    {
        $array = array_unique($array);

        if ( count($array) >0 )
        {
            global $db;
            $_cat_str = implode(',', $array);

            $_query = $db->query('select categories_name, categories_id from '.DB_PREFIX.'categories_description where categories_id in ('.$_cat_str.')');   

            $cat_name = array();

            while ( $query = $db->fetch_array($_query,false) )
            {
                $cat_name[ $query['categories_id'] ] = $query['categories_name'];
            }


            return $cat_name;
        }
        else
        {
            return 0;
        }
    }
?>