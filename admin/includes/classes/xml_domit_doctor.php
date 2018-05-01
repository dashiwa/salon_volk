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
* DOMIT! Doctor is a set of utilities for repairing malformed XML
* @package domit-xmlparser
* @copyright (C) 2004 John Heinstein. All rights reserved
* @license http://www.gnu.org/copyleft/lesser.html LGPL License
* @author John Heinstein <johnkarl@nbnet.nb.ca>
* @link http://www.engageinteractive.com/domit/ DOMIT! Home Page
* DOMIT! is Free Software
**/
defined( '_VALID_OS' ) or die( 'Прямой доступ  не допускается.' );

class domit_doctor {
	
	function fixAmpersands($xmlText) {
		$xmlText = trim($xmlText);
		$startIndex = -1;
		$processing = true;
		$illegalChar = '&';
				
		while ($processing) {
			$startIndex = strpos($xmlText, $illegalChar, ($startIndex + 1));
			
			if ($startIndex !== false) {
				$xmlText = domit_doctor::evaluateCharacter($xmlText, 
									$illegalChar, ($startIndex + 1));
			}
			else {
				$processing = false;
			}
		}
		
		return $xmlText;
	} 
	function evaluateCharacter($xmlText, $illegalChar, $startIndex) {
		$total = strlen($xmlText);
		$searchingForCDATASection = false; 
		
		for ($i = $startIndex; $i < $total; $i++) {
			$currChar = substr($xmlText, $i, 1);
			
			if (!$searchingForCDATASection) {
				switch ($currChar) {
					case ' ':
					case "'":
					case '"':
					case "\n":
					case "\r":
					case "\t":
					case '&':
					case "]":
						$searchingForCDATASection = true;
						break;
					case ";":
						return $xmlText;
						break;			
				}
			}
			else {
				switch ($currChar) {
					case '<':
					case '>':
						return (substr_replace($xmlText, '&amp;', 
										($startIndex - 1) , 1));
						break;
					case "]":
						return $xmlText;
						break;			
				}
			}
		}
		return $xmlText;
	} 
} 
?>