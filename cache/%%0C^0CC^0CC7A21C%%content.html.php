<?php /* Smarty version 2.6.24, created on 2017-01-13 15:38:09
         compiled from silver/module/content.html */ ?>
<div class="mod_news">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td class="mod_blueleft"></td><td class="mod_bluecenter">
<div class="modtit_feat"><?php echo $this->_tpl_vars['CONTENT_HEADING']; ?>
</div>
</td><td class="mod_blueright"></td></tr></table>
<div class="mod_moreinfo">
<?php $_from = $this->_tpl_vars['sub_pages_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sub_pages']):
        $this->_foreach['aussen']['iteration']++;
?>
<div class="mod_arturl"><a href="<?php echo $this->_tpl_vars['sub_pages']['PAGE_LINK']; ?>
"><?php echo $this->_tpl_vars['sub_pages']['PAGE_TITLE']; ?>
</a></div>
<?php endforeach; endif; unset($_from); ?> 
</div>
<?php if ($this->_tpl_vars['file']): ?>
<div class="mod_space"><div class="mod_corner"><?php echo $this->_tpl_vars['file']; ?>
</div></div>
<?php else: ?>
<div class="mod_space"><div class="mod_corner"><?php echo $this->_tpl_vars['CONTENT_BODY']; ?>
</div></div>
<?php endif; ?>
<div class="mod_space">
 <div class="cont_tab">
  <div class="mod_row ">
    <div class="mod_tdright"><span class="imgs right"><?php echo $this->_tpl_vars['BUTTON_CONTINUE']; ?>
</span></div>
  </div>
 </div>
</div>
</div>