<?php
/*
#####################################
#  ShopOS: Shopping Cart Software.
#  Copyright (c) 2008-2010
#  http://www.shopos.ru
#  http://www.shoposs.com
#  Ver. 1.0.1
#####################################
*/

defined( '_VALID_OS' ) or die( 'Прямой доступ  не допускается.' );

  function html_graph($names, $values, $bars, $vals, $dvalues = 0, $dbars = 0) {

    $er = error_reporting(1);

    $vals = hv_graph_defaults($vals);
    $html_graph_string = start_graph($vals, $names);

    if ($vals['type'] == 0) {
      $html_graph_string .= horizontal_graph($names, $values, $bars, $vals);
    } elseif ($vals['type'] == 1) {
      $html_graph_string .= vertical_graph($names, $values, $bars, $vals);
    } elseif ($vals['type'] == 2) {
      $html_graph_string .= double_horizontal_graph($names, $values, $bars, $vals, $dvalues, $dbars);
    } elseif ($vals['type'] == 3) {
      $html_graph_string .= double_vertical_graph($names, $values, $bars, $vals, $dvalues, $dbars);
    }

    $html_graph_string .= end_graph();

    error_reporting($er);  

    return $html_graph_string;
  }


  function html_graph_init() {
    $vals = array('vlabel'=>'',
                  'hlabel'=>'',
                  'type'=>'',
                  'cellpadding'=>'',
                  'cellspacing'=>'',
                  'border'=>'',
                  'width'=>'',
                  'background'=>'',
                  'vfcolor'=>'',
                  'hfcolor'=>'',
                  'vbgcolor'=>'',
                  'hbgcolor'=>'',
                  'vfstyle'=>'',
                  'hfstyle'=>'',
                  'noshowvals'=>'',
                  'scale'=>'',
                  'namebgcolor'=>'',
                  'valuebgcolor'=>'',
                  'namefcolor'=>'',
                  'valuefcolor'=>'',
                  'namefstyle'=>'',
                  'valuefstyle'=>'',
                  'doublefcolor'=>'');

    return($vals);
  }


  function start_graph($vals, $names) {
    $start_graph_string = '<table cellpadding="' . $vals['cellpadding'] . '" cellspacing="' . $vals['cellspacing'] . '" border="' . $vals['border'] . '"';

    if ($vals['width'] != 0) $start_graph_string .= ' width="' . $vals['width'] . '"';
    if ($vals['background']) $start_graph_string .= ' background="' . $vals['background'] . '"';

    $start_graph_string .= '>' . "\n";

    if ( ($vals['vlabel']) || ($vals['hlabel']) ) {
      if ( ($vals['type'] == 0) || ($vals['type'] == 2) ) {

        $rowspan = sizeof($names) + 1; 
        $colspan = 3; 
      } elseif ( ($vals['type'] == 1) || ($vals['type'] == 3) ) {

        $rowspan = 3;
        $colspan = sizeof($names) + 1; 
      }

      $start_graph_string .= '  <tr>' . "\n" .
                             '    <td align="center" valign="center"';


      if (!$vals['background']) $start_graph_string .= ' bgcolor="' . $vals['hbgcolor'] . '"';

      $start_graph_string .= ' colspan="' . $colspan . '"><font color="' . $vals['hfcolor'] . '" style="' . $vals['hfstyle'] . '"><b>' . $vals['hlabel'] . '</b></font></td>' . "\n" .
                             '  </tr>' . "\n" .
                             '  <tr>' . "\n" .
                             '    <td align="center" valign="center"';


      if (!$vals['background']) $start_graph_string .= ' bgcolor="' . $vals['vbgcolor'] . '"';

      $start_graph_string .=  ' rowspan="' . $rowspan . '"><font color="' . $vals['vfcolor'] . '" style="' . $vals['vfstyle'] . '"><b>' . $vals['vlabel'] . '</b></font></td>' . "\n" .
                              '  </tr>' . "\n";
    }

    return $start_graph_string;
  }


  function end_graph() {
    return '</table>' . "\n";
  }


  function hv_graph_defaults($vals) {
    if (!$vals['vfcolor']) $vals['vfcolor'] = '#000000';
    if (!$vals['hfcolor']) $vals['hfcolor'] = '#000000';
    if (!$vals['vbgcolor']) $vals['vbgcolor'] = '#FFFFFF';
    if (!$vals['hbgcolor']) $vals['hbgcolor'] = '#FFFFFF';
    if (!$vals['cellpadding']) $vals['cellpadding'] = '0';
    if (!$vals['cellspacing']) $vals['cellspacing'] = '0';
    if (!$vals['border']) $vals['border'] = '0';
    if (!$vals['scale']) $vals['scale'] = '1';
    if (!$vals['namebgcolor']) $vals['namebgcolor'] = '#FFFFFF';
    if (!$vals['valuebgcolor']) $vals['valuebgcolor'] = '#FFFFFF';
    if (!$vals['namefcolor']) $vals['namefcolor'] = '#000000';
    if (!$vals['valuefcolor']) $vals['valuefcolor'] = '#000000';
    if (!$vals['doublefcolor']) $vals['doublefcolor'] = '#886666';

    return $vals;
  }


  function horizontal_graph($names, $values, $bars, $vals) {
    $horizontal_graph_string = '';
    for($i = 0, $n = sizeof($values); $i < $n; $i++) { 
      $horizontal_graph_string .= '  <tr>' . "\n" .
                                  '    <td align="right"';
      if (!$vals['background']) $horizontal_graph_string .= ' bgcolor="' . $vals['namebgcolor'] . '"';

      $horizontal_graph_string .= '><font size="-1" color="' . $vals['namefcolor'] . '" style="' . $vals['namefstyle'] . '">' . $names[$i] . '</font></td>' . "\n" .
                                  '    <td'; 

      if (!$vals['background']) $horizontal_graph_string .= ' bgcolor="' . $vals['valuebgcolor'] . '"';

      $horizontal_graph_string .= '>';

      if (ereg('^#', $bars[$i])) { 
        $horizontal_graph_string .= '<table cellpadding="0" cellspacing="0" bgcolor="' . $bars[$i] . '" width="' . ($values[$i] * $vals['scale']) . '">' . "\n" .
                                    '  <tr>' . "\n" .
                                    '    <td>&nbsp;</td>' . "\n" .
                                    '  </tr>' . "\n" .
                                    '</table>';
      } else {
        $horizontal_graph_string .= '<img src="' . $bars[$i] . '" height="10" width="' . ($values[$i] * $vals['scale']) . '">';
      }

      if (!$vals['noshowvals']) {
        $horizontal_graph_string .= '<i><font size="-2" color="' . $vals['valuefcolor'] . '" style="' . $vals['valuefstyle'] . '">(' . $values[$i] . ')</font></i>';
      }

      $horizontal_graph_string .= '</td>' . "\n" .
                                  '  </tr>' . "\n";
    } 

    return $horizontal_graph_string;
  }


  function vertical_graph($names, $values, $bars, $vals) {
    $vertical_graph_string = '  <tr>' . "\n";

    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
      $vertical_graph_string .= '    <td align="center" valign="bottom"';


      if (!$vals['background']) $vertical_graph_string .= ' bgcolor="' . $vals['valuebgcolor'] . '"';

      $vertical_graph_string .= '>';

      if (!$vals['noshowvals']) {
        $vertical_graph_string .= '<i><font size="-2" color="' . $vals['valuefcolor'] . '" style="' . $vals['valuefstyle'] . '">(' . $values[$i] . ')</font></i><br>';
      }

      $vertical_graph_string .= '<img src="' . $bars[$i] . '" width="5" height="';


      if ($values[$i] != 0) {
        $vertical_graph_string .= $values[$i] * $vals['scale'];
      } else {
        $vertical_graph_string .= '1';
      } 

      $vertical_graph_string .= '"></td>' . "\n";
    } 

    $vertical_graph_string .= '  </tr>' . "\n" .
                              '  <tr>' . "\n";

    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
      $vertical_graph_string .= '    <td align="center" valign="top"';

      if (!$vals['background']) $vertical_graph_string .= ' bgcolor="' . $vals['namebgcolor'] . '"';

      $vertical_graph_string .= '><font size="-1" color="' . $vals['namefcolor'] . '" style="' . $vals['namefstyle'] . '">' . $names[$i] . '</font></td>' . "\n";
    } 

    $vertical_graph_string .= '  </tr>' . "\n";

    return $vertical_graph_string;
  }


  function double_horizontal_graph($names, $values, $bars, $vals, $dvalues, $dbars) {
    $double_horizontal_graph_string = '';
    for($i = 0, $n = sizeof($values); $i < $n; $i++) {
      $double_horizontal_graph_string .= '  <tr>' . "\n" .
                                        '    <td align="right"';


      if (!$vals['background']) $double_horizontal_graph_string .= ' bgcolor="' . $vals['namebgcolor'] . '"';

      $double_horizontal_graph_string .= '><font size="-1" color="' . $vals['namefcolor'] . '" style="' . $vals['namefstyle'] . '">' . $names[$i] . '</font></td>' . "\n" .
                                         '    <td';


      if (!$vals['background']) $double_horizontal_graph_string .= ' bgcolor="' . $vals['valuebgcolor'] . '"';

      $double_horizontal_graph_string .= '><table align="left" cellpadding="0" cellspacing="0" width="' . ($dvalues[$i] * $vals['scale']) . '">' . "\n" .
                                         '      <tr>' . "\n" .
                                         '        <td';


      if (ereg('^#', $dbars[$i])) {
        $double_horizontal_graph_string .= ' bgcolor="' . $dbars[$i] . '">';
      } else {
        $double_horizontal_graph_string .= ' background="' . $dbars[$i] . '">';
      }

      $double_horizontal_graph_string .= '<nowrap>';

 
      if (ereg('^#', $bars[$i])) { 
        $double_horizontal_graph_string .= '<table align="left" cellpadding="0" cellspacing="0" bgcolor="' . $bars[$i] . '" width="' . ($values[$i] * $vals['scale']) . '">' . "\n" .
                                           '  <tr>' . "\n" .
                                           '    <td>&nbsp;</td>' . "\n" .
                                           '  </tr>' . "\n" .
                                           '</table>';
      } else {
        $double_horizontal_graph_string .= '<img src="' . $bars[$i] . '" height="10" width="' . ($values[$i] * $vals['scale']) . '">';
      }          

      if (!$vals['noshowvals']) {
        $double_horizontal_graph_string .= '<i><font size="-3" color="' . $vals['valuefcolor'] . '" style="' . $vals['valuefstyle'] . '">(' . $values[$i] . ')</font></i>';
      }

      $double_horizontal_graph_string .= '</nowrap></td>' . "\n" .
                                         '        </tr>' . "\n" .
                                         '      </table>';

      if (!$vals['noshowvals']) {
        $double_horizontal_graph_string .= '<i><font size="-3" color="' . $vals['doublefcolor'] . '" style="' . $vals['valuefstyle'] . '">(' . $dvalues[$i] . ')</font></i>';
      }

      $double_horizontal_graph_string .= '</td>' . "\n" .
                                         '  </tr>' . "\n";
    } 

    return $double_horizontal_graph_string;
  }


  function double_vertical_graph($names, $values, $bars, $vals, $dvalues, $dbars) {
    $double_vertical_graph_string = '  <tr>' . "\n";
    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
      $double_vertical_graph_string .= '    <td align="center" valign="bottom"';


      if (!$vals['background']) $double_vertical_graph_string .= ' bgcolor="' . $vals['valuebgcolor'] . '"';

      $double_vertical_graph_string .= '><table>' . "\n" .
                                       '      <tr>' . "\n" .
                                       '        <td align="center" valign="bottom"';


      if (!$vals['background']) $double_vertical_graph_string .= ' bgcolor="' . $vals['valuebgcolor'] . '"';

      $double_vertical_graph_string .= '>';

      if (!$vals['noshowvals'] && $values[$i]) {
        $double_vertical_graph_string .= '<i><font size="-2" color="' . $vals['valuefcolor'] . '" style="' . $vals['valuefstyle'] . '">(' . $values[$i] . ')</font></i><br>';
      }

      $double_vertical_graph_string .= '<img src="' . $bars[$i] . '" width="10" height="';

      if ($values[$i] != 0) {
        $double_vertical_graph_string .= $values[$i] * $vals['scale'];
      } else {
        $double_vertical_graph_string .= '1';
      }

      $double_vertical_graph_string .= '"></td>' . "\n" .
                                       '        <td align="center" valign="bottom"';


      if (!$vals['background']) $double_vertical_graph_string .= ' bgcolor="' . $vals['valuebgcolor'] . '"';

      $double_vertical_graph_string .= '>';

      if (!$vals['noshowvals'] && $dvalues[$i]) {
        $double_vertical_graph_string .= '<i><font size="-2" color="' . $vals['doublefcolor'] . '" style="' . $vals['valuefstyle'] . '">(' . $dvalues[$i] . ')</font></i><br>';
      }

      $double_vertical_graph_string .= '<img src="' . $dbars[$i] . '" width="10" height="';

      if ($dvalues[$i] != 0) {
        $double_vertical_graph_string .= $dvalues[$i] * $vals['scale'];
      } else {
        $double_vertical_graph_string .= '1';
      }

      $double_vertical_graph_string .= '"></td>' . "\n" .
                                       '      </tr>' . "\n" .
                                       '    </table></td>' . "\n";
    } 

    $double_vertical_graph_string .= '  </tr>' . "\n" .
                                     '  <tr>' . "\n";

    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
      $double_vertical_graph_string .= '    <td align="center" valign="top"';

   
      if (!$vals['background']) $double_vertical_graph_string .= ' bgcolor="' . $vals['namebgcolor'] . '"';

      $double_vertical_graph_string .= '><font size="-1" color="' . $vals['namefcolor'] . '" style="' . $vals['namefstyle'] . '">' . $names[$i] . '</font></td>' . "\n";
    } 

    $double_vertical_graph_string .= '  </tr>' . "\n";

    return $double_vertical_graph_string;
  }

  function os_banner_graph_infoBox($banner_id, $days) 
  {
    $banner_stats_query = os_db_query("select dayofmonth(banners_history_date) as name, banners_shown as value, banners_clicked as dvalue from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . $banner_id . "' and to_days(now()) - to_days(banners_history_date) < " . $days . " order by banners_history_date");
    while ($banner_stats = os_db_fetch_array($banner_stats_query)) {
      $names[] = $banner_stats['name'];
      $values[] = $banner_stats['value'];
      $dvalues[] = $banner_stats['dvalue'];
    }
    $largest = @max($values);

    $bars = array();
    $dbars = array();
    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
      $bars[$i] = http_path('images_admin') . 'graph_hbar_blue.gif';
      $dbars[$i] = http_path('images_admin') . 'graph_hbar_red.gif';
    }

    $graph_vals = @array('vlabel'=>TEXT_BANNERS_DATA,
                        'hlabel'=>TEXT_BANNERS_LAST_3_DAYS,
                        'type'=>'3',
                        'cellpadding'=>'',
                        'cellspacing'=>'1',
                        'border'=>'',
                        'width'=>'',
                        'vfcolor'=>'#ffffff',
                        'hfcolor'=>'#ffffff',
                        'vbgcolor'=>'#81a2b6',
                        'hbgcolor'=>'#81a2b6',
                        'vfstyle'=>'Verdana, Arial, Helvetica',
                        'hfstyle'=>'Verdana, Arial, Helvetica',
                        'scale'=>100/$largest,
                        'namebgcolor'=>'#f3f5fe',
                        'valuebgcolor'=>'#f3f5fe',
                        'namefcolor'=>'',
                        'valuefcolor'=>'#0000d0',
                        'namefstyle'=>'Verdana, Arial, Helvetica',
                        'valuefstyle'=>'',
                        'doublefcolor'=>'#ff7339');

    return html_graph($names, $values, $bars, $graph_vals, $dvalues, $dbars);
  }


  function os_banner_graph_yearly($banner_id) {
    global $banner;

    $banner_stats_query = os_db_query("select year(banners_history_date) as year, sum(banners_shown) as value, sum(banners_clicked) as dvalue from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . $banner_id . "' group by year(banners_history_date)");
    while ($banner_stats = os_db_fetch_array($banner_stats_query)) {
      $names[] = $banner_stats['year'];
      $values[] = (($banner_stats['value']) ? $banner_stats['value'] : '0');
      $dvalues[] = (($banner_stats['dvalue']) ? $banner_stats['dvalue'] : '0');
    }

    $largest = @max($values);

    $bars = array();
    $dbars = array();
    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
      $bars[$i] = http_path('images_admin') . 'graph_hbar_blue.gif';
      $dbars[$i] = http_path('images_admin') . 'graph_hbar_red.gif';
    }

    $graph_vals = @array('vlabel'=>TEXT_BANNERS_DATA,
                        'hlabel'=>sprintf(TEXT_BANNERS_YEARLY_STATISTICS, $banner['banners_title']),
                        'type'=>'3',
                        'cellpadding'=>'',
                        'cellspacing'=>'1',
                        'border'=>'',
                        'width'=>'',
                        'vfcolor'=>'#ffffff',
                        'hfcolor'=>'#ffffff',
                        'vbgcolor'=>'#81a2b6',
                        'hbgcolor'=>'#81a2b6',
                        'vfstyle'=>'Verdana, Arial, Helvetica',
                        'hfstyle'=>'Verdana, Arial, Helvetica',
                        'scale'=>100/$largest,
                        'namebgcolor'=>'#f3f5fe',
                        'valuebgcolor'=>'#f3f5fe',
                        'namefcolor'=>'',
                        'valuefcolor'=>'#0000d0',
                        'namefstyle'=>'Verdana, Arial, Helvetica',
                        'valuefstyle'=>'',
                        'doublefcolor'=>'#ff7339');

    return html_graph($names, $values, $bars, $graph_vals, $dvalues, $dbars);
  }


  function os_banner_graph_monthly($banner_id) {
    global $banner;

    $year = (($_GET['year']) ? $_GET['year'] : date('Y'));

    for ($i=1; $i<13; $i++) {
      $names[] = strftime('%b', mktime(0,0,0,$i));
      $values[] = '0';
      $dvalues[] = '0';
    }

    $banner_stats_query = os_db_query("select month(banners_history_date) as banner_month, sum(banners_shown) as value, sum(banners_clicked) as dvalue from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . $banner_id . "' and year(banners_history_date) = '" . $year . "' group by month(banners_history_date)");
    while ($banner_stats = os_db_fetch_array($banner_stats_query)) {
      $names[($banner_stats['banner_month']-1)] = strftime('%b', mktime(0,0,0,$banner_stats['banner_month']));
      $values[($banner_stats['banner_month']-1)] = (($banner_stats['value']) ? $banner_stats['value'] : '0');
      $dvalues[($banner_stats['banner_month']-1)] = (($banner_stats['dvalue']) ? $banner_stats['dvalue'] : '0');
    }

    $largest = @max($values);

    $bars = array();
    $dbars = array();
    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
      $bars[$i] = http_path('images_admin') . 'graph_hbar_blue.gif';
      $dbars[$i] = http_path('images_admin') . 'graph_hbar_red.gif';
    }

    $graph_vals = @array('vlabel'=>TEXT_BANNERS_DATA,
                        'hlabel'=>sprintf(TEXT_BANNERS_MONTHLY_STATISTICS, $banner['banners_title'], date('Y')),
                        'type'=>'3',
                        'cellpadding'=>'',
                        'cellspacing'=>'1',
                        'border'=>'',
                        'width'=>'',
                        'vfcolor'=>'#ffffff',
                        'hfcolor'=>'#ffffff',
                        'vbgcolor'=>'#81a2b6',
                        'hbgcolor'=>'#81a2b6',
                        'vfstyle'=>'Verdana, Arial, Helvetica',
                        'hfstyle'=>'Verdana, Arial, Helvetica',
                        'scale'=>100/$largest,
                        'namebgcolor'=>'#f3f5fe',
                        'valuebgcolor'=>'#f3f5fe',
                        'namefcolor'=>'',
                        'valuefcolor'=>'#0000d0',
                        'namefstyle'=>'Verdana, Arial, Helvetica',
                        'valuefstyle'=>'',
                        'doublefcolor'=>'#ff7339');

    return html_graph($names, $values, $bars, $graph_vals, $dvalues, $dbars);
  }


  function os_banner_graph_daily($banner_id) {
    global $banner;

    $year = (($_GET['year']) ? $_GET['year'] : date('Y'));
    $month = (($_GET['month']) ? $_GET['month'] : date('n'));

    $days = (date('t', mktime(0,0,0,$month))+1);
    $stats = array();
    for ($i=1; $i<$days; $i++) {
      $names[] = $i;
      $values[] = '0';
      $dvalues[] = '0';
    }

    $banner_stats_query = os_db_query("select dayofmonth(banners_history_date) as banner_day, banners_shown as value, banners_clicked as dvalue from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . $banner_id . "' and month(banners_history_date) = '" . $month . "' and year(banners_history_date) = '" . $year . "'");
    while ($banner_stats = os_db_fetch_array($banner_stats_query)) {
      $names[($banner_stats['banner_day']-1)] = $banner_stats['banner_day'];
      $values[($banner_stats['banner_day']-1)] = (($banner_stats['value']) ? $banner_stats['value'] : '0');
      $dvalues[($banner_stats['banner_day']-1)] = (($banner_stats['dvalue']) ? $banner_stats['dvalue'] : '0');
    }

    $largest = @max($values);

    $bars = array();
    $dbars = array();
    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
      $bars[$i] = http_path('images_admin') . 'graph_hbar_blue.gif';
      $dbars[$i] = http_path('images_admin') . 'graph_hbar_red.gif';
    }

    $graph_vals = @array('vlabel'=>TEXT_BANNERS_DATA,
                        'hlabel'=>sprintf(TEXT_BANNERS_DAILY_STATISTICS, $banner['banners_title'], strftime('%B', mktime(0,0,0,$month)), $year),
                        'type'=>'3',
                        'cellpadding'=>'',
                        'cellspacing'=>'1',
                        'border'=>'',
                        'width'=>'',
                        'vfcolor'=>'#ffffff',
                        'hfcolor'=>'#ffffff',
                        'vbgcolor'=>'#81a2b6',
                        'hbgcolor'=>'#81a2b6',
                        'vfstyle'=>'Verdana, Arial, Helvetica',
                        'hfstyle'=>'Verdana, Arial, Helvetica',
                        'scale'=>100/$largest,
                        'namebgcolor'=>'#f3f5fe',
                        'valuebgcolor'=>'#f3f5fe',
                        'namefcolor'=>'',
                        'valuefcolor'=>'#0000d0',
                        'namefstyle'=>'Verdana, Arial, Helvetica',
                        'valuefstyle'=>'',
                        'doublefcolor'=>'#ff7339');

    return html_graph($names, $values, $bars, $graph_vals, $dvalues, $dbars);
  }
?>