<?php



$box = new osTemplate;
$box->assign('tpl_path', _HTTP_THEMES_C);
$box->assign('language', $_SESSION['language']);


$boxes_userinfo = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_userinfo.html');
$osTemplate->assign('box_userinfo', $boxes_userinfo);

?>