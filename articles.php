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

include ('includes/top.php');
//$osTemplate = new osTemplate;


// the following tPath references come from top.php
  $topic_depth = 'top';

  if (isset($tPath) && os_not_null($tPath)) {
    $topics_articles_query = "select count(*) as total from " . TABLE_ARTICLES_TO_TOPICS . " where topics_id = '" . (int)$current_topic_id . "'";
    $topics_articles_query = osDBquery($topics_articles_query);
    $topics_articles = os_db_fetch_array($topics_articles_query);
    if ($topics_articles['total'] > 0) {
      $topic_depth = 'articles'; // display articles
    } else {
      $topic_parent_query = "select count(*) as total from " . TABLE_TOPICS . " where parent_id = '" . (int)$current_topic_id . "'";
      $topic_parent_query = osDBquery($topic_parent_query);
      $topic_parent = os_db_fetch_array($topic_parent_query);
      if ($topic_parent['total'] > 0) {
        $topic_depth = 'nested'; // navigate through the topics
      } else {
        $topic_depth = 'articles'; // topic has no articles, but display the 'no articles' message
      }
    }
  }

  if ($topic_depth == 'top' && !isset($_GET['authors_id'])) {
    $breadcrumb->add(NAVBAR_TITLE_DEFAULT, os_href_link(FILENAME_ARTICLES));
  }

    $topic_query = os_db_query("select td.topics_name, td.topics_heading_title, td.topics_description from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.topics_id = '" . (int)$current_topic_id . "' and td.topics_id = '" . (int)$current_topic_id . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "'");
    $topic = os_db_fetch_array($topic_query);
 
    if (os_not_null($topic['topics_name'])) {
        $topic_name = $topic['topics_name'];
      } else {
        $topic_name = NAVBAR_TITLE_DEFAULT;
      }

	$osTemplate->assign('HEADER_TEXT', $topic_name);

    if (os_not_null($topic['topics_heading_title'])) {
	$osTemplate->assign('TOPICS_HEADING_TITLE', $topic['topics_heading_title']);
   }    
             
    if (os_not_null($topic['topics_description'])) {
	$osTemplate->assign('TOPICS_DESCRIPTION', $topic['topics_description']);
   }    
             
require (dir_path('includes').'header.php');

  if ($topic_depth == 'articles' || isset($_GET['authors_id'])) {

// show the articles of a specified author
    if (isset($_GET['authors_id'])) {
    
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and au.authors_id = '" . (int)$_GET['authors_id'] . "' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by a.sort_order, ad.articles_name";
    } else {
    
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and a2t.topics_id = '" . (int)$current_topic_id . "' order by a.sort_order, ad.articles_name";
    }

  } else {
 
  $listing_sql = "select a.articles_id, a.articles_date_added, a.articles_date_available, ad.articles_name, ad.articles_head_desc_tag, ad.articles_viewed, au.authors_id, au.authors_name, td.topics_id, td.topics_name from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' ORDER BY IF (`a`.`sort_order`,`a`.`articles_date_available`, `a`.`articles_date_added`) DESC";
}

  if ($_GET['akeywords'] != ""){
  
  $_GET['akeywords'] = urldecode($_GET['akeywords']);
  if (isset($_GET['description'])) {
    $listing_sql = "select ad.articles_name, a.articles_date_added, a.articles_date_available, a.articles_id, ad.articles_description from " . TABLE_ARTICLES_DESCRIPTION . " ad inner join " . TABLE_ARTICLES . " a on ad.articles_id = a.articles_id where a.articles_status = '1' and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and (ad.articles_name like '%" . $_GET['akeywords'] . "%' or ad.articles_description like '%" . $_GET['akeywords'] . "%' or ad.articles_head_desc_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_keywords_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_title_tag like '%" . $_GET['akeywords'] . "%') order by ad.articles_name ASC";
  }  else {
    $listing_sql = "select ad.articles_name, a.articles_date_added, a.articles_date_available, a.articles_id, ad.articles_description from " . TABLE_ARTICLES_DESCRIPTION . " ad inner join " . TABLE_ARTICLES . " a on ad.articles_id = a.articles_id where a.articles_status='1' and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and (ad.articles_name like '%" . $_GET['akeywords'] . "%' or ad.articles_head_desc_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_keywords_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_title_tag like '%" . $_GET['akeywords'] . "%') order by a.sort_order, ad.articles_name ASC";
  }    
 }
 
$articles_split = new splitPageResults($listing_sql, $_GET['page'], MAX_ARTICLES_PER_PAGE);

if (($articles_split->number_of_rows > 0)) {
	$osTemplate->assign('NAVIGATION_BAR', TEXT_RESULT_PAGE.' '.$articles_split->display_links(MAX_DISPLAY_PAGE_LINKS, os_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$osTemplate->assign('NAVIGATION_BAR_PAGES', $articles_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES));

}

$module_content = '';
if ($articles_split->number_of_rows > 0) {

	$osTemplate->assign('no_articles', 'false');

	$articles_query = os_db_query($articles_split->sql_query);
	while ($articles = os_db_fetch_array($articles_query)) {

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&article='.os_cleanName($articles['articles_name']);

		$SEF_parameter_author = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_author = '&author='.os_cleanName($articles['authors_name']);

		$SEF_parameter_category = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_category = '&category='.os_cleanName($articles['topics_name']);

		$module_content[] = array (
		
		'ARTICLE_NAME' => $articles['articles_name'],
		'ARTICLE_SHORT_DESCRIPTION' => $articles['articles_head_desc_tag'], 
		'ARTICLE_DATE' => os_date_long($articles['articles_date_added']), 
		'ARTICLE_LINK' => os_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $articles['articles_id'] . $SEF_parameter), 
		'AUTHOR_NAME' => $articles['authors_name'], 
		'AUTHOR_LINK' =>  os_href_link(FILENAME_ARTICLES, 'authors_id=' . $articles['authors_id'] . $SEF_parameter_author), 
		'ARTICLE_CATEGORY_NAME' => $articles['topics_name'],
		'ARTICLE_CATEGORY_LINK' => os_href_link(FILENAME_ARTICLES, 'tPath=' . $articles['topics_id'] . $SEF_parameter_category)
		
		);

	}
} else {

	$osTemplate->assign('no_articles', 'true');

}

$osTemplate->assign('language', $_SESSION['language']);
$osTemplate->caching = 0;
$osTemplate->assign('module_content', $module_content);
$main_content = $osTemplate->fetch(CURRENT_TEMPLATE.'/module/articles.html');
$osTemplate->assign('main_content', $main_content);

$osTemplate->assign('language', $_SESSION['language']);
$osTemplate->caching = 0;
 $osTemplate->load_filter('output', 'trimhitespace');
$template = (file_exists(_THEMES_C.FILENAME_ARTICLES.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ARTICLES.'.html' : CURRENT_TEMPLATE.'/index.html');
$osTemplate->display($template);
include ('includes/bottom.php');
?>