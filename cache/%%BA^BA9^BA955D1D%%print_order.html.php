<?php /* Smarty version 2.6.24, created on 2018-02-05 13:48:55
         compiled from silver/module/print_order.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/print_order.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'print_order'), $this);?>
 

 <?php echo $this->_tpl_vars['oID']; ?>
</title>
" />
<br />
</strong><?php echo $this->_tpl_vars['csID']; ?>
<br /><?php endif; ?>
</strong> <?php echo $this->_tpl_vars['PAYMENT_METHOD']; ?>
<br /><?php endif; ?>
</strong> <?php echo $this->_tpl_vars['SHIPPING_METHOD']; ?>
<br /><?php endif; ?>
</strong> <?php echo $this->_tpl_vars['oID']; ?>
<br />
</strong> <?php echo $this->_tpl_vars['DATE']; ?>
<br />
logo.gif" alt="<?php echo $this->_tpl_vars['store_name']; ?>
" /></td>




</strong></font></td>
</font></strong></div></td>
</font></strong></td>
</font></strong></td>
</font></strong></td>
</font></strong></div></td>
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['order_values']):
        $this->_foreach['aussen']['iteration']++;
?> 
</font></div></td>
</strong><em><?php echo $this->_tpl_vars['order_values']['PRODUCTS_ATTRIBUTES']; ?>
</em><?php if ($this->_tpl_vars['order_values']['PRODUCTS_SHIPPING_TIME'] != ''): ?><br />
 <?php echo $this->_tpl_vars['order_values']['PRODUCTS_SHIPPING_TIME']; ?>
<br /><?php endif; ?></font></td>
<em><?php echo $this->_tpl_vars['order_values']['PRODUCTS_ATTRIBUTES_MODEL']; ?>
</em></font></td>
</font></td>
</font></div></td>
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['order_total_values']):
        $this->_foreach['aussen']['iteration']++;
?>
 
</font></div></td>