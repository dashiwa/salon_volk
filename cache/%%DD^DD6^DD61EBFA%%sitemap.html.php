<?php /* Smarty version 2.6.24, created on 2017-01-13 15:44:37
         compiled from silver/module/sitemap.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/sitemap.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'sitemap'), $this);?>

<table width="100%" cellspacing="0" cellpadding="3" border="0">
<tr>
<?php $i=0; ?>
<?php $_from = $this->_tpl_vars['module_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['module_data']):
        $this->_foreach['aussen']['iteration']++;
?>
<?php $i++; ?>
<td valign="top">
  <table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
  	<th class="sitemap_heading"><a href="<?php echo $this->_tpl_vars['module_data']['CAT_LINK']; ?>
"><?php echo $this->_tpl_vars['module_data']['CAT_NAME']; ?>
</a></th>
  </tr>
  <tr>
  	<td><table width="100%" cellspacing="0" cellpadding="0" border="0">
			<?php $_from = $this->_tpl_vars['module_data']['SCATS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key_data'] => $this->_tpl_vars['item_data']):
?>
	<tr>
		<td class="sitemap_sub"><a href="<?php echo $this->_tpl_vars['item_data']['link']; ?>
"><?php echo $this->_tpl_vars['item_data']['text']; ?>
</a></td>
	</tr><?php endforeach; else: ?>
	<tr>
		<td class="sitemap_sub"><?php echo $this->_config[0]['vars']['no_subcategories']; ?>
</td>
	</tr>			 
    <?php endif; unset($_from); ?>    
    </table></td>
  </tr>
</table></td>
<?php if ($i==3){ echo "</tr><tr>"; $i=0; } ?>  
<?php endforeach; endif; unset($_from); ?>
</tr>
</table>