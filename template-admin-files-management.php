<?php

// Start Session
session_start();

/*
Template Name: Admin Files Management
*/

?>

<?php
    // Set Sub-menu URL
    $subMenuURL = get_home_url() . "/admin-files-management/?FType=";
    // Get View File Type
    $serviceStatus = $_GET['FType'];
    if(empty($serviceStatus)){
        $serviceStatus = '';
    }
    // Init
    $allServices = array();
    $allServices = get_all_services($serviceStatus);

    // Get All Services By Status
    function get_all_services($serviceStatus){
        $allServicesResult = get_all_services_by_status($serviceStatus);
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

    .title {
        padding:0px;
        margin:20px;
    }
    .title h4 {
        padding:0px;
        margin:0px;
        width: 300px;
        font-size: 20px;
        color:grey;
        font-style: bold;
    }

    .inputPart {
        padding-top: 30px;
        background-color: grey;
        color:white;
        height: 500px;
        width: 800px;
    }

    .table td {
        font-size:10px;
        vertical-align: middle;
    }

    .arrow-up {
        width:0;
        height:0;
        border-left:3px solid transparent;
        border-right:3px solid transparent;
        border-bottom:6px solid #fff;
        display: inline-block;
    }

    .arrow-down {
        width:0;
        height:0;
        border-left:3px solid transparent;
        border-right:3px solid transparent;
        border-top:6px solid #fff;
        display: inline-block;
    }

    .table td a:link {
        text-decoration: underline;
    }

    .table th a:link{
        font-size: 8px;
        color:white;
        text-decoration:none;
    }

    .table th a:visited{
        color:white;
        text-decoration:none;
    }

    .table th a:hover{
        color:white;
        text-decoration:none;
    }

    .table th a:active{
        color:white;
        text-decoration:none;
    }

    .pageNum {
        text-align: center;
    }

    .pageNum a:link{
        font-size: 8px;
        color:black;
        text-decoration:underline;
    }

    .pageNum a:visited{
        color:black;
        text-decoration:underline;
    }

    .pageNum a:hover{
        color:black;
        text-decoration:underline;
    }

    .pageNum a:active{
        color:black;
        text-decoration:underline;
    }

    .table-striped {
        width: 900px !important;
    }

    .topBar {
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .topBar a:link {
        text-decoration: none;
    }

    .topBar a:hover {
        text-decoration: none;
        /*font-weight: bold;*/
    }

    .topBar a {
        padding-left: 10px;
        padding-right: 10px;
        letter-spacing: 0px;
    }
</style>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
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
            <div class="topBar">
                <?php
                    echo '<a href="' . $subMenuURL . '' . '">All Files</a>|<a href="' . $subMenuURL . "Pending" . '">Pending Files</a>|<a href="' . $subMenuURL . "Approved" . '">Approved Files</a>';
                ?>
            </div>
            <section ng-app="app" ng-controller="MainCtrl">
                <table  class="table table-striped">
                    <thead style="background-color:#535353;">
                    <tr>
                        <th>
                            <a href="#" ng-click="orderByField='MLSNUMBER'; reverseSort = !reverseSort">MLS NUMBER <span ng-show="orderByField == 'MLSNUMBER'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>
                        </th>
                        <th>
                            <a href="#" ng-click="orderByField='MEMBERNAME'; reverseSort = !reverseSort">MEMBER NAME <span ng-show="orderByField == 'MEMBERNAME'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th>
                            <a href="#" ng-click="orderByField='TEAMLEAD'; reverseSort = !reverseSort">TEAM LEAD <span ng-show="orderByField == 'TEAMLEAD'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th>
                            <a href="#" ng-click="orderByField='UPLOADDATE'; reverseSort = !reverseSort">UPLOAD DATE <span ng-show="orderByField == 'UPLOADDATE'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th>
                            <a href="#" ng-click="orderByField='SERVICETYPE'; reverseSort = !reverseSort">SERVICE TYPE <span ng-show="orderByField == 'SERVICETYPE'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th>
                            <a href="#" ng-click="orderByField='PRICEBEFFORETAX'; reverseSort = !reverseSort">PRICE BEFFORE TAX <span ng-show="orderByField == 'PRICEBEFFORETAX'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th>
                            <a href="#">INVOICE</a>
                        </th>
                        <th>
                            <a href="#">STATUS</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <form method="post">
                        <?php
                        for($i = 0; $i < count($allServices); $i++) {
                            echo '<tr ng-repeat="info in data.infoAdmin|orderBy:orderByField:reverseSort">';
                            echo '<td>', '<a href="' . $homeURL . '/admin-case-details/?CID=' . $allServices[$i]['MLS'] . '" />', $allServices[$i]['MLS'], '</td>';
                            echo '<td>', $allServices[$i]['MemberName'], '</td>';
                            echo '<td>', $allServices[$i]['TeamLeaderName'], '</td>';
                            echo '<td>', $allServices[$i]['StartDate'], '</td>';
                            echo '<td>', $allServices[$i]['SupplierType'], '</td>';
                            echo '<td>', $allServices[$i]['RealCost'], '</td>';
                            echo '<td>', '<a href="#">DOWNLOAD</a>', '</td>';
                            echo '<td>', $allServices[$i]['InvoiceStatus'], '</td>';
                        }
                        ?>
                    </form>
                    </tbody>
                </table>
            </section>
            <div class="pageNum"><a href="#">BACK</a>&nbsp;&nbsp;&nbsp;<a href="#">NEXT</a></div>
        </div>
    </div>
</div>
</div>

</body>