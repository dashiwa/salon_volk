<?php /* Smarty version 2.6.24, created on 2017-01-13 12:44:39
         compiled from silver/module/product_listing/product_columns3.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/product_listing/product_columns3.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'index'), $this);?>

<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'boxes'), $this);?>

<p><h1 class="cat_name str"><?php echo $this->_tpl_vars['CATEGORIES_NAME']; ?>
</h1>
</p>
<?php if ($this->_tpl_vars['CATEGORIES_NAME']): ?>

<?php endif; ?>
  <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
  <?php $_from = $this->_tpl_vars['module_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['module_data']):
        $this->_foreach['aussen']['iteration']++;
?>
  <?php  $col++;
   ?>
<td class="mod_cel5">
 

<table width="100%" cellpadding="0" cellspacing="0" border="0">
  
  <tr>
    <td height="220" class="product_image">
      <div align="center"></div>
      <?php if ($this->_tpl_vars['module_data']['PRODUCTS_IMAGE']): ?><a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
"><img src="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_IMAGE']; ?>
" alt="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_NAME']; ?>
" title="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_NAME']; ?>
" /></a><?php endif; ?></td>
    
  </tr>
   <tr>
    <td class="product_name center" colspan="2" height="40"><a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
"><?php echo $this->_tpl_vars['module_data']['PRODUCTS_NAME']; ?>
</a></td>
  </tr>
</table>
</div>
 


</td>
  <?php 
  if ($col>=3) {
  $col=0;
  echo '</tr><tr>';
  }
   ?>
  <?php endforeach; endif; unset($_from); ?>
    </tr>
  </table>
<?php if ($this->_tpl_vars['CATEGORIES_DESCRIPTION']): ?>
<div class="mod_space">

  <table width="100%" border="0">
  <tr>
    <td><?php if ($this->_tpl_vars['CATEGORIES_IMAGE']): ?><?php endif; ?>
<?php echo $this->_tpl_vars['CATEGORIES_DESCRIPTION']; ?>
 </td>
    <td>&nbsp;</td>
  </tr>
</table>
</div></div></div>
<?php endif; ?>

