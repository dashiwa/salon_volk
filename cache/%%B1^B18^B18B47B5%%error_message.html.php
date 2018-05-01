<?php /* Smarty version 2.6.24, created on 2017-01-13 15:01:36
         compiled from silver/module/error_message.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/error_message.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'error_handler'), $this);?>

<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'advanced_search'), $this);?>

<div class="mod_news">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td class="mod_blueleft"></td><td class="mod_bluecenter">
<div class="modtit_affil"><?php echo $this->_config[0]['vars']['heading_search']; ?>
</div>
</td><td class="mod_blueright"></td></tr></table>
<div class="error"><?php echo $this->_tpl_vars['ERROR']; ?>
</div>
</div>