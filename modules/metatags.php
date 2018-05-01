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


$HEAD[]['link'] = array('rel' => 'icon',
                        'href' => http_path('catalog') .'favicon.ico',
                        'type' => 'image/x-icon');
						
$HEAD[]['link'] = array('rel' => 'shortcut icon',
                        'href' => http_path('catalog') .'favicon.ico',
                        'type' => 'image/x-icon');
						
$HEAD[]['meta'] = array('name' => 'language',
                        'content' => $_SESSION['language_code']);

$content_meta_default_query = osDBquery("select cm.content_heading, cm.content_meta_title, cm.content_meta_description,  cm.content_meta_keywords from " . TABLE_CONTENT_MANAGER . " cm where cm.content_group = '5' and cm.languages_id = '" . (int)$_SESSION['languages_id'] . "'");

$content_meta_default = os_db_fetch_array($content_meta_default_query);

if ($content_meta_default['content_meta_title'] == '') 
{
			$content_default_title = $content_meta_default['content_heading'];
} 
else 
{
			$content_default_title = $content_meta_default['content_meta_title'];
}

$content_default_description = $content_meta_default['content_meta_description'];
$content_default_keywords = $content_meta_default['content_meta_keywords'];	

if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO)) {

	if ($product->isProduct()) {
        $description = $product->data['products_meta_description'];
        if (strlen($description) == 0){
            $description = $product->data['products_name'];
        }

        $title = $product->data['products_meta_title'];
        if (strlen($title) == 0){
            $title = $product->data['products_name'];
        }

$cat_query = osDBquery("SELECT
                                 categories_name
                                 FROM ".TABLE_CATEGORIES_DESCRIPTION." 
                                 WHERE categories_id='".$current_category_id."'
                                 and language_id = '".(int) $_SESSION['languages_id']."'"
                                 );
$cat_data = os_db_fetch_array($cat_query, true);  

   $_description  = $description;     
   $_keywords  = $product->data['products_meta_keywords'];    
   $_title  = $title.' '.$product->data['products_model'] . ' - ' . $cat_data['categories_name'] . ' - ' . TITLE;    
} 
else 
{
   $_description  = $content_default_description;     
   $_keywords  = $content_default_keywords;    
   $_title  = TITLE;   
}

} else {
	if (isset($_GET['cPath'])) {
		if (strpos($_GET['cPath'], '_') == '1') {
			$arr = explode('_', os_input_validation($_GET['cPath'], 'cPath', ''));
			$size = count($arr);
			$_cPath = $arr[$size-1];
		} else {
			if (isset ($_GET['cat'])) {
				$site = explode('_', $_GET['cat']);
				$cID = $site[0];
				$_cPath = str_replace('c', '', $cID);
			}
		}
		/*$categories_meta_query = osDBquery("SELECT categories_meta_keywords,
		                                            categories_meta_description,
		                                            categories_meta_title,
		                                            categories_name
		                                            FROM " . TABLE_CATEGORIES_DESCRIPTION . "
		                                            WHERE categories_id='" . $_cPath . "' and
		                                            language_id='" . $_SESSION['languages_id'] . "'");*/
        $categories_meta = get_categories_info ($_cPath); 
		//$categories_meta = os_db_fetch_array($categories_meta_query, true);
		if ($categories_meta['categories_meta_keywords'] == '') {
			$categories_meta['categories_meta_keywords'] = $content_default_keywords;
		}
		if ($categories_meta['categories_meta_description'] == '') {
			$categories_meta['categories_meta_description'] = $content_default_description;
		}
		if ($categories_meta['categories_meta_title'] == '') {
			$categories_meta['categories_meta_title'] = $categories_meta['categories_name'];
		}
		if (isset($_GET['filter_id']) or isset($_GET['manufacturers_id'])) {		

	$mID = (isset($_GET['filter_id']) ? $_GET['filter_id'] : $_GET['manufacturers_id']);
		
		    $manufacturer_query = osDBquery("select m.manufacturers_name, mi.manufacturers_meta_title, mi.manufacturers_meta_description, mi.manufacturers_meta_keywords from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on mi.manufacturers_id = m.manufacturers_id where m.manufacturers_id = '" . $mID . "'");
		      $manufacturer = os_db_fetch_array($manufacturer_query,true);		

   $mName = (isset($manufacturer['manufacturers_meta_title']) ? ' - ' . $manufacturer['manufacturers_meta_title'] : ' - ' . $manufacturer['manufacturers_name']);
   $mDesc = (isset($manufacturer['manufacturers_meta_description']) ? ' ' . $manufacturer['manufacturers_meta_description'] : null);
   $mKey = (isset($manufacturer['manufacturers_meta_keywords']) ? ' ' . $manufacturer['manufacturers_meta_keywords'] : null);


		}	
   $_description  = $categories_meta['categories_meta_description'] . $mDesc;     
   $_keywords  = $categories_meta['categories_meta_keywords'].$mKey;    
   $_title  = $categories_meta['categories_meta_title'] . $mName . ' - ' . TITLE;  		
   				

	} else {

switch (true) {
  case (isset($_GET['coID'])):

$content_meta_query = osDBquery("select cm.content_heading, cm.content_meta_title, cm.content_meta_description,  cm.content_meta_keywords from " . TABLE_CONTENT_MANAGER . " cm where cm.content_group = '" . (int)$_GET['coID'] . "' and cm.languages_id = '" . (int)$_SESSION['languages_id'] . "'");

if (os_db_num_rows($content_meta_query, true) > 0) {

$content_meta = os_db_fetch_array($content_meta_query);

		if ($content_meta['content_meta_title'] == '') {
			$content_title = $content_meta['content_heading'];
		} else {
			$content_title = $content_meta['content_meta_title'];
		}

		if ($content_meta['content_meta_description'] == '') {
			$content_desc = $content_default_description;
		} else {
			$content_desc = $content_meta['content_meta_description'];
		}

		if ($content_meta['content_meta_keywords'] == '') {
			$content_key = $content_default_keywords;
		} else {
			$content_key = $content_meta['content_meta_keywords'];
		}

}
   $_description  = $content_desc;     
   $_keywords  = $content_key;    
   $_title  = $content_title . ' - ' . TITLE;  		
   		
    break;

  case (isset($_GET['news_id'])):

			$news_meta_query = osDBquery("SELECT headline
			                                            FROM " . TABLE_LATEST_NEWS . "
			                                            WHERE news_id='" . (int)$_GET['news_id'] . "' and
			                                            language='" . (int)$_SESSION['languages_id'] . "'");
			$news_meta = os_db_fetch_array($news_meta_query, true);
   
   $_description  = $content_default_description;     
   $_keywords  = $content_default_keywords;    
   $_title  = $news_meta['headline'] . ' - ' . TITLE;  		
   		

    break;

  case (isset($_GET['tPath'])):

			$articles_cat_meta_query = osDBquery("SELECT topics_name, topics_heading_title, topics_description
			                                            FROM " . TABLE_TOPICS_DESCRIPTION . "
			                                            WHERE topics_id='" . (int)$current_topic_id . "' and
			                                            language_id='" . (int)$_SESSION['languages_id'] . "'");
			$articles_cat_meta = os_db_fetch_array($articles_cat_meta_query, true);

			$articles_cat_title = $articles_cat_meta['topics_name'];

		if ($articles_cat_meta['topics_description'] == '') {
			$articles_cat_desc = $content_default_description;
		} else {
			$articles_cat_desc = $articles_cat_meta['topics_heading_title'];
		}
   $_description  = $articles_cat_desc;     
   $_keywords  = $content_default_keywords;    
   $_title  = $articles_cat_title . ' - ' . TITLE;  		
   

    break;

  case (isset($_GET['articles_id'])):

			$articles_meta_query = osDBquery("SELECT articles_name, articles_head_title_tag, articles_head_desc_tag, articles_head_keywords_tag
			                                            FROM " . TABLE_ARTICLES_DESCRIPTION . "
			                                            WHERE articles_id='" . (int)$_GET['articles_id'] . "' and
			                                            language_id='" . (int)$_SESSION['languages_id'] . "'");
			$articles_meta = os_db_fetch_array($articles_meta_query, true);

		if ($articles_meta['articles_head_title_tag'] == '') {
			$articles_title = $articles_meta['articles_name'];
		} else {
			$articles_title = $articles_meta['articles_head_title_tag'];
		}

		if ($articles_meta['articles_head_desc_tag'] == '') {
			$articles_desc = $content_default_description;
		} else {
			$articles_desc = $articles_meta['articles_head_desc_tag'];
		}

		if ($articles_meta['articles_head_keywords_tag'] == '') 
		{
			$articles_key = $content_default_keywords;
		} 
		else 
		{
			$articles_key = $articles_meta['articles_head_keywords_tag'];
		}
   $_description  = $articles_desc;     
   $_keywords  = $articles_key;    
   $_title  = $articles_title . ' - ' . TITLE;  		
   
    break;

  case (isset($_GET['authors_id'])):

			$authors_meta_query = osDBquery("SELECT authors_name
			                                            FROM " . TABLE_AUTHORS . "
			                                            WHERE authors_id='" . (int)$_GET['authors_id'] . "'");
			$authors_meta = os_db_fetch_array($authors_meta_query, true);
			
   $_description  = $content_default_description;     
   $_keywords  = $content_default_keywords;    
   $_title  = $authors_meta['authors_name'] . ' - ' . TITLE;  		

    break;

default:
if (strstr($PHP_SELF, FILENAME_DEFAULT) && !isset($_GET['cat'])) {


} else {

			$content_default_title = TITLE;
}

   $mDesc = (isset($content_meta_default['content_meta_description']) ? ' ' . $content_meta_default['content_meta_description'] : null);
   $mKey = (isset($content_meta_default['content_meta_keywords']) ? ' ' . $content_meta_default['content_meta_keywords'] : null);

		if (isset($_GET['filter_id']) or isset($_GET['manufacturers_id'])) {		

	$mID = (isset($_GET['filter_id']) ? $_GET['filter_id'] : $_GET['manufacturers_id']);
		
		    $manufacturer_query = osDBquery("select m.manufacturers_name, mi.manufacturers_meta_title, mi.manufacturers_meta_description, mi.manufacturers_meta_keywords from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on mi.manufacturers_id = m.manufacturers_id where m.manufacturers_id = '" . $mID . "'");
		      $manufacturer = os_db_fetch_array($manufacturer_query,true);		

   $mName = (isset($manufacturer['manufacturers_meta_title']) ? ' - ' . $manufacturer['manufacturers_meta_title'] : ' - ' . $manufacturer['manufacturers_name']);

   $mDesc = (isset($manufacturer['manufacturers_meta_description']) ? $manufacturer['manufacturers_meta_description'] : null);
   $mKey = (isset($manufacturer['manufacturers_meta_keywords']) ? $manufacturer['manufacturers_meta_keywords'] : null);
   $content_default_description = $mDesc;
   $content_default_keywords = $mKey;
   $content_default_title .= $mName;
   
		}	
		
   $_description  = $content_default_description;     
   $_keywords  = $content_default_keywords;    
   $_title  = $content_default_title;   		

     }
	}
}

$HEAD[]['title'] = $_title;
$HEAD[]['meta'] = array('name' => 'description', 'content' => $_description);
$HEAD[]['meta'] = array('name' => 'keywords', 'content' => $_keywords);

?>
