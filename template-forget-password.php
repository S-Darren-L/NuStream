<?php

/*
Template Name: Forget Password
*/

    // Reset Password
    if(isset($_POST['reset_password'])) {
        $email = $_POST['email'];
        // Check if account exist
        $isAccountExistResult = is_account_exist($email);
        $isAccountExistResultRow = mysqli_fetch_array($isAccountExistResult);
        if (!is_null($isAccountExistResultRow)) {
            $errorMessage = null;
            $isError = false;

            // Generate Password
            $password = generate_password();
            $forgetPasswordArray = array(
                "accountID" => $isAccountExistResultRow['AccountID'],
                "password" => $password
            );
            $forgetPasswordResult = forget_password($forgetPasswordArray);

            if(!is_null($forgetPasswordResult)){
                // Send User Password By Email
                $sendEmailResult = send_user_new_password($email, $isAccountExistResultRow['FirstName'], $isAccountExistResultRow['LastName'], $password);
            }
        } else {
            $errorMessage = "Email does not exist";
            $isError = true;
        }
    }
?>
<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>NuStream 新勢力地產</title>

    <style>
        .contentPart {
            width:80%;
            height: 170px;
            margin:0 auto;
            border:1px #a9a9a9 solid;
        }
        .modal-title {
            text-align: center;
        }
        .contentPart p {
            text-align: center;
            padding-top: 20px;
        }
        .contentPart input {
            margin-top: 10px;
            margin-left: 10%;
            border-radius: 3px;
            border:1px #a9a9a9 solid;
            margin-bottom: 10px;
            height: 30px;
            width: 80%;
        }
        .sendPassword {
            width: 80%;
            margin-left: 10%;
        }
        .modalStyle {
            height: 300px;
        }
        .error-message a{
            color: red;
            font-size: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Forget Password</h2>

    <form method="post">
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">forget password</button>
    </form>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>

                <div class="modal-body">
                    <div class="contentPart">
                        <form method="post">
                            <p>If you forget your password, you can reset here.</p>
                            <input type="email" name="email" placeholder="E-mail Address" size="50">
                            <input type="submit" name="reset_password" value="Send My Password" class="btn btn-primary sendPassword">
                            <?php
                            if($isError){
                                echo '<div class="error-message"><a>';
                                global $errorMessage;
                                echo $errorMessage;
                                echo '</a></div>';
                            }
                            ?>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
