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
        $commissionRate = $createCaseArray['commissionRate'];
        $CaseStatus = 'OPEN';

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "INSERT INTO cases (MLS, StaffID, CoStaffID, Address, LandSize, HouseSize, PropertyType, ListingPrice, OwnerName, ContactNumber, CaseStatus, CommissionRate)
                        VALUES ('$MLSNumber', '$staffID', '$coStaffID', '$address', '$landSize', '$houseSize', '$propertyType', '$listingPrice', '$ownerName', '$contactNumber', '$CaseStatus', '$commissionRate')";

        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Check If MLS Exist
    function is_MLS_exist_request($MLS){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT * FROM cases WHERE MLS='case' LIMIT 1";
        $result = mysqli_query($conn, $sql);

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
        $commissionRate = $updateCaseArray['commissionRate'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE cases SET StaffID = '$staffID', CoStaffID = '$coStaffID',
                        Address = '$address', LandSize = '$landSize',
                        HouseSize = '$houseSize', PropertyType = '$propertyType',
                        ListingPrice = '$listingPrice', OwnerName = '$ownerName', 
                        ContactNumber = '$contactNumber', CommissionRate = '$commissionRate'
                        WHERE MLS = '$MLS'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Update Case Service ID
    function update_case_service_id_request($updateCaseServiceIDArray){
        $MLS = $updateCaseServiceIDArray['MLS'];
        $serviceID = $updateCaseServiceIDArray['serviceID'];
        $serviceSupplierType = $updateCaseServiceIDArray['serviceSupplierType'];

        if($serviceSupplierType === 'STAGING'){
            $serviceIDKey = 'StagingID';
        }else if($serviceSupplierType === 'TOUCHUP'){
            $serviceIDKey = 'TouchUpID';
        }else if($serviceSupplierType === 'CLEANUP'){
            $serviceIDKey = 'CleanUpID';
        }else if($serviceSupplierType === 'YARDWORK'){
            $serviceIDKey = 'YardWorkID';
        }else if($serviceSupplierType === 'INSPECTION'){
            $serviceIDKey = 'InspectionID';
        }else if($serviceSupplierType === 'STORAGE'){
            $serviceIDKey = 'StorageID';
        }else if($serviceSupplierType === 'RELOCATEHOME'){
            $serviceIDKey = 'RelocateHomeID';
        }else if($serviceSupplierType === 'PHOTOGRAPHY'){
            $serviceIDKey = 'PhotographyID';
        }

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE cases SET $serviceIDKey = '$serviceID'
                        WHERE MLS = '$MLS'";

        $result = mysqli_query($conn, $sql);
        return $result;
    }

    // Get Case By Service Type And ID
    function get_case_by_service_type_and_id_request($serviceType, $serviceID){
        if($serviceType === 'STAGING'){
            $serviceIDKey = 'StagingID';
        }else if($serviceType === 'TOUCHUP'){
            $serviceIDKey = 'TouchUpID';
        }else if($serviceType === 'CLEANUP'){
            $serviceIDKey = 'CleanUpID';
        }else if($serviceType === 'YARDWORK'){
            $serviceIDKey = 'YardWorkID';
        }else if($serviceType === 'INSPECTION'){
            $serviceIDKey = 'InspectionID';
        }else if($serviceType === 'STORAGE'){
            $serviceIDKey = 'StorageID';
        }else if($serviceType === 'RELOCATEHOME'){
            $serviceIDKey = 'RelocateHomeID';
        }else if($serviceType === 'PHOTOGRAPHY'){
            $serviceIDKey = 'PhotographyID';
        }

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT * FROM cases WHERE $serviceIDKey='$serviceID' LIMIT 1";

        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);

        return $result;
    }

    // Get All Closed Cases
    function get_all_closed_cases_request(){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT * FROM cases WHERE CaseStatus='CLOSED'";

        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Update Case Status And Final Price
    function update_case_status_and_final_price_request($MLS, $totalCost, $caseStatus){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE cases SET FinalPrice = '$totalCost', CaseStatus = '$caseStatus'
                        WHERE MLS = '$MLS'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

?>