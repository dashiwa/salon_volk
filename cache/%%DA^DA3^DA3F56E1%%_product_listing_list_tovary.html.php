<?php /* Smarty version 2.6.24, created on 2015-06-03 11:42:17
         compiled from silver/module/product_listing/_product_listing_list_tovary.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/product_listing/_product_listing_list_tovary.html', 1, false),array('modifier', 'os_truncate', 'silver/module/product_listing/_product_listing_list_tovary.html', 93, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'index'), $this);?>

<div class="t"><div class="b"><div class="l"><div class="r"><div class="bleft"><div class="br"><div class="tl"><div class="tr"> 
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="border">
<tr><td class="cat_name str">
<div class="h1"><?php echo $this->_tpl_vars['CATEGORIES_NAME']; ?>
</div>
</td>
</tr></table>
<br />
<!--Подбор по параметрам -->
<table width="100%" border="0" cellspacing="0" cellpadding="4" >
  <tr> 
  <td class="main" align="left"><?php echo $this->_tpl_vars['param_filter']; ?>
</td>
  </tr>
</table>
<!--/Подбор по параметрам -->

<?php if ($this->_tpl_vars['MANUFACTURERS_DESCRIPTION']): ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="main" align="left">
	<div class="cat-sort-prod-menu"><div class="cat-page"><?php echo $this->_tpl_vars['MANUFACTURERS_DESCRIPTION']; ?>
</div> </div> 
    </td>
  </tr>
</table>

<?php endif; ?>
<?php if ($this->_tpl_vars['MANUFACTURER_SORT']): ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
  <td class="main" align="left">
	 <div class="info"><?php echo $this->_tpl_vars['MANUFACTURER_SORT']; ?>
</div>
    </td>
  </tr>
</table>


<?php endif; ?>
<?php if ($this->_tpl_vars['CATEGORIES_NAME']): ?>


<table width="100%" cellpadding="5" cellspacing="0" border="0">
    <tr>
<td >
 <!-- Сортировка --> 
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
 <!--/Сортировка -->
 <td align="right" ><?php echo $this->_tpl_vars['NAVIGATION_PAGES']; ?>
 </td >
    </tr>
</table>
<?php endif; ?>
 <div class="hr"></div>   
<table width="100%" border="0"  cellspacing="0" cellpadding="4" >
  <tr> 

          <?php $_from = $this->_tpl_vars['module_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['module_data']):
        $this->_foreach['aussen']['iteration']++;
?> 
  <?php  $col++; 
   ?>
    <td class="main" valign="top">
 <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr class="contentBoxContents1" valign="top">
    <td height="90" class="contentBoxContents1" valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" border=0><tr>
        <td valign="top"> 
  <!-- Фото 120х90 -->
		<div class="prod-img"><div class="product_name">
        <?php if ($this->_tpl_vars['module_data']['PRODUCTS_IMAGE']): ?><a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
"><img src="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_IMAGE']; ?>
" alt="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_NAME']; ?>
" title="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_NAME']; ?>
" /></a><?php endif; ?><?php if ($this->_tpl_vars['module_data']['PRODUCTS_FSK18'] == 'true'): ?><br /><img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
img/fsk18.gif" alt="" /><?php endif; ?>
             </div>
  <!--/ Фото 120х90 -->
		
		</td>                                                  
    <td width="100%" valign="top">     
  
  <!--Название товара -->
	<div class="product_name">
 <a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
"><?php echo $this->_tpl_vars['module_data']['PRODUCTS_NAME']; ?>
</a>
    </div>
  <!--/Название товара -->
  
  <!--Краткое описание -->
     <?php if ($this->_tpl_vars['module_data']['PRODUCTS_SHORT_DESCRIPTION']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['module_data']['PRODUCTS_SHORT_DESCRIPTION'])) ? $this->_run_mod_handler('os_truncate', true, $_tmp, 300) : smarty_modifier_os_truncate($_tmp, 300)); ?>
<br />     
     <?php endif; ?>
  <!--/Краткое описание -->
      <br />
  

  <!--Описание Где купить Отзывы -->         
                          <table width="260" border="0" cellpadding="3" cellspacing="0">
                            <tr valign="middle">
                              <td class="main" align="center"><a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
">Описание</a> |</td>
                              <td class="main" align="center"><?php if ($this->_tpl_vars['module_data']['PRODUCTS_ID'] > 0): ?><a href="index.php?main_page=seller_offers_page&products_id=<?php echo $this->_tpl_vars['module_data']['PRODUCTS_ID']; ?>
">Где купить (<?php echo $this->_tpl_vars['module_data']['PRODUCTS_PRICE_COUNT_P']; ?>
)</a><?php else: ?>нет<?php endif; ?> |</td>
                              <td class="main" align="center"><a href="reviews.php?products_id=<?php echo $this->_tpl_vars['module_data']['PRODUCTS_ID']; ?>
">Отзывы (<?php echo $this->_tpl_vars['module_data']['reviews_count']; ?>
)</a></td>
                            </tr>
                          </table>

 <!--/Описание Где купить Отзывы --> 
  
     </td>
   
	<td class="o-s"> <table width="120" border="0">
<tbody>
<tr>
<td>
                  
    <?php if ($this->_tpl_vars['module_data']['PRODUCTS_PRICE_COUNT_P'] > 0): ?>
                                           <?php if ($this->_tpl_vars['module_data']['PRODUCTS_PRICE_S_P'] != 0): ?>
										 
                                        средняя цена <br />
                                        <div class="product_price_2">
                                            <div align="center"><div class="product_price_2"><strong><?php echo $this->_tpl_vars['module_data']['PRODUCTS_PRICE_S']; ?>
</strong></div></div>
                                        </div>
                                         (<?php echo $this->_tpl_vars['module_data']['PRODUCTS_PRICE_COUNT']; ?>
)
										    <?php else: ?>
											  Цены <br/>не указаны <br/>
                                    
                                         (<?php echo $this->_tpl_vars['module_data']['PRODUCTS_PRICE_COUNT']; ?>
)
										<?php endif; ?>
                                        <?php else: ?>
                                        Нет<br/> продавцов<br/>
										<?php if ($this->_tpl_vars['module_data']['PRODUCTS_PRICE_COUNT_ALL'] > 0): ?>
										<a href="index.php?main_page=seller_offers_page&products_id=<?php echo $this->_tpl_vars['module_data']['PRODUCTS_ID']; ?>
&find=all">Найти в других<br> регионах</a>
										<?php endif; ?>
                                        <?php endif; ?>
										<br />
										<?php if ($this->_tpl_vars['module_data']['PRODUCTS_PRICE_COUNT_ALL'] > 0): ?>
                                        <!--Кнопка Выбрать продавца -->
                                        <a class="offers" rel="nofollow" href="index.php?main_page=seller_offers_page&products_id=<?php echo $this->_tpl_vars['module_data']['PRODUCTS_ID']; ?>
">
                                            <img height="19" width="108" vspace="5"  src="/themes/silver/img/price.png">
                                        </a>
                                        <!--/Кнопка Выбрать продавца -->
										<?php endif; ?>

</td>
</tr>
   <tr>
  
</tbody>
</table>
  </td>
	 </tr>
    </table>
   
</td>


  </tr>
</table>    
<div class="hr"></div>    
 
</td>
  <?php  
  if ($col>=1) {
  $col=0;
  echo '</tr><tr>';
  }
   ?>
  <?php endforeach; endif; unset($_from); ?>  

  </tr>
  
<tr>
<td >
<table width="100%" cellpadding="0" cellspacing="0" border="0" >
    <tr>
<td >
 <!--Товаров на странице -->
 <div class="cat-page">
 Товаров на странице: <a href="<?php echo $this->_tpl_vars['LINK_PAGE']; ?>
10"> 10</a>, <a href="<?php echo $this->_tpl_vars['LINK_PAGE']; ?>
20"> 20</a>, <a href="<?php echo $this->_tpl_vars['LINK_PAGE']; ?>
50"> 50</a>, <a href="<?php echo $this->_tpl_vars['LINK_PAGE']; ?>
100"> 100 </a> 
 </div> 
<!--/Товаров на странице --> 

 <td align="right">
<!--/Навигация по страницам -->  
 <div class="cat-page">
 <span class="s14"><?php echo $this->_tpl_vars['NAVIGATION']; ?>
 
 </div>
 <!--/Навигация по страницам -->
 </td >
  
    </tr>
</table>

</td>
</tr>
</table>
</div></div></div></div></div></div></div></div> 
<?php if ($this->_tpl_vars['CATEGORIES_DESCRIPTION']): ?><br /><div class="mod_space">
<?php echo $this->_tpl_vars['CATEGORIES_DESCRIPTION']; ?>
<?php endif; ?><br /><?php if ($this->_tpl_vars['CATEGORIES_IMAGE']): ?>
<br /></div>

<?php endif; ?>