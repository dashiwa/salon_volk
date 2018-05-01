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

  $_var = 'main_page=banner_manager_page&';
  $_var2 = 'page=banner_status&';
  $_var3 = 'main_page=banner_statistics_page&';
 
  $_banner_query = os_db_query("select banners_title, banners_url, banners_image, banners_group, banners_html_text, status, date_format(date_scheduled, '%d/%m/%Y') as date_scheduled, date_format(expires_date, '%d/%m/%Y') as expires_date, expires_impressions, date_status_change from " . TABLE_BANNERS);

  if (os_db_num_rows($_banner_query, true) > 0) 
  {
      os_db_query("update `".DB_PREFIX."configuration` set configuration_value='true' where configuration_key='VIS_BANNER';");
  }
  else
  {
      os_db_query("update `".DB_PREFIX."configuration` set configuration_value='false' where configuration_key='VIS_BANNER';");
  }
  
  
?>  
  
  
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($_GET['action'] == 'new') 
  {
    $form_action = 'insert';
    if ($_GET['bID']) {
      $bID = os_db_prepare_input($_GET['bID']);
      $form_action = 'update';

      $banner_query = os_db_query("select banners_title, banners_url, banners_image, banners_group, banners_html_text, status, date_format(date_scheduled, '%d/%m/%Y') as date_scheduled, date_format(expires_date, '%d/%m/%Y') as expires_date, expires_impressions, date_status_change from " . TABLE_BANNERS . " where banners_id = '" . os_db_input($bID) . "'");
      $banner = os_db_fetch_array($banner_query);

      $bInfo = new objectInfo($banner);
    } elseif ($_POST) {
      $bInfo = new objectInfo($_POST);
    } else {
      $bInfo = new objectInfo(array());
    }

    $groups_array = array();
    $groups_query = os_db_query("select distinct banners_group from " . TABLE_BANNERS . " order by banners_group");
    while ($groups = os_db_fetch_array($groups_query)) {
      $groups_array[] = array('id' => $groups['banners_group'], 'text' => $groups['banners_group']);
    }
?>
<link href="includes/javascript/date-picker/css/datepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/javascript/date-picker/js/datepicker.js"></script>

      <tr><?php echo os_draw_form('new_banner', FILENAME_PLUGINS_PAGE, $_var2.'_page=' . $_GET['_page'] . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"'); if ($form_action == 'update') echo os_draw_hidden_field('banners_id', $bID); ?>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_BANNERS_TITLE; ?></td>
            <td class="main"><?php echo os_draw_input_field('banners_title', $bInfo->banners_title, '', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANNERS_URL; ?></td>
            <td class="main"><?php echo os_draw_input_field('banners_url', $bInfo->banners_url); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_BANNERS_GROUP; ?></td>
            <td class="main"><?php echo os_draw_pull_down_menu('banners_group', $groups_array, $bInfo->banners_group) . TEXT_BANNERS_NEW_GROUP . '<br />' . os_draw_input_field('new_banners_group', '', '', ((sizeof($groups_array) > 0) ? false : true)); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo os_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_BANNERS_IMAGE; ?></td>
            <td class="main"><?php echo os_draw_file_field('banners_image') . ' ' . TEXT_BANNERS_IMAGE_LOCAL . '<br />' . dir_path('images').'banner/' . os_draw_input_field('banners_image_local', $bInfo->banners_image); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo os_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANNERS_IMAGE_TARGET; ?></td>
            <td class="main"><?php echo dir_path('images').'banner/' . os_draw_input_field('banners_image_target'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo os_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_BANNERS_HTML_TEXT; ?></td>
            <td class="main"><?php echo os_draw_textarea_field('html_text', 'soft', '60', '5', $bInfo->banners_html_text); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo os_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANNERS_SCHEDULED_AT; ?><br /><small>(dd/mm/yyyy)</small></td>
            <td valign="top" class="main"><?php echo os_draw_input_field('date_scheduled', $bInfo->date_scheduled, 'size="10" class="format-d-m-y dividor-slash"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo os_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_BANNERS_EXPIRES_ON; ?><br /><small>(dd/mm/yyyy)</small></td>
            <td class="main"><?php echo os_draw_input_field('expires_date', $bInfo->expires_date, 'size="10" class="format-d-m-y dividor-slash"'); ?> <?php echo TEXT_BANNERS_OR_AT . '<br />' . os_draw_input_field('impressions', $bInfo->expires_impressions, 'maxlength="7" size="7"') . ' ' . TEXT_BANNERS_IMPRESSIONS; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo os_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_BANNERS_BANNER_NOTE . '<br />' . TEXT_BANNERS_INSERT_NOTE . '<br />' . TEXT_BANNERS_EXPIRCY_NOTE . '<br />' . TEXT_BANNERS_SCHEDULE_NOTE; ?></td>
            <td class="main" align="right" valign="top" nowrap><?php echo (($form_action == 'insert') ? '<span class="button"><button type="submit" onClick="this.blur();" value="' . BUTTON_INSERT . '"/>' . BUTTON_INSERT . '</button></span>' : '<span class="button"><button type="submit" onClick="this.blur();" value="' . BUTTON_UPDATE . '"/>' . BUTTON_UPDATE . '</button></span>'). '&nbsp;&nbsp;<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_PLUGINS_PAGE, 'page=' . $_GET['_page'] . '&bID=' . $_GET['bID']) . '"><span>' . BUTTON_CANCEL . '</span></a>'; ?></td>
          </tr>
        </table></td>
      </form></tr>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_BANNERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_GROUPS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATISTICS; ?></td>
				<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_GROUP; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $banners_query_raw = "select banners_id, banners_title, banners_image, banners_group, status, expires_date, expires_impressions, date_status_change, date_scheduled, date_added from " . TABLE_BANNERS . " order by banners_title, banners_group";
    $banners_split = new splitPageResults($_GET['_page'], MAX_DISPLAY_ADMIN_PAGE, $banners_query_raw, $banners_query_numrows);
    $banners_query = os_db_query($banners_query_raw);
    while ($banners = os_db_fetch_array($banners_query)) {
      $info_query = os_db_query("select sum(banners_shown) as banners_shown, sum(banners_clicked) as banners_clicked from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . $banners['banners_id'] . "'");
      $info = os_db_fetch_array($info_query);

      if (((!$_GET['bID']) || ($_GET['bID'] == $banners['banners_id'])) && (!$bInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
        $bInfo_array = os_array_merge($banners, $info);
        $bInfo = new objectInfo($bInfo_array);
      }

      $banners_shown = ($info['banners_shown'] != '') ? $info['banners_shown'] : '0';
      $banners_clicked = ($info['banners_clicked'] != '') ? $info['banners_clicked'] : '0';
	  $color = $color == '#f9f9ff' ? '#f0f1ff':'#f9f9ff';
	  
      if ( (is_object($bInfo)) && ($banners['banners_id'] == $bInfo->banners_id) ) {
        echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'">' . "\n";
      } else {
        echo '<tr  onmouseover="this.style.background=\'#e9fff1\';this.style.cursor=\'hand\';" onmouseout="this.style.background=\''.$color.'\';" style="background-color:'.$color.'" onclick="document.location.href=\'' . os_href_link(FILENAME_PLUGINS_PAGE, $_var.'_page=' . $_GET['_page'] . '&bID=' . $banners['banners_id']) . '\'">' . "\n";
      }
	  
	  $image_url = http_path('images').'banner/'.$banners['banners_image']; 
?>

                <td class="dataTableContent">
				<?php if ( !empty( $banners['banners_image'] ) )
				{ ?>
				
				
				<a href="<?php echo $image_url; ?>" class="zoom" rel="gallery-plants" target="_blank"><?php echo os_image( http_path('icons_admin')  . 'icon_popup.gif', $banners['banners_title']) . '</a>&nbsp;';
                }
				echo  $banners['banners_title']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $banners['banners_group']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $banners_shown . ' / ' . $banners_clicked;  ?></td>
                <td class="dataTableContent" align="center"><?php

				 $m = strtolower( $banners['banners_group'] );
	
						    if ( $m == 'banner' )
							{
							   $_banner = strtoupper($m);
							}
							else
							{
							   $m = 'banner_'.$m;
							   $_banner = $m;  
							}
                               
				echo '{$'.$_banner.'}'; 
				
				?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($banners['status'] == '1') {
        echo os_image(http_path('icons_admin')  . 'icon_status_green.gif', 'Active', 10, 10) . '&nbsp;&nbsp;<a href="' . os_href_link(FILENAME_PLUGINS_PAGE, $_var2.'_page=' . $_GET['_page'] . '&bID=' . $banners['banners_id'] . '&action=setflag&flag=0') . '">' . os_image(http_path('icons_admin') . 'icon_status_red_light.gif', 'Set Inactive', 10, 10) . '</a>';
      } else {
        echo '<a href="' . os_href_link(FILENAME_PLUGINS_PAGE, $_var2.'_page=' . $_GET['_page'] . '&bID=' . $banners['banners_id'] . '&action=setflag&flag=1') . '">' . os_image(http_path('icons_admin') . 'icon_status_green_light.gif', 'Set Active', 10, 10) . '</a>&nbsp;&nbsp;' . os_image(http_path('icons_admin') . 'icon_status_red.gif', 'Inactive', 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php  if ( (is_object($bInfo)) && ($banners['banners_id'] == $bInfo->banners_id) ) { echo os_image(http_path('icons_admin') . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . os_href_link(FILENAME_PLUGINS_PAGE, '_page=' . $_GET['_page'] . '&bID=' . $banners['banners_id']) . '">' . os_image(http_path('icons_admin') . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $banners_split->display_count($banners_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['_page'], TEXT_DISPLAY_NUMBER_OF_BANNERS); ?></td>
                    <td class="smallText" align="right"><?php echo $banners_split->display_links($banners_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['_page']); ?></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_PLUGINS_PAGE,  $_var.'action=new') . '"><span>' . BUTTON_NEW_BANNER . '</span></a>'; ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'delete':
      $heading[] = array('text' => '<b>' . $bInfo->banners_title . '</b>');

      $contents = array('form' => os_draw_form('banners', FILENAME_PLUGINS_PAGE,  $_var2.'_page=' . $_GET['_page'] . '&bID=' . $bInfo->banners_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $bInfo->banners_title . '</b>');
      if ($bInfo->banners_image) $contents[] = array('text' => '<br />' . os_draw_checkbox_field('delete_image', 'on', true) . ' ' . TEXT_INFO_DELETE_IMAGE);
      
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" onClick="this.blur();" value="' . BUTTON_DELETE . '"/>' . BUTTON_DELETE . '</button></span>&nbsp;<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_PLUGINS_PAGE, $_var.'_page=' . $_GET['_page'] . '&bID=' . $_GET['bID']) . '"><span>' . BUTTON_CANCEL . '</span></a>');
      break;
    default:
      if (is_object($bInfo)) {
        $heading[] = array('text' => '<b>' . $bInfo->banners_title . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_PLUGINS_PAGE, $_var.'_page=' . $_GET['_page'] . '&bID=' . $bInfo->banners_id . '&action=new') . '"><span>' . BUTTON_EDIT . '</span></a> <a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_PLUGINS_PAGE, $_var.'_page=' . $_GET['_page'] . '&bID=' . $bInfo->banners_id . '&action=delete') . '"><span>' . BUTTON_DELETE . '</span></a>');
        $contents[] = array('text' => '<br />' . TEXT_BANNERS_DATE_ADDED . ' ' . os_date_short($bInfo->date_added));


        if ($bInfo->date_scheduled) $contents[] = array('text' => '<br />' . sprintf(TEXT_BANNERS_SCHEDULED_AT_DATE, os_date_short($bInfo->date_scheduled)));

        if ($bInfo->expires_date) {
          $contents[] = array('text' => '<br />' . sprintf(TEXT_BANNERS_EXPIRES_AT_DATE, os_date_short($bInfo->expires_date)));
        } elseif ($bInfo->expires_impressions) {
          $contents[] = array('text' => '<br />' . sprintf(TEXT_BANNERS_EXPIRES_AT_IMPRESSIONS, $bInfo->expires_impressions));
        }

        if ($bInfo->date_status_change) $contents[] = array('text' => '<br />' . sprintf(TEXT_BANNERS_STATUS_CHANGE, os_date_short($bInfo->date_status_change)));
      }
      break;
  }

  if ( (os_not_null($heading)) && (os_not_null($contents)) ) {
    echo '            <td class="right_box" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table>