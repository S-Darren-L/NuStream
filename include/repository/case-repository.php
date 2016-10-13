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

    // Get Cases Brief Info
    function get_cases_brief_info_request($agentAccountID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT MLS, StartDate, PropertyType, Address, CaseStatus FROM cases WHERE StaffID='$agentAccountID' ORDER BY StartDate";

        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);

        return $result;
    }


    // Get Case By ID
    function get_case_by_id_request($MLS){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT * FROM cases WHERE MLS='$MLS'";

        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);

        return $result;
    }

    // Update Case
    function update_case_request($updateCaseArray){
        $MLS = $updateCaseArray['MLS'];
        $staffID = $updateCaseArray['staffID'];
        $coStaffID = $updateCaseArray['coStaffID'];
        $address = $updateCaseArray['address'];
        $landSize = $updateCaseArray['landSize'];
        $houseSize = $updateCaseArray['houseSize'];
        $propertyType = $updateCaseArray['propertyType'];
        $listingPrice = $updateCaseArray['listingPrice'];
        $ownerName = $updateCaseArray['ownerName'];
        $contactNumber = $updateCaseArray['contactNumber'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE cases SET StaffID = '$staffID', CoStaffID = '$coStaffID',
                        Address = '$address', LandSize = '$landSize',
                        HouseSize = '$houseSize', PropertyType = '$propertyType',
                        ListingPrice = '$listingPrice', OwnerName = '$ownerName', ContactNumber = '$contactNumber'
                        WHERE MLS = '$MLS'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

?>