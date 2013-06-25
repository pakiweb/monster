<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
define('IS_IFRAME', true);
//        echo "<pre>";
//        print_r($_POST);
//        print_r($_FILES);
//        echo "</pre>";
if(!empty($_FILES)) {
        include('fileupload.php');
}
if(isset($_GET['i'])) {

        if(isset($message) && $message['success'] == 1) {
                ?>
                        <html>
                        <head></head>
                        <body>
                                <script type="text/javascript" src="templates/monstarZeug/javascript/jquery-1.6.2.min.js"></script>
                                <script type="text/javascript" >

                                        $('input[type=file]').change(function() {
                                                $('#imageupload').submit();
                                        });

                                </script>
                        </body>
                        </html>
                <?php
        } else {
                ?>
                        <html>
                        <head></head>
                        <body>
                                <form method="post" enctype='multipart/form-data' id="imageupload">
                                        <div class="the-file-wrapper">
                                                <input type="file" name="file" size="15" class="fupload" />
                                                <input type="hidden" class="the-file-id" name="image_id[<?php echo $_GET['i'];?>][]" value="-1" />
                                        </div>
                                        <div class="the-file-message">
                                                <span></span>
                                        </div>


                                        <div>
                                        <table cellpadding="0" cellspacing="0" class="the-file-image-list">

                                        </table>

                                        </div>
                                </form>
                                <script type="text/javascript" src="templates/monstarZeug/javascript/jquery-1.6.2.min.js"></script>
                                <script type="text/javascript" >

                                        $('input[type=file]').change(function() {
                                                $('#imageupload').submit();
                                        });

                                </script>
                        </body>
                        </html>
                <?php
        }

}
?>


