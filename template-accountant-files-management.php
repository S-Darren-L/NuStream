<?php

    // Start Session
    session_start();

    /*
    Template Name: Accountant Files Management
    */


    // Init
    $serviceStatus = '';
    $allServices = array();
    $allServices = get_all_services($serviceStatus);

    // Get All Services By Status
    function get_all_services($serviceStatus){
        $allServicesResult = get_all_services_with_file_by_status($serviceStatus);
        while($service = mysqli_fetch_array($allServicesResult))
        {
            $caseResult = mysqli_fetch_array(get_case_by_service_type_and_id($service['SupplierType'], $service['ServiceID']));
            $service['MLS'] = $caseResult['MLS'];
            $accountResult = mysqli_fetch_array(get_agent_account($caseResult['StaffID']));
            $service['MemberName'] = $accountResult['FirstName'] . $accountResult['LastName'];
            $teamResult = mysqli_fetch_array(get_team_by_team_id($accountResult['TeamID']));
            $service['TeamLeaderName'] = $teamResult['TeamLeaderName'];
            $allServices[] = $service;
        }
        return $allServices;
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
        <p class="ICATitleSize">FILES<a class="FACSelect"href="#">DOWNLOAD SELECTED</a></p>
        </div>
            <table class="FACTable" >
                <thead>
                <tr>
                    <th class="FACTableHeader FACTableMargin">MLS NUMBER</th>
                    <th class="FACTableHeader">MEMBER NAME</th>
                    <th class="FACTableHeader">TEAM LEAD</th>
                    <th class="FACTableHeader">UPLOAD DATE</th>
                    <th class="FACTableHeader">SERVICE TYPE</th>
                    <th class="FACTableHeader FACTableHeaderLarge">PRICE BEFORE TAX</th>
                    <th class="FACTableHeader FACTableHeaderSmall">INVOICE</th>
                    <th class="FACTableHeader FACTableHeaderSmall">SELECT</th></tr>
                </thead>
                <tbody>
                <?php
                    for($i = 0; $i < count($allServices); $i++) {
                        echo '<tr ng-repeat="info in data.infoAdmin|orderBy:orderByField:reverseSort">';
                        echo '<td class="FACTableMargin">', $allServices[$i]['MLS'], '</td>';
                        echo '<td>', $allServices[$i]['MemberName'], '</td>';
                        echo '<td>', $allServices[$i]['TeamLeaderName'], '</td>';
                        echo '<td>', $allServices[$i]['StartDate'], '</td>';
                        echo '<td>', $allServices[$i]['SupplierType'], '</td>';
                        echo '<td>', $allServices[$i]['RealCost'], '</td>';
                        echo '<td class="FACDownload">', '<a href="#">DOWNLOAD</a>', '</td>';
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



