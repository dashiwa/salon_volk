<?php /* Smarty version 2.6.24, created on 2017-02-19 04:34:44
         compiled from silver/module/cookie_usage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/cookie_usage.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'cookie_usage'), $this);?>

<div class="mod_news">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td class="mod_blueleft"></td><td class="mod_bluecenter">
<div class="modtit_feat"><?php echo $this->_config[0]['vars']['heading_cookie_usage']; ?>
</div>
</td><td class="mod_blueright"></td></tr></table>
<div class="info"><?php echo $this->_config[0]['vars']['text_information']; ?>

<br /><br />
<b><?php echo $this->_config[0]['vars']['title_infobox']; ?>
</b><br />
<?php echo $this->_config[0]['vars']['text_infobox']; ?>

</div>
<div class="mod_space">
 <div class="cont_tab">
  <div class="mod_row ">
    <div class="mod_tdright"><span class="right imgs"><?php echo $this->_tpl_vars['BUTTON_CONTINUE']; ?>
</span></div>
  </div>
 </div>
</div>

</div>