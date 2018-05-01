<?php
/*
#####################################
#  ShopOS: Shopping Cart Software.
#  Copyright (c) 2008-2010
#  http://www.shopos.ru
#  http://www.shoposs.com
#  Ver. 1.1
#####################################
*/

  include('includes/top.php');
  @ ini_set('auto_detect_line_endings',TRUE);
  
  add_action('head_admin', 'head_admin_progress');
  
  
  function head_admin_progress()
  {
    _e( "
	<script type=\"text/javascript\">
	function s(st, colors){
	inner = document.getElementById('products_process');
	inner.innerHTML = inner.innerHTML + st+'<br />';
	inner.scrollTop += 25;
	inner.style.color = colors;
	}
	</script>");
  }
  
  include('includes/pages/import/func.php');
  
  $_step = 1;
  
  if (@$_GET['page']) 
  { 
     $_page_step = (int)$_GET['page'];
     switch ($_page_step)
	 {
	    case '1':
		   $_step = 1;
		break;
		
		case '2':
		   $_step = 2;
		break;
		
		case '3':
		   $_step = 3;
		break;
		
		default:
		   $_step = 1;
	 }
  }
 
 $main->head(); 
 $main->top_menu(); 

?>
 <table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="boxCenter" width="100%" valign="top">
		
    <?php os_header('database_go.png', HEADING_TITLE.' > '.IMPORT_STEP.' '.$_step.'/3'); ?> 
<?php

  if (isset($_GET['page']) && !empty($_GET['page'])) $_page = 'page'.(int)$_GET['page'].'.php'; else $_page = 'page1.php';
  
  if (is_file('includes/pages/import/'.$_page))
  {
     include('includes/pages/import/'.$_page);
  }
  else include('includes/pages/import/page1.php');
  

?>

	</td></tr></table>

	
<?php $main->bottom(); ?>