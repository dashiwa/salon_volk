<?php /* Smarty version 2.6.24, created on 2017-01-13 15:01:37
         compiled from silver/module/product_navigator.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/product_navigator.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'product_navigator'), $this);?>


<?php if ($this->_tpl_vars['PREVIOUS'] != ''): ?>&nbsp;<a href="<?php echo $this->_tpl_vars['PREVIOUS']; ?>
"><img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
img/pre.jpg" title="Предыдущий"/></a>&nbsp;<?php endif; ?>
<?php if ($this->_tpl_vars['NEXT'] != ''): ?>&nbsp;<a href="<?php echo $this->_tpl_vars['NEXT']; ?>
"><img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
img/sl.jpg" title="Следующий"/></a><?php endif; ?>
