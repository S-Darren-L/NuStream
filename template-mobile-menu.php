<?php

// Start Session
session_start();

/*
Template Name: Mobile Menu
*/

$homeURL = get_home_url();
$mainPath = $homeURL . "/wp-content/themes/NuStream/";
$settingIconImagePath = $mainPath . "img/Settings-50.png";
$listingIconImagePath = $mainPath . "img/Copy-50.png";
$infoCenterIconImagePath = $mainPath . "img/Open Folder-50.png";
$mycaseIconImagePath = $mainPath . "img/Briefcase-50.png";
$estimationImagePath = $mainPath . "img/Pencil-50.png";
$logo1ImagePath = $mainPath . "img/logo.png";
$logOutIconImagePath = $mainPath . "img/Exit-52.png";

$UserName = $_SESSION['FirstName'] . " " . $_SESSION['LastName'];


$settingURL = get_home_url() . "/mobile-settings";
$newCaseURL = get_home_url() . "/agent-mobile-create-case";
$infoCenterCenterURL = get_home_url() . "/agent-mobile-supplier-info";
$myCaseURL = get_home_url() . "/agent-mobile-my-cases";
$estimationURL = get_home_url() . "/agent-mobile-case-estimation";

?>
<html class="gr__nustreamtoronto_com">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        @charset "UTF-8";

        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak, .ng-hide:not(.ng-hide-animate) {
            display: none !important;
        }

        ng\:form {
            display: block;
        }

        .ng-animate-shim {
            visibility: hidden;
        }

        .ng-anchor {
            position: absolute;
        }
    </style>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>NuStream 新勢力地產</title>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/styles.css">
        <style>
            .menu_fields td:hover {
                background: #006ac0;
                cursor: pointer;
            }

            a:link {
                color: #95a0aa;
                text-decoration: none;
            }

            a:visited {
                color: #95a0aa;
                text-decoration: none;
            }

            a:hover {
                color: #95a0aa;
                text-decoration: none;
            }

            a:active {
                color: #95a0aa;
                text-decoration: none;
            }
        </style>
    </head>
    <body data-gr-c-s-loaded="true">
        <div ng-app="App" ng-controller="myController" class="ng-scope">
            <div class='menu_setting'>
                <div class='mainPageSettingIconPart'>
                    <?php
                    echo '<img src="' . $settingIconImagePath . '" />';
                    ?>
                </div>
                <div class="mainPageSettingContentPart">
                    <h6 style="margin:0px;">
                        <?php
                        echo '<a href="' .$settingURL . '">&nbsp;&nbsp;Settings</a>';
                        ?>
                    </h6>
                </div>
                <div class="logOutIconPart">
                    <?php
                    echo '<img src="' . $logOutIconImagePath . '" />';
                    ?>
                </div>
                <div class="logOutContentPart">
                    <h6>
                        <?php
                        echo '<a href="#">&nbsp;&nbsp;Log Out</a>';
                        ?>
                    </h6>
                </div>
            </div>
            <div class='menu_user_name'>
                <p class="menuUserName">
                    <?php echo $UserName;?>
                </p>
                <p class="menuUserPosition"><?php echo $_SESSION['AccountPosition']; ?></p>
            </div>
            <div class='menu_fields'>
                <table>
                    <tr>
                        <td class="tableOne">
                            <?php
                            echo '<img src="' . $listingIconImagePath . '" />';
                            ?>
                            <p class="menuFiledContent">
                                <?php
                                echo '<a href="' .$newCaseURL . '">New Listing</a>';
                                ?>
                            </p>
                        </td>
                        <td class="tableTwo">
                            <?php
                            echo '<img src="' . $infoCenterIconImagePath . '" />';
                            ?><p class="menuFiledContent">
                                <?php
                                echo '<a href="' .$infoCenterCenterURL . '">Info Center</a>';
                                ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="tableThree">
                            <?php
                            echo '<img src="' . $mycaseIconImagePath . '" />';
                            ?><p class="menuFiledContent">
                                <?php
                                echo '<a href="' .$myCaseURL . '">My Cases</a>';
                                ?>
                            </p>
                        </td>
                        <td class="tableFour">
                            <?php
                            echo '<img src="' . $estimationImagePath . '" />';
                            ?><p class="menuFiledContent">
                                <?php
                                echo '<a href="' .$estimationURL . '">Estimation</a>';
                                ?>
                            </p>
                        </td>
                    </tr>
                </table>
                <div class="logo_bottom">
                    <?php
                    echo '<img src="' . $logo1ImagePath . '" />';
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
