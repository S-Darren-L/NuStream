<?php

// Start Session
session_start();

/*
Template Name: Admin Member Info
*/

?>

<?php
    // Set Navigation URL
    $filesURL = get_home_url() . '/admin-files-management/';
    $createSupplierURL = get_home_url() . '/admin-create-supplier';
    $createMemberURL = get_home_url() . '/admin-create-agent-account';
    $memberInfoURL = get_home_url() . '/admin-member-info';
    $supplierInfoURL = get_home_url() . '/admin-info-centre';

    // Check Session Exist
    if(!isset($_SESSION['AccountID'])){
        redirectToLogin();
    }

    // Logout User
    if(isset($_GET['logout'])) {
        logoutUser();
    }

    $UserName = $_SESSION['FirstName'] . " " . $_SESSION['LastName'];

    // Set URL
    $homeURL = get_home_url();
    $mainPath = $homeURL . "/wp-content/themes/NuStream/";
    $logo1ImagePath = $mainPath . "img/logo1.png";


    $orderVariable = 'FirstName';
    $member_info_result_rows = [];
    get_member_info_table($orderVariable);
    $member_info_result_rows = get_member_info_table($orderVariable);

    // Get All Member Brief Info
    function get_member_info_table($orderVariable){
        $result = get_agent_member_brief_info($orderVariable);
        if($result === null)
            echo 'result is null';
        while($row = mysqli_fetch_array($result))
        {
            $result_rows[] = $row;
        }
        for($i = 0; $i < count($result_rows); $i++){
            $teamResult = mysqli_fetch_array(get_team_by_team_id($result_rows[$i]['TeamID']));
            $result_rows[$i]['TeamLeaderName'] = $teamResult['TeamLeaderName'];
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
    <div id="nav">
        <div class="logo">
            <?php
            echo '<img src="' . $logo1ImagePath . '"/>';
            ?>
        </div>
        <div class="userNamePart">
            <h4 id="userName"><?php echo $UserName;?></h4>
            <h8 id="position" style="font-size:10px;"><?php echo $_SESSION['AccountPosition'];?></h8>
        </div>
        <ul class="nav nav-pills nav-stacked">
            <li><?php echo '<a href="' . $filesURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;Files</a></li>
            <li><?php echo '<a href="' . $createMemberURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-blackboard"></span>&nbsp;&nbsp;Create Member</a></li>
            <li><?php echo '<a href="' . $memberInfoURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-th-large"></span>&nbsp;&nbsp;Member Info</a></li>
            <li><?php echo '<a href="' . $createSupplierURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Create Supplier</a></li>
            <li><?php echo '<a href="' . $supplierInfoURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;Supplier Info</a></li>
            <li><a href="?logout" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
        </ul>
        <div class="footer">
            <p class="copyRight" style="font-size:10px;">@copyright @2016<br/> Darren Liu All Rights Reserved</p>
        </div>
    </div>
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
                                echo '<a href="#" ng-click="orderByField()"; reverseSort = !reverseSort">TEAM LEAD <span ng-show="orderByField()"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>';
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
                                    echo '<td>', '<a href="' . $homeURL . '/admin-edit-agent-account/?AID=' . $accountID . '" />', $member_info_result_rows[$i]["FirstName"] . " " . $member_info_result_rows[$i]["LastName"], '</td>';
                                    echo '<td>', $member_info_result_rows[$i]["TeamLeaderName"], '</td>';
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