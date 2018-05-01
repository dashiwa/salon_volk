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
/**
* @package domit-xmlparser
* @copyright (C) 2004 John Heinstein. All rights reserved
* @license http://www.gnu.org/copyleft/lesser.html LGPL License
* @author John Heinstein <johnkarl@nbnet.nb.ca>
* @link http://www.engageinteractive.com/domit/ DOMIT! Home Page
* DOMIT! is Free Software
**/
defined( '_VALID_OS' ) or die( 'Прямой доступ  не допускается.' );

define ('DOMIT_FILE_EXTENSION_CACHE', 'dch');

class DOMIT_cache {

	function toCache($xmlFileName, &$doc, $writeAttributes = 'w') {
		require_once(DOMIT_INCLUDE_PATH . 'xml_domit_utilities.php');
		require_once(DOMIT_INCLUDE_PATH . 'php_file_utilities.php');

		$name = DOMIT_Utilities::removeExtension($xmlFileName) . '.' . DOMIT_FILE_EXTENSION_CACHE;
		php_file_utilities::putDataToFile($name, serialize($doc), $writeAttributes);

		return (file_exists($name) && is_writable($name));
	} 
	

	function &fromCache($xmlFileName) {
		require_once(DOMIT_INCLUDE_PATH . 'xml_domit_utilities.php');
		require_once(DOMIT_INCLUDE_PATH . 'php_file_utilities.php');
		
		$name = DOMIT_Utilities::removeExtension($xmlFileName) . '.' . DOMIT_FILE_EXTENSION_CACHE;
		$fileContents =& php_file_utilities::getDataFromFile($name, 'r');
		$newxmldoc =& unserialize($fileContents);

		return $newxmldoc;
	} 
	function cacheExists($xmlFileName) {
		require_once(DOMIT_INCLUDE_PATH . 'xml_domit_utilities.php');
		
		$name = DOMIT_Utilities::removeExtension($xmlFileName) . '.' . DOMIT_FILE_EXTENSION_CACHE;
		return file_exists($name);
	} 
	function removeFromCache($xmlFileName) {
		require_once(DOMIT_INCLUDE_PATH . 'xml_domit_utilities.php');
		
		$name = DOMIT_Utilities::removeExtension($xmlFileName) . '.' . DOMIT_FILE_EXTENSION_CACHE;
		return unlink($name);
	} 
} 
?>