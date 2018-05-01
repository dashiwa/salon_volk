<?php
/*
#####################################
#  ShopOS: Скрипты интернет-магазина
#  Copyright (c) 2008-2009
# http://www.shopos.ru
# Ver. 1.0.0
#####################################
*/

require('includes/top.php');
require_once(DIR_WS_FUNCTIONS . 'export_functions.php');

      if (!is_writeable(_EXPORT)) 
	  {
      	 $messageStack->add(ERROR_EXPORT_FOLDER_NOT_WRITEABLE, 'error');
      }
      $module_type = 'export';
      $module_directory = DIR_WS_MODULES . 'export/';
      $module_key = 'MODULE_EXPORT_INSTALLED';
      $file_extension = '.php';
      define('HEADING_TITLE', HEADING_TITLE_MODULES_EXPORT);
      if (isset($_GET['error'])) {
      $map='error';
      if ($_GET['kind']=='success') $map='success';
      $messageStack->add($_GET['error'], $map);
      }

  switch ($_GET['action']) {
    case 'save':
    if (is_array($_POST['configuration'])) {
    if (count($_POST['configuration'])) {
      while (list($key, $value) = each($_POST['configuration'])) {
        os_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $value . "' where configuration_key = '" . $key . "'");
        if (substr($key,'FILE')) $file=$value;
      }
    }
    }

      $class = basename($_GET['module']);
      include($module_directory . $class . $file_extension);

      $module = new $class;
      $module->process($file);
      os_redirect(os_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $class));
      break;

    case 'install':
    case 'remove':
      $file_extension = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '.'));
      $class = basename($_GET['module']);
      if (file_exists($module_directory . $class . $file_extension)) {
        include($module_directory . $class . $file_extension);
        $module = new $class;
        if ($_GET['action'] == 'install') {
          $module->install();
        } elseif ($_GET['action'] == 'remove') {
          $module->remove();
        }
      }
      os_redirect(os_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $class));
      break;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<?php echo ADMIN_FAVICON;?>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLES; ?></title>
<?php 
   os_styles("style"); 
   os_styles("menu");
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<?php require(DIR_FS_CATALOG.'admin/themes/'.ADMIN_TEMPLATE.'/header.php'); ?>

<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="boxCenter" width="100%" valign="top">
    
    <?php os_header('plugin.gif',HEADING_TITLE); ?> 
    	<?php
		echo "<div style=\"position:absolute;top:100px; right:3%;\"><a target=\"_blank\" style=\"color:#4378a1\" href=\"http://www.shopos.ru/module/\">".MODULES_OTHER."</a></div>"; 
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_MODULES; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $file_extension = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '.'));
  $directory_array = array();
  if ($dir = @dir($module_directory)) {
    while ($file = $dir->read()) {
      if (!is_dir($module_directory . $file)) {
        if (substr($file, strrpos($file, '.')) == $file_extension) {
          $directory_array[] = $file;
        }
      }
    }
    sort($directory_array);
    $dir->close();
  }

  $installed_modules = array();
  for ($i = 0, $n = sizeof($directory_array); $i < $n; $i++) {
    $file = $directory_array[$i];
    include($module_directory . $file);

    $class = substr($file, 0, strrpos($file, '.'));
    if (os_class_exists($class)) {
      $module = new $class;
      if ($module->check() > 0) {
        if ($module->sort_order > 0) {
          $installed_modules[$module->sort_order] = $file;
        } else {
          $installed_modules[] = $file;
        }
      }

      if (((!$_GET['module']) || ($_GET['module'] == $class)) && (!$mInfo)) {
        $module_info = array('code' => $module->code,
                             'title' => $module->title,
                             'description' => $module->description,
                             'status' => $module->check());

        $module_keys = $module->keys();
        $keys_extra = array();
        for ($j = 0, $k = sizeof($module_keys); $j < $k; $j++) {
          $key_value_query = os_db_query("select configuration_key,configuration_value, use_function, set_function from " . TABLE_CONFIGURATION . " where configuration_key = '" . $module_keys[$j] . "'");
          $key_value = os_db_fetch_array($key_value_query);
          if ($key_value['configuration_key'] !='')  $keys_extra[$module_keys[$j]]['title'] = constant(strtoupper($key_value['configuration_key'] .'_TITLE'));
          $keys_extra[$module_keys[$j]]['value'] = $key_value['configuration_value'];
          if ($key_value['configuration_key'] !='')  $keys_extra[$module_keys[$j]]['description'] = constant(strtoupper($key_value['configuration_key'] .'_DESC'));
          $keys_extra[$module_keys[$j]]['use_function'] = $key_value['use_function'];
          $keys_extra[$module_keys[$j]]['set_function'] = $key_value['set_function'];
        }

        $module_info['keys'] = $keys_extra;

        $mInfo = new objectInfo($module_info);
      }

      if ( (is_object($mInfo)) && ($class == $mInfo->code) ) {
        if ($module->check() > 0) {
          echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . os_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $class . '&action=edit') . '\'">' . "\n";
        } else {
          echo '              <tr class="dataTableRowSelected">' . "\n";
        }
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . os_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $class) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo $module->title; ?></td>
                <td class="dataTableContent" align="right">
				<?php 
				   if ( (is_object($mInfo)) && ($class == $mInfo->code) ) 
				   { 
				      echo os_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); 
				   } 
				   else 
				   { 
				      echo '<a href="' . os_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $class) . '">' . os_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; 
				   } 
				?>&nbsp;</td>
              </tr>
<?php
    }
  }

  ksort($installed_modules);
  $check_query = os_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = '" . $module_key . "'");
  if (os_db_num_rows($check_query)) 
  {
     $check = os_db_fetch_array($check_query);
     if ($check['configuration_value'] != implode(';', $installed_modules)) 
	 {
         os_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . implode(';', $installed_modules) . "', last_modified = now() where configuration_key = '" . $module_key . "'");
     }
  } 
  else 
  {
     os_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ( '" . $module_key . "', '" . implode(';', $installed_modules) . "','6', '0', now())");
  }
?>
              <tr>
                <td colspan="3" class="smallText"><?php echo TEXT_MODULE_DIRECTORY . ' admin/' . $module_directory; ?></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'edit':
      $keys = '';
      reset($mInfo->keys);
      while (list($key, $value) = each($mInfo->keys)) {
        $keys .= '<b>' . $value['title'] . '</b><br />' .  $value['description'].'<br />';
        if ($value['set_function']) {
          eval('$keys .= ' . $value['set_function'] . "'" . $value['value'] . "', '" . $key . "');");
        } else {
          $keys .= os_draw_input_field('configuration[' . $key . ']', $value['value']);
        }
        $keys .= '<br /><br />';
      }
      $keys = substr($keys, 0, strrpos($keys, '<br /><br />'));

      $heading[] = array('text' => '<b>' . $mInfo->title . '</b>');
      $class = substr($file, 0, strrpos($file, '.'));
      $module = new $_GET['module'];
      $contents = array('form' => os_draw_form('modules', FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $_GET['module'] . '&action=save','post'));
      $contents[] = array('text' => $keys);
      $contents[] = $module->display();

      break;

    default:
      $heading[] = array('text' => '<b>' . $mInfo->title . '</b>');

      if ($mInfo->status == '1') {
        $keys = '';
        reset($mInfo->keys);
        while (list(, $value) = each($mInfo->keys)) {
          $keys .= '<b>' . $value['title'] . '</b><br />';
          if ($value['use_function']) {
            $use_function = $value['use_function'];
            if (ereg('->', $use_function)) {
              $class_method = explode('->', $use_function);
              if (!is_object(${$class_method[0]})) {
                include(DIR_WS_CLASSES . $class_method[0] . '.php');
                ${$class_method[0]} = new $class_method[0]();
              }
              $keys .= os_call_function($class_method[1], $value['value'], ${$class_method[0]});
            } else {
              $keys .= os_call_function($use_function, $value['value']);
            }
          } else {
		  if(strlen($value['value']) > 30) {
		  $keys .=  substr($value['value'],0,30) . ' ...';
		  } else {
            $keys .=  $value['value'];
			}
          }
          $keys .= '<br /><br />';
        }
        $keys = substr($keys, 0, strrpos($keys, '<br /><br />'));

        $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $mInfo->code . '&action=remove') . '"><span>' . BUTTON_MODULE_REMOVE . '</span></a> <a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $mInfo->code . '&action=edit') . '"><span>' . BUTTON_START . '</span></a>');
        $contents[] = array('text' => '<br />' . $mInfo->description);
        $contents[] = array('text' => '<br />' . $keys);
      } else {
        $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . os_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $mInfo->code . '&action=install') . '"><span>' . BUTTON_MODULE_INSTALL . '</span></a>');
        $contents[] = array('text' => '<br />' . $mInfo->description);
      }
      break;
  }

  if ( (os_not_null($heading)) && (os_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

<?php require(DIR_WS_INCLUDES . 'bottom.php'); ?>