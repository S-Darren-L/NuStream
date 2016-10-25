<?php

// Start Session
session_start();

/*
Template Name: Agent Mobile Case Estimation
*/

// Init Data

$isNewPage = $_GET['RF'];
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

    header('Location: ' . get_home_url() . '/agent-case-estimation/?RF=true');
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
    if ($isNewPage === 'true'){
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
<div class='estimationPage'>
    <div class="goBack">
        <img class="goBackButton" src="../img/goBack.png">
    </div>
    <div class="estimationTitlePart">
        <h2>ESTIMATION</h2>
    </div>
    <div class='estimationInput'>
        <div class='estimationInputPart'>
            <input class="estimationInputStyle" id="houseSizeInput" placeholder='HOUSE SIZE *' type='text' size="30">
            </input>
        </div>
        <div class='estimationInputPart'>
            <input class="estimationInputStyle" id="propertySizeInput" placeholder='PROPERTY SIZE *' type='text' size="30">
            </input>
        </div>
        <div class='estimationInputPart'>
            <input class="estimationInputStyle" id="landSizeInput" placeholder='LAND SIZE *' type='text' size="30">
        </div>
    </div>
    <div class="estimationButtonPart">
        <button class="estimationButton">SUBMIT</button>
    </div>
</div>
</body>
</html>
