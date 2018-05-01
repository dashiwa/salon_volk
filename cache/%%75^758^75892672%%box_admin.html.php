<?php /* Smarty version 2.6.24, created on 2015-06-03 09:32:03
         compiled from silver/boxes/box_admin.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/boxes/box_admin.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'boxes'), $this);?>

<!-- Бокс вход -->
<div class="block"> 
		<div class="greenblock_header"><h3><?php echo $this->_config[0]['vars']['heading_admin']; ?>
</h3></div> 
		  <div class="block_center"><div class="block_centertxt"> 
			<ul class="list"> 
<?php echo $this->_tpl_vars['BOX_CONTENT']; ?>

			</ul> 
			</div></div> 
		  <div class="block_bot"></div> 
</div>
<!-- /Бокс вход -->