<?php /* Smarty version 2.6.24, created on 2017-01-13 12:44:37
         compiled from silver/module/main_content.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/main_content.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'index'), $this);?>

<?php echo $this->_tpl_vars['MODULE_error']; ?>


<?php echo $this->_tpl_vars['text']; ?>


<?php echo $this->_tpl_vars['MODULE_latest_news']; ?>
	
<?php echo $this->_tpl_vars['MODULE_featured_products']; ?>

<?php echo $this->_tpl_vars['MODULE_new_products']; ?>