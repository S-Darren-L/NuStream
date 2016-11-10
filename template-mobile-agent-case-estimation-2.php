<?php

// Start Session
session_start();

/*
Template Name: Agent Mobile Case Estimation 2
*/

// Init Data

$menuURL = get_home_url() . "/mobile-menu";
$houseSize = $_GET['HS'];
$propertyType = $_GET['HP'];
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

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NuStream 新勢力地產</title>
    <!--<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/default.css">-->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/styles.css">
</head>
<body>
<span style="color:white;">
    <?php echo '<a href="' . $menuURL . '" style="color:white;">', '<<', '</a>'; ?></span>
    <div class='estimationTwoPage'>
        <div class="goBack">
        </div>
        <div id="staging" style="display:none"><?php echo $stagingEstimatePrice; ?></div>
        <div id="touchup" style="display:none"><?php echo $photographyEstimatePrice; ?></div>
        <div id="cleanup" style="display:none"><?php echo $cleanUpEstimatePrice; ?></div>
        <div id="yardwork" style="display:none"><?php echo $relocateHomeEstimatePrice; ?></div>
        <div id="storage" style="display:none"><?php echo $touchUpEstimatePrice; ?></div>
        <div id="relocation" style="display:none"><?php echo $inspectionEstimatePrice; ?></div>
        <div id="photography" style="display:none"><?php echo $isYardWordChecked; ?></div>
        <div id="inspection" style="display:none"><?php echo $storageEstimatePrice; ?></div>
        <div class='estimationTwoButton'>
            <button class="estimationTwoWhiteButton" id="sta">STAGING</button>
            <button class="estimationTwoWhiteButton" id="tou">TOUCH UP</button>
            <button class="estimationTwoWhiteButton" id="cle">CLEAN UP</button>
            <button class="estimationTwoWhiteButton" id="yar">YARD WORK</button>
            <button class="estimationTwoWhiteButton" id="sto">STORAGE</button>
            <button class="estimationTwoWhiteButton" id="rel">RELOCATION HOME</button>
            <button class="estimationTwoWhiteButton" id="pho">PHOTOGRAPHY</button>
            <button class="estimationTwoWhiteButton" id="ins">INSPECTION</button>
        </div>
        <div class="estimateCostPart">
            <p style="font-size:11px;">ESTIMATE COST</p>
            <p style="margin-top:0px; font-size:15px;" id="sum">0 CAD</p>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        
        var sta = $('#staging').text();
        var tou = $('#touchup').text();
        var cle = $('#cleanup').text();
        var yar = $('#yardwork').text();
        var sto = $('#storage').text();
        var rel = $('#relocation').text();
        var pho = $('#photography').text();
        var ins = $('#inspection').text();
        
        var ifsta = false;
        var iftou = false;
        var ifcle = false;
        var ifyar = false;
        var ifsto = false;
        var ifrel = false;
        var ifpho = false;
        var ifins = false;
        $('#sta').on('click', function () {
            ifsta = !ifsta;
            recalculate();
        });
        $('#tou').on('click', function () {
            iftou = !iftou;
            recalculate();
        });
        $('#cle').on('click', function () {
            ifcle = !ifcle;
            recalculate();
        });
        $('#yar').on('click', function () {
            ifyar = !ifyar;
            recalculate();
        });
        $('#sto').on('click', function () {
            ifsto = !ifsto;
            recalculate();
        });
        $('#rel').on('click', function () {
            ifrel = !ifrel;
            recalculate();
        });
        $('#pho').on('click', function () {
            ifpho = !ifpho;
            recalculate();
        });
        $('#ins').on('click', function () {
            ifins = !ifins;
            recalculate();
        });

        function recalculate() {
            var sum = 0;
            if (ifsta) {
                $('#sta').css('background-color', 'black').css('color', 'white');
                sum += sta * 1;
            } else {
                $('#sta').css('background-color', 'white').css('color', 'black');
            }

            if (iftou) {
                $('#tou').css('background-color', 'black').css('color', 'white');
                sum += tou * 1;
            } else {
                $('#tou').css('background-color', 'white').css('color', 'black');
            }

            if (ifcle) {
                $('#cle').css('background-color', 'black').css('color', 'white');
                sum += cle * 1;
            } else {
                $('#cle').css('background-color', 'white').css('color', 'black');
            }

            if (ifyar) {
                $('#yar').css('background-color', 'black').css('color', 'white');
                sum += yar * 1;
            } else {
                $('#yar').css('background-color', 'white').css('color', 'black');
            }

            if (ifsto) {
                $('#sto').css('background-color', 'black').css('color', 'white');
                sum += sto * 1;
            } else {
                $('#sto').css('background-color', 'white').css('color', 'black');
            }

            if (ifrel) {
                $('#rel').css('background-color', 'black').css('color', 'white');
                sum += rel * 1;
            } else {
                $('#rel').css('background-color', 'white').css('color', 'black');
            }

            if (ifpho) {
                $('#pho').css('background-color', 'black').css('color', 'white');
                sum += pho * 1;
            } else {
                $('#pho').css('background-color', 'white').css('color', 'black');
            }

            if (ifins) {
                $('#ins').css('background-color', 'black').css('color', 'white');
                sum += ins * 1;
            } else {
                $('#ins').css('background-color', 'white').css('color', 'black');
            }
            $('#sum').text(sum + ' CAD');
        }
    </script>
</body>
</html>
