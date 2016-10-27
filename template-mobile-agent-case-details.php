<?php

// Start Session
session_start();

/*
Template Name: Agent Mobile Case Details
*/

    // Get Case ID
    $MLS = $_GET['CID'];
    $isRefreshPage = $_GET['RF'];
    $uploadPageURL = get_home_url() . '/agent-mobile-case-file-upload/?CID=' . $MLS;
    $uploadPath = get_home_url() . "/wp-content/themes/NuStream/Upload/Services/";
    $houseImageURL =  get_home_url() . "/wp-content/themes/NuStream/Upload/case/" . $MLS . "/HouseImage/";
    $uploadBasePath = "wp-content/themes/NuStream/Upload/case/" . $MLS;
    $defaultHouseImageURL =  get_home_url() . "/wp-content/themes/NuStream/img/house.jpg";

    // Init Date
    // Get Case Statuses
    $caseStatuses = get_case_statuses();

    // Get Case Basic Details
    $caseDetailsArray = array();
    $caseDetailsArray = get_case_basic_details($MLS);
    $isCaseChangeable = $caseDetailsArray['CaseStatus'] === 'CLOSED' ? 'hidden' : null;

    // Get All Suppliers Brief Info
    $allSuppliersArray = array(); // supplier table
    $allSuppliersArray = get_all_suppliers_brief_info();

    // Get All Services Info
    $stagingServiceArray = array();
    $stagingServiceArray = get_service_detail($caseDetailsArray['StagingID']);
    $touchUpServiceArray = array();
    $touchUpServiceArray = get_service_detail($caseDetailsArray['TouchUpID']);
    $cleanUpServiceArray = array();
    $cleanUpServiceArray = get_service_detail($caseDetailsArray['CleanUpID']);
    $yardWorkServiceArray = array();
    $yardWorkServiceArray = get_service_detail($caseDetailsArray['YardWorkID']);
    $inspectionServiceArray = array();
    $inspectionServiceArray = get_service_detail($caseDetailsArray['InspectionID']);
    $storageServiceArray = array();
    $storageServiceArray = get_service_detail($caseDetailsArray['StorageID']);
    $relocateHomeServiceArray = array();
    $relocateHomeServiceArray = get_service_detail($caseDetailsArray['RelocateHomeID']);
    $photographyServiceArray = array();
    $photographyServiceArray = get_service_detail($caseDetailsArray['PhotographyID']);

    // Get Estimate Service Price
    get_estimate_service_price();

    // Get Team Data
    $teamID = $_SESSION['TeamID'];
    $staffID = $_SESSION['AccountID'];
    $teamResult = mysqli_fetch_array(get_team_by_team_id($teamID));
    $teamLeaderID = $teamResult['TeamLeaderID'];
    $teamLeaderName = $teamResult['TeamLeaderName'];
    $isCaseStatusChangeable = $teamLeaderID === $_SESSION['AccountID'] ? null : 'disabled';

    // Get Case Basic Details
    function get_case_basic_details($MLS){
        $getCaseResult = get_case_by_id($MLS);
        if($getCaseResult !== null){
            $caseDetailsArray = mysqli_fetch_array($getCaseResult);
        }
        else{
            echo die("Cannot find account");
        }
        $getCoStaffResult = get_agent_account($caseDetailsArray['CoStaffID']);
        if($getCoStaffResult !== null){
            $coStaffArray = mysqli_fetch_array($getCoStaffResult);
            $caseDetailsArray['CoStaffName'] = $coStaffArray['FirstName'] . " " . $coStaffArray['LastName'];
        }
        return $caseDetailsArray;
    }
    // Get All Suppliers Brief Info
    function get_all_suppliers_brief_info(){
        $supplierTypes = get_supplier_types();
        foreach ($supplierTypes as $supplierType){
            $supplierResult = get_no_default_supplier_brief_info($supplierType);

            if($supplierResult === null)
                echo 'result is null';
            $supplierArray = array();
            while($row = mysqli_fetch_array($supplierResult))
            {
                $supplierArray[] = $row;
            }
            $allSuppliersArray[$supplierType] = $supplierArray;
        }
        return $allSuppliersArray;
    }

    // Get Service Details By ID
    function get_service_detail($serviceID){
        global $isRefreshPage;
        $serviceDetailsResult = get_service_details_by_id($serviceID);
        $serviceDetailsArray = mysqli_fetch_array($serviceDetailsResult);
        $serviceDetailsArray['IsDisabled'] = $serviceDetailsArray['InvoiceStatus'] === 'APPROVED' ? 'disabled' : null;
        if($serviceDetailsArray['InvoiceStatus'] === 'APPROVED'){
            $serviceDetailsArray['IsChecked'] = $serviceDetailsArray['IsActivate'] === '1' ? 'checked' : null;
        }else{
            $isActive = $isRefreshPage === 'true' ? $_SESSION['CaseEstimate'][$serviceID]['isServiceChecked'] : $serviceDetailsArray['IsActivate'];
            if($isActive === 'checked'){
                $isActive = '1';
            }
            $serviceDetailsArray['IsChecked'] = $isActive === '1' ? 'checked' : null;
            if($isRefreshPage === 'true'){
                $serviceDetailsArray['ServiceSupplierID'] = $_SESSION['CaseEstimate'][$serviceID]['supplierID'];
                $serviceDetailsArray['RealCost'] = $_SESSION['CaseEstimate'][$serviceID]['serviceRealCost'];
            }
        }
        return $serviceDetailsArray;
    }

    // Get Estimate Service Price
    function get_estimate_service_price(){
        global $stagingEstimatePrice;
        global $touchUpEstimatePrice;
        global $cleanUpEstimatePrice;
        global $yardWordEstimatePrice;
        global $inspectionEstimatePrice;
        global $storageEstimatePrice;
        global $relocateHomeEstimatePrice;
        global $photographyEstimatePrice;

        global $isStagingChecked;
        global $isTouchUpChecked;
        global $isCleanUpChecked;
        global $isYardWordChecked;
        global $isInspectionChecked;
        global $isStorageChecked;
        global $isRelocateHomeChecked;
        global $isPhotographyChecked;

        global $caseDetailsArray;

        global $stagingServiceArray;
        global $touchUpServiceArray;
        global $cleanUpServiceArray;
        global $yardWorkServiceArray;
        global $inspectionServiceArray;
        global $storageServiceArray;
        global $relocateHomeServiceArray;
        global $photographyServiceArray;

        if(!isset($_POST['submit_service_info']) && !isset($_POST['estimate'])){
            $isStagingChecked = $stagingServiceArray['IsChecked'];
            $isTouchUpChecked = $touchUpServiceArray['IsChecked'];
            $isCleanUpChecked = $cleanUpServiceArray['IsChecked'];
            $isYardWordChecked = $yardWorkServiceArray['IsChecked'];
            $isInspectionChecked = $inspectionServiceArray['IsChecked'];
            $isStorageChecked = $storageServiceArray['IsChecked'];
            $isRelocateHomeChecked = $relocateHomeServiceArray['IsChecked'];
            $isPhotographyChecked = $photographyServiceArray['IsChecked'];

            $stagingSupplierID = $stagingServiceArray['ServiceSupplierID'];
            $touchUpSupplierID = $touchUpServiceArray['ServiceSupplierID'];
            $cleanUpSupplierID = $cleanUpServiceArray['ServiceSupplierID'];
            $yardWordSupplierID = $yardWorkServiceArray['ServiceSupplierID'];
            $inspectionSupplierID = $inspectionServiceArray['ServiceSupplierID'];
            $storageSupplierID = $storageServiceArray['ServiceSupplierID'];
            $relocateHomeSupplierID = $relocateHomeServiceArray['ServiceSupplierID'];
            $photographySupplierID = $photographyServiceArray['ServiceSupplierID'];
        }else{
            $isStagingChecked = $_POST['stagingCheckbox'];
            $isTouchUpChecked = $_POST['touchUpCheckbox'];
            $isCleanUpChecked = $_POST['cleanUpCheckbox'];
            $isYardWordChecked = $_POST['yardWorkCheckbox'];
            $isInspectionChecked = $_POST['inspectionCheckbox'];
            $isStorageChecked = $_POST['storageCheckbox'];
            $isRelocateHomeChecked = $_POST['relocateHomeCheckbox'];
            $isPhotographyChecked = $_POST['photographyCheckbox'];

            $stagingSupplierID = $_POST['stagingSelect'];
            $touchUpSupplierID = $_POST['touchUpSelect'];
            $cleanUpSupplierID = $_POST['cleanUpSelect'];
            $yardWordSupplierID = $_POST['yardWorkSelect'];
            $inspectionSupplierID = $_POST['inspectionSelect'];
            $storageSupplierID = $_POST['storageSelect'];
            $relocateHomeSupplierID = $_POST['relocateHomeSelect'];
            $photographySupplierID = $_POST['photographySelect'];
        }

        if($isStagingChecked === 'checked'){
            $stagingEstimatePrice = staging_price_estimate_by_id($caseDetailsArray['HouseSize'], $stagingSupplierID);
        }else{
            $stagingEstimatePrice = 0;
        }
        if($isTouchUpChecked === 'checked'){
            $touchUpEstimatePrice = touch_up_price_estimate_by_id($touchUpSupplierID);
        }else{
            $touchUpEstimatePrice = 0;
        }
        if($isCleanUpChecked === 'checked'){
            $cleanUpEstimatePrice = clean_up_price_estimate_by_id($caseDetailsArray['HouseSize'], $cleanUpSupplierID);
        }else{
            $cleanUpEstimatePrice = 0;
        }
        if($isYardWordChecked === 'checked'){
            $yardWordEstimatePrice = yard_work_price_estimate_by_id($yardWordSupplierID);
        }else{
            $yardWordEstimatePrice = 0;
        }
        if($isInspectionChecked === 'checked'){
            $inspectionEstimatePrice = inspection_price_estimate_by_id($caseDetailsArray['PropertyType'], $inspectionSupplierID);
        }else{
            $inspectionEstimatePrice = 0;
        }
        if($isStorageChecked === 'checked'){
            $storageEstimatePrice = storage_price_estimate_by_id($storageSupplierID);
        }else{
            $storageEstimatePrice = 0;
        }
        if($isRelocateHomeChecked === 'checked'){
            $relocateHomeEstimatePrice = relocate_home_price_estimate_by_id($relocateHomeSupplierID);
        }else{
            $relocateHomeEstimatePrice = 0;
        }
        if($isPhotographyChecked === 'checked'){
            $photographyEstimatePrice = photography_price_estimate_by_id($caseDetailsArray['PropertyType'], $photographySupplierID);
        }else{
            $photographyEstimatePrice = 0;
        }

        // Estimate Total Cost And Commission
        global $totalCost;
        if($stagingServiceArray['IsChecked'] === 'checked'){
            $totalCost = $totalCost + ($stagingServiceArray['RealCost'] !== '0' ? $stagingServiceArray['RealCost'] : $stagingEstimatePrice);
        }
        if($touchUpServiceArray['IsChecked'] === 'checked'){
            $totalCost = $totalCost + ($touchUpServiceArray['RealCost'] !== '0' ? $touchUpServiceArray['RealCost'] : $touchUpEstimatePrice);
        }
        if($cleanUpServiceArray['IsChecked'] === 'checked'){
            $totalCost = $totalCost + ($cleanUpServiceArray['RealCost'] !== '0' ? $cleanUpServiceArray['RealCost'] : $cleanUpEstimatePrice);
        }
        if($yardWorkServiceArray['IsChecked'] === 'checked'){
            $totalCost = $totalCost + ($yardWorkServiceArray['RealCost'] !== '0' ? $yardWorkServiceArray['RealCost'] : $yardWordEstimatePrice);
        }
        if($inspectionServiceArray['IsChecked'] === 'checked'){
            $totalCost = $totalCost + ($inspectionServiceArray['RealCost'] !== '0' ? $inspectionServiceArray['RealCost'] : $inspectionEstimatePrice);
        }
        if($storageServiceArray['IsChecked'] === 'checked'){
            $totalCost = $totalCost + ($storageServiceArray['RealCost'] !== '0' ? $storageServiceArray['RealCost'] : $storageEstimatePrice);
        }
        if($relocateHomeServiceArray['IsChecked'] === 'checked'){
            $totalCost = $totalCost + ($relocateHomeServiceArray['RealCost'] !== '0' ? $relocateHomeServiceArray['RealCost'] : $relocateHomeEstimatePrice);
        }
        if($photographyServiceArray['IsChecked'] === 'checked'){
            $totalCost = $totalCost + ($photographyServiceArray['RealCost'] !== '0' ? $photographyServiceArray['RealCost'] : $isPhotographyChecked);
        }
        global $finalCommission;
        $finalCommission = $caseDetailsArray['ListingPrice'] * $caseDetailsArray['CommissionRate'] * 0.01 - $totalCost;
    }

    // Save Session
    function save_session(){
        global $caseDetailsArray;
        $_SESSION['CaseEstimate'] = array(
            $caseDetailsArray['StagingID'] => array(
                "isServiceChecked" => $_POST['stagingCheckbox'],
                "supplierID" => $_POST['stagingSelect'],
                "serviceRealCost" => $_POST['stagingRealCost']
            ),
            $caseDetailsArray['TouchUpID'] => array(
                "isServiceChecked" => $_POST['touchUpCheckbox'],
                "supplierID" => $_POST['touchUpSelect'],
                "serviceRealCost" => $_POST['touchUpRealCost']
            ),
            $caseDetailsArray['CleanUpID'] => array(
                "isServiceChecked" => $_POST['cleanUpCheckbox'],
                "supplierID" => $_POST['cleanUpSelect'],
                "serviceRealCost" => $_POST['cleanUpRealCost']
            ),
            $caseDetailsArray['YardWorkID'] => array(
                "isServiceChecked" => $_POST['yardWorkCheckbox'],
                "supplierID" => $_POST['yardWorkSelect'],
                "serviceRealCost" => $_POST['yardWorkRealCost']
            ),
            $caseDetailsArray['InspectionID'] => array(
                "isServiceChecked" => $_POST['inspectionCheckbox'],
                "supplierID" => $_POST['inspectionSelect'],
                "serviceRealCost" => $_POST['inspectionRealCost']
            ),
            $caseDetailsArray['StorageID'] => array(
                "isServiceChecked" => $_POST['storageCheckbox'],
                "supplierID" => $_POST['storageSelect'],
                "serviceRealCost" => $_POST['storageRealCost']
            ),
            $caseDetailsArray['RelocateHomeID'] => array(
                "isServiceChecked" => $_POST['relocateHomeCheckbox'],
                "supplierID" => $_POST['relocateHomeSelect'],
                "serviceRealCost" => $_POST['relocateHomeRealCost']
            ),
            $caseDetailsArray['PhotographyID'] => array(
                "isServiceChecked" => $_POST['photographyCheckbox'],
                "supplierID" => $_POST['photographySelect'],
                "serviceRealCost" => $_POST['photographyRealCost']
            )
        );
    }

    // Submit Services Info
    if(isset($_POST['submit_service_info'])) {
        global $totalCost;
        // Staging
        if($stagingServiceArray['IsDisabled'] === 'disabled'){
            $isStagingEnabled = $stagingServiceArray['IsChecked'] === 'checked' ? '1' : '0';
            $stagingSupplierID = $stagingServiceArray['ServiceSupplierID'];
        }else{
            $isStagingEnabled = $_POST['stagingCheckbox'] === 'checked' ? '1' : '0';
            $stagingSupplierID = $_POST['stagingSelect'];
        }
        $stagingServiceID = $stagingServiceArray['ServiceID'];
        $stagingRealCost = $_POST['stagingRealCost'];
        update_service_info($isStagingEnabled, $stagingSupplierID, $stagingServiceID, $stagingRealCost);
        // Touch up
        if($touchUpServiceArray['IsDisabled'] === 'disabled'){
            $isTouchUpEnabled = $touchUpServiceArray['IsChecked'] === 'checked' ? '1' : '0';
            $touchUpSupplierID = $touchUpServiceArray['ServiceSupplierID'];
        }else{
            $isTouchUpEnabled = $_POST['touchUpCheckbox'] === 'checked' ? '1' : '0';
            $touchUpSupplierID = $_POST['touchUpSelect'];
        }
        $touchUpServiceID = $touchUpServiceArray['ServiceID'];
        $touchUpRealCost = $_POST['touchUpRealCost'];
        update_service_info($isTouchUpEnabled, $touchUpSupplierID, $touchUpServiceID, $touchUpRealCost);
        // Clean up
        if($cleanUpServiceArray['IsDisabled'] === 'disabled'){
            $isCleanUpEnabled = $cleanUpServiceArray['IsChecked'] === 'checked' ? '1' : 0;
            $cleanUpSupplierID = $cleanUpServiceArray['ServiceSupplierID'];
        }else{
            $isCleanUpEnabled = $_POST['cleanUpCheckbox'] === 'checked' ? '1' : '0';
            $cleanUpSupplierID = $_POST['cleanUpSelect'];
        }
        $cleanUpServiceID = $cleanUpServiceArray['ServiceID'];
        $cleanUpRealCost = $_POST['cleanUpRealCost'];
        update_service_info($isCleanUpEnabled, $cleanUpSupplierID, $cleanUpServiceID, $cleanUpRealCost);
        // Yard work
        if($yardWorkServiceArray['IsDisabled'] === 'disabled'){
            $isYardWorkEnabled = $yardWorkServiceArray['IsChecked'] === 'checked' ? '1' : '0';
            $yardWorkSupplierID = $yardWorkServiceArray['ServiceSupplierID'];
        }else{
            $isYardWorkEnabled = $_POST['yardWorkCheckbox'] === 'checked' ? '1' : '0';
            $yardWorkSupplierID = $_POST['yardWorkSelect'];
        }
        $yardWorkServiceID = $yardWorkServiceArray['ServiceID'];
        $yardWorkRealCost = $_POST['yardWorkRealCost'];
        update_service_info($isYardWorkEnabled, $yardWorkSupplierID, $yardWorkServiceID, $yardWorkRealCost);
        // Inspection
        if($inspectionServiceArray['IsDisabled'] === 'disabled'){
            $isInspectionEnabled = $inspectionServiceArray['IsChecked'] === 'checked' ? '1' : '0';
            $inspectionSupplierID = $inspectionServiceArray['ServiceSupplierID'];
        }else{
            $isInspectionEnabled = $_POST['inspectionCheckbox'] === 'checked' ? '1' : '0';
            $inspectionSupplierID = $_POST['inspectionSelect'];
        }
        $inspectionServiceID = $inspectionServiceArray['ServiceID'];
        $inspectionRealCost = $_POST['inspectionRealCost'];
        update_service_info($isInspectionEnabled, $inspectionSupplierID, $inspectionServiceID, $inspectionRealCost);
        // Storage
        if($storageServiceArray['IsDisabled'] === 'disabled'){
            $isStorageEnabled = $storageServiceArray['IsChecked'] === 'checked' ? '1' : '0';
            $storageSupplierID = $storageServiceArray['ServiceSupplierID'];
        }else{
            $isStorageEnabled = $_POST['storageCheckbox'] === 'checked' ? '1' : '0';
            $storageSupplierID = $_POST['storageSelect'];
        }
        $storageServiceID = $storageServiceArray['ServiceID'];
        $storageRealCost = $_POST['storageRealCost'];
        update_service_info($isStorageEnabled, $storageSupplierID, $storageServiceID, $storageRealCost);
        // Relocate Home
        if($relocateHomeServiceArray['IsDisabled'] === 'disabled'){
            $isRelocateHomeEnabled = $relocateHomeServiceArray['IsChecked'] === 'checked' ? '1' : '0';
            $relocateHomeSupplierID = $relocateHomeServiceArray['ServiceSupplierID'];
        }else{
            $isRelocateHomeEnabled = $_POST['relocateHomeCheckbox'] === 'checked' ? '1' : '0';
            $relocateHomeSupplierID = $_POST['relocateHomeSelect'];
        }
        $relocateHomeServiceID = $relocateHomeServiceArray['ServiceID'];
        $relocateHomeRealCost = $_POST['relocateHomeRealCost'];
        update_service_info($isRelocateHomeEnabled, $relocateHomeSupplierID, $relocateHomeServiceID, $relocateHomeRealCost);
        // Photography
        if($photographyServiceArray['IsDisabled'] === 'disabled'){
            $isPhotographyEnabled = $photographyServiceArray['IsChecked'] === 'checked' ? '1' : '0';
            $photographySupplierID = $photographyServiceArray['ServiceSupplierID'];
        }else{
            $isPhotographyEnabled = $_POST['photographyCheckbox'] === 'checked' ? '1' : '0';
            $photographySupplierID = $_POST['photographySelect'];
        }
        $photographyServiceID = $photographyServiceArray['ServiceID'];
        $photographyRealCost = $_POST['photographyRealCost'];
        update_service_info($isPhotographyEnabled, $photographySupplierID, $photographyServiceID, $photographyRealCost);

        // Update Case Status And Final Price
        $caseStatus = $_POST['case_status'];
        update_case_status_and_final_price($MLS, $totalCost, $caseStatus);

        // Generate Final Report
        if($caseStatus === 'CLOSED'){
            $reportFromArray = array(
                "MLS" => $MLS,
                "address" => $caseDetailsArray['Address'],
                "teamLeader" => $teamLeaderName,
                "teamMember" => $caseDetailsArray['CoStaffName'],
                "propertyType" => $caseDetailsArray['PropertyType'],
                "sellingListingRate" => $caseDetailsArray['CommissionRate'],
                "listingPrice" => $caseDetailsArray['ListingPrice'],
                "stagingSupplier" => mysqli_fetch_array(get_supplier_name_by_id($stagingSupplierID))['SupplierName'],
                "stagingFinalPrice" => $stagingRealCost,
                "cleanUpSupplier" => mysqli_fetch_array(get_supplier_name_by_id($cleanUpSupplierID))['SupplierName'],
                "cleanUpFinalPrice" => $cleanUpRealCost,
                "touchUpSupplier" => mysqli_fetch_array(get_supplier_name_by_id($touchUpSupplierID))['SupplierName'],
                "touchUpFinalPrice" => $touchUpRealCost,
                "inspectionSupplier" => mysqli_fetch_array(get_supplier_name_by_id($inspectionSupplierID))['SupplierName'],
                "inspectionFinalPrice" => $inspectionRealCost,
                "yardWorkSupplier" => mysqli_fetch_array(get_supplier_name_by_id($yardWorkSupplierID))['SupplierName'],
                "yardWorkFinalPrice" => $yardWorkRealCost,
                "storageSupplier" => mysqli_fetch_array(get_supplier_name_by_id($storageSupplierID))['SupplierName'],
                "storageFinalPrice" => $storageRealCost,
                "relocateHomeSupplier" => mysqli_fetch_array(get_supplier_name_by_id($relocateHomeSupplierID))['SupplierName'],
                "relocateHomeFinalPrice" => $relocateHomeRealCost,
                "totalCost" => $totalCost
            );
            $reportInvoicesArray = array(
                "reportFormFile" => '',
                "stagingInvoice" => trim(mysqli_fetch_array(download_file_by_path($uploadBasePath . "/Staging/" . "Invoice/"))['FileName'], "wp-content/themes/NuStream/"),
                "cleanUpInvoice" => trim(mysqli_fetch_array(download_file_by_path($uploadBasePath . "/CleanUp/" . "Invoice/"))['FileName'], "wp-content/themes/NuStream/"),
                "relocateHomeInvoice" => trim(mysqli_fetch_array(download_file_by_path($uploadBasePath . "/RelocateHome/" . "Invoice/"))['FileName'], "wp-content/themes/NuStream/"),
                "touchUpInvoice" => trim(mysqli_fetch_array(download_file_by_path($uploadBasePath . "/TouchUp/" . "Invoice/"))['FileName'], "wp-content/themes/NuStream/"),
                "inspectionInvoice" => trim(mysqli_fetch_array(download_file_by_path($uploadBasePath . "/Inspection/" . "Invoice/"))['FileName'], "wp-content/themes/NuStream/"),
                "yardWorkInvoice" => trim(mysqli_fetch_array(download_file_by_path($uploadBasePath . "/YardWork/" . "Invoice/"))['FileName'], "wp-content/themes/NuStream/"),
                "storageInvoice" => trim(mysqli_fetch_array(download_file_by_path($uploadBasePath . "/Storage/" . "Invoice/"))['FileName'], "wp-content/themes/NuStream/"),
            );

            generate_case_report($reportFromArray, $reportInvoicesArray);
        }

        save_session();
        header('Location: ' . get_home_url() . '/agent-case-details/?CID=' . $MLS . '&'  . 'RF=true');
        exit;
    }

    // Estimate
    if(isset($_POST['estimate'])){
        save_session();
        get_estimate_service_price();
        header('Location: ' . get_home_url() . '/agent-case-details/?CID=' . $MLS . '&'  . 'RF=true');
        exit;
    }

    // Update Services Info
    function update_service_info($isServiceEnabled, $serviceSupplierID, $serviceID, $realCost){
        if($isServiceEnabled === '1'){
            if(!is_null($serviceID)){
                // Update Service
                $updateStagingResult = update_service($serviceID, $serviceSupplierID, $realCost, $isServiceEnabled);
            }
        }else{
            // Delete Service Info And Case-service Info
            $deleteOldServiceResult = delete_service_by_id($serviceID);
        }
    }

    // Update Service Info
    function update_service($serviceID, $supplierID, $realCost, $isStagingEnabled){
        $updateServiceArray = array(
            "serviceID" => $serviceID,
            "serviceSupplierID" => $supplierID,
            "realCost" => $realCost,
            "isActive" => $isStagingEnabled
        );
        $updateServiceResult = update_service_details($updateServiceArray);
        return $updateServiceResult;
    }


?>
<html>
<head>
    <title>Project</title>
    <script src="<?php bloginfo('template_url');?>/lib/angular-1.5.0/angular.js"></script>
    <script src="<?php bloginfo('template_url');?>/CaseDetailSiteScripts/CaseDetailApp.js"></script>
    <script src="<?php bloginfo('template_url');?>/CaseDetailSiteScripts/CaseDetailController.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/CaseDetailSite.css">
</head>
<body>
<div ng-app="CaseDetailApp" ng-controller="CaseDetailController" class="CaseDetailContainer">
    <form method="post">
        <div class="Back">
        </div>
        <div class="TopContainer">
            <div class="BackgroundGrey">
                <div>MLS#</div>
                <div><?php
                    if($isCaseChangeable === 'hidden'){
                        echo '<a>', $caseDetailsArray['MLS'], '</a>';
                    }else{
                        echo '<a href="' . $uploadPageURL . '">', $caseDetailsArray['MLS'], '</a>';
                    }
                    ?>
                </div>
            </div>
            <div>
                <div>ADDRESS</div>
                <div><?php echo $caseDetailsArray['Address'];?></div>
            </div>
            <div class="BackgroundGrey">
                <div>PROPERTY TYPE</div>
                <div><?php echo $caseDetailsArray['PropertyType'];?></div>
            </div>
            <div>
                <div>LAND SIZE(LOT)</div>
                <div><?php echo $caseDetailsArray['LandSize'];?></div>
            </div>
            <div class="BackgroundGrey">
                <div>HOUSE SIZE(SQF)</div>
                <div><?php echo $caseDetailsArray['HouseSize'];?></div>
            </div>
            <div>
                <div>LISTING PRICE</div>
                <div><?php echo $caseDetailsArray['ListingPrice'];?></div>
            </div>
            <div class="BackgroundGrey">
                <div>OWNER'S NAME</div>
                <div><?php echo $caseDetailsArray['OwnerName'];?></div>
            </div>
            <div>
                <div>TEAM MEMBER'S NAME</div>
                <div><?php echo $caseDetailsArray['CoStaffName'];?></div>
            </div>
            <div class="BackgroundGrey">
                <div>SELLING LISTING RATE</div>
                <div><?php echo $caseDetailsArray['CommissionRate'] . "%";?></div>
            </div>
        </div>

        <div class="TotalCostContainer">
            <div class="TextContainer">
                <div>Total Cost: <?php echo "$" . $totalCost; ?></div>
                <div>Final Commission: <?php echo "$" . $finalCommission; ?></div>
            </div>
            <input type="submit" name="estimate" class="Button Submit" value="Estimate" <?php echo $isCaseChangeable; ?> />
            <input type="submit" value="Submit" class="Button" name="submit_service_info" <?php echo $isCaseChangeable; ?>/>
        </div>

        <div class="BottomContainer">
            <div class="ItemContainer">
                <div class="FirstLine">
                    <div class="Label"><label>STAGING</label></div>
                    <div class="Select"><?php
                        echo '<select name="stagingSelect" ' . $stagingServiceArray['IsDisabled'] . '>';
                        if(is_null($stagingServiceArray['ServiceSupplierID']))
                            $isDefaultSelected = 'selected';
                        foreach ($allSuppliersArray['STAGING'] as $stagingSupplierItem){
                            if(!is_null($stagingServiceArray['ServiceSupplierID']) && $stagingServiceArray['ServiceSupplierID'] === $stagingSupplierItem['SupplierID']){
                                $isSelected = 'selected';
                            }else {
                                $isSelected = null;
                            }
                            echo '<option value="' . $stagingSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $stagingSupplierItem['SupplierName'], '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <label class="Status"><?php echo $stagingServiceArray['InvoiceStatus']; ?></label>
                </div>
                <div class="SecondLine">
                    <label class="Est">EST</label>
                    <label class="Amount"><?php echo $stagingEstimatePrice; ?></label>
                    <?php echo '<input type="text" class="Input" placeholder="REAL COST" name="stagingRealCost" value="' . $stagingServiceArray['RealCost'] . '"/>'; ?>
                    <?php echo '<input type="checkbox" class="Check" name="stagingCheckbox" value="checked" ' . $stagingServiceArray['IsChecked'] . ' ' . $stagingServiceArray['IsDisabled'] . ' >'; ?>
                </div>
            </div>

            <div class="ItemContainer">
                <div class="FirstLine">
                    <div class="Label"><label>TOUCH UP</label></div>
                    <div class="Select"><?php
                        echo '<select name="touchUpSelect" ' . $touchUpServiceArray['IsDisabled'] . '>';
                        if(is_null($touchUpServiceArray['ServiceSupplierID']))
                            $isDefaultSelected = 'selected';
                        foreach ($allSuppliersArray['TOUCHUP'] as $touchUpSupplierItem){
                            if(!is_null($touchUpServiceArray['ServiceSupplierID']) && $touchUpServiceArray['ServiceSupplierID'] === $touchUpSupplierItem['SupplierID']){
                                $isSelected = 'selected';
                            }else {
                                $isSelected = null;
                            }
                            echo '<option value="' . $touchUpSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $touchUpSupplierItem['SupplierName'], '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <label class="Status"><?php echo $touchUpServiceArray['InvoiceStatus']; ?></label>
                </div>
                <div class="SecondLine">
                    <label class="Est">EST</label>
                    <label class="Amount"><?php echo $touchUpEstimatePrice; ?></label>
                    <?php echo '<input type="text" class="Input" placeholder="REAL COST" name="touchUpRealCost" value="' . $touchUpServiceArray['RealCost'] . '"/>'; ?>
                    <?php echo '<input type="checkbox" class="Check" name="touchUpCheckbox" value="checked" ' . $touchUpServiceArray['IsChecked'] . ' ' . $touchUpServiceArray['IsDisabled'] . '>'; ?>
                </div>
            </div>

            <div class="ItemContainer">
                <div class="FirstLine">
                    <div class="Label"><label>CLEAN UP</label></div>
                    <div class="Select"><?php
                        echo '<select name="cleanUpSelect" ' . $cleanUpServiceArray['IsDisabled'] . '>';
                        if(is_null($cleanUpServiceArray['ServiceSupplierID']))
                            $isDefaultSelected = 'selected';
                        foreach ($allSuppliersArray['CLEANUP'] as $cleanUpSupplierItem){
                            if(!is_null($cleanUpServiceArray['ServiceSupplierID']) && $cleanUpServiceArray['ServiceSupplierID'] === $cleanUpSupplierItem['SupplierID']){
                                $isSelected = 'selected';
                            }else {
                                $isSelected = null;
                            }
                            echo '<option value="' . $cleanUpSupplierItem['SupplierID'] . '" ' . $isSelected . ' >', $cleanUpSupplierItem['SupplierName'], '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <label class="Status"><?php echo $cleanUpServiceArray['InvoiceStatus']; ?></label>
                </div>
                <div class="SecondLine">
                    <label class="Est">EST</label>
                    <label class="Amount"><?php echo $cleanUpEstimatePrice; ?></label>
                    <?php echo '<input type="text" class="Input" placeholder="REAL COST" name="cleanUpRealCost" value="' . $cleanUpServiceArray['RealCost'] . '"/>'; ?>
                    <?php echo '<input type="checkbox" class="Check" name="cleanUpCheckbox" value="checked" ' . $cleanUpServiceArray['IsChecked'] . ' ' . $cleanUpServiceArray['IsDisabled'] . '>'; ?>
                </div>
            </div>

            <div class="ItemContainer">
                <div class="FirstLine">
                    <div class="Label"><label>YARD WORK</label></div>
                    <div class="Select"><?php
                        echo '<select name="yardWorkSelect" ' . $yardWorkServiceArray['IsDisabled'] . '>';
                        if(is_null($yardWorkServiceArray['ServiceSupplierID']))
                            $isDefaultSelected = 'selected';
                        foreach ($allSuppliersArray['YARDWORK'] as $yardWorkSupplierItem){
                            if(!is_null($yardWorkServiceArray['ServiceSupplierID']) && $yardWorkServiceArray['ServiceSupplierID'] === $yardWorkSupplierItem['SupplierID']){
                                $isSelected = 'selected';
                            }else {
                                $isSelected = null;
                            }
                            echo '<option value="' . $yardWorkSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $yardWorkSupplierItem['SupplierName'], '</option>';
                        }
                        echo '</select>';
                        ?>
                        </select></div>
                    <label class="Status"><?php echo $yardWorkServiceArray['InvoiceStatus']; ?></label>
                </div>
                <div class="SecondLine">
                    <label class="Est">EST</label>
                    <label class="Amount"><?php echo $yardWordEstimatePrice; ?></label>
                    <?php echo '<input type="text" class="Input" placeholder="REAL COST" name="yardWorkRealCost" value="' . $yardWorkServiceArray['RealCost'] . '"/>'; ?>
                    <?php echo '<input type="checkbox" class="Check" name="yardWorkCheckbox" value="checked" ' . $yardWorkServiceArray['IsChecked'] . ' ' . $yardWorkServiceArray['IsDisabled'] . '>'; ?>
                </div>
            </div>

            <div class="ItemContainer">
                <div class="FirstLine">
                    <div class="Label"><label>INSPECTION</label></div>
                    <div class="Select"><?php
                        echo '<select name="inspectionSelect" ' . $inspectionServiceArray['IsDisabled'] . '>';
                        if(is_null($inspectionServiceArray['ServiceSupplierID']))
                            $isDefaultSelected = 'selected';
                        foreach ($allSuppliersArray['INSPECTION'] as $inspectionSupplierItem){
                            if(!is_null($inspectionServiceArray['ServiceSupplierID']) && $inspectionServiceArray['ServiceSupplierID'] === $inspectionSupplierItem['SupplierID']){
                                $isSelected = 'selected';
                            }else {
                                $isSelected = null;
                            }
                            echo '<option value="' . $inspectionSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $inspectionSupplierItem['SupplierName'], '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <label class="Status"><?php echo $inspectionServiceArray['InvoiceStatus']; ?></label>
                </div>
                <div class="SecondLine">
                    <label class="Est">EST</label>
                    <label class="Amount"><?php echo $inspectionEstimatePrice; ?></label>
                    <?php echo '<input type="text" name="inspectionRealCost" class="Input" placeholder="REAL COST" value="' . $inspectionServiceArray['RealCost'] . '"/>'; ?>
                    <?php echo '<input type="checkbox" class="Check" name="inspectionCheckbox" value="checked" ' . $inspectionServiceArray['IsChecked'] . ' ' . $inspectionServiceArray['IsDisabled'] . '>'; ?>
                </div>
            </div>

            <div class="ItemContainer">
                <div class="FirstLine">
                    <div class="Label"><label>STORAGE</label></div>
                    <div class="Select"><?php
                        echo '<select name="storageSelect" ' . $storageServiceArray['IsDisabled'] . '>';
                        if(is_null($storageServiceArray['ServiceSupplierID']))
                            $isDefaultSelected = 'selected';
                        foreach ($allSuppliersArray['STORAGE'] as $storageSupplierItem){
                            if(!is_null($storageServiceArray['ServiceSupplierID']) && $storageServiceArray['ServiceSupplierID'] === $storageSupplierItem['SupplierID']){
                                $isSelected = 'selected';
                            }else {
                                $isSelected = null;
                            }
                            echo '<option value="' . $storageSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $storageSupplierItem['SupplierName'], '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <label class="Status"><?php echo $storageServiceArray['InvoiceStatus']; ?></label>
                </div>
                <div class="SecondLine">
                    <label class="Est">EST</label>
                    <label class="Amount"><?php echo $storageEstimatePrice; ?></label>
                    <?php echo '<input type="text" name="storageRealCost" class="Input" placeholder="REAL COST" value="' . $storageServiceArray['RealCost'] . '"/>'; ?>
                    <?php echo '<input type="checkbox" class="Check" name="storageCheckbox" value="checked" ' . $storageServiceArray['IsChecked'] . ' ' . $storageServiceArray['IsDisabled'] . '>' ;?>
                </div>
            </div>

            <div class="ItemContainer">
                <div class="FirstLine">
                    <div class="Label"><label>RELOCATE HOME</label></div>
                    <div class="Select"><?php
                        echo '<select name="relocateHomeSelect" ' . $relocateHomeServiceArray['IsDisabled'] . '>';
                        if(is_null($relocateHomeServiceArray['ServiceSupplierID']))
                            $isDefaultSelected = 'selected';
                        foreach ($allSuppliersArray['RELOCATEHOME'] as $relocateHomeSupplierItem){
                            if(!is_null($relocateHomeServiceArray['ServiceSupplierID']) && $relocateHomeServiceArray['ServiceSupplierID'] === $relocateHomeSupplierItem['SupplierID']){
                                $isSelected = 'selected';
                            }else {
                                $isSelected = null;
                            }
                            echo '<option value="' . $relocateHomeSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $relocateHomeSupplierItem['SupplierName'], '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <label class="Status"><?php echo $relocateHomeServiceArray['InvoiceStatus']; ?></label>
                </div>
                <div class="SecondLine">
                    <label class="Est">EST</label>
                    <label class="Amount"><?php echo $relocateHomeEstimatePrice; ?></label>
                    <?php echo '<input type="text" name="relocateHomeRealCost" class="Input" placeholder="REAL COST" value="' . $relocateHomeServiceArray['RealCost'] . '"/>'; ?>
                    <?php echo '<input type="checkbox" class="Check" name="relocateHomeCheckbox" value="checked" ' . $relocateHomeServiceArray['IsChecked'] . ' ' . $relocateHomeServiceArray['IsDisabled'] .'>'; ?>
                </div>
            </div>

            <div class="ItemContainer">
                <div class="FirstLine">
                    <div class="Label"><label>PHOTOGRAPHY</label></div>
                    <div class="Select"><?php
                        echo '<select name="photographySelect" ' . $photographyServiceArray['IsDisabled'] . '>';
                        if(is_null($photographyServiceArray['ServiceSupplierID']))
                            $isDefaultSelected = 'selected';
                        foreach ($allSuppliersArray['PHOTOGRAPHY'] as $photographySupplierItem){
                            if(!is_null($photographyServiceArray['ServiceSupplierID']) && $photographyServiceArray['ServiceSupplierID'] === $photographySupplierItem['SupplierID']){
                                $isSelected = 'selected';
                            }else {
                                $isSelected = null;
                            }
                            echo '<option value="' . $photographySupplierItem['SupplierID'] . '" ' . $isSelected . '>', $photographySupplierItem['SupplierName'], '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <label class="Status"><?php echo $photographyServiceArray['InvoiceStatus']; ?></label>
                </div>
                <div class="SecondLine">
                    <label class="Est">EST</label>
                    <label class="Amount"><?php echo $photographyEstimatePrice; ?></label>
                    <?php echo '<input type="text" name="photographyRealCost" class="Input" placeholder="REAL COST" value="' . $photographyServiceArray['RealCost'] . '"/>'; ?>
                    <?php echo '<input type="checkbox" class="Check" name="photographyCheckbox" value="checked" ' . $photographyServiceArray['IsChecked'] . ' ' . $photographyServiceArray['IsDisabled'] . '>'; ?>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
