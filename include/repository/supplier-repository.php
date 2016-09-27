<?php
    // Require SQL Connection
    require_once(__DIR__ . '/mysql-connect.php');

    function create_supplier_repository($createSupplierArray){
        $supplierName = $createSupplierArray['supplierName'];
        $priceUnit = $createSupplierArray['priceUnit'];
        $pricePerUnit = $createSupplierArray['pricePerUnit'];
        $firstContactName = $createSupplierArray['firstContactName'];
        $firstContactNumber = $createSupplierArray['firstContactNumber'];
        $secondContactName = $createSupplierArray['secondContactName'];
        $secondContactNumber = $createSupplierArray['secondContactNumber'];
        $supportLocation = $createSupplierArray['supportLocation'];
        $HSTNumber = $createSupplierArray['HSTNumber'];
        $paymentTerm = $createSupplierArray['paymentTerm'];
        $sql = "INSERT INTO suppliers (SupplierName, PriceUnit, PricePerUnit, FirstContactName, FirstContactNumber, SecondContactName, SecondContactNumber, SupportLocation, HTSNumber, PaymentTerm)
                VALUES ('$supplierName', '$priceUnit', '$pricePerUnit', '$firstContactName', '$firstContactNumber', '$secondContactName', '$secondContactNumber', '$supportLocation', '$HSTNumber', '$paymentTerm')";

        global $conn;
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        mysqli_close($conn);
    }
?>