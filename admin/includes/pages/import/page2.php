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


defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

function get_fields_list($_fields)
{
    echo '<i style="font-size:12px;">';
	
    foreach ($_fields as $_value)
    {
	   echo $_value.', ';
	}
	
	echo '</i>';
}

if (isset($_POST['delimeter']))
{
   if ($_POST['delimeter']=='tab') $_delimeter = "	";
   else $_delimeter = $_POST['delimeter'];
}
else
{
   die('no delimeter!');
}

//поля для импорта
$_default_fields = array(
'products_id' => IMPORT_ID,
'products_model' => IMPORT_MODEL,
'products_name' => IMPORT_NAME,
'products_price' => IMPORT_PRICE,
'products_page_url' => IMPORT_PAGE_URL,
'products_image' => IMPORT_IMAGE,
'products_quantity' => IMPORT_QUANTITY,
'products_description' => IMPORT_DESCRIPTION,
'products_short_description' => IMPORT_SHORT_DESCRIPTION,
'products_keywords' => 'keywords',
'products_url' => 'URL товара',
'products_weight' => IMPORT_WEIGHT,
'date_added' => IMPORT_DATE_ADDED,
'products_sort' => IMPORT_SORT,
'manufacturers_name' => IMPORT_MANUFACTURERS_NAME,
'products_status' => IMPORT_STATUS,
'products_ean' => IMPORT_EAN,
'products_meta_title' => 'Meta Title',
'products_meta_description' => 'Meta Description',
'products_meta_keywords' => 'Meta Keywords',
'action' => IMPORT_ACTION,
'categories_name_1' => 'categories_name_1',
'categories_name_2' => 'categories_name_2',
'categories_name_3' => 'categories_name_3',
'categories_name_4' => 'categories_name_4',
'categories_name_5' => 'categories_name_5',
'categories_name_6' => 'categories_name_6',
'categories_name_7' => 'categories_name_7'
);   
//'tax_class_title' => 'v_tax_class_title',
/*
'date_avail' => 'v_date_avail',
v_mo_image_1
v_mo_image_2
v_mo_image_3
v_mo_image_4
v_mo_image_5
v_mo_image_6
v_mo_image_7
v_mo_image_8
v_mo_image_9
v_mo_image_10
v_tax_class_title
stock
fsk18
priceNoTax
tax
p_vpe
p_vpe_status
p_vpe_value
p_shipping
*/

if (is_uploaded_file($_FILES['csv']['tmp_name']) && isset($_POST['charset']) && isset($_POST['delimeter']))
{
   $_explode = explode('.', $_FILES['csv']['name']);
   
   if (count($_explode)==1) 
   {
       $_file_type = $_POST['sub'] == 'excel_import' ? 'csv' : 'txt';

	   $_FILES['csv']['name'] = $_FILES['csv']['name'].'_'.date("Y-m-d").'.'.$_file_type;
   }
   else 
   {
       $_file_type = $_explode[count($_explode)-1];
	   unset($_explode[count($_explode)-1]); 
	   $_file_name = implode('.', $_explode);
	   $_FILES['csv']['name'] = $_file_name.'_'.date("Y-m-d").'.'.$_file_type;
   }
      
  
   $csv_upload = os_try_upload('csv', _IMPORT);
  // date("Y-m-d_H-i")
}
elseif ( isset($_POST['downloaded_file_name']) && !empty( $_POST['downloaded_file_name'] ) &&  is_file( _IMPORT.$_POST['downloaded_file_name'] ) )
{
   $_FILES['csv']['name'] = $_POST['downloaded_file_name'];
   $_FILES['csv']['size'] = filesize (_IMPORT. $_POST['downloaded_file_name']);
   $_FILES['csv']['type'] = 'text/plain';
}
else
{
  // $post_max = (int)ini_get('post_max_size');
  // $max_filesize = (int)ini_get('upload_max_filesize');
   
 //  echo $max_filesize.$post_max ;
   echo 'error downloads!';
}

  $_fields_array = get_csv_header_fields(_IMPORT.$_FILES['csv']['name'], $_delimeter);


   echo '<b>'.IMPORT_PAGE2_FILENAME.' '.$_FILES['csv']['name'].'<br>';
   echo IMPORT_PAGE2_FILESIZE.' '.os_format_filesize($_FILES['csv']['size']).'</b><br>';

// В закачанном файле обнаружены следующие колонки ...
  echo IMPORT_PAGE2_TEXT1;

function fields_select($array, $_num)
{
    $value = '';
    $value .= '<select name="field['.$_num.']">';
	$value .= '<option value="0" style="color:grey"> - пропустить этот столбец -</option>';
	$i = '0';

	//print_r($array);
    foreach ($array as $_value)
    {
	   if ($_value != 'EOREOR') $value .= '<option value="'.$_value.'">'.$i.':'.' '.$_value.'</option>';
	   $i++;
    }  
	$value .= '</select>';
   return $value;
}

function fields_default_select($_num)
{
    global $_default_fields;
	
	$name = 'name_';
    $value = '';
	$i = '0';
	
    foreach ($_default_fields as $_name => $_value)
    {
       if ($i == $_num)
	   {
	       $value = '<input type="hidden" value="'.$_name.'" name="field_1['.$_num.']">'.$_value;
	   }
	   
	   $i++;
    }   

   return $value;
}

//Колонки идентификации
$_array_general[] = '<input type="radio" checked name="general" value="products_id">';
$_array_general[] = '<input type="radio" name="general" value="products_model">';
//$_array_general[] = '<input type="radio" name="general" value="products_name">';

if ($_fields_array)
{
   echo '<br>В CSV-файле найдено '.count($_fields_array).' колонок<br>';
   get_fields_list($_fields_array);
   echo '<br />';
   echo '<br /><form action="import.php?page=3" method="POST">';
   echo '<table cellspacing="2" cellpadding="2">';
   echo '<tr>';
   echo '<td align="center"><b>Колонки в CSV-файле</b></td>';
   echo '<td align="center">&nbsp;</td>';
   echo '<td align="center"><b>Поля в базе данных</b></td>';
   echo '<td align="center"><b>Колонка идентификации:</b></td>';
   echo '</tr>';
   
   $i = 0;
   
   $color = '';
   
   foreach ($_fields_array as $_tmp)
   {
      $color = $color == '#f9f9ff' ? '#f0f1ff':'#f9f9ff';
	  
	  echo '<tr style="background-color:'.$color.'">' . "\n";
      echo '<td align="center">'.fields_select($_fields_array, $i).'</td>';
      echo '<td align="center">→</td>';
      echo '<td align="center">'.fields_default_select($i).'</td>';
      echo '<td align="center">'.(isset($_array_general[$i])?$_array_general[$i]:'').'</td>';
      echo '</tr>';
	  
	  $i++;
   }

   echo '</table>
   <input type="hidden" name="file_name" value="'.$_FILES['csv']['name'].'">
   <input type="hidden" name="delimeter" value="'.$_POST['delimeter'].'">
   <input type="hidden" name="charset" value="'.$_POST['charset'].'">
   <input type="hidden" name="sub" value="'.$_POST['sub'].'">
  <br /> <input type="submit" value="OK"><br />
   </form>
   ';
}  

  echo '<br />';
?>