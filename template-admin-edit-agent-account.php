<?php

    // Start Session
    session_start();

    /*
    Template Name: Admin Edit Agent Account
    */

    // Get Supplier ID
    $accountID = $_GET['AID'];

    // Init Date
    init_data($accountID);

    // Init Date
    function init_data($accountID){
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

    // Validate Mandatory Fields
    function date_validated()
    {
        $contactNumber = test_input($_POST["contactNumber"]);
        $email = test_input($_POST["email"]);

        global $errorMessage;
        global $isError;
        if (empty($contactNumber) || empty($email)) {
            $errorMessage = "Mandatory fields are empty";
            $isError = true;
            return false;
        } else {
            $errorMessage = null;
            $isError = false;
            return true;
        }
    }

    // Update Team
    if(isset($_POST['update_account']) && date_validated() === true) {
        $updateAccountArray = array(
            "accountID" => $accountID,
            "contactNumber" => $_POST['contactNumber'],
            "email" => $_POST['email']
        );
        $updateAccountResult = update_account($updateAccountArray);

        // Navigate
        if($updateAccountResult === true){
            $url = get_home_url() . '/admin-member-info';
            echo("<script>window.location.assign('$url');</script>");
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
        global $adminMemberInfoURL;
        echo("<script>window.location.assign('$adminMemberInfoURL');</script>");
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


    .error-message a{
        color: red;
        font-size: 80%;
    }

</style>
<html>
<head>
    <title>Edit Account Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>NuStream 新勢力地產</title>
</head>
<body>
<div id="container">
    <?php
        include_once(__DIR__ . '/navigation.php');
    ?>
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
                        <?php
                        if($isError){
                            echo '<div class="error-message"><a>';
                            global $errorMessage;
                            echo $errorMessage;
                            echo '</a></div>';
                        }
                        ?>
                    </div>
                </div>
                <input type="submit" value="Back" name="navigate_back">
            </form>
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
