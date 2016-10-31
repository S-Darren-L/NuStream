<?php

    // Start Session
    session_start();

    // Set Cookie Name
    $cookieName = 'userLogin';

    // Check Cookie
    if(isset($_COOKIE[$cookieName])){
        // Check If User Logged In
        if(!isset($_SESSION['AccountID'])){
            // Get Session Array From Cookie
            $sessionArray = json_decode(stripslashes($_COOKIE[$cookieName]), true);

            // Set Session
            setSession($sessionArray);
        }
        // Navigate To User Home Page
        navigateToUserHomePage();
    }
    else{
        if(isset($_SESSION['AccountID'])){
            // Navigate To User Home Page
            navigateToUserHomePage();
        }
    }

    // Set URL
    $homeURL = get_home_url();
    $mainPath = $homeURL . "/wp-content/themes/NuStream/";
    $logoImagePath = $mainPath . "img/logo.png";
    $logoSImagePath = $mainPath . "img/logo-s.png";
    $logo1ImagePath = $mainPath . "img/logo1.png";
    $userIconImagePath = $mainPath . "img/userIcon.png";
    $lockIconImagePath = $mainPath . "img/lockIcon.png";
    $backgroundImagePath = $mainPath . "img/background.jpg";
    $forgetPasswordPath = $homeURL . "/forget-password";

    if(isset($_POST['login'])) {
        $rememberMe = $_POST['remember_me'];

        $loginArray = array(
            "email" => $_POST['email'],
            "password" => $_POST['password'],
        );

        $loginResult = login($loginArray);
        $loginData = mysqli_fetch_array($loginResult);
        $isLoginFailed = is_null($loginData);
        if (!$isLoginFailed) {
            // Set Session
            setSession($loginData);

            // Set Session Array
            $sessionArray = array(
                "accountID" => $_SESSION['AccountID'],
                "firstName" => $_SESSION['FirstName'],
                "lastName" => $_SESSION['LastName'],
                "teamID" => $_SESSION['TeamID'],
                "accountPosition" => $_SESSION['AccountPosition'],
                "isTeamLeader" => $_SESSION['IsTeamLeader']
            );

            // Set Cookie If Remember User
            if ($rememberMe) {
                setLoginCookie($sessionArray);
            }
            if ($_SESSION['AccountPosition'] === 'AGENT') {
                $url = get_home_url() . '/mobile-menu';
                echo("<script>window.location.assign('$url');</script>");
            }
        }
    }

    // Set Session
    function setSession($sessionArray){
        $_SESSION['AccountID'] = $sessionArray['AccountID'];
        $_SESSION['FirstName'] = $sessionArray['FirstName'];
        $_SESSION['LastName'] = $sessionArray['LastName'];
        $_SESSION['TeamID'] = $sessionArray['TeamID'];
        $_SESSION['AccountPosition'] = $sessionArray['AccountPosition'];
        $_SESSION['IsTeamLeader'] = $sessionArray['IsTeamLeader'];
    }

    // Set Cookie
    function setLoginCookie($sessionArray){
        // Set Cookie
        global $cookieName;
        $cookieValue = json_encode($sessionArray);
        $expiry = time() + 60*60*24*180;
        $setCookieResult = setcookie($cookieName, $cookieValue, $expiry, '/', $_SERVER['SERVER_NAME'], false, false);
    }

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

<html class="gr__nustreamtoronto_com"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style type="text/css">@charset "UTF-8";[ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\:form{display:block;}.ng-animate-shim{visibility:hidden;}.ng-anchor{position:absolute;}</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUSTREAM</title>
    <!--<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/default.css">-->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/styles.css">
</head>
<body data-gr-c-s-loaded="true">
<div ng-app="App" ng-controller="myController" class="ng-scope">
    <form method="post">
    <div class='login_title'>
        <span><?php
            echo '<img src="' . $logo1ImagePath . '"/>';
            ?></span>
    </div>
    <div class='login_fields'>
        <!--<div class='login_fields__user'>-->
            <div class='userIcon'>
                <?php
                echo '<img src="' . $userIconImagePath . '"/>';
                ?>
            </div>
            <input class="userNameInput" name="email" placeholder='&nbsp;&nbsp;&nbsp;Username' type='email' style="text-indent: 40px;" />
        <!--</div>-->
        <!--<div class='login_fields__password'>-->
            <div class='passwordIcon'>
                <?php
                echo '<img src="' . $lockIconImagePath . '"/>';
                ?>
            </div>
            <input class="passwordInput" name="password" placeholder='&nbsp;&nbsp;&nbsp;Password' type='password'  style="text-indent: 15px;"/>
        <!--</div>-->
        <div class="checkbox">
            <label>
                <input id="login-remember" type="checkbox" name="remember_me" value="1" />&nbsp;&nbsp;Remember me
            </label>
        </div>
        <div class='login_fields__submit'>
            <input type='submit' name="login" value='LOGIN'/>
            <div class='forgot'>
<!--                <a href='#'>Forgot Password?</a>-->
                <?php
                if($isLoginFailed){
                    echo '<div class="error-message">
                    <label>
                        <a>Email and password do not match.</a>
                    </label>
                </div>';
                }
                ?>
            </div>
        </div>
    </div>
    </form>
</div>
</body>
<!--</html>-->
