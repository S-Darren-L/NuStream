<?php

    // Start Session
    session_start();

    /*
    Template Name: Accountant File Management
    */

?>

<?php
    // Set Cookie Name
    $cookieName = 'userLogin';

    // Set Navigation URL
    $infoCentreURL = get_home_url() . '/admin-info-centre/';

    // Check Session Exist
    if(!isset($_SESSION['AccountID'])){
        redirectToLogin();
    }

    $UserName = $_SESSION['FirstName'] . " " . $_SESSION['LastName'];

    if(isset($_GET['logout'])) {
        // Destroy Session
        // Unset all of the session variables.
        $_SESSION = array();

        // Finally, destroy the session.
        session_destroy();

        // Destroy Cookie
        if(isset($_COOKIE[$cookieName])){
            $expiry = time() - 60*60*24*180;
            $deleteCookie = setcookie($cookieName, "", $expiry, '/', $_SERVER['SERVER_NAME'], false, false);
        }

        // Redirect To Login
        redirectToLogin();
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
    <div id="nav">
        <div class="logo">
            <img src="img/logo1.png"/>
        </div>
        <div class="userNamePart">
            <h4 id="userName"><?php echo $UserName;?></h4>
            <h8 id="position" style="font-size:10px;"><?php echo $_SESSION['AccountPosition'];?></h8>
        </div>
        <ul class="nav nav-pills nav-stacked">

            <li class="active"><a href="#"  style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;Files</a></li>
            <li>><?php echo '<a href="' . $infoCentreURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;Info Center</a></li>
            <li><a href="#" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Member Info</a></li>
            <li><a href="?logout" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
        </ul>
        <div class="footer">
            <p class="copyRight" style="font-size:10px;">@copyright @2016<br/> Darren Liu All Rights Reserved</p>
        </div>
    </div>
    <div id="main">
        <div class="formPart">
            <table class="table table-striped" >
                <thead style="background-color:#535353;">
                <tr>
                    <th>MLS NUMBER</th>
                    <th>MEMBER NAME</th>
                    <th>TEAM LEAD</th>
                    <th>UPLOAD DATAE</th>
                    <th>SERVICE TYPE</th>
                    <th>PRICE BEFFORE TAX</th>
                    <th>INVOICE</th>
                    <th>SELECT</th></tr>
                </thead>
                <!-- There should be a dynamic table body-->
                <tbody>
                <tr>
                    <td>n12345678</td>
                    <td>JASMINE ZOU</td>
                    <td>DAVID TAO</td>
                    <td>2016/09/03</td>
                    <td>STAGING</td>
                    <td>$3500 CAD</td>
                    <td><a href="#">DOWNLOAD</a> <a href="#">VIEW</a></td>
                    <td><input name="SelectButton" checked="checked" type="checkbox"></td>
                </tr>
<!--                <tr>-->
<!--                    <td>n12345678</td>-->
<!--                    <td>JASMINE ZOU</td>-->
<!--                    <td>DAVID TAO</td>-->
<!--                    <td>2016/09/03</td>-->
<!--                    <td>STAGING</td>-->
<!--                    <td>$3500 CAD</td>-->
<!--                    <td><a href="#">DOWNLOAD</a> <a href="#">VIEW</a></td>-->
<!--                    <td><input name="SelectButton" checked="checked" type="radio"></td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>n12345678</td>-->
<!--                    <td>JASMINE ZOU</td>-->
<!--                    <td>DAVID TAO</td>-->
<!--                    <td>2016/09/03</td>-->
<!--                    <td>STAGING</td>-->
<!--                    <td>$3500 CAD</td>-->
<!--                    <td><a href="#">DOWNLOAD</a> <a href="#">VIEW</a></td>-->
<!--                    <td><input name="SelectButton" checked="checked" type="radio"></td>-->
<!--                </tr>-->
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>



