<?php

    // Start Session
    session_start();

    /*
    Template Name: Home Page
    */

    //Demo
    require_once 'Mobile-Detect/Mobile_Detect.php';
    $detect = new Mobile_Detect;

    // Web
    if( !$detect->isMobile() && !$detect->isTablet() ){
        require_once 'template-web-login.php';
    }else{
        require_once 'template-mobile-login.php';
    }
?>

