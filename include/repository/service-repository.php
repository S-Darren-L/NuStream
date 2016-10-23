<?php

    // Get Service Details
    function get_service_details_by_id_request($serviceID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT * FROM services WHERE ServiceID='$serviceID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Update Service Details
    function update_service_details_request($serviceArray){
        $serviceID = $serviceArray['serviceID'];
        $serviceSupplierID = $serviceArray['serviceSupplierID'];
        $realCost = $serviceArray['realCost'];
        $isActive = $serviceArray['isActive'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE services SET ServiceSupplierID = '$serviceSupplierID', RealCost = '$realCost', IsActivate = '$isActive'
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

        $sql = "UPDATE services SET ServiceSupplierID = '', RealCost = '', IsActivate = '0'
                        WHERE ServiceID = '$serviceID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Create Service Details
    function create_service_details_request($createServiceArray){
        $supplierID = $createServiceArray['serviceSupplierID'];
        $supplierType = $createServiceArray['supplierType'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "INSERT INTO services (ServiceSupplierID, SupplierType)
                        VALUES ('$supplierID', '$supplierType')";

        $result = mysqli_query($conn, $sql);

        if($result === TRUE){
            $sql = "SELECT LAST_INSERT_ID()";
            $result = mysqli_query($conn, $sql);
        }

        mysqli_close($conn);
        return $result;
    }

    // Get All Services By Status
    function get_all_services_with_file_by_status_request($serviceStatus){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        if($serviceStatus === '')
            $sql = "SELECT * FROM services WHERE IsActivate='1' AND InvoicePath!='' ORDER BY StartDate DESC ";
        else
            $sql = "SELECT * FROM services WHERE InvoiceStatus='$serviceStatus' AND IsActivate='1' AND InvoicePath!='' ORDER BY StartDate DESC ";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Update Service Invoice
    function update_service_invoice_request($serviceID, $uploadPath){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE services SET InvoicePath = '$uploadPath'
                        WHERE ServiceID = '$serviceID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Update Service Image
    function update_service_image_request($serviceID, $uploadPath){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE services SET ImagePath = '$uploadPath', RealCost = '', IsActivate = '0'
                        WHERE ServiceID = '$serviceID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Update Service Status
    function update_service_status_request($serviceID, $invoiceStatus){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE services SET InvoiceStatus = '$invoiceStatus'
                        WHERE ServiceID = '$serviceID' AND IsActivate='1'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }
?>