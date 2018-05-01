<?php
/*
Plugin Name: Yandex.Metrika
Plugin URI: http://www.shopos.ru/
Description: <b>Яндекс.Метрика</b> — бесплатный инструмент для оценки посещаемости сайта, анализа поведения пользователей и эффективности рекламных кампаний.
Version: 1.0
Author: Матецкий Евгений
Author URI: http://www.shopos.ru/
*/

defined('_VALID_OS') or die('Direct Access to this location is not allowed.');

   add_action('bottom', 'head_metrika');

   function head_metrika()
   { 
       $metrika_id = get_option('metrika_id');
	   
	   if (!empty($metrika_id))
	   {
          _e('<!-- Yandex.Metrika -->');
          _e('<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript"></script>');
          _e('<script type="text/javascript">try { var yaCounter'.$metrika_id.' = new Ya.Metrika('.$metrika_id.');yaCounterID.clickmap();
yaCounterID.trackLinks({external: true}); } catch(e){}</script>');
          _e('<noscript><div style="position: absolute;"><img src="//mc.yandex.ru/watch/'.$metrika_id.'" alt="" /></div></noscript>');
          _e('<!-- /Yandex.Metrika -->');
	   }  
   }
   
   function metrika_install ()
   {
       add_option('metrika_id', '605364');
   }
?>