<?php
   add_action('main_page_admin', 'seller_import_page1');
   add_action('main_page_admin', 'seller_import_page2');
   
   function seller_import_page1()
   {
       include('import.page1.php');
   }
   
   function seller_import_page2()
   {
       include('import.page2.php');
   }
   
   function seller_import_install()
   {
       add_option('seller_import', '', 'readonly');
   }
   
   function seller_import_readonly()
   {
       _e('<center><a href="'.main_page_admin('seller_import_page1').'">Импорт</a></center>'); 
   }
?>