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

if (is_file(dirname(__FILE__).'/'.$_SESSION['language'].'.php'))
{
   require (dirname(__FILE__).'/'.$_SESSION['language'].'.php');
}
else
{
   die('no file. '.dirname(__FILE__).'/'.$_SESSION['language'].'.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>" /> 
<meta http-equiv="Content-Style-Type" content="text/css" />
<script type="text/javascript">
<!-- 
  document.oncontextmenu = function(){return false}
  if(document.layers)
    {
      window.captureEvents(Event.MOUSEDOWN);
      window.onmousedown = function(e){if(e.target==document)return false;}
    }
  else 
    {
      document.onmousedown = function(){return false}
    }

  var i=0;

function resize() 
 {
   if (navigator.appName == 'Netscape') i=40;
   window.resizeTo(480, 460-i);
   self.focus();
 }

//-->
</script>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo 'themes/'.CURRENT_TEMPLATE.'/style.css'; ?>" />
</head>
<body onload="resize();">

<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="pagecontent">
<p>
<span class="bold"><?php echo $content_data['content_heading']; ?></span>
</p>
<p>
<?php echo HEADING_CVV; ?>
</p>
<p>
<?php echo TEXT_CVV; ?>
</p>
</div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
<div class="pagecontentfooter">
<a href="javascript:window.close()"><?php echo TEXT_CLOSE_WINDOW; ?></a>
</div>
</div>
</body>
</html>