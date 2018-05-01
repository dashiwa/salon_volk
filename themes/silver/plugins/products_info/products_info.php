<?php


add_action('products_info', 'products_info_tpl');


function products_info_tpl()
{
   $tpl=  '';
   
   $tpl .= "<style> @import url('". plugurl()."demo/css/ui-lightness/jquery-ui-1.8.2.custom.css'); </style>"."\n";
   $tpl .= '<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="'. plugurl().'demo/js/jquery-ui-1.8.2.custom.min.js"></script>
<script type=\'text/javascript\'>
	$(function() {
		$(\'#tabs\').tabs();
	});
	</script>	';   
	
	$tpl .='		<!-- Tabs -->
		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Описание</a></li>
				<li><a href="#tabs-2">Фото</a></li>
				<li><a href="#tabs-3">Отзывы</a></li>
			</ul>
			<div id="tabs-1"> {$MODULE_featured_products} </div>
			<div id="tabs-2">Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum.</div>
			<div id="tabs-3">Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.</div>
		</div><!-- Tabs -->';
   
   return array('name' => 'tabber', 'value' => $tpl);
}


?>