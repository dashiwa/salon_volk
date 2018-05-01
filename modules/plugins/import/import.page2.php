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

    do_action('import_page2');
    
    echo '<html>
    <head>
    <title>'.$import->lang['page2_title'].'</title>';?>
<style>
    @import url('<?php echo plugurl(); ?>import.style.css');
</style>
<script type="text/javascript" src="includes/javascript/jquery_1.3.2.js"></script>
<script type="text/javascript">
    
	$(document).ready(function()
    {
            //запускаем рестар импорта
            $("#unselect").click(
            function () 
            {
                 $('option:selected').attr('selected', '');
                // $('option:nth-child(1) option:selected').attr('selected', 'selected');
            }
            );
    });
	
</script>
<?php
    echo '</head>
    <body>';
    //загрузка файла
    $import->upload();
    $import->get_fields();
    
	if ( $import->file_size == 0)
	{
	   die('Файл не найден или размер файла = 0. <a class="import" href="plugins_page.php?main_page=import_page1">Вернуться назад</a>');
	}
	
    echo '<b> Файл:</b> '.$import->file_name.', <b>Размер:</b> '. $import->format ( $import->file_size ) .'</b>';
	echo ' <span style="color:blue">| </span> <a href="plugins_page.php?main_page=import_page1" class="import">Первый шаг</a> <br />';


    //Колонки идентификации
    $_array_general[] = '<input type="radio" checked name="general" value="products_id">';
   // $_array_general[] = '<input type="radio" name="general" value="products_model">';
    //$_array_general[] = '<input type="radio" name="general" value="products_name">';

    $_count_fields = count( $import->fields_array );
    if ( $_count_fields > 1 )
    {
        echo 'В CSV-файле найдено '.$_count_fields.' колонок.<br>';
		echo '<a class="import" id="unselect" href="#">Снять выделение</a>';
        // $import->get_fields_list();
        /// echo '<br />';
        echo '<br /><form action="plugins_page.php?page=import_page3" method="POST">';
        echo '<table cellspacing="2" cellpadding="2">';
        echo '<tr>';
        echo '<td align="center"><b>Колонки в CSV-файле</b></td>';
        echo '<td align="center">&nbsp;</td>';
        echo '<td align="center"><b>Поля в базе данных</b></td>';
        echo '<td align="center"><b>Колонка идентификации:</b></td>';
        echo '</tr>';

        $i = 0;

        $color = '';

        foreach ($import->default_fields as  $num => $_tmp)
        {
            $color = $color == '#f9f9ff' ? '#f0f1ff':'#f9f9ff';

            echo '<tr style="background-color:'.$color.'">' . "\n";
            echo '<td align="center">'.$import->fields_select($i).'</td>';
            echo '<td align="center">→</td>';
            echo '<td align="center">'.$import->fields_default_select($i).'</td>';
            echo '<td align="center">'.( isset($_array_general[$i] ) ? $_array_general[$i] : '').'</td>';
            echo '</tr>';

            $i++;
        }

        echo '</table>
        <input type="hidden" name="file_name" value="'.$import->file_name.'">
        <input type="hidden" name="delimeter" value="'.$import->delimeter.'">
        <input type="hidden" name="charset" value="'.$import->charset.'">
        <input type="hidden" name="sub" value="'.$import->sub.'">
        <br /> <input type="submit" value="OK"><br />
        </form>
        ';
    }  
    else
    {
        echo $import->lang['page2_error'].'<br /><a class="import" href="plugins_page.php?main_page=import_page1">'.$import->lang['page2_back'].'</a>';
    }

    echo '<br /></body></html>';
?>