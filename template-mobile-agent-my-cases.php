<?php

// Start Session
session_start();

/*
Template Name: Agent Mobile My Cases
*/

$homeURL = get_home_url();
$menuURL = $homeURL . "/mobile-menu";
$mainPath = $homeURL . "/wp-content/themes/NuStream/";
$goBackImagePath = $mainPath . "img/goBack.png";

    $agentAccountID = $_SESSION['AccountID'];
    // Get Cases Brief Info
    $CasesBriefInfoArray = get_cases_brief_table($agentAccountID);

    function get_cases_brief_table($agentAccountID){
        $result = get_cases_brief_info($agentAccountID);
        if($result === null)
            echo 'result is null';
        $result_rows = [];
        while($row = mysqli_fetch_array($result))
        {
            $result_rows[] = $row;
        }
        return $result_rows;
    }
?>
<html class="gr__nustreamtoronto_com"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style type="text/css">@charset "UTF-8";[ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\:form{display:block;}.ng-animate-shim{visibility:hidden;}.ng-anchor{position:absolute;}</style>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NuStream 新勢力地產</title>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/styles.css">
    <script type="text/javascript" src="<?php bloginfo('template_url');?>/js/index.js"></script>
    <style>
        .firstdiv{
            width:100px;
            border-right:1px solid black;
                padding: 0px 15px;
        }
                .seconddiv{
    width: 100px;
    border-right: 1px solid black;
    padding: 0px 15px;
    position: absolute;
    left: 40%;
    padding-top: 10px;
    top: 0px;
        }
        .myCaseInfoTable th {
            margin-top: 2%;
            border-right: none;
        }

        .myCaseInfoTable a{
                float: right;
    margin-right: 15%;        }
    </style>
</head>
<body  data-gr-c-s-loaded="true">
<span style="color:white;">
    <?php echo '<a href="' . $menuURL . '" style="color:white;">', '<<', '</a>'; ?></span>
<div cng-app="App" ng-controller="myController" class="ng-scope myCasePage">
    <!--<div class="goBack">
        <?php
                            echo '<img class="goBackButton" src="' . $goBackImagePath . '" />';
                            ?>
    </div></br>-->
    <div class="infoPart"><?php
        for($i = 0; $i < count($CasesBriefInfoArray); $i++)
        {
            $MLS = $CasesBriefInfoArray[$i]["MLS"];
            echo '<div class="myCaseInfoStyle redBorder">';
            echo '<table class="myCaseInfoTable " style="position:relative;">';
                echo '<th><div class="firstdiv">', $CasesBriefInfoArray[$i]["Address"], '<br/>';
                echo '<span style="font-size:6px;">MLS ', $MLS , $CasesBriefInfoArray[$i]["PropertyType"], '<span></div></th>';
                echo '<th><div class="seconddiv">', $CasesBriefInfoArray[$i]["StartDate"], '</div></th>';
                echo '<th class="tableBorderColor">', '<a href="' . $homeURL . '/agent-mobile-case-details/?CID=' . $MLS . '" >', $CasesBriefInfoArray[$i]["CaseStatus"], '</th>';
            echo '</table>';
        echo '</div>';
        }
        ?>

    </div>
	<div class="myCaseInfoBottom">
		<button class="buttonStyle buttonBlack">PREVIOUS</button>&nbsp;&nbsp;&nbsp;
		<button class="buttonStyle buttonBlack">NEXT</button>
	</div>
</br>
</div>
</body>
</html>
