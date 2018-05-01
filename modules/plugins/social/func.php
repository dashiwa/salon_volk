<?php
/*
#####################################
#  ShopOS: Shopping Cart Software.
#  Copyright (c) 2008-2010
#  http://www.shopos.ru
#  http://www.shoposs.com
#  Ver. 1.0.0
#####################################
*/


defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

function social_send()
{
   if ($_GET['social'])
   {
      $_social = $_GET['social'];
      $_url = $_GET['url'];
      $_title = $_GET['title'];
	  
      switch ($_social)
	  {
		  
		  //LiveJournal
	      case '10':
		     os_redirect('http://www.livejournal.com/update.bml?subject='.$_title.'&event='.rawurlencode('<a href="'.$_url.'">'.$_title.'</a>'));
		  break;
		  
		  //google
	      case '11':
		     os_redirect('http://www.google.com/bookmarks/mark?op=add&bkmk='.$_url.'&title='.$_title);
		  break;		  
		  				
		  //Facebook
	      case '12':
		     os_redirect('http://www.facebook.com/sharer.php?u='.$_url.'&t='.$_title);
		  break;			  
		  
		  //Twitter
	      case '13':
		     os_redirect('http://twitter.com/home/?status='.$_url.' '.$_title);
		  break;		  
		  
		  //digg
	      case '16':
		     os_redirect('http://digg.com/submit?url='.$_url);
		  break;		  
		  
		  //delicious
	      case '17':
		     os_redirect('http://delicious.com/post?url='.$_url.'&title='.$_title);
		  break;		 
		  		  
		 //myspace
	      case '18':
		     os_redirect('http://www.myspace.com/Modules/PostTo/Pages/?l=3&u='.$_url.'&t='.$_title);
		  break;		 
		  
		  //бобрДобр
	      case '19':
		     os_redirect('http://www.bobrdobr.ru/addext.html?url='.$_url.'&title='.$_title);
		  break;			  
		  
		  //slashdot
	      case '20':
		     os_redirect('http://www.slashdot.org/bookmark.pl?url='.$_url.'&title='.$_title);
		  break;		  
		  
		  //vaau
	      case '21':
		     os_redirect('http://www.vaau.ru/submit/?action=step2&url='.$_url);
		  break;		  
		  
		  //moemesto
	      case '22':
		     os_redirect('http://moemesto.ru/post.php?url='.$_url.'&title='.$_title);
		  break;	     
		  
		  //smi2
	      case '23':
		     os_redirect('http://smi2.ru/add/?action=step2&url='.$_url);
		  break;	     
		  				 
		  //blinklis
	      case '24':
		     os_redirect('http://blinklist.com/index.php?Action=Blink/addblink.php&Url='.$_url.'&Title='.$_title);
		  break;		  
		  
		  //vkontakt
	      case '25':
		     os_redirect('http://vkontakte.ru/share.php?url='.$_url);
		  break;		  
		  
		  //yandex
	      case '26':
		     os_redirect('http://zakladki.yandex.ru/userarea/links/addfromfav.asp?bAddLink_x=1&lurl='.$_url.'&lname='.$_title);
		  break;		  
		  
		  //friendfeed
	      case '27':
		     os_redirect('http://friendfeed.com/?url='.$_url.'&title='.$_title);
		  break;		  
		  
		  //linkstore
	      case '28':
		     os_redirect('http://www.linkstore.ru/linkstore/temp.jsp?a=add&url='.$_url);
		  break;			  
		  
		  //linkedin
	      case '29':
		     os_redirect('http://www.linkedin.com/shareArticle?mini=true&url='.$_url.'&title='.$_title);
		  break;	     
		  		  
		  //memory
	      case '30':
		     os_redirect('http://memori.ru/link/?sm=1&u_data[url]='.$_url.'&u_data[name]='.$_title);
		  break;	     
		  		  
				  
		 //mister-wong
	      case '31':
		     os_redirect('http://www.mister-wong.ru/index.php?action=addurl&bm_url='.$_url.'&bm_description='.$_title);
		  break;	     
		  
		  //myscoop
	      case '33':
		     os_redirect('http://myscoop.ru/add/'.$_url);
		  break;	     
		  
		  
		  //news2
	      case '34':
		     os_redirect('http://news2.ru/add_story.php?url='.$_url);
		  break;		  	  
		  		
		  //newsvine
	      case '37':
		     os_redirect('http://www.newsvine.com/_tools/seed&save?u='.$_url.'&h='.$_title);
		  break;		  
		  
		  //propeller
	      case '38':
		     os_redirect('http://www.propeller.com/signin/?next=/story/submit/?url='.$_url);
		  break;  
		  
		  //propeller
	      case '39':
		     os_redirect('http://reddit.com/submit?url='.$_url.'&title='.$_title);
		  break;			  
		  
		  //ruspace
	      case '41':
		     os_redirect('http://www.ruspace.ru/index.php?link=bookmark&action=bookmarkNew&bm=1&url='.$_url.'&title='.$_title);
		  break;				  
		  
		  //stumbleupon
	      case '43':
		     os_redirect('http://www.stumbleupon.com/submit?url='.$_url.'&title='.$_title);
		  break;		

		  //technorati
	      case '44':
		     os_redirect('http://www.technorati.com/faves?add='.$_url);
		  break;		  
		  
		  //toodoo
	      case '46':
		     os_redirect('http://toodoo.ru/digest/discuss?dig_url='.$_url.'&comment='.$_title);
		  break;			  
		  
		  //yahoo
	      case '48':
		     os_redirect('http://myweb2.search.yahoo.com/myresults/bookmarklet?u='.$_url.'&t='.$_title);
		  break;		  
		  
		  //100zakladok
	      case '49':
		     os_redirect('http://www.100zakladok.ru/save/?bmurl='.$_url.'&bmtitle='.$_title);
		  break;		  
		  
		  //buzz
	      case '50':
		     os_redirect('http://www.google.com/reader/link?url='.$_url.'&title='.$_title);
		  break;		  
		  		  
		  //микроблоггинг qip
	      case '51':
		     os_redirect('http://mblogi.qip.ru/knopka/?url='.$_url.'&title='.$_title);
		  break;		  
		  
		  //ссылки@mail.ru
	      case '52':
		     os_redirect('http://connect.mail.ru/share?share_url='.$_url);
		  break;			  
		  
		  //liveinternet
	      case '53':
		     os_redirect('http://www.liveinternet.ru/journal_post.php?action=n_add&cnurl='.$_url.'&cntitle='.$_title);
		  break;		  

	  }
   }
   
}



function social_page()
{
   return 'index.php?page=social_send';
}



function social_head()
{
  ?>
<script language="JavaScript" type="text/javascript" src="<?php echo plugurl(); ?>js/functions.js"></script>
  <style>
#socialine {
	float:left;
	padding-top:10px;
	}
	#socialine a, 
	#socialmore a {
		float:left;
		padding:0 2px;
		cursor:pointer;
		}
		#socialine a span,
		#socialmore a span {
			display:block;
			width:16px;
			height:16px;
			line-height:16px !important;
			background:transparent url(<?php echo plugurl(); ?>images/socialicons.png) no-repeat scroll 0 0;
			}
	#socialine .separator  {
		float:left;
		line-height:16px;
		color:#aaa;
		}
	#socialine a#socbtn {
		display:block;
		width:116px;
		height:16px;
		background:transparent url(<?php echo plugurl(); ?>images/socialbutton.png) no-repeat scroll 0 0;
		}
#socialmore {
	position:absolute;
	display:none;
	width:430px;
	padding:5px;
	border:1px solid #999;
	font:10px verdana;
	color:#666;
	line-height:16px;
	z-index:1000;
	background-color:#fff;
	}
	#socialmore a {
		float:left;
		padding:1px;
		width:140px;
		height:16px;
		overflow:hidden;
		text-decoration:none;
		color:#666;
		}
	#socialmore a:hover {
		background-color:#f0f0f0;
		}
		#socialmore a span {
			float:left;
			margin-right:5px;
			}

</style>

  <?php
}

function _social_icons($url, $title)
{

   $str = '<div id="socialine">
   <a target="_blank" title="LiveJournal" href="'.social_page().'&social=10&amp;url='.$url.'&amp;title='.$title.'"><span style="background-position: 0pt -160px;"></span></a>
   <a target="_blank" title="Закладки Google" href="'.social_page().'&social=11&amp;url='.$url.'&amp;title='.$title.'"><span style="background-position: 0pt -176px;"></span></a>
   <a target="_blank" title="В Контакте" href="'.social_page().'&social=25&amp;url='.$url.'&amp;title='.$title.'"><span style="background-position: 0pt -400px;"></span></a>
   <a target="_blank" title="Facebook" href="'.social_page().'&social=12&amp;url='.$url.'&amp;title='.$title.'"><span style="background-position: 0pt -192px;"></span></a>
   <a target="_blank" title="Twitter" href="'.social_page().'&social=13&amp;url='.$url.'&amp;title='.$title.'"><span style="background-position: 0pt -208px;"></span></a>
   <a target="_blank" title="СМИ2" href="'.social_page().'&social=23&amp;url='.$url.'&amp;title='.$title.'"><span style="background-position: 0pt -368px;"></span></a>
   <a target="_blank" title="Ссылки@Mail.Ru" href="'.social_page().'&social=53&amp;url='.$url.'&amp;title='.$title.'"><span style="background-position: 0pt -832px;"></span></a>
   <a target="_blank" title="БобрДобр" href="'.social_page().'&social=19&amp;url='.$url.'&amp;title='.$title.'"><span style="background-position: 0pt -304px;"></span></a><span class="separator"> | </span>
<a title="В закладки" onclick="setfavorite(\''.$url.'\', \''.$title.'&quot;\');return false;" href=""><span style="background-position: 0pt -16px;"></span></a>
<a title="Распечатать" onclick="window.print();return false;" href=""><span style="background-position: 0pt -32px;"></span></a><span class="separator"> | </span><a onclick="return false;" onmouseout="SwitchSocials(false);" onmouseover="SwitchSocials(true);" id="socbtn" href="#"></a></div>
';
   
   return $str;
  
}
   

?>