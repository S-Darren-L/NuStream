<?php
    // Start Session
    session_start();

    // Check Session Exist
    if(!isset($_SESSION['AccountID'])){
        redirectToLogin();
    }

    // Logout User
    if(isset($_GET['logout'])) {
        logoutUser();
    }

    // Set Navigation URL
    // Admin URL
    $adminFilesURL = get_home_url() . '/admin-files-management';
    $adminCreateSupplierURL = get_home_url() . '/admin-create-supplier';
    $adminCreateMemberURL = get_home_url() . '/admin-create-agent-account';
    $adminMemberInfoURL = get_home_url() . '/admin-member-info';
    $adminSupplierInfoURL = get_home_url() . '/supplier-info';
    // Agent URl
    $agentNewCaseURL = get_home_url() . '/agent-create-case';
    $agentCaseEstimationURL = get_home_url() . '/agent-case-estimation';
    $agentMyCasesURL = get_home_url() . '/agent-my-cases';
    $agentSupplierInfoURL = get_home_url() . '/supplier-info';
    $agentSettingsURL = get_home_url() . '/agent-settings';


    $UserName = $_SESSION['FirstName'] . " " . $_SESSION['LastName'];

    // Set URL
    $homeURL = get_home_url();
    $mainPath = $homeURL . "/wp-content/themes/NuStream/";
    $logo1ImagePath = $mainPath . "img/logo1.png";

    // Set Main Menu
    echo '
        <div id="nav">
            <div class="logo">
                <img src="' . $logo1ImagePath . '"/>
            </div>
            <div class="userNamePart">
                <h4 id="userName">';
                    echo $UserName;
                echo '</h4>
                <h8 id="position" style="font-size:10px;">';
                    echo $_SESSION['AccountPosition'];
                echo '</h8>
            </div>';
            if($_SESSION['AccountPosition'] === 'ADMIN'){
                // Admin Menu
                echo '<ul class="nav nav-pills nav-stacked">
                    <li><a href="' . $adminFilesURL . '" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;Files</a></li>
                    <li><a href="' . $adminCreateMemberURL . '" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-blackboard"></span>&nbsp;&nbsp;Create Member</a></li>
                    <li><a href="' . $adminMemberInfoURL . '" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-th-large"></span>&nbsp;&nbsp;Member Info</a></li>
                    <li><a href="' . $adminCreateSupplierURL . '" style="text-align:left;">&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Create Supplier</a></li>
                    <li><a href="' . $adminSupplierInfoURL . '" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;Supplier Info</a></li>
                    <li><a href="?logout" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
                </ul>';
            }else if($_SESSION['AccountPosition'] === 'AGENT'){
                // AGENT Menu
                echo '<ul class="nav nav-pills nav-stacked">
                    <li><a href="' . $agentNewCaseURL . '" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-duplicate"></span>&nbsp;&nbsp;New Listing</a></li>
                    <li><a href="' . $agentCaseEstimationURL . '" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Estimation</a></li>
                    <li><a href="' . $agentMyCasesURL . '" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-th-large"></span>&nbsp;&nbsp;My Cases</a></li>
                    <li><a href="' . $agentSupplierInfoURL . '" style="text-align:left;">&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Supplier Info</a></li>
                    <li><a href="' . $agentSettingsURL . '" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-blackboard"></span>&nbsp;&nbsp;Settings</a></li>
                    <li><a href="?logout" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
                </ul>';

            }else if($_SESSION['AccountPosition'] === 'ACCOUNTANT'){
                // ACCOUNTANT Menu

            }else if($_SESSION['AccountPosition'] === 'SUPERUSER'){
                // SUPERUSER Menu

            }else{
                // Navigate To Login
                redirectToLogin();
            }
             echo '<div class="footer">
                <p class="copyRight" style="font-size:10px;">@copyright @2016<br/> Darren Liu All Rights Reserved</p>
             </div>
        </div>
    ';

?>