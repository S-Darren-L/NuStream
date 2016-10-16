<?php

// Start Session
session_start();

/*
Template Name: Superuser Member Info
*/

?>

<?php
    // Init Data
    $orderVariable = 'FirstName';
    $member_info_result_rows = [];
    $member_info_result_rows = get_member_info_table($orderVariable);

    // Get All Member Brief Info
    function get_member_info_table($orderVariable){
        $result = get_admin_and_account_member_brief_info($orderVariable);
        if($result === null)
            echo 'result is null';
        while($row = mysqli_fetch_array($result))
        {
            $result_rows[] = $row;
        }
        for($i = 0; $i < count($result_rows); $i++){
            if($result_rows[$i]['AccountPosition'] === 'ADMIN')
                $result_rows[$i]['AccountType'] = 'Admin';
            else if($result_rows[$i]['AccountPosition'] === 'ACCOUNTANT')
                $result_rows[$i]['AccountType'] = 'Accountant';
        }
        return $result_rows;
    }

    // Deactivate Account
    if(isset($_POST['deactivate_account'])){
        $accountID = $_POST['accountID'];
        $deactivateResult = deactivate_account_by_id($accountID);
        header("Refresh:0");
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
        width: 900px !important;
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
            <div class="title"><h4>Member Information</h4></div>
            <?php
                echo '<table class="table table-striped">';
                    // Table Head
                    echo '<thead style="background-color:#535353;">';
                        echo '<tr>';
                            echo '<th>';
                                echo '<a href="#" ng-click="orderByField()"; reverseSort = !reverseSort">MEMBER NAME <span ng-show="orderByField()"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>';
                            echo '</th>';
                            echo '<th>';
                                echo '<a href="#" ng-click="orderByField()"; reverseSort = !reverseSort">ACCOUNT TYPE <span ng-show="orderByField()"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>';
                            echo '</th>';
                            echo '<th>';
                                echo '<a href="#" ng-click="orderByField()"; reverseSort = !reverseSort">CONTACT NUMBER <span ng-show="orderByField()"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>';
                            echo '</th>';
                            echo '<th>';
                                echo '<a href="#" ng-click="orderByField()"; reverseSort = !reverseSort">EMAIL <span ng-show="orderByField()"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>';
                            echo '</th>';
                            echo '<th>';
                                echo '<a href="#">Deactivate ACCOUNT </a>';
                            echo '</th>';
                        echo '</tr>';
                    echo '</thead>';
                    // Table Body
                    echo '<tbody id="tbody">';
                        for($i = 0; $i < count($member_info_result_rows); $i++) {
                            $accountID = $member_info_result_rows[$i]["AccountID"];
                                echo '<tr ng-repeat="info in data.infoAdmin|orderBy:orderByField:reverseSort">';
                                    echo '<td>', '<a href="' . $homeURL . '/superuser-edit-account/?AID=' . $accountID . '" />', $member_info_result_rows[$i]["FirstName"] . " " . $member_info_result_rows[$i]["LastName"], '</td>';
                                    echo '<td>', $member_info_result_rows[$i]["AccountType"], '</td>';
                                    echo '<td>', $member_info_result_rows[$i]["ContactNumber"], '</td>';
                                    echo '<td>', $member_info_result_rows[$i]["Email"], '</td>';
                                    echo '<td>';
                                        echo '<form method="post">';
                                            echo '<input type="text" hidden="hidden" name="accountID" value="' . $accountID . '">';
                                            echo '<input type="submit" value="Deactivate" name="deactivate_account">';
                                        echo '</form>';
                                    echo '</td>';
                                echo '</tr>';
                        }
                    echo '</tbody>';
                echo '</table><br />';
            ?>
            <div class="pageNum"><a href="#">BACK</a>&nbsp;&nbsp;&nbsp;<a href="#">NEXT</a></div>
        </div>
    </div>
</div>
</body>