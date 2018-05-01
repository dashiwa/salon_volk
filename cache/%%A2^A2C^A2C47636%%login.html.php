<?php /* Smarty version 2.6.24, created on 2017-01-26 05:40:33
         compiled from silver/module/login.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/login.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'login'), $this);?>

<div class="mod_news">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td class="mod_blueleft"></td><td class="mod_bluecenter">
<div class="modtit_acnt"><?php echo $this->_config[0]['vars']['heading_login']; ?>
</div>
</td><td class="mod_blueright"></td></tr></table>
<?php if ($this->_tpl_vars['info_message'] != ''): ?>
<div class="info"><?php echo $this->_tpl_vars['info_message']; ?>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['account_option'] == 'account' || $this->_tpl_vars['account_option'] == 'both'): ?>
<div class="mod_space">
<table width="100%" cellpadding="10" cellspacing="0">
  <tr>
    <td class="mod_td3">
    <div class="mod_corner" id="myBox">
    <b class="h2"><?php echo $this->_config[0]['vars']['title_new']; ?>
</b><br /><br />
    <?php echo $this->_config[0]['vars']['text_new']; ?>
<br />
    <span class="imgs"><?php echo $this->_tpl_vars['BUTTON_NEW_ACCOUNT']; ?>
</span>
    </div>
    </td>
    <td class="mod_td3">
    <div class="mod_corner" id="myBox">
    <b class="h2"><?php echo $this->_config[0]['vars']['title_returning']; ?>
</b><br /><br />
    <?php echo $this->_config[0]['vars']['text_returning']; ?>
<?php echo $this->_tpl_vars['FORM_ACTION']; ?>

    <table width="100%" cellpadding="10" cellspacing="0">
      <tr>
        <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_email']; ?>
</td>
        <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_MAIL']; ?>
</td>
      </tr>
      <tr>
        <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_password']; ?>
</td>
        <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_PASSWORD']; ?>
</td>
      </tr>
     <?php if ($this->_tpl_vars['CAPTCHA_IMG'] != ''): ?>
      <tr>
        <td class="mod_tdb"><?php echo $this->_tpl_vars['CAPTCHA_IMG']; ?>
</td>
        <td class="mod_td2"><?php echo $this->_tpl_vars['CAPTCHA_INPUT']; ?>
</td>
      </tr>
     <?php endif; ?>
      <tr>
        <td class="mod_tdb"></td>
        <td class="mod_td2"><?php echo $this->_tpl_vars['BUTTON_LOGIN']; ?>
</td>
      </tr>
      <tr>
        <td class="mod_tdb"></td>
        <td class="mod_td2"><a href="<?php echo $this->_tpl_vars['LINK_LOST_PASSWORD']; ?>
"><?php echo $this->_config[0]['vars']['text_lost_password']; ?>
</a></td>
      </tr>
    </table>
   </div><?php echo $this->_tpl_vars['FORM_END']; ?>

    </td>
  </tr>
</table>
</div>

<?php endif; ?>
<br />
<?php if ($this->_tpl_vars['account_option'] == 'both' || $this->_tpl_vars['account_option'] == 'guest'): ?><br />
<div class="mod_space">
    <div class="mod_corner" id="myBox">
    <b class="h2"><?php echo $this->_config[0]['vars']['title_guest']; ?>
</b><br /><br />
    <?php echo $this->_config[0]['vars']['text_guest']; ?>
<br />
    <span class="imgs"><?php echo $this->_tpl_vars['BUTTON_GUEST']; ?>
</span>
</div>
 </div>
<?php endif; ?>

</div>