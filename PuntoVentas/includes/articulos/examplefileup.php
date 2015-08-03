<?php
require("fileUpload.php");
if ($_POST['submit']) {
    if (!is_array($HTTP_POST_FILES['file1'])) {
        echo "no file uploaded";
    } else {
        $upImage = new upload($HTTP_POST_FILES['file1']['name'], $HTTP_POST_FILES['file1']['tmp_name'], $HTTP_POST_FILES['file1']['size'], images);
        $upImage->fileUp();
    }
}
?>
<html>
    <head>
    </head>
    <body>
        <form name="form1" action="example.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td><input type="file" name="file1"></td>
                </tr>
                <tr>
                    <td><input name="submit" id="submit" type="submit" value="submit"></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <table>
                    </form>
                    </body>
                    </html>
