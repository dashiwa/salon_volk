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

function prepare_image($image) 
{
	$products_image_name = os_db_prepare_input($image);
	
	if(!is_file(dir_path('images_original') . $products_image_name)) return false;
	
	require_once(get_path('class_admin') . FILENAME_IMAGEMANIPULATOR);
	require(get_path('includes_admin') . 'product_thumbnail_images.php');
	require(get_path('includes_admin') . 'product_info_images.php');
	require(get_path('includes_admin') . 'product_popup_images.php');
	return $products_image_name;
}

function get_csv_header_fields($_file, $_delimeter) 
{ 
	
    global $get_csv_header_fields;
	
	if (empty($get_csv_header_fields))
	{
         $arr_csv_columns = '';
         $fpointer = fopen($_file, "r"); 

         if ($fpointer) 
         { 
             $arr = fgetcsv($fpointer, 10*1024, $_delimeter); 
	         fclose($fpointer); 
			 
	         if (!empty($arr))
			 {
	             foreach ($arr as $_num =>$_value) trim($arr[$_num]);
	         }
			 
			 $get_csv_header_fields = $arr;
			 
	         return $arr;
         } 
	}
	else
	{
	     return $get_csv_header_fields;
	}

    return 0; 
}

//возвращает массив всех значений полей  
function get_csv_array($_file, $_charset, $_delimeter, $_fields, $data_mapping_primary_col)
{
   $_fields_layer = get_csv_header_fields($_file, $_delimeter);

   $fp = fopen($_file, "r"); 
  
   $_products_csv = array();
   $i=0;
   
   while ($data = fgetcsv ($fp, 1000, $_delimeter)) 
   {
       if ($i != 0)
	   {
	       $num = count ($data);

           for ($c=0; $c < $num; $c++) 
	       {  
	            $_products_csv[$i][$_fields_layer[$c]] = @ iconv($_charset, 'UTF-8',  trim( $data[ $c ] ));
           }
	   }
	   $i++;
  }

  fclose($fp); 
  
  /* закинули весь файл в массив  $_products_csv*/
  
  $_products_csv_2 = '';
  $i = 0;
  /* теперь отфильтруем только нужные столбики */
  foreach ($_products_csv as $_value)
  {
     foreach($_fields as $_fields_1 => $_fields_2)
	 {
		if (isset($_value[$_fields_1]))
		{
		   $_products_csv_2[$i][$_fields_2] = $_value[$_fields_1];
		}
	 }
	 
	 if ($data_mapping_primary_col == 'products_model' && isset($_products_csv_2[$i][$data_mapping_primary_col]) && empty($_products_csv_2[$i][$data_mapping_primary_col]) )
	 {
	    unset( $_products_csv_2[$i] );
		$i--;
	 }
	 $i++;
  }
  
  return $_products_csv_2;
  
}  

function get_group_products_array($data_mapping_primary_col)
{
   $_products['update'] = array();//массив товаров, которые будут обновлены
   $_products['insert'] = array();//массив товаров, которые будут добавлены
   $_products['delete'] = array();//массив товаров, которые будут удалены 
   
   global $_charset;
   global $_delimeter;
   global $_fields;
   
   $_products_local = array();
   $_products_local = get_csv_array(_IMPORT.$_POST['file_name'], $_charset, $_delimeter, $_fields, $data_mapping_primary_col);

   //возвращает массив продуктов, которые есть в магазине, и которые нужно обновлять
   $_is_products = get_is_products_array($data_mapping_primary_col); //1 sql запрос

   $_products_tmp = ''; 
  
  //ошибки
   if (empty($_products_local)) die('Не выбрано ни одно поле для импорта или нет ни одного товара для обновления-добавления <br /><a href="javascript:history.back(1)" class="button"><span>Назад</span></a>');
   if ( count($_fields) < 2) die('Для импорта нужно как минимум 2 поля <br /><a href="javascript:history.back(1)" class="button"><span>Назад</span></a>');
   $_error = true;
   
   // проверка. указано ли ключевое поле
   foreach ($_fields as $_fields_tmp)
   {
      if ( $_fields_tmp == $data_mapping_primary_col ) 
	  {
	     $_error = false; 
	  }
   }
   
  if ( $_error == true ) die('Нужно указать ключевое поле <br /><a href="javascript:history.back(1)" class="button"><span>Назад</span></a>');
   
   foreach ($_products_local as $_value)
   { 
      $__value = set_products_value_filter($_value);
     
      if (isset($__value['EOREOR'])) unset($__value['EOREOR']);
	  
      if (empty($__value[$data_mapping_primary_col]))
	  {
	      $_products['error'][] = $__value; /* нужно назначать свой $data_mapping_primary_col, т.к. он пустой */
	  }
	  else
	  {
	     if (isset($_is_products[$__value[$data_mapping_primary_col]])) 
		 {
             if (isset($__value['action']) && $__value['action']=='delete')
			 {
			     /* если action = delete  - добавить в список на удаление*/
			     $_products['delete'][] = array($data_mapping_primary_col => $__value[$data_mapping_primary_col]);
			 }
			 else
			 {
		         $_products['update'][] = $__value;
		     }
		 }
		 else
		 {
		     $_products['insert'][] = $__value; /* не нужно назначать свой $data_mapping_primary_col */
		 }
	  }

   }
   
   return $_products;
}

//возвращает массив продуктов, которые есть
function get_is_products_array($data_mapping_primary_col)
{
    if (empty($data_mapping_primary_col)) $data_mapping_primary_col = 'products_id'; 
    
	$filelayout_sql = "SELECT p.products_id as products_id, p.products_model as products_model FROM ".TABLE_PRODUCTS." p where p.".$data_mapping_primary_col." <> ''";
	 /* разделяем те товары, которые нужно обновить и те, которые нужно добавить	
допустим главное поле v_products_id

тогда смотрим массив v_products_id из csv файла и проверяем, есть ли аналогичные из массива $_is_products

если есть - добавляем в очередь обновления, если нет - в очередь добавления
  */	
  
	 $p_query  = os_db_query($filelayout_sql);	
	 
	 $_is_products = '';
	 
	  if (os_db_num_rows($p_query,true)) 
	  {
		   while ($products = os_db_fetch_array($p_query,true))  
           {
	             $_is_products[$products[$data_mapping_primary_col]] = 1;	 
           } 
      }
	  
	  return $_is_products;
}

function set_products_value_filter($_value)
{
   //фильтруем данные, приводим к нужным типам. все перепроверяем
   
   if (isset($_value['products_quantity'])) $_value['products_quantity'] = (int)$_value['products_quantity'];
   if (isset($_value['products_id'])) $_value['products_id'] = (int)$_value['products_id'];
   //сортировка
   if (isset($_value['products_sort'])) $_value['products_sort'] = (int)$_value['products_sort'];
   if (isset($_value['products_name'])) $_value['products_name'] = mysql_real_escape_string($_value['products_name']);
   
   //статус продукта
   if (isset($_value['products_status'])) 
   {
      $_value['products_status'] = strtolower( $_value['products_status'] );
	  if ($_value['products_status'] == 'active') $_value['products_status'] = 1;
	  elseif ($_value['products_status'] == 'inactive') $_value['products_status'] = 0;
	  elseif($_value['products_status'] == 'true') $_value['products_status'] = 1;
	  elseif($_value['products_status'] == 'false') $_value['products_status'] = 0;
	  
	  if ($_value['products_status'] != 1 && $_value['products_status'] != 0) $_value['products_status'] = 0;
   }
   if (isset($_value['products_page_url'])) $_value['products_page_url'] = mysql_real_escape_string($_value['products_page_url']);
   if (isset($_value['products_model'])) $_value['products_model'] = mysql_real_escape_string($_value['products_model']);
   if (isset($_value['products_image'])) $_value['products_image'] = mysql_real_escape_string($_value['products_image']);
   if (isset($_value['products_price'])) $_value['products_price'] = (int)mysql_real_escape_string($_value['products_price']);
   if (isset($_value['products_date_available'])) $_value['products_date_available'] = mysql_real_escape_string($_value['products_date_available']);
   if (isset($_value['products_weight'])) $_value['products_weight'] = mysql_real_escape_string($_value['products_weight']);
   if (isset($_value['action'])) $_value['action'] = trim(strtolower($_value['action']));
   
   return $_value;
}


function get_products_model_id ( $id, $data_mapping_primary_col )
{
   global $get_products_id_model_cache;
   
   if (empty($get_products_id_model_cache))
   {
      $p_query  = os_db_query('select products_id, products_model from '.TABLE_PRODUCTS." where products_model <> ''");	
	
	  if (os_db_num_rows($p_query,true)) 
	  {
		   while ($products = os_db_fetch_array($p_query,true))  
           {
	             $get_products_id_model_cache[ $products['products_model'] ] = $products['products_id'];	 
           } 
      }

	  if ( empty($get_products_id_model_cache) ) $get_products_id_model_cache = 1;
	  
	  if ($data_mapping_primary_col == 'products_model')
	  {
	     if ( isset($get_products_id_model_cache[ $id ]) )  return $get_products_id_model_cache[ $id ];
	     else return 0;
	  }
	  elseif ($data_mapping_primary_col == 'products_id')
	  {
	     return $id;
	  }
   }
   else
   {
     if ($data_mapping_primary_col == 'products_model')
	  {
	     if ( isset($get_products_id_model_cache[ $id ]) )  return $get_products_id_model_cache[ $id ];
	     else return 0;
	  }
	  elseif ($data_mapping_primary_col == 'products_id')
	  {
	     return $id;
	  }
   }   
}

/* обновляем информацию о товарах */
function set_products_update($_products_group_update, $data_mapping_primary_col)
{ 
   $log = array();
   $log['count'] = 0;
 
    //поля таблицы os_products
   $_field_products = array('products_id'=> 1,
   'products_quantity'=> 1,
   'products_model'=> 1,
   'products_sort'=> 1,
   'products_image'=> 1,
   'products_price'=> 1,
   'products_date_available'=> 1,
   'products_weight'=> 1,
   'products_status'=> 1,
   'products_ean'=> 1,
   'products_page_url'=> 1
   );
   
   //поля таблицы os_products_description
   $_field_products_desc = array('products_name'=> 1,
   'products_description'=> 1,
   'products_short_description'=> 1,
   'products_keywords'=> 1,
   'products_meta_title'=> 1,
   'products_meta_description'=> 1,
   'products_meta_keywords'=> 1,
   'products_url'=> 1
   );
   
   $sql_start = 'update '.DB_PREFIX."products set";
   $sql_start_pd = 'update '.DB_PREFIX."products_description set";
   
   foreach ($_products_group_update as $_value)
   {
       $start = 0;
	   $sql = '';
	   
	   $start_pd = 0;
	   $sql_pd = '';
	   $sql_where_value = '';
	   
	   //фильтруем данные, приводим к нужным типам. все перепроверяем
	
	   $_value = set_products_value_filter ($_value);

        foreach ($_value as $_val => $_value_sql)
		{ 
		
		   $_value_sql = mysql_real_escape_string($_value_sql);

		   //поля таблицы os_products
		   if (isset($_field_products[$_val])) 
		   {
		       if ($_val != $data_mapping_primary_col)
			   {
	    	      if ($start==0)   
			      {
			         $sql .= " $_val = '$_value_sql'";
			      }
			      else 
			      {
			         $sql .= ", $_val = '$_value_sql'";
			      }
				  
				  $start++;
			   }
			   else
			   { 
			            add_products_process ('<b>Обновлен</b> '.$data_mapping_primary_col.' = '.$_value_sql, 'green');
			            $sql_where = "where $_val = '$_value_sql';";
						$sql_where_value = $_value_sql;
			   }
			   
		   //поля таблицы os_products_descriptio   
		   }elseif (isset($_field_products_desc[$_val]))
		   {
		       if ($_val != $data_mapping_primary_col)
			   {
	    	      if ($start_pd==0)   
			      {
			         $sql_pd .= " $_val = '$_value_sql'";
			      }
			      else 
			      {
			         $sql_pd .= ", $_val = '$_value_sql'";
			      }
				  
				  $start_pd++;
			   }

		   }
		   
		} 
		
        if ($sql or $sql_pd)
		{
			 $log['count']++;
		}
		
		if ($sql && !empty($sql_where) )
		{
		    $sql = $sql_start.' '.$sql.' '.$sql_where;
			@ os_db_query($sql);
		}
		
		if ($sql_pd)
		{
		    $sql_where_pd = "where products_id = '" . get_products_model_id($sql_where_value, $data_mapping_primary_col). "'";
		    $sql_pd = $sql_start_pd.' '.$sql_pd.' '.$sql_where_pd;
			@ os_db_query($sql_pd);
		}
		
	
				             
   }
   
   return $log;
}

function set_products_delete($_products_group_delete, $data_mapping_primary_col)
{
    $log = array();
    $log['count'] = 0;
   
    if ($_products_group_delete)
	{
	   $start = 0;
	   
	   foreach ($_products_group_delete as $_value)
	   {
	        $log['count']++;
		//	$log['value'][] = '<b>'.$data_mapping_primary_col.'</b>='.$_value[$data_mapping_primary_col].': '.IMPORT_DELETE;
			
	     	if ($start==0)   
			{
			      $sql .= $_value[$data_mapping_primary_col];
			}
			else 
			{
			      $sql .= ",".$_value[$data_mapping_primary_col];
			} 
			
			 add_products_process ('<b>Удален</b> '.$data_mapping_primary_col.' = '.$_value[$data_mapping_primary_col], 'red');
			 
			$start++;
	   }
	   
	   $sql_end = 'delete from '.DB_PREFIX.'products where '.$data_mapping_primary_col.' in ('.$sql.')';
	   
	   @ os_db_query($sql_end);
	   
	   return $log;
	}
	else
	{
	   return 0;
	}
}


function set_products_insert($_products_group_insert, $data_mapping_primary_col)
{
   $sql_count = 5;
   if ($_products_group_insert)
   {
       $log = array();

       $_field_products = array('products_id'=>1,
   'products_quantity'=>1,
   'products_model'=>1,
   'products_sort'=>1,
   'products_image'=>1,
   'products_price'=>1,
   'products_date_available'=>1,
   'products_weight'=>1,
   'products_status'=>1,
   'products_ean'=>1,
   'products_page_url'=>1
       );
	      $_field_products_desc = array('products_id'=>1, 
   'products_name'=>1,
   'products_description'=>1,
   'products_short_description'=>1,
   'products_keywords'=>1,
   'products_meta_title'=>1,
   'products_meta_description'=>1,
   'products_meta_keywords'=>1,
   'products_url'=>1
   );
	   
        $sql_start = 'insert into '.DB_PREFIX."products";
        $sql_start_desc = 'insert into '.DB_PREFIX."products_description";
	    $start = '';
	    $start_pd = '';
		$sql_col = '';
		$sql_value ='';		
		
		$sql_col_pd = '';
		$sql_value_pd ='';
		
		
		$_query_p = '';
		$_query_p_desc = array();
		$_query_fields = array();
		$_query_fields_desc = array();
        $_start_field = 0;
		$_start_field_desc = 0;
		$_col = 0;
		
		$_products_count = count($_products_group_insert);
		
		foreach ($_products_group_insert as $_value)
        { 
            foreach ($_value as $_val => $_value_sql)
		    { 
			 if (isset($_field_products[$_val]))
		     {
 
			      if ($_start_field == 0)
				  {
				       $_query_fields[] = $_val;
				  }
				  
				  $_sql_value[] = "'".mysql_real_escape_string($_value_sql)."'";
				  
				  $start++;
		     }
			 
			 //для products_description
			 if (isset( $_field_products_desc[$_val]))
			{
			      if ($_start_field_desc == 0)
				  {
				       $_query_fields_desc[] = $_val;
				  }
				 

                 $_sql_value_desc[] = "'".mysql_real_escape_string($_value_sql)."'";
	
			}
			    
           }

		   add_products_process ('<b>Добавлен</b> '.$data_mapping_primary_col.' = '.$_value[$data_mapping_primary_col], 'green');
         		 

		  $_query_p_desc[] = '(' . @ implode(", ", $_sql_value_desc) . ')';
		  $_query_p[] = '(' . @ implode(", ", $_sql_value) . ')';
		  
		  $_sql_value_desc = array();
		  $_sql_value = array();

		  //формирования и выполнение запроса для добавления товара
		  if ( ($_col % 5 + 1) == $sql_count or $_products_count == $_col+1)
		  {
		        if ( !empty($_query_p) )
		        {
				
				       if ( count ($_query_fields) > 0 )
					   {
		                   $__query_fields = '('.implode(", ", $_query_fields).')';
		                   $__query_p = implode(", ", $_query_p);
		                   os_db_query( $sql_start.' '.$__query_fields.' values '.$__query_p.';');
					   }

					   if ( count($_query_fields_desc) > 0 )
					   {
		                  $__query_fields_desc = '('.implode(", ", $_query_fields_desc).')';
					      $__query_p_desc = implode(", ", $_query_p_desc);
					      os_db_query( $sql_start_desc.' '.$__query_fields_desc.' values '.$__query_p_desc.';');
					   }

					   $_start_field = 0;
					
					   $_query_p_desc = array();
					   $_query_p = array();
					   
					   
		        }
		   }

		    $_col++;
		   	$sql_col = '';
			$sql_value  = '';
			$sql_value_desc  = '';
			$start = 0;
		    $_start_field = 1;
		    $_start_field_desc = 1;
			 
			$log['count']++;
			
		}	     
		
	   
		
		return $log;
   }
   else 
   {
      return false;
   }
}

function add_products_process( $msg, $color )
{ 
    echo "<script>s('" .$msg . "', 'blue');</script>\n";
}

?>