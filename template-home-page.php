<?php

/*
Template Name: Home Page
*/

?>

<?php
    session_status();

    if(isset($_POST['login'])){
        $email = strip_tags($_POST['email']);
//        $password = strip_tags($_POST['password']);

        $email = stripslashes($email);
        $password = stripslashes($password);

        $loginArray = array(
            "email" => $email,
            "password" => "",
        );

        $loginResult = login($loginArray);
        $loginData = mysqli_fetch_array($loginResult);
        $isLoginFailed= is_null($loginData);
        if(!$isLoginFailed) {
            $_SESSION['accountID'] = $row['AccountID'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['lastName'] = $row['LastName'];
            $_SESSION['accountID'] = $row['AccountID'];
            $_SESSION['teamID'] = $row['TeamID'];
            $_SESSION['accountPosition'] = 'ACCOUNTANT';
            //temp
//            $_SESSION['accountPosition'] = $row['AccountPosition'];
            $_SESSION['isTeamLeader'] = $row['IsTeamLeader'];
            if ($_SESSION['accountPosition'] === 'ADMIN') {
//                $url = get_home_url() . '/admin-file-management/';
//                echo("<script>window.location.assign('$url');</script>");
            } else if ($_SESSION['accountPosition'] === 'AGENT') {
//                $url = get_home_url() . '/my-cases/';
//                echo("<script>window.location.assign('$url');</script>");
            }else if ($_SESSION['accountPosition'] === 'ACCOUNTANT') {
                $url = get_home_url() . '/accountant-file-management/';
                echo("<script>window.location.assign('$url');</script>");
            }else if ($_SESSION['accountPosition'] === 'SUPERUSER') {
//                $url = get_home_url() . '/super-user-home-page/';
//                echo("<script>window.location.assign('$url');</script>");
            }
        }
    }
?>

<!DOCTYPE html>
<style>
    body {
        overflow-x:hidden;
    }
    .topPart {
        height: 80px;
        width: 100%;

    }

    .middlePart {
        position: relative;
        padding:0px;
        margin: 0px !important;
        width:100%;
        height: 480px;
        background-image: url("img/background.jpg") ;

    }
    .middlePart img{width:100%;}

    .NUS_login {
        position: relative;
        margin-top: 50px;
        width: 300px;
        height: 300px;
        padding:30px;
        margin-right: 40px;
        float:right;
        background-color: white;
    }

    .NUS_authTitle {
        text-align: center;
    }

    .FPassword {
        font-size:80%;
        position: relative;
    }
    .logo {
        margin-left: 30px;
        margin-top: 10px;
        height: 100px;
        width: 150px;
        display:inline-block;
    }
    .logo img{
        width:100%;
    }

    .contact {
        padding-top: 50px;
        text-align: right;
        float: right;
        letter-spacing: 1px;
        display: inline;
    }
    .userNameColor {
        border-color:green !important;
    }
    .passWordColor {
        border-color: yellow !important;
    }
    .inner-addon {
        position: relative;
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
    .logos {
        height:40px;
        width: 40px;
        display: inline-block;
    }
    .logos img {
        width: 100%;
    }
    .copyright {
        vertical-align: middle;
        display: inline;
    }
    .bottomPart {
        position:fixed;
        bottom:0px;
        left:0;
        right:0;
        margin:0 auto;
        text-align: center;
    }

    .error-message a{
        color: red;
        font-size: 80%;
    }


    /* ----------- iPhone 5 and 5S ----------- */

    /* Portrait and Landscape */
    @media only screen
    and (min-device-width: 320px)
    and (max-device-width: 568px)
    and (-webkit-min-device-pixel-ratio: 2) {

        .NUS_login {
            position: relative;
            margin-top: 50px;
            width: 300px;
            height: 300px;
            padding:30px;
            margin: 0 auto;
            background-color: white;
        }
    }

    /* Portrait */
    @media only screen
    and (min-device-width: 320px)
    and (max-device-width: 568px)
    and (-webkit-min-device-pixel-ratio: 2)
    and (orientation: portrait) {
        .NUS_login {
            position: relative;
            margin-top: 50px;
            width: 300px;
            height: 300px;
            padding:30px;
            margin: 0 auto;
            background-color: white;
        }
    }

    /* Landscape */
    @media only screen
    and (min-device-width: 320px)
    and (max-device-width: 568px)
    and (-webkit-min-device-pixel-ratio: 2)
    and (orientation: landscape) {
        .NUS_login {
            position: relative;
            margin-top: 50px;
            width: 300px;
            height: 300px;
            padding:30px;
            margin: 0 auto;
            background-color: white;
        }
    }


</style>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="topPart row">
    <div class="logo">
        <img src="img/logo.png"/>
    </div>
    <div class="contact">
        <h6 style="display:inline;"><strong>Sales:</strong></h6><h4 style="display:inline;"><strong>416-333-1111</strong></h4> | <h5 style="display:inline;"><strong>Office:</strong></h5><h4 style="display:inline;"><strong>647-795-1188</strong></h4>
    </div>
</div>
<div class="middlePart row">

    <div class="NUS_login">
        <h4 class="NUS_authTitle">Account Login</h4>
        <form method="post">
            <div style="margin-bottom: 25px" class="inner-addon left-addon">
                <i class="glyphicon glyphicon-user"></i>
                <input id="login-username" type="email" class="form-control userNameColor" name="email" value="" placeholder="Email" required>
            </div>
            <div style="margin-bottom: 25px" class="inner-addon left-addon">
                <i class="glyphicon glyphicon-lock"></i>
                <input id="login-password" type="password" class="form-control passWordColor" name="password" value="" placeholder="Password" required>
            </div>
            <div class="checkbox">
                <label>
                    <input id="login-remember" type="checkbox" value="1">Remeber me
                </label>
            </div>
            <input type="submit" value="Login" name="login" class="btn btn-primary btn-block">
            <?php
                if($isLoginFailed){
                    echo '<div class="error-message">
                    <label>
                        <a>Email and password do not match.</a>
                    </label>
                </div>';
                }
            ?>
        </form>
        <div class="FPassword"><a href="#">Forgot password?</a></div>
    </div>

</div>
<div class="bottomPart row">
    <div class="logos">
        <img src="img/logo-s.png">
    </div>
    <p class="copyright">@copyright @2016 Darren Liu All Rights Reserved</p>
</div>
</body>