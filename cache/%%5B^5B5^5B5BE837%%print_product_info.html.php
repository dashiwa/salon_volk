<?php /* Smarty version 2.6.24, created on 2016-02-02 09:11:43
         compiled from silver/module/print_product_info.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/print_product_info.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'print_product_info'), $this);?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->_tpl_vars['PRODUCTS_NAME']; ?>
 / <?php echo $this->_tpl_vars['PRODUCTS_MODEL']; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['charset']; ?>
" />
</head>

<body leftmargin="0" topmargin="0" onload="window.print()">

<!-- head -->
<table border="0" width="640" cellpadding="10" cellspacing="0" bgcolor="#ffffff">
<tr>
	<td>
	<p><strong><font color="#999999" size="4" face="Arial, Helvetica, sans-serif"><?php echo $this->_tpl_vars['PRODUCTS_NAME']; ?>
</font></strong><br />
	<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_tpl_vars['PRODUCTS_MODEL']; ?>
</font></p>
	</td>
</tr>
</table>	
<!-- head eof -->

<table width="640" border="0">
<tr>
<td width="1" valign="top">

<!-- pics -->
<table width="1" border="0" cellpadding="5">
 <tr>
  <td style="border-right: 1px solid; border-color: #cccccc" width="1" align="left" valign="top">
  		<?php if ($this->_tpl_vars['PRODUCTS_IMAGE'] != ''): ?><img src="<?php echo $this->_tpl_vars['PRODUCTS_IMAGE']; ?>
" alt="<?php echo $this->_tpl_vars['module_data']['NAME']; ?>
" border="0" /><?php endif; ?>
  </td>
 </tr>
</table></td>
<!-- more images -->
<?php if ($this->_tpl_vars['PRODUCTS_MO_IMAGES']): ?>
<table width="100%" border="0">
<?php $_from = $this->_tpl_vars['mo_img']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['mo_pic'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['mo_pic']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['img_values']):
        $this->_foreach['mo_pic']['iteration']++;
?>
 <tr>
  <td style="border-right: 1px solid; border-color: #cccccc" width="1" align="left" valign="top"><img src="<?php echo $this->_tpl_vars['img_values']['PRODUCTS_MO_IMAGE']; ?>
" alt="<?php echo $this->_tpl_vars['img_values']['PRODUCTS_MO_IMAGE']; ?>
" border="0" /></td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<br />
<?php endif; ?>
<!-- more images eof -->
<!-- pics eof -->

<!-- desc -->
<td valign="top">

<table width="100%" border="0"  >
  <tr>
  <td align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_tpl_vars['PRODUCTS_DESCRIPTION']; ?>
<br />
   
    
        </font></td>
  </tr>
</table>

</td></tr></table>


</body>
</html>