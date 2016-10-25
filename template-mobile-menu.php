<?php

// Start Session
session_start();

/*
Template Name: Mobile Menu
*/

$homeURL = get_home_url();
$mainPath = $homeURL . "/wp-content/themes/NuStream/";
$settingIconImagePath = $mainPath . "img/Settings Filled-100.png";
$listingIconImagePath = $mainPath . "img/Copy Filled-100.png";
$infoCenterIconImagePath = $mainPath . "img/Open Folder Filled-100.png";
$mycaseIconImagePath = $mainPath . "img/Briefcase Filled-100.png";
$estimationImagePath = $mainPath . "img/Pencil-96.png";
$logo1ImagePath = $mainPath . "img/logo.png";

$UserName = $_SESSION['FirstName'] . " " . $_SESSION['LastName'];


$settingURL = get_home_url() . "/mobile-settings";
$newCaseURL = get_home_url() . "/agent-mobile-create-case";
$infoCenterCenterURL = get_home_url() . "/agent-mobile-supplier-info";
$myCaseURL = get_home_url() . "/agent-mobile-my-cases";
$estimationURL = get_home_url() . "/agent-mobile-case-estimation";

?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUSTREAM</title>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/default.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/styles.css">
    <style>
        .menu_fields > div:hover{
            background:#006ac0;
            cursor:pointer;
        }
    </style>
</head>
<body>
<div class='menu'>
    <div class='menu_setting'>
        <div class='settingIconPart'><?php
            echo '<img src="' . $settingIconImagePath . '"/>';
            ?>
        </div>
        <div class="settingContentPart">
            <h6><?php
            echo '<a href="' .$settingURL . '">&nbsp;&nbsp;Settings</a>';
                ?></h6>
        </div>
    </div>
    <div class='menu_user_name'>
        <h2>
            <?php echo $UserName;?></h2>
        <h6><?php echo $_SESSION['AccountPosition']; ?></h6>
    </div>
    <div class='menu_fields'>
        <div class='login_fields_newlisting'>
            <div class="listingIconPart"><?php
                echo '<img src="' . $listingIconImagePath . '"/>';
                ?>
                <!-- </div> -->
                <!-- <div class='newlistingContent'> -->
                <h4><?php
                    echo '<a href="' .$newCaseURL . '">&nbsp;&nbsp;New Listing</a>';
                    ?></h4>
            </div>
        </div>
        <div class='login_fields_infocenter'>
            <div class='infocenterIconPart'><?php
                echo '<img src="' . $infoCenterIconImagePath . '"/>';
                ?>
                <!-- </div> -->
                <!-- <div class="infocenterContent"> -->
                <h4><?php
                    echo '<a href="' .$infoCenterCenterURL . '">&nbsp;&nbsp;Info Center</a>';
                    ?></h4>
            </div>
        </div>
        <div class='login_fields_mycases'>
            <div class='mycasesIconPart'><?php
                echo '<img src="' . $mycaseIconImagePath . '"/>';
                ?>
                <!-- </div>
                <div class='mycasesIconContent'> -->
                <h4><?php
                    echo '<a href="' .$myCaseURL . '">&nbsp;&nbsp;My Cases</a>';
                    ?></h4>
            </div>
        </div>
        <div class='login_fields_estimation'>
            <div class='estimationIconPart'><?php
                echo '<img src="' . $estimationImagePath . '"/>';
                ?>
                <!-- </div>
                <div class='estimationIconContent'> -->
                <h4><?php
                    echo '<a href="' .$estimationURL . '">&nbsp;&nbsp;Estimation</a>';
                    ?></h4>
            </div>
        </div>
        <div class="logo_bottom"><?php
            echo '<img src="' . $logo1ImagePath . '"/>';
            ?>
        </div>
    </div>
</div>
</body>
</html>
