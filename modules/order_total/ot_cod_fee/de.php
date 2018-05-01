<?php
/*
#####################################
#  ShopOS: ������� ��������-��������
#  Copyright (c) 2008-2009
# http://www.shopos.ru
# Ver. 1.0.0
#####################################
*/

  define('MODULE_ORDER_TOTAL_COD_FEE_TITLE', 'Nachnahmegeb&uuml;hr');
  define('MODULE_ORDER_TOTAL_COD_FEE_DESCRIPTION', 'Berechnung der Nachnahmegeb&uuml;hr');

  define('MODULE_ORDER_TOTAL_COD_FEE_STATUS_TITLE','Nachnahmegeb&uuml;hr');
  define('MODULE_ORDER_TOTAL_COD_FEE_STATUS_DESC','Berechnung der Nachnahmegeb&uuml;hr');

  define('MODULE_ORDER_TOTAL_COD_FEE_SORT_ORDER_TITLE','Sortierreihenfolge');
  define('MODULE_ORDER_TOTAL_COD_FEE_SORT_ORDER_DESC','Anzeigereihenfolge');

  define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_TITLE','Pauschale Versandkosten');
  define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_TITLE','Versandkosten pro St&uuml;ck');
  define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_TITLE','Tabellarische Versandkosten');
  define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_TITLE','Versandkosten nach Zonen');
  define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_AP_TITLE','&Ouml;sterreichische Post AG');
  define('MODULE_ORDER_TOTAL_COD_FEE_AP_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn 
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn 
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet 
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_CHP_TITLE','Schweizerische Post');
  define('MODULE_ORDER_TOTAL_COD_FEE_CHP_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_CHRONOPOST_TITLE','Chronopost Zone Rates');
  define('MODULE_ORDER_TOTAL_COD_FEE_CHRONOPOST_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_DHL_TITLE','DHL &Ouml;sterreich');
  define('MODULE_ORDER_TOTAL_COD_FEE_DHL_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');

  define('MODULE_ORDER_TOTAL_COD_FEE_DP_TITLE','Deutsche Post AG');
  define('MODULE_ORDER_TOTAL_COD_FEE_DP_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');
  
  define('MODULE_ORDER_TOTAL_COD_FEE_UPS_TITLE','UPS');
  define('MODULE_ORDER_TOTAL_COD_FEE_UPS_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');
  
  define('MODULE_ORDER_TOTAL_COD_FEE_UPSE_TITLE','UPS Express');
  define('MODULE_ORDER_TOTAL_COD_FEE_UPSE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');
  

  define('MODULE_ORDER_TOTAL_COD_FEE_FREE_TITLE','Versandkostenfrei (Modul Versandkosten in Zusammenfassung)');
  define('MODULE_ORDER_TOTAL_COD_FEE_FREE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');
  
  define('MODULE_ORDER_TOTAL_FREEAMOUNT_FREE_TITLE','Versandkostenfrei (Modul Versankosten in Versandkosten)');
  define('MODULE_ORDER_TOTAL_FREEAMOUNT_FREE_DESC','&lt;ISO2-Code&gt;:&lt;Preis&gt;, ....<br />
  00 als ISO2-Code erm&ouml;glicht den Nachnahmeversand in alle L&auml;nder. Wenn
  00 verwendet wird, muss dieses als letztes Argument eingetragen werden. Wenn
  kein 00:9.99 eingetragen ist, wird der Nachnahmeversand ins Ausland nicht berechnet
  (nicht m&ouml;glich).');  

  define('MODULE_ORDER_TOTAL_COD_FEE_TAX_CLASS_TITLE','Steuerklasse');
  define('MODULE_ORDER_TOTAL_COD_FEE_TAX_CLASS_DESC','W&auml;hlen Sie eine Steuerklasse.');
?>