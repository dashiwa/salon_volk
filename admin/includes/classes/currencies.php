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
/*
  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
  (c) 2002-2003 osCommerce(2003/06/02); www.oscommerce.com 
  (c) 2003	 nextcommerce (2003/08/18); www.nextcommerce.org
  (c) 2004	 xt:Commerce (2003/08/18); xt-commerce.com
  (c) 2008	 VamShop (2008/01/01); vamshop.com
*/

defined( '_VALID_OS' ) or die( '������ ������  �� �����������.' );

  class currencies {
  
    var $currencies;
	
    function currencies() 
	{
      $this->currencies = array();
      $currencies_query = os_db_query("select code, title, symbol_left, symbol_right, decimal_point, thousands_point, decimal_places, value from " . TABLE_CURRENCIES);
      while ($currencies = os_db_fetch_array($currencies_query)) {
	    $this->currencies[$currencies['code']] = array('title' => $currencies['title'],
                                                       'symbol_left' => $currencies['symbol_left'],
                                                       'symbol_right' => $currencies['symbol_right'],
                                                       'decimal_point' => $currencies['decimal_point'],
                                                       'thousands_point' => $currencies['thousands_point'],
                                                       'decimal_places' => $currencies['decimal_places'],
                                                       'value' => $currencies['value']);
      }
    }

    function format($number, $calculate_currency_value = true, $currency_type = DEFAULT_CURRENCY, $currency_value = '') {
      if ($calculate_currency_value) {
        $rate = ($currency_value) ? $currency_value : $this->currencies[$currency_type]['value'];
        $format_string = $this->currencies[$currency_type]['symbol_left'] . @number_format($number * $rate, $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . ' ' . $this->currencies[$currency_type]['symbol_right'];
        if ( (DEFAULT_CURRENCY == 'EUR') && ($currency_type == 'DEM' || $currency_type == 'BEF' || $currency_type == 'LUF' || $currency_type == 'ESP' || $currency_type == 'FRF' || $currency_type == 'IEP' || $currency_type == 'ITL' || $currency_type == 'NLG' || $currency_type == 'ATS' || $currency_type == 'PTE' || $currency_type == 'FIM' || $currency_type == 'GRD') ) {
          $format_string .= ' <small>[' . $this->format($number, true, 'EUR') . ']</small>';
        }
      } else {
        $format_string = $this->currencies[$currency_type]['symbol_left'] . number_format($number, $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . ' ' . $this->currencies[$currency_type]['symbol_right'];
      }

      return $format_string;
    }

    function get_value($code) {
      return $this->currencies[$code]['value'];
    }

    function display_price($products_price, $products_tax, $quantity = 1) {
      return $this->format(os_add_tax($products_price, $products_tax) * $quantity);
    }
  }
?>