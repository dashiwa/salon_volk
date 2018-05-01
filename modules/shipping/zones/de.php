<?php
/*
#####################################
#  ShopOS: Скрипты интернет-магазина
#  Copyright (c) 2008-2009
# http://www.shopos.ru
# Ver. 1.0.0
#####################################
*/

define('NUMBER_OF_ZONES',10);

define('MODULE_SHIPPING_ZONES_TEXT_TITLE', 'Versandkosten nach Zonen');
define('MODULE_SHIPPING_ZONES_TEXT_DESCRIPTION', 'Versandkosten Zonenbasierend');
define('MODULE_SHIPPING_ZONES_TEXT_WAY', 'Versand nach:');
define('MODULE_SHIPPING_ZONES_TEXT_UNITS', 'kg');

define('MODULE_SHIPPING_ZONES_STATUS_TITLE' , 'Versandkosten nach Zonen Methode aktivieren');
define('MODULE_SHIPPING_ZONES_STATUS_DESC' , 'M&ouml;chten Sie Versandkosten nach Zonen anbieten?');


for ($ii=0;$ii<NUMBER_OF_ZONES;$ii++) {
define('MODULE_SHIPPING_ZONES_COUNTRIES_'.$ii.'_TITLE' , 'Zone '.$ii.' L&auml;nder');
define('MODULE_SHIPPING_ZONES_COUNTRIES_'.$ii.'_DESC' , 'Durch Komma getrennte Liste von ISO L&auml;ndercodes (2 Zeichen), welche Teil von Zone '.$ii.' sind.');
define('MODULE_SHIPPING_ZONES_COST_'.$ii.'_TITLE' , 'Zone '.$ii.' Versandkosten');
define('MODULE_SHIPPING_ZONES_COST_'.$ii.'_DESC' , 'Versandkosten nach Zone '.$ii.' Bestimmungsorte, basierend auf einer Gruppe von max. Bestellgewichten. Beispiel: 3:8.50,7:10.50,... Gewicht von kleiner oder gleich 3 w&uuml;rde 8.50 fьr die Zone '.$ii.' Bestimmungsl&auml;nder kosten.');
define('MODULE_SHIPPING_ZONES_HANDLING_'.$ii.'_TITLE' , 'Zone '.$ii.' Handling Geb&uuml;hr');
define('MODULE_SHIPPING_ZONES_HANDLING_'.$ii.'_DESC' , 'Handling Geb&uuml;hr fьr diese Versandzone');
}

define('MODULE_SHIPPING_ZONES_TAX_CLASS_TITLE' , _MODULES_TAX_ZONE_TITLE);
define('MODULE_SHIPPING_ZONES_TAX_CLASS_DESC' ,_MODULES_TAX_ZONE_DESC);
define('MODULE_SHIPPING_ZONES_ZONE_TITLE' , _MODULES_ZONE_TITLE);
define('MODULE_SHIPPING_ZONES_ZONE_DESC' , _MODULES_ZONE_DESC);
define('MODULE_SHIPPING_ZONES_SORT_ORDER_TITLE' , _MODULES_SORT_ORDER_TITLE);
define('MODULE_SHIPPING_ZONES_SORT_ORDER_DESC' , _MODULES_SORT_ORDER_DESC);
define('MODULE_SHIPPING_ZONES_ALLOWED_TITLE' , _MODULES_ZONE_ALLOWED_TITLE);
define('MODULE_SHIPPING_ZONES_ALLOWED_DESC' , _MODULES_ZONE_ALLOWED_DESC);
define('MODULE_SHIPPING_ZONES_INVALID_ZONE', _MODULE_INVALID_SHIPPING_ZONE);
define('MODULE_SHIPPING_ZONES_UNDEFINED_RATE', _MODULE_UNDEFINED_SHIPPING_RATE);
?>
