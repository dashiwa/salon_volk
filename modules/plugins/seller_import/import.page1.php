<?php
    include('import3.class.php');
    $import3 = new import3();
?>
<html>
<head>
    <title><?php echo $import3->lang['page1_title']; ?></title>
    <style>
        @import url('<?php echo plugurl(); ?>import.style.css');
    </style>
</head>
<body>
<form enctype="multipart/form-data" action="plugins_page.php?main_page=seller_import_page2" method="POST">
<table cellpadding="0" cellspacing="0" width="98%" style="width: 98%;">
<tr>
<td id="content">

<table cellpadding="1" border="0" style="padding-top:5px;">
<tr>
    <td><?php echo $import3->lang['page1_text1']; ?></td>
    <td><input type="file" name="csv" style="width:250px"/></td>
</tr>     
<?php
    $upload_max = (int)ini_get('upload_max_filesize');
    if ( !empty($upload_max)) {
    ?>				
    <tr>
        <td>&nbsp;</td>
        <td style="padding:0px;" valign="top"><small><i>Максимальный размер файла: <?php echo $upload_max.'Мб'; ?></i></small></td>
    </tr>
    <?php
    }
?>
<tr>
    <td><?php echo $import3->lang['page1_text2']; ?></td>
    <td>
        <select name="downloaded_file_name" style="width:250px">
            <option value="" selected></option>
            <?php

                $_file_array = os_getFiles( _IMPORT, array('.csv', '.txt', '.xls', '.xml') ) ;

                if ( !empty($_file_array) ) 
                {
                    foreach ($_file_array as $_file_info)
                    {
                        echo '<option value="'. $_file_info['id'] .'">'. $_file_info['id'] .' ('. os_format_filesize( filesize(_IMPORT.$_file_info['id']) ) .')</option>';
                    }

                }
            ?>
        </select>
    </td>
</tr>				
<tr>
    <td>&nbsp;</td>
    <td style="padding:0px;" valign="top"><small><i>media/import/</i></small></td>
</tr>	
<?php
    echo  apply_filter('import3_page1', '');


?>		
<tr>
    <td><?php echo $import3->lang['page1_text3']; ?></td>
    <td>
        <select name="delimeter">
            <option value="tab"><?php echo $import3->lang['page1_delimeter1']; ?></option>
            <option value=";" selected="on"><?php echo $import3->lang['page1_delimeter2']; ?></option>
        </select>
    </td>
</tr>
<?php
    
    global $seller;

        if ( !is_object($seller)) 
        {
            include( dir_path('catalog') .'modules/plugins/seller/seller.class.php');
            $seller = new seller();  
        } 


        $seller_array = array();
        $seller_array[] = array('text'=> 'Выбрать продавца', 'id'=>'0');

        if ( count($seller->seller) > 0 )
        {
            foreach ($seller->seller as $value)
            {
                if ( !empty( $value['products_name'] ) )
                {
                    $seller_array[] = array('text' => $value['products_name'], 'id' => $value['products_id']) ; 
                }
            }
        }

        $form =  os_draw_pull_down_menu('seller_id', $seller_array, $current_category_id, 'style="width:80%"');
?>
<tr>
  <td>Продавец</td>
  <td><?php echo $form; ?></td>
</tr>
<tr>
    <td><?php echo $import3->lang['page1_charset']; ?></td>
    <td>
        <select name="charset">
            <option value="cp1251" selected="selected">cp1251</option>
            <option value="utf-8" >utf-8</option>
        </select>
    </td>
                </tr>
            </table>
            <input type=submit value="OK">

        </form>
        </td>
        </tr>
        </table>
    </body>
</html>