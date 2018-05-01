/*
#####################################
#  ShopOS: Скрипты интернет-магазина
 #  Copyright (c) 2008-2009              
 #  http://www.shopos.ru                 
 # Ver. 1.0.0
#####################################
*/

function selectFile(msgNoFileSelected)
{
	var selectedFileRowNum = $('#selectedFileRowNum').val();
  if(selectedFileRowNum != '' && $('#row' + selectedFileRowNum))
  {

	  // insert information now
	  var url = $('#fileUrl'+selectedFileRowNum).val();  	
		window.opener.SetUrl( url ) ;
		window.close() ;
		
  }else
  {
  	alert(msgNoFileSelected);
  }
  

}



function cancelSelectFile()
{
  // close popup window
  window.close() ;
}