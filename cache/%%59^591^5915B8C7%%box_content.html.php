<?php /* Smarty version 2.6.24, created on 2017-01-13 12:44:37
         compiled from silver/boxes/box_content.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/boxes/box_content.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'boxes'), $this);?>

<div class="block"> 
          <div class="greenblock_header"><h3><?php echo $this->_config[0]['vars']['heading_infobox']; ?>
</h3></div> 
		  <div class="block_center"> 
			 <div class="leftmenu"> 
				<ul class="list">
<?php echo $this->_tpl_vars['BOX_CONTENT']; ?>
 
		       </ul>
			 </div> 
		  </div> 
		  <div class="block_bot"></div> 
</div>