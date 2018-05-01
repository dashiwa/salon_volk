<?php /* Smarty version 2.6.24, created on 2015-06-05 15:11:55
         compiled from silver/module/product_listing/product_listing_columns2.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/product_listing/product_listing_columns2.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'index'), $this);?>

<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'boxes'), $this);?>

<h1 class="cat_name str"><?php echo $this->_tpl_vars['CATEGORIES_NAME']; ?>
</h1>

<?php if ($this->_tpl_vars['MANUFACTURERS_DESCRIPTION']): ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="main" align="left">
	<?php echo $this->_tpl_vars['MANUFACTURERS_DESCRIPTION']; ?>

    </td>
  </tr>
</table>

<?php endif; ?>
<?php if ($this->_tpl_vars['MANUFACTURER_SORT']): ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
  <td class="main" align="left">
	 <div class="info bl">Производитель: <?php echo $this->_tpl_vars['MANUFACTURER_SORT']; ?>
</div>
    </td>
  </tr>
</table>


<?php endif; ?>
<?php if ($this->_tpl_vars['CATEGORIES_NAME']): ?>


<table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
<td >

                                                             <div class="cat-prod-page">
				<form id="prod-soft-menu">
				        <input type="hidden" name="select value" />
				       <select name="sel-pages" size="1" onchange="top.location.href = this.options[this.selectedIndex].value;">
				            <option selected value="#"><?php echo $this->_config[0]['vars']['text_sort']; ?>
</option>
				            <option value="<?php echo $this->_tpl_vars['LINK_sort_name_asc']; ?>
"><?php echo $this->_config[0]['vars']['text_sort_name_asc']; ?>
</option>
				            <option value="<?php echo $this->_tpl_vars['LINK_sort_name_desc']; ?>
"><?php echo $this->_config[0]['vars']['text_sort_name_desc']; ?>
</option>
				            <option value="<?php echo $this->_tpl_vars['LINK_sort_price_asc']; ?>
"><?php echo $this->_config[0]['vars']['text_sort_price_asc']; ?>
</option>
				            <option value="<?php echo $this->_tpl_vars['LINK_sort_price_desc']; ?>
"><?php echo $this->_config[0]['vars']['text_sort_price_desc']; ?>
</option>						
				      </select>
				</form>
		                </div>
</td >
 <td align="right" >
                                                           <div class="cat-prod-page">
				<form id="prod-soft-menu">
				        <input type="hidden" name="select value" />
				       <select name="sel-pages" size="1" onchange="top.location.href = this.options[this.selectedIndex].value;">
				            <option selected value="#"><?php echo $this->_config[0]['vars']['text_products_per_page']; ?>
</option>
				            <option value="<?php echo $this->_tpl_vars['LINK_PAGE']; ?>
10">10</option>
				            <option value="<?php echo $this->_tpl_vars['LINK_PAGE']; ?>
20">20</option>
				            <option value="<?php echo $this->_tpl_vars['LINK_PAGE']; ?>
50">50</option>
				            <option value="<?php echo $this->_tpl_vars['LINK_PAGE']; ?>
100">100</option>						
				      </select>
				</form>
		                </div>
</td >
    </tr>
</table>
<?php endif; ?>
<!--Подбор по параметрам -->
<table width="100%" border="0" cellspacing="0" cellpadding="4" >
  <tr> 
  <td class="main" align="left">
<?php echo $this->_tpl_vars['param_filter']; ?>

 </td>
  </tr>
</table>
<!--/Подбор по параметрам -->
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
<div class="t"><div class="b"><div class="l"><div class="r"><div class="bleft"><div class="br"><div class="tl"><div class="tr">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td class="product_name center" colspan="2" height="40"><a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
"><?php echo $this->_tpl_vars['module_data']['PRODUCTS_NAME']; ?>
</a></td>
  </tr>
  <tr>
    <td height="80" class="product_image">
      <div align="center"></div>
      <p><?php if ($this->_tpl_vars['module_data']['PRODUCTS_IMAGE']): ?><a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
"><img src="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_IMAGE']; ?>
" alt="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_NAME']; ?>
" title="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_NAME']; ?>
" /></a><?php endif; ?></p></td>
    
  </tr>
   <tr>
    <td   height="25">
          <div class="product_price_2"> 
             <div align="center">
                  <?php echo $this->_tpl_vars['module_data']['PRODUCTS_PRICE']; ?>
<?php if ($this->_tpl_vars['module_data']['PRODUCTS_VPE']): ?>
                  <?php echo $this->_tpl_vars['module_data']['PRODUCTS_VPE']; ?>
<?php endif; ?> <?php if ($this->_tpl_vars['module_data']['PRODUCTS_SHIPPING_LINK']): ?>
                  <?php echo $this->_tpl_vars['module_data']['PRODUCTS_SHIPPING_LINK']; ?>
<?php endif; ?>
            </div>    
       </div>
   </div>
   <div align="center"><?php if ($this->_tpl_vars['module_data']['PRODUCTS_TAX_INFO']): ?></div>
   <div class="product_vpe"><?php echo $this->_tpl_vars['module_data']['PRODUCTS_TAX_INFO']; ?>
</div><?php endif; ?>    </td>
  </tr>
</table>
</div>
 </div></div></div></div></div></div></div></div> 

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
<br/>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td align="center" valign="middle">

<div class="clear"></div>
<div class="navigation">
<span class="right"><?php echo $this->_tpl_vars['NAVIGATION']; ?>
</span><?php echo $this->_tpl_vars['NAVIGATION_PAGES']; ?>
</div>
<div class="clear"></div>
</td>
</tr>
</table>

<?php if ($this->_tpl_vars['CATEGORIES_DESCRIPTION']): ?><br /><div class="mod_space">
<?php echo $this->_tpl_vars['CATEGORIES_DESCRIPTION']; ?>
<?php endif; ?><br /><?php if ($this->_tpl_vars['CATEGORIES_IMAGE']): ?>
<br /></div>

<?php endif; ?>