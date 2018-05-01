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
"à"=>"a","á"=>"b","â"=>"v","ã"=>"g","ä"=>"d","å"=>"e","¸"=>"yo","æ"=>"ge","ç"=>"z","è"=>"i",
"é"=>"y","ê"=>"k","ë"=>"l","ì"=>"m","í"=>"n","î"=>"o","ï"=>"p","ğ"=>"r",
"ñ"=>"s","ò"=>"t","ó"=>"u","ô"=>"f","õ"=>"h","ö"=>"ts","÷"=>"4","ø"=>"sh","ù"=>"sch",
"ü"=>"","ú"=>"","ı"=>"e","û"=>"y","ş"=>"yu","ÿ"=>"ya","³"=>"i","¿"=>"yi","º"=>"e"
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