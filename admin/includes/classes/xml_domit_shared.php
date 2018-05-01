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
* @version 1.01
* @copyright (C) 2004 John Heinstein. All rights reserved
* @author John Heinstein <johnkarl@nbnet.nb.ca>
* @link http://www.engageinteractive.com/domit/ DOMIT! Home Page
* DOMIT! is Free Software
**/
defined( '_VALID_OS' ) or die( 'Прямой доступ  не допускается.' );

if (!defined('DOMIT_INCLUDE_PATH')) {
	define('DOMIT_INCLUDE_PATH', (dirname(__FILE__) . "/"));
}

define('DOMIT_ELEMENT_NODE', 1);
define('DOMIT_ATTRIBUTE_NODE', 2);
define('DOMIT_TEXT_NODE', 3);
define('DOMIT_CDATA_SECTION_NODE', 4);
define('DOMIT_ENTITY_REFERENCE_NODE', 5);
define('DOMIT_ENTITY_NODE', 6);
define('DOMIT_PROCESSING_INSTRUCTION_NODE', 7);
define('DOMIT_COMMENT_NODE', 8);
define('DOMIT_DOCUMENT_NODE', 9);
define('DOMIT_DOCUMENT_TYPE_NODE', 10);
define('DOMIT_DOCUMENT_FRAGMENT_NODE', 11);
define('DOMIT_NOTATION_NODE', 12);
define('DOMIT_INDEX_SIZE_ERR', 1);
define('DOMIT_DOMSTRING_SIZE_ERR', 2); 
define('DOMIT_HIERARCHY_REQUEST_ERR', 3);
define('DOMIT_WRONG_DOCUMENT_ERR', 4); 
define('DOMIT_INVALID_CHARACTER_ERR', 5);
define('DOMIT_NO_DATA_ALLOWED_ERR', 6);
define('DOMIT_NO_MODIFICATION_ALLOWED_ERR', 7);
define('DOMIT_NOT_FOUND_ERR', 8);
define('DOMIT_NOT_SUPPORTED_ERR', 9);
define('DOMIT_INUSE_ATTRIBUTE_ERR', 10);
define('DOMIT_INVALID_STATE_ERR', 11);
define('DOMIT_SYNTAX_ERR', 12);
define('DOMIT_INVALID_MODIFICATION_ERR', 13);
define('DOMIT_NAMESPACE_ERR', 14);
define('DOMIT_INVALID_ACCESS_ERR', 15);
define('DOMIT_ABSTRACT_CLASS_INSTANTIATION_ERR', 100);
define('DOMIT_ABSTRACT_METHOD_INVOCATION_ERR', 101);
define('DOMIT_DOCUMENT_FRAGMENT_ERR', 102);
define('DOMIT_ONERROR_CONTINUE', 1);
define('DOMIT_ONERROR_DIE', 2);

$GLOBALS['uidFactory'] = new UIDGenerator();
require_once(DOMIT_INCLUDE_PATH . 'xml_domit_nodemaps.php');

class UIDGenerator {
	var $seed;
	var $counter = 0;
	function UIDGenerator() {
		$this->seed = 'node' . time();
	}
	function generateUID() {
		return ($this->seed . $this->counter++);
	}
}
$GLOBALS['DOMIT_DOMException_errorHandler'] = null;
$GLOBALS['DOMIT_DOMException_mode'] = DOMIT_ONERROR_CONTINUE;
$GLOBALS['DOMIT_DOMException_log'] = null;

class DOMIT_DOMException {
	function raiseException($errorNum, $errorString) {
		if ($GLOBALS['DOMIT_DOMException_errorHandler'] != null) {
			call_user_func($GLOBALS['DOMIT_DOMException_errorHandler'], $errorNum, $errorString);
		}
		else {
			$errorMessageText = $errorNum  . ' ' . $errorString;
			$errorMessage = 'Error: ' . $errorMessageText;
			
			if ((!isset($GLOBALS['DOMIT_ERROR_FORMATTING_HTML'])) ||
				($GLOBALS['DOMIT_ERROR_FORMATTING_HTML'] == true)) {
					$errorMessage = "<p><pre>" . $errorMessage . "</pre></p>";
			}
			
			if ((isset($GLOBALS['DOMIT_DOMException_log'])) &&
				($GLOBALS['DOMIT_DOMException_log'] != null)) {
					require_once(DOMIT_INCLUDE_PATH . 'php_file_utilities.php');
					$logItem = "\n" . date('Y-m-d H:i:s') . 'DOMIT! Error ' . $errorMessageText;
					php_file_utilities::putDataToFile($GLOBALS['DOMIT_DOMException_log'], 
										$logItem, 'a');
			}
			
			switch ($GLOBALS['DOMIT_DOMException_mode']) {
				case DOMIT_ONERROR_CONTINUE:
					return;
					break;
					
				case DOMIT_ONERROR_DIE:
					die($errorMessage);
					break;
			}			
		}
	} 
	
	function setErrorHandler($method) {
		$GLOBALS['DOMIT_DOMException_errorHandler'] =& $method;
	}
	
	function setErrorMode($mode) {
		$GLOBALS['DOMIT_DOMException_mode'] = $mode;
	} 
	
	function setErrorLog($doLogErrors, $logfile) {
		if ($doLogErrors) {
			$GLOBALS['DOMIT_DOMException_log'] = $logfile;
		}
		else {
			$GLOBALS['DOMIT_DOMException_log'] = null;
		}
	} 
} 
class DOMIT_DOMImplementation {
	function hasFeature($feature, $version = null) {
		if (strtoupper($feature) == 'XML') {
			if (($version == '1.0') || ($version == '2.0') || ($version == null)) {
				return true;
			}
		}
		
		return false;
	} 
	function &createDocument($namespaceURI, $qualifiedName, &$docType) {
		$xmldoc = new DOMIT_Document();
		$documentElement =& $xmldoc->createElementNS($namespaceURI, $qualifiedName);
		
		$xmldoc->setDocumentElement($documentElement);
		
		if ($docType != null) {
			$xmldoc->doctype =& $docType;
		}
		
		return $xmldoc;
	} 
	function &createDocumentType($qualifiedName, $publicID, $systemID) {
		DOMIT_DOMException::raiseException(DOMIT_NOT_SUPPORTED_ERROR, 
			('Method createDocumentType is not yet implemented.'));
	} 
}
?>