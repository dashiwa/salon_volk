<?php
/*
Plugin Name: Голосование
Plugin URI: http://www.shopos.ru/
Version: 1.0
Author: Матецкий Евгений
Author URI: http://www.shopos.ru/
*/

defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

  add_action('box', 'box_vote');
  add_action('page', 'page_vote');
  add_action('head', 'head_vote');
  
  function box_vote ()
  {
      $vote_name = get_option('vote_name');
      $vote_value = get_option('vote_values');
	  $vote_array = explode("\n", $vote_value); 
	  $title = get_option('vote_title');
	  
	  //результат голосования
	  $vote_result = get_option('vote_result');
      $vote_result = explode(";", $vote_result);
	  
	  $content = '';
	  $content .= '<div class="os_vote">';
	  $content .= '<div class="os_vote_name">'.$vote_name.'</div>';
	  
	  if (!isset($_SESSION['vote']))
	  {
   
	           $content .= '<form action="'.HTTP_SERVER.DIR_WS_CATALOG.'index.php?page=page_vote" method="post">';
	           $content .= '<table border="0">';
	  
	           if (!empty($vote_array))
	           {
	                 $num = 0;
	                 foreach ($vote_array as $vote_value)
		             {
		                  $num ++;
						  if ($num == 1)
						  {
		                        $content .= '<tr><td><input type="radio" checked id="answer'.$num.'" name="answer" value="'.$num.'" /></td><td>&nbsp;<label for="answer'.$num.'">'.$vote_value.'</label></td></tr>';
						  }
                          else
                          {
						  		$content .= '<tr><td><input type="radio" id="answer'.$num.'" name="answer" value="'.$num.'" /></td><td>&nbsp;<label for="answer'.$num.'">'.$vote_value.'</label></td></tr>';
						  }						  
		             }
	           }
	  
	           $content .= '</table>';
	           $content .= '<div class="button_submit"><input type="submit" value=" OK " /></div>';
               $content .= '</form>';
		
	  }
	  else
	  {

		 $result = array();
		 
		 //определение общее кол. голосов
		for ($i=0; $i<count($vote_result);$i++)
		{
		    @$sum = $sum+$vote_result[$i]  ;
		}

		 for ($i=1; $i<=count($vote_result);$i++)
		 {
		    $c = $i-1;
			
			if ($vote_result[$c] == 0) 
			{
			   $result[$c] = '0 %';
			}
			else
			{
			   $result[$c] = (round(($vote_result[$c]/$sum)*100)).' %';
			}
		 }
		 
		  $content .= '<table>';
		  
	      for ($i =0;$i<=count($vote_array);$i++)
		   {

		     @ $content .= '<tr><td>'.$vote_array[$i].'</td><td width="30px">'.$result[$i].'</td></tr>';
		   }
		   
		   $content .='</table>';

	  }
      $content .= '</div>';
	  
	  return array('title' => $title, 'content' =>$content);
  }
  
  function head_vote()
  {
       //вывод стилей блока
       _e('<!--vote--><style type="text/css">.os_vote_name{font-weight:bold;}</style><!--/vote-->');
  }
  
  
  function vote_install ()
  {
      add_option('vote_title', 'Голосование');
      add_option('vote_name', 'Вы хотите принять участие в нашем опросе?');
      add_option('vote_values', "Да, с удовольствием\nУ меня времени нет\nЯ никогда не участвую в опросах", 'textarea');
      add_option('vote_result', '0;0;0', 'readonly');
  }
  
  function vote_result_readonly($value)
  {
     // $vote_result = get_option('vote_result');
      $vote_result = explode(";", $value); 
	  
	  	 $result = array();
		 $sum  = '';
		 //определение общее кол. голосов
		for ($i=0; $i<count($vote_result);$i++)
		{
		    $sum = $sum+$vote_result[$i]  ;
		}

		 for ($i=1; $i<=count($vote_result);$i++)
		 {
		    $c = $i-1;
			
			if ($vote_result[$c] == 0) 
			{
			   $result[$c] = '0 %';
			}
			else
			{
			   $result[$c] = (round(($vote_result[$c]/$sum)*100)).' %';
			}
		 }
		 
	  foreach ($result as $_num => $_val)	
      {
	      _e($_num.': '.$_val.'<br>');
	  }	  
	  
	  global $p;
  }
  
  function page_vote ()
  {

      if (isset($_POST['answer']) && is_numeric($_POST['answer']))
	  {
	      if (!isset($_SESSION['vote']))
		  {
               $vote_value = get_option('vote_values');
               $vote_array = explode("\n", $vote_value);
		  
		 
               $vote_result = get_option('vote_result');
               $vote_result = explode(";", $vote_result);
	           $vote_cole = count($vote_array);
		 
		       //если кол. вариантов ответов не соответствует с результатами - обнуляются результаты.
		       
			   if (count($vote_array) !=  count($vote_result))
		       {
		             unset($vote_result);
		             foreach ($vote_array as $_n=>$_m)
			         {
			              $vote_result[$_n] = 0;
			         }
		       }
		  
		       $_POST['answer']--;
		  
		       if ($_POST['answer'] >= 0 && ($_POST['answer']<=$vote_cole))
		       {
		           $vote_result[$_POST['answer']]++;
		       }
		  
		       $vote_result = implode(';', $vote_result);  
               update_option ('vote_result', $vote_result);
		       $_SESSION['vote'] = '1';
                os_redirect(os_href_link('index.php'));
		         //echo 'Голос учтен<br>';
          }
		  else
		  {  
             os_redirect(os_href_link('index.php'));
		     //echo 'Голос не учтен. Вы уже голосовали.';
		  }
	  }
  }
  
?>