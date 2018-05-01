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
    
    do_action('import_page3');
    unset( $_SESSION['log_info'] );
?>
<html>
<head>
    <title><?php echo $import->lang['page3_title']; ?></title>
    <style>
        @import url('<?php echo plugurl(); ?>import.style.css');
    </style>
    <style>
        #loading {
            position:absolute;
            top:7px;
            left:7px;
        }
    </style>
    <style>
        #div_import {
            top: 10px;
            width: 200px;
            position:absolute;
        }

        #import
        {
            color:#4169E1;
            padding:10px;
        }

        #mlog {
            top: 30px;
            border: 1px solid #B5B5B5;
            -moz-border-radius:4px;
            -webkit-border-radius:4px;
            -khtml-border-radius:4px;
			-webkit-border-radius: 4px;
			border-radius:4px;
            width: 400px;
            padding:10px;

            float:left;
            position:absolute;
            left:180px;
        }

        #log{
            position:absolute;
            left:180px;
        }
        #loading {
            position:absolute;
            top:20px;
            left:20px;
        }
    </style>
</head>
<body>    
<?php
    $_error = 'Не выбрано ни одно поле. <a class="import" href="plugins_page.php?page=import_page2">Вернуться на первый шаг.</a>';
	
    print_r($_POST);
    unset( $_SESSION['field'] );
    if (isset($_POST['field']) && isset($_POST['file_name']))
    {
        foreach ($_POST['field'] as $_num => $_value)
        {
           $v =  trim( $_value );

            if ( $v != '0') 
            {
                //сохраняем в сессию поля, которые нужно импортировать
                $_SESSION['field'][ $_POST['field_1'][ $_num ] ] = $_value;
            }
        }
		
	   //если выбранных полей нет - ошибка
	   if ( count( $_SESSION['field']) ==0 )
       {
		  die( $_error );
	   }	   	
    }
	else
	{
		die( $_error );
	}

    $_delay_log = get_option('import_delay_log');
    $_delay = get_option('import_delay');
  

    @$_SESSION['file_name'] = $import->file_name;

?>  
    <script type="text/javascript" src="includes/javascript/jquery_1.3.2.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            var inputMessage = $("#import");
            var loading = $("#loading");

            updateShoutbox();

            function updateShoutbox(){
                //just for the fade effect
                // messageList.hide('slow');
                loading.fadeIn();
                //send the post to shoutbox.php
                $.ajax({
                    type: "POST", url: "plugins_page.php?page=import_page4", data: "",
                    complete: function(data)
                    {
                        result = data.responseText;
                        loading.fadeOut();

                        if ( result == 'ok')
                            {
                            inputMessage.html( '&nbsp;' );
                            setTimeout( updateShoutbox, <?php echo $_delay;?>);
                        }
                        else
                            {
                            loading.fadeOut('slow');
                            inputMessage.html('<font color="green"><b>Импорт завершен</b></font>');
                        }
                    }
                });
            }

            //работа с логом импорта
            var mlog = $("#mlog");
            var log = $("#log");

            getLog();

            function getLog(){
                log.fadeIn();
                //send the post to shoutbox.php
                $.ajax({
                    type: "POST", url: "<?php echo http_path('catalog');?>index.php?page=import_get_log", data: "",
                    complete: function(data)
                    {
                        result = data.responseText;

                        log.fadeOut('slow');

                        if ( result != 'no')
                            {
                            mlog.html( result );
                            setTimeout( getLog, <?php echo $_delay_log;?>);
                        }
                        else
                            {
                            log.fadeOut('slow');
                        }
                    }
                });
            }

            //запускаем рестар импорта
            $("#restart").click(
            function () 
            {
                $.ajax({
                    type: "POST", url: "plugins_page.php?page=import_restart", data: "",
                    complete: function(data)
                    {
                        updateShoutbox();
                        mlog.html('');
                        getLog(); 
                    }
                });
            }
            );



        });

    </script>
<!--- импорт --->
<div id="loading"><img src="<?php echo plugurl(); ?>import.loading.gif" alt="Загрузка..." />
    <font color="green"><b>Импорт</b></font></b>
</div>
<!--- //импорт --->
<!--- лог --->
<div id="log">
    <img src="<?php echo plugurl(); ?>import.loading.gif" alt="Загрузка..." />
</div>
<!--- //лог --->
<div id="div_import">
   <div id="import"></div>
   <a id="restart" class="import">Перезапустить</a> <br />
   <a href="plugins_page.php?main_page=import_page1" class="import">Первый шаг</a>
</div>  
<div id="mlog"><i>лог</i></div> 
</body>
</html>