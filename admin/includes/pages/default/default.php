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

  $dir = dirname(__FILE__);
  
  $_file_name = $_GET['name'];
  $_file_name = os_check_file_name($_file_name); /* ������� ������ ������� �� ����� �����*/
  $_file_name = str_replace('/','',$_file_name);
  $_file_name = $dir.'/'.'sql/'. $_file_name.'_'.os_check_file_name($_GET['param']).'.php';
  
  if (is_file($_file_name)) include($_file_name);

  header('Location: '.os_check_file_name($_GET['name']).'.php?gID='.os_check_file_name($_GET['param']));
?>