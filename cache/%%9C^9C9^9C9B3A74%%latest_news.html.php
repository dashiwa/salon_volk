<?php /* Smarty version 2.6.24, created on 2017-01-13 15:41:58
         compiled from silver/module/latest_news.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/module/latest_news.html', 1, false),array('modifier', 'os_truncate', 'silver/module/latest_news.html', 26, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'latest_news'), $this);?>

<div class="mod_news">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td>
<div class="modtit_news"><?php echo $this->_config[0]['vars']['heading_text']; ?>
</div>
</td></tr></table>
<?php if ($this->_tpl_vars['ONE'] == 1): ?>
<?php $this->assign('module_data', $this->_tpl_vars['module_content'][0]); ?>
<div class="mod_space">
<div class="mod_corner" id="myBox">
<div class="mod_time"><?php echo $this->_tpl_vars['module_data']['NEWS_DATA']; ?>
</div>
<div class="mod_newstitle"><a href="<?php echo $this->_tpl_vars['module_data']['NEWS_LINK_MORE']; ?>
"><?php echo $this->_tpl_vars['module_data']['NEWS_HEADING']; ?>
</a></div>
<div class="mod_newscontent"><?php echo $this->_tpl_vars['module_data']['NEWS_CONTENT']; ?>
<br /><a class="a_more" href="<?php echo $this->_tpl_vars['NEWS_LINK']; ?>
"><?php echo $this->_config[0]['vars']['other_news']; ?>
</a></div>
</div></div>
</div>
<?php else: ?>
<div class="cont_tab">
  <div class="mod_row">
  <?php $_from = $this->_tpl_vars['module_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['module_data']):
        $this->_foreach['aussen']['iteration']++;
?>
  <?php  $col++;
   ?>
<div class="mod_space">
<div class="mod_corner" id="myBox">
<div class="mod_time"><?php echo $this->_tpl_vars['module_data']['NEWS_DATA']; ?>
</div>
<div class="mod_newstitle"><a href="<?php echo $this->_tpl_vars['module_data']['NEWS_LINK_MORE']; ?>
"><?php echo $this->_tpl_vars['module_data']['NEWS_HEADING']; ?>
</a></div>
<div class="mod_newscontent"><?php echo ((is_array($_tmp=$this->_tpl_vars['module_data']['NEWS_CONTENT'])) ? $this->_run_mod_handler('os_truncate', true, $_tmp, @MAX_DISPLAY_LATEST_NEWS_CONTENT, " ...") : smarty_modifier_os_truncate($_tmp, @MAX_DISPLAY_LATEST_NEWS_CONTENT, " ...")); ?>
<br /><a class="a_more" href="<?php echo $this->_tpl_vars['NEWS_LINK']; ?>
"><?php echo $this->_config[0]['vars']['other_news']; ?>
</a></div>
</div></div>
  <?php  
  if ($col>=1) {
  $col=0;
  echo '</div><div class="mod_row">';
  }
   ?>
  <?php endforeach; endif; unset($_from); ?>  
  </div>
</div>
<div class="brspace"></div><div class="brspace"></div>
<div class="navigation">
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td class="navbar"><?php echo $this->_tpl_vars['NAVIGATION_BAR']; ?>
</td>
    <td class="navbar1"><?php echo $this->_tpl_vars['NAVIGATION_BAR_PAGES']; ?>
</td>
  </tr>
</table>
</div>
</div>
<?php endif; ?>