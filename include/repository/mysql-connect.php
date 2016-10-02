<?php
    // Open sql connection
    function myqlii_connection(){
        $conn = mysqli_connect("localhost", "root", "", "nustream");
        if ($conn->connect_error) {
            die('Connect Error (' . $conn->connect_errno . ') '
                . $conn->connect_error);
        }
        return $conn;
    }
//    else
//        echo "Open Connection";
//
//    if($conn == null)
//        echo "mysqli_connect Conn is null";
//    else
//        echo "mysqli_connect Conn is not null";
?>