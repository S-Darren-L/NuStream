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

    // Create Case Service
    function create_case_service_details_request($caseCaseServiceArray){
        $MLS = $caseCaseServiceArray['MLS'];
        $serviceID = $caseCaseServiceArray['serviceID'];
        $serviceSupplierType = $caseCaseServiceArray['serviceSupplierType'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "INSERT INTO caseservices (MLS, ServiceID, ServiceSupplierType)
                        VALUES ('$MLS', '$serviceID', '$serviceSupplierType')";

        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Delete Case Service By ID
    function delete_case_service_by_id_request($serviceID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "DELETE FROM caseservices WHERE ServiceID = '$serviceID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

?>