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

defined( '_VALID_OS' ) or die( 'Прямой доступ  не допускается.' );

define('DOMIT_ATTRIBUTEPARSER_STATE_ATTR_NONE', 0);
define('DOMIT_ATTRIBUTEPARSER_STATE_ATTR_KEY', 1);
define('DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE', 2);


$GLOBALS['DOMIT_PREDEFINED_ENTITIES'] = array('&' => '&amp;', '<' => '&lt;', '>' => '&gt;',
											'"' => '&quot;', "'" => '&apos;');


function parseAttributes($attrText, $convertEntities = true, $definedEntities = null) {
	$attrText = trim($attrText);	
	$attrArray = array();
	$maybeEntity = false;	
	
	$total = strlen($attrText);
	$keyDump = '';
	$valueDump = '';
	$currentState = DOMIT_ATTRIBUTEPARSER_STATE_ATTR_NONE;
	$quoteType = '';
	
	if ($definedEntities == null) $defineEntities = array();
	
	for ($i = 0; $i < $total; $i++) {								
		$currentChar = $attrText{$i};
		
		if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_NONE) {
			if (trim($currentChar != '')) {
				$currentState = DOMIT_ATTRIBUTEPARSER_STATE_ATTR_KEY;
			}
		}
		
		switch ($currentChar) {
			case "\t":
				if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE) {
					$valueDump .= $currentChar;
				}
				else {
					$currentChar = '';
				}
				break;
			
			case "\x0B": 
			case "\n":
			case "\r":
				$currentChar = '';
				break;
				
			case '=':
				if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE) {
					$valueDump .= $currentChar;
				}
				else {
					$currentState = DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE;
					$quoteType = '';
					$maybeEntity = false;
				}
				break;
				
			case '"':
				if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE) {
					if ($quoteType == '') {
						$quoteType = '"';
					}
					else {
						if ($quoteType == $currentChar) {
							if ($convertEntities && $maybeEntity) {
							    $valueDump = strtr($valueDump, DOMIT_PREDEFINED_ENTITIES);
								$valueDump = strtr($valueDump, $definedEntities);
							}
							
							$attrArray[trim($keyDump)] = $valueDump;
							$keyDump = $valueDump = $quoteType = '';
							$currentState = DOMIT_ATTRIBUTEPARSER_STATE_ATTR_NONE;
						}
						else {
							$valueDump .= $currentChar;
						}
					}
				}
				break;
				
			case "'":
				if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE) {
					if ($quoteType == '') {
						$quoteType = "'";
					}
					else {
						if ($quoteType == $currentChar) {
							if ($convertEntities && $maybeEntity) {
							    $valueDump = strtr($valueDump, $predefinedEntities);
								$valueDump = strtr($valueDump, $definedEntities);
							}
							
							$attrArray[trim($keyDump)] = $valueDump;
							$keyDump = $valueDump = $quoteType = '';
							$currentState = DOMIT_ATTRIBUTEPARSER_STATE_ATTR_NONE;
						}
						else {
							$valueDump .= $currentChar;
						}
					}
				}
				break;
				
			case '&':
				$maybeEntity = true;
				$valueDump .= $currentChar;
				break;
				
			default:
				if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_KEY) {
					$keyDump .= $currentChar;
				}
				else {
					$valueDump .= $currentChar;
				}
		}
	}

	return $attrArray;
}
?>