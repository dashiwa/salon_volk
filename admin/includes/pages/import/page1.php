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

defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

?>
<form enctype="multipart/form-data" action="import.php?page=2" method="POST">
<table cellpadding="0" cellspacing="0" width="98%" style="height: 98%; width: 98%;">
	<tr>
		<td id="content">

	<table cellpadding=3>
		<tr>
			<td><?php echo IMPORT_TEXT1; ?></td>
			<td><input type="file" name="csv"   style="width:250px"/></td>
		</tr>
		<tr>
			<td>
			Выбрать загруженный файл:
			</td>
			<td>
				<select name="downloaded_file_name" style="width:250px">
				<option value="" selected></option>
				<?php
				
				 $_file_array = os_getFiles( _IMPORT, array('.csv', '.txt', '.xls', '.xml') ) ;
				 
				 if ( !empty($_file_array) ) 
				 {
				    foreach ($_file_array as $_file_info)
					{
					   echo '<option value="'. $_file_info['id'] .'">'. $_file_info['id'] .' ('. os_format_filesize( filesize(_IMPORT.$_file_info['id']) ) .')</option>';
					}
				 
				 }
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
			Разделитель в импортируемом CSV файле:
			</td>
			<td>
			
				<select name="delimeter">
					<option value="tab"><?php echo IMPORT_TAB; ?></option>
				<!--	<option value=";">Точка с запятой (;)</option>--->
				</select>
			</td>
		</tr>
				<tr>
		<!---	<td>type:</td>
			<td>
			
				<select name="sub">
					<option value="excel_import">csv</option>
				</select>
			</td>--->
		</tr>
		<tr>
			<td><?php echo IMPORT_ENCODING; ?></td>
			<td>
				<select name="charset"><option value="cp1251" selected="selected">cp1251</option><option value="utf-8" >utf-8</option></select>
			</td>
		</tr>
		</table>

		<p>
		<input type=hidden name=proceed value=1>
		<input type=hidden name=dpt value="catalog">
		<input type=submit value="OK">

		</form>


					</td>
	</tr>
</table>