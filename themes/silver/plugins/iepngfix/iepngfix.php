<?php


defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

add_action('head', 'iepngfix');
add_action('page', 'iepngfix_page');

function iepngfix()
{
  _e('<!--[if lte IE 6]><script type="text/javascript" src="'.plugurl().'iepngfix_tilebg.js"></script>');
  _e('<style type="text/css"> img { behavior: url("'.plugurl().'iepngfix.htc")}</style>');
  _e('<![endif]-->');
}

?>