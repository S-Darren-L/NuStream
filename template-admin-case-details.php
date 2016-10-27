<?php

// Start Session
session_start();

/*
Template Name: Admin Case Details
*/

    // Get Case ID
    $MLS = $_GET['CID'];
    $isRefreshPage = $_GET['RF'];
    $uploadBasePath = "wp-content/themes/NuStream/Upload/case/" . $MLS;
    $PageURL = get_home_url() . '/admin-case-details';
    $invoiceStatuses = get_invoice_statuses();
    $houseImageURL =  get_home_url() . "/wp-content/themes/NuStream/Upload/case/" . $MLS . "/HouseImage/";
    $defaultHouseImageURL =  get_home_url() . "/wp-content/themes/NuStream/img/house.jpg";

// Init Date
    // Get Case Statuses
    $caseStatuses = get_case_statuses();

    // Get Case Basic Details
    $caseDetailsArray = array();
    $caseDetailsArray = get_case_basic_details($MLS);

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

    // Get All Files
    $stagingImageFilesArray = get_staging_files();
    $cleanUpImageFilesArray = get_clean_up_files();
    $touchUpImageFilesArray = get_touch_up_files();
    $yardWorkImageFilesArray = get_yard_work_files();
    $inspectionImageFilesArray = get_inspection_files();
    $storageImageFilesArray = get_storage_files();
    $relocateHomeImageFilesArray = get_relocate_home_files();
    $stagingImageFilesArray = get_staging_files();

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

    // Get Service Details By ID
    function get_service_detail($serviceID){
        global $isRefreshPage;
        $serviceDetailsResult = get_service_details_by_id($serviceID);
        $serviceDetailsArray = mysqli_fetch_array($serviceDetailsResult);
        $isActive = $isRefreshPage === "1" ? $_SESSION['CaseEstimate'][$serviceID]['isServiceChecked'] : $serviceDetailsArray['IsActivate'];
        $serviceDetailsArray['IsChecked'] = $isActive === 'checked' ? 'checked' : null;
        $serviceDetailsArray['IsDisabled'] = $serviceDetailsArray['InvoiceStatus'] === 'APPROVED' ? 'disabled' : null;
        if($isRefreshPage === '1'){
            $serviceDetailsArray['ServiceSupplierID'] = $_SESSION['CaseEstimate'][$serviceID]['supplierID'];
            $serviceDetailsArray['RealCost'] = $_SESSION['CaseEstimate'][$serviceID]['serviceRealCost'];
        }
        return $serviceDetailsArray;
    }

    // Get All Files
    function get_staging_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/Staging/";
        $stagingImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "BeforeLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "LivingRoom/")),
            "BeforeDinningRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "DinningRoom/")),
            "BeforeMasterRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "MasterRoom/")),
            "AfterLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "LivingRoom/")),
            "AfterDinningRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "DinningRoom/")),
            "AfterMasterRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "MasterRoom/"))
        );
        return $stagingImageFilesArray;
    }
    function get_clean_up_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/CleanUp/";
        $cleanUpImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "BeforeLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "LivingRoom/")),
            "BeforeKitchen" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "Kitchen/")),
            "BeforeWashRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "WashRoom/")),
            "AfterLivingRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "LivingRoom/")),
            "AfterKitchen" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "Kitchen/")),
            "AfterWashRoom" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "WashRoom/"))
        );
        return $cleanUpImageFilesArray;
    }
    function get_touch_up_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/TouchUp/";
        $touchUpImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "Before1" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "1/")),
            "Before1" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "2/")),
            "Before3" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "3/")),
            "Before4" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "4/")),
            "Before5" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "5/")),
            "After1" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "1/")),
            "After2" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "2/")),
            "After3" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "3/")),
            "After4" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "4/")),
            "After5" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "5/"))
        );
        return $touchUpImageFilesArray;
    }
    function get_yard_work_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/YardWork/";
        $yardWorkImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "BeforeFrontYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "FrontYard/")),
            "BeforeBackYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "Before/" . "BackYard/")),
            "AfterFrontYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "FrontYard/")),
            "AfterBackYard" => mysqli_fetch_array(download_file_by_path($uploadPath . "After/" . "BackYard/"))
        );
        return $yardWorkImageFilesArray;
    }
    function get_inspection_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/Inspection/";
        $inspectionImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/")),
            "Report" => mysqli_fetch_array(download_file_by_path($uploadPath . "Report/"))
        );
        return $inspectionImageFilesArray;
    }
    function get_storage_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/Storage/";
        $storageImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/"))
        );
        return $storageImageFilesArray;
    }
    function get_relocate_home_files(){
        global $uploadBasePath;
        $uploadPath = $uploadBasePath . "/RelocateHome/";
        $relocateHomeImageFilesArray = array(
            "Invoice" => mysqli_fetch_array(download_file_by_path($uploadPath . "Invoice/"))
        );
        return $relocateHomeImageFilesArray;
    }

    // Submit
    if(isset($_POST['submit'])){
        if($stagingServiceArray['IsActivate'] === '1'){
            update_service_status($stagingServiceArray['ServiceID'], $_POST['stagingStatus']);
        }
        if($touchUpServiceArray['IsActivate'] === '1'){
            update_service_status($touchUpServiceArray['ServiceID'], $_POST['cleanUpStatus']);
        }
        if($cleanUpServiceArray['IsActivate'] === '1'){
            update_service_status($cleanUpServiceArray['ServiceID'], $_POST['touchUpStatus']);
        }
        if($yardWorkServiceArray['IsActivate'] === '1'){
            update_service_status($yardWorkServiceArray['ServiceID'], $_POST['yardWorkStatus']);
        }
        if($inspectionServiceArray['IsActivate'] === '1'){
            update_service_status($inspectionServiceArray['ServiceID'], $_POST['inspectionStatus']);
        }
        if($storageServiceArray['IsActivate'] === '1'){
            update_service_status($storageServiceArray['ServiceID'], $_POST['storageStatus']);
        }
        if($relocateHomeServiceArray['IsActivate'] === '1'){
            update_service_status($relocateHomeServiceArray['ServiceID'], $_POST['relocateHomeStatus']);
        }
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    // Approve All
    if(isset($_POST['approve_all'])){
        if($stagingServiceArray['IsActivate'] === '1'){
            update_service_status($stagingServiceArray['ServiceID'], 'APPROVED');
        }
        if($touchUpServiceArray['IsActivate'] === '1'){
            update_service_status($touchUpServiceArray['ServiceID'], 'APPROVED');
        }
        if($cleanUpServiceArray['IsActivate'] === '1'){
            update_service_status($cleanUpServiceArray['ServiceID'], 'APPROVED');
        }
        if($yardWorkServiceArray['IsActivate'] === '1'){
            update_service_status($yardWorkServiceArray['ServiceID'], 'APPROVED');
        }
        if($inspectionServiceArray['IsActivate'] === '1'){
            update_service_status($inspectionServiceArray['ServiceID'], 'APPROVED');
        }
        if($storageServiceArray['IsActivate'] === '1'){
            update_service_status($storageServiceArray['ServiceID'], 'APPROVED');
        }
        if($relocateHomeServiceArray['IsActivate'] === '1'){
            update_service_status($relocateHomeServiceArray['ServiceID'], 'APPROVED');
        }
        header('location: ' . $PageURL . '/?CID=' . $MLS);
    }

    // Download FIle
    if(isset($_GET['File'])){
        download_file($_GET['File']);
    }

?>

<!DOCTYPE html>
<style type="text/css">
    /*------------------------------------nav bar css---------------------------------*/
    html, body {
        margin:0;
        padding:0;
        background-color: #eeeeee !important;
        font-family: Arial!important;
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
        margin-top: -54px;
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

    .formPart {
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

    /*--------------------------template css for all page----------------------*/

    .title {
        padding:5px 0 5px 0;
        margin-top:89px;
        margin-left: 23px;
        background-color: #fff;
        border-left:5px #0068b7 solid;
        border-bottom:1px #eeeeee solid;
        width: 600px;
    }
    .titleSize {
        font-size: 20px;
        margin:0px;
        padding-left:23px;
    }

    .contentPart {
        padding-top: 20px;
        background-color: #fff;
        color:#a9a9a9;
        height: 400px;
        width: 600px;
        font-size: 12px;
        margin-left: 23px;
    }


    /*--------------------------template-agent-create-case----------------------*/

    .inputPart {
        padding-top: 20px;
        background-color: #fff;
        color:#a9a9a9;
        height: 400px;
        width: 600px;
        font-size: 12px;
        margin-left: 23px;
    }

    .oneLineDiv {
        display: relative;
        height: 45px;
        padding: 0px;
        margin: 0px;
        vertical-align:middle;
        padding:10px 0 0 0;
    }

    .requireTitle {
        height: 30px;
        padding-left:23px;
        float:left;
        vertical-align: middle;
        line-height: 30px;
        display: absolute;
    }

    .inputContent {
        display: absolute;
        padding:0 0 0 143px;
        margin:0px;
        width: 150px;
    }

    .secondTitle {
        margin:-30px 0 0 280px;

    }

    .secondInput {
        margin: -30px 0 0 415px;
    }

    input {
        border-radius: 3px;
        border:1px #a9a9a9 solid;
        width: 150px;
        height: 30px;
    }

    fieldset {
        overflow: hidden
    }

    .dropdown {
        height: 30px;
        width: 150px;
    }

    select {
        border-radius: 3px;
        height: 30px;
        width: 150px;
    }

    .createButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: 100px;
        height: 30px;
        width: 150px;
    }

    .PropertyType select {
        border-radius: 3px;
        height: 30px;
        width: 150px;
    }

    .coListingTitle {
        margin-top: -60px;
        margin-left: 290px;
    }

    .photoUploadButton {
        font-size: 11px;
        color:#a9a9a9;
        background-color: #fff;
        border:1px #a9a9a9 solid;
        width: 150px;
        height: 30px;
        border-radius: 3px;
    }

    .error-message a{
        color: red;
        font-size: 80%;
    }


    /*------------------------------------table page css--------------------------------------*/
    .tablePageTitle {
        width:800px;
        margin:0 auto;
    }
    .title img {
        width: 100%;
    }

    .tablePart table {
        text-align: center;
        border:1px #000 solid;
        width:800px;
        margin:0 auto;
    }

    /*------------------------------------File Approvement Admin css--------------------------------------*/

    .FAFContentPart {
        padding-top: 20px;
        background-color: #fff;
        color:#a9a9a9;
        height: 240px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom:1px #eeeeee solid;
    }
    /*File Approvement Page First Title*/
    .FAFTitle {
        padding:5px 0 5px 0;
        margin-top:54px;
        margin-left: 23px;
        background-color: #fff;
        border-left:5px #0068b7 solid;
        border-bottom:1px #eeeeee solid;
        width: 750px;
    }

    .FANormalTitle {
        padding:5px 0 5px 0;
        margin-top:10px;
        margin-left: 23px;
        background-color: #fff;
        border-left:5px #0068b7 solid;
        border-bottom:1px #eeeeee solid;
        width: 750px;
    }

    .FASContentPart {
        padding-top: 10px;
        background-color: #fff;
        color:#a9a9a9;
        height: 270px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom:1px #eeeeee solid;
    }
    .table-striped {
        width: 775px !important;
        padding-left:20px;
        margin-left: 20px;
    }

    .table-striped th{
        font-size: 10px;
        color:#a9a9a9;
    }

    .table-striped td{
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
        /*  margin-top: 0px;
            margin-left: 0px;*/
        width: 400px !important;
        height: 200px !important;
        color: #a9a9a9;
    }

    .houseInfo {
        width: 100%;
        overflow: hidden;
        padding-left: 20px;
        background-color: #fff;
    }

    .houseImg {
        height: 200px;
        width: 300px;
        float: left;
        /*padding-top:25px;*/
    }

    .houseImg img {
        width: 100%;
    }

    .houseTable {
        width: 300px;
        margin-left: 300px;
    }



    .FAFSubTitle {
        font-weight:bold;
        padding-left: 23px;
        float: left;
        padding-top: 5px;
        width: 100px;
    }

    .FASubTitleUpload {
        margin-left: 10px;
        width: 100px;
        float: left;
        padding-top: 5px;
    }

    .FASelectType {
        height: 30px;
        width: 80px;
        margin-left: 360px;

    }

    .FASelectType select {
        border-radius: 3px;
        height: 30px;
        width: 80px;
    }

    .FASCPSLine {
        float:left;
        height: 100px;
        width: 750px;
        margin-top: 10px;
        margin-left: 20px;
    }

    .FASSubTitle {
        font-weight:bold;
        padding-left: 23px;
        float: left;
        padding-top: 5px;
        color:#a9a9a9;
    }
    .FAImage {
        float:left;
        height: 70px;
        width: 130px;
        border: 1px blue dashed;
        margin:0 25px;

    }

    .FAtable {
        float:left;
    }


    .FAtable td {
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: center;
    }

    .FASCPTLine {
        float:left;
        height: 100px;
        width: 750px;
        margin-top: 10px;
        margin-left: 20px;
    }

    .FATContentPart {
        padding-top: 10px;
        background-color: #fff;
        color:#a9a9a9;
        height: 270px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom:1px #eeeeee solid;
    }

    .FAFoContentPart {
        padding-top: 10px;
        background-color: #fff;
        color:#a9a9a9;
        height: 270px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom:1px #eeeeee solid;
    }

    .FAImageTouchUp {
        float:left;
        height: 70px;
        width: 80px;
        border: 1px blue dashed;
        margin:0 10px;
    }

    .FAImageYardWork {
        float:left;
        height: 80px;
        width: 170px;
        border: 1px blue dashed;
        margin:0 25px;
    }

    .FASubTitleInsoection {
        margin-left: 10px;
        width: 150px;
        float: left;
        padding-top: 5px;
    }

    .FASubTitleInvoice {
        margin-left: 20px;
        width: 150px;
        float: left;
        padding-top: 5px;
    }

    .FASelectTypeInspection {
        height: 30px;
        width: 80px;
        margin-left: 145px;
    }

    .FAFiContentPart {
        padding-top: 10px;
        background-color: #fff;
        color:#a9a9a9;
        height: 280px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom:1px #eeeeee solid;
    }

    .FASixContentPart {
        padding-top: 10px;
        background-color: #fff;
        color:#a9a9a9;
        height: 50px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom:1px #eeeeee solid;
    }

    .FASubTitleStoageInvoice {
        margin-left: 10px;
        width: 70px;
        float: left;
        padding-top: 5px;
    }

    .FASelectTypeStorage {
        height: 30px;
        width: 80px;
        margin-left: 315px;
    }

    .approveButton {
        height: 30px;
        width: 120px;
        background-color: #32323a;
        color:#fff;
        font-size: 12px;
        float:left;
        border:1px solid #32323a;
        margin-left: 20px;
        border-radius: 3px;
    }

    .submitChangeButton {
        height: 30px;
        width: 120px;
        background-color: #32323a;
        color:#fff;
        font-size: 12px;
        border:1px solid #32323a;
        margin-left: 10px;
        border-radius: 3px;
    }

    .FASevenContentPart {
        padding-top: 10px;
        background-color: #fff;
        color:#a9a9a9;
        height: 60px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom:1px #eeeeee solid;
    }


    /*----------------------------------------File Upload Agent---------------------------------------*/

    .FUASaveButton {
        height: 25px;
        width: 80px;
        background-color: #32323a;
        color:#fff;
        font-size: 12px;
        float:left;
        border:1px solid #32323a;
        margin-left: 20px;
        border-radius: 3px;
    }

    .FUAChooseFileButton {
        border-radius: 3px;
        height: 17px;
        width: 130px;
        margin:0 25px;
        font-size: 9px;
    }

    .TouchUpButtonStyle {
        margin-left: 0px;
        margin-right: 5px;
    }

    .inspectionButtonStyle {
        margin-left: 120px;
    }

    .inspectionStyle {
        margin-left: 0px;
    }

    .FUSixContentPart {
        padding-top: 10px;
        background-color: #fff;
        color:#a9a9a9;
        height: 60px;
        width: 750px;
        font-size: 12px;
        margin-left: 23px;
        border-bottom:1px #eeeeee solid;
    }

    .storageButtonStyle {
        margin-left: 215px;
    }

    .storageInputFileStyle {
        float: left;
        margin-left: 0px;
        margin-top: 5px;
    }
</style>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/pcStyles.css">
</head>
<body>
<div id="container">
    <?php
    include_once(__DIR__ . '/navigation.php');
    ?>
    <div id="main">
        <div class="formPart">
            <form method="post">
                <div class="FAFTitle">
                    <p class="titleSize"><strong>BASIC INFO</strong></p>
                </div>
                <div class="FAFContentPart ">
                    <div class="houseInfo">
                        <div class="houseImg">
                            <?php
                            if(!empty($caseDetailsArray['Images'])){
                                echo '<img src="' . $houseImageURL . $caseDetailsArray['Images'] . '">';
                            }else{
                                echo '<img src="' . $defaultHouseImageURL . '">';
                            }
                            ?>
                        </div>
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
                                    <td>SELLING LISTING RATE</td>
                                    <td><?php echo $caseDetailsArray['CommissionRate'] . "%";?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="FANormalTitle">
                    <p class="titleSize"><strong>FILE UPLOAD</strong></p>
                </div>
                <div class="FASContentPart">
                    <div class="FASCPFLine">
                        <p class="FAFSubTitle">STAGING</p>
                        <p class="FASubTitleUpload">
                            <?php
                            if(!empty($stagingImageFilesArray['Invoice']["FileName"])){
                                echo '<a href="' . $PageURL . '/?CID=' . $MLS . '&File=' . $stagingImageFilesArray['Invoice']["FileName"] . '">Invoice uploaded</a>';
                            }
                            else{
                                echo '<a>No Invoice uploaded</a>';
                            }
                            ?>
                        </p>
                        <select name="stagingStatus" id="drop-down" class="FASelectType">
                            <?php
                            foreach ($invoiceStatuses as $invoiceStatus){
                                if($stagingServiceArray['InvoiceStatus'] === $invoiceStatus){
                                    $isSelected = "selected";
                                }else{
                                    $isSelected = "";
                                }
                                echo '<option value="' . $invoiceStatus . '" ' . $isSelected . '>', $invoiceStatus, '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="FASCPSLine">
                        <table class="FAtable">
                            <tr>
                                <td>BEFORE</td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['BeforeLivingRoom']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['BeforeLivingRoom']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['BeforeDinningRoom']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['BeforeDinningRoom']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['BeforeMasterRoom']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['BeforeMasterRoom']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>LIVING ROOM</td>
                                <td>KITCHEN</td>
                                <td>WASH ROOM</td>
                            </tr>
                        </table>
                    </div>
                    <div class="FASCPTLine">
                        <table class="FAtable">
                            <tr>
                                <td>AFTER&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['AfterLivingRoom']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['AfterLivingRoom']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['AfterDinningRoom']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['AfterDinningRoom']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['AfterMasterRoom']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['AfterMasterRoom']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>LIVING ROOM</td>
                                <td>KITCHEN</td>
                                <td>WASH ROOM</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="FATContentPart">
                    <div class="FASCPFLine">
                        <p class="FAFSubTitle">CLEAN UP</p>
                        <p class="FASubTitleUpload">
                            <?php
                            if(!empty($cleanUpImageFilesArray['Invoice']["FileName"])){
                                echo '<a href="' . $PageURL . '/?CID=' . $MLS . '&File=' . $cleanUpImageFilesArray['Invoice']["FileName"] . '">Invoice uploaded</a>';
                            }
                            else{
                                echo '<a>No Invoice uploaded</a>';
                            }
                            ?>
                        </p>
                        <select name="cleanUpStatus" id="drop-down" class="FASelectType">
                            <?php
                            foreach ($invoiceStatuses as $invoiceStatus){
                                if($cleanUpServiceArray['InvoiceStatus'] === $invoiceStatus){
                                    $isSelected = "selected";
                                }else{
                                    $isSelected = "";
                                }
                                echo '<option value="' . $invoiceStatus . '" ' . $isSelected . '>', $invoiceStatus, '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="FASCPSLine">
                        <table class="FAtable">
                            <tr>
                                <td>BEFORE</td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['BeforeLivingRoom']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['BeforeLivingRoom']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['BeforeKitchen']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['BeforeKitchen']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['BeforeWashRoom']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['BeforeWashRoom']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>LIVING ROOM</td>
                                <td>KITCHEN</td>
                                <td>WASH ROOM</td>
                            </tr>
                        </table>
                    </div>
                    <div class="FASCPTLine">
                        <table class="FAtable">
                            <tr>
                                <td>AFTER&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['AfterLivingRoom']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['AfterLivingRoom']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['AfterKitchen']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['AfterKitchen']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['AfterWashRoom']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['AfterWashRoom']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>LIVING ROOM</td>
                                <td>KITCHEN</td>
                                <td>WASH ROOM</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="FAFoContentPart">
                    <div class="FASCPFLine">
                        <p class="FAFSubTitle">TOUCH UP</p>
                        <p class="FASubTitleUpload">
                            <?php
                            if(!empty($touchUpImageFilesArray['Invoice']["FileName"])){
                                echo '<a href="' . $PageURL . '/?CID=' . $MLS . '&File=' . $touchUpImageFilesArray['Invoice']["FileName"] . '">Invoice uploaded</a>';
                            }
                            else{
                                echo '<a>No Invoice uploaded</a>';
                            }
                            ?>
                        </p>
                        <?php
                            echo '<select name="touchUpStatus" id="drop-down" class="FASelectType">';
                                foreach ($invoiceStatuses as $invoiceStatus){
                                    if($touchUpServiceArray['InvoiceStatus'] === $invoiceStatus){
                                        $isSelected = "selected";
                                    }else{
                                        $isSelected = null;
                                    }
                                    echo '<option value="' . $invoiceStatus . '" ' . $isSelected . '>', $invoiceStatus, '</option>';
                                }
                            echo '</select>';
                        ?>
                    </div>
                    <div class="FASCPSLine">
                        <table class="FAtable">
                            <tr>
                                <td>BEFORE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['Before1']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['Before1']["FileName"] . '" class="FAImageTouchUp">';
                                    else
                                        echo '<img src="" class="FAImageTouchUp">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['Before2']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['Before2']["FileName"] . '" class="FAImageTouchUp">';
                                    else
                                        echo '<img src="" class="FAImageTouchUp">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['Before3']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['Before3']["FileName"] . '" class="FAImageTouchUp">';
                                    else
                                        echo '<img src="" class="FAImageTouchUp">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['Before4']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['Before4']["FileName"] . '" class="FAImageTouchUp">';
                                    else
                                        echo '<img src="" class="FAImageTouchUp">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['Before5']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['Before5']["FileName"] . '" class="FAImageTouchUp">';
                                    else
                                        echo '<img src="" class="FAImageTouchUp">';
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="FASCPTLine">
                        <table class="FAtable">
                            <tr>
                                <td>AFTER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['After1']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['After1']["FileName"] . '" class="FAImageTouchUp">';
                                    else
                                        echo '<img src="" class="FAImageTouchUp">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['After2']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['After2']["FileName"] . '" class="FAImageTouchUp">';
                                    else
                                        echo '<img src="" class="FAImageTouchUp">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['After3']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['After3']["FileName"] . '" class="FAImageTouchUp">';
                                    else
                                        echo '<img src="" class="FAImageTouchUp">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['After4']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['After4']["FileName"] . '" class="FAImageTouchUp">';
                                    else
                                        echo '<img src="" class="FAImageTouchUp">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['After5']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['After5']["FileName"] . '" class="FAImageTouchUp">';
                                    else
                                        echo '<img src="" class="FAImageTouchUp">';
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="FAFiContentPart">
                    <div class="FASCPFLine">
                        <p class="FAFSubTitle">YARD WORK</p>
                        <p class="FASubTitleUpload">
                            <?php
                            if(!empty($yardWorkImageFilesArray['Invoice']["FileName"])){
                                echo '<a href="' . $PageURL . '/?CID=' . $MLS . '&File=' . $yardWorkImageFilesArray['Invoice']["FileName"] . '">Invoice uploaded</a>';
                            }
                            else{
                                echo '<a>No Invoice uploaded</a>';
                            }
                            ?>
                        </p>
                        <select name="yardWorkStatus" id="drop-down" class="FASelectType">
                            <?php
                            foreach ($invoiceStatuses as $invoiceStatus){
                                if($yardWorkServiceArray['InvoiceStatus'] === $invoiceStatus){
                                    $isSelected = "selected";
                                }else{
                                    $isSelected = "";
                                }
                                echo '<option value="' . $invoiceStatus . '" ' . $isSelected . '>', $invoiceStatus, '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="FASCPSLine">
                        <table class="FAtable">
                            <tr>
                                <td>BEFORE</td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['BeforeFrontYard']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['BeforeFrontYard']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['After5']["BeforeBackYard"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['BeforeBackYard']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>FRONT YEAR</td>
                                <td>BACK YARD</td>
                            </tr>
                        </table>
                    </div>
                    <div class="FASCPTLine">
                        <table class="FAtable">
                            <tr>
                                <td>AFTER&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['AfterFrontYard']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['AfterFrontYard']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($stagingImageFilesArray['AfterBackYard']["FileName"]))
                                        echo '<img src="' . get_home_url() . "/" . $stagingImageFilesArray['AfterBackYard']["FileName"] . '" class="FAImage">';
                                    else
                                        echo '<img src="" class="FAImage">';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>FRONT YEAR</td>
                                <td>BACK YARD</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="FASixContentPart">
                    <div class="FASCPFLine">
                        <p class="FAFSubTitle">INSPECTION</p>
                        <p class="FASubTitleInsoection">
                            <?php
                            if(!empty($inspectionImageFilesArray['Report']["FileName"])){
                                echo '<a href="' . $PageURL . '/?CID=' . $MLS . '&File=' . $inspectionImageFilesArray['Report']["FileName"] . '">Invoice uploaded</a>';
                            }
                            else{
                                echo '<a>No Report uploaded</a>';
                            }
                            ?>
                        </p>
                        <p class="FASubTitleInvoice">
                            <?php
                            if(!empty($inspectionImageFilesArray['Invoice']["FileName"])){
                                echo '<a href="' . $PageURL . '/?CID=' . $MLS . '&File=' . $inspectionImageFilesArray['Invoice']["FileName"] . '">Invoice uploaded</a>';
                            }
                            else{
                                echo '<a>No Invoice uploaded</a>';
                            }
                            ?>
                        </p>
                        <select name="inspectionStatus" id="drop-down" class="FASelectTypeInspection">
                            <?php
                            foreach ($invoiceStatuses as $invoiceStatus){
                                if($inspectionServiceArray['InvoiceStatus'] === $invoiceStatus){
                                    $isSelected = "selected";
                                }else{
                                    $isSelected = "";
                                }
                                echo '<option value="' . $invoiceStatus . '" ' . $isSelected . '>', $invoiceStatus, '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="FASixContentPart">
                    <div class="FASCPFLine">
                        <p class="FAFSubTitle">STORAGE</p>
                        <p class="FASubTitleStoageInvoice">
                            <?php
                            if(!empty($storageImageFilesArray['Invoice']["FileName"])){
                                echo '<a href="' . $PageURL . '/?CID=' . $MLS . '&File=' . $storageImageFilesArray['Invoice']["FileName"] . '">Invoice uploaded</a>';
                            }
                            else{
                                echo '<a>No Invoice uploaded</a>';
                            }
                            ?>
                        </p>
                        <select name="storageStatus" id="drop-down" class="FASelectTypeStorage">
                            <?php
                            foreach ($invoiceStatuses as $invoiceStatus){
                                if($stagingServiceArray['InvoiceStatus'] === $invoiceStatus){
                                    $isSelected = "selected";
                                }else{
                                    $isSelected = "";
                                }
                                echo '<option value="' . $invoiceStatus . '" ' . $isSelected . '>', $invoiceStatus, '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="FASevenContentPart">
                    <div class="FASCPFLine">
                        <p class="FAFSubTitle">RELOCATION HOME</p>
                        <p class="FASubTitleStoageInvoice">
                            <?php
                            if(!empty($relocateHomeImageFilesArray['Invoice']["FileName"])){
                                echo '<a href="' . $PageURL . '/?CID=' . $MLS . '&File=' . $relocateHomeImageFilesArray['Invoice']["FileName"] . '">Invoice uploaded</a>';
                            }
                            else{
                                echo '<a>No Invoice uploaded</a>';
                            }
                            ?>
                        </p>
                        <?php
                            echo '<select name="relocateHomeStatus" id="drop-down" class="FASelectTypeStorage">';

                                foreach ($invoiceStatuses as $invoiceStatus){
                                    if($relocateHomeServiceArray['InvoiceStatus'] === $invoiceStatus){
                                        $isSelected = "selected";
                                    }else{
                                        $isSelected = "";
                                    }
                                    echo '<option value="' . $invoiceStatus . '" ' . $isSelected . '>', $invoiceStatus, '</option>';
                                }
                            echo '</select>';
                        ?>
                    </div>
                </div>
                <div class="FASixContentPart">
                    <input type="submit" name="approve_all" value="APPROVE ALL" class="approveButton">
                    <input type="submit" name="submit" value="SUBMIT CHANGE" class="submitChangeButton">
                </div>
            </form>
        </div></br></br></br>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>




