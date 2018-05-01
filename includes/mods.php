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

function base64todec($base64_value)
{
   // конвертация base64 
   switch($base64_value)
   {
	case "A":$decimal_value=0;break;
	case "B":$decimal_value=1;break;
	case "C":$decimal_value=2;break;
	case "D":$decimal_value=3;break;
	case "E":$decimal_value=4;break;
	case "F":$decimal_value=5;break;
	case "G":$decimal_value=6;break;
	case "H":$decimal_value=7;break;
	case "I":$decimal_value=8;break;
	case "J":$decimal_value=9;break;
	case "K":$decimal_value=10;break;
	case "L":$decimal_value=11;break;
	case "M":$decimal_value=12;break;
	case "N":$decimal_value=13;break;
	case "O":$decimal_value=14;break;
	case "P":$decimal_value=15;break;
	case "Q":$decimal_value=16;break;
	case "R":$decimal_value=17;break;
	case "S":$decimal_value=18;break;
	case "T":$decimal_value=19;break;
	case "U":$decimal_value=20;break;
	case "V":$decimal_value=21;break;
	case "W":$decimal_value=22;break;
	case "X":$decimal_value=23;break;
	case "Y":$decimal_value=24;break;
	case "Z":$decimal_value=25;break;
	case "a":$decimal_value=26;break;
	case "b":$decimal_value=27;break;
	case "c":$decimal_value=28;break;
	case "d":$decimal_value=29;break;
	case "e":$decimal_value=30;break;
	case "f":$decimal_value=31;break;
	case "g":$decimal_value=32;break;
	case "h":$decimal_value=33;break;
	case "i":$decimal_value=34;break;
	case "j":$decimal_value=35;break;
	case "k":$decimal_value=36;break;
	case "l":$decimal_value=37;break;
	case "m":$decimal_value=38;break;
	case "n":$decimal_value=39;break;
	case "o":$decimal_value=40;break;
	case "p":$decimal_value=41;break;
	case "q":$decimal_value=42;break;
	case "r":$decimal_value=43;break;
	case "s":$decimal_value=44;break;
	case "t":$decimal_value=45;break;
	case "u":$decimal_value=46;break;
	case "v":$decimal_value=47;break;
	case "w":$decimal_value=48;break;
	case "x":$decimal_value=49;break;
	case "y":$decimal_value=50;break;
	case "z":$decimal_value=51;break;
	case "0":$decimal_value=52;break;
	case "1":$decimal_value=53;break;
	case "2":$decimal_value=54;break;
	case "3":$decimal_value=55;break;
	case "4":$decimal_value=56;break;
	case "5":$decimal_value=57;break;
	case "6":$decimal_value=58;break;
	case "7":$decimal_value=59;break;
	case "8":$decimal_value=60;break;
	case "9":$decimal_value=61;break;
	case "+":$decimal_value=62;break;
	case "/":$decimal_value=63;break;
	case "=":$decimal_value=64;break;
	default: $decimal_value=0;break;
   }
   return $decimal_value;
}

function changedatain($plain_data,$key)
{
   // encode plain data with key using xoft encryption
   $key_length=0; //key length counter
   $all_bin_chars="";
   $cipher_data="";

   for($i=0;$i<strlen($plain_data);$i++){
	$p=substr($plain_data,$i,1);   // p = plaintext
	$k=substr($key,$key_length,1); // k = key
	$key_length++;

	if($key_length>=strlen($key)){
		$key_length=0;
	}

	$dec_chars=ord($p)^ord($k);
	$dec_chars=$dec_chars + strlen($key);
	$bin_chars=decbin($dec_chars);

	while(strlen($bin_chars)<8){
		$bin_chars="0".$bin_chars;
	}

	$all_bin_chars=$all_bin_chars.$bin_chars;

   }

   $m=0;

   for($j=0;$j<strlen($all_bin_chars);$j=$j+4){
	$four_bit=substr($all_bin_chars,$j,4);     // split 8 bit to 4 bit
	$four_bit_dec=bindec($four_bit);

	$decimal_value=$four_bit_dec * 4 + $m;     //multiply by 4 plus m where m=0,1,2, or 3

	$base64_value=dectobase64($decimal_value); //convert to base64 value
	$cipher_data=$cipher_data.$base64_value;
	$m++;

	if($m>3){
		$m=0;
	}
   }

   return $cipher_data;
}


function changedataout($cipher_data,$key){

   // decode cipher data with key using xoft encryption */

   $m=0;
   $all_bin_chars="";

   for($i=0;$i<strlen($cipher_data);$i++){
	$c=substr($cipher_data,$i,1);             // c = ciphertext
	$decimal_value=base64todec($c);           //convert to decimal value

	$decimal_value=($decimal_value - $m) / 4; //substract by m where m=0,1,2,or 3 then divide by 4

	$four_bit=decbin($decimal_value);

	while(strlen($four_bit)<4){
		$four_bit="0".$four_bit;
	}

	$all_bin_chars=$all_bin_chars.$four_bit;
	$m++;

	if($m>3){
		$m=0;
	}
   }

   $key_length=0;
   $plain_data="";

   for($j=0;$j<strlen($all_bin_chars);$j=$j+8){
	$c=substr($all_bin_chars,$j,8);
	$k=substr($key,$key_length,1);

	$dec_chars=bindec($c);
	$dec_chars=$dec_chars - strlen($key);
	$c=chr($dec_chars);
	$key_length++;

	if($key_length>=strlen($key)){
		$key_length=0;
	}

	$dec_chars=ord($c)^ord($k);
	$p=chr($dec_chars);
	$plain_data=$plain_data.$p;
   }

   return $plain_data;
}


  function create_coupon_code($salt="secret", $length = SECURITY_CODE_LENGTH) {
    $ccid = md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    $ccid .= md5(uniqid("","salt"));
    srand((double)microtime()*1000000); // seed the random number generator
    $random_start = @rand(0, (128-$length));
    $good_result = 0;
    while ($good_result == 0) {
      $id1=substr($ccid, $random_start,$length);
      $query = os_db_query("select coupon_code from " . TABLE_COUPONS . " where coupon_code = '" . $id1 . "'");
      if (os_db_num_rows($query) == 0) $good_result = 1;
    }
    return $id1;
  }
  
  

function dectobase64($decimal_value){

   // convert decimal value into base64 value

   switch($decimal_value){
	case 0: $base64_value="A";break;
	case 1: $base64_value="B";break;
	case 2: $base64_value="C";break;
	case 3: $base64_value="D";break;
	case 4: $base64_value="E";break;
	case 5: $base64_value="F";break;
	case 6: $base64_value="G";break;
	case 7: $base64_value="H";break;
	case 8: $base64_value="I";break;
	case 9: $base64_value="J";break;
	case 10: $base64_value="K";break;
	case 11: $base64_value="L";break;
	case 12: $base64_value="M";break;
	case 13: $base64_value="N";break;
	case 14: $base64_value="O";break;
	case 15: $base64_value="P";break;
	case 16: $base64_value="Q";break;
	case 17: $base64_value="R";break;
	case 18: $base64_value="S";break;
	case 19: $base64_value="T";break;
	case 20: $base64_value="U";break;
	case 21: $base64_value="V";break;
	case 22: $base64_value="W";break;
	case 23: $base64_value="X";break;
	case 24: $base64_value="Y";break;
	case 25: $base64_value="Z";break;
	case 26: $base64_value="a";break;
	case 27: $base64_value="b";break;
	case 28: $base64_value="c";break;
	case 29: $base64_value="d";break;
	case 30: $base64_value="e";break;
	case 31: $base64_value="f";break;
	case 32: $base64_value="g";break;
	case 33: $base64_value="h";break;
	case 34: $base64_value="i";break;
	case 35: $base64_value="j";break;
	case 36: $base64_value="k";break;
	case 37: $base64_value="l";break;
	case 38: $base64_value="m";break;
	case 39: $base64_value="n";break;
	case 40: $base64_value="o";break;
	case 41: $base64_value="p";break;
	case 42: $base64_value="q";break;
	case 43: $base64_value="r";break;
	case 44: $base64_value="s";break;
	case 45: $base64_value="t";break;
	case 46: $base64_value="u";break;
	case 47: $base64_value="v";break;
	case 48: $base64_value="w";break;
	case 49: $base64_value="x";break;
	case 50: $base64_value="y";break;
	case 51: $base64_value="z";break;
	case 52: $base64_value="0";break;
	case 53: $base64_value="1";break;
	case 54: $base64_value="2";break;
	case 55: $base64_value="3";break;
	case 56: $base64_value="4";break;
	case 57: $base64_value="5";break;
	case 58: $base64_value="6";break;
	case 59: $base64_value="7";break;
	case 60: $base64_value="8";break;
	case 61: $base64_value="9";break;
	case 62: $base64_value="+";break;
	case 63: $base64_value="/";break;
	case 64: $base64_value="=";break;
	default: $base64_value="a";break;
   }

   return $base64_value;
}

 function os_get_cross_sell_name($cross_sell_group, $language_id = '') {

	if (!$language_id)
		$language_id = $_SESSION['languages_id'];
	$cross_sell_query = os_db_query("select groupname from ".TABLE_PRODUCTS_XSELL_GROUPS." where products_xsell_grp_name_id = '".$cross_sell_group."' and language_id = '".$language_id."'");
	$cross_sell = os_db_fetch_array($cross_sell_query);

	return $cross_sell['groupname'];
}

  function os_activate_banners() {
    $banners_query = os_db_query("select banners_id, date_scheduled from " . TABLE_BANNERS . " where date_scheduled != ''");
    if (os_db_num_rows($banners_query)) {
      while ($banners = os_db_fetch_array($banners_query)) {
        if (date('Y-m-d H:i:s') >= $banners['date_scheduled']) {
          os_set_banner_status($banners['banners_id'], '1');
        }
      }
    }
  }
  
  function os_add_tax($price, $tax) 
	{ 
	  $price=$price+$price/100*$tax;
	  return $price;
	  }
	  
	  
	  
function os_address_format($address_format_id, $address, $html, $boln, $eoln) {
    $address_format_query = os_db_query("select address_format as format from " . TABLE_ADDRESS_FORMAT . " where address_format_id = '" . $address_format_id . "'");
    $address_format = os_db_fetch_array($address_format_query);

    $company = addslashes($address['company']);
    $firstname = addslashes($address['firstname']);
    $lastname = addslashes($address['lastname']);
    $street = addslashes($address['street_address']);
    $suburb = addslashes($address['suburb']);
    $city = addslashes($address['city']);
    $state = addslashes($address['state']);
    $country_id = $address['country_id'];
    $zone_id = $address['zone_id'];
    $postcode = addslashes($address['postcode']);
    $zip = $postcode;
    $country = os_get_country_name($country_id);
    $state = os_get_zone_name($country_id, $zone_id, $state);

    if ($html) {
// HTML Mode
      $HR = '<hr />';
      $hr = '<hr />';
      if ( ($boln == '') && ($eoln == "\n") ) { // Values not specified, use rational defaults
        $CR = '<br />';
        $cr = '<br />';
        $eoln = $cr;
      } else { // Use values supplied
        $CR = $eoln . $boln;
        $cr = $CR;
      }
    } else {
// Text Mode
      $CR = $eoln;
      $cr = $CR;
      $HR = '----------------------------------------';
      $hr = '----------------------------------------';
    }

    $statecomma = '';
    $streets = $street;
    if ($suburb != '') $streets = $street . $cr . $suburb;
    if ($firstname == '') $firstname = addslashes($address['name']);
    if ($country == '') $country = addslashes($address['country']);
    if ($state != '') $statecomma = $state . ', ';

    $fmt = $address_format['format'];
    eval("\$address = \"$fmt\";");

    if ( (ACCOUNT_COMPANY == 'true') && (os_not_null($company)) ) {
      $address = $company . $cr . $address;
    }

    $address = stripslashes($address);

    return $address;
  }

  function os_address_label($customers_id, $address_id = 1, $html = false, $boln = '', $eoln = "\n") {
    $address_query = os_db_query("select entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $customers_id . "' and address_book_id = '" . $address_id . "'");
    $address = os_db_fetch_array($address_query);

    $format_id = os_get_address_format_id($address['country_id']);

    return os_address_format($format_id, $address, $html, $boln, $eoln);
  }

function os_address_summary($customers_id, $address_id) {
    $customers_id = os_db_prepare_input($customers_id);
    $address_id = os_db_prepare_input($address_id);

    $address_query = os_db_query("select ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_state, ab.entry_country_id, ab.entry_zone_id, c.countries_name, c.address_format_id from " . TABLE_ADDRESS_BOOK . " ab, " . TABLE_COUNTRIES . " c where ab.address_book_id = '" . os_db_input($address_id) . "' and ab.customers_id = '" . os_db_input($customers_id) . "' and ab.entry_country_id = c.countries_id");
    $address = os_db_fetch_array($address_query);

    $street_address = $address['entry_street_address'];
    $suburb = $address['entry_suburb'];
    $postcode = $address['entry_postcode'];
    $city = $address['entry_city'];
    $state = os_get_zone_name($address['entry_country_id'], $address['entry_zone_id'], $address['entry_state']);
    $country = $address['countries_name'];

    $address_format_query = os_db_query("select address_summary from " . TABLE_ADDRESS_FORMAT . " where address_format_id = '" . $address['address_format_id'] . "'");
    $address_format = os_db_fetch_array($address_format_query);

//    eval("\$address = \"{$address_format['address_summary']}\";");
    $address_summary = $address_format['address_summary'];
    eval("\$address = \"$address_summary\";");

    return $address;
  }

  function os_array_to_string($array, $exclude = '', $equals = '=', $separator = '&') {
    if (!is_array($exclude)) $exclude = array();

    $get_string = '';
    if (sizeof($array) > 0) {
      while (list($key, $value) = each($array)) {
        if ( (!in_array($key, $exclude)) && ($key != 'x') && ($key != 'y') ) {
          $get_string .= $key . $equals . $value . $separator;
        }
      }
      $remove_chars = strlen($separator);
      $get_string = substr($get_string, 0, -$remove_chars);
    }

    return $get_string;
  }

  function os_banner_exists($action, $identifier) 
  {
    if ($action == 'dynamic') {
      return os_random_select("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
    } elseif ($action == 'static') {
      $banner_query = os_db_query("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . $identifier . "'");
      return os_db_fetch_array($banner_query);
    } else {
      return false;
    }
  }

  function os_break_string($string, $len, $break_char = '-') {
    $l = 0;
    $output = '';
    for ($i=0, $n=utf8_strlen($string); $i<$n; $i++) {
      $char = utf8_substr($string, $i, 1);
      if ($char != ' ') {
        $l++;
      } else {
        $l = 0;
      }
      if ($l > $len) {
        $l = 1;
        $output .= $break_char;
      }
      $output .= $char;
    }
    return $output;
  }


   
function browser($browser) {
	switch($browser) {
		case 'MSIE': $browser = 'images/icons/icons_browser/iexplore.jpg'; break;
		case 'Netscape': $browser = 'images/icons/icons_browser/netscape.jpg'; break;
		case 'Opera': $browser = 'images/icons/icons_browser/opera.jpg'; break;
		case 'Mozilla': $browser = 'images/icons/icons_browser/mozilla.jpg'; break;
		case 'Safari': $browser = 'images/icons/icons_browser/safari.jpg'; break;
		case 'Firefox': $browser = 'images/icons/icons_browser/firefox.jpg'; break;
		case 'Firebird': $browser = 'images/icons/icons_browser/firebird.jpg'; break;
		case 'AOL': $browser = 'images/icons/icons_browser/aol.jpg'; break;
		case 'Unknown': $browser = 'images/icons/icons_browser/unknown.jpg'; break;
		case 'Konqueror': $browser = 'images/icons/icons_browser/konqueror.jpg'; break;
		case 'Camino': $browser = 'images/icons/icons_browser/camino.jpg'; break;
		case 'Thunderbird': $browser = 'images/icons/icons_browser/thunderbird.jpg'; break;
		case 'Mac': $browser = 'images/icons/icons_browser/mac.jpg'; break;
		case 'AvantGo': $browser = 'images/icons/icons_browser/avantgo.jpg'; break;
		case 'Nautilus': $browser = 'images/icons/icons_browser/nautilus.jpg'; break; // added 7/20/04
		case 'Avant Browser': $browser = 'images/icons/icons_browser/avant.jpg'; break; // added 7/23/04
		default: $browser = 'images/icons/icons_browser/no_icon.jpg'; break;
		
	}
	//if($browser && trim($browser) != 'images/icons/') { $browser = 'images/icons/icons_browser/no_icon.jpg'; }
	if(trim($browser) == 'images/icons/') { $browser = 'images/icons/icons_browser/unknown.jpg'; }
	
	//echo "BROWSER: $browser<br>"; // TEST
	return $browser;
}

  function os_browser_detect($component) {

    return stristr($_SERVER['HTTP_USER_AGENT'], $component);
  }

  function os_calculate_tax($price, $tax) {
    //global $currencies;
	return $price * $tax / 100;
    //return os_round($price * $tax / 100, $currencies->currencies[DEFAULT_CURRENCY]['decimal_places']);
  }

function os_category_link($cID,$cName='') {
		$cName = os_cleanName($cName);
		$link = 'cat='.$cID;
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') $link = 'cat=c'.$cID.'_'.$cName.'.html';
		return $link;
}

function os_check_categories_status($categories_id) {

	if (!$categories_id)
		return 0;

	$categorie_query = "SELECT
	                                   parent_id,
	                                   categories_status
	                                   FROM ".TABLE_CATEGORIES."
	                                   WHERE
	                                   categories_id = '".(int) $categories_id."'";

	$categorie_query = osDBquery($categorie_query);

	$categorie_data = os_db_fetch_array($categorie_query, true);
	if ($categorie_data['categories_status'] == 0) {
		return 1;
	} else {
		if ($categorie_data['parent_id'] != 0) {
			if (os_check_categories_status($categorie_data['parent_id']) >= 1)
				return 1;
		}
		return 0;
	}

}

function os_get_categoriesstatus_for_product($product_id) {

	$categorie_query = "SELECT
	                                   categories_id
	                                   FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
	                                   WHERE products_id='".$product_id."'";

	$categorie_query = osDBquery($categorie_query);

	while ($categorie_data = os_db_fetch_array($categorie_query, true)) {
		if (os_check_categories_status($categorie_data['categories_id']) >= 1) {
			return 1;
		} else {
			return 0;
		}
		echo $categorie_data['categories_id'];
	}

}

  function os_check_gzip() {

    if (headers_sent() || connection_aborted()) {
      return false;
    }

    if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) return 'x-gzip';

    if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'],'gzip') !== false) return 'gzip';

    return false;
  }

  function os_check_gzip() {

    if (headers_sent() || connection_aborted()) {
      return false;
    }

    if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) return 'x-gzip';

    if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'],'gzip') !== false) return 'gzip';

    return false;
  }

  function os_check_stock_attributes($attribute_id, $products_quantity) {

       $stock_query=os_db_query("SELECT
                                  attributes_stock
                                  FROM ".TABLE_PRODUCTS_ATTRIBUTES."
                                  WHERE products_attributes_id='".$attribute_id."'");
       $stock_data=os_db_fetch_array($stock_query);
    $stock_left = $stock_data['attributes_stock'] - $products_quantity;
    $out_of_stock = '';

    if ($stock_left < 0) {
      $out_of_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
    }

    return $out_of_stock;
  }


  function os_checkdate($date_to_check, $format_string, &$date_array) {
    $separator_idx = -1;

    $separators = array('-', ' ', '/', '.');
    $month_abbr = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');
    $no_of_days = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    $format_string = strtolower($format_string);

    if (strlen($date_to_check) != strlen($format_string)) {
      return false;
    }

    $size = sizeof($separators);
    for ($i=0; $i<$size; $i++) {
      $pos_separator = strpos($date_to_check, $separators[$i]);
      if ($pos_separator != false) {
        $date_separator_idx = $i;
        break;
      }
    }

    for ($i=0; $i<$size; $i++) {
      $pos_separator = strpos($format_string, $separators[$i]);
      if ($pos_separator != false) {
        $format_separator_idx = $i;
        break;
      }
    }

    if ($date_separator_idx != $format_separator_idx) {
      return false;
    }

    if ($date_separator_idx != -1) {
      $format_string_array = explode( $separators[$date_separator_idx], $format_string );
      if (sizeof($format_string_array) != 3) {
        return false;
      }

      $date_to_check_array = explode( $separators[$date_separator_idx], $date_to_check );
      if (sizeof($date_to_check_array) != 3) {
        return false;
      }

      $size = sizeof($format_string_array);
      for ($i=0; $i<$size; $i++) {
        if ($format_string_array[$i] == 'mm' || $format_string_array[$i] == 'mmm') $month = $date_to_check_array[$i];
        if ($format_string_array[$i] == 'dd') $day = $date_to_check_array[$i];
        if ( ($format_string_array[$i] == 'yyyy') || ($format_string_array[$i] == 'aaaa') ) $year = $date_to_check_array[$i];
      }
    } else {
      if (strlen($format_string) == 8 || strlen($format_string) == 9) {
        $pos_month = strpos($format_string, 'mmm');
        if ($pos_month != false) {
          $month = substr( $date_to_check, $pos_month, 3 );
          $size = sizeof($month_abbr);
          for ($i=0; $i<$size; $i++) {
            if ($month == $month_abbr[$i]) {
              $month = $i;
              break;
            }
          }
        } else {
          $month = substr($date_to_check, strpos($format_string, 'mm'), 2);
        }
      } else {
        return false;
      }

      $day = substr($date_to_check, strpos($format_string, 'dd'), 2);
      $year = substr($date_to_check, strpos($format_string, 'yyyy'), 4);
    }

    if (strlen($year) != 4) {
      return false;
    }

    if (!settype($year, 'integer') || !settype($month, 'integer') || !settype($day, 'integer')) {
      return false;
    }

    if ($month > 12 || $month < 1) {
      return false;
    }

    if ($day < 1) {
      return false;
    }

    if (os_is_leap_year($year)) {
      $no_of_days[1] = 29;
    }

    if ($day > $no_of_days[$month - 1]) {
      return false;
    }

    $date_array = array($year, $month, $day);

    return true;
  }

function os_cleanName($name) {
//     $replace_param='/[^a-zA-Z0-9]/';
     $replace_param='/[^a-zA-Zа-яА-Я0-9]/';
     $cyrillic = array("ж", "ё", "й","ю", "ь","ч", "щ", "ц","у","к","е","н","г","ш", "з","х","ъ","ф","ы","в","а","п","р","о","л","д","э","я","с","м","и","т","б","Ё","Й","Ю","Ч","Ь","Щ","Ц","У","К","Е","Н","Г","Ш","З","Х","Ъ","Ф","Ы","В","А","П","Р","О","Л","Д","Ж","Э","Я","С","М","И","Т","Б");
     $translit = array("zh","yo","i","yu","","ch","sh","c","u","k","e","n","g","sh","z","h","",  "f",  "y",  "v",  "a",  "p",  "r",  "o",  "l",  "d",  "ye", "ya", "s",  "m",  "i",  "t",  "b",  "yo", "I",  "YU", "CH", "",  "SH", "C",  "U",  "K",  "E",  "N",  "G",  "SH", "Z",  "H",  "",  "F",  "Y",  "V",  "A",  "P",  "R",  "O",  "L",  "D",  "Zh", "Ye", "Ya", "S",  "M",  "I",  "T",  "B");
     $name = str_replace($cyrillic, $translit, $name);    
     $name=preg_replace($replace_param,'-',$name);    
     return $name;
}



function os_collect_posts() 
{
      global $coupon_no, $REMOTE_ADDR,$osPrice,$cc_id;
      if (!$REMOTE_ADDR) $REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
      if ($_POST['gv_redeem_code']) {
        $gv_query = os_db_query("select coupon_id, coupon_amount, coupon_type, coupon_minimum_order,uses_per_coupon, uses_per_user, restrict_to_products,restrict_to_categories from " . TABLE_COUPONS . " where coupon_code='".$_POST['gv_redeem_code']."' and coupon_active='Y'");
        $gv_result = os_db_fetch_array($gv_query);

        if (os_db_num_rows($gv_query) != 0) {
          $redeem_query = os_db_query("select * from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $gv_result['coupon_id'] . "'");
          if ( (os_db_num_rows($redeem_query) != 0) && ($gv_result['coupon_type'] == 'G') ) {
            os_redirect(os_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_INVALID_REDEEM_GV), 'SSL'));
          }
        }  else {

        os_redirect(os_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_INVALID_REDEEM_GV), 'SSL'));
        }



        // GIFT CODE G START
        if ($gv_result['coupon_type'] == 'G') {

          $gv_amount = $gv_result['coupon_amount'];
          // Things to set
          // ip address of claimant
          // customer id of claimant
          // date
          // redemption flag
          // now update customer account with gv_amount
          $gv_amount_query=os_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $_SESSION['customer_id'] . "'");
          $customer_gv = false;
          $total_gv_amount = $gv_amount;
          if ($gv_amount_result = os_db_fetch_array($gv_amount_query)) {
            $total_gv_amount = $gv_amount_result['amount'] + $gv_amount;
            $customer_gv = true;
          }
          $gv_update = os_db_query("update " . TABLE_COUPONS . " set coupon_active = 'N' where coupon_id = '" . $gv_result['coupon_id'] . "'");
          $gv_redeem = os_db_query("insert into  " . TABLE_COUPON_REDEEM_TRACK . " (coupon_id, customer_id, redeem_date, redeem_ip) values ('" . $gv_result['coupon_id'] . "', '" . $_SESSION['customer_id'] . "', now(),'" . $REMOTE_ADDR . "')");
          if ($customer_gv) {
            // already has gv_amount so update
            $gv_update = os_db_query("update " . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $total_gv_amount . "' where customer_id = '" . $_SESSION['customer_id'] . "'");
          } else {
            // no gv_amount so insert
            $gv_insert = os_db_query("insert into " . TABLE_COUPON_GV_CUSTOMER . " (customer_id, amount) values ('" . $_SESSION['customer_id'] . "', '" . $total_gv_amount . "')");
          }
          os_redirect(os_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(REDEEMED_AMOUNT. $osPrice->Format($gv_amount,true,0,true)), 'SSL'));



      } else {



        if (os_db_num_rows($gv_query)==0) {
            os_redirect(os_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_INVALID_REDEEM_COUPON), 'SSL'));
        }

        $date_query=os_db_query("select coupon_start_date from " . TABLE_COUPONS . " where coupon_start_date <= now() and coupon_code='".$_POST['gv_redeem_code']."'");

        if (os_db_num_rows($date_query)==0) {
            os_redirect(os_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_STARTDATE_COUPON), 'SSL'));
        }

        $date_query=os_db_query("select coupon_expire_date from " . TABLE_COUPONS . " where coupon_expire_date >= now() and coupon_code='".$_POST['gv_redeem_code']."'");

       if (os_db_num_rows($date_query)==0) {
            os_redirect(os_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_FINISDATE_COUPON), 'SSL'));
        }

        $coupon_count = os_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $gv_result['coupon_id']."'");
        $coupon_count_customer = os_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $gv_result['coupon_id']."' and customer_id = '" . $_SESSION['customer_id'] . "'");

        if (os_db_num_rows($coupon_count)>=$gv_result['uses_per_coupon'] && $gv_result['uses_per_coupon'] > 0) {
            os_redirect(os_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_USES_COUPON . $gv_result['uses_per_coupon'] . TIMES ), 'SSL'));
        }

        if (os_db_num_rows($coupon_count_customer)>=$gv_result['uses_per_user'] && $gv_result['uses_per_user'] > 0) {
            os_redirect(os_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_USES_USER_COUPON . $gv_result['uses_per_user'] . TIMES ), 'SSL'));
        }
        if ($gv_result['coupon_type']=='S') {
            $coupon_amount = $order->info['shipping_cost'];
        } else {
            $coupon_amount = $gv_result['coupon_amount'] . ' ';
        }
        if ($gv_result['coupon_type']=='P') $coupon_amount = $gv_result['coupon_amount'] . '% ';
        if ($gv_result['coupon_minimum_order']>0) $coupon_amount .= 'on orders greater than ' . $gv_result['coupon_minimum_order'];
        if (!os_session_is_registered('cc_id')) os_session_register('cc_id'); //Fred - this was commented out before
        $_SESSION['cc_id'] = $gv_result['coupon_id']; //Fred ADDED, set the global and session variable
        os_redirect(os_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(REDEEMED_COUPON), 'SSL'));
    }

     }
     if ($_POST['submit_redeem_x'] && $gv_result['coupon_type'] == 'G') os_redirect(os_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_REDEEM_CODE), 'SSL'));
}



function os_convert_linefeeds($from, $to, $string) 
{
      return str_replace($from, $to, $string);
}




function os_count_cart() 
{

	$id_list = $_SESSION['cart']->get_product_id_list();

	$id_list = explode(', ', $id_list);

	$actual_content = array ();

	for ($i = 0, $n = sizeof($id_list); $i < $n; $i ++) {

		$actual_content[] = array ('id' => $id_list[$i], 'qty' => $_SESSION['cart']->get_quantity($id_list[$i]));

	}

	// merge product IDs
	$content = array ();
	for ($i = 0, $n = sizeof($actual_content); $i < $n; $i ++) {

		//$act_id=$actual_content[$i]['id'];
		if (strpos($actual_content[$i]['id'], '{')) {
			$act_id = substr($actual_content[$i]['id'], 0, strpos($actual_content[$i]['id'], '{'));
		} else {
			$act_id = $actual_content[$i]['id'];
		}

		$_SESSION['actual_content'][$act_id] = array ('qty' => $_SESSION['actual_content'][$act_id]['qty'] + $actual_content[$i]['qty']);

	}

}

function os_count_customer_address_book_entries($id = '', $check_session = true) {

    if (is_numeric($id) == false) {
      if (isset($_SESSION['customer_id'])) {
        $id = $_SESSION['customer_id'];
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( (isset($_SESSION['customer_id']) == false) || ($id != $_SESSION['customer_id']) ) {
        return 0;
      }
    }

    $addresses_query = os_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$id . "'");
    $addresses = os_db_fetch_array($addresses_query);

    return $addresses['total'];
  }

  function os_count_customer_orders($id = '', $check_session = true) {

    if (is_numeric($id) == false) {
      if (isset($_SESSION['customer_id'])) {
        $id = $_SESSION['customer_id'];
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( (isset($_SESSION['customer_id']) == false) || ($id != $_SESSION['customer_id']) ) {
        return 0;
      }
    }

    $orders_check_query = os_db_query("select count(*) as total from " . TABLE_ORDERS . " where customers_id = '" . (int)$id . "'");
    $orders_check = os_db_fetch_array($orders_check_query);
    return $orders_check['total'];
  }

function os_count_modules($modules = '') {
    $count = 0;

    if (empty($modules)) return $count;

    $modules_array = split(';', $modules);

    for ($i=0, $n=sizeof($modules_array); $i<$n; $i++) {
      $class = substr($modules_array[$i], 0, strrpos($modules_array[$i], '.'));

      if (is_object($GLOBALS[$class])) {
        if ($GLOBALS[$class]->enabled) {
          $count++;
        }
      }
    }

    return $count;
  }

  function os_count_payment_modules() {
    return os_count_modules(MODULE_PAYMENT_INSTALLED);
  }

  function os_count_products_in_category($category_id, $include_inactive = false) {
    $products_count = 0;
    if ($include_inactive == true) {
      $products_query = "select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = p2c.products_id and p2c.categories_id = '" . $category_id . "'";
    } else {
      $products_query = "select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = p2c.products_id and p.products_status = '1' and p2c.categories_id = '" . $category_id . "'";
    }

    $products_query = osDBquery($products_query);

    $products = os_db_fetch_array($products_query,true);
    $products_count += $products['total'];

    $child_categories_query = "select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . $category_id . "'";

    $child_categories_query = osDBquery($child_categories_query);
    if (os_db_num_rows($child_categories_query,true)) {
      while ($child_categories = os_db_fetch_array($child_categories_query,true)) {
        $products_count += os_count_products_in_category($child_categories['categories_id'], $include_inactive);
      }
    }


    return $products_count;
  }

  function os_count_shipping_modules() {
    return os_count_modules(MODULE_SHIPPING_INSTALLED);
  }



$engines = array(
'www.alexa.com' => 'Alexa',
'www.alltheinternet.com' => 'All the Internet',
'alltheweb.com' => 'AlltheWeb.com',
'www.altavista.com' => 'AltaVista',
'aolsearch.aol.com' => 'AOL Web Search',
'search.aol.com' => 'AOL Web Search',
'web.ask.com' => 'Ask Jeeves',
'search.dmoz.org' => 'DMOZ',
'www.dogpile.com' => 'Dogpile',
'search.earthlink.net' => 'EarthLink',
'www.entireweb.com' => 'Entireweb',
'euroseek.com' => 'Euroseek.com',
'msxml.excite.com' => 'Excite',
'www.gigablast.com' => 'Gigablast',
'www.google.com' => 'Google',
'www.hotbot.com' => 'HotBot',
'search.iwon.com' => 'iWon',
'search.looksmart.com' => 'LookSmart',
'www.metacrawler.com' => 'MetaCrawler',
'search.msn.com' => 'MSN Search',
'search.netscape.com' => 'Netscape Search',
'www.overture.com' => 'Overture',
'www.search.com' => 'Search.com',
's.teoma.com' => 'Teoma',
'search.viewpoint.com' => 'Viewpoint',
'msxml.webcrawler.com' => 'WebCrawler',
'www.wisenut.com' => 'WiseNut',
'search.yahoo.com' => 'Yahoo!',
'br.busca.yahoo.com' => 'Yahoo!', // Brazil
'www.zeal.com' => 'Zeal.com'
);

// search engine "start of query" markers
$keymark = array(
'Alexa' => 'q=',
'All the Internet' => 'q=',
'AlltheWeb.com' => 'q=',
'AltaVista' => 'q=',
'AOL Web Search' => 'query=',
'Ask Jeeves' => 'q=',
'DMOZ' => 'search=',
'Dogpile' => 'web/',
'EarthLink' => 'q=',
'Entireweb' => 'q=',
'Euroseek.com' => 'string=',
'Excite' => 'web/',
'Gigablast' => 'q=',
'Google' => 'q=',
'HotBot' => 'query=',
'iWon' => 'searchfor=',
'LookSmart' => 'qt=',
'MetaCrawler' => 'web/',
'MSN Search' => 'q=',
'Netscape Search' => 'query=',
'Overture' => 'Keywords=',
'Search.com' => 'q=',
'Teoma' => 'q=',
'Viewpoint' => 'k=',
'WebCrawler' => 'web/',
'WiseNut' => 'q=',
'Yahoo!' => 'p=',
'Zeal.com' => 'keyword='
);


     function os_RandomString($length) {
       $chars = array( 'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n','N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v','V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

       $max_chars = count($chars) - 1;
       srand( (double) microtime()*1000000);

       $rand_str = '';
       for($i=0;$i<$length;$i++)
       {
         $rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
       }

         return $rand_str;
       }

  function os_create_password($length) {

  	$pass=os_RandomString($length);
    return md5($pass);
  }

function os_create_random_value($length, $type = 'mixed') {
    if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;

    $rand_value = '';
    while (strlen($rand_value) < $length) {
      if ($type == 'digits') {
        $char = os_rand(0,9);
      } else {
        $char = chr(os_rand(0,255));
      }
      if ($type == 'mixed') {
        if (eregi('^[a-z0-9]$', $char)) $rand_value .= $char;
      } elseif ($type == 'chars') {
        if (eregi('^[a-z]$', $char)) $rand_value .= $char;
      } elseif ($type == 'digits') {
        if (ereg('^[0-9]$', $char)) $rand_value .= $char;
      }
    }

    return $rand_value;
  }


  function os_create_sort_heading($sortby, $colnum, $heading) {

    $sort_prefix = '';
    $sort_suffix = '';

    if ($sortby) {
      $sort_prefix = '<a href="' . os_href_link(basename($_SERVER['PHP_SELF']), os_get_all_get_params(array('page', 'info', 'sort')) . 'page=1&sort=' . $colnum . ($sortby == $colnum . 'a' ? 'd' : 'a')) . '" title="' . TEXT_SORT_PRODUCTS . ($sortby == $colnum . 'd' || substr($sortby, 0, 1) != $colnum ? TEXT_ASCENDINGLY : TEXT_DESCENDINGLY) . TEXT_BY . $heading . '" class="productListing-heading">' ;
      $sort_suffix = (substr($sortby, 0, 1) == $colnum ? (substr($sortby, 1, 1) == 'a' ? '+' : '-') : '') . '</a>';
    }

    return $sort_prefix . $heading . $sort_suffix;
  }

function os_currency_exists($code) {
	$param ='/[^a-zA-Z]/';
	$code=preg_replace($param,'',$code);
	$currency_code = os_db_query("SELECT code, currencies_id from " . TABLE_CURRENCIES . " WHERE code = '" . $code . "' LIMIT 1");
	if (os_db_num_rows($currency_code)) {
		$curr = os_db_fetch_array($currency_code);
		if ($curr['code'] == $code) {
			return $code;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

  function os_customer_greeting() {

    if (isset($_SESSION['customer_last_name']) && isset($_SESSION['customer_id'])) {
      if (!isset($_SESSION['customer_gender'])) {
      $check_customer_query = "select customers_gender FROM  " . TABLE_CUSTOMERS . " where customers_id = '" . $_SESSION['customer_id'] . "'";
      $check_customer_query = osDBquery($check_customer_query);
      $check_customer_data  = os_db_fetch_array($check_customer_query,true);
      $_SESSION['customer_gender'] = $check_customer_data['customers_gender'];
      }
      if($_SESSION['customer_gender']=='f'){
      $greeting_string = sprintf(TEXT_GREETING_PERSONAL, FEMALE . '&nbsp;'. $_SESSION['customer_first_name'] . '&nbsp;'. $_SESSION['customer_last_name'], os_href_link(FILENAME_PRODUCTS_NEW));
      }else{
      $greeting_string = sprintf(TEXT_GREETING_PERSONAL, MALE . '&nbsp;'. $_SESSION['customer_first_name'] . '&nbsp;' . $_SESSION['customer_last_name'], os_href_link(FILENAME_PRODUCTS_NEW));
      }

    } else {
      $greeting_string = sprintf(TEXT_GREETING_GUEST, os_href_link(FILENAME_LOGIN, '', 'SSL'), os_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
    }

    return $greeting_string;
  }


  function os_date_long($raw_date) {
    if ( ($raw_date == '0000-00-00 00:00:00') || ($raw_date == '') ) return false;

    $year = (int)substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

if (function_exists('os_date_long_translate')) 
    return os_date_long_translate(strftime(DATE_FORMAT_LONG, mktime($hour,$minute,$second,$month,$day,$year))); 
    return strftime(DATE_FORMAT_LONG, mktime($hour,$minute,$second,$month,$day,$year));
  }


  function os_date_short($raw_date) {
    if ( ($raw_date == '0000-00-00 00:00:00') || empty($raw_date) ) return false;

    $year = substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

    if (@date('Y', mktime($hour, $minute, $second, $month, $day, $year)) == $year) {
      return date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
    } else {
      return ereg_replace('2037' . '$', $year, date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, 2037)));
    }
  }


  function os_db_close($link = 'db_link') {
    global $$link;

    return mysql_close($$link);
  }


  function os_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $$link;

    if (USE_PCONNECT == 'true') {
     $$link = mysql_pconnect($server, $username, $password);
    } else {
$$link = @mysql_connect($server, $username, $password);
    
   }

if ($$link){
   @mysql_select_db($database);
   @mysql_query("SET CHARACTER SET utf8");
   @mysql_query("SET NAMES utf8");
   @mysql_query("SET COLLATION utf8_general_ci");
}


    if (!$$link) {
      os_db_error("connect", mysql_errno(), mysql_error());
    }


    return $$link;
  }


  function os_db_connect_installer($server, $username, $password, $link = 'db_link') {
    global $$link, $db_error;

    $db_error = false;

    if (!$server) {
      $db_error = 'No Server selected.';
      return false;
    }

    $$link = @mysql_connect($server, $username, $password) or $db_error = mysql_error();
    
   @mysql_query("SET CHARACTER SET utf8");
   @mysql_query("SET NAMES utf8");
   @mysql_query("SET COLLATION utf8_general_ci");

    return $$link;
  }


  function os_db_data_seek($db_query, $row_number,$cq=false) {


    if (DB_CACHE=='true' && $cq) {
    if (!count($db_query)) return;
     return $db_query[$row_number];
      } else {

         if (!is_array($db_query)) return mysql_data_seek($db_query, $row_number);

      }

  }


function os_db_error($query, $errno, $error) 
{
    global $db;
	$db->error($query, $errno, $error);
}

function zen_trace_back($backtrace=false, $from=0, $to=0, $get_call=true) {
	if (!$backtrace)
		$backtrace = debug_backtrace();
	$output = array();
	for ($i=count($backtrace)-1-$from;$i>$to-1;$i--) {
		$args = '';
		if ($get_call && is_array($backtrace[$i]['args'])){
			$args = str_replace("\n", "; ", zen_trace_vardump($backtrace[$i]['args']));
/*
			foreach ($backtrace[$i]['args'] as $a) {
				if (!empty($args))
					$args .= ', ';
				switch (gettype($a)) {
					case 'integer':
					case 'double':
						$args .= $a;
						break;
					case 'string':
						$a = substr($a, 0, 64).((strlen($a) > 64) ? '...' : '');
						$args .= "\"$a\"";
						break;
					case 'array':
						$args .= 'Array('.count($a).')';
						break;
					case 'object':
						$args .= 'Object('.get_class($a).')';
						break;
					case 'resource':
						$args .= 'Resource('.strstr($a, '#').')';
						break;
					case 'boolean':
						$args .= $a ? 'True' : 'False';
						break;
					case 'NULL':
						$args .= 'Null';
						break;
					default:
						$args .= 'Unknown';
				}
			}
*/
		}
		$output[] = $backtrace[$i]['file'].":".$backtrace[$i]['line'] . (($get_call) ? "(".$backtrace[$i]['class'].$backtrace[$i]['type'].$backtrace[$i]['function'].$args.")" : "");
	}
	return $output;
}

	function zen_trace_vardump($var){
		ob_start();
		var_dump($var);
		$out = ob_get_contents();
		ob_end_clean();
		return($out);
	}

// EOF db-error processing


function os_db_fetch_array(&$db_query,$cq=false) 
{
   if (DB_CACHE=='true' && $cq) 
   {
       if (!count($db_query)) return false;
       $curr = current($db_query);
       next($db_query);
       return $curr;
   } 
   else 
   {
       if (is_array($db_query)) 
	   {
          $curr = current($db_query);
          next($db_query);
          return $curr;
       }
       return mysql_fetch_array($db_query, MYSQL_ASSOC);
    }
}

  function os_db_fetch_fields($db_query) {
    return mysql_fetch_field($db_query);
  }

function os_db_free_result(&$db_query) {
  if (is_array($db_query)) {
    unset($db_query);
    return true;
  } else {
    return mysql_free_result($db_query);
  }
}

  function os_db_input($string, $link = 'db_link') {
  global $$link;

  if (function_exists('mysql_real_escape_string')) {
    return mysql_real_escape_string($string, $$link);
  } elseif (function_exists('mysql_escape_string')) {
    return mysql_escape_string($string);
  }

  return addslashes($string);
}


  function os_db_insert_id() {
    return mysql_insert_id();
  }


  function os_db_num_rows($db_query,$cq=false) {
      if (DB_CACHE=='true' && $cq) {
         if (!count($db_query)) return false;
     return count($db_query);
      } else {

         if (!is_array($db_query)) return mysql_num_rows($db_query);

      }
      /*
    if (!is_array($db_query)) return mysql_num_rows($db_query);
    if (!count($db_query)) return false;
     return count($db_query);
     */
  }


  function os_db_output($string) {
    return htmlspecialchars($string);
  }


  function os_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    reset($data);

    if ($action == 'insert') {
      $query = 'insert into ' . $table . ' (';
      while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      reset($data);
      while (list(, $value) = each($data)) {
      	 $value = (is_Float($value) & PHP4_3_10) ? sprintf("%.F",$value) : (string)($value);
        switch ($value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . os_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
         $value = (is_Float($value) & PHP4_3_10) ? sprintf("%.F",$value) : (string)($value);
      	switch ($value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . os_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }

    return os_db_query($query, $link);
  }


  function os_db_prepare_input($string) {
    if (is_string($string)) {
  return trim(stripslashes($string));
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = os_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }


 function os_db_query($query, $link = 'db_link') {
    global $$link;
    global $query_counts;
    $query_counts++; 

    //echo $query.'<br>';

    if (STORE_DB_TRANSACTIONS == 'true') {
      error_log('QUERY ' . $query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }
    $result = mysql_query($query, $$link) or os_db_error($query, mysql_errno(), mysql_error());

    if (STORE_DB_TRANSACTIONS == 'true') {
       $result_error = mysql_error();
       error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

    if (!$result) {
      os_db_error($query, mysql_errno(), mysql_error());
    }


    return $result;
  }


  function os_db_query_installer($query, $link = 'db_link') {
    global $$link;

    return mysql_query($query, $$link);
  }



  function os_db_queryCached($query, $link = 'db_link') {
    global $$link;

    // get HASH ID for filename
    $id=md5($query);


    // cache File Name
    $file=SQL_CACHEDIR.$id.'.os';

    // file life time
    $expire = DB_CACHE_EXPIRE; // 24 hours

    if (STORE_DB_TRANSACTIONS == 'true') {
      error_log('QUERY ' . $query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

    if (file_exists($file) && filemtime($file) > (time() - $expire)) {

     // get cached resulst
        $result = unserialize(implode('',file($file)));

        } else {

         if (file_exists($file)) @unlink($file);

        // get result from DB and create new file
        $result = mysql_query($query, $$link) or os_db_error($query, mysql_errno(), mysql_error());

        if (STORE_DB_TRANSACTIONS == 'true') {
                $result_error = mysql_error();
                error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
        }

        // fetch data into array
        while ($record = os_db_fetch_array($result))
                $records[]=$record;


        // safe result into file.
        $stream = serialize($records);
        $fp = fopen($file,"w");
        fwrite($fp, $stream);
        fclose($fp);
        $result = unserialize(implode('',file($file)));

   }

    return $result;
  }


  function os_db_select_db($database) {
    return mysql_select_db($database);
  }


   
function os_db_test_connection($database) {
    global $db_error;

    $db_error = false;

    if (!$db_error) {
      if (!@os_db_select_db($database)) {
        $db_error = mysql_error();
      } else {
        if (!@os_db_query_installer("select count(*) from " . TABLE_CONFIGURATION . "")) {
          $db_error = mysql_error();
        }
      }
    }

    if ($db_error) {
      return false;
    } else {
      return true;
    }
  }


  
function os_db_test_create_db_permission($database) {
    global $db_error;

    $db_created = false;
    $db_error = false;

    if (!$database) {
      $db_error = 'No Database selected.';
      return false;
    }

    if (!$db_error) {
      if (!@os_db_select_db($database)) {
        $db_created = true;
        if (!@os_db_query_installer_installer('create database ' . $database)) {
          $db_error = mysql_error();
        }
      } else {
        $db_error = mysql_error();
      }
      if (!$db_error) {
        if (@os_db_select_db($database)) {
          if (@os_db_query_installer('create table temp ( temp_id int(5) )')) {
            if (@os_db_query_installer('drop table temp')) {
              if ($db_created) {
                if (@os_db_query_installer('drop database ' . $database)) {
                } else {
                  $db_error = mysql_error();
                }
              }
            } else {
              $db_error = mysql_error();
            }
          } else {
            $db_error = mysql_error();
          }
        } else {
          $db_error = mysql_error();
        }
      }
    }

    if ($db_error) {
      return false;
    } else {
      return true;
    }
  }

function os_delete_file($file){ 
	
	$delete= @unlink($file);
	clearstatcache();
	if (@file_exists($file)) {
		$filesys=eregi_replace("/","\\",$file);
		$delete = @system("del $filesys");
		clearstatcache();
		if (@file_exists($file)) {
			$delete = @chmod($file,0775);
			$delete = @unlink($file);
			$delete = @system("del $filesys");
		}
	}
	clearstatcache();
	if (@file_exists($file)) {
		return false;
	}
	else {
	return true;
} // end function
}



  function os_display_banner($action, $identifier) {
    if ($action == 'dynamic') {
      $banners_query = os_db_query("select count(*) as count from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
      $banners = os_db_fetch_array($banners_query);
      if ($banners['count'] > 0) {
        $banner = os_random_select("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
      } else {
        return '<b>ShopOS ERROR! (os_display_banner(' . $action . ', ' . $identifier . ') -> No banners with group \'' . $identifier . '\' found!</b>';
      }
    } elseif ($action == 'static') {
      if (is_array($identifier)) {
        $banner = $identifier;
      } else {
        $banner_query = os_db_query("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . $identifier . "'");
        if (os_db_num_rows($banner_query)) {
          $banner = os_db_fetch_array($banner_query);
        } else {
          return '<b>ShopOS ERROR! (os_display_banner(' . $action . ', ' . $identifier . ') -> Banner with ID \'' . $identifier . '\' not found, or status inactive</b>';
        }
      }
    } else {
      return '<b>ShopOS ERROR! (os_display_banner(' . $action . ', ' . $identifier . ') -> Unknown $action parameter value - it must be either \'dynamic\' or \'static\'</b>';
    }

    if (os_not_null($banner['banners_html_text'])) {
      $banner_string = $banner['banners_html_text'];
    } else {
      $banner_string = '<a href="' . os_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner['banners_id']) . '" onclick="window.open(this.href); return false;">' . os_image(DIR_WS_IMAGES.'banner/' . $banner['banners_image'], $banner['banners_title']) . '</a>';
    }

    os_update_banner_display_count($banner['banners_id']);

    return $banner_string;
  }



  function os_display_tax_value($value, $padding = TAX_DECIMAL_PLACES) {
    if (strpos($value, '.')) {
      $loop = true;
      while ($loop) {
        if (substr($value, -1) == '0') {
          $value = substr($value, 0, -1);
        } else {
          $loop = false;
          if (substr($value, -1) == '.') {
            $value = substr($value, 0, -1);
          }
        }
      }
    }

    if ($padding > 0) {
      if ($decimal_pos = strpos($value, '.')) {
        $decimals = strlen(substr($value, ($decimal_pos+1)));
        for ($i=$decimals; $i<$padding; $i++) {
          $value .= '0';
        }
      } else {
        $value .= '.';
        for ($i=0; $i<$padding; $i++) {
          $value .= '0';
        }
      }
    }

    return $value;
  }


   
function os_draw_box_content_bullet($bullet_text, $bullet_link = '') {
    global $page_file;

    $bullet = '      <tr>' . CR .
              '        <td><table border="0" cellspacing="0" cellpadding="0">' . CR .
              '          <tr>' . CR .
              '            <td width="12" class="boxText"><img src="images/icon_pointer.gif" border="0"></td>' . CR .
              '            <td class="infoboxText">';
    if ($bullet_link) {
      if ($bullet_link == $page_file) {
        $bullet .= '<font color="#0033cc"><b>' . $bullet_text . '</b></font>';
      } else {
        $bullet .= '<a href="' . $bullet_link . '">' . $bullet_text . '</a>';
      }
    } else {
      $bullet .= $bullet_text;
    }

    $bullet .= '</td>' . CR .
               '         </tr>' . CR .
               '       </table></td>' . CR .
               '     </tr>' . CR;

    return $bullet;
  }  
	  

?>