<?php

    function create_supplier_request($createSupplierArray)
    {
        $supplierName = $createSupplierArray['supplierName'];
        $supplierType = $createSupplierArray['supplierType'];
        $priceUnit = $createSupplierArray['priceUnit'];
        $pricePerUnit = $createSupplierArray['pricePerUnit'];
        $firstContactName = $createSupplierArray['firstContactName'];
        $firstContactNumber = $createSupplierArray['firstContactNumber'];
        $secondContactName = $createSupplierArray['secondContactName'];
        $secondContactNumber = $createSupplierArray['secondContactNumber'];
        $supportLocation = $createSupplierArray['supportLocation'];
        $HSTNumber = $createSupplierArray['HSTNumber'];
        $paymentTerm = $createSupplierArray['paymentTerm'];
        $sql = "INSERT INTO suppliers (SupplierName, SupplierType, PriceUnit, PricePerUnit, FirstContactName, FirstContactNumber, SecondContactName, SecondContactNumber, SupportLocation, HSTNumber, PaymentTerm)
                        VALUES ('$supplierName', '$supplierType', '$priceUnit', '$pricePerUnit', '$firstContactName', '$firstContactNumber', '$secondContactName', '$secondContactNumber', '$supportLocation', '$HSTNumber', '$paymentTerm')";

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = myqlii_connection();

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        mysqli_close($conn);
    }

    // Get supplier Brief Info
    function get_supplier_brief_info_request($supplierType)
    {
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = myqlii_connection();

        $sql = "SELECT SupplierID, SupplierName, PricePerUnit, FirstContactName, FirstContactNumber, SupportLocation FROM suppliers WHERE SupplierType='$supplierType'";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        return $result;
    }

    // Get Supplier Detail
    function get_supplier_detail_request($supplierID)
    {
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = myqlii_connection();

        $sql = "SELECT * FROM suppliers WHERE SupplierID='$supplierID'";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        return $result;
    }

    // Edit Supplier
    function edit_supplier_request($updateSupplierArray)
    {
        $supplierID = $updateSupplierArray['supplierID'];
        $supplierName = $updateSupplierArray['supplierName'];
        $supplierType = $updateSupplierArray['supplierType'];
        $priceUnit = $updateSupplierArray['priceUnit'];
        $pricePerUnit = $updateSupplierArray['pricePerUnit'];
        $firstContactName = $updateSupplierArray['firstContactName'];
        $firstContactNumber = $updateSupplierArray['firstContactNumber'];
        $secondContactName = $updateSupplierArray['secondContactName'];
        $secondContactNumber = $updateSupplierArray['secondContactNumber'];
        $supportLocation = $updateSupplierArray['supportLocation'];
        $HSTNumber = $updateSupplierArray['HSTNumber'];
        $paymentTerm = $updateSupplierArray['paymentTerm'];

        $sql = "UPDATE suppliers SET SupplierName = '$supplierName', 
                    SupplierType = '$supplierType',
                    PriceUnit = '$priceUnit',
                    PricePerUnit = '$pricePerUnit', 
                    FirstContactName = '$firstContactName', 
                    FirstContactNumber = '$firstContactNumber',
                    SecondContactName = '$secondContactName',
                    SecondContactNumber = '$secondContactNumber',
                    SupportLocation = '$supportLocation',
                    HSTNumber = '$HSTNumber',
                    PaymentTerm = '$paymentTerm'
                    WHERE SupplierID = '$supplierID'";

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = myqlii_connection();

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        mysqli_close($conn);
    }

?>