<?php

    // Start Session
    session_start();

    /*
    Template Name: Home Page
    */
?>

<?php
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
    $backgroundImagePath = $mainPath . "img/background.jpg";

    if(isset($_POST['login'])){
        $rememberMe = $_POST['remember_me'];

        $loginArray = array(
            "email" => $_POST['email'],
            "password" => $_POST['password'],
        );

        $loginResult = login($loginArray);
        $loginData = mysqli_fetch_array($loginResult);
        $isLoginFailed= is_null($loginData);
        if(!$isLoginFailed) {
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
            if($rememberMe){
                setLoginCookie($sessionArray);
            }
            navigateToUserHomePage();
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
        background-image: url("<?php echo $backgroundImagePath; ?>") ;

    }
    .middlePart img{width:100%;}

    .NUS_login {
        position: relative;
        margin-top: 50px;
        width: 300px;
        height: 300px;
        padding:30px;
        margin-right: 200px;
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
        margin-left: 200px;
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
        margin-right: 200px;
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
        bottom:0px;
        left:0;
        right:0;
        margin:10px auto;
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
        <?php
            echo '<img src="' . $logoImagePath . '"/>';
        ?>
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
                    <input id="login-remember" type="checkbox" value="1" name="remember_me">Remeber me
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
        <?php
            echo '<img src="' . $logoSImagePath . '">';
        ?>
    </div>
    <p class="copyright">@copyright @2016 Darren Liu All Rights Reserved</p>
</div>
</body>