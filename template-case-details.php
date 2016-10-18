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
    $uploadPath = get_home_url() . "/wp-content/themes/NuStream/Upload/Services/";

    // Init Date
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
        $serviceDetailsResult = get_service_details_by_id($serviceID);
        $serviceDetailsArray = mysqli_fetch_array($serviceDetailsResult);
        $serviceDetailsArray['IsChecked'] = $serviceDetailsArray['IsActivate'] === '1' ? 'checked' : null;
        $serviceDetailsArray['IsDisabled'] = $serviceDetailsArray['InvoiceStatus'] === 'APPROVED' ? 'disabled' : null;
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

        $stagingEstimatePrice = 0;
        $touchUpEstimatePrice = 0;
        $cleanUpEstimatePrice = 0;
        $yardWordEstimatePrice = 0;
        $inspectionEstimatePrice = 0;
        $storageEstimatePrice = 0;
        $relocateHomeEstimatePrice = 0;
        $photographyEstimatePrice = 0;

        global $isStagingChecked;
        global $isTouchUpChecked;
        global $isCleanUpChecked;
        global $isYardWordChecked;
        global $isInspectionChecked;
        global $isStorageChecked;
        global $isRelocateHomeChecked;
        global $isPhotographyChecked;

        global $houseSize;
        global $propertyType;

        global $stagingServiceArray;
        global $touchUpServiceArray;
        global $cleanUpServiceArray;
        global $yardWorkServiceArray;
        global $inspectionServiceArray;
        global $storageServiceArray;
        global $relocateHomeServiceArray;
        global $photographyServiceArray;

        if($isStagingChecked === 'checked'){
            $stagingEstimatePrice = staging_price_estimate_by_id($houseSize, $stagingServiceArray['ServiceID']);
        }
        if($isTouchUpChecked === 'checked'){
            $touchUpEstimatePrice = touch_up_price_estimate_by_id($touchUpServiceArray['ServiceID']);
        }
        if($isCleanUpChecked === 'checked'){
            $cleanUpEstimatePrice = clean_up_price_estimate_by_id($houseSize, $cleanUpServiceArray['ServiceID']);
        }
        if($isYardWordChecked === 'checked'){
            $yardWordEstimatePrice = yard_work_price_estimate_by_id($yardWorkServiceArray['ServiceID']);
        }
        if($isInspectionChecked === 'checked'){
            $inspectionEstimatePrice = inspection_price_estimate_by_id($propertyType, $inspectionServiceArray['ServiceID']);
        }
        if($isStorageChecked === 'checked'){
            $storageEstimatePrice = storage_price_estimate_by_id($storageServiceArray['ServiceID']);
        }
        if($isRelocateHomeChecked === 'checked'){
            $relocateHomeEstimatePrice = relocate_home_price_estimate_by_id($relocateHomeServiceArray['ServiceID']);
        }
        if($isPhotographyChecked === 'checked'){
            $photographyEstimatePrice = photography_price_estimate_by_id($propertyType, $photographyServiceArray['ServiceID']);
        }

    }

    // Staging Service Before Images
//    if(isset($_POST['get_staging_before_images'])){
//        echo "test";
//        // Image Path For Downloading Old Images
//        $imagesPath = $uploadPath . $allServiceDetailArray['STAGING']['ServiceID'] . "/Before/";
//        $imagesArray = download_all_files_by_path($imagesPath);
////        $supplierType = 'STAGING';
//    }

    // Download All Files
//    function download_all_files($imagesPath){
//        $downloadAllFilesResult = download_all_files_by_path($imagesPath);
//        if($downloadAllFilesResult === null)
//            echo 'result is null';
//
//        $downloadAllFilesResult_rows = [];
//        while($row = mysqli_fetch_array($downloadAllFilesResult))
//        {
//            $downloadAllFilesResult_rows[] = $row;
//        }
//        return $downloadAllFilesResult_rows;
//    }

    // Submit Services Info
    if(isset($_GET['submit_service_info'])) {
        // Staging
        $isStagingEnabled = $_POST['stagingCheckbox'];
        $stagingSupplierID = $_POST['stagingSelect'];
        $oldStagingSupplierID = $allServiceDetailArray['STAGING']['ServiceSupplierID'];
        $stagingServiceID = $allServiceDetailArray['STAGING']['ServiceID'];
        $stagingRealCost = $_POST['stagingRealCost'];
        if($isStagingEnabled === 'checked' && !empty($stagingSupplierID)){
            //Before images
            //After images
            //Files
            if(!is_null($stagingServiceID)){
                // Update Service
                if($stagingSupplierID === $oldStagingSupplierID){
                    // Update Service With Same Supplier
                    $updateStagingResult = update_service($stagingServiceID, $stagingSupplierID, 'STAGING', $stagingRealCost);
                }
                else{
                    // Update Service With New Supplier
                    // Delete Old Service Info And Case-service Info
                    $deleteOldServiceResult = delete_service_by_id($stagingServiceID);
                    // Insert Service Info And Case-service Info
                    $createStagingResult = create_service($MLS, $stagingSupplierID, 'STAGING', $stagingRealCost);
                }
            }
            else{
                // Insert Service Info And Case-service Info
                $createStagingResult = create_service($MLS, $stagingSupplierID, 'STAGING', $stagingRealCost);
            }
        }else{
            // Delete Service Info And Case-service Info
            $deleteOldServiceResult = delete_service_by_id($stagingServiceID);
        }
        // Touch up
        // Clean up
        // Yard work
        // Inspection
        // Storage
        // Relocate Home
        // Photography

        header("Refresh:0");
    }

    // Update Service Info
    function update_service($serviceID, $supplierID, $supplierType, $realCost){
        $updateServiceArray = array(
            "serviceID" => $serviceID,
            "serviceSupplierID" => $supplierID,
            "supplierType" => $supplierType,
            "realCost" => $realCost
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
                    <div class="houseImg"><img src="img/house.jpg"></div>
                    <div class="houseTable">
                        <div style="width:300px; padding:0px;"><h5 style="z-index:100;color:#a9a9a9; margin-top:0px; margin-left:10px;">HOUSE INFORMATION</h5></div>
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>MLS#</td>
                                <td><?php echo $caseDetailsArray['MLS'];?></td>
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
                                <td>COMMISSION RATE</td>
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
                        <th>BEFORE</th>
                        <th>AFTER</th>
                        <th>INVOICE</th>
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
                                echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
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
                        <td></td>
                        <td></td>
                        <td></td>
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
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
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
                        <td></td>
                        <td></td>
                        <td></td>
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
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
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
                        <td>NONE</td>
                        <td><a href="#">UPLOAD<a></td>
                        <td>NONE</td>
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
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
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
                        <td style="text-align:center;">-</td>
                        <td><a href="#">UPLOAD<a></td>
                        <td>NONE</td>
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
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
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
                        <td style="text-align:center;">-</td>
                        <td><a href="#">VIEW<a></td>
                        <td style="text-align:center;">-</td>
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
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
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
                        <td style="text-align:center;"><?php echo $stagingEstimatePrice; ?></td>
                        <td><?php echo '<input type="text" name="storageRealCost" value="' . $storageServiceArray['RealCost'] . '"/>'; ?></td>
                        <td style="text-align:center;">-</td>
                        <td style="text-align:center;">-</td>
                        <td><a href="#">VIEW<a></td>
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
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
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
                        <td></td>
                        <td></td>
                        <td><a href="#">VIEW<a></td>
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
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
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
                        <td style="text-align:center;">-</td>
                        <td style="text-align:center;">-</td>
                        <td style="text-align:center;">-</td>
                        <td><?php echo $photographyServiceArray['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    </tbody>
                </table>
                <div class="financial" style="display:block; float:left; margin-left:20px;">
                    <div class="line" style="float:left;">
                        <hr style="height:1px; width:500px;border:none;border-top:2px solid #a9a9a9; float:left;" />
                    </div>
                    <div class="total">
                        <h5>Total Cost: $5000.00</h5>
                        <h5>Final Commission: $15000.00</h5>
                    </div>
                    <div class="selectTeamPart">
                        <div class="selectTeam">
                            <div class="dropdown">
                                <select>
                                    <option value="1">SELECT TEAM</option>
                                    <option value="2">ONE</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="height:150px;"></div>
                </div>
                <input type="submit" value="Submit" name="submit_service_info">
            </form>
        </div>
    </div>
</div>
</div>
</body>
