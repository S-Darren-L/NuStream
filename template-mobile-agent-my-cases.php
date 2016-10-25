<?php

// Start Session
session_start();

/*
Template Name: Agent Mobile My Cases
*/

$homeURL = get_home_url();
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
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUSTREAM</title>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/default.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/styles.css">
    <script type="text/javascript" src="<?php bloginfo('template_url');?>/js/index.js"></script>
</head>
<body>
<div class='myCasePage'>
    <div class="goBack">
        <?php echo '<img class="goBackButton" src="' . $goBackImagePath . '">'; ?>
    </div></br>
    <div class="infoPart"><?php
        for($i = 0; $i < count($CasesBriefInfoArray); $i++)
        {
            $MLS = $CasesBriefInfoArray[$i]["MLS"];
            echo '<div class="myCaseInfoStyle redBorder">';
            echo '<table class="myCaseInfoTable ">';
                echo '<th>', $CasesBriefInfoArray[$i]["Address"], '<br/>';
                echo '<span style="font-size:6px;">MLS ', $MLS , $CasesBriefInfoArray[$i]["PropertyType"], '<span></th>';
                echo '<th>', $CasesBriefInfoArray[$i]["StartDate"], '</th>';
                echo '<th class="tableBorderColor">', '<a href="' . $homeURL . '/agent-mobile-case-details/?CID=' . $MLS . '" >', $CasesBriefInfoArray[$i]["CaseStatus"], '</th>';
            echo '</table>';
        echo '</div>';
        }
        ?>

    </div>
    </br>
</div>
</body>
</html>
