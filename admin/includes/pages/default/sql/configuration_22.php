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

defined( '_VALID_OS' ) or die( '������ ������  �� �����������.' );

$db->query("DELETE FROM ".DB_PREFIX."configuration WHERE configuration_group_id=22");

#configuration_group_id 22, Search Options
$db->query("INSERT INTO ".DB_PREFIX."configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SEARCH_IN_DESC', 'true', '22', '2', NULL, '0000-00-00 00:00:00', NULL, 'os_cfg_select_option(array(\'true\', \'false\'),');");
$db->query("INSERT INTO ".DB_PREFIX."configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SEARCH_IN_ATTR', 'true', '22', '3', NULL, '0000-00-00 00:00:00', NULL, 'os_cfg_select_option(array(\'true\', \'false\'),');");

?>