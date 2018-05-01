<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <link href="<?php echo plugurl(); ?>default.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo plugurl(); ?>swfupload/swfupload.js"></script>
        <script type="text/javascript" src="<?php echo plugurl(); ?>js/swfupload.queue.js"></script>
        <script type="text/javascript" src="<?php echo plugurl(); ?>js/fileprogress.js"></script>
        <script type="text/javascript" src="<?php echo plugurl(); ?>js/handlers.js"></script>
        <script type="text/javascript">


            var upload1, upload2;

            window.onload = function() {
                upload1 = new SWFUpload({
                    // Backend Settings
                    upload_url: "<?php echo http_path('catalog'); ?>admin/plugins_page.php?page=upload_file",
                    post_params: {"PHPSESSID" : "<?php echo session_id(); ?>", "lkey" : "<?php echo @$_GET['lkey'].'"'; 

                            if ( isset($_GET['products_id']) && !empty($_GET['products_id']) )
                            {
                                echo ', "products_id" : "'.$_GET['products_id'].'"'; 
                            }
                    ?>},

                    // File Upload Settings
                    file_size_limit : "2048",	// 2MB
                    file_types : "*.gif;*.jpg;*.png;*.jpe;*.jpeg",
                    file_types_description : "All Files",
                    file_upload_limit : "1000",
                    file_queue_limit : "0",

                    // Event Handler Settings (all my handlers are in the Handler.js file)
                    file_dialog_start_handler : fileDialogStart,
                    file_queued_handler : fileQueued,
                    file_queue_error_handler : fileQueueError,
                    file_dialog_complete_handler : fileDialogComplete,
                    upload_start_handler : uploadStart,
                    upload_progress_handler : uploadProgress,
                    upload_error_handler : uploadError,
                    upload_success_handler : uploadSuccess,
                    upload_complete_handler : uploadComplete,

                    // Button Settings
                    button_image_url : "<?php echo plugurl(); ?>up.png",
                    button_placeholder_id : "spanButtonPlaceholder1",
                    button_width: 61,
                    button_height: 22,

                    // Flash Settings
                    flash_url : "<?php echo plugurl(); ?>swfupload/swfupload.swf",


                    custom_settings : {
                        progressTarget : "fsUploadProgress1",
                        cancelButtonId : "btnCancel1"
                    },

                    // Debug Settings
                    debug: false
                });
            }
        </script>
    </head>
    <body>
        <?php

            if (isset ($_GET['products_id']))
            {                              
                $products_id = '&lkey='.$_GET['lkey'].'&products_id='.$_GET['products_id']; 
               ?>
                <a style="text-decoration:underline;padding-top:5px;padding-left:5px;" href="<?php echo page_admin('upload_images_edit_page').$products_id; ?>">Управление картинками</a><br />
      
               <?php


            }
            else
            {
                $products_id = '&lkey='.$_GET['lkey'];  
            }

?>
        <div id="content">
            <form id="form1" action="<?php echo plugurl(); ?>index.php" method="post" enctype="multipart/form-data">

                <table>
                    <tr valign="top">
                        <td>
                            <div>
                                <div class="fieldset flash" id="fsUploadProgress1">
                                    <span class="legend">Список загружаемых файлов</span>
                                </div>
                                <div style="padding-left: 5px;">
                                    <span id="spanButtonPlaceholder1"></span>
                                    <input id="btnCancel1" type="button" value="Отменить загрузку" onclick="cancelQueue(upload1);" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 8pt;" />
                                    <br />
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
