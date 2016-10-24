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

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUSTREAM</title>
    <link rel="stylesheet" type="text/css" href="../css/default.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
<div class='settingPage'>
    <form method="post">
    <div class="goBack">
        <img class="goBackButton" src="../img/goBack.png">
    </div>
    <div class="settingResetPasswordPart">
        <p class="settingTitleStyle">RESET PASSWORD</p>
    </div>
    <div class='settingResetPasswordInput'>
        <div class='settingResetPasswordInputPart'>
            <input type="password" name="oldPassword" class="settingInputStyle" id="oldPasswordInput" placeholder=' OLD PASSWORD' size="38">
            </input>
        </div>
        <div class='settingResetPasswordInputPart'>
            <input type="password" name="newPassword" class="settingInputStyle" id="newPasswordInput" placeholder=' NEW PASSWORD' size="38">
            </input>
        </div>
        <div class='settingResetPasswordInputPart'>
            <input type="password" name="confirmPassword" class="settingInputStyle" id="retypePasswordInput" placeholder=' RE-TYPE PASSWORD' size="38">
        </div>
    </div>
    <div class="settingButtonPart">
        <input type="submit" value="COMFIRM" name="reset_password" class="settingButton">
        <?php
        if($isResetError){
            echo '<div class="error-message"><a>';
            global $resetErrorMessage;
            echo $resetErrorMessage;
            echo '</a></div>';
        }
        ?>
    </div>
    <div class="settingResetPasswordPart">
        <p class="settingTitleStyle">RESET PERSONAL INFO</p>
    </div>
    <div class='settingResetPasswordInput'>
        chensun1105@gmail.com
        <div class='settingResetPasswordInputPart'>
            <input type="email" name="newEmailAddress" class="settingInputStyle" id="newEmailAddressInput" placeholder=' NEW EMAIL ADDRESS' size="38">
            </input>
        </div>
        647-527-0528
        <div class='settingResetPasswordInputPart'>
            <input type="text" name="newContactNumber" class="settingInputStyle" id="newContactNumberInput" placeholder=' NEW CONTACT NUMBER' size="38">
            </input>
        </div>
    </div>
    <div class="settingButtonPart">
        <input type="submit" value="UPDATE" name="change_info" class="settingButton">
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
</body>
</html>

