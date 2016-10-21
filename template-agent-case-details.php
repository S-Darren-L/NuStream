<?php

// Start Session
session_start();

/*
Template Name: Agent Case Details
*/

?>

<?php
    // Get Case ID
    $MLS = $_GET['CID'];
    $isRefreshPage = $_GET['RF'];
    $uploadPageURL = get_home_url() . '/agent-case-file-upload/?CID=' . $MLS;
    $uploadPath = get_home_url() . "/wp-content/themes/NuStream/Upload/Services/";
    $houseImageURL =  get_home_url() . "/wp-content/themes/NuStream/img/house.jpg";

    // Init Date
    // Get Case Statuses
    $caseStatuses = get_case_statuses();

    // Get Case Basic Details
    $caseDetailsArray = array();
    $caseDetailsArray = get_case_basic_details($MLS);

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
            $supplierResult = get_supplier_brief_info($supplierType);

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
        $isActive = $isRefreshPage === 'true' ? $_SESSION['CaseEstimate'][$serviceID]['isServiceChecked'] : $serviceDetailsArray['IsActivate'];
        if($isActive === 'checked'){
            $isActive = '1';
        }
        $serviceDetailsArray['IsChecked'] = $isActive === '1' ? 'checked' : null;
        $serviceDetailsArray['IsDisabled'] = $serviceDetailsArray['InvoiceStatus'] === 'APPROVED' ? 'disabled' : null;
        if($isRefreshPage === 'true'){
            $serviceDetailsArray['ServiceSupplierID'] = $_SESSION['CaseEstimate'][$serviceID]['supplierID'];
            $serviceDetailsArray['RealCost'] = $_SESSION['CaseEstimate'][$serviceID]['serviceRealCost'];
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
        $isStagingEnabled = $_POST['stagingCheckbox'] === 'checked' ? '1' : '0';
        $stagingSupplierID = $_POST['stagingSelect'];
        $stagingServiceID = $stagingServiceArray['ServiceID'];
        $stagingRealCost = $_POST['stagingRealCost'];
        update_service_info($isStagingEnabled, $stagingSupplierID, $stagingServiceID, $stagingRealCost);
        // Touch up
        $isTouchUpEnabled = $_POST['touchUpCheckbox'] === 'checked' ? '1' : '0';
        $touchUpSupplierID = $_POST['touchUpSelect'];
        $touchUpServiceID = $touchUpServiceArray['ServiceID'];
        $touchUpRealCost = $_POST['touchUpRealCost'];
        update_service_info($isTouchUpEnabled, $touchUpSupplierID, $touchUpServiceID, $touchUpRealCost);
        // Clean up
        $isCleanUpEnabled = $_POST['cleanUpCheckbox'] === 'checked' ? '1' : '0';
        $cleanUpSupplierID = $_POST['cleanUpSelect'];
        $cleanUpServiceID = $cleanUpServiceArray['ServiceID'];
        $cleanUpRealCost = $_POST['cleanUpRealCost'];
        update_service_info($isCleanUpEnabled, $cleanUpSupplierID, $cleanUpServiceID, $cleanUpRealCost);
        // Yard work
        $isYardWorkEnabled = $_POST['yardWorkCheckbox'] === 'checked' ? '1' : '0';
        $yardWorkSupplierID = $_POST['yardWorkSelect'];
        $yardWorkServiceID = $yardWorkServiceArray['ServiceID'];
        $yardWorkRealCost = $_POST['yardWorkRealCost'];
        update_service_info($isYardWorkEnabled, $yardWorkSupplierID, $yardWorkServiceID, $yardWorkRealCost);
        // Inspection
        $isInspectionEnabled = $_POST['inspectionCheckbox'] === 'checked' ? '1' : '0';
        $inspectionSupplierID = $_POST['inspectionSelect'];
        $inspectionServiceID = $inspectionServiceArray['ServiceID'];
        $inspectionRealCost = $_POST['inspectionRealCost'];
        update_service_info($isInspectionEnabled, $inspectionSupplierID, $inspectionServiceID, $inspectionRealCost);
        // Storage
        $isStorageEnabled = $_POST['storageCheckbox'] === 'checked' ? '1' : '0';
        $storageSupplierID = $_POST['storageSelect'];
        $storageServiceID = $storageServiceArray['ServiceID'];
        $storageRealCost = $_POST['storageRealCost'];
        update_service_info($isStorageEnabled, $storageSupplierID, $storageServiceID, $storageRealCost);
        // Relocate Home
        $isRelocateHomeEnabled = $_POST['relocateHomeCheckbox'] === 'checked' ? '1' : '0';
        $relocateHomeSupplierID = $_POST['relocateHomeSelect'];
        $relocateHomeServiceID = $relocateHomeServiceArray['ServiceID'];
        $relocateHomeRealCost = $_POST['relocateHomeRealCost'];
        update_service_info($isRelocateHomeEnabled, $relocateHomeSupplierID, $relocateHomeServiceID, $relocateHomeRealCost);
        // Photography
        $isPhotographyEnabled = $_POST['photographyCheckbox'] === 'checked' ? '1' : '0';
        $photographySupplierID = $_POST['photographySelect'];
        $photographyServiceID = $photographyServiceArray['ServiceID'];
        $photographyRealCost = $_POST['photographyRealCost'];
        update_service_info($isPhotographyEnabled, $photographySupplierID, $photographyServiceID, $photographyRealCost);

        // Update Case Status And Final Price
        update_case_status_and_final_price($MLS, $totalCost, $_POST['case_status']);

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
        if($isServiceEnabled === '1' && !empty($serviceSupplierID)){
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
<!DOCTYPE html>
<style type="text/css">
    html, body {
        margin:0;
        padding:0;
    }

    #container {
        margin-left: 230px;
        _zoom: 1;
    }

    #nav {
        float: left;
        width: 230px;
        height: 100%;
        background: #32323a;
        margin-left: -230px;
        position:fixed;
    }

    #main {
        height: 400px;
    }
    /* style icon */
    .inner-addon .glyphicon {
        position: absolute;
        padding: 10px;
        pointer-events: none;
    }

    /* align icon */
    .left-addon .glyphicon {
        left: 0px;
    }

    /* add padding  */
    .left-addon input {
        padding-left: 30px;
    }

    a {
        letter-spacing: 1px;
    }

    .logo {
        height: 120px;
        width: 230px;
        padding-top: 20px;
        padding-left: 20px;
        padding-right:20px;
        padding-bottom: 20px;
        display: block;
        background-color: #28282e;
    }

    .logo img {
        width: 100%;
    }

    .nav-pills {
        background-color: #32323a;
        border-color: #030033;
    }

    .nav-pills > li > a {
        color: #95a0aa; /*Change active text color here*/
    }
    .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        color: #000;  /*Sets the text hover color on navbar*/
    }

    li {
        border-bottom:1px #2a2a31 solid;
    }
    .footer {
        position: absolute;
        bottom:0px;
        left:0;
        right:0;
        margin:0 auto;
        text-align: center;
    }

    .copyRight {
        color:white;
        padding:0px;
    }

    .formPart {
        margin-left: 40px;
        padding-top: 30px;
    }

    th {
        color:white;
        font-size:11px;
        text-align:center;
    }

    .userNamePart {
        color:white;
        text-align: center;
        margin-bottom: 20px;
    }

    .title {
        padding:0px;
        margin:20px;
    }
    .title h4 {
        padding:0px;
        margin:0px;
        width: 300px;
        font-size: 20px;
        color:grey;
        font-style: bold;
    }

    .inputPart {
        padding-top: 30px;
        background-color: grey;
        color:white;
        height: 500px;
        width: 800px;
    }

    .table td {
        font-size:10px;
        vertical-align: middle;
    }

    .arrow-up {
        width:0;
        height:0;
        border-left:3px solid transparent;
        border-right:3px solid transparent;
        border-bottom:6px solid #fff;
        display: inline-block;
    }

    .arrow-down {
        width:0;
        height:0;
        border-left:3px solid transparent;
        border-right:3px solid transparent;
        border-top:6px solid #fff;
        display: inline-block;
    }



    .pageNum {
        text-align: center;
    }

    .pageNum a:link{
        font-size: 8px;
        color:black;
        text-decoration:underline;
    }

    .pageNum a:visited{
        color:black;
        text-decoration:underline;
    }

    .pageNum a:hover{
        color:black;
        text-decoration:underline;
    }

    .pageNum a:active{
        color:black;
        text-decoration:underline;
    }

    .table-striped {
        width: 790px !important;
        padding-left:20px;
        margin-left: 20px;
    }

    .table-striped th{
        font-size: 10px;
        color:#a9a9a9;
        text-align: center;
    }

    .table-striped td{
        text-align: center;
        color:#a9a9a9;
    }

    .houseInfo .table-striped tr {
        font-size: 10px;
        color:#a9a9a9;
    }

    .houseInfo .table-striped th {
        font-size: 10px;
        color:#a9a9a9;
    }

    .houseInfo .table-striped td {
        padding-top:2px !important;
        padding-bottom:2px !important;
    }

    .houseInfo .table-striped {
        /*	margin-top: 0px;
            margin-left: 0px;*/
        width: 415px !important;
        height: 200px !important;
        color: #a9a9a9;
    }

    .houseInfo {
        width: 100%;
        overflow: hidden;
        padding-left: 20px;
    }

    .houseImg {
        height: 200px;
        width: 300px;
        float: left;
        padding-top:25px;
    }

    .houseImg img {
        width: 100%;
    }

    .houseTable {
        width: 300px;
        margin-left: 350px;
    }

    .table-striped a:link {
        text-decoration: underline;
    }

    .dropdown {
        height: 20px;
        width: 25px;
    }

    select {
        border-radius: 3px;
        height: 20px;
        width: 70px;
    }

    .financial {
        width: 780px;
    }

    .financial h5{
        margin-left: 20px;
        color:#a9a9a9;
    }

    .approveButton {
        height: 30px;
        width: 100px;
        background-color: #32323a;
        color:#fff;
        font-size: 12px;
        float:right;
    }

    .line {
        width: 900px;
    }

    .total {
        float: left;
    }

    .selectTeamPart {
        float:left;
        padding-left: 240px;
        color:#a9a9a9;
    }

    .selectTeam {
        margin-top:-60px;
        margin-left: 420px;
    }

    .selectTeam select {
        border-radius: 3px;
        height: 30px;
        width: 130px;
    }
</style>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
<div id="container">
    <?php
        include_once(__DIR__ . '/navigation.php');
    ?>
    <div id="main">
        <div class="formPart">
            <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
                <div class="houseInfo">
                    <div class="houseImg"><?php echo '<img src="' . $houseImageURL . '">'; ?></div>
                    <div class="houseTable">
                        <div style="width:300px; padding:0px;"><h5 style="z-index:100;color:#a9a9a9; margin-top:0px; margin-left:10px;">HOUSE INFORMATION</h5></div>
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>MLS#</td>
                                <td><?php echo '<a href="' . $uploadPageURL . '">', $caseDetailsArray['MLS'], '</a>';?></td>
                            </tr>
                            <tr>
                                <td>ADDRESS</td>
                                <td><?php echo $caseDetailsArray['Address'];?></td>
                            </tr>
                            <tr>
                                <td>PROPERTY TYPE</td>
                                <td><?php echo $caseDetailsArray['PropertyType'];?></td>
                            </tr>
                            <tr>
                                <td>LAND SIZE (LOT)</td>
                                <td><?php echo $caseDetailsArray['LandSize'];?></td>
                            </tr>
                            <tr>
                                <td>HOUSE SIZE(SQF)</td>
                                <td><?php echo $caseDetailsArray['HouseSize'];?></td>
                            </tr>
                            <tr>
                                <td>LISTING PRICE</td>
                                <td><?php echo $caseDetailsArray['ListingPrice'];?></td>
                            </tr>
                            <tr>
                                <td>OWNER'S NAME</td>
                                <td><?php echo $caseDetailsArray['OwnerName'];?></td>
                            </tr>
                            <tr>
                                <td>TEAM MEMBER'S NAME</td>
                                <td><?php echo $caseDetailsArray['CoStaffName'];?></td>
                            </tr>
                            <tr>
                                <td>SELLING LISTING RATE</td>
                                <td><?php echo $caseDetailsArray['CommissionRate'] . "%";?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div style="width:300px; padding:0px 0px 0px 10px;"><h5 style="z-index:100;color:#a9a9a9; margin-top:0px; margin-left:10px;">SERVICES INFO</h5></div>
                <table class="table table-striped">
                    <thead style="background-color:#fffeff;">
                    <tr>
                        <th></th>
                        <th>SERVICE TYPE</th>
                        <th>PROVIDER</th>
                        <th>ESTIMATE COST</th>
                        <th>REAL COST</th>
                        <th>STATUS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo '<input type="checkbox" name="stagingCheckbox" value="checked" ' . $stagingServiceArray['IsChecked'] . ' ' . $stagingServiceArray['IsDisabled'] . ' >'; ?></td>
                        <td>STAGING</td>
                        <td>
                            <?php
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
                        </td>
                        <td style="text-align:center;"><?php echo $stagingEstimatePrice; ?></td>
                        <td><?php echo '<input type="text" name="stagingRealCost" value="' . $stagingServiceArray['RealCost'] . '"/>'; ?></td>
                        <td><?php echo $stagingServiceArray['InvoiceStatus']; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo '<input type="checkbox" name="touchUpCheckbox" value="checked" ' . $touchUpServiceArray['IsChecked'] . ' ' . $touchUpServiceArray['IsDisabled'] . '>'; ?></td>
                        <td>TOUCH UP</td>
                        <td>
                            <?php
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
                        </td>
                        <td style="text-align:center;"><?php echo $touchUpEstimatePrice; ?></td>
                        <td><?php echo '<input type="text" name="touchUpRealCost" value="' . $touchUpServiceArray['RealCost'] . '"/>'; ?></td>
                        <td><?php echo $touchUpServiceArray['InvoiceStatus']; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo '<input type="checkbox" name="cleanUpCheckbox" value="checked" ' . $cleanUpServiceArray['IsChecked'] . ' ' . $cleanUpServiceArray['IsDisabled'] . '>'; ?></td>
                        <td>CLEAN UP</td>
                        <td>
                            <?php
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
                        </td>
                        <td style="text-align:center;"><?php echo $cleanUpEstimatePrice; ?></td>
                        <td><?php echo '<input type="text" name="cleanUpRealCost" value="' . $cleanUpServiceArray['RealCost'] . '"/>'; ?></td>
                        <td><?php echo $cleanUpServiceArray['InvoiceStatus']; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo '<input type="checkbox" name="yardWorkCheckbox" value="checked" ' . $yardWorkServiceArray['IsChecked'] . ' ' . $yardWorkServiceArray['IsDisabled'] . '>'; ?></td>
                        <td>YARD WORK</td>
                        <td>
                            <?php
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
                        </td>
                        <td style="text-align:center;"><?php echo $yardWordEstimatePrice; ?></td>
                        <td><?php echo '<input type="text" name="yardWorkRealCost" value="' . $yardWorkServiceArray['RealCost'] . '"/>'; ?></td>
                        <td><?php echo $yardWorkServiceArray['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo '<input type="checkbox" name="inspectionCheckbox" value="checked" ' . $inspectionServiceArray['IsChecked'] . ' ' . $inspectionServiceArray['IsDisabled'] . '>'; ?></td>
                        <td>INSPECTION</td>
                        <td>
                            <?php
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
                        </td>
                        <td style="text-align:center;"><?php echo $inspectionEstimatePrice; ?></td>
                        <td><?php echo '<input type="text" name="inspectionRealCost" value="' . $inspectionServiceArray['RealCost'] . '"/>'; ?></td>
                        <td><?php echo $inspectionServiceArray['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo '<input type="checkbox" name="storageCheckbox" value="checked" ' . $storageServiceArray['IsChecked'] . ' ' . $storageServiceArray['IsDisabled'] . '>' ;?></td>
                        <td>STORAGE</td>
                        <td>
                            <?php
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
                        </td>
                        <td style="text-align:center;"><?php echo $storageEstimatePrice; ?></td>
                        <td><?php echo '<input type="text" name="storageRealCost" value="' . $storageServiceArray['RealCost'] . '"/>'; ?></td>
                        <td><?php echo $storageServiceArray['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo '<input type="checkbox" name="relocateHomeCheckbox" value="checked" ' . $relocateHomeServiceArray['IsChecked'] . ' ' . $relocateHomeServiceArray['IsDisabled'] .'>'; ?></td>
                        <td>RELOCATE HOME</td>
                        <td>
                            <?php
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
                        </td>
                        <td style="text-align:center;"><?php echo $relocateHomeEstimatePrice; ?></td>
                        <td><?php echo '<input type="text" name="relocateHomeRealCost" value="' . $relocateHomeServiceArray['RealCost'] . '"/>'; ?></td>
                        <td><?php echo $relocateHomeServiceArray['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo '<input type="checkbox" name="photographyCheckbox" value="checked" ' . $photographyServiceArray['IsChecked'] . ' ' . $photographyServiceArray['IsDisabled'] . '>'; ?></td>
                        <td>PHOTOGRAPHY</td>
                        <td>
                            <?php
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
                        </td>
                        <td style="text-align:center;"><?php echo $photographyEstimatePrice; ?></td>
                        <td><?php echo '<input type="text" name="photographyRealCost" value="' . $photographyServiceArray['RealCost'] . '"/>'; ?></td>
                        <td><?php echo $photographyServiceArray['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    </tbody>
                </table>
                <div class="financial" style="display:block; float:left; margin-left:20px;">
                    <div class="line" style="float:left;">
                        <hr style="height:1px; width:500px;border:none;border-top:2px solid #a9a9a9; float:left;" />
                    </div>
                    <div class="total">
                        <h5>Total Cost: <?php echo "$" . $totalCost; ?></h5>
                        <h5>Final Commission: <?php echo "$" . $finalCommission; ?></h5>
                    </div>
                    <div class="selectTeamPart">
                        <div class="selectTeam">
                            <div class="dropdown">
                                <?php
                                echo '<select name="case_status" ' . $isCaseStatusChangeable . '>';
                                if(is_null($stagingServiceArray['ServiceSupplierID']))
                                    $isDefaultSelected = 'selected';
                                foreach ($caseStatuses as $caseStatusItem){
                                    if($caseStatusItem === $caseDetailsArray['CaseStatus']){
                                        $isSelected = 'selected';
                                    }else {
                                        $isSelected = null;
                                    }
                                    echo '<option value="' . $caseStatusItem . '" ' . $isSelected . '>', $caseStatusItem, '</option>';
                                }
                                echo '</select>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div style="height:150px;"></div>
                </div>
                <input type="submit" value="Estimate" name="estimate">
                <input type="submit" value="Submit" name="submit_service_info">
            </form>
        </div>
    </div>
</div>
</div>
</body>
