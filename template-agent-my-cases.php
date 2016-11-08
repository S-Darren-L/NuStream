<?php

// Start Session
session_start();

/*
Template Name: Agent My Cases
*/

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
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/pcStyles.css">
    <title>NuStream 新勢力地產</title>
</head>
<body>
<div id="container">
    <?php
        include_once(__DIR__ . '/navigation.php');
    ?>
    <div id="main">
        <div class="formPart">
            <div class="MCATitle">
		<p class="titleSize"><strong>MY CASES</strong></p>
	    </div>
            <section ng-app="app" ng-controller="MainCtrl">
                <table class="MCATable">
                    <thead>
                    <tr>
                        <th class="MCATableHead MCATableFirstLine">
                            <a href="#" ng-click="orderByField='MLSNUMBER'; reverseSort = !reverseSort">MLS NUMBER <!--<span ng-show="orderByField == 'MLSNUMBER'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>--></a>
                        </th>
                        <th class="MCATableHead">
                            <a href="#" ng-click="orderByField='STARTEDDATE'; reverseSort = !reverseSort">STARTED DATE <!--<span ng-show="orderByField == 'STARTEDDATE'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>-->
                            </a>
                        </th>
                        <th class="MCATableHead">
                            <a href="#" ng-click="orderByField='PROPERTYTYPE'; reverseSort = !reverseSort">PROPERTY TYPE <!--<span ng-show="orderByField == 'PROPERTYTYPE'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>-->
                            </a>
                        </th>
                        <th class="MCATableHead MYATableHeadLarge">
                            <a href="#">ADDRESS</a>
                        </th>
                        <th class="MCATableHead MYATableHeadLarge">
                            <a href="#" ng-click="orderByField='STATUS'; reverseSort = !reverseSort">STATUS <!--<span ng-show="orderByField == 'STATUS'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>-->
                            </a>
                        </th>
                        <th>
                            <a href="#" ng-click="orderByField='STATUS'; reverseSort = !reverseSort">View Detail <!--<span ng-show="orderByField == 'STATUS'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>-->
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        for($i = 0; $i < count($CasesBriefInfoArray); $i++) {
                            echo '<tr>';
                                $MLS = $CasesBriefInfoArray[$i]["MLS"];
                                echo '<td class="MCATableFirstLine">', '<a href="' . $homeURL . '/agent-edit-case/?CID=' . $MLS . '" >', $MLS, '</a>', '</td>';
                                echo '<td >', $CasesBriefInfoArray[$i]["StartDate"], '</td>';
                                echo '<td>', $CasesBriefInfoArray[$i]["PropertyType"], '</td>';
                                echo '<td>', $CasesBriefInfoArray[$i]["Address"], '</td>';
                                echo '<td>', $CasesBriefInfoArray[$i]["CaseStatus"], '</td>';
                            echo '<td >', '<a href="' . $homeURL . '/agent-case-details/?CID=' . $MLS . '" >', "View", '</a>', '</td>';
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
                </table>
            </section>
            <div class="MCAPageNum"><a href="#">BACK</a>&nbsp;&nbsp;&nbsp;<a href="#">NEXT</a></div>
        </div>
    </div>
</div>
<script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    var app = angular.module('app', []);

    app.controller('MainCtrl', function($scope) {
        $scope.orderByField = 'MLSNUMBER';
        $scope.reverseSort = false;

        $scope.data = {
            infoCase: [{
                MLSNUMBER: 'N12345678',
                STARTEDDATE: '09/25/2016',
                PROPERTYTYPE:'CONDO',
                ADDRESS:'238 BONIS AVE, SCRBOROUGH, M1T 357'
            },{
                MLSNUMBER: 'N12345678',
                STARTEDDATE: '09/25/2016',
                PROPERTYTYPE:'CONDO',
                ADDRESS:'238 BONIS AVE, SCRBOROUGH, M1T 357'
            },{
                MLSNUMBER: 'N12345678',
                STARTEDDATE: '09/25/2016',
                PROPERTYTYPE:'CONDO',
                ADDRESS:'238 BONIS AVE, SCRBOROUGH, M1T 357'
            }]
        };
    });
</script>

</body>