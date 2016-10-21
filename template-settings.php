<?php

// Start Session
session_start();

/*
Template Name: Settings
*/

    // Init Date
    $accountID = $_SESSION['AccountID'];

    // Reset Password
    if(isset($_POST['reset_password'])){
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        if($newPassword !== $confirmPassword){
            $resetErrorMessage = "New Password does not match";
            $isResetError = true;
        }

        $checkPasswordResult = mysqli_fetch_array(check_password($accountID, $oldPassword));
        if(!is_null($checkPasswordResult)){
            $resetErrorMessage = null;
            $isResetError = false;
            // Reset Password
            $resetPasswordResult = reset_member_password($accountID, $newPassword);

        }else{
            $resetErrorMessage = "Old password is not correct";
            $isResetError = true;
        }

    }

    // Update Account Info
    if(isset($_POST['change_info'])){
        $newEmailAddress = $_POST['newEmailAddress'];
        $newContactNumber = $_POST['newContactNumber'];
        if(!empty($newEmailAddress)){
            // Check if account exist
            $isAccountExistResult = is_account_exist($newEmailAddress);
            $isAccountExistResultRow = mysqli_fetch_array($isAccountExistResult);
            if(!is_null($isAccountExistResultRow)){
                $updateErrorMessage = "Email already exist";
                $isUpdateError = true;
            }
            else {
                $updateErrorMessage = null;
                $isUpdateError = false;
                $updateEmailResult = update_account_email($accountID, $newEmailAddress);
            }
        }
        if(!empty($newContactNumber)){
            $updateContactNumberResult = update_contact_number($accountID, $newContactNumber);
        }
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
        z-index:99999;
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
        padding-top: 1px;
        padding-left: 15px;
        background-color: #eeeeee;
        color:#a9a9a9;
        height: 350px;
        width: 680px;
        font-size: 11px;
    }

    .requireTitle {
        width: 150px;
        padding-left: 20px;
        float:left;
        padding-top: 5px;
    }

    .newPassword {
        float: left;
        margin-left: 10px;
    }

    .dropdown {
        height: 40px;
        width: 50px;
    }



    .upDate {
        float:left;
        margin-left: 15px;
        margin-top: -70px;
    }

    .upDateButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: 100px;
        height: 30px;
        width: 100px;
    }

    .confirmPart {
        float:left;
        margin-top: 20px;
    }

    .confirmButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: 100px;
        height: 30px;
        width: 100px;
    }
    .subTitle h5{
        margin-top: 3px;
        margin-bottom: 2px;
        color:#808080;
    }

    .line {
        height: 10px;
    }

    .inputContent {
        position:relative;
    }

    .supplierName {
        width: 100px;
        float: left;
    }
    .selectServerType {
        margin-left: 10px;
        float: left;
    }

    .selectServerType select {
        border-radius: 3px;
        height: 28px;
        width: 210px;
    }

    .retypePassword {
        margin-left: 10px;
        float: left;
    }



    .changeInfo {
        display: block;
        padding-top: 80px;
        margin-left: 0px;
        width: 250px;
    }

    .oldPassword{
        float: left;
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
        font-size: 100%;
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
            <div class="title"><h4>ACCOUNT SETTING</h4></div>
            <form method="post">
                <div class="form-group inputPart">
                    <div class="basicInfo">
                        <div class="subTitle"><h5>RESET PASSWORD</h5></div>
                        <div class="line" >
                            <hr style="height:1px; width:565px;border:none;border-top:1px solid #a9a9a9; float:left; margin:2px 5px 15px 0px;" />
                        </div>
                        <div class="inputContent">
                            <div class="oldPassword">
                                <input type="password" name="oldPassword" placeholder="OLD PASSWORD*" style="font-size:11px; height:27px;" size="30" require/>
                            </div>
                            <div class="newPassword">
                                <input type="password" name="newPassword" placeholder="NEW PASSWORD*" style="font-size:11px; height:27px;" size="30" require/>
                            </div>
                            <div class="retypePassword">
                                <input type="password" name="confirmPassword" placeholder="RE-TYPE PASSWORD*" style="font-size:11px; height:27px;" size="30" require/>
                            </div>
                        </div>
                        <div class="confirmPart">
                            <input type="submit" value="Reset" name="reset_password" class="confirmButton">
                            <?php
                            if($isResetError){
                                echo '<div class="error-message"><a>';
                                global $resetErrorMessage;
                                echo $resetErrorMessage;
                                echo '</a></div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="changeInfo">
                        <div class="subTitle" style="margin-top:20px;">
                            <h5>CHANGE PERSONAL INFOTMATION</h5>
                            <div class="line" >
                                <hr style="height:1px; width:180px;border:none;border-top:1px solid #a9a9a9; float:left; margin:2px 5px 5px 0px;" />
                            </div>
                        </div>
                        EMAIL ADDRESS
                        <input type="email" name="newEmailAddress" placeholder="NEW EMAIL ADDRESS" style="font-size:11px; margin-bottom:10px; margin-top:10px; height:27px;" size="30" require /></br>
                        CONTACT NUMBER
                        <input type="text" name="newContactNumber" placeholder="NEW CONTACT NUMBER" style="font-size:11px; margin:10px 0 25px 0; height:27px;" size="30" require />
                    </div>
                </div>
                <div class="upDate">
                    <input type="submit" value="Change" name="change_info" class="upDateButton">
                    <?php
                    if($isUpdateError){
                        echo '<div class="error-message"><a>';
                        global $updateErrorMessage;
                        echo $updateErrorMessage;
                        echo '</a></div>';
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
