<?php /* Smarty version 2.6.24, created on 2016-09-02 03:23:35
         compiled from silver/module/password_double_opt_in.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/password_double_opt_in.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'new_password'), $this);?>

<div class="mod_news">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td class="mod_blueleft"></td><td class="mod_bluecenter">
<div class="modtit_feat"><?php echo $this->_config[0]['vars']['heading_password']; ?>
</div>
</td><td class="mod_blueright"></td></tr></table>
<?php if ($this->_tpl_vars['info_message'] != ''): ?>
<div class="error"><?php echo $this->_tpl_vars['info_message']; ?>
</div>
<?php endif; ?>
<?php echo $this->_tpl_vars['FORM_ACTION']; ?>


<div class="info"><?php echo $this->_tpl_vars['message']; ?>
</div>
<div class="mod_space">
<div class="h2"><?php echo $this->_config[0]['vars']['text_step1']; ?>
<?php echo $this->_config[0]['vars']['text_info_pre']; ?>
 <?php echo $this->_tpl_vars['SHOP_NAME']; ?>
 <?php echo $this->_config[0]['vars']['text_info_post']; ?>
</div>
<div class="mod_corner">
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_sec_code']; ?>
</td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['CAPTCHA_IMG']; ?>
</td>
  </tr>
  <tr>
    <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_sec_code']; ?>
</td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['CAPTCHA_INPUT']; ?>
</td>
  </tr>
  <tr>
    <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_email']; ?>
</td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_EMAIL']; ?>
</td>
  </tr>
</table>
</div>
<div class="h2"><?php echo $this->_config[0]['vars']['text_to_step2']; ?>
</div>
<div class="mod_corner">
 <div class="cont_tab">
  <div class="mod_row"><div><?php echo $this->_config[0]['vars']['text_continue']; ?>
</div></div>
 </div>
</div>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td class="mod_tdb"></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['BUTTON_SEND']; ?>
</td>
  </tr>
</table>
</div>
<?php echo $this->_tpl_vars['FORM_END']; ?>

</div>