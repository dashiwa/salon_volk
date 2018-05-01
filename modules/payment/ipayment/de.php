<?php
/*
#####################################
#  ShopOS: ������� ��������-��������
#  Copyright (c) 2008-2009
# http://www.shopos.ru
# Ver. 1.0.0
#####################################
*/

define('MODULE_PAYMENT_IPAYMENT_TEXT_TITLE', 'iPayment');
define('MODULE_PAYMENT_IPAYMENT_TEXT_DESCRIPTION', 'Kreditkarten Test Info:<br /><br />CC#: 4111111111111111<br />G&uuml;ltig bis: Any');
define('MODULE_PAYMENT_IPAYMENT_TEXT_INFO', '');
define('IPAYMENT_ERROR_HEADING', 'Folgender Fehler wurde von iPayment w&auml;hrend des Prozesses gemeldet:');
define('IPAYMENT_ERROR_MESSAGE', 'Bitte kontrollieren Sie die Daten Ihrer Kreditkarte!');
define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_OWNER', 'Kreditkarteninhaber');
define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_NUMBER', 'Kreditkarten-Nr.:');
define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_EXPIRES', 'G&uuml;ltig bis:');
define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER', 'Karten-Pr&uuml;fnummer');
define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(Auf der Kartenr&uuml;ckseite im Unterschriftsfeld)');

define('MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_OWNER', '* Der Name des Kreditkarteninhabers mss mindestens aus  ' . CC_OWNER_MIN_LENGTH . ' Zeichen bestehen.\n');
define('MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_NUMBER', '* Die \'Kreditkarten-Nr.\' muss mindestens aus ' . CC_NUMBER_MIN_LENGTH . ' Zahlen bestehen.\n');

define('MODULE_PAYMENT_IPAYMENT_ID_TITLE', 'Kundennummer');
define('MODULE_PAYMENT_IPAYMENT_ID_DESC', 'Kundennummer, welche f&uuml;r iPayment verwendet wird');
define('MODULE_PAYMENT_IPAYMENT_STATUS_TITLE', 'iPayment Modul aktivieren');
define('MODULE_PAYMENT_IPAYMENT_STATUS_DESC', 'M&ouml;chten Sie Zahlungen per iPayment akzeptieren?');
define('MODULE_PAYMENT_IPAYMENT_PASSWORD_TITLE', 'Benutzer-Passwort');
define('MODULE_PAYMENT_IPAYMENT_PASSWORD_DESC', 'Benutzer-Passwort welches f&uuml;r iPayment verwendet wird');
define('MODULE_PAYMENT_IPAYMENT_USER_ID_TITLE', 'Benutzer ID');
define('MODULE_PAYMENT_IPAYMENT_USER_ID_DESC', 'Benutzer ID welche f&uuml;r iPayment verwendet wird');
define('MODULE_PAYMENT_IPAYMENT_CURRENCY_TITLE', 'Transaktionsw&auml;hrung');
define('MODULE_PAYMENT_IPAYMENT_CURRENCY_DESC', 'W&auml;hrung, welche f&uuml;r Kreditkartentransaktionen verwendet wird');

define('MODULE_PAYMENT_IPAYMENT_COST_TITLE', _MODULES_PAYMENT_FEE_TITLE);
define('MODULE_PAYMENT_IPAYMENT_COST_DESC', _MODULES_PAYMENT_FEE_DESC);
define('MODULE_PAYMENT_IPAYMENT_ZONE_TITLE', _MODULES_ZONE_TITLE);
define('MODULE_PAYMENT_IPAYMENT_ZONE_DESC', _MODULES_ZONE_DESC);
define('MODULE_PAYMENT_IPAYMENT_ALLOWED_TITLE', _MODULES_ZONE_ALLOWED_TITLE);
define('MODULE_PAYMENT_IPAYMENT_ALLOWED_DESC', _MODULES_ZONE_ALLOWED_DESC);
define('MODULE_PAYMENT_IPAYMENT_SORT_ORDER_TITLE', _MODULES_SORT_ORDER_TITLE);
define('MODULE_PAYMENT_IPAYMENT_SORT_ORDER_DESC', _MODULES_SORT_ORDER_DESC);
define('MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID_TITLE', _MODULES_SET_ORDER_STATUS_TITLE);
define('MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID_DESC', _MODULES_SET_ORDER_STATUS_DESC);
?>