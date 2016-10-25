<?php

// Start Session
session_start();

/*
Template Name: Agent Mobile Case Estimation
*/

// Init Data

$isNewPage = $_GET['RF'];
$propertyTypes = get_property_types();
//set_init_value();


$homeURL = get_home_url();
$mainPath = $homeURL . "/wp-content/themes/NuStream/";
$goBackImagePath = $mainPath . "img/goBack.png";

if(isset($_POST['submit'])){
    $houseSize = $_POST['houseSize'];
    $propertyType = $_POST['propertyType'];

    header('Location: ' . get_home_url() . '/agent-mobile-case-estimation-2/?HS=' . $houseSize . '&HP=' . $propertyType);
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
</head>
<body>
<div class='estimationPage'>
    <form method="post">
    <div class="goBack">
        <?php echo '<img class="goBackButton" src="' . $goBackImagePath . '">'; ?>
    </div>
    <div class="estimationTitlePart">
        <h2>ESTIMATION</h2>
    </div>
    <div class='estimationInput'>
        <div class='estimationInputPart'>
            <input class="estimationInputStyle" name="houseSize"  id="houseSizeInput" placeholder='HOUSE SIZE *' type='number' size="30">
            </input>
        </div>
        <div class='estimationInputPart'>
            <select name="propertyType" style="color:#111;" class="estimationInputStyle" id="propertySizeInput">
                <?php
                foreach ($propertyTypes as $propertyTypeItem){
                    global $propertyType;
                    $isSelected = $propertyTypeItem === $propertyType ? 'selected' : null;
                    echo '
                                    <option class="estimationAgentOption" value="' . $propertyTypeItem . '" ' . $isSelected . '>' , $propertyTypeItem, '</option>' ;
                }
                ?>
            </select>
        </div>
    </div>
    <div class="estimationButtonPart">
        <input type="submit" name="submit" class="estimationButton" value="SUBMIT">
    </div>
    </form>
</div>
</body>
</html>
