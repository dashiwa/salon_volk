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

$box = new osTemplate;
$box_content='';
$flag='';

$box->assign('language', $_SESSION['language']);
// set cache ID
if (!CacheCheck()) {
	$cache=false;
	$box->caching = 0;
} else {
	$cache=true;
	$box->caching = 1;
	$box->cache_lifetime = CACHE_LIFETIME;
	$box->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'];
}

if (!$box->is_cached(CURRENT_TEMPLATE.'/boxes/box_authors.html', @$cache_id) || !$cache) {

	$box->assign('tpl_path', _HTTP_THEMES_C);

  $authors_query = "select authors_id, authors_name from " . TABLE_AUTHORS . " order by authors_name";
  $authors_query = osDBquery($authors_query);
  $number_of_author_rows = os_db_num_rows($authors_query,true);
  if (os_db_num_rows($authors_query,true) > 0) {
?>
<?php
    if ($number_of_author_rows <= MAX_DISPLAY_AUTHORS_IN_A_LIST) {
// Display a list
      $authors_list = '';
      while ($authors = os_db_fetch_array($authors_query,true)) {

		$SEF_parameter_author = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_author = '&author='.os_cleanName($authors['authors_name']);

        $authors_name = ((utf8_strlen($authors['authors_name']) > MAX_DISPLAY_AUTHOR_NAME_LEN) ? utf8_substr($authors['authors_name'], 0, MAX_DISPLAY_AUTHOR_NAME_LEN) . '..' : $authors['authors_name']);
        if (isset($_GET['authors_id']) && ($_GET['authors_id'] == $authors['authors_id'])) $authors_name = '<b>' . $authors_name .'</b>';
        $authors_list .= '<a href="' . os_href_link(FILENAME_ARTICLES, 'authors_id=' . $authors['authors_id'] . $SEF_parameter_author) . '">' . $authors_name . '</a><br />';
      }

      $authors_list = utf8_substr($authors_list, 0, -4);

      $content_string .= $authors_list;
    } else {
// Display a drop-down
      $authors_array = array();
      if (MAX_AUTHORS_LIST < 2) {
        $authors_array[] = array('id' => '', 'text' => PULL_DOWN_DEFAULT);
      }

      while ($authors = os_db_fetch_array($authors_query,true)) {
        $authors_name = ((utf8_strlen($authors['authors_name']) > MAX_DISPLAY_AUTHOR_NAME_LEN) ? utf8_substr($authors['authors_name'], 0, MAX_DISPLAY_AUTHOR_NAME_LEN) . '..' : $authors['authors_name']);
        $authors_array[] = array('id' => $authors['authors_id'],
                                       'text' => $authors_name);
      }

      @$content_string .= os_draw_form('authors', os_href_link(FILENAME_ARTICLES, '', 'NONSSL', false), 'get') . os_draw_pull_down_menu('authors_id', $authors_array, (isset($_GET['authors_id']) ? $_GET['authors_id'] : ''), 'onchange="this.form.submit();" size="' . MAX_AUTHORS_LIST . '" style="width: 100%"') . os_hide_session_id().'</form>';
}

?>
<?php
}

  
    $box->assign('BOX_CONTENT', $content_string);

}

if (!$cache) {
	$box_authors = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_authors.html');
} else {
	$box_authors = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_authors.html', $cache_id);
}

   $osTemplate->assign('box_AUTHORS',$box_authors);

?>