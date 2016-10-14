<?php

    // Get All Case Services ID
    function get_all_case_services_by_MLS_request($MLS){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT * FROM caseservices WHERE MLS='$MLS'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }
?>