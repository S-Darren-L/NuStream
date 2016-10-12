<?php

    // Create Case
    function create_case_request($createCaseArray){
        $MLSNumber = $createCaseArray['MLSNumber'];
        $staffID = $createCaseArray['staffID'];
        $coStaffID = $createCaseArray['coStaffID'];
        $address = $createCaseArray['address'];
        $landSize = $createCaseArray['landSize'];
        $houseSize = $createCaseArray['houseSize'];
        $propertyType = $createCaseArray['propertyType'];
        $listingPrice = $createCaseArray['listingPrice'];
        $ownerName = $createCaseArray['ownerName'];
        $contactNumber = $createCaseArray['contactNumber'];
        $CaseStatus = 'OPEN';

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "INSERT INTO cases (MLS, StaffID, CoStaffID, Address, LandSize, HouseSize, PropertyType, ListingPrice, OwnerName, ContactNumber, CaseStatus)
                        VALUES ('$MLSNumber', '$staffID', '$coStaffID', '$address', '$landSize', '$houseSize', '$propertyType', '$listingPrice', '$ownerName', '$contactNumber', '$CaseStatus')";

        $result = mysqli_query($conn, $sql);

        if($result === TRUE){
            $sql = "SELECT LAST_INSERT_ID()";
            $result = mysqli_query($conn, $sql);
        }

        mysqli_close($conn);
        return $result;
}

?>