<?php

/*
Template Name: Upload Files
*/

get_header();
?>

<?php
    // Get Upload Type
    $uploaderType = $_GET['UType'];
    $uploaderID = $_GET['UID'];
    echo $uploaderType;
    echo $uploaderID;

    if (isset($_Files['upload_file_field'])) {
        echo "try2";
        $uploadName = $_FILES['upload_file_field']['name'];
        $uploadTmp = $_FILES['upload_file_field']['tmp_name'];
        $uploadType = $_FILES['upload_file_field']['type'];

        $uploadName = preg_replace("#[^a-z0-9.]#i", "", $uploadName);
        $uploadPath = "Upload/$uploaderType/$uploaderID/$uploadName";
        echo $uploadPath;

        if (!$uploadTmp) {
            die("No File Selected, Please Upload Again.");
        } else {
            move_uploaded_file($uploadTmp, $uploadPath);
        }
    }

?>
<div class="file-upload-holder">
    <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
        <label for="UploadFileField"> </label>
        <input type="file" name="upload_file_field" class="upload-file-field"/>
        <input type="submit" name="upload_button" value="Upload"/>
    </form>
</div>

<?php
get_footer();

?>
