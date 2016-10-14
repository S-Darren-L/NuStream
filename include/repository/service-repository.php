<?php

    // Get Service Details
    function get_service_details_by_id_request($serviceID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT * FROM cases WHERE ServiceID='$serviceID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Update Service Details
    function update_service_details_request($serviceArray){
        $serviceID = $serviceArray['serviceID'];
        $serviceSupplierID = $serviceArray['serviceSupplierID'];
        $supplierType = $serviceArray['supplierType'];
        $realCost = $serviceArray['realCost'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE services SET ServiceSupplierID = '$serviceSupplierID', SupplierType = '$supplierType', RealCost = '$realCost'
                        WHERE ServiceID = '$serviceID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Delete Service By ID
    function delete_service_by_id_request($serviceID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "DELETE FROM services WHERE ServiceID = '$serviceID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

?>