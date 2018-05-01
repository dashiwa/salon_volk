<?php
/*
#####################################
#  ShopOS: Shopping Cart Software.
#  Copyright (c) 2008-2010
#  http://www.shopos.ru
#  http://www.shoposs.com
#  Ver. 1.0.2
#####################################
*/

class translit{
var $translit=array(
"�"=>"a","�"=>"b","�"=>"v","�"=>"g","�"=>"d","�"=>"e","�"=>"yo","�"=>"ge","�"=>"z","�"=>"i",
"�"=>"y","�"=>"k","�"=>"l","�"=>"m","�"=>"n","�"=>"o","�"=>"p","�"=>"r",
"�"=>"s","�"=>"t","�"=>"u","�"=>"f","�"=>"h","�"=>"ts","�"=>"4","�"=>"sh","�"=>"sch",
"�"=>"","�"=>"","�"=>"e","�"=>"y","�"=>"yu","�"=>"ya","�"=>"i","�"=>"yi","�"=>"e"
);

function get_translit($rus_text){
	setlocale(LC_CTYPE,"ru_RU.KOI8-R");
	$translit_text=strtoupper(stripslashes($rus_text));
	reset($this->translit);
	while (list ($key, $val) = each ($this->translit)) {
//		echo $key . " ->" .$val."   === ". $translit_text."<br>";
		$translit_text=ereg_replace($key,$val,$translit_text);
	}
//	return ereg_replace('"','',ereg_replace("\.","",ereg_replace("[[:space:]]+","",$translit_text)));
	return ereg_replace('"','',ereg_replace("\.","",$translit_text));
}

}
?>