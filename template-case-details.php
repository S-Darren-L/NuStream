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

    // Init Date
    // Get Case Basic Details
    get_case_basic_details($MLS);

    // Get All Suppliers Brief Info
    $allSuppliersArray = array(); // supplier table
    $allSuppliersArray = get_all_suppliers_brief_info();

    // Get All Case Services ID
    $caseServicesArray = array();
    $caseServicesArray = get_all_case_service($MLS);

    // Set IS Each Service Enabled
    set_is_service_enabled($caseServicesArray);

    // Get Each Service Details
    $allServiceDetailArray = array(); // services table
    if(!is_null($caseServicesArray)){
        $allServiceDetailArray = get_each_service_details($caseServicesArray);
    }

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
            $getCaseArray = mysqli_fetch_array($getCaseResult);
            global $coStaffID;
            global $address;
            global $landSize;
            global $houseSize;
            global $propertyType;
            global $listingPrice;
            global $ownerName;
            global $contactNumber;
            global $coStaffName;

            $coStaffID = $getCaseArray['CoStaffID'];
            $address = $getCaseArray['Address'];
            $landSize = $getCaseArray['LandSize'];
            $houseSize = $getCaseArray['HouseSize'];
            $propertyType = $getCaseArray['PropertyType'];
            $listingPrice = $getCaseArray['ListingPrice'];
            $ownerName = $getCaseArray['OwnerName'];
            $contactNumber = $getCaseArray['ContactNumber'];
        }
        else{
            echo die("Cannot find account");
        }
        $getCoStaffResult = get_agent_account($coStaffID);
        if($getCoStaffResult !== null){
            $coStaffArray = mysqli_fetch_array($getCoStaffResult);
            $coStaffName = $coStaffArray['FirstName'] . " " . $coStaffArray['LastName'];
        }
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

    // Get All Case Services ID
    function get_all_case_service($MLS){
        $allServicesResult = get_all_case_services_by_MLS($MLS);

        while($row = mysqli_fetch_array($allServicesResult))
        {
            $servicesArray[] = $row;
        }
        return $servicesArray;
    }

    // Set IS Each Service Enabled
    function set_is_service_enabled($caseServicesArray){
        global $isStagingChecked;
        global $isTouchUpChecked;
        global $isCleanUpChecked;
        global $isYardWordChecked;
        global $isInspectionChecked;
        global $isStorageChecked;
        global $isRelocateHomeChecked;
        global $isPhotographyChecked;
        
        foreach ($caseServicesArray as $caseService){
            if($caseService['ServiceSupplierType'] === 'STAGING'){
                $isStagingChecked = 'checked';
            } else if($caseService['ServiceSupplierType'] === 'TOUCHUP'){
                $isTouchUpChecked = 'checked';
            }else if($caseService['ServiceSupplierType'] === 'CLEANUP'){
                $isCleanUpChecked = 'checked';
            }else if($caseService['ServiceSupplierType'] === 'YARDWORK'){
                $isYardWordChecked = 'checked';
            }else if($caseService['ServiceSupplierType'] === 'INSPECTION'){
                $isInspectionChecked = 'checked';
            }else if($caseService['ServiceSupplierType'] === 'STORAGE'){
                $isStorageChecked = 'checked';
            }else if($caseService['ServiceSupplierType'] === 'RELOCATEHOME'){
                $isRelocateHomeChecked = 'checked';
            }else if($caseService['ServiceSupplierType'] === 'PHOTOGRAPHY'){
                $isPhotographyChecked = 'checked';
            }
        }
    }

    // Get Each Service Details
    function get_each_service_details($caseServicesArray){
        foreach ($caseServicesArray as $caseService){
            $serviceDetailsResult = get_service_details_by_id($caseService['ServiceID']);
            $serviceDetailsArray = mysqli_fetch_array($serviceDetailsResult);
            $allServiceDetailArray[$serviceDetailsArray['SupplierType']] = $serviceDetailsArray;
        }
        return $allServiceDetailArray;
    }

    // Submit Services Info
    if(isset($_POST['submit_service_info'])) {
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
                if($stagingServiceID === $oldStagingSupplierID){
                    $updateStagingResult = update_service($stagingServiceID, $stagingSupplierID, 'STAGING', $stagingRealCost);
                }
                else{
                    // delete old service info
                    $deleteOldServiceResult = delete_service_by_id($stagingServiceID);
                    // then insert new service info
                    // then update case-service info

                }
            }
            else{
                // Insert service Info
                $createStagingResult = create_service($MLS, $stagingSupplierID, 'STAGING', $stagingRealCost);
                // Insert case-service info
            }
        }else{
            // TODO: delete all?
        }
        // Touch up
        // Clean up
        // Yard work
        // Inspection
        // Storage
        // Relocate Home
        // Photography
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

    // Create service Info
    function create_service($MLS, $supplierID, $supplierType, $realCost){
        // Insert Service
        $createServiceArray = array(
            "serviceSupplierID" => $supplierID,
            "supplierType" => $supplierType,
            "realCost" => $realCost
        );
        $createServiceResult = create_service_details($createServiceArray);
        $result_rows = [];
        while($row = mysqli_fetch_array($createServiceResult))
        {
            $result_rows[] = $row;
        }
        $serviceID = $result_rows[0]["LAST_INSERT_ID()"];

        // Insert Case-Service
        $caseCaseServiceArray = array(
            "MLS" => $MLS,
            "serviceID" => $serviceID,
            "serviceSupplierType" => $supplierType
        );
        $createCaseServiceResult = create_case_service_details($caseCaseServiceArray);
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
</head>
<body>
<div id="container">
    <?php
        include_once(__DIR__ . '/navigation.php');
    ?>
    <div id="main">
        <div class="formPart">
            <form method="post">
                <div class="houseInfo">
                    <div class="houseImg"><img src="img/house.jpg"></div>
                    <div class="houseTable">
                        <div style="width:300px; padding:0px;"><h5 style="z-index:100;color:#a9a9a9; margin-top:0px; margin-left:10px;">HOUSE INFORMATION</h5></div>
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>MLS#</td>
                                <td><?php echo $MLS;?></td>
                            </tr>
                            <tr>
                                <td>ADDRESS</td>
                                <td><?php echo $address;?></td>
                            </tr>
                            <tr>
                                <td>PROPERTY TYPE</td>
                                <td><?php echo $propertyType;?></td>
                            </tr>
                            <tr>
                                <td>LAND SIZE (LOT)</td>
                                <td><?php echo $landSize;?></td>
                            </tr>
                            <tr>
                                <td>HOUSE SIZE(SQF)</td>
                                <td><?php echo $houseSize;?></td>
                            </tr>
                            <tr>
                                <td>LISTING PRICE</td>
                                <td><?php echo $listingPrice;?></td>
                            </tr>
                            <tr>
                                <td>OWNER'S NAME</td>
                                <td><?php echo $ownerName;?></td>
                            </tr>
                            <tr>
                                <td>TEAM MEMBER'S NAME</td>
                                <td><?php echo $coStaffName;?></td>
                            </tr>
                            <tr>
                                <td>COMMISSION RATE</td>
                                <td>2.25%</td>
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
                        <td><input type="checkbox" name="stagingCheckbox" value='checked' <?php echo $isStagingChecked; ?>></td>
                        <td>STAGING</td>
                        <td>
                            <?php
                                echo '<select name="stagingSelect">';
                                if(is_null($allServiceDetailArray['STAGING']['ServiceSupplierID']))
                                    $isDefaultSelected = 'selected';
                                echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
                                foreach ($allSuppliersArray['STAGING'] as $stagingSupplierItem){
                                    if(!is_null($allServiceDetailArray['STAGING']['ServiceSupplierID']) && $allServiceDetailArray['STAGING']['ServiceSupplierID'] === $stagingSupplierItem['SupplierID']){
                                        $isSelected = 'selected';
                                    }else {
                                        $isSelected = null;
                                    }
                                    echo '<option value="' . $stagingSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $stagingSupplierItem['SupplierName'], '</option>';
                                }
                                echo '</select>';
                            ?>
                        </td>
                        <td style="text-align:center;">$360</td>
                        <td><?php echo '<input type="text" name="stagingRealCost" value="' . $allServiceDetailArray['STAGING']['RealCost'] . '"/>'; ?></td>
                        <td><a href="#">UPLOAD<a></td>
                        <td><a href="#">UPLOAD<a></td>
                        <td><a href="#">UPLOAD<a></td>
                        <td><?php echo $allServiceDetailArray['STAGING']['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="touchUpCheckbox" value='checked' <?php echo $isTouchUpChecked; ?>></td>
                        <td>TOUCH UP</td>
                        <td>
                            <?php
                            echo '<select name="touchUpSelect">';
                            if(is_null($allServiceDetailArray['TOUCHUP']['ServiceSupplierID']))
                                $isDefaultSelected = 'selected';
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
                            foreach ($allSuppliersArray['TOUCHUP'] as $touchUpSupplierItem){
                                if(!is_null($allServiceDetailArray['TOUCHUP']['ServiceSupplierID']) && $allServiceDetailArray['TOUCHUP']['ServiceSupplierID'] === $touchUpSupplierItem['SupplierID']){
                                    $isSelected = 'selected';
                                }else {
                                    $isSelected = null;
                                }
                                echo '<option value="' . $touchUpSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $touchUpSupplierItem['SupplierName'], '</option>';
                            }
                            echo '</select>';
                            ?>
                        </td>
                        <td style="text-align:center;">$360</td>
                        <td><?php echo '<input type="text" name="touchUpRealCost" value="' . $allServiceDetailArray['TOUCHUP']['RealCost'] . '"/>'; ?></td>
                        <td><a href="#">UPLOAD<a></td>
                        <td><a href="#">UPLOAD<a></td>
                        <td><a href="#">UPLOAD<a></td>
                        <td><?php echo $allServiceDetailArray['TOUCHUP']['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="cleanUpCheckbox" value='checked' <?php echo $isCleanUpChecked; ?>></td>
                        <td>CLEAN UP</td>
                        <td>
                            <?php
                            echo '<select name="cleanUpSelect">';
                            if(is_null($allServiceDetailArray['CLEANUP']['ServiceSupplierID']))
                                $isDefaultSelected = 'selected';
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
                            foreach ($allSuppliersArray['CLEANUP'] as $cleanUpSupplierItem){
                                if(!is_null($allServiceDetailArray['CLEANUP']['ServiceSupplierID']) && $allServiceDetailArray['CLEANUP']['ServiceSupplierID'] === $cleanUpSupplierItem['SupplierID']){
                                    $isSelected = 'selected';
                                }else {
                                    $isSelected = null;
                                }
                                echo '<option value="' . $cleanUpSupplierItem['SupplierID'] . '" ' . $isSelected . ' >', $cleanUpSupplierItem['SupplierName'], '</option>';
                            }
                            echo '</select>';
                            ?>
                        </td>
                        <td style="text-align:center;">$360</td>
                        <td><?php echo '<input type="text" name="cleanUpRealCost" value="' . $allServiceDetailArray['CLEANUP']['RealCost'] . '"/>'; ?></td>
                        <td>NONE</td>
                        <td><a href="#">UPLOAD<a></td>
                        <td>NONE</td>
                        <td><?php echo $allServiceDetailArray['CLEANUP']['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="yardWorkCheckbox" value='checked' <?php echo $isYardWordChecked; ?>></td>
                        <td>YARD WORK</td>
                        <td>
                            <?php
                            echo '<select name="yardWorkSelect">';
                            if(is_null($allServiceDetailArray['YARDWORK']['ServiceSupplierID']))
                                $isDefaultSelected = 'selected';
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
                            foreach ($allSuppliersArray['YARDWORK'] as $yardWorkSupplierItem){
                                if(!is_null($allServiceDetailArray['YARDWORK']['ServiceSupplierID']) && $allServiceDetailArray['YARDWORK']['ServiceSupplierID'] === $yardWorkSupplierItem['SupplierID']){
                                    $isSelected = 'selected';
                                }else {
                                    $isSelected = null;
                                }
                                echo '<option value="' . $yardWorkSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $yardWorkSupplierItem['SupplierName'], '</option>';
                            }
                            echo '</select>';
                            ?>
                        </td>
                        <td style="text-align:center;">$360</td>
                        <td><?php echo '<input type="text" name="yardWorkRealCost" value="' . $allServiceDetailArray['YARDWORK']['RealCost'] . '"/>'; ?></td>
                        <td style="text-align:center;">-</td>
                        <td><a href="#">UPLOAD<a></td>
                        <td>NONE</td>
                        <td><?php echo $allServiceDetailArray['YARDWORK']['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="inspectionCheckbox" value='checked' <?php echo $isInspectionChecked; ?>></td>
                        <td>INSPECTION</td>
                        <td>
                            <?php
                            echo '<select name="inspectionSelect">';
                            if(is_null($allServiceDetailArray['INSPECTION']['ServiceSupplierID']))
                                $isDefaultSelected = 'selected';
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
                            foreach ($allSuppliersArray['INSPECTION'] as $inspectionSupplierItem){
                                if(!is_null($allServiceDetailArray['INSPECTION']['ServiceSupplierID']) && $allServiceDetailArray['INSPECTION']['ServiceSupplierID'] === $inspectionSupplierItem['SupplierID']){
                                    $isSelected = 'selected';
                                }else {
                                    $isSelected = null;
                                }
                                echo '<option value="' . $inspectionSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $inspectionSupplierItem['SupplierName'], '</option>';
                            }
                            echo '</select>';
                            ?>
                        </td>
                        <td style="text-align:center;">$360</td>
                        <td><?php echo '<input type="text" name="inspectionRealCost" value="' . $allServiceDetailArray['INSPECTION']['RealCost'] . '"/>'; ?></td>
                        <td style="text-align:center;">-</td>
                        <td><a href="#">VIEW<a></td>
                        <td style="text-align:center;">-</td>
                        <td><?php echo $allServiceDetailArray['INSPECTION']['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="storageCheckbox" value='checked' <?php echo $isStorageChecked; ?>></td>
                        <td>STORAGE</td>
                        <td>
                            <?php
                            echo '<select name="storageSelect">';
                            if(is_null($allServiceDetailArray['STORAGE']['ServiceSupplierID']))
                                $isDefaultSelected = 'selected';
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
                            foreach ($allSuppliersArray['STORAGE'] as $storageSupplierItem){
                                if(!is_null($allServiceDetailArray['STORAGE']['ServiceSupplierID']) && $allServiceDetailArray['STORAGE']['ServiceSupplierID'] === $storageSupplierItem['SupplierID']){
                                    $isSelected = 'selected';
                                }else {
                                    $isSelected = null;
                                }
                                echo '<option value="' . $storageSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $storageSupplierItem['SupplierName'], '</option>';
                            }
                            echo '</select>';
                            ?>
                        </td>
                        <td style="text-align:center;">$360</td>
                        <td><?php echo '<input type="text" name="storageRealCost" value="' . $allServiceDetailArray['STORAGE']['RealCost'] . '"/>'; ?></td>
                        <td style="text-align:center;">-</td>
                        <td style="text-align:center;">-</td>
                        <td><a href="#">VIEW<a></td>
                        <td><?php echo $allServiceDetailArray['STORAGE']['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="relocateHomeCheckbox" value='checked' <?php echo $isRelocateHomeChecked; ?>></td>
                        <td>RELOCATE HOME</td>
                        <td>
                            <?php
                            echo '<select name="relocateHomeSelect">';
                            if(is_null($allServiceDetailArray['RELOCATEHOME']['ServiceSupplierID']))
                                $isDefaultSelected = 'selected';
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
                            foreach ($allSuppliersArray['RELOCATEHOME'] as $relocateHomeSupplierItem){
                                if(!is_null($allServiceDetailArray['RELOCATEHOME']['ServiceSupplierID']) && $allServiceDetailArray['RELOCATEHOME']['ServiceSupplierID'] === $relocateHomeSupplierItem['SupplierID']){
                                    $isSelected = 'selected';
                                }else {
                                    $isSelected = null;
                                }
                                echo '<option value="' . $relocateHomeSupplierItem['SupplierID'] . '" ' . $isSelected . '>', $relocateHomeSupplierItem['SupplierName'], '</option>';
                            }
                            echo '</select>';
                            ?>
                        </td>
                        <td style="text-align:center;">$360</td>
                        <td><?php echo '<input type="text" name="relocateHomeRealCost" value="' . $allServiceDetailArray['RELOCATEHOME']['RealCost'] . '"/>'; ?></td>
                        <td></td>
                        <td></td>
                        <td><a href="#">VIEW<a></td>
                        <td><?php echo $allServiceDetailArray['RELOCATEHOME']['InvoiceStatus'] ?? '-'; ?></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="photographyCheckbox" value='checked' <?php echo $isPhotographyChecked; ?>></td>
                        <td>PHOTOGRAPHY</td>
                        <td>
                            <?php
                            echo '<select name="photographySelect">';
                            if(is_null($allServiceDetailArray['PHOTOGRAPHY']['ServiceSupplierID']))
                                $isDefaultSelected = 'selected';
                            echo '<option selected="' . $isDefaultSelected . '" value="">- supplier -</option>';
                            foreach ($allSuppliersArray['PHOTOGRAPHY'] as $photographySupplierItem){
                                if(!is_null($allServiceDetailArray['PHOTOGRAPHY']['ServiceSupplierID']) && $allServiceDetailArray['PHOTOGRAPHY']['ServiceSupplierID'] === $photographySupplierItem['SupplierID']){
                                    $isSelected = 'selected';
                                }else {
                                    $isSelected = null;
                                }
                                echo '<option value="' . $photographySupplierItem['SupplierID'] . '" ' . $isSelected . '>', $photographySupplierItem['SupplierName'], '</option>';
                            }
                            echo '</select>';
                            ?>
                        </td>
                        <td style="text-align:center;">$360</td>
                        <td><?php echo '<input type="text" name="photographyRealCost" value="' . $allServiceDetailArray['PHOTOGRAPHY']['RealCost'] . '"/>'; ?></td>
                        <td style="text-align:center;">-</td>
                        <td style="text-align:center;">-</td>
                        <td style="text-align:center;">-</td>
                        <td><?php echo $allServiceDetailArray['PHOTOGRAPHY']['InvoiceStatus'] ?? '-'; ?></td>
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
