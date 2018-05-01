<?php /* Smarty version 2.6.24, created on 2017-01-13 15:44:00
         compiled from silver/module/contact_us.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/contact_us.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'contact_us'), $this);?>

<div class="mod_news">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td class="mod_blueleft"></td><td class="mod_bluecenter">
<div class="modtit_newsletter"><?php echo $this->_tpl_vars['CONTACT_HEADING']; ?>
</div>
</td><td class="mod_blueright"></td></tr></table>
<?php if ($this->_tpl_vars['error_message'] != ''): ?>
<div class="error"><?php echo $this->_tpl_vars['error_message']; ?>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['success'] != '1'): ?>
<?php echo $this->_tpl_vars['FORM_ACTION']; ?>

<div class="mod_space">
<?php echo $this->_tpl_vars['CONTACT_CONTENT']; ?>

</div>
<div class="mod_space">
<div class="mod_corner" id="myBox">
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_name']; ?>
</td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_NAME']; ?>
</td>
  </tr>
  <tr>
    <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_email']; ?>
</td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_EMAIL']; ?>
</td>
  </tr>
  <tr>
    <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_message']; ?>
</td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_TEXT']; ?>
</td>
  </tr>
  <tr>
    <td class="mod_tdb"></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['BUTTON_SUBMIT']; ?>
</td>
  </tr>
</table>
</div>
</div>
<?php echo $this->_tpl_vars['FORM_END']; ?>

<?php else: ?>
<div class="info"><?php echo $this->_config[0]['vars']['text_success']; ?>
</div>
 <div class="mod_space">
 <div class="cont_tab"><div class="mod_row"><div class="mod_tdright"><?php echo $this->_tpl_vars['BUTTON_CONTINUE']; ?>
</div></div></div>
 </div>
<?php endif; ?>
</div>