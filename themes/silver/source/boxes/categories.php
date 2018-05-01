<?php
/*
#####################################
# ShopOS: Скрипт интернет-магазина
#  Copyright (c) 2008-2010
# http://www.shopos.ru
# Ver. 1.0.1
#####################################
*/

// reset var
$box = new osTemplate;
$box_content = '';
$id = '';
$box->assign('tpl_path', _HTTP_THEMES_C);

// include needed functions
require_once(_THEMES_C.'source/inc/show_category.inc.php');

$categories_string = '';
if (GROUP_CHECK == 'true') {
	$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 "; 
 } else { $group_check=''; }

$categories_query = osDBquery(	"select c.categories_id,
									cd.categories_name,
									c.parent_id from " .
									TABLE_CATEGORIES . " c, " .
									TABLE_CATEGORIES_DESCRIPTION . " cd
									where c.categories_status = '1'
									".$group_check."
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
 
os_show_category(0, 0, $foo, '');

// NaviListe bekommt die ID "CatNavi"
$CatNaviStart = "\n<ul id=\"CatNavi\">\n";

// Hдtte man auch einfacher machen kцnnen, aber mit Tabulatoren ist schicker.
// AuЯerdem kann man so leichter nachprьfen, ob auch wirklich alles korrekt lдuft.
for ($counter = 1; $counter < $old_level+1; $counter++) {
	@$CatNaviEnd .= "</li>\n".str_repeat("\t", $old_level - $counter)."</ul>\n";
	if ($old_level - $counter > 0)
		$CatNaviEnd .= str_repeat("\t", ($old_level - $counter)-1);
}

      }

// Fertige Liste zusammensetzen
$box->assign('BOX_CONTENT', $CatNaviStart.$categories_string.$CatNaviEnd);
$box->assign('language', $_SESSION['language']);
// Jibbie - darauf einen Dujardin

// Viele, viele bunte Smarties
if (USE_CACHE=='false') {
	$box->caching = 0;
	$box_categories= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_categories.html');
} else {
	$box->caching = 1;
	$box->cache_lifetime=CACHE_LIFETIME;
	$box->cache_modified_check=CACHE_CHECK;
	$cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'].$current_category_id;
	$box_categories= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_categories.html',$cache_id);
}
$osTemplate->assign('box_CATEGORIES',$box_categories);
?>