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

$_GET['no_box'] = 'true';
require ('includes/top.php');
?>

<body bgcolor="#FFFFFF">
<table align="center">
<tr>
<?php

$mo_images = os_get_products_mo_images((int) $_GET['pID']);
if ((int) $_GET['imgID'] == 0)
	$actual = ' bgcolor="#FF0000"';
else
	unset ($actual);
echo '<td align="left"'.$actual.'>';
$products_query = os_db_query("select pd.products_name, p.products_image from ".TABLE_PRODUCTS." p left join ".TABLE_PRODUCTS_DESCRIPTION." pd on p.products_id = pd.products_id where p.products_status = '1' and p.products_id = '".(int) $_GET['pID']."' and pd.language_id = '".(int) $_SESSION['languages_id']."'");
$products_values = os_db_fetch_array($products_query);
echo '<a href="popup_image.php?pID='.(int) $_GET['pID'].'&imgID=0" target="_parent">'.os_image(http_path('images_thumbnail').$products_values['products_image'], $products_values['products_name']).'</a>';
echo '</td>';
if ($mo_images != false) {
	foreach ($mo_images as $mo_img) {
		if ($mo_img['image_nr'] == (int) $_GET['imgID'])
			$actual = ' bgcolor="#FF0000"';
		else
			unset ($actual);
		echo '<td align=left'.$actual.'><a href="popup_image.php?pID='.(int) $_GET['pID'].'&imgID='.$mo_img['image_nr'].'" target="_parent">'.os_image(http_path('images_thumbnail').$mo_img['image_name'], $products_values['products_name']).'</a></td>';
	}
}
?>
</tr>
</table>
</body>