<?php

// Start Session
session_start();

/*
Template Name: Admin Files Management
*/

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
        $allServicesResult = get_all_services_with_file_by_status($serviceStatus);
        while($service = mysqli_fetch_array($allServicesResult))
        {
            $caseResult = mysqli_fetch_array(get_case_by_service_type_and_id($service['SupplierType'], $service['ServiceID']));
            $service['MLS'] = $caseResult['MLS'];
            $accountResult = mysqli_fetch_array(get_agent_account($caseResult['StaffID']));
            $service['MemberName'] = $accountResult['FirstName'] . $accountResult['LastName'];
            $teamResult = mysqli_fetch_array(get_team_by_team_id($accountResult['TeamID']));
            $service['TeamLeaderName'] = $teamResult['TeamLeaderName'];
            if($serviceStatus !== 'Report'){
                $service['File'] = mysqli_fetch_array(download_file_by_path($service['InvoicePath']))['FileName'];
            }
            $allServices[] = $service;
        }
        return $allServices;
    }

    // Download FIle
    if(isset($_GET['File'])){
        download_file($_GET['File']);
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
            <div class="FATitle"><p class="titleSize">CREATE NEW SUPPLIER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php
                    echo '<a class="FASubTitle" href="' . $subMenuURL . '' . '">All Files&nbsp;&nbsp;</a>|<a class="FASubTitle" href="' . $subMenuURL . "Pending" . '">&nbsp;&nbsp;Pending Files&nbsp;&nbsp;</a>|<a class="FASubTitle" href="' . $subMenuURL . "Approved" . '">&nbsp;&nbsp;Approved Files&nbsp;&nbsp;</a>';
                ?></p>
            </div>
            <section ng-app="app" ng-controller="MainCtrl">
                <table  class="FATable">
                    <thead>
                    <tr>
                        <th class="FATableHead">
                            <a href="#" ng-click="orderByField='MLSNUMBER'; reverseSort = !reverseSort">MLS NUMBER <span ng-show="orderByField == 'MLSNUMBER'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>
                        </th>
                        <th class="FATableHead">
                            <a href="#" ng-click="orderByField='MEMBERNAME'; reverseSort = !reverseSort">MEMBER NAME <span ng-show="orderByField == 'MEMBERNAME'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th class="FATableHead">
                            <a href="#" ng-click="orderByField='TEAMLEAD'; reverseSort = !reverseSort">TEAM LEAD <span ng-show="orderByField == 'TEAMLEAD'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th class="FATableHead">
                            <a href="#" ng-click="orderByField='UPLOADDATE'; reverseSort = !reverseSort">UPLOAD DATE <span ng-show="orderByField == 'UPLOADDATE'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th class="FATableHead">
                            <a href="#" ng-click="orderByField='SERVICETYPE'; reverseSort = !reverseSort">SERVICE TYPE <span ng-show="orderByField == 'SERVICETYPE'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th class="FATableHead FATableHeadLarge">
                            <a href="#" ng-click="orderByField='PRICEBEFFORETAX'; reverseSort = !reverseSort">PRICE BEFFORE TAX <span ng-show="orderByField == 'PRICEBEFFORETAX'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th  class="FATableHead FATableHeadSmall">
                            <a href="#">INVOICE</a>
                        </th>
                        <th  class="FATableHead FATableHeadSmall">
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
                            echo '<td>', '<a href="' . $subMenuURL . $serviceStatus . '&File=' . $allServices[$i]["File"] . '">DOWNLOAD</a>', '</td>';
                            echo '<td>', $allServices[$i]['InvoiceStatus'], '</td>';
                        }
                        ?>
                    </form>
                    </tbody>
                </table>
            </section>
            <div class="FAPageNum"><a href="#">BACK</a>&nbsp;&nbsp;&nbsp;<a href="#">NEXT</a></div>
        </div>
    </div>
</div>
</div>
<script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>