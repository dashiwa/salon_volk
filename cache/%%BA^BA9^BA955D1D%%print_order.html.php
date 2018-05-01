<?php /* Smarty version 2.6.24, created on 2018-02-05 13:48:55
         compiled from silver/module/print_order.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/print_order.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'print_order'), $this);?>
 <?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'product_info'), $this);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title><?php echo $this->_config[0]['vars']['title']; ?>
 <?php echo $this->_tpl_vars['oID']; ?>
</title><meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['charset']; ?>
" /></head><body onload="window.print()"><table width="100%" border="0">  <tr>     <td><table width="100%" border="0" cellpadding="0" cellspacing="0">        <tr>           <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_tpl_vars['address_label_customer']; ?>
<br />              <br /><?php if ($this->_tpl_vars['csID']): ?><strong><?php echo $this->_config[0]['vars']['csID']; ?>
</strong><?php echo $this->_tpl_vars['csID']; ?>
<br /><?php endif; ?>            <?php if ($this->_tpl_vars['PAYMENT_METHOD']): ?><strong><?php echo $this->_config[0]['vars']['payment']; ?>
</strong> <?php echo $this->_tpl_vars['PAYMENT_METHOD']; ?>
<br /><?php endif; ?>            <?php if ($this->_tpl_vars['SHIPPING_METHOD']): ?><strong><?php echo $this->_config[0]['vars']['shipping']; ?>
</strong> <?php echo $this->_tpl_vars['SHIPPING_METHOD']; ?>
<br /><?php endif; ?>            <strong><?php echo $this->_config[0]['vars']['order']; ?>
</strong> <?php echo $this->_tpl_vars['oID']; ?>
<br />            <strong><?php echo $this->_config[0]['vars']['date']; ?>
</strong> <?php echo $this->_tpl_vars['DATE']; ?>
<br />            </font></td>          <td width="1"><img src="<?php echo $this->_tpl_vars['logo_path']; ?>
logo.gif" alt="<?php echo $this->_tpl_vars['store_name']; ?>
" /></td>        </tr>      </table>      <br />      <table style="border-top:1px solid; border-bottom:1px solid;" width="100%" border="0">        <tr bgcolor="#f1f1f1">           <td width="50%">             <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>            </strong><strong>            <?php echo $this->_config[0]['vars']['shipping_address']; ?>
            </strong><br />          </font></p></td><?php if ($this->_tpl_vars['address_label_payment']): ?>          <td>             <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>              </strong><strong>              <?php echo $this->_config[0]['vars']['payment_address']; ?>
              </strong><br />          </font> </p></td><?php endif; ?>        </tr>        <tr>          <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">            <?php echo $this->_tpl_vars['address_label_shipping']; ?>
          </font></td>		  <?php if ($this->_tpl_vars['address_label_payment']): ?>          <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">            <?php echo $this->_tpl_vars['address_label_payment']; ?>
          </font></td><?php endif; ?>        </tr>      </table>      <p>&nbsp;</p></td>  </tr></table><table style="border-bottom:1px solid;" width="100%" border="0" cellpadding="0" cellspacing="0">  <tr>     <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $this->_config[0]['vars']['heading_products']; ?>
</strong></font></td>  </tr>  <tr>    <td>	<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="f1f1f1">        <tr>           <td colspan="2" style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_config[0]['vars']['head_units']; ?>
</font></strong></div></td>          <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_config[0]['vars']['head_products']; ?>
</font></strong></td>          <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_config[0]['vars']['head_artnr']; ?>
</font></strong></td>          <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_config[0]['vars']['head_single_price']; ?>
</font></strong></td>          <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;" width="150"><div align="right"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_config[0]['vars']['head_price']; ?>
</font></strong></div></td>        </tr>        <?php $_from = $this->_tpl_vars['order_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['order_values']):
        $this->_foreach['aussen']['iteration']++;
?>         <tr>           <td width="20" style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_tpl_vars['order_values']['PRODUCTS_QTY']; ?>
</font></div></td>          <td width="20" style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">x</font></div></td>          <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $this->_tpl_vars['order_values']['PRODUCTS_NAME']; ?>
</strong><em><?php echo $this->_tpl_vars['order_values']['PRODUCTS_ATTRIBUTES']; ?>
</em><?php if ($this->_tpl_vars['order_values']['PRODUCTS_SHIPPING_TIME'] != ''): ?><br />          <?php echo $this->_config[0]['vars']['text_shippingtime']; ?>
 <?php echo $this->_tpl_vars['order_values']['PRODUCTS_SHIPPING_TIME']; ?>
<br /><?php endif; ?></font></td>          <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_tpl_vars['order_values']['PRODUCTS_MODEL']; ?>
<em><?php echo $this->_tpl_vars['order_values']['PRODUCTS_ATTRIBUTES_MODEL']; ?>
</em></font></td>          <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_tpl_vars['order_values']['PRODUCTS_SINGLE_PRICE']; ?>
</font></td>          <td style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;" width="150"><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $this->_tpl_vars['order_values']['PRODUCTS_PRICE']; ?>
</font></div></td>        </tr>        <?php endforeach; endif; unset($_from); ?> </table>	</td>  </tr></table><table width="100%" border="0" cellpadding="0" cellspacing="0">  <tr>    <td>	<table width="100%" border="0" cellpadding="3" cellspacing="0">  <?php $_from = $this->_tpl_vars['order_total']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['order_total_values']):
        $this->_foreach['aussen']['iteration']++;
?>  <tr>     <td nowrap="nowrap" width="100%" style="border-right: 2px solid; border-bottom: 2px solid; border-color: #ffffff;"><div align="right"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $this->_tpl_vars['order_total_values']['TITLE']; ?>
               <?php echo $this->_tpl_vars['order_total_values']['TEXT']; ?>
</font></div></td>  </tr>  <?php endforeach; endif; unset($_from); ?> </table></td>  </tr></table></body></html>