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

function category_level_count($foo_to, $_name)
{
   $count = 0;
   
     foreach ($foo_to as $__name => $__value)
	 {
	      if ($__value['parent'] == $_name)
	          {
			    $count ++;
			  }
	 }
	 
	 return $count;
}

$categories_string = '';

$categories_query = osDBquery(	"select c.categories_id,
									cd.categories_name,
									c.parent_id from " .
									TABLE_CATEGORIES . " c, " .
									TABLE_CATEGORIES_DESCRIPTION . " cd
									where c.categories_status = '1'
									and c.categories_id = cd.categories_id
									and cd.language_id='" . (int)$_SESSION['languages_id'] ."'
									order by sort_order, cd.categories_name");
									

if (os_db_num_rows($categories_query,true)) 
{

while ($categories = os_db_fetch_array($categories_query,true))  
{
	$foo[$categories['categories_id']] = array(	'name' => $categories['categories_name'],
												'parent' => $categories['parent_id']);
}
}

if ($foo)
{

$_style = get_option('top_filter_style');

if (!empty($_style ))
{
  echo '<style>';
  echo $_style;
  echo '</style>';
}
?>




<table border="0" width="100%">
<tr>
   <?php
    $count = 0;
	$foo_to = $foo;
	$top_filter_cat = get_option('top_filter_cat');
	
    foreach ($foo as $_name => $_value)
    {
    
       if ($_value['parent'] == 0)
	   {
	      $_cat_check = false; 
		
		  if ($top_filter_cat == 'top_filter_cat_true')
		  {
		     //не проверяем категорию на кол. подкатегорий
			 
			 $_cat_check = true;
		  }
		  
		  if ($top_filter_cat == 'top_filter_cat_false' && category_level_count($foo_to, $_name) != 0)
		  {
             //если в категории нет подкатегорий 2ого уровня - нен выводить категорию вообще.
   		     $_cat_check = true;
		  }
		  
		  
          if ($_cat_check)	
          {		   
		         $_count = os_count_products_in_category($_name);
				 
				 //если кол. = 0 - ничего не выводить
				 $__count = '';
				 if ($_count != 0) $__count = '('.$_count.')';
				 
	             echo  '<td width="33%" class="rcat_table">'.'<a class="rcat_root_category" href="' . os_href_link(FILENAME_DEFAULT, os_category_link($_name, $_value['name']) ) . '">'.$_value['name'].'</a> '.$__count.' <br /><div class="rcat_child_categories">';
	
	
	             $_cat_2 = 0;
				 $_one = 0;
				 
		         foreach ($foo_to as $__name => $__value)
		         {
		              if ($__value['parent'] == $_name)
	                  { 
					 
			              $_cat_2++;
						
 						  if ($_one != 0) 
						  {
						      echo ",";
							  echo "\n"; 
						  }
						  
				          echo '<a href="' . os_href_link(FILENAME_DEFAULT, os_category_link($__name, $__value['name']) ) . '">'.$__value['name'].'</a>';          
						  
						  
				          if ($_cat_2 == 5) break;
						  
						  $_one++;
			           }
			  
		         }
		  echo '</td>';
		    
		  $count++;
		  
		  if ( $count >= 3) 
		  {
		      echo '</tr><tr>';
			  $count = 0;
		  }
	  }
		  
	   }
      
   }
   ?>
   </tr></table>
   
<?php
  //выводить разделитель
  if (get_option('top_filter_hr_check') == 'top_filter_hr_check_true')
  {
     echo get_option('top_filter_hr');
  }
}

?>