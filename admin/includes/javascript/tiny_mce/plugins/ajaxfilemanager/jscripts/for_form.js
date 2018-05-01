/*
#####################################
#  ShopOS: Скрипты интернет-магазина
 #  Copyright (c) 2008-2009              
 #  http://www.shopos.ru                 
 # Ver. 1.0.0
#####################################
*/

function selectFile(url)
{
      window.opener.document.getElementById(elementId).value = url;
      window.close() ;
 

}



function cancelSelectFile()
{
  // close popup window
  window.close() ;
}

