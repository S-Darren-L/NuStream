<?php

    // Set File Path And Name
    function set_file_path_and_name_request($uploadPath, $uploadName){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $uploadName = $uploadPath . $uploadName;
        $sql = "INSERT INTO files (FilePath, FileName)
                            VALUES ('$uploadPath', '$uploadName')";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Get All Images
    function download_all_files_by_path_request($uploadPath){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT FileName FROM files WHERE FilePath='$uploadPath'";

        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Get File
    function download_file_by_path_request($uploadPath){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT FileName FROM files WHERE FilePath='$uploadPath' LIMIT 1";

        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Remove FIle By Name
    function remove_file_by_name_request($fileName){

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "DELETE FROM files WHERE FileName='$fileName' AND FileStatus!= 'Approved' LIMIT 1";

        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }
?>