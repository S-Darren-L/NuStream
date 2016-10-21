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
<style type="text/css">
    html, body {
        margin:0;
        padding:0;
    }


    #container{
        margin-left: 230px;
        _zoom: 1;
    }
    #nav{
        float: left;
        width: 230px;
        height: 100%;
        background: #32323a;
        margin-left: -230px;
        position:fixed;
    }
    #main{
        height: 400px;

    }
    /* style icon */
    .inner-addon .glyphicon {
        position: absolute;
        padding: 10px;
        pointer-events: none;
    }

    /* align icon */
    .left-addon .glyphicon  { left:  0px;}

    /* add padding  */
    .left-addon input  { padding-left:  30px; }

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
        margin-right: 40px;
        margin-left: 40px;
        padding-top: 40px;
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
    .table td {
        font-size:10px;
        vertical-align: middle;
    }
</style>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div id="container">
    <?php
        include_once(__DIR__ . '/navigation.php');
    ?>
    <div id="main">
        <div class="formPart">
            <table class="table table-striped" >
                <thead style="background-color:#535353;">
                <tr>
                    <th>MLS NUMBER</th>
                    <th>MEMBER NAME</th>
                    <th>TEAM LEAD</th>
                    <th>UPLOAD DATE</th>
                    <th>SERVICE TYPE</th>
                    <th>PRICE BEFORE TAX</th>
                    <th>INVOICE</th>
                    <th>SELECT</th></tr>
                </thead>
                <!-- There should be a dynamic table body-->
                <tbody>
                <?php
                    for($i = 0; $i < count($allServices); $i++) {
                        echo '<tr ng-repeat="info in data.infoAdmin|orderBy:orderByField:reverseSort">';
                        echo '<td>', $allServices[$i]['MLS'], '</td>';
                        echo '<td>', $allServices[$i]['MemberName'], '</td>';
                        echo '<td>', $allServices[$i]['TeamLeaderName'], '</td>';
                        echo '<td>', $allServices[$i]['StartDate'], '</td>';
                        echo '<td>', $allServices[$i]['SupplierType'], '</td>';
                        echo '<td>', $allServices[$i]['RealCost'], '</td>';
                        echo '<td>', '<a href="#">DOWNLOAD</a>', '</td>';
                        echo '<td>', '<input name="select_for_download" checked="checked" type="checkbox">', '</td>';
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>



