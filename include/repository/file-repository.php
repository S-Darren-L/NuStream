<?php

    // Set File Path And Name
    function set_file_path_and_name_request($uploaderType, $uploaderID, $uploadPath, $uploadName){
        switch ($uploaderType) {
            case Supplier:
                $table = "suppliers";
                break;
            default:
                $result = false;
        }

//        switch ($uploadType) {
//            case "image/jpeg":
//                $uploadType = "IMAGE";
//                break;
//            default:
//                $result = false;
//        }

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "INSERT INTO files (FilePath, FileName)
                            VALUES ('$uploadPath', '$uploadName')";
        $result = mysqli_query($conn, $sql);

        if($result){
            $sql = "UPDATE $table SET FilePath = '$uploadPath'
                            WHERE SupplierID = '$uploaderID'";
            $result = mysqli_query($conn, $sql);
        }

        mysqli_close($conn);
        return $result;
    }

    // Get All Images
    function download_all_files_by_path_request($uploadPath){
        $sql = "SELECT FileName FROM files WHERE FilePath='$uploadPath' AND FileType='IMAGE'";

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }
?>