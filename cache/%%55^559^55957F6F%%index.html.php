<?php /* Smarty version 2.6.24, created on 2017-01-13 12:44:37
         compiled from silver/index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'silver/index.html', 1, false),)), $this); ?>
﻿<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang.conf",'section' => 'index'), $this);?>

<!--[if lt IE 7]>
<script type="text/javascript" src="/js/unitpngfix/unitpngfix.js"></script>
<![endif]--> 
 
<body> 
 <div class="base">    	
	<table width="100%" cellpadding="7" cellspacing="0" border="0" class="ss_center1"> 
   <tr> 
	 
<td align="right" >
<div class="login-box">
 
 <!--Мои данные -->
<?php if ($this->_tpl_vars['account']): ?><?php if ($this->_supers['session']['customer_id']): ?>
<a href="<?php echo $this->_tpl_vars['account']; ?>
"><?php echo $this->_config[0]['vars']['link_account']; ?>
</a><span class="delm">| </span>
<?php endif; ?><?php endif; ?>
 <!--/Мои данные -->
 
 <!--Вход-->	
	<?php if ($this->_tpl_vars['account']): ?><?php if ($this->_supers['session']['customer_id']): ?>
 <a href="<?php echo $this->_tpl_vars['logoff']; ?>
"><?php echo $this->_config[0]['vars']['link_logoff']; ?>
</a>
  <?php else: ?>
 <!--<a href="<?php echo $this->_tpl_vars['login']; ?>
"><?php echo $this->_config[0]['vars']['link_login']; ?>
</a>-->
<?php endif; ?>
<?php endif; ?>   
  </div>	
  </td> 
<!--/Вход -->	
	
   </tr> 
   </table> 
 
   
   <table width="100%" cellpadding="5" cellspacing="0" border="0" class="ss_center"> 
   <tr> 
	<td align="left" width="300">
	
<!-- Лого -->
	<div class="logo"><a title="Свадебный салон Марина" href="/"><img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
img/NoLogo.jpg" alt="Свадебный салон Марина " /></a></div>
<!--/ Лого -->
	</td> 
	
	<td width="50%" valign="middle" align="left" >

 		
	</td>
   	<td width="250" valign="middle" align="left" >
Наши телефоны:<br><div class="cat_name">   (01512) 2-66-72
 <br>(029) 282-23-02 </div>
 		
	</td> 
	</table> 
   
 

<!--Хлебные крошки-->
 <table width="100%" cellpadding="0" cellspacing="0" class="ss_center"> 
    <tr> <td class="speedbar_center" align="left"><?php echo $this->_tpl_vars['navtrail']; ?>
</td> 
 <td class="speedbar_center" align="right">
 <a href="<?php echo $this->_tpl_vars['mainpage']; ?>
"><?php echo $this->_config[0]['vars']['text_mainpage']; ?>
</a><span class="delm"> |</span>
      <a href="news.php">Новости</a><span class="delm"> |</span>
	  </td>
 </tr> 
 </table> 
 <!--/Хлебные крошки-->
 
<table width="100%" class="ss_center" cellpadding="0" cellspacing="0" border=0> 
<tr valign="top"> 
	<td class="content_left" align="left"> 
	<div class="left_block"> 
<?php echo $this->_tpl_vars['box_MANUFACTURERS_INFO']; ?>

<?php echo $this->_tpl_vars['box_CATEGORIES']; ?>




<?php echo $this->_tpl_vars['box_CONTENT']; ?>


<?php echo $this->_tpl_vars['box_ADD_QUICKIE']; ?>




<?php echo $this->_tpl_vars['box_FEATURED']; ?>

<?php echo $this->_tpl_vars['box_AUTHORS']; ?>



<?php echo $this->_tpl_vars['box_ADMIN']; ?>


<?php echo $this->_tpl_vars['box_userinfo']; ?>

<?php echo $this->_tpl_vars['box_ORDER_HISTORY']; ?>


<?php echo $this->_tpl_vars['box_AFFILIATE']; ?>

<?php echo $this->_tpl_vars['box_WHATSNEW']; ?>



<?php echo $this->_tpl_vars['box_INFOBOX']; ?>





	</div> 
 
	</td><!-- /content_left --> 
 
 
	<td class="content_center" align="left"> 
 
	   <div class="center_block"> 

	   
<table width="100%" cellspacing="0" cellpadding="0" border=0> 
<tr>  <td><?php echo $this->_tpl_vars['text']; ?>
<?php echo $this->_tpl_vars['main_content']; ?>
 </td> </tr> 
</table>
    </div> 
	</td>
	<!-- /content_center -->  
</tr> 
</table>  
<!-- /page -->  
 
<table width="100%" cellpadding="0" cellspacing="0" border=0> 
<tr> 
	<td class="footer_left" align="left"><div class="copy">© 2013 marina.volk.by</div></td> 
	<td class="footer_center" align="left"> 
	   <div class="copy"> 
	  Свадебный салон Марина. Свадебные платья напрокат. Вечерние платья напрокат. Волковыск, ул.Фабричная 10
	  </div> 
	</td> 
	<td class="footer_right" align="left"> 
	   <div class="copy"> 
 тел. (01512) 2-66-72, (029) 282-23-02
	   </div> 
	</td> 
</tr> 
</table> 
<table cellspacing="10" cellpadding="0" width="100%">
<tr  align="center"><td> 
<?php echo '
<!--LiveInternet counter-->
<!--/LiveInternet-->'; ?>

</td>

</table>
</div>
</body> 
</html>