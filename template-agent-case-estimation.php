<?php

// Start Session
session_start();

/*
Template Name: Agent Case Estimation
*/

    // Init Data

    $isNewPage = $_REQUEST['NEW'];
    $propertyTypes = get_property_types();
    set_init_value();

    //Estimate
    if(isset($_POST['estimate'])){
        $houseSize = $_POST['houseSize'];
        $propertyType = $_POST['propertyType'];
        $landSize = $_POST['landSize'];

        $isStagingChecked = $_POST['stagingCheckBox'];
        $isPhotographyChecked = $_POST['photographyCheckBox'];
        $isCleanUpChecked = $_POST['cleanUpCheckBox'];
        $isRelocateHomeChecked = $_POST['relocateHomeCheckBox'];
        $isTouchUpChecked = $_POST['touchUpCheckBox'];
        $isInspectionChecked = $_POST['inspectionCheckBox'];
        $isYardWordChecked = $_POST['yardWordCheckBox'];
        $isStorageChecked = $_POST['storageCheckBox'];

        //Estimate Staging
        if($isStagingChecked === 'checked')
            $stagingEstimatePrice = default_staging_price_estimate($houseSize);
        //Estimate Photography
        if($isPhotographyChecked === 'checked')
            $photographyEstimatePrice = default_photography_price_estimate($propertyType);
        //Estimate Clean Up
        if($isCleanUpChecked === 'checked')
            $cleanUpEstimatePrice = default_clean_up_price_estimate($houseSize);
        //Estimate Relocate Home
        if($isRelocateHomeChecked === 'checked')
            $relocateHomeEstimatePrice = default_relocate_home_price_estimate();
        //Estimate Touch Up
        if($isTouchUpChecked === 'checked')
            $touchUpEstimatePrice = default_touch_up_price_estimate();
        //Estimate Inspection
        if($isInspectionChecked === 'checked')
            $inspectionEstimatePrice = default_inspection_price_estimate($propertyType);
        //Estimate Yard Work
        if($isYardWordChecked === 'checked')
            $yardWorkEstimatePrice = default_yard_work_price_estimate();
        //Estimate Storage
        if($isStorageChecked === 'checked')
            $storageEstimatePrice = default_storage_price_estimate();
        // Total Cost
        $totalCost = $stagingEstimatePrice + $photographyEstimatePrice + $cleanUpEstimatePrice + $relocateHomeEstimatePrice + $touchUpEstimatePrice + $inspectionEstimatePrice + $yardWorkEstimatePrice + $storageEstimatePrice;

        $_SESSION['estimateHouseSize'] = $houseSize;
        $_SESSION['estimatePropertyType'] = $propertyType;
        $_SESSION['estimateLandSize'] = $landSize;

        $_SESSION['isStagingChecked'] = $isStagingChecked;
        $_SESSION['isPhotographyChecked'] = $isPhotographyChecked;
        $_SESSION['isCleanUpChecked'] = $isCleanUpChecked;
        $_SESSION['isRelocateHomeChecked'] = $isRelocateHomeChecked;
        $_SESSION['isTouchUpChecked'] = $isTouchUpChecked;
        $_SESSION['isInspectionChecked'] = $isInspectionChecked;
        $_SESSION['isYardWordChecked'] = $isYardWordChecked;
        $_SESSION['isStorageChecked'] = $isStorageChecked;
    }

    if(isset($_POST['clear_all'])){
        set_init_value();
    }

    function set_init_value(){
        global $isNewPage;

        global  $houseSize;
        global  $landSize;
        global  $propertyType;

        global  $stagingEstimatePrice;
        global  $photographyEstimatePrice;
        global  $cleanUpEstimatePrice;
        global  $touchUpEstimatePrice;
        global  $relocateHomeEstimatePrice;
        global  $inspectionEstimatePrice;
        global  $yardWorkEstimatePrice;
        global  $storageEstimatePrice;
        global  $totalCost;

        global $isStagingChecked;
        global $isPhotographyChecked;
        global $isCleanUpChecked;
        global $isRelocateHomeChecked;
        global $isTouchUpChecked;
        global $isInspectionChecked;
        global $isYardWordChecked;
        global $isStorageChecked;


        $stagingEstimatePrice =
        $photographyEstimatePrice =
        $cleanUpEstimatePrice =
        $touchUpEstimatePrice =
        $relocateHomeEstimatePrice =
        $inspectionEstimatePrice =
        $yardWorkEstimatePrice =
        $storageEstimatePrice =
        $totalCost = 0;
        if ($isNewPage === 0){
            $houseSize = $_SESSION['estimateHouseSize'];
            $propertyType = $_SESSION['estimatePropertyType'];
            $landSize = $_SESSION['estimateLandSize'];

            $isStagingChecked = $_SESSION['isStagingChecked'];
            $isPhotographyChecked = $_SESSION['isPhotographyChecked'];
            $isCleanUpChecked = $_SESSION['isCleanUpChecked'];
            $isRelocateHomeChecked = $_SESSION['isRelocateHomeChecked'];
            $isTouchUpChecked = $_SESSION['isTouchUpChecked'];
            $isInspectionChecked = $_SESSION['isInspectionChecked'];
            $isYardWordChecked = $_SESSION['isYardWordChecked'];
            $isStorageChecked = $_SESSION['isStorageChecked'];
        }
        else{
            $isStagingChecked = null;
            $isPhotographyChecked = null;
            $isCleanUpChecked = null;
            $isRelocateHomeChecked = null;
            $isTouchUpChecked = null;
            $isInspectionChecked = null;
            $isYardWordChecked = null;
            $isStorageChecked = null;
        }
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

    .formPart {
        display: relative;
        margin-right: 40px;
        margin-left: 40px;
        padding-top: 40px;
    }

    .tablePart {
        float: left;
        width: 400px;
        margin-left: 0px;
    }

    .table-style {
        width: 300px !important;
        padding-left:20px;
        margin-left: 20px;
        border-color: #fff;
    }

    .table-style th{
        font-size: 10px;
        color:#a9a9a9;
    }

    .table-style td{
        border: 2px solid #fff;
        color:#a9a9a9;
    }

     .estimationPart {
        margin-left: 420px;
        background-color: #32323a;
        height: 210px;
        width: 270px;
        color:#a9a9a9;
        border-radius: 2px;
    }

    .estimateButtonPart {
        display: absolute;
        margin-left: 440px;
    }

    .clearAllPart {
        padding-left: 120px;
        margin-top: -30px;
    }

    .clearAllButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: bold;
        height: 30px;
        width: 100px;
        font-size: 11px;
    }

    .estimatePart {
        margin-top: 20px;
    }

    .estimateButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: bold;
        height: 30px;
        width: 100px;
        font-size: 11px;
    }

    .estimationAgentSelect {
        color:#a9a9a9! important;
        width: 185px;
    }

    .estimationAgentOption {
        height:30px;
    }
</style>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
                <div class="tablePart">
                    <table>
                        <table class="table table-style">
                            <thead style="background-color:#fffeff">
                            <th></th>
                            <th>SERVERTYPE</th>
                            <th>ESTIMATE COST</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="checkbox" name="stagingCheckBox" value="checked" <?php echo $isStagingChecked; ?>></td>
                                <td>STAGING</td>
                                <td style="text-align:center;"><?php echo $stagingEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="touchUpCheckBox" value="checked" <?php echo $isTouchUpChecked; ?>></td>
                                <td>TOUCH UP</td>
                                <td style="text-align:center;"><?php echo $touchUpEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="cleanUpCheckBox" value="checked" <?php echo $isCleanUpChecked; ?>></td>
                                <td>CLEAN UP</td>
                                <td style="text-align:center;"><?php echo $cleanUpEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="yardWordCheckBox" value="checked" <?php echo $isYardWordChecked; ?>></td>
                                <td>YARD WORK</td>
                                <td style="text-align:center;"><?php echo $yardWorkEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="inspectionCheckBox" value="checked" <?php echo $isInspectionChecked; ?>></td>
                                <td>INSPECTION</td>
                                <td style="text-align:center;"><?php echo $inspectionEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="storageCheckBox" value="checked" <?php echo $isStorageChecked; ?>></td>
                                <td>STORAGE</td>
                                <td style="text-align:center;"><?php echo $storageEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="relocateHomeCheckBox" value="checked" <?php echo $isRelocateHomeChecked; ?>></td>
                                <td>RELOCATE HOME</td>
                                <td style="text-align:center;"><?php echo $relocateHomeEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="photographyCheckBox" value="checked" <?php echo $isPhotographyChecked; ?>></td>
                                <td>PHOTOGRAPHY</td>
                                <td style="text-align:center;"><?php echo $photographyEstimatePrice;?></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="line" >
                            <hr style="height:1px; width:300px;border:none;border-top:2px solid #a9a9a9; float:left; margin:2px 5px 5px 15px;" />	</br>
                        </div>
                        <h4 style="margin-left:20px;color:#a9a9a9; font-size:15px;">Total Cost:  <?php echo $totalCost; ?></h4>
                </div>
                <div class="estimationPart">
                    <h4 style="padding:10px 0 0 10px;">ESTIMATION</h4>
                    <div class="line" >
                        <hr style="height:1px; width:240px;border:none;border-top:1px solid #fff; float:left; margin:2px 5px 5px 10px;" />	</br>
                    </div>
                    <input type="number" name="houseSize" value="<?php echo $houseSize; ?>" placeholder="HOUSE SIZE*" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;" size="30" require />
                    <select  name="propertyType" class="estimationAgentSelect" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;">
                        <?php
                                foreach ($propertyTypes as $propertyTypeItem){
                                    global $propertyType;
                                    $isSelected = $propertyTypeItem === $propertyType ? 'selected' : null;
                                    echo '<option class="estimationAgentOption" value="' . $propertyTypeItem . '" ' . $isSelected . '>', $propertyTypeItem, '</option>';
                                }
                                ?>
                    </select>
                    <input type="number" name="landSize" value="<?php echo $landSize; ?>" placeholder="LAND SIZE*" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;" size="30" require />
                </div>
                <div class="estimateButtonPart">
                    <div class="estimatePart">
                        <input name="NEW" value="0" hidden="hidden">
                        <input type="submit" value="ESTIMATE" class="estimateButton" name="estimate">
                    </div>
                    <div class="clearAllPart">
                        <input type="submit" value="CLEAR ALL" class="clearAllButton" name="clear_all">
                    </div>
            </form>
        </div>
    </div>
</div>
</body>