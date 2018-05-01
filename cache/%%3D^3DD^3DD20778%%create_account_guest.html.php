<?php /* Smarty version 2.6.24, created on 2016-09-02 03:23:35
         compiled from silver/module/create_account_guest.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/create_account_guest.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'create_account'), $this);?>

<div class="mod_news">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td class="mod_blueleft"></td><td class="mod_bluecenter">
<div class="modtit_acnt"><?php echo $this->_config[0]['vars']['heading_create_account']; ?>
</div>
</td><td class="mod_blueright"></td></tr></table>
<?php if ($this->_tpl_vars['error'] != ''): ?>
<div class="error"><?php echo $this->_tpl_vars['error']; ?>
</div>
<?php endif; ?>
<?php echo $this->_tpl_vars['FORM_ACTION']; ?>

<div class="mod_space">
<div class="mod_corner">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="mod_th"><?php echo $this->_config[0]['vars']['title_personal']; ?>
</td>
    <td><span class="red right"><?php echo $this->_config[0]['vars']['text_must']; ?>
</span></td>
  </tr>
<?php if ($this->_tpl_vars['gender'] == '1'): ?>
  <tr>
    <td class="mod_tdb"><label for="gender" title="<?php echo $this->_tpl_vars['ENTRY_GENDER_ERROR']; ?>
"><?php echo $this->_config[0]['vars']['text_gender']; ?>
</label></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_MALE']; ?>
<br /><?php echo $this->_tpl_vars['INPUT_FEMALE']; ?>
</td>
  </tr>
  <?php endif; ?>
  <tr>
    <td class="mod_tdb"><label for="firstname" title="<?php echo $this->_tpl_vars['ENTRY_FIRST_NAME_ERROR']; ?>
"><?php echo $this->_config[0]['vars']['text_firstname']; ?>
</label></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_FIRSTNAME']; ?>
</td>
  </tr>
<?php if ($this->_tpl_vars['secondname'] == '1'): ?>
  <tr>
    <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_secondname']; ?>
</td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_SECONDNAME']; ?>
</td>
  </tr>
  <?php endif; ?>
  <tr>
    <td class="mod_tdb"><label for="lastname" title="<?php echo $this->_tpl_vars['ENTRY_LAST_NAME_ERROR']; ?>
"><?php echo $this->_config[0]['vars']['text_lastname']; ?>
</label></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_LASTNAME']; ?>
</td>
  </tr>
  <?php if ($this->_tpl_vars['birthdate'] == '1'): ?>
  <tr>
    <td class="mod_tdb"><label for="dob" title="<?php echo $this->_tpl_vars['ENTRY_DATE_OF_BIRTH_ERROR']; ?>
"><?php echo $this->_config[0]['vars']['text_birthdate']; ?>
</label></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_DOB']; ?>
</td>
  </tr>
  <?php endif; ?>
  <tr>
    <td class="mod_tdb"><label for="email" title="<?php echo $this->_tpl_vars['ENTRY_EMAIL_ADDRESS_ERROR']; ?>
"><?php echo $this->_config[0]['vars']['text_email']; ?>
</label></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_EMAIL']; ?>
</td>
  </tr>
  <?php if ($this->_tpl_vars['company'] == '1'): ?>
  <tr>
    <td class="mod_th" colspan="2"><?php echo $this->_config[0]['vars']['title_company']; ?>
</td>
  </tr>
  <tr>
    <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_company']; ?>
</td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_COMPANY']; ?>
</td>
  </tr>
  <?php if ($this->_tpl_vars['vat'] == '1'): ?>
  <tr>
     <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_ustid']; ?>
</td>
     <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_VAT']; ?>
</td>
  </tr>
  <?php endif; ?>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['street_address'] == '1'): ?>
  <tr>
    <td class="mod_th" colspan="2"><?php echo $this->_config[0]['vars']['title_address']; ?>
</td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['street_address'] == '1'): ?>
  <tr>
    <td class="mod_tdb"><label for="address" title="<?php echo $this->_tpl_vars['ENTRY_STREET_ADDRESS_ERROR']; ?>
"><?php echo $this->_config[0]['vars']['text_street']; ?>
</label></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_STREET']; ?>
</td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['suburb'] == '1'): ?>
  <tr>
    <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_suburb']; ?>
</td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_SUBURB']; ?>
</td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['postcode'] == '1'): ?>
  <tr>
    <td class="mod_tdb"><label for="postcode" title="<?php echo $this->_tpl_vars['ENTRY_POST_CODE_ERROR']; ?>
"><?php echo $this->_config[0]['vars']['text_code']; ?>
</label></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_CODE']; ?>
</td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['city'] == '1'): ?>
  <tr>
    <td class="mod_tdb"><label for="city" title="<?php echo $this->_tpl_vars['ENTRY_CITY_ERROR']; ?>
"><?php echo $this->_config[0]['vars']['text_city']; ?>
</label></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_CITY']; ?>
</td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['state'] == '1'): ?>
  <tr>
    <td class="mod_tdb"><label for="state" title="<?php echo $this->_tpl_vars['ENTRY_STATE_ERROR_SELECT']; ?>
"><?php echo $this->_config[0]['vars']['text_state']; ?>
</label></td>
    <td class="mod_td2"><span id="stateXML"><?php echo $this->_tpl_vars['INPUT_STATE']; ?>
</span></td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['country'] == '1'): ?>
  <tr>
    <td class="mod_tdb"><label for="country" title="<?php echo $this->_tpl_vars['ENTRY_COUNTRY_ERROR']; ?>
"><?php echo $this->_config[0]['vars']['text_country']; ?>
</label></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['SELECT_COUNTRY']; ?>
<?php echo $this->_tpl_vars['SELECT_COUNTRY_NOSCRIPT']; ?>
</td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['telephone'] == '1'): ?>
  <tr>
    <td class="mod_th" colspan="2"><?php echo $this->_config[0]['vars']['title_contact']; ?>
</td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['telephone'] == '1'): ?>
  <tr>
    <td class="mod_tdb"><label for="telephone" title="<?php echo $this->_tpl_vars['ENTRY_TELEPHONE_NUMBER_ERROR']; ?>
"><?php echo $this->_config[0]['vars']['text_tel']; ?>
</label></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_TEL']; ?>
</td>
  </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['fax'] == '1'): ?>
  <tr>
    <td class="mod_tdb"><?php echo $this->_config[0]['vars']['text_fax']; ?>
</td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['INPUT_FAX']; ?>
</td>
  </tr>
  <?php endif; ?>
<?php if ($this->_tpl_vars['INPUT_CUSTOMERS_EXTRA_FIELDS']): ?>
<?php $_from = $this->_tpl_vars['INPUT_CUSTOMERS_EXTRA_FIELDS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['customers_extra_filelds']):
?>
  <tr>
    <td class="mod_tdb"><?php echo $this->_tpl_vars['customers_extra_filelds']['NAME']; ?>
:</td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['customers_extra_filelds']['VALUE']; ?>
</td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
</table>
</div>
<table>
  <tr>
    <td class="mod_tdb"></td>
    <td class="mod_td2"><?php echo $this->_tpl_vars['BUTTON_SUBMIT']; ?>
</td>
  </tr>
</table>
</div>
</div>
<?php echo $this->_tpl_vars['FORM_END']; ?>

