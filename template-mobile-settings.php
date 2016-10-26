<?php

// Start Session
session_start();

/*
Template Name: Mobile Settings
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

<html class="gr__nustreamtoronto_com"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style type="text/css">@charset "UTF-8";[ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\:form{display:block;}.ng-animate-shim{visibility:hidden;}.ng-anchor{position:absolute;}</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUSTREAM</title>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/styles.css">
    <style>
        .Input{
            width: 250px;
            border-radius: 5px;
            border: 1px solid grey;
            text-indent: 5px;
        }

        .Input:hover{
            border:1px solid black;
        }
    </style>
</head>
<body data-gr-c-s-loaded="true">
    <div ng-app="App" ng-controller="myController" class="ng-scope settingPage">
        <form method="post">
            <div class="goBack">
            </div>
            <div class="settingResetPasswordPart">
                <p class="settingTitleStyle">RESET PASSWORD</p>
            </div>
            <div class='settingResetPasswordInput'>
                <div class='settingResetPasswordInputPart'>
                    <input type="password" name="oldPassword" class="settingInputStyle Input" id="oldPasswordInput" placeholder='OLD PASSWORD' size="38"/>
                </div>
                <div class='settingResetPasswordInputPart'>
                    <input type="password" name="newPassword" class="settingInputStyle Input" id="newPasswordInput" placeholder='NEW PASSWORD' size="38" />
                </div>
                <div class='settingResetPasswordInputPart'>
                    <input type="password" name="confirmPassword" class="settingInputStyle Input" id="retypePasswordInput" placeholder='RE-TYPE PASSWORD' size="38" />
                </div>
            </div>
            <div class="settingButtonPart">
                <input type="submit" value="COMFIRM" name="reset_password" class="settingButton" />
                <?php
                if($isResetError){
                echo '<div class="error-message">
                    <a>
                        ';
                        global $resetErrorMessage;
                        echo $resetErrorMessage;
                        echo '
                    </a>
                </div>';
                }
                ?>
            </div>
            <div class="settingResetPasswordPart">
                <p class="settingTitleStyle">RESET PERSONAL INFO</p>
            </div>
            <div class='settingResetPasswordInput'>
                EMAIL ADDRESS
                <div class='settingResetPasswordInputPart'>
                    <input type="email" name="newEmailAddress" class="settingInputStyle Input" id="newEmailAddressInput" placeholder='NEW EMAIL ADDRESS' size="38" />
                </div>
                PHONE NUMBER
                <div class='settingResetPasswordInputPart'>
                    <input type="text" name="newContactNumber" class="settingInputStyle Input" id="newContactNumberInput" placeholder='NEW CONTACT NUMBER' size="38" />
                </div>
            </div>
            <div class="settingButtonPart">
                <input type="submit" value="UPDATE" name="change_info" class="settingButton" />
                <?php
                if($isUpdateError){
                echo '<div class="error-message">
                    <a>
                        ';
                        global $updateErrorMessage;
                        echo $updateErrorMessage;
                        echo '
                    </a>
                </div>';
                }
                ?>
            </div>
        </form>
    </div>
</body>
</html>

