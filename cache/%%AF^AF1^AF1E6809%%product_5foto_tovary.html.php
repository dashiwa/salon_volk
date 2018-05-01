<?php /* Smarty version 2.6.24, created on 2016-02-02 09:08:10
         compiled from silver/module/product_info/product_5foto_tovary.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/product_info/product_5foto_tovary.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'product_info'), $this);?>

<script type="text/javascript" src="themes/silver/javascript/tab.js"></script>
<script type="text/javascript" src="themes/grin/javascript/highslide/highslide-with-gallery.js"></script>
<script type="text/javascript" src="themes/grin/javascript/highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="themes/grin/javascript/highslide/highslide.css" />
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="themes/grin/javascript/highslide/highslide-ie6.css" />
<![endif]-->
<?php echo $this->_tpl_vars['FORM_ACTION']; ?>

<div class="mod_news"><div class="t"><div class="b"><div class="l"><div class="r"><div class="bleft"><div class="br"><div class="tl"><div class="tr"> 
   <table width="100%" cellpadding="5" cellspacing="0" border="0">
        <tr><td>
                <!-- Название товара -->
                <div class="cat_name"><?php echo $this->_tpl_vars['PRODUCTS_NAME']; ?>
</div>
                <!--/Название товара -->
            <td align="right">
                <!-- Навигатор -->
               <?php echo $this->_tpl_vars['PRODUCT_NAVIGATOR']; ?>

                <!--/Навигатор -->
            </td>			
			</td></tr></table>
    <div class="hr"></div>
	<!-- Шапка товара -->    
	
        
                                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                        <tbody>
                                        <tr>
                                        <td width="200">
                                            <!-- Фото -->
                                            <div class="product_image">
                                                <?php if ($this->_tpl_vars['PRODUCTS_IMAGE'] || $this->_tpl_vars['PRODUCTS_MO_IMAGES'] || $this->_tpl_vars['PRODUCTS_IMAGE_LINK'] != ''): ?>
                                                <?php if ($this->_tpl_vars['PRODUCTS_POPUP_LINK'] != ''): ?><a id="thumb1" href="<?php echo $this->_tpl_vars['PRODUCTS_POPUP_IMAGE']; ?>
" onclick="return hs.expand(this, config1)" class="highslide" title="<?php echo $this->_tpl_vars['PRODUCTS_NAME']; ?>
" <?php if ($this->_tpl_vars['PRODUCTS_MO_IMAGES']): ?>rel="gallery-plants"<?php endif; ?> target="_blank"><?php endif; ?><img src="<?php echo $this->_tpl_vars['PRODUCTS_IMAGE']; ?>
" alt="<?php echo $this->_tpl_vars['PRODUCTS_NAME']; ?>
" /><?php if ($this->_tpl_vars['PRODUCTS_POPUP_LINK'] != ''): ?></a><?php endif; ?>
                                                <?php endif; ?>
                                            </div>     
                                            <!--/Фото -->
                                        </td>
                                   			
                                    <td>
                                        <!-- Краткое описание товара -->			
                                        <div class="mod_space">
                                            <?php echo $this->_tpl_vars['PRODUCTS_SHORT_DESCRIPTION']; ?>

                                        </div><br />
                                        <!--/ Краткое описание товара -->

                                        <?php if ($this->_tpl_vars['PRODUCTS_TAX_INFO']): ?><div class="mod_tax"><?php echo $this->_tpl_vars['PRODUCTS_TAX_INFO']; ?>
</div><?php endif; ?>
                                        <div class="mod_space">
                                            <div class="1mod_manuf">Производитель: <?php echo $this->_tpl_vars['MANUFACTURER']; ?>
</div> 
                                            <div class="1mod_print"><?php echo $this->_config[0]['vars']['print']; ?>
&nbsp;<?php echo $this->_tpl_vars['PRODUCTS_PRINT']; ?>
</div>

                                        </div>
<?php if ($this->_tpl_vars['param']): ?>
<?php $_from = $this->_tpl_vars['param']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['extra_fields']):
        $this->_foreach['aussen']['iteration']++;
?> 
<div class="mod_info"><b><?php echo $this->_tpl_vars['extra_fields']['name_value']; ?>
:</b> <?php echo $this->_tpl_vars['extra_fields']['value']; ?>
</div>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
                                        <?php if ($this->_tpl_vars['MODULE_products_media'] != ''): ?>
                                        <?php echo $this->_tpl_vars['MODULE_products_media']; ?>

                                        <?php endif; ?>





                                        &nbsp;</td>
                                    <td align="center">
                                 
                                        <?php if ($this->_tpl_vars['PRODUCTS_PRICE_COUNT_P'] > 0): ?>
                                           <?php if ($this->_tpl_vars['PRODUCTS_PRICE_S_P'] != 0): ?>
										 
                                        Средняя цена <br />
                                        <div class="product_price_2">
                                            <div align="center"><?php echo $this->_tpl_vars['PRODUCTS_PRICE_S']; ?>
</div>
                                        </div>
                                         (<?php echo $this->_tpl_vars['PRODUCTS_PRICE_COUNT']; ?>
)
										    <?php else: ?>
											  Цены не указаны <br />
                                    
                                         (<?php echo $this->_tpl_vars['PRODUCTS_PRICE_COUNT']; ?>
)
										<?php endif; ?>
                                        <?php else: ?>
                                        Нет продавцов<br>
										<?php if ($this->_tpl_vars['PRODUCTS_PRICE_COUNT_ALL'] > 0): ?>
										<a href="index.php?main_page=seller_offers_page&products_id=<?php echo $this->_tpl_vars['PRODUCTS_ID']; ?>
">Найти в других<br> регионах</a>
										<?php endif; ?>
                                        <?php endif; ?>
										<br />
										<?php if ($this->_tpl_vars['PRODUCTS_PRICE_COUNT_ALL'] > 0): ?>
                                        <!--Кнопка Выбрать продавца -->
                                        <a class="offers" rel="nofollow" href="index.php?main_page=seller_offers_page&products_id=<?php echo $this->_tpl_vars['PRODUCTS_ID']; ?>
">
                                            <img height="19" width="108" vspace="5"  src="/themes/silver/img/price.png">
                                        </a>
                                        <!--/Кнопка Выбрать продавца -->
										<?php endif; ?>
                                    </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                
    <div class="left_block"> </div>
    <!--Табы ................................................................................-->
    <div class="section">
        <ul class="tabs">
		    <li class="current">Фото (<?php echo $this->_tpl_vars['mo_img_count']; ?>
)</li>
			<?php if ($this->_tpl_vars['PRODUCTS_DESCRIPTION']): ?>
            <li >Описание</li>
			<?php endif; ?>
            <li id="prod">Где купить (<?php echo $this->_tpl_vars['PRODUCTS_PRICE_COUNT_P']; ?>
)</li>
			<?php if ($this->_tpl_vars['PRODUCTS_MO_IMAGES']): ?>
            
			<?php endif; ?>
            <li>Отзывы (<?php echo $this->_tpl_vars['reviews_count']; ?>
)</li>
        </ul>
<!--Таб Фото -->
		<?php if ($this->_tpl_vars['PRODUCTS_MO_IMAGES']): ?>
        <div class="box visible">     
            <?php if ($this->_tpl_vars['PRODUCTS_MO_IMAGES']): ?>
            <table width="100%" cellspacing="0" cellpadding="7" border="0">
                <tr>
                    <?php $_from = $this->_tpl_vars['mo_img']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['mo_pic'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['mo_pic']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['img_values']):
        $this->_foreach['mo_pic']['iteration']++;
?>
                    <?php  $col++;
                     ?>
                    <td valign="top">
                        <div align="center">
                            <?php if ($this->_tpl_vars['img_values']['PRODUCTS_MO_POPUP_LINK'] != ''): ?><a href="<?php echo $this->_tpl_vars['img_values']['PRODUCTS_MO_POPUP_IMAGE']; ?>
" title="<?php echo $this->_tpl_vars['PRODUCTS_NAME']; ?>
" onclick="return hs.expand(this, config1)" class="highslide" rel="gallery-plants" target="_blank"><?php endif; ?><img src="<?php echo $this->_tpl_vars['img_values']['PRODUCTS_MO_IMAGE']; ?>
" alt="<?php echo $this->_tpl_vars['PRODUCTS_NAME']; ?>
"width="100px" /><?php if ($this->_tpl_vars['img_values']['PRODUCTS_MO_POPUP_LINK'] != ''): ?></a><?php endif; ?>
                        <br><?php echo $this->_tpl_vars['img_values']['image_alt']; ?>

						</div>
                    </td>
                    <?php 
                    if ($col>=5) {
                    $col=0;
                    echo '</tr><tr>';
                    }
                     ?>
                    <?php endforeach; endif; unset($_from); ?>
                </tr>
            </table>
            <?php endif; ?>
        </div>
        <!--/Таб Фото -->		
		
		<?php if ($this->_tpl_vars['PRODUCTS_DESCRIPTION']): ?>
        <!--Таб Описание -->
        <div class="box ">
            <?php if ($this->_tpl_vars['PRODUCTS_DESCRIPTION'] != ''): ?>
            <div class="mod_space">

                <div class="mod_space">
                    <?php echo $this->_tpl_vars['PRODUCTS_DESCRIPTION']; ?>

                    <BR/><?php if ($this->_tpl_vars['PRODUCTS_URL'] != ''): ?><div class="mod_arturl"><?php echo $this->_tpl_vars['PRODUCTS_URL']; ?>
</div><?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
        <!--/Таб Описание --> 
		<?php endif; ?>

        <!--Таб Где купить -->
        <div class="box"><?php echo $this->_tpl_vars['buy']; ?>
</div>
        <!--Таб/ Где купить -->
		
<?php endif; ?>
        <!--Таб Отзывы -->
        <div class="box">
            <?php if ($this->_tpl_vars['MODULE_products_reviews'] != ''): ?>
            <?php echo $this->_tpl_vars['MODULE_products_reviews']; ?>

            <?php endif; ?>
        </div>
        <!--/Таб Отзывы -->

    </div> 
  </div><!-- .section -->
 <!--/Табы -->
</div></div></div></div></div></div></div></div> 

<?php if ($this->_tpl_vars['MODULE_cross_selling'] != ''): ?>
<?php echo $this->_tpl_vars['MODULE_cross_selling']; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['MODULE_reverse_cross_selling'] != ''): ?>
<?php echo $this->_tpl_vars['MODULE_reverse_cross_selling']; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['MODULE_also_purchased'] != ''): ?>
<?php echo $this->_tpl_vars['MODULE_also_purchased']; ?>

<?php endif; ?>
  
  
<?php echo $this->_tpl_vars['FORM_END']; ?>