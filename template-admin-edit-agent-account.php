<?php

    // Start Session
    session_start();

    /*
    Template Name: Admin Edit Agent Account
    */

?>

<?php
    // Get Supplier ID
    $accountID = $_GET['AID'];

    // Set Navigation URL
    $filesURL = get_home_url() . '/admin-files-management/';
    $createSupplierURL = get_home_url() . '/admin-create-supplier';
    $createMemberURL = get_home_url() . '/admin-create-agent-account';
    $memberInfoURL = get_home_url() . '/admin-member-info';
    $supplierInfoURL = get_home_url() . '/admin-supplier-info';

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

    // Init Date
    init_date($accountID);

    // Init Date
    function init_date($accountID){
        $getAgentAccountResult = get_agent_account($accountID);
        if($getAgentAccountResult !== null){
            $getAgentAccountArray = mysqli_fetch_array($getAgentAccountResult);
            global $accountID;
            global $firstName;
            global $lastName;
            global $contactNumber;
            global $email;

            $accountID = $getAgentAccountArray['AccountID'];
            $firstName = $getAgentAccountArray['FirstName'];
            $lastName = $getAgentAccountArray['LastName'];
            $contactNumber = $getAgentAccountArray['ContactNumber'];
            $email = $getAgentAccountArray['Email'];
        }
        else{
            echo die("Cannot find account");
        }
    }

    // Update Team
    if(isset($_POST['update_account'])) {
        $updateAccountArray = array(
            "accountID" => $accountID,
            "contactNumber" => $_POST['contactNumber'],
            "email" => $_POST['email']
        );
        $updateAccountResult = update_account($updateAccountArray);
        if($updateAccountResult === true){
            init_date($accountID);
        }
    }

    // Deactivate Account
    if(isset($_POST['deactivate_account'])){
        $deactivateResult = deactivate_account_by_id($accountID);
        navigate_back();
    }

    // Navigate Back
    if(isset($_POST['navigate_back'])){
        navigate_back();
    }

    function navigate_back(){
        global $memberInfoURL;
        $url = get_home_url();
        echo("<script>window.location.assign('$memberInfoURL');</script>");
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
        color:#616161;
        font-weight: bold;
    }

    .inputPart {
        padding-top: 30px;
        background-color: #eeeeee;
        color:#a9a9a9;
        height: 350px;
        width: 600px;
        font-size: 11px;
    }

    .requireTitle {
        width: 150px;
        padding-left: 20px;
        float:left;
        padding-top: 5px;
    }

    .inputContent {
        overflow: hidden;
        margin-bottom: 30px;
    }

    fieldset {
        overflow: hidden
    }

    .radioButtonPart {
        float: left;
        clear: none;
    }

    label {
        float: left;
        clear: none;
        display: block;
        padding: 5px 20px 0 3px;
    }

    input[type=radio],
    input.radio {
        float: left;
        clear: none;
        padding-top: 5px;
        margin: 2px 0 0 2px;
        font-size: 11px !important;
        color:#616161;
    }

    .selectTeam {
        float: left;
        clear: none;
        margin: 0px 0 0 2px;
    }

    .dropdown {
        height: 40px;
        width: 70px;
    }

    select {
        border-radius: 3px;
        height: 30px;
        width: 110px;
    }

    .update {
        float:left;
        padding-left: 20px;
        margin-left: 0px;
    }

    .updateButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: 100px;
        height: 30px;
        width: 100px;
    }

    .delete{
        float:left;
        padding-left: 20px;
        margin-left: 0px;
    }

    .deleteButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: 100px;
        height: 30px;
        width: 100px;
    }


</style>
<html>
<head>
    <title>Edit Account Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
            <div class="title"><h4>EDIT ACCOUNT</h4></div>
            <form method="post">
                <div class="form-group inputPart">
                    <div class="requireTitle">MEMBER NAME</div>
                    <div class="inputContent">
                        <input class="prayer-first-name" type="text" disabled="disabled" name="firstName" value="<?php echo $firstName; ?>" id="firstName" placeholder=" FIRST NAME*" style="font-size:11px; height:30px;" size="26" require/>
                        <input class="prayer-email" type="text" disabled="disabled" name="lastName" value="<?php  echo $lastName; ?>" id="lastName" placeholder=" LAST NAME*" style="font-size:11px; height:30px;" size="27" require/>
                    </div>
                    <div class="requireTitle">CONTACT NUMBER*</div>
                    <div class="inputContent contactNum">
                        <input class="prayer-email" type="text" name="contactNumber" value="<?php echo $contactNumber; ?>" id="contactNumber" placeholder="CONTACT NUMBER" style="font-size:11px; height:30px;" size="59" require/>
                    </div>
                    <div class="requireTitle">EAMIL ADDRESS*</div>
                    <div class="inputContent contactEmail">
                        <input class="prayer-email" type="email" name="email" value="<?php echo $email; ?>" id="emailAddress" placeholder="EAMIL ADDRESS" style="font-size:11px; height:30px;" size="59" require/>
                    </div>
                    <div class="update">
                        <input type="submit" value="Update" name="update_account">
                    </div>
                    <div class="delete">
                        <input type="submit" value="Deactivate" name="deactivate_account">
                    </div>
                </div>
                <input type="submit" value="Back" name="navigate_back">
            </form>
        </div>
    </div>
</body>
</html>
