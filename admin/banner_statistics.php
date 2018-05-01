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

  require('includes/top.php');
  $banner_extension = os_banner_image_extension();

  $dir_ok = false;
  if ( (function_exists('imagecreate')) && ($banner_extension) ) {
   if (is_dir(DIR_FS_ADMIN.'images/graphs')) {
     
   	 if (is_writeable(DIR_FS_ADMIN.'images/graphs')) {
        $dir_ok = true;
      } else {
        $messageStack->add(ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE, 'error');
      }
	  
    } else {
      $messageStack->add(ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST, 'error');
    }
  }

  $banner_query = os_db_query("select banners_title from " . TABLE_BANNERS . " where banners_id = '" . $_GET['bID'] . "'");
  $banner = os_db_fetch_array($banner_query);

  $years_array = array();
  $years_query = os_db_query("select distinct year(banners_history_date) as banner_year from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . $_GET['bID'] . "'");
  while ($years = os_db_fetch_array($years_query)) {
    $years_array[] = array('id' => $years['banner_year'],
                           'text' => $years['banner_year']);
  }

  $months_array = array();
  for ($i=1; $i<13; $i++) {
    $months_array[] = array('id' => $i,
                            'text' => strftime('%B', mktime(0,0,0,$i)));
  }

  $type_array = array(array('id' => 'daily',
                            'text' => STATISTICS_TYPE_DAILY),
                      array('id' => 'monthly',
                            'text' => STATISTICS_TYPE_MONTHLY),
                      array('id' => 'yearly',
                            'text' => STATISTICS_TYPE_YEARLY));
?>
<?php $main->head(); ?>
<?php $main->top_menu(); ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="boxCenter" width="100%" valign="top">
    
    <?php os_header('portfolio_package.gif',HEADING_TITLE); ?> 
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr><?php echo os_draw_form('year', FILENAME_BANNER_STATISTICS, '', 'get'); ?>
            <td class="pageHeading" align="right"><?php echo os_draw_separator('pixel_trans.gif', '1', HEADING_IMAGE_HEIGHT); ?></td>
            <td class="main" align="right"><?php echo TITLE_TYPE . ' ' . os_draw_pull_down_menu('type', $type_array, (($_GET['type']) ? $_GET['type'] : 'daily'), 'onChange="this.form.submit();"'); ?><noscript><span class="button"><button type="submit" value="GO">GO</button></span></noscript><br />
<?php
  switch ($_GET['type']) {
    case 'yearly': break;
    case 'monthly':
      echo TITLE_YEAR . ' ' . os_draw_pull_down_menu('year', $years_array, (($_GET['year']) ? $_GET['year'] : date('Y')), 'onChange="this.form.submit();"') . '<noscript><span class="button"><button type="submit" value="GO">GO</button></span></noscript>';
      break;
    default:
    case 'daily':
      echo TITLE_MONTH . ' ' . os_draw_pull_down_menu('month', $months_array, (($_GET['month']) ? $_GET['month'] : date('n')), 'onChange="this.form.submit();"') . '<noscript><span class="button"><button type="submit" value="GO">GO</button></span></noscript><br />' . TITLE_YEAR . ' ' . os_draw_pull_down_menu('year', $years_array, (($_GET['year']) ? $_GET['year'] : date('Y')), 'onChange="this.form.submit();"') . '<noscript><span class="button"><button type="submit" value="GO">GO</button></span></noscript>';
      break;
  }
?>
            </td>
          <?php echo os_draw_hidden_field('page', $_GET['page']) . os_draw_hidden_field('bID', $_GET['bID']); ?></form></tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo os_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="center">
<?php
  if ( (function_exists('imagecreate')) && ($dir_ok) && ($banner_extension) ) {
    $banner_id = $_GET['bID'];
    switch ($_GET['type']) {
      case 'yearly':
        include(get_path('includes_admin') . 'graphs/banner_yearly.php');
        echo os_image(http_path('images_admin') . 'graphs/banner_yearly-' . $banner_id . '.' . $banner_extension);
        break;
      case 'monthly':
        include(get_path('includes_admin') . 'graphs/banner_monthly.php');
        echo os_image(http_path('images_admin') . 'graphs/banner_monthly-' . $banner_id . '.' . $banner_extension);
        break;
      default:
      case 'daily':
        include(get_path('includes_admin') . 'graphs/banner_daily.php');
        echo os_image(http_path('images_admin') . 'graphs/banner_daily-' . $banner_id . '.' . $banner_extension);
        break;
    }
?>
          <table border="0" width="600" cellspacing="0" cellpadding="2">
            <tr class="dataTableHeadingRow">
             <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SOURCE; ?></td>
             <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_VIEWS; ?></td>
             <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_CLICKS; ?></td>
           </tr>
<?php
 
    for ($i = 0, $n = sizeof($stats); $i < $n; $i++) 
	{
	      $color = $color == '#f9f9ff' ? '#f0f1ff':'#f9f9ff';
      echo '            <tr class="dataTableRow" onmouseover="this.style.background=\'#e9fff1\';this.style.cursor=\'hand\';" onmouseout="this.style.background=\''.$color.'\';" style="background-color:'.$color.'">' . "\n" .
           '              <td class="dataTableContent">' . $stats[$i][0] . '</td>' . "\n" .
           '              <td class="dataTableContent" align="center">' . number_format($stats[$i][1]) . '</td>' . "\n" .
           '              <td class="dataTableContent" align="center">' . number_format($stats[$i][2]) . '</td>' . "\n" .
           '            </tr>' . "\n";
    }
?>
          </table>
<?php
  } else {
    include(dir_path('func_admin') . 'html_graphs.php');
    switch ($_GET['type']) {
      case 'yearly':
        echo os_banner_graph_yearly($_GET['bID']);
        break;
      case 'monthly':
        echo os_banner_graph_monthly($_GET['bID']);
        break;
      default:
      case 'daily':
        echo os_banner_graph_daily($_GET['bID']);
        break;
    }
  }
?>
        </td>
      </tr>
      <tr>
        <td><?php echo os_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right"><?php echo '<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $_GET['bID']) . '"><span>' . BUTTON_BACK . '</span></a>'; ?></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php $main->bottom(); ?>