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
   $_var3 = '?main_page=banner_statistics_page&';


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

    
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr><?php echo os_draw_form('year', FILENAME_PLUGINS_PAGE.$_var3, '', 'get'); ?>
            <td class="pageHeading" align="right"><?php echo os_draw_separator('pixel_trans.gif', '1'); ?></td>
            <td class="main" align="right"><?php echo TITLE_TYPE . ' ' . os_draw_pull_down_menu('type', $type_array, (($_GET['type']) ? $_GET['type'] : 'daily'), 'onChange="this.form.submit();"'); ?><br />
<?php
  switch ( $_GET['type'] ) 
  {
    case 'yearly': break;
    case 'monthly':
      echo TITLE_YEAR . ' ' . os_draw_pull_down_menu('year', $years_array, (($_GET['year']) ? $_GET['year'] : date('Y')), ' onchange="top.location.href=this.options[this.selectedIndex].value"');
      break;
    default:
	
    case 'daily':
      echo TITLE_MONTH . ' ' . os_draw_pull_down_menu('month', $months_array, (($_GET['month']) ? $_GET['month'] : date('n')), 'onChange="this.form.submit();"') . '<br />' . TITLE_YEAR . ' ' . os_draw_pull_down_menu('year', $years_array, (($_GET['year']) ? $_GET['year'] : date('Y')), 'onChange="this.form.submit();"') ;
      break;
  }
?>
            </td>
          <?php echo os_draw_hidden_field('page', $_GET['_page']) . os_draw_hidden_field('bID', $_GET['bID']); ?></form></tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo os_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="center">
      <table border="0" width="600" cellspacing="2" cellpadding="2">
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

        </td>
      </tr>
      <tr>
        <td><?php echo os_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right"><?php echo '<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_PLUGINS_PAGE, $_var3.'_page=' . $_GET['_page'] . '&bID=' . $_GET['bID']) . '"><span>' . BUTTON_BACK . '</span></a>'; ?></td>
      </tr>
    </table>