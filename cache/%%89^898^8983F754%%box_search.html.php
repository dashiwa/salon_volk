<?php /* Smarty version 2.6.24, created on 2017-01-13 12:44:37
         compiled from silver/boxes/box_search.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/boxes/box_search.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'boxes'), $this);?>

<?php echo $this->_tpl_vars['FORM_ACTION']; ?>

<table border="0" width="390px" >
<tr ><td height="3px" ></td></tr >
<tr >
<td width="40px" align="right" >
<?php echo $this->_config[0]['vars']['heading_search']; ?>

</td>
<td>
<input type="text" size=50 name="keywords" onkeyup="ajaxQuickFindUp(this);" id="quick_find_keyword" />
</td>
<td width="50px">
<?php echo $this->_tpl_vars['BUTTON_SUBMIT']; ?>

</td>
 <!--<td valign="middle" align="center" width="100%">
 <a href="<?php echo $this->_tpl_vars['LINK_ADVANCED']; ?>
" style="color: #ffffff;"> <?php echo $this->_config[0]['vars']['text_advanced_search']; ?>
 </a>
 </td>-->
</tr>
</table>
<?php echo $this->_tpl_vars['FORM_END']; ?>

         
<!--		 
			 <div class="leftmenu"> 
				<ul class="list">

            <table width="70%"  border="0" cellpadding="2" cellspacing="0">
              <tr>
                <td valign="middle"><?php echo $this->_tpl_vars['INPUT_SEARCH']; ?>
</td>
                <td valign="middle" ><?php echo $this->_tpl_vars['BUTTON_SUBMIT']; ?>
</td>
                <td valign="middle" width="100%"> <a href="<?php echo $this->_tpl_vars['LINK_ADVANCED']; ?>
"> <?php echo $this->_config[0]['vars']['text_advanced_search']; ?>
 </a></td>
			  </tr>
              
            </table>
            
    
		       </ul>
			 </div> 
	  
		

<?php echo $this->_tpl_vars['FORM_END']; ?>

-->	
<?php echo '
<script language="javascript" type="text/javascript">
	function ajaxQuickFind(elt) {
//		if(ajaxQuickFindUpForm.keywords.value.length > 2)
			loadXMLDoc(\'ajaxQuickFind\', hashFormFields(ajaxQuickFindUpForm), true);
	}
	var timeout = null;
	var ajaxQuickFindUpForm = null;
	function ajaxQuickFindUp(elt) {
		ajaxQuickFindUpForm = elt.form;
	  if (timeout) clearTimeout(timeout);
	  timeout = setTimeout(\'ajaxQuickFind()\', 500);
	}
</script>
'; ?>