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
    $action = 'plugins_page.php?main_page=param_add';
    $action2 = 'plugins_page.php?main_page=param_options';
    //require_once(_FUNC_ADMIN.'wysiwyg_tiny.php');


    echo tiny_mce_param();
    //print_r($_POST);
    //добавление параметра


    //событие
    if ( isset($_GET['action']) ) 
    {
        switch ( $_GET['action'] )
        {
            case 'setflag':
                // смена статуса параметра
                $param->set_param_status( (int)$_GET['id'], (int)$_GET['flag']);
                break;

            case 'delete':
                //удаление параметра
                if ( isset($_GET['id']))
                {
                    $param->remove_param_name( (int)$_GET['id'] ); 
                    //удаляем варианты параметра
                    $param->query('delete from '.DB_PREFIX.'param_value where name_id = '.(int)$_GET['id']);
                }
                break;


            case 'add_param':
                //    добавляем параметр
                if ( isset($_POST['param']) )
                {
                    $categories_id  = @ $_POST['param']['categories_id'];
                    $param_name  = @ $_POST['param']['param_name'];
                    $value_default  = @ $_POST['param']['value_default'];
                    $param_type  = @ $_POST['param_type']['value'];

                    $param->add_param_name($param_name, $categories_id, $param_type, $value_default);
                }

                break;               

            case 'save_param':
                //   сохранение параметров
                if ( isset($_POST['params']) )
                {
                    $param->save_param_name( $_POST['params'] );
                }

                break;                   

            case 'save_param_edit':
                //   сохранение параметров
                if ( isset($_POST['params']) )
                {
                    $param->save_param_name( $_POST['params'] );
                }

                break;   
        }


    }
?>
<form name="add_field" action="<?php echo $action.'&action=add_param'; ?>" method="post">      
    <table border="0"  cellspacing="2" cellpadding="2" width="100%">
        <tr class="dataTableHeadingRow">
            <td width="100px" class="dataTableHeadingContent">Категория</td>
            <td width="200px" class="dataTableHeadingContent" align="center">Название параметра</td>
            <td width="100px" class="dataTableHeadingContent" align="center">Тип</td>
            <td width="100px" class="dataTableHeadingContent" align="center">по умолчанию</td>
        </tr>

        <tr>
            <td class="dataTableContent" align="center">
            <?php echo os_draw_pull_down_menu('param[categories_id]', os_get_categories(array (array ('id' => '0', 'text' => 'Начало'))), '', 'style="width:100px"'); ?>       </td>  
            <td class="dataTableContent">
            <input type="text" name="param[param_name]" >        </td>

            <td class="dataTableContent">
            <?php echo get_param_type( $param, 'value' ) ; ?>  </td>

            <td class="dataTableContent" align="center">
            <input type="text" name="param[value_default]" style="width:80%">        </td>    
            <td  align="left" >
            <span class="button"><button type="submit" value="Добавить"/>Добавить</button></span>        </td>
        </tr>
    </table>
</form>     
<div style="width: 100%; border-top: 1px dashed #0042B2;" />
<br />
<?php
    $array = $param->get_param_name();

    if (count($array) > 0) {

        $cat_id_array = array();

        foreach ($array as $val)
        {
            $cat_id_array[] = $val['category_id'];
        }

        $name_array = get_categories_name($cat_id_array);
    ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0"  valign="top">
        <tr><td valign="top"><table border="0"  cellspacing="2" cellpadding="2" width="100%">
                    <tr class="dataTableHeadingRow">
                        <td  width="100px" class="dataTableHeadingContent">Категория</td>
                        <td width="200px" class="dataTableHeadingContent" align="center">Название параметра</td>
                        <td class="dataTableHeadingContent" align="center">Статус</td>
                        <td width="100px" class="dataTableHeadingContent" align="center" alt="тип">Тип</td>
                        <td class="dataTableHeadingContent" align="center" alt="тип">Сорт.</td>
                        <td width="100px" class="dataTableHeadingContent" align="center" alt="тип">По умолчанию</td>
                        <td width="80px" class="dataTableHeadingContent" align="center" alt="тип">Действие</td>
                    </tr>
                    <form action="<?php echo $action.'&action=save_param&id='.@$_GET['id']; ?>" method="post"> 

                    <?php

                        // print_r($array);

                        $color = '';
                        foreach ($array as $value)
                        {
                            $color = $color == '#f9f9ff' ? '#f0f1ff':'#f9f9ff'; 

                            if (!isset($_GET['id']) )  $_GET['id'] =$value['name_id'];

                            if ($_GET['id'] == $value['name_id'] ) 
                            {
                                $current_array = $value;
                                $_data = 'class="dataTableRowSelected"';
                            }
                            else
                            {
                                $_data= 'onmouseover="this.style.background=\'#e9fff1\';this.style.cursor=\'hand\';" onmouseout="this.style.background=\''.$color.'\';" style="background-color:'.$color.'"'; 
                            }

                            $_click = 'onclick="document.location.href=\''.$action.'&id='.$value['name_id'].'\'"';


                            echo  '<tr '.$_data.'  >';


                            if ( isset( $name_array[ $value['category_id'] ] ) )
                            {
                                $category_text = $name_array[ $value['category_id'] ];
                            }
                            else
                            {
                                if ($value['category_id'] == 0)
                                {
                                    $category_text = 'Начало';
                                }

                            }

                            echo '<td class="dataTableContent" '.$_click.' align="center">'.$category_text.add_hidden_value($value['name_id'],'category_id', $value['category_id']).'</td>';

                            echo '<td class="dataTableContent"><input type="text" name="params['.$value['name_id'].'][name_value]" value="'.$value['name_value'].'"></td>';   

                            //статус
                            echo '<td class="dataTableContent" align="center">';

                            if ($value['status'] == '1') 
                            {
                                echo os_image(http_path('icons_admin')  . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '  <a href="' . os_href_link('plugins_page.php', 'main_page=param_add&action=setflag&flag=0&id=' . $value['name_id']) . '">' . os_image(http_path('icons_admin') . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
                            } 
                            else 
                            {
                                echo '<a href="' . os_href_link('plugins_page.php', 'main_page=param_add&action=setflag&flag=1&id=' . $value['name_id']) . '">' . os_image(http_path('icons_admin') . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>  ' . os_image(http_path('icons_admin') . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
                            }

                            echo '</td>';  

                            echo '<td class="dataTableContent" align="center">'.$param->type_array_reverse[ $value['type_id'] ].'</td>';
                            echo '<td class="dataTableContent" align="center"><input type="text" name="params['.$value['name_id'].'][sort_order]" value="'.@$value['sort_order'].'" size="2"></td>';
                            echo '<td class="dataTableContent" align="center"><input type="hidden" name="params['.$value['name_id'].'][value_id]" value="'.@$value['value_id'].'" /><input type="text" name="params['.$value['name_id'].'][value_default]" value="'.@$value['value_default'].'" style="width: 80px;"></td>';
                            echo '<td class="dataTableContent" align="center"><a onclick="return confirm(\'Действительно хотите удалить параметр и все его варианты?\')" href="'.$action.'&action=delete&id='.$value['name_id'].'"><img src="'.plugurl().'images/delete.gif" border="0" /></a><a href="'.$action2.'&name_id='.$value['name_id'].'" class="code">Варианты</a></td>';
                            echo '</tr>';
                        }


                    ?>
                </table>
                <span class="button"><button type="submit" value="Сохранить"/>Сохранить</button></span>  
                </form>
                <?php
                }
            ?>
        </td>
        <td class="right_box" valign="top">


            <?php
                if (count($array) > 0) {
                    echo  get_form_save_param($current_array, $action);

            }            ?>


        </td></tr></table>

</td>

</table>
