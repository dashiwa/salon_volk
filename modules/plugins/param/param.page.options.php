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
    $action = 'plugins_page.php?main_page=param_options';

    //print_r($_POST);
?>

<style>
    .options   {
        padding: 3px;
    }
</style>
<?php
    // print_r($_POST);
    // print_r($_GET);
    //добавление параметра
    if ( isset($_GET['name_id']) )
    {

        $_name_id = (int)$_GET['name_id'];

        if ( isset($_POST['action'])  ) 
        {

            switch ( $_POST['action'] )
            {
                case 'save':
                    if ( isset($_POST['options']) )
                    {
                        if ( count($_POST['options']) )
                        {
                            $post_option = array();

                            foreach ($_POST['options'] as $num => $value)
                            {
                                $post_option[ $num ]['value'] =  $value['value'];
                            }
                          
                            $param->save_param_value( $post_option );
                        }

                    }

                    break;            

                    //добавить вариант параметра
                case 'add_option':
                    if ( isset($_POST['options']) && !empty ($_POST['options'])  )
                    {

                        $param->add_param_value( $_name_id, $_POST['options'] );
                    }

                    break;

                case 'remove':
                    if ( count($_POST['options']) >0 )
                    {
                        foreach ($_POST['options'] as $value_id => $value)
                        {
                            if ( isset($value['checkbox']) ) 
                            {
                                if ( $param->remove_param_value($value_id) >0 )
                                {
                                    echo '<font color="red">Удален вариант параметра id='.$value_id.'</font><br />';
                                }
                            }
                        }
                    }
                    break;

            }



        }

        if ( isset($_GET['action']))
        {
            switch ( $_GET['action'] )
            {
                case 'remove':
                    if ( isset($_GET['value_id']) && !empty($_GET['value_id']) )
                    {
                        $param->remove_param_value( (int)$_GET['value_id'] );
                        echo '<font color="red">Удален вариант параметра ='.$_GET['value_id'].'</font><br />';
                    }
                    break;
            }
        }



    }


    if ( isset($_GET['name_id']) )

    {
    ?><b>Добавить вариант значения этой характеристики</b><br />
    <form action="<?php echo $action.'&name_id='.$_name_id; ?>" method="post">      
        <table border="0"  cellspacing="2" cellpadding="2" >
            <tr class="dataTableHeadingRow">
                <td width="200px" class="dataTableHeadingContent" align="center">Вариант параметра</td>
            </tr>

            <tr>
                <td class="dataTableContent">
                <input type="text" name="options" >        </td>
                <td  align="left" >
                    <input type="hidden" name="action" value="add_option" />
                    <span class="button"><button type="submit" value="Добавить"/>Добавить</button></span>        
                </td>
            </tr>
        </table>
    </form>
    <br />

    <?php
    }
    $param_name_array = $param->get_param_name();

    //print_r($param_name_array);

    if ( count($param_name_array)> 0)
    {

        echo '<b>Параметр:</b> <SELECT NAME="navSelect" ONCHANGE="top.location.href = \'plugins_page.php?main_page=param_options&\'+this.options[this.selectedIndex].value">';
        echo '<OPTION value="name_id=1">Не выбран</OPTION>';

        foreach ($param_name_array as $_value_name)
        {
            if ( $_name_id == $_value_name['name_id'])
            {
                echo '<OPTION selected VALUE="name_id='.$_value_name['name_id'].'">'.$_value_name['name_value'].'</OPTION>';
            }
            else
            {
                echo '<OPTION VALUE="name_id='.$_value_name['name_id'].'">'.$_value_name['name_value'].'</OPTION>';
            }   
        }

        echo '</SELECT></br>';
    }

    if ( isset($_GET['name_id']) )

    {
    ?>     
    <br />
    <?php
        $array = $param->get_param_option( $_name_id );

        if ( count($array) > 0 )
        {
        ?>
        <b>Варианты параметра</b>
        <table width="100%" border="0" cellspacing="0" cellpadding="0"  valign="top">
            <tr><td>

                <form  name ="_option" action="<?php echo $action.'&name_id='.$_name_id; ?>" method="post"> 
                <table border="0"  cellspacing="2" cellpadding="2">
                <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" align="center">&nbsp;</td>
                    <td class="dataTableHeadingContent" align="center">Значение</td>
                    <td class="dataTableHeadingContent" align="center">&nbsp;</td>
                </tr>


                <?php
                    $color = '';
                    foreach ($array as $num => $value)
                    {
                        $color = $color == '#f9f9ff' ? '#f0f1ff':'#f9f9ff'; 

                        if (!isset($_GET['name_id']) )  $_GET['name_id'] =$num;
                        $_GET['name_id'] = (int)$_GET['name_id'];

                        $_data= 'onmouseover="this.style.background=\'#e9fff1\'; onmouseout="this.style.background=\''.$color.'\';" style="background-color:'.$color.'"'; 


                        echo  '<tr '.$_data.' >';

                        // echo '<td class="dataTableContent">'.$num.'<input type="hidden" value="'..'"></td>';   
                        echo '<td class="options" align="center" valign="middle"><input type="checkbox" name="options['.$num.'][checkbox]" value="true">'.'</td>';
                        //статус

                        echo '<td class="options" align="center"><input type="text" style="width:90%" name="options['.$num.'][value]" value="'.$value.'">'.'</td>';

                        echo '<td class="options" align="center"><a href="'.$action.'&action=remove&name_id='.$_name_id.'&value_id='.$num.'"><img src="'.plugurl().'images/delete.gif" border="0" /></a></td>';

                        echo '</tr>';
                    }



                ?>
                <td colspan="13" valign="bottom">
                    <img src="images/arrow_ltr.png" border="0" style="padding-left: 3px;" height="22"/>
                    <select name="action" dir="ltr" style="width: 200px;">
                        <option value="remove" >Удалить отмеченные</option>
                        <option value="save" selected="selected"  >Сохранить все</option>
                    </select>
                    <span class="button"><button type="submit" />Ok</button></span>
                </td>
            </tr>

        </table>
        </form>

        </td>
        <td class="right_box" valign="top">




        </td></tr></table>
        <?php
        }
        else
        {
            echo 'нет вариантов для этого параметра<br />';   
        }
    }
?>    
<br />
<a href="plugins_page.php?main_page=param_add">Перейти к редактированию параметров</a>
</td>

</table>