<?php

    // Start Session
    session_start();

    /*
    Template Name: Load Files
    */

    get_header();
?>

<?php
// Get Upload Type
    $uploaderType = $_GET['UType'];
    $uploaderID = $_GET['UID'];
    $uploadPath = "wp-content/themes/NuStream/Upload/$uploaderType/$uploaderID/";
    $homeURL = get_home_url();

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
    $downloadAllFilesResult = download_all_files($uploadPath);

    if($downloadAllFilesResult === null)
        echo 'result is null';

    $$downloadAllFilesResult_rows = [];
    while($row = mysqli_fetch_array($downloadAllFilesResult))
    {
        $downloadAllFilesResult_rows[] = $row;
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
        if(!is_null($downloadAllFilesResult_rows)){
            foreach($downloadAllFilesResult_rows as $fileRow):
                $filePath = $fileRow['FileName'];
                $fileURL = $homeURL . "/" . $uploadPath . $filePath;
                echo '<div class="file-gallery-item">';
                echo '<img src="'. $fileURL .'">';
                echo '</div>';
            endforeach;}
        ?>
    </div>
</div>
<?php
get_footer();

?>
