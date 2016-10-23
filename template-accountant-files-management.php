<?php

    // Start Session
    session_start();

    /*
    Template Name: Accountant Files Management
    */


    // Init
    $serviceStatus = '';
    $allServiceArray = get_all_cases();
    $PageURL = get_home_url() . '/accountant-files-management';

    // Get All Closed Cases
    function get_all_cases(){
        $allServicesResult = get_all_closed_cases();
    //        $allServiceArray = mysqli_fetch_array($allServicesResult);
        foreach ($allServicesResult as $case)
        {
            $accountResult = mysqli_fetch_array(get_agent_account($case['StaffID']));
            $case['MemberName'] = $accountResult['FirstName'] . $accountResult['LastName'];
            $teamResult = mysqli_fetch_array(get_team_by_team_id($accountResult['TeamID']));
            $case['TeamLeaderName'] = $teamResult['TeamLeaderName'];
            $allServiceArray[] = $case;
        }
        return $allServiceArray;
    }

    // Download FIle
    if(isset($_GET['File'])){
        $MLS = $_GET['File'];
        $uploadPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . "Upload" . DIRECTORY_SEPARATOR . "case" . DIRECTORY_SEPARATOR . $MLS . DIRECTORY_SEPARATOR . "finalReport";
        try{
            create_zip($uploadPath, $MLS);
        }catch (Exception $e){

        }
    }

?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/pcStyles.css">
</head>
<body>
<div id="container">
    <?php
        include_once(__DIR__ . '/navigation.php');
    ?>
    <div id="main">
        <div class="formPart">
            <div class="ICATitle">
		<p class="ICATitleSize"><strong>FILES</strong><a class="FACSelect"href="#"><strong>DOWNLOAD SELECTED</strong></a></p>
	    </div>
            <table class="FACTable" >
                <thead">
                <tr>
                    <th class="FACTableHeader FACTableMargin">MLS NUMBER</th>
                    <th class="FACTableHeader">MEMBER NAME</th>
                    <th class="FACTableHeader">TEAM LEAD</th>
                    <th class="FACTableHeader">UPLOAD DATE</th>
                    <th class="FACTableHeader FACTableHeaderLarge">PRICE BEFORE TAX</th>
                    <th class="FACTableHeader FACTableHeaderSmall">INVOICE</th>
                    <th class="FACTableHeader FACTableHeaderSmall">SELECT</th></tr>
                </thead>
                <tbody>
                <?php
                    for($i = 0; $i < count($allServiceArray); $i++) {
                        echo '<tr ng-repeat="info in data.infoAdmin|orderBy:orderByField:reverseSort">';
                        echo '<td class="FACTableMargin">', $allServiceArray[$i]['MLS'], '</td>';
                        echo '<td>', $allServiceArray[$i]['MemberName'], '</td>';
                        echo '<td>', $allServiceArray[$i]['TeamLeaderName'], '</td>';
                        echo '<td>', $allServiceArray[$i]['StartDate'], '</td>';
                        echo '<td>$&nbsp;', $allServiceArray[$i]['FinalPrice'], '&nbsp;CAD</td>';
                        echo '<td class="FACDownload">', '<a href="' . $PageURL . '/?File=' . $allServiceArray[$i]['MLS'] . '">DOWNLOAD</a>', '</td>';
                        echo '<td>', '<input class="FACCheckBox" name="select_for_download" checked="checked" type="checkbox">', '</td>';
                    }
                ?>
                </tbody>
            </table>
            <div class="FACPageNum"><a href="#">BACK</a>&nbsp;&nbsp;&nbsp;<a href="#">NEXT</a></div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>



