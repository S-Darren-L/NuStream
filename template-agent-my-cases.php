<?php

// Start Session
session_start();

/*
Template Name: Agent My Cases
*/

?>

<?php
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
        width: 850px !important;
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
            <section ng-app="app" ng-controller="MainCtrl">
                <table  class="table table-striped">
                    <thead style="background-color:#535353;">
                    <tr>
                        <th>
                            <a href="#" ng-click="orderByField='MLSNUMBER'; reverseSort = !reverseSort">MLS NUMBER <span ng-show="orderByField == 'MLSNUMBER'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>
                        </th>
                        <th>
                            <a href="#" ng-click="orderByField='STARTEDDATE'; reverseSort = !reverseSort">STARTED DATE <span ng-show="orderByField == 'STARTEDDATE'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th>
                            <a href="#" ng-click="orderByField='PROPERTYTYPE'; reverseSort = !reverseSort">PROPERTY TYPE <span ng-show="orderByField == 'PROPERTYTYPE'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th>
                            <a href="#">ADDRESS</a>
                        </th>
                        <th>
                            <a href="#" ng-click="orderByField='STATUS'; reverseSort = !reverseSort">STATUS <span ng-show="orderByField == 'STATUS'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                        <th>
                            <a href="#" ng-click="orderByField='STATUS'; reverseSort = !reverseSort">View Detail <span ng-show="orderByField == 'STATUS'"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        for($i = 0; $i < count($CasesBriefInfoArray); $i++) {
                            echo '<tr>';
                                $MLS = $CasesBriefInfoArray[$i]["MLS"];
                                echo '<td >', '<a href="' . $homeURL . '/agent-edit-case/?CID=' . $MLS . '" >', $MLS, '</a>', '</td>';
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
            <div class="pageNum"><a href="#">BACK</a>&nbsp;&nbsp;&nbsp;<a href="#">NEXT</a></div>
        </div>
    </div>
</div>
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