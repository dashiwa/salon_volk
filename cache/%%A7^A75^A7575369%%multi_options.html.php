<?php /* Smarty version 2.6.24, created on 2017-01-13 15:01:37
         compiled from silver/module/product_options/multi_options.html */ ?>
<?php if ($this->_tpl_vars['options'] != ''): ?>
<div class="mod_space"><div class="mod_corner">
<table class="mod_table" width="100%" border="1" bordercolor="#dddddd" cellpadding="4" cellspacing="1">
<?php $_from = $this->_tpl_vars['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['outer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['outer']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['options_data']):
        $this->_foreach['outer']['iteration']++;
?>
<?php if ($this->_tpl_vars['options_data']['TYPE'] == '1'): ?>

<!-- select -->

  <tr>
    <th align="left"><?php echo $this->_tpl_vars['options_data']['NAME']; ?>
:</th>
  </tr>
  <tr>
    <td align="left">
        <select name="id[<?php echo $this->_tpl_vars['options_data']['ID']; ?>
]">
        <?php $_from = $this->_tpl_vars['options_data']['DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key_data'] => $this->_tpl_vars['item_data']):
?>
                <option value="<?php echo $this->_tpl_vars['item_data']['ID']; ?>
"><?php echo $this->_tpl_vars['item_data']['TEXT']; ?>
 <?php if ($this->_tpl_vars['item_data']['PRICE'] != ''): ?>   (<?php echo $this->_tpl_vars['item_data']['PREFIX']; ?>
 <?php echo $this->_tpl_vars['item_data']['PRICE']; ?>
)   <?php endif; ?> </option>
        <?php endforeach; endif; unset($_from); ?>
        </select>
    </td>
  </tr>
<!-- /select -->

<?php elseif ($this->_tpl_vars['options_data']['TYPE'] == '2'): ?>

<!-- text -->
    <tr>
      <th><?php echo $this->_tpl_vars['options_data']['NAME']; ?>
:</th>
    </tr>
    <tr>
    <td width="100%">
    <?php $_from = $this->_tpl_vars['options_data']['DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key_data'] => $this->_tpl_vars['item_data']):
        $this->_foreach['aussen']['iteration']++;
?>
     <table width="100%" border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td align="left"><input name="id[<?php echo $this->_tpl_vars['options_data']['ID']; ?>
]" type="hidden" value="<?php echo $this->_tpl_vars['item_data']['ID']; ?>
" /><input name="id[txt_<?php echo $this->_tpl_vars['options_data']['ID']; ?>
_<?php echo $this->_tpl_vars['item_data']['ID']; ?>
]" type="text" size="<?php echo $this->_tpl_vars['options_data']['SIZE']; ?>
" maxlength="<?php echo $this->_tpl_vars['options_data']['LENGTH']; ?>
" /></td>
        <td align="left"><?php echo $this->_tpl_vars['item_data']['TEXT']; ?>
</td>
        <td align="right"><?php if ($this->_tpl_vars['item_data']['MODEL']): ?>(<?php echo $this->_tpl_vars['item_data']['MODEL']; ?>
)<?php endif; ?> <?php echo $this->_tpl_vars['item_data']['PREFIX']; ?>
<?php echo $this->_tpl_vars['item_data']['PRICE']; ?>
</td>
      </tr>
      <?php if ($this->_tpl_vars['item_data']['DESCRIPTION']): ?><tr>
        <td align="left" colspan="3"><?php echo $this->_tpl_vars['item_data']['DESCRIPTION']; ?>
</td>
      </tr><?php endif; ?>
    </table>
    <?php endforeach; endif; unset($_from); ?>
    </td>
    </tr>
<!-- /text -->

<?php elseif ($this->_tpl_vars['options_data']['TYPE'] == '3'): ?>

<!-- textarea -->
    <tr>
      <th><?php echo $this->_tpl_vars['options_data']['NAME']; ?>
:</th>
    </tr>
    <tr>
    <td width="100%">
    <?php $_from = $this->_tpl_vars['options_data']['DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key_data'] => $this->_tpl_vars['item_data']):
        $this->_foreach['aussen']['iteration']++;
?>
     <table width="100%" border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td align="left"><input name="id[<?php echo $this->_tpl_vars['options_data']['ID']; ?>
]" type="hidden" value="<?php echo $this->_tpl_vars['item_data']['ID']; ?>
" /><textarea name="id[txt_<?php echo $this->_tpl_vars['options_data']['ID']; ?>
_<?php echo $this->_tpl_vars['item_data']['ID']; ?>
]" cols="20" rows="<?php echo $this->_tpl_vars['options_data']['ROWS']; ?>
"></textarea></td>
        <td align="left"><?php echo $this->_tpl_vars['item_data']['TEXT']; ?>
</td>
        <td align="right"><?php if ($this->_tpl_vars['item_data']['MODEL']): ?>(<?php echo $this->_tpl_vars['item_data']['MODEL']; ?>
)<?php endif; ?> <?php echo $this->_tpl_vars['item_data']['PREFIX']; ?>
<?php echo $this->_tpl_vars['item_data']['PRICE']; ?>
</td>
      </tr>
      <?php if ($this->_tpl_vars['item_data']['DESCRIPTION']): ?><tr>
        <td align="left" colspan="3"><?php echo $this->_tpl_vars['item_data']['DESCRIPTION']; ?>
</td>
      </tr><?php endif; ?>
    </table>
    <?php endforeach; endif; unset($_from); ?>
    </td>
    </tr>
<!-- /textarea -->

<?php elseif ($this->_tpl_vars['options_data']['TYPE'] == '4'): ?>

<!-- radio -->
    <tr>
      <th><?php echo $this->_tpl_vars['options_data']['NAME']; ?>
:</th>
    </tr>
    <tr>
    <td width="100%">
    <?php $_from = $this->_tpl_vars['options_data']['DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key_data'] => $this->_tpl_vars['item_data']):
        $this->_foreach['aussen']['iteration']++;
?>
     <table width="100%" border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td width="1"><input type="radio" name="id[<?php echo $this->_tpl_vars['options_data']['ID']; ?>
]" value="<?php echo $this->_tpl_vars['item_data']['ID']; ?>
" <?php if (($this->_foreach['aussen']['iteration'] <= 1)): ?> checked="checked"<?php endif; ?> /></td>
        <td width="1" valign="top"><?php if ($this->_tpl_vars['item_data']['IMAGE']): ?><img src="<?php echo $this->_tpl_vars['image_dir']; ?>
/thumbs/<?php echo $this->_tpl_vars['item_data']['IMAGE']; ?>
" width="45" height="45" alt="" style="border: 1px solid #000000"  /><?php endif; ?></td>
        <td align="left">
        <?php if ($this->_tpl_vars['item_data']['LINK']): ?>
        <a align="right" href="http://<?php echo $this->_tpl_vars['item_data']['LINK']; ?>
" target="_blank">
        <?php echo $this->_tpl_vars['item_data']['TEXT']; ?>
</a>
        <?php else: ?><?php echo $this->_tpl_vars['item_data']['TEXT']; ?>

        <?php endif; ?></td>
        <td align="left"><?php echo $this->_tpl_vars['item_data']['SHORT_DESCRIPTION']; ?>
</td>
        <td align="right"><?php if ($this->_tpl_vars['item_data']['PRICE']): ?><?php echo $this->_tpl_vars['item_data']['PREFIX']; ?>
<?php echo $this->_tpl_vars['item_data']['PRICE']; ?>
<?php endif; ?></td>
      </tr>
    </table>
    <?php endforeach; endif; unset($_from); ?>
    </td>
    </tr>

<!-- /radio -->

<?php elseif ($this->_tpl_vars['options_data']['TYPE'] == '5'): ?>

<!-- checkbox -->

    <tr>
      <th><?php echo $this->_tpl_vars['options_data']['NAME']; ?>
:</th>
    </tr>
    <tr>
    <td width="100%">
    <?php $_from = $this->_tpl_vars['options_data']['DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key_data'] => $this->_tpl_vars['item_data']):
        $this->_foreach['aussen']['iteration']++;
?>
     <table width="100%" border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td width="1"><input type="checkbox" name="id[<?php echo $this->_tpl_vars['options_data']['ID']; ?>
]" value="<?php echo $this->_tpl_vars['item_data']['ID']; ?>
" /></td>
        <td width="1" valign="top"><?php if ($this->_tpl_vars['item_data']['IMAGE']): ?><img src="<?php echo $this->_tpl_vars['image_dir']; ?>
/thumbs/<?php echo $this->_tpl_vars['item_data']['IMAGE']; ?>
" width="45" height="45" alt="" style="border: 1px solid #000000"  /><?php endif; ?></td>
        <td align="left">
        <?php if ($this->_tpl_vars['item_data']['LINK']): ?>
        <a align="right" href="http://<?php echo $this->_tpl_vars['item_data']['LINK']; ?>
" target="_blank">
        <?php echo $this->_tpl_vars['item_data']['TEXT']; ?>
</a>
        <?php else: ?><?php echo $this->_tpl_vars['item_data']['TEXT']; ?>

        <?php endif; ?></td>
        <td align="left"><?php echo $this->_tpl_vars['item_data']['SHORT_DESCRIPTION']; ?>
</td>
        <td align="right"><?php if ($this->_tpl_vars['item_data']['PRICE']): ?><?php echo $this->_tpl_vars['item_data']['PREFIX']; ?>
<?php echo $this->_tpl_vars['item_data']['PRICE']; ?>
<?php endif; ?></td>
      </tr>
    </table>
    <?php endforeach; endif; unset($_from); ?>
    </td>
    </tr>

<!-- /checkbox -->

<?php elseif ($this->_tpl_vars['options_data']['TYPE'] == '6'): ?>

<!-- readonly -->
    <tr>
      <th><?php echo $this->_tpl_vars['options_data']['NAME']; ?>
:</th>
    </tr>
    <tr>
    <td width="100%">
    <?php $_from = $this->_tpl_vars['options_data']['DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key_data'] => $this->_tpl_vars['item_data']):
?>
     <table width="100%" border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td width="1">
        <input type="hidden" name="id[<?php echo $this->_tpl_vars['options_data']['ID']; ?>
]" value="<?php echo $this->_tpl_vars['item_data']['ID']; ?>
" /></td>
        <td valign="top"><?php if ($this->_tpl_vars['item_data']['MODEL']): ?>(<?php echo $this->_tpl_vars['item_data']['MODEL']; ?>
)<?php endif; ?></td>
        </tr><tr>
        <td align="left" colspan="2"><?php if ($this->_tpl_vars['item_data']['DESCRIPTION']): ?><?php echo $this->_tpl_vars['item_data']['DESCRIPTION']; ?>
<?php endif; ?></td>
        </tr><tr>
        <td align="right" colspan="2"><?php if ($this->_tpl_vars['item_data']['PRICE']): ?><?php echo $this->_tpl_vars['item_data']['PREFIX']; ?>
<?php echo $this->_tpl_vars['item_data']['PRICE']; ?>
<?php endif; ?></td>
      </tr>
    </table>
    <?php endforeach; endif; unset($_from); ?>
    </td>
    </tr>
<!-- /readonly -->

<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</table></div></div>
<?php endif; ?>