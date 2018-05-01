<?php /* Smarty version 2.6.24, created on 2016-02-05 04:29:06
         compiled from silver/module/product_info/product_2foto_tovary.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/product_info/product_2foto_tovary.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'product_info'), $this);?>


<script type="text/javascript" src="themes/grin/javascript/highslide/highslide-with-gallery.js"></script>
<script type="text/javascript" src="themes/grin/javascript/highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="themes/grin/javascript/highslide/highslide.css" />
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="themes/grin/javascript/highslide/highslide-ie6.css" />
<![endif]-->
<?php echo $this->_tpl_vars['FORM_ACTION']; ?>

<div class="mod_news">

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
    
	<!-- Шапка товара -->    
	
        
                                      
                                
    <div class="left_block"> </div>
    <!--Табы ................................................................................-->
   
<!--Таб Фото -->
	<table border="0" cellpadding="0" cellspacing="0" style="width: 200;">
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
                                                <br><?php if ($this->_tpl_vars['img_values']['image_alt']): ?>
    //какой то код с выводом комментария или просто метка
     <?php echo $this->_tpl_vars['img_values']['image_alt']; ?>
 
<?php else: ?>
   //нет комментария к картинке 
<?php endif; ?>
												<?php endif; ?>
                                            </div>     
                                            <!--/Фото -->
                                        </td>         			
                                 
                                    </tr>
                                    </tbody>
                                    </table>    
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
" /><?php if ($this->_tpl_vars['img_values']['PRODUCTS_MO_POPUP_LINK'] != ''): ?></a><?php endif; ?>
                        <br><?php echo $this->_tpl_vars['img_values']['image_alt']; ?>

						</div>
                    </td>
                    <?php 
                    if ($col>=2) {
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
      
        <!--/Таб Отзывы -->


  </div><!-- .section -->
 <!--/Табы -->

</div> 

  
<?php echo $this->_tpl_vars['FORM_END']; ?>