<?php
/*
Plugin Name: Редактор метатегов
Version: 1.1
Author: Матецкий Евгений
Author URI: http://www.shopos.ru/
*/

  defined('_VALID_OS') or die('Direct Access to this location is not allowed.');
  
  add_action('head', 'head_metatags');

  function head_metatags ()
  {
      if (get_option('check_meta_reply_to')=='true')
	  {
	      _e('<meta name="reply-to" content="'.get_option('meta_reply_to').'" />');
	  }
	  
      if(get_option('check_meta_robots')=='true') 
	  {
	      _e('<meta name="robots" content="'.get_option('meta_robots').'" />');
	  }
      if(get_option('check_meta_company')=='true') 
	  {
	      _e('<meta name="company" content="'.get_option('meta_company').'" />');
	  }
      if(get_option('check_meta_author')=='true') 
	  {
	      _e('<meta name="author" content="'.get_option('meta_author').'" />');
	  }

      if(get_option('check_meta_publisher')=='true') 
	  {
	      _e('<meta name="publisher" content="'.get_option('meta_publisher').'" />');
	  }
	  
      if(get_option('check_meta_distrib')=='true') 
	  {
	      _e('<meta name="distribution" content="global" />');
	  }
	  
      if(get_option('check_meta_revisit_after')=='true') 
	  {
	      _e('<meta name="revisit-after" content="'.get_option('meta_revisit_after').'" />');
	  }
	  
	  if ((get_option('check_metatags_add')=='true'))
	  {
	  $metatags_add = get_option('metatags_add');
	  if (!empty($metatags_add))
	  {
	      _e($metatags_add);
	  }
	  }

  }
  
  function metatags_install ()
  {
       add_option('check_metatags_add', 'false', 'radio', "array('true','false')");
       add_option('metatags_add', '', 'textarea');
	   
       add_option('check_meta_robots', 'false', 'radio', "array('true','false')");
       add_option('meta_robots', 'index,follow', 'input');
	   
       add_option('check_meta_author', 'false', 'radio', "array('true','false')");
       add_option('meta_author', '', 'input');

       add_option('check_meta_distrib', 'false', 'radio', "array('true', 'false')");
	   
       add_option('check_meta_reply_to', 'false', 'radio', "array('true', 'false')");
	   add_option('meta_reply_to', STORE_OWNER_EMAIL_ADDRESS, 'input');       
	   
	   add_option('check_meta_revisit_after', 'false', 'radio', "array('true', 'false')");
	   add_option('meta_revisit_after', '14', 'input');
	   
	   add_option('check_meta_publisher', 'false', 'radio', "array('true', 'false')");
	   add_option('meta_publisher', '', 'input');
	   
	   
	   add_option('check_meta_company', 'false', 'radio', "array('true', 'false')");
	   add_option('meta_company', STORE_OWNER, 'input'); 
	   
	   add_option('check_client_agent', 'true', 'radio', "array('true', 'false')");
  }
  
  if (!function_exists('os_check_agent'))
  {
      function os_check_agent()
      {
          if (get_option('check_client_agent')) 
          {
               $Robots = array ("antibot","appie","architext","bjaaland","digout4u","echo","fast-webcrawler","ferret","googlebot", "gulliver",
   "harvest","htdig","ia_archiver","jeeves","jennybot","linkwalker","lycos","mercator","moget","muscatferret","myweb","netcraft","nomad","petersnews","scooter","slurp","unlost_web_crawler","voila","voyager","webbase","weblayers","wget","wisenutbot","acme.spider","ahoythehomepagefinder","alkaline","arachnophilia","aretha","ariadne","arks","aspider","atn.txt","atomz","auresys","backrub","bigbrother","blackwidow","blindekuh","bloodhound","brightnet","bspider","cactvschemistryspider","cassandra","cgireader","checkbot","churl","cmc","collective","combine","conceptbot","coolbot","core","cosmos","cruiser","cusco","cyberspyder","deweb","dienstspider","digger","diibot","directhit","dnabot","download_express","dragonbot","dwcp","e-collector","ebiness","eit","elfinbot","emacs","emcspider","esther","evliyacelebi","nzexplorer","fdse","felix","fetchrover","fido","finnish","fireball","fouineur","francoroute","freecrawl","funnelweb","gama","gazz","gcreep","getbot","geturl","golem","grapnel","griffon","gromit","hambot","havindex","hometown","htmlgobble","hyperdecontextualizer","iajabot","ibm","iconoclast","ilse","imagelock","incywincy","informant","infoseek","infoseeksidewinder","infospider","inspectorwww","intelliagent","irobot","iron33","israelisearch","javabee","jbot","jcrawler","jobo","jobot","joebot","jubii","jumpstation","katipo","kdd","kilroy","ko_yappo_robot","labelgrabber.txt","larbin","legs","linkidator","linkscan","lockon","logo_gif","macworm","magpie","marvin","mattie","mediafox","merzscope","meshexplorer","mindcrawler","momspider","monster","motor","mwdsearch","netcarta","netmechanic","netscoop","newscan-online","nhse","northstar","occam","octopus","openfind","orb_search","packrat","pageboy","parasite","patric","pegasus","perignator","perlcrawler","phantom","piltdownman","pimptrain","pioneer","pitkow","pjspider","pka","plumtreewebaccessor","poppi","portalb","puu","python","raven","rbse","resumerobot","rhcs","roadrunner","robbie","robi","robofox","robozilla","roverbot","rules","safetynetrobot","search_au","searchprocess","senrigan","sgscout","shaggy","shaihulud","sift","simbot","site-valet","sitegrabber","sitetech","slcrawler","smartspider","snooper","solbot","spanner","speedy","spider_monkey","spiderbot","spiderline","spiderman","spiderview","spry","ssearcher","suke","suntek","sven","tach_bw","tarantula","tarspider","techbot","templeton","teoma_agent1","titin","titan","tkwww","tlspider","ucsd","udmsearch","urlck","valkyrie","victoria","visionsearch","vwbot","w3index","w3m2","wallpaper","wanderer","wapspider","webbandit","webcatcher","webcopy","webfetcher","webfoot","weblinker","webmirror","webmoose","webquest","webreader","webreaper","websnarf","webspider","webvac","webwalk","webwalker","webwatch","whatuseek","whowhere","wired-digital","wmir","wolp","wombat","worm","wwwc","wz101","xget","awbot","bobby","boris","bumblebee","cscrawler","daviesbot","ezresult","gigabot","gnodspider","internetseer","justview","linkbot","linkchecker","nederland.zoek","perman","pompos","pooodle","redalert","shoutcast","slysearch","ultraseek","webcompass","aport","yandex","stackrambler","yandexbot","robot","yahoo","bot","psbot","crawl");
               $botID = strtolower($_SERVER['HTTP_USER_AGENT']);
               $botID2 = strtolower(getenv("HTTP_USER_AGENT"));
		
               for ($i = 0; $i < count($Robots); $i++)
               {
                   if (strstr($botID, $Robots[$i]) or strstr($botID2, $Robots[$i]))
                   {
                       return 1;
                   }
               }
               return 0;
         } 
         else 
         {
               return 0;
         }
	 }
  }


?>