<?php

// Start Session
session_start();

/*
Template Name: Agent Mobile Case Estimation 2
*/

// Init Data

$isNewPage = $_GET['RF'];
$propertyTypes = get_property_types();
//set_init_value();

//Estimate Staging
$stagingEstimatePrice = default_staging_price_estimate($houseSize);
//Estimate Photography
$photographyEstimatePrice = default_photography_price_estimate($propertyType);
//Estimate Clean Up
$cleanUpEstimatePrice = default_clean_up_price_estimate($houseSize);
//Estimate Relocate Home
$relocateHomeEstimatePrice = default_relocate_home_price_estimate();
//Estimate Touch Up
$touchUpEstimatePrice = default_touch_up_price_estimate();
//Estimate Inspection
$inspectionEstimatePrice = default_inspection_price_estimate($propertyType);
//Estimate Yard Work
$yardWorkEstimatePrice = default_yard_work_price_estimate();
//Estimate Storage
$storageEstimatePrice = default_storage_price_estimate();

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

    header('Location: ' . get_home_url() . '/agent-case-estimation/?RF=true');
}

if(isset($_POST['clear_all'])){
    set_init_value();
}

//function set_init_value(){
//    global $isNewPage;
//
//    global  $houseSize;
//    global  $landSize;
//    global  $propertyType;
//
//    global  $stagingEstimatePrice;
//    global  $photographyEstimatePrice;
//    global  $cleanUpEstimatePrice;
//    global  $touchUpEstimatePrice;
//    global  $relocateHomeEstimatePrice;
//    global  $inspectionEstimatePrice;
//    global  $yardWorkEstimatePrice;
//    global  $storageEstimatePrice;
//    global  $totalCost;
//
//    global $isStagingChecked;
//    global $isPhotographyChecked;
//    global $isCleanUpChecked;
//    global $isRelocateHomeChecked;
//    global $isTouchUpChecked;
//    global $isInspectionChecked;
//    global $isYardWordChecked;
//    global $isStorageChecked;
//
//
//    $stagingEstimatePrice =
//    $photographyEstimatePrice =
//    $cleanUpEstimatePrice =
//    $touchUpEstimatePrice =
//    $relocateHomeEstimatePrice =
//    $inspectionEstimatePrice =
//    $yardWorkEstimatePrice =
//    $storageEstimatePrice =
//    $totalCost = 0;
//    if ($isNewPage === 'true'){
//        $houseSize = $_SESSION['estimateHouseSize'];
//        $propertyType = $_SESSION['estimatePropertyType'];
//        $landSize = $_SESSION['estimateLandSize'];
//
//        $isStagingChecked = $_SESSION['isStagingChecked'];
//        $isPhotographyChecked = $_SESSION['isPhotographyChecked'];
//        $isCleanUpChecked = $_SESSION['isCleanUpChecked'];
//        $isRelocateHomeChecked = $_SESSION['isRelocateHomeChecked'];
//        $isTouchUpChecked = $_SESSION['isTouchUpChecked'];
//        $isInspectionChecked = $_SESSION['isInspectionChecked'];
//        $isYardWordChecked = $_SESSION['isYardWordChecked'];
//        $isStorageChecked = $_SESSION['isStorageChecked'];
//    }
//    else{
//        $isStagingChecked = null;
//        $isPhotographyChecked = null;
//        $isCleanUpChecked = null;
//        $isRelocateHomeChecked = null;
//        $isTouchUpChecked = null;
//        $isInspectionChecked = null;
//        $isYardWordChecked = null;
//        $isStorageChecked = null;
//    }
//}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUSTREAM</title>
    <link rel="stylesheet" type="text/css" href="../css/default.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
<div class='estimationTwoPage'>
    <div class="goBack">
        <img class="goBackButton" src="../img/goBack.png">
    </div>
    <div id="staging" style="display:none"><?php echo $stagingEstimatePrice; ?></div>
    <div id="staging" style="display:none"><?php echo $photographyEstimatePrice; ?></div>
    <div id="staging" style="display:none"><?php echo $cleanUpEstimatePrice; ?></div>
    <div id="staging" style="display:none"><?php echo $relocateHomeEstimatePrice; ?></div>
    <div id="staging" style="display:none"><?php echo $touchUpEstimatePrice; ?></div>
    <div id="staging" style="display:none"><?php echo $inspectionEstimatePrice; ?></div>
    <div id="staging" style="display:none"><?php echo $isYardWordChecked; ?></div>
    <div id="staging" style="display:none"><?php echo $storageEstimatePrice; ?></div>
    <div class='estimationTwoButton'>
        <button class="estimationTwoBlackButton">STAGING</button>
        <button class="estimationTwoBlackButton">TOUCH UP</button>
        <button class="estimationTwoWhiteButton">CLEN UP</button>
        <button class="estimationTwoBlackButton">YARWORK</button>
        <button class="estimationTwoWhiteButton">STORAGE</button>
        <button class="estimationTwoBlackButton">RELOCATION HOME</button>
        <button class="estimationTwoBlackButton">PHOTOGRAPHY</button>
        <button class="estimationTwoWhiteButton">INSPECTION</button>
    </div>
    <div class="estimateCostPart">
        <p style="font-size:11px;">ESTIMATE COST</p>
        <p style="margin-top:0px; font-size:15px;">$5000.00 CAD</p>
    </div>
</div>
</body>
</html>
