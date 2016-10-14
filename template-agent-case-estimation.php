<?php

// Start Session
session_start();

/*
Template Name: Agent Case Estimation
*/

?>

<?php
    // Init Data
    $propertyTypes = get_property_types();



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

    .formPart {
        display: relative;
        margin-right: 40px;
        margin-left: 40px;
        padding-top: 40px;
    }

    .tablePart {
        float: left;
        width: 400px;
        margin-left: 0px;
    }

    .table-style {
        width: 300px !important;
        padding-left:20px;
        margin-left: 20px;
        border-color: #fff;
    }

    .table-style th{
        font-size: 10px;
        color:#a9a9a9;
    }

    .table-style td{
        border: 2px solid #fff;
        color:#a9a9a9;
    }

    .estimationPart {
        margin-left: 420px;
        background-color: #32323a;
        height: 210px;
        width: 270px;
        color:#fff;
        border-radius: 2px;
    }

    .estimateButtonPart {
        display: absolute;
        margin-left: 440px;
    }

    .clearAllPart {
        padding-left: 120px;
        margin-top: -30px;
    }

    .clearAllButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: bold;
        height: 30px;
        width: 100px;
        font-size: 11px;
    }

    .estimatePart {
        margin-top: 20px;
    }

    .estimateButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: bold;
        height: 30px;
        width: 100px;
        font-size: 11px;
    }

    .estimationAgentSelect {
        color:#a9a9a9! important;
        width: 185px;
    }

    .estimationAgentOption {
        height:30px;
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
            <form method="post">
                <div class="tablePart">
                    <table>
                        <table class="table table-style">
                            <thead style="background-color:#fffeff">
                            <th></th>
                            <th>SERVERTYPE</th>
                            <th>ESTIMATE COST</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="checkbox" value="checked"></td>
                                <td>STAGING</td>
                                <td style="text-align:center;">$355</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" value="checked"></td>
                                <td>TOUCH UP</td>
                                <td style="text-align:center;">$355</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" value="checked"></td>
                                <td>CLEARN UP</td>
                                <td style="text-align:center;">$355</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" value="checked"></td>
                                <td>YARDWORK</td>
                                <td style="text-align:center;">$355</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" value="checked"></td>
                                <td>INSPECTION</td>
                                <td style="text-align:center;">$355</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" value="checked"></td>
                                <td>STORGAE</td>
                                <td style="text-align:center;">$355</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" value="checked"></td>
                                <td>RELOCATION HOME</td>
                                <td style="text-align:center;">$355</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" value="checked"></td>
                                <td>PHOTOGRAPHY</td>
                                <td style="text-align:center;">$355</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="line" >
                            <hr style="height:1px; width:300px;border:none;border-top:2px solid #a9a9a9; float:left; margin:2px 5px 5px 15px;" />	</br>
                        </div>
                        <h4 style="margin-left:20px;color:#a9a9a9; font-size:15px;">Total Cost:  $5000.00</h4>
                </div>
                <div class="estimationPart">
                    <h4 style="padding:10px 0 0 10px;">ESTIMATION</h4>
                    <div class="line" >
<<<<<<< HEAD
                        <hr style="height:1px; width:300px;border:none;border-top:2px solid #a9a9a9; float:left; margin:2px 5px 5px 15px;" />   </br>
                    </div>
                    <h4 style="margin-left:20px;color:#a9a9a9; font-size:15px;">Total Cost:  $5000.00</h4>
            </div>
            <div class="estimationPart">
                <h4 style="padding:10px 0 0 10px;">ESTIMATION</h4>
                <div class="line" >
                    <hr style="height:1px; width:240px;border:none;border-top:1px solid #fff; float:left; margin:2px 5px 5px 10px;" />  </br>
                </div>
                <input type="text" value="" placeholder="HOUSE SIZE*" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;" size="30" require />
                <!-- <input type="text" value="" placeholder="PROPERTY TYPE*" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;" size="30" require /> -->
                <select class="estimationAgentSelect" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;"> 
                    <option class="estimationAgentOption">PROPERTY TYPE*</option> 
                    <option class="estimationAgentOption">ONE</option> 
                    <option class="estimationAgentOption">TWO</option>
                </select>
                <input type="text" value="" placeholder="LAND SIZE*" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;" size="30" require />
            </div>
            <div class="estimateButtonPart">
                <div class="estimatePart">
                    <button class="estimateButton">ESTIMATE</button>
                </div>
                <div class="clearAllPart">
                    <button class="clearAllButton">CLEAR ALL</button>
                </div>
            </div>
=======
                        <hr style="height:1px; width:240px;border:none;border-top:1px solid #fff; float:left; margin:2px 5px 5px 10px;" />	</br>
                    </div>
                    <input type="text" name="houseSize" value="" placeholder="HOUSE SIZE*" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;" size="30" require />
                    <div class="selectPropertyType">
                        <div class="dropdown">
                            <select name="propertyType">
                                <?php
                                foreach ($propertyTypes as $propertyTypeItem){
                                    echo '<option value="' . $propertyTypeItem . '">', $propertyTypeItem, '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
<!--                    <input type="text" name="propertyType" value="" placeholder="PROPERTY TYPE*" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;" size="30" require />-->
                    <input type="text" name="landSize" value="" placeholder="LAND SIZE*" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;" size="30" require />
                </div>
                <div class="clearAll">
                    <input value="ESTIMATE" class="clearAllButton" name="estimate">
                    <input value="CLEAR ALL" class="clearAllButton" name="clear_all">
                </div>
            </form>
>>>>>>> 288321350e374a0f567aeeba8547e6116d234752
        </div>
    </div>
</div>
</body>