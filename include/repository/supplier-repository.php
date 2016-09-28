<?php
    // Require SQL Connection
    require_once(__DIR__ . '/mysql-connect.php');

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
        $sql = "INSERT INTO suppliers (SupplierName, SupplierType, PriceUnit, PricePerUnit, FirstContactName, FirstContactNumber, SecondContactName, SecondContactNumber, SupportLocation, HTSNumber, PaymentTerm)
                    VALUES ('$supplierName', '$supplierType', '$priceUnit', '$pricePerUnit', '$firstContactName', '$firstContactNumber', '$secondContactName', '$secondContactNumber', '$supportLocation', '$HSTNumber', '$paymentTerm')";

        global $conn;
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        mysqli_close($conn);
    }

    function edit_supplier_request($createSupplierArray)
    {
        $supplierID = $createSupplierArray['supplierID'];
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
        $sql = "UPDATE suppliers SET SupplierName = '$supplierName', 
                SupplierType = '$supplierType',
                PriceUnit = '$priceUnit',
                PricePerUnit = '$pricePerUnit', 
                FirstContactName = '$firstContactName', 
                FirstContactNumber = '$firstContactNumber',
                SecondContactName = '$secondContactName',
                SecondContactNumber = '$secondContactNumber',
                SupportLocation = '$supportLocation',
                HTSNumber = '$HSTNumber',
                PaymentTerm = '$paymentTerm'
                WHERE SupplierID = '$supplierID'";

        global $conn;
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        mysqli_close($conn);
    }

    function get_supplier_brief_info_request($supplierType)
    {
        global $conn;
        $sql = "SELECT SupplierName, PricePerUnit, FirstContactNumber, SupportLocation FROM suppliers";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        return $result;
    }

?>