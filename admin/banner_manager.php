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
  
  $_banner_query = os_db_query("select banners_title, banners_url, banners_image, banners_group, banners_html_text, status, date_format(date_scheduled, '%d/%m/%Y') as date_scheduled, date_format(expires_date, '%d/%m/%Y') as expires_date, expires_impressions, date_status_change from " . TABLE_BANNERS);

  if (os_db_num_rows($_banner_query, true) > 0) 
  {
      os_db_query("update `".DB_PREFIX."configuration` set configuration_value='true' where configuration_key='VIS_BANNER';");
  }
  else
  {
      os_db_query("update `".DB_PREFIX."configuration` set configuration_value='false' where configuration_key='VIS_BANNER';");
  }
  
  if (!version_compare(phpversion(), "5.3.0"))
  {
     $banner_extension = os_banner_image_extension();
  }
  
  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'setflag':
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          os_set_banner_status($_GET['bID'], $_GET['flag']);
          $messageStack->add_session(SUCCESS_BANNER_STATUS_UPDATED, 'success');
        } else {
          $messageStack->add_session(ERROR_UNKNOWN_STATUS_FLAG, 'error');
        }

        os_redirect(os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . (int)$_GET['bID']));
        break;
      case 'insert':
      case 'update':
        $banners_id = os_db_prepare_input($_POST['banners_id']);
        $banners_title = os_db_prepare_input($_POST['banners_title']);
        $banners_url = os_db_prepare_input($_POST['banners_url']);
        $new_banners_group = os_db_prepare_input($_POST['new_banners_group']);
        $banners_group = (empty($new_banners_group)) ? os_db_prepare_input($_POST['banners_group']) : $new_banners_group;
        $html_text = os_db_prepare_input($_POST['html_text']);
        $banners_image_local = os_db_prepare_input($_POST['banners_image_local']);
        $banners_image_target = os_db_prepare_input($_POST['banners_image_target']);
        $db_image_location = '';

        $banner_error = false;
        if (empty($banners_title)) {
          $messageStack->add(ERROR_BANNER_TITLE_REQUIRED, 'error');
          $banner_error = true;
        }

        if (empty($banners_group)) {
          $messageStack->add(ERROR_BANNER_GROUP_REQUIRED, 'error');
          $banner_error = true;
        }

        if (empty($html_text)) 
		{
          if (!$banners_image = &os_try_upload('banners_image', dir_path('images').'banner/' . $banners_image_target) && $_POST['banners_image_local'] == '') {
            $banner_error = true;
          }
        }

        if (!$banner_error) {
          $db_image_location = (os_not_null($banners_image_local)) ? $banners_image_local : $banners_image_target . $banners_image->filename;
          $sql_data_array = array('banners_title' => $banners_title,
                                  'banners_url' => $banners_url,
                                  'banners_image' => $db_image_location,
                                  'banners_group' => $banners_group,
                                  'banners_html_text' => $html_text);

          if ($_GET['action'] == 'insert') {
            $insert_sql_data = array('date_added' => 'now()',
                                      'status' => '1');
            $sql_data_array = os_array_merge($sql_data_array, $insert_sql_data);
            os_db_perform(TABLE_BANNERS, $sql_data_array);
            $banners_id = os_db_insert_id();
            $messageStack->add_session(SUCCESS_BANNER_INSERTED, 'success');
          } elseif ($_GET['action'] == 'update') {
            os_db_perform(TABLE_BANNERS, $sql_data_array, 'update', 'banners_id = \'' . $banners_id . '\'');
            $messageStack->add_session(SUCCESS_BANNER_UPDATED, 'success');
          }

          if ($_POST['expires_date']) 
		  {
            $expires_date = os_db_prepare_input($_POST['expires_date']);
            list($day, $month, $year) = explode('/', $expires_date);

            $expires_date = $year .
                            ((strlen($month) == 1) ? '0' . $month : $month) .
                            ((strlen($day) == 1) ? '0' . $day : $day);

            os_db_query("update " . TABLE_BANNERS . " set expires_date = '" . os_db_input($expires_date) . "', expires_impressions = null where banners_id = '" . $banners_id . "'");
          } 
		  elseif ($_POST['impressions']) {
            $impressions = os_db_prepare_input($_POST['impressions']);
            os_db_query("update " . TABLE_BANNERS . " set expires_impressions = '" . os_db_input($impressions) . "', expires_date = null where banners_id = '" . $banners_id . "'");
          }

          if ($_POST['date_scheduled']) {
            $date_scheduled = os_db_prepare_input($_POST['date_scheduled']);
            list($day, $month, $year) = explode('/', $date_scheduled);

            $date_scheduled = $year .
                              ((strlen($month) == 1) ? '0' . $month : $month) .
                              ((strlen($day) == 1) ? '0' . $day : $day);

            os_db_query("update " . TABLE_BANNERS . " set status = '0', date_scheduled = '" . os_db_input($date_scheduled) . "' where banners_id = '" . $banners_id . "'");
          }

          os_redirect(os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $banners_id));
        } else {
          $_GET['action'] = 'new';
        }
        break;
      case 'deleteconfirm':
        $banners_id = os_db_prepare_input($_GET['bID']);
        $delete_image = os_db_prepare_input($_POST['delete_image']);

        if ($delete_image == 'on') {
          $banner_query = os_db_query("select banners_image from " . TABLE_BANNERS . " where banners_id = '" . os_db_input($banners_id) . "'");
          $banner = os_db_fetch_array($banner_query);
          if (is_file(dir_path('images') . $banner['banners_image'])) 
		  {
            if (is_writeable(dir_path('images') . $banner['banners_image'])) 
			{
              unlink(dir_path('images') . $banner['banners_image']);
            } 
			else 
			{
              $messageStack->add_session(ERROR_IMAGE_IS_NOT_WRITEABLE, 'error');
            }
          } else {
            $messageStack->add_session(ERROR_IMAGE_DOES_NOT_EXIST, 'error');
          }
        }

        os_db_query("delete from " . TABLE_BANNERS . " where banners_id = '" . os_db_input($banners_id) . "'");
        os_db_query("delete from " . TABLE_BANNERS_HISTORY . " where banners_id = '" . os_db_input($banners_id) . "'");
		
        if ( (function_exists('imagecreate')) && ($banner_extension) ) {
          if (is_file(get_path('images_admin') . 'graphs/banner_infobox-' . $banners_id . '.' . $banner_extension)) {
            if (is_writeable(get_path('images_admin') . 'graphs/banner_infobox-' . $banners_id . '.' . $banner_extension)) {
              unlink(get_path('images_admin') . 'graphs/banner_infobox-' . $banners_id . '.' . $banner_extension);
            }
          }

          if (is_file(get_path('images_admin') . 'graphs/banner_yearly-' . $banners_id . '.' . $banner_extension)) {
            if (is_writeable(get_path('images_admin') . 'graphs/banner_yearly-' . $banners_id . '.' . $banner_extension)) {
              unlink(get_path('images_admin') . 'graphs/banner_yearly-' . $banners_id . '.' . $banner_extension);
            }
          }

          if (is_file(get_path('images_admin'). 'graphs/banner_monthly-' . $banners_id . '.' . $banner_extension)) {
            if (is_writeable(get_path('images_admin') . 'graphs/banner_monthly-' . $banners_id . '.' . $banner_extension)) {
              unlink(get_path('images_admin') . 'graphs/banner_monthly-' . $banners_id . '.' . $banner_extension);
            }
          }

          if (is_file(get_path('images_admin') . 'graphs/banner_daily-' . $banners_id . '.' . $banner_extension)) {
            if (is_writeable(get_path('images_admin') . 'graphs/banner_daily-' . $banners_id . '.' . $banner_extension)) {
              unlink(get_path('images_admin') . 'graphs/banner_daily-' . $banners_id . '.' . $banner_extension);
            }
          }
        }

        $messageStack->add_session(SUCCESS_BANNER_REMOVED, 'success');

        os_redirect(os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page']));
        break;
    }
  }

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
  
  add_action('head_admin', 'head_banner_manager');
  
  function head_banner_manager ()
  {
     _e('<script type="text/javascript"><!--');
     _e('function popupImageWindow(url) {');
     _e('window.open(url,\'popupImageWindow\',\'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150\')');
     _e('} //--></script>');
  }
  
?>

<?php $main->head(); ?>
<?php $main->top_menu(); ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="boxCenter" width="100%" valign="top">
    
    <?php os_header('portfolio_package.gif',HEADING_TITLE); ?> 
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($_GET['action'] == 'new') {
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
      <tr>
        <td><?php echo os_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo os_draw_form('new_banner', FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"'); if ($form_action == 'update') echo os_draw_hidden_field('banners_id', $bID); ?>
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
            <td class="main" align="right" valign="top" nowrap><?php echo (($form_action == 'insert') ? '<span class="button"><button type="submit" onClick="this.blur();" value="' . BUTTON_INSERT . '"/>' . BUTTON_INSERT . '</button></span>' : '<span class="button"><button type="submit" onClick="this.blur();" value="' . BUTTON_UPDATE . '"/>' . BUTTON_UPDATE . '</button></span>'). '&nbsp;&nbsp;<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $_GET['bID']) . '"><span>' . BUTTON_CANCEL . '</span></a>'; ?></td>
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
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $banners_query_raw = "select banners_id, banners_title, banners_image, banners_group, status, expires_date, expires_impressions, date_status_change, date_scheduled, date_added from " . TABLE_BANNERS . " order by banners_title, banners_group";
    $banners_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $banners_query_raw, $banners_query_numrows);
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
        echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . os_href_link(FILENAME_BANNER_STATISTICS, 'page=' . $_GET['page'] . '&bID=' . $bInfo->banners_id) . '\'">' . "\n";
      } else {
        echo '<tr  onmouseover="this.style.background=\'#e9fff1\';this.style.cursor=\'hand\';" onmouseout="this.style.background=\''.$color.'\';" style="background-color:'.$color.'" onclick="document.location.href=\'' . os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $banners['banners_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="javascript:popupImageWindow(\'' . FILENAME_POPUP_IMAGE . '?banner=' . $banners['banners_id'] . '\')">' . os_image(http_path('icons_admin')  . 'icon_popup.gif', 'View Banner') . '</a>&nbsp;' . $banners['banners_title']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $banners['banners_group']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $banners_shown . ' / ' . $banners_clicked; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($banners['status'] == '1') {
        echo os_image(http_path('icons_admin')  . 'icon_status_green.gif', 'Active', 10, 10) . '&nbsp;&nbsp;<a href="' . os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $banners['banners_id'] . '&action=setflag&flag=0') . '">' . os_image(http_path('icons_admin') . 'icon_status_red_light.gif', 'Set Inactive', 10, 10) . '</a>';
      } else {
        echo '<a href="' . os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $banners['banners_id'] . '&action=setflag&flag=1') . '">' . os_image(http_path('icons_admin') . 'icon_status_green_light.gif', 'Set Active', 10, 10) . '</a>&nbsp;&nbsp;' . os_image(http_path('icons_admin') . 'icon_status_red.gif', 'Inactive', 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php echo '<a href="' . os_href_link(FILENAME_BANNER_STATISTICS, 'page=' . $_GET['page'] . '&bID=' . $banners['banners_id']) . '">' . os_image(http_path('icons_admin') . 'statistics.gif', ICON_STATISTICS) . '</a>&nbsp;'; if ( (is_object($bInfo)) && ($banners['banners_id'] == $bInfo->banners_id) ) { echo os_image(http_path('icons_admin') . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $banners['banners_id']) . '">' . os_image(http_path('icons_admin') . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $banners_split->display_count($banners_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_BANNERS); ?></td>
                    <td class="smallText" align="right"><?php echo $banners_split->display_links($banners_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_BANNER_MANAGER, 'action=new') . '"><span>' . BUTTON_NEW_BANNER . '</span></a>'; ?></td>
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

      $contents = array('form' => os_draw_form('banners', FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $bInfo->banners_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $bInfo->banners_title . '</b>');
      if ($bInfo->banners_image) $contents[] = array('text' => '<br />' . os_draw_checkbox_field('delete_image', 'on', true) . ' ' . TEXT_INFO_DELETE_IMAGE);
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" onClick="this.blur();" value="' . BUTTON_DELETE . '"/>' . BUTTON_DELETE . '</button></span>&nbsp;<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $_GET['bID']) . '"><span>' . BUTTON_CANCEL . '</span></a>');
      break;
    default:
      if (is_object($bInfo)) {
        $heading[] = array('text' => '<b>' . $bInfo->banners_title . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $bInfo->banners_id . '&action=new') . '"><span>' . BUTTON_EDIT . '</span></a> <a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_BANNER_MANAGER, 'page=' . $_GET['page'] . '&bID=' . $bInfo->banners_id . '&action=delete') . '"><span>' . BUTTON_DELETE . '</span></a>');
        $contents[] = array('text' => '<br />' . TEXT_BANNERS_DATE_ADDED . ' ' . os_date_short($bInfo->date_added));

        if ( (function_exists('imagecreate')) && ($dir_ok) && ($banner_extension) ) {
          $banner_id = $bInfo->banners_id;
          $days = '3';
          include(get_path('includes_admin') . 'graphs/banner_infobox.php');
          $contents[] = array('align' => 'center', 'text' => '<br />' . os_image(http_path('icons_admin') . 'graphs/banner_infobox-' . $banner_id . '.' . $banner_extension));
        } else {
          include(dir_path('func_admin') . 'html_graphs.php');
          $contents[] = array('align' => 'center', 'text' => '<br />' . os_banner_graph_infoBox($bInfo->banners_id, '3'));
        }

        $contents[] = array('text' => os_image(http_path('icons_admin') . 'graph_hbar_blue.gif', 'Blue', '5', '5') . ' ' . TEXT_BANNERS_BANNER_VIEWS . '<br />' . os_image(http_path('icons_admin') . 'graph_hbar_red.gif', 'Red', '5', '5') . ' ' . TEXT_BANNERS_BANNER_CLICKS);

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
    </table></td>
  </tr>
</table>
<?php $main->bottom(); ?>