<?php
    /***************************/
    //@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
    //@website: www.yensdesign.com
    //@email: yensamg@gmail.com
    //@license: Feel free to use it, but keep this credits please!					
    /***************************/
    add_action('box', 'box_shoutbox');
    add_action('page', 'shoutbox');
    add_filter('head_array_detail', 'chat_head_array_detail', 100);

    if ( !function_exists('is_head_js') )
    {
        function is_head_js ($src,  &$_meta_array)
        { 
            if (!empty($_meta_array))
            {
                foreach ($_meta_array as $_num => $_value)
                {
                    if ( isset($_value['js']) && isset($_value['js']['src']) )
                    {
                        if (mb_strpos($_value['js']['src'], $src))
                        {
                            return true;
                        }
                    }
                }

                return false;
            }
            else
            {
                return false;
            }
        }

    }
    
    function chat_head_array_detail($array)
    {
     /*   if ( !is_head_js ('jquery', $array) )
        {
            add_js ( http_path('catalog').'jscript/jquery/jquery.js' , $array, 'jquery');
        }
*/
        return $array;
    }

    function shoutbox()
    {
        global $db;

        if(!$_POST['action'])
        {
            header ("Location: index.html"); 
        }
        else{
            switch($_POST['action'])
            { 
                case "update":
                    $res = getContent(50);

                    while($row = $db->fetch_array($res))
                    {
                        $result .= "<p><strong>".$row['user']."</strong><img src=\"".plugurl()."css/images/bullet.gif\" alt=\"-\" />".$row['message']." <span class=\"date\">".$row['date']."</span></p>";
                    }
                    echo $result;
                    break;
                case "insert":
                    echo insertMessage($_POST['nick'], $_POST['message']);
                    break;
            }
        }

    }

    function box_shoutbox()
    {
        $title = 'Чат';
        $content ='<style> @import url('.plugurl().'css/general.css);</style>';
        $content .= '<div class="shoutbox"><form method="post" id="form">
        <table border="0" width="100%">
        <tr>
        <td><label>Ваше имя</label></td>
        </tr>
        <tr>
        <td><input class="text user" id="nick" style="width:98%" type="text" MAXLENGTH="25" /></td>
        </tr>
        <tr>
        <td><label>Сообщение</label></td>
        </tr>
        <tr>
        <td><input class="text" id="message" type="text" style="width:98%" MAXLENGTH="255" /></td>
        </tr>
        <tr>
        <td style="text-align:right"><input id="send" type="submit" value="Отправить" /></td>
        </tr>
        </table>
        </form>
        <div id="container">
        <div class="content">
        <h1>Последние сообщения</h1>
        <div id="loading"><img src="'.plugurl().'css/images/loading.gif" alt="Загрузка..." /></div>
        <p>
        </div>
        </div>

        </div>
        <script type="text/javascript" src="'.plugurl().'/js/shoutbox.js"></script>';

        return array('title' => $title, 'content' =>$content);
    }

    function getContent($num)
    {
        global $db;
        $res = $db->query("SELECT date, user, message FROM ".DB_PREFIX."shoutbox ORDER BY date DESC LIMIT ".$num);
        return $res;
    }

    function insertMessage($user, $message)
    {
        global $db;
        $query = sprintf("INSERT INTO ".DB_PREFIX."shoutbox(user, message) VALUES('%s', '%s');", mysql_real_escape_string(strip_tags($user)), mysql_real_escape_string(strip_tags($message)));
        $res = $db->query($query);
        return $res;
    }


    function ajaxchat_install()
    {
        global $db;
        $db->query('drop table if exists '.DB_PREFIX.'shoutbox;');
        $db->query('CREATE TABLE `'.DB_PREFIX.'shoutbox` (`id` INT( 5 ) NOT NULL AUTO_INCREMENT ,`date` TIMESTAMP NOT NULL ,`user` VARCHAR( 25 ) NOT NULL ,`message` VARCHAR( 255 ) NOT NULL ,PRIMARY KEY ( `id` ) ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;');

    }

    function ajaxchat_remove()
    {
        global $db;
        $db->query('drop table if exists '.DB_PREFIX.'shoutbox;');
    }


?>