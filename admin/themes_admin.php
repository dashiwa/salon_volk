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

$_utf8win1251 = array(
"\xD0\x90"=>"\xC0","\xD0\x91"=>"\xC1","\xD0\x92"=>"\xC2","\xD0\x93"=>"\xC3","\xD0\x94"=>"\xC4",
"\xD0\x95"=>"\xC5","\xD0\x81"=>"\xA8","\xD0\x96"=>"\xC6","\xD0\x97"=>"\xC7","\xD0\x98"=>"\xC8",
"\xD0\x99"=>"\xC9","\xD0\x9A"=>"\xCA","\xD0\x9B"=>"\xCB","\xD0\x9C"=>"\xCC","\xD0\x9D"=>"\xCD",
"\xD0\x9E"=>"\xCE","\xD0\x9F"=>"\xCF","\xD0\xA0"=>"\xD0","\xD0\xA1"=>"\xD1","\xD0\xA2"=>"\xD2",
"\xD0\xA3"=>"\xD3","\xD0\xA4"=>"\xD4","\xD0\xA5"=>"\xD5","\xD0\xA6"=>"\xD6","\xD0\xA7"=>"\xD7",
"\xD0\xA8"=>"\xD8","\xD0\xA9"=>"\xD9","\xD0\xAA"=>"\xDA","\xD0\xAB"=>"\xDB","\xD0\xAC"=>"\xDC",
"\xD0\xAD"=>"\xDD","\xD0\xAE"=>"\xDE","\xD0\xAF"=>"\xDF","\xD0\x87"=>"\xAF","\xD0\x86"=>"\xB2",
"\xD0\x84"=>"\xAA","\xD0\x8E"=>"\xA1","\xD0\xB0"=>"\xE0","\xD0\xB1"=>"\xE1","\xD0\xB2"=>"\xE2",
"\xD0\xB3"=>"\xE3","\xD0\xB4"=>"\xE4","\xD0\xB5"=>"\xE5","\xD1\x91"=>"\xB8","\xD0\xB6"=>"\xE6",
"\xD0\xB7"=>"\xE7","\xD0\xB8"=>"\xE8","\xD0\xB9"=>"\xE9","\xD0\xBA"=>"\xEA","\xD0\xBB"=>"\xEB",
"\xD0\xBC"=>"\xEC","\xD0\xBD"=>"\xED","\xD0\xBE"=>"\xEE","\xD0\xBF"=>"\xEF","\xD1\x80"=>"\xF0",
"\xD1\x81"=>"\xF1","\xD1\x82"=>"\xF2","\xD1\x83"=>"\xF3","\xD1\x84"=>"\xF4","\xD1\x85"=>"\xF5",
"\xD1\x86"=>"\xF6","\xD1\x87"=>"\xF7","\xD1\x88"=>"\xF8","\xD1\x89"=>"\xF9","\xD1\x8A"=>"\xFA",
"\xD1\x8B"=>"\xFB","\xD1\x8C"=>"\xFC","\xD1\x8D"=>"\xFD","\xD1\x8E"=>"\xFE","\xD1\x8F"=>"\xFF",
"\xD1\x96"=>"\xB3","\xD1\x97"=>"\xBF","\xD1\x94"=>"\xBA","\xD1\x9E"=>"\xA2");
$_win1251utf8 = array(
"\xC0"=>"\xD0\x90","\xC1"=>"\xD0\x91","\xC2"=>"\xD0\x92","\xC3"=>"\xD0\x93","\xC4"=>"\xD0\x94",
"\xC5"=>"\xD0\x95","\xA8"=>"\xD0\x81","\xC6"=>"\xD0\x96","\xC7"=>"\xD0\x97","\xC8"=>"\xD0\x98",
"\xC9"=>"\xD0\x99","\xCA"=>"\xD0\x9A","\xCB"=>"\xD0\x9B","\xCC"=>"\xD0\x9C","\xCD"=>"\xD0\x9D",
"\xCE"=>"\xD0\x9E","\xCF"=>"\xD0\x9F","\xD0"=>"\xD0\xA0","\xD1"=>"\xD0\xA1","\xD2"=>"\xD0\xA2",
"\xD3"=>"\xD0\xA3","\xD4"=>"\xD0\xA4","\xD5"=>"\xD0\xA5","\xD6"=>"\xD0\xA6","\xD7"=>"\xD0\xA7",
"\xD8"=>"\xD0\xA8","\xD9"=>"\xD0\xA9","\xDA"=>"\xD0\xAA","\xDB"=>"\xD0\xAB","\xDC"=>"\xD0\xAC",
"\xDD"=>"\xD0\xAD","\xDE"=>"\xD0\xAE","\xDF"=>"\xD0\xAF","\xAF"=>"\xD0\x87","\xB2"=>"\xD0\x86",
"\xAA"=>"\xD0\x84","\xA1"=>"\xD0\x8E","\xE0"=>"\xD0\xB0","\xE1"=>"\xD0\xB1","\xE2"=>"\xD0\xB2",
"\xE3"=>"\xD0\xB3","\xE4"=>"\xD0\xB4","\xE5"=>"\xD0\xB5","\xB8"=>"\xD1\x91","\xE6"=>"\xD0\xB6",
"\xE7"=>"\xD0\xB7","\xE8"=>"\xD0\xB8","\xE9"=>"\xD0\xB9","\xEA"=>"\xD0\xBA","\xEB"=>"\xD0\xBB",
"\xEC"=>"\xD0\xBC","\xED"=>"\xD0\xBD","\xEE"=>"\xD0\xBE","\xEF"=>"\xD0\xBF","\xF0"=>"\xD1\x80",
"\xF1"=>"\xD1\x81","\xF2"=>"\xD1\x82","\xF3"=>"\xD1\x83","\xF4"=>"\xD1\x84","\xF5"=>"\xD1\x85",
"\xF6"=>"\xD1\x86","\xF7"=>"\xD1\x87","\xF8"=>"\xD1\x88","\xF9"=>"\xD1\x89","\xFA"=>"\xD1\x8A",
"\xFB"=>"\xD1\x8B","\xFC"=>"\xD1\x8C","\xFD"=>"\xD1\x8D","\xFE"=>"\xD1\x8E","\xFF"=>"\xD1\x8F",
"\xB3"=>"\xD1\x96","\xBF"=>"\xD1\x97","\xBA"=>"\xD1\x94","\xA2"=>"\xD1\x9E");

function utf8_win1251($a)
{
    global $_utf8win1251;
    if (is_array($a)){
        foreach ($a as $k => $v) {
            if (is_array($v)) {
                $a[$k] = utf8_win1251($v);
            } else {
                $a[$k] = strtr($v, $_utf8win1251);
            }
        }
        return $a;
    } else {
        return strtr($a, $_utf8win1251);
    }
}

function win1251_utf8($a) {
    global $_win1251utf8;
    if (is_array($a)){
        foreach ($a as $k=>$v) {
            if (is_array($v)) {
                $a[$k] = utf8_win1251($v);
            } else {
                $a[$k] = strtr($v, $_win1251utf8);
            }
        }
        return $a;
    } else {
        return strtr($a, $_win1251utf8);
    }
}

if(!empty($_SERVER['QUERY_STRING']))
    {
	 if (!empty($_GET['a_templates'])) 
	   {
		  os_db_query("UPDATE os_configuration SET configuration_value='".$_GET['a_templates']."' where configuration_key='ADMIN_TEMPLATE'");
		  os_redirect(FILENAME_THEMES_ADMIN);
	   }
	 if (!empty($_GET['c_templates'])) 
	    {   
		  os_db_query("UPDATE os_configuration SET configuration_value='".$_GET['c_templates']."' where configuration_key='CURRENT_TEMPLATE'");
		  os_redirect(FILENAME_THEMES_ADMIN);
		}
	} 
$counter = 0;

//Возвращает информация о шаблоне
function themes_info ($sp,$current)
{
   if ($sp !="admin") 
   {
      $files =  DIR_FS_CATALOG.'themes/'.$current."/style.css";
   }
   else 
   {
      $files =  DIR_FS_CATALOG.'admin/themes/'.$current."/styles/style.css";
   } 
   $st = '';
   if (file_exists ($files))
     {
       $f = fopen($files,"r");
       while(!feof($f))
         {
           $str = fgets ($f);
           $str = strtolower ($str); 
		   $str = str_replace("  "," ",$str);
           if (ereg("^theme.*name:(.*)",$str,$regs)) @$theme_nam = ucwords($regs[1]);
		   if (ereg("^tags:(.*)",$str,$regs)) @$tags = $regs[1];
		   if (ereg("^version:(.*)",$str,$regs)) @$version = $regs[1];
		   if (ereg("^author:(.*)",$str,$regs))  @$author = $regs[1];
		   if (ereg("^description:.(.*)",$str,$regs)) @$description = win1251_utf8(ucfirst($regs[1]));
		   if (ereg("^author.*uri:(.*)",$str,$regs))  @$author_uri = $regs[1]; 
		   $counter++;
         }
	  fclose($f);
	  echo ("<a style=\"font-size:17px;\" href=\"?c_templates=$current\">".ucwords($current)."</a><br><br>$description");
	  echo "<br>Р Р°СЃРїРѕР»РѕР¶РµРЅРёРµ: /themes/".$current;
	 // echo "<br><br>Tags: $tags";	  
     }	  

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
  os_styles("themes");
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<?php require(DIR_FS_CATALOG.'admin/themes/'.ADMIN_TEMPLATE.'/header.php'); ?>
<?php
	
   echo "<div style=\"position:absolute;top:100px; right:3%;\"><a target=\"_blank\" style=\"color:#4378a1\" href=\"http://www.shopos.ru/themes/\">".THEMES_OTHER."</a></div>"; 

?>
<table width="100%"><tr><td valign="top">

<?php
//Просмотр шаблонов админки
if ($dir = opendir(DIR_FS_CATALOG.'admin/themes/')) 
{
   while (($templates = readdir($dir)) !== false) 
   {
	  if (is_dir(DIR_FS_CATALOG.'admin/themes/'."//".$templates) && ($templates != "CVS") && ($templates != ".") && ($templates != ".svn") && ($templates != "..")) 
	  {
		 $templates_array[] = array ('id' => $templates, 'text' => $templates);
	  }
   }
   closedir($dir);
   sort($templates_array);
}

$os_admin_style[] = "";
foreach($templates_array as $key => $type)
{
   foreach($type as $ship)
   {
	  if (!in_array($ship,$os_admin_style)) @$os_admin_style[] = $ship; 
   }
}
?>
 <?php os_header('themes.png',BOX_CONFIGURATION." / ".HEADING_TITLE); ?> 
   <table border=0 width="100%"><tr valign="top"><td>
		<div class="PortfolioContent">
			<h1 class="str"><?php echo THEMES_H1; ?></h1>
			<table border=0 width="100%"><tr>


<table style="paddin-top:10px;" border="0" width="100%"><tr>
<?php
$colo = 0;
foreach($os_admin_style as $str)
{
   if (!empty($str)) 
   {
       if (ADMIN_TEMPLATE == $str )
	   {
	      echo "<tr  class=\"available-theme-ok\"><td><a href=\"?a_templates=$str\"><img class=\"Image1\" style=\"margin-right: 11px;\" src=\"".HTTP_SERVER.DIR_WS_CATALOG."/admin/themes/".ADMIN_TEMPLATE."/screenshot.jpg\" width=\"200\" height=\"116\" alt=\"$str\" /></a></td>";	   
		  echo "<td align=\"left\" valign=\"top\">";
		  themes_info("admin",$str);
		  echo "</td></tr>"; 
	   }	
	   $colo++;
   }
   
}
	   
echo "</tr></table>";
if ($colo > 1)
{
?>
<table style="paddin-top:10px;" border="0" width="100%"><tr>
<h1 class="str"><?php echo THEMES_H2; ?></h1>
<?php
foreach($os_admin_style as $str)
{
   if (!empty($str)) 
   {
       
       if (ADMIN_TEMPLATE != $str ) 
	   {
	      echo "<tr class=\"available-theme\"><td><a href=\"?a_templates=$str\"><img class=\"Image\" style=\"margin-right: 11px;\" src=\"".HTTP_SERVER.DIR_WS_CATALOG."/admin/themes/".ADMIN_TEMPLATE."/screenshot.jpg\" width=\"200\" height=\"116\" alt=\"$str\" /></a></td>";
	  
	      echo "<td align=\"left\" valign=\"top\">";
		  themes_info("admin",$str);
		  echo "</td></tr>";
	   }	 
   }
}
}
echo '</table></div></div></td></tr></table>';
?>
<?php require(DIR_WS_INCLUDES . 'bottom.php'); ?>