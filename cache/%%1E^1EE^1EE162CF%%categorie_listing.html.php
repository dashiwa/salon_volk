<?php /* Smarty version 2.6.24, created on 2016-02-02 02:47:04
         compiled from silver/module/categorie_listing/categorie_listing.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/categorie_listing/categorie_listing.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'categorie_listing'), $this);?>

<div class="3mod_news">
<table width="100%" cellpadding="0" cellspacing="4" border=0>
<tr><td class="cat_name str">
<div class="modtit_feat"><?php echo $this->_tpl_vars['CATEGORIES_NAME']; ?>
</div>
</td></tr></table>


<div class="brspace"></div>
<?php if ($this->_tpl_vars['module_content'] != ''): ?>



 <table width="100%" cellpadding="0" cellspacing="0" border="0" >
    <tr>
<?php $_from = $this->_tpl_vars['module_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['module_data']):
        $this->_foreach['aussen']['iteration']++;
?>
  <?php 
  $col++;
   ?>
<td  height="150" class="product_image">



<div class="product_image"><?php if ($this->_tpl_vars['module_data']['CATEGORIES_IMAGE']): ?><a href="<?php echo $this->_tpl_vars['module_data']['CATEGORIES_LINK']; ?>
"><img src="<?php echo $this->_tpl_vars['module_data']['CATEGORIES_IMAGE']; ?>
" alt="<?php echo $this->_tpl_vars['module_data']['CATEGORIES_NAME']; ?>
" /></a><?php endif; ?></div>
 

 <div class="product_name center"><a href="<?php echo $this->_tpl_vars['module_data']['CATEGORIES_LINK']; ?>
"><?php echo $this->_tpl_vars['module_data']['CATEGORIES_NAME']; ?>
</a></div>
   <?php if ($this->_tpl_vars['module_data']['CATEGORIES_DESCRIPTION']): ?><?php endif; ?>
   
   
</td>
</div> 
  <?php 
  if ($col>=3) {
  $col=0;
  echo '</tr><tr>';
  }
   ?>
  <?php endforeach; endif; unset($_from); ?>
    </tr>
  </table>
<br />
<?php if ($this->_tpl_vars['CATEGORIES_DESCRIPTION']): ?>
<div class="mod_space">

  <table width="100%" border="0">
  <tr>
    <td>
	<img  class="imgcat" align="left" src="<?php echo $this->_tpl_vars['CATEGORIES_IMAGE']; ?>
" alt="<?php echo $this->_tpl_vars['CATEGORIES_NAME']; ?>
" /><?php if ($this->_tpl_vars['CATEGORIES_IMAGE']): ?><?php endif; ?>
<?php echo $this->_tpl_vars['CATEGORIES_DESCRIPTION']; ?>
 </td>
    <td>&nbsp;</td>
  </tr>
</table>
</div></div></div>
<?php endif; ?>
<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['MODULE_featured_products']; ?>
