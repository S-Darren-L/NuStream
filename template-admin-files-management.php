<?php

// Start Session
session_start();

/*
Template Name: Admin Files Management
*/

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
            <div class="topBar"><a href="#">All Files</a>|<a href="#">Pending Files</a>|<a href="#">Approved Files</a></div>
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
                    <tr ng-repeat="info in data.infoAccountant|orderBy:orderByField:reverseSort">
                        <td>{{info.MLSNUMBER}}</td>
                        <td>{{info.MEMBERNAME}}</td>
                        <td>{{info.TEAMLEAD}}</td>
                        <td>{{info.UPLOADDATE}}</td>
                        <td>{{info.SERVICETYPE}}</td>
                        <td>${{info.PRICEBEFFORETAX}} CDA</td>
                        <td><a href="#">VIEW</a></td>
                        <td STYLE="color:red;">NEW</td>
                    </tr>
                    </tbody>
                </table>
            </section>
            <div class="pageNum"><a href="#">BACK</a>&nbsp;&nbsp;&nbsp;<a href="#">NEXT</a></div>
        </div>
    </div>
</div>
</div>
<script>
    var app = angular.module('app', []);

    app.controller('MainCtrl', function($scope) {
        $scope.orderByField = 'MLSNUMBER';
        $scope.reverseSort = false;

        $scope.data = {
            infoAccountant: [{
                MLSNUMBER: 'N12345678',
                MEMBERNAME: 'JASMINE ZOU',
                TEAMLEAD:'DAVID R.TAsfawfawefO',
                UPLOADDATE:'2016/09/01',
                SERVICETYPE:'STAGING',
                PRICEBEFFORETAX:3500
            },{
                MLSNUMBER: 'N12345679',
                MEMBERNAME: 'ASMINE ZOU',
                TEAMLEAD:'DAVID R.TAO',
                UPLOADDATE:'2016/09/01',
                SERVICETYPE:'STAGING',
                PRICEBEFFORETAX:3500
            },{
                MLSNUMBER: 'N12345670',
                MEMBERNAME: 'ASMINE ZOU',
                TEAMLEAD:'AVID R.TAO',
                UPLOADDATE:'2016/09/01',
                SERVICETYPE:'STAGING',
                PRICEBEFFORETAX:3502
            }]
        };
    });
</script>
</body>