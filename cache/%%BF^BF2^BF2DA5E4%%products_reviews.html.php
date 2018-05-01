<?php /* Smarty version 2.6.24, created on 2017-01-13 15:01:37
         compiled from silver/module/products_reviews.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/products_reviews.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'reviews'), $this);?>

<div class="mod_news">


<?php $_from = $this->_tpl_vars['module_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['module_data']):
        $this->_foreach['aussen']['iteration']++;
?>
<div class="mod_space"><div class="mod_corner">
    <div class="mod_time"><?php echo $this->_tpl_vars['module_data']['DATE']; ?>
</div>
    <div class="mod_artautor"><?php echo $this->_config[0]['vars']['text_author']; ?>
 <?php echo $this->_tpl_vars['module_data']['AUTHOR']; ?>
</div>
    <div class="mod_info"><?php echo $this->_config[0]['vars']['text_rating']; ?>
 <?php echo $this->_tpl_vars['module_data']['RATING']; ?>
</div>
    <div class="brspace"></div><div class="brspace"></div>
    <div class="cooment_info"><?php echo $this->_tpl_vars['module_data']['TEXT']; ?>
</div>
</div></div>
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['TEXT_FIRST_REVIEW'] != ''): ?>
<div class="info"><?php echo $this->_tpl_vars['TEXT_FIRST_REVIEW']; ?>
</div>
<?php endif; ?>
<div class="mod_space">
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
    <td><span class="imgs right"><?php echo $this->_tpl_vars['BUTTON_NEW']; ?>
<?php echo $this->_tpl_vars['BUTTON_WRITE']; ?>
</span></td>
  </tr>
</table>
<div>
<div class="brspace"></div>
</div></div></div>