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
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/pcStyles.css">
</head>
<body>
<div id="container">
    <?php
        include_once(__DIR__ . '/navigation.php');
    ?>
    <div id="main">
        <div class="formPart">
            <div class="SETTINGTitle">
		<p class="titleSize"><strong>ACCOUNT SETTING</strong></p>
            </div>
            <form method="post">
                <div class="form-group SETTINGInputPart">
                    <div class="SETTINGOneLineDiv">
                        <div class="subTitle"><h5>RESET PASSWORD</h5></div>
                        <div class="SETTINGOldPasswordPart">OLD PASSWORD *</br>
                            <input type="password" name="oldPassword" class="SETTINGOldPassword" require/>
                        </div>
                        <div class="SETTINGNewPasswordPart">NEW PASSWORD *</br>
                            <input type="password" name="newPassword" class="SETTINGNewPassword" require/>
                        </div>
                        <div class="SETTINGRetypePassword">RE-TYPE PASSWORD *</br>
                            <input type="password" name="confirmPassword" class="SETTINGRETypePassword" require/>
                        </div>
                    </div>
                    <div class="SETTINGOneLineDiv">
                        <input type="submit" value="COMFIRM" name="reset_password" class="SETTINGConfirmButton">
                        <?php
                        if($isResetError){
                            echo '<div class="error-message"><a>';
                            global $resetErrorMessage;
                            echo $resetErrorMessage;
                            echo '</a></div>';
                        }
                        ?>
                    </div>
                    <div class="SETTINGOneLineDiv SETTINGMoveSpace">
                        <div class="subTitle">
                            <h5>CHANGE PERSONAL INFOTMATION</h5> 
                        </div>
                        EMAIL ADDRESS</br>
                        <input type="email" name="newEmailAddress" placeholder="&nbsp;&nbsp;NEW EMAIL ADDRESS" class="SETTINGEmail" require /></br>
                        CONTACT NUMBER</br>
                        <input type="text" name="newContactNumber" placeholder="&nbsp;&nbsp;NEW CONTACT NUMBER" class="SETTINGEmail" require />
                    </div>   
                </div>
                <div class="SETTINGUpDate">
                    <input type="submit" value="UPDATE" name="change_info" class="SETTINGUpDateButton">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
