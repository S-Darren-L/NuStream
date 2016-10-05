<?php

    // Set File Path And Name
    function set_file_path_and_name_request($uploaderType, $uploaderID, $uploadPath, $uploadName, $uploadType){
        switch ($uploaderType) {
            case Supplier:
                $table = "suppliers";
                break;
            default:
                $result = false;
        }

        switch ($uploadType) {
            case "image/jpeg":
                $uploadType = "IMAGE";
                break;
            default:
                $result = false;
        }

        $sql = "INSERT INTO files (FilePath, FileName, FileType)
                            VALUES ('$uploadPath', '$uploadName', '$uploadType')";

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = myqlii_connection();
        $result = mysqli_query($conn, $sql);

        if($result){
            $sql = "UPDATE $table SET FilePath = '$uploadPath'
                            WHERE SupplierID = '$uploaderID'";

            // Require SQL Connection
            require_once(__DIR__ . '/mysql-connect.php');
            $conn = myqlii_connection();
            $result = mysqli_query($conn, $sql);
        }
        return $result;
    }

    // Get All Images
    function download_all_images_request($uploadPath){
        $sql = "SELECT FileName FROM files WHERE FilePath='$uploadPath' AND FileType='IMAGE'";

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = myqlii_connection();
        $result = mysqli_query($conn, $sql);

        return $result;
    }
?>