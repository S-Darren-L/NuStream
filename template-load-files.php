<?php

/*
Template Name: Load Images
*/

get_header();
?>

<?php
    // Start Session
    session_start();

// Get Upload Type
    $uploaderType = $_GET['UType'];
    $uploaderID = $_GET['UID'];
    $uploadPath = "wp-content/themes/NuStream/Upload/$uploaderType/$uploaderID/";

    // Upload File
    if(isset($_POST['upload_button'])){
        upload_file($uploadPath, $uploaderType, $uploaderID);
    }

    function upload_file($uploadPath, $uploaderType, $uploaderID){
        $uploadName = $_FILES['upload_file_field']['name'];
        $uploadTmp = $_FILES['upload_file_field']['tmp_name'];
        $uploadName = time() . '_' . preg_replace("#[^a-z0-9.]#i", "", $uploadName);

        $uploadType = $_FILES['upload_file_field']['type'];
//        $fileSize = $_FILES['upload_file_field']['size'];

        if(!is_dir($uploadPath)){
            mkdir($uploadPath, 0777, true);
        }

        if (!$uploadTmp) {
            die("No File Selected, Please Upload Again.");
        } else {
            $uploadResult = move_uploaded_file($uploadTmp, $uploadPath . $uploadName);
        }

        if($uploadResult){
            $setFilePathAndNameResult = set_file_path_and_name($uploaderType, $uploaderID, $uploadPath, $uploadName, $uploadType);
        }
    }

    // Gat All Files
    $downloadAllImagesResult = download_all_images($uploadPath);

    if($downloadAllImagesResult === null)
        echo 'result is null';

    $$downloadAllImagesResult_rows = [];
    while($row = mysqli_fetch_array($downloadAllImagesResult))
    {
        $downloadAllImagesResult_rows[] = $row;
    }
?>

<div class="file-upload-holder">
    <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
        <label for="UploadFileField"> </label>
        <input type="file" name="upload_file_field" class="upload-file-field"/>
        <input type="submit" name="upload_button" value="Upload"/>
    </form>
</div>

<div class="gallery-container">
    <div class="file-gallery cf">
        <?php
        $homeURL = get_home_url();
        foreach($downloadAllImagesResult_rows as $imageFileRow):
            $filePath = $imageFileRow['FileName'];
            $fileURL = $homeURL . "/" . $uploadPath . $filePath;
            echo '<div class="file-gallery-item">';
                echo '<img src="'. $fileURL .'">';
            echo '</div>';
        endforeach; ?>
    </div>
</div>
<?php
get_footer();

?>
