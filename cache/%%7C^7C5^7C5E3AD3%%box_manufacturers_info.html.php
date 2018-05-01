<?php /* Smarty version 2.6.24, created on 2017-01-13 15:01:37
         compiled from silver/boxes/box_manufacturers_info.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/boxes/box_manufacturers_info.html', 1, false),)), $this); ?>
﻿<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'boxes'), $this);?>

<div class="block"> 
		<div class="greenblock_header"><h3>ПРОИЗВОДИТЕЛЬ</h3></div> 
		  <div class="block_center"><div class="block_centertxt"> 
			<ul class="list"> 
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  
    <td class="infoBox_right" align="left"><table width="95%"  border="0" cellpadding="2" cellspacing="0">
        <tr>
          <td class="blockTitle_bl"> <?php if ($this->_tpl_vars['IMAGE']): ?><center><img src="<?php echo $this->_tpl_vars['IMAGE']; ?>
" alt="<?php echo $this->_tpl_vars['NAME']; ?>
" /><br />
          </center><?php endif; ?>
          <?php if ($this->_tpl_vars['URL']): ?><?php echo $this->_tpl_vars['URL']; ?>
<br /><?php endif; ?>
          <?php echo $this->_tpl_vars['LINK_MORE']; ?>
<br />"<?php echo $this->_tpl_vars['NAME']; ?>
"</td>

        </tr>
    </table></td>
  </tr>
</table>
			</ul> 
			</div></div> 
		  <div class="block_bot"></div> 
	</div>