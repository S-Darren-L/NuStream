<?php

    // Start Session
    session_start();

    /*
    Template Name: Admin Create Agent Account
    */

?>

<?php
    // Set Navigation URL
    $filesURL = get_home_url() . '/admin-files-management/';
    $createSupplierURL = get_home_url() . '/admin-create-supplier';
    $createMemberURL = get_home_url() . '/admin-create-agent-account';
    $memberInfoURL = get_home_url() . '/admin-member-info';
    $supplierInfoURL = get_home_url() . '/admin-supplier-info';

    // Check Session Exist
    if(!isset($_SESSION['AccountID'])){
        redirectToLogin();
    }

    // Logout User
    if(isset($_GET['logout'])) {
        logoutUser();
    }

    $UserName = $_SESSION['FirstName'] . " " . $_SESSION['LastName'];

    // Set URL
    $homeURL = get_home_url();
    $mainPath = $homeURL . "/wp-content/themes/NuStream/";
    $logo1ImagePath = $mainPath . "img/logo1.png";

    // init Data
    $getAllAccountsResult = get_all_team_leaders();

    if($getAllAccountsResult === null)
        echo 'result is null';

    $accountsResult = [];
    while($row = mysqli_fetch_array($getAllAccountsResult))
    {
        $accountsResult[] = $row;
    }

    $selectedAccountID = null;

    // Validate Mandatory Fields
    function date_validated()
    {
        $firstName = test_input($_POST["firstName"]);
        $lastName = test_input($_POST["lastName"]);
        $contactNumber = test_input($_POST["contactNumber"]);
        $email = test_input($_POST["email"]);
        $isTeamLeader  = (int)$_POST["isTeamLeader"] == 'TRUE' ? true : false;
        $isTeamLeader = test_input($isTeamLeader);

        global $errorMessage;
        global $isError;
        if (empty($firstName) || empty($lastName) || empty($contactNumber) || empty($email) || empty($isTeamLeader)) {
            $errorMessage = "Mandatory fields are empty";
            $isError = true;
            return false;
        } else {
            $errorMessage = null;
            $isError = false;
            return true;
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Create Account
    if(isset($_POST['create_account']) && date_validated() === true) {
        // Generate Password
        $password = generate_password();
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $teamLeaderID = $_POST['teamLeaderID'];
        $contactNumber = $_POST['contactNumber'];
        $email = $_POST['email'];
        $isTeamLeader = $_POST['isTeamLeader'] == 'TRUE' ? true : false;

        // If Is Not Team Leader, Get Team ID
        if(!$isTeamLeader){
            $getTeamIDResult = get_team_id_by_team_leader($teamLeaderID);
            $teamID = mysqli_fetch_array($getTeamIDResult)['TeamID'];
        }

        // Check if account exist
        $isAccountExistResult = is_account_exist($email);
        $isAccountExistResultRow = mysqli_fetch_array($isAccountExistResult);
        if(!is_null($isAccountExistResultRow)){
            $errorMessage = "Email already exist";
            $isError = true;
        }
        else{
            $errorMessage = null;
            $isError = false;
            // Create Account
            $createAccountArray = array (
                "password" => $password,
                "firstName" => $firstName,
                "lastName" => $lastName,
                "teamID" => $teamID,
                "contactNumber" => $contactNumber,
                "email" => $email,
                "isTeamLeader" => $isTeamLeader
            );

            $createAccountResult = create_agent_account($createAccountArray);
            $result_rows = [];
            while($row = mysqli_fetch_array($createAccountResult))
            {
                $result_rows[] = $row;
            }
            $accountID = $result_rows[0]["LAST_INSERT_ID()"];

            // Send User Password By Email
            if(!is_null($accountID)){
                $sendEmailResult = send_user_password($email, $firstName, $lastName,$password);
            }

            // If Is Team Leader, Create Team
            if($isTeamLeader && !is_null($accountID)){
                $createTeamArray = array (
                    "teamName" => $firstName . " " . $lastName,
                    "teamLeaderID" => $accountID
                );

                $createTeamResult = create_team($createTeamArray);
                $result_rows = [];
                while($row = mysqli_fetch_array($createTeamResult))
                {
                    $result_rows[] = $row;
                }
                $newTeamID = $result_rows[0]["LAST_INSERT_ID()"];
            }

            // If Is Team Leader, Update Account
            if($isTeamLeader && !is_null($newTeamID) && !is_null($accountID)) {
                $updateAccountTeamIdArray = array(
                    "accountID" => $accountID,
                    "teamID" => $newTeamID
                );
                $updateAccountResult = update_account_team_id($updateAccountTeamIdArray);
            }

            // Navigate
            if(!is_null($accountID)){
                $url = get_home_url() . '/member-info';
                echo("<script>window.location.assign('$url');</script>");
            }
        }
    }
?>

<script type="text/javascript">
    var isSelectDisabled = true;
    function teamLeaderChecked(rdo) {
        isSelectDisabled = document.getElementById("drop-down").disabled = rdo.checked;
    }
    function teamMemberChecked(rdo) {
        isSelectDisabled = document.getElementById("drop-down").disabled = !rdo.checked;
    }
</script>

<!DOCTYPE html>
<style type="text/css">

    html, body {
        margin:0;
        padding:0;
    }

    #container {
        margin-left: 230px;
        _zoom: 1;
    }

    #nav {
        float: left;
        width: 230px;
        height: 100%;
        background: #32323a;
        margin-left: -230px;
        position:fixed;
    }

    #main {
        height: 400px;
    }

    /* style icon */
    .inner-addon .glyphicon {
        position: absolute;
        padding: 10px;
        pointer-events: none;
    }

    /* align icon */
    .left-addon .glyphicon {
        left: 0px;
    }

    /* add padding  */
    .left-addon input {
        padding-left: 30px;
    }

    a {
        letter-spacing: 1px;
    }

    .logo {
        height: 120px;
        width: 230px;
        padding-top: 20px;
        padding-left: 20px;
        padding-right:20px;
        padding-bottom: 20px;
        display: block;
        background-color: #28282e;
    }

    .logo img {
        width: 100%;
    }

    .nav-pills {
        background-color: #32323a;
        border-color: #030033;
    }

    .nav-pills > li > a {
        color: #95a0aa; /*Change active text color here*/
    }

    .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        color: #000;  /*Sets the text hover color on navbar*/
    }

    li {
        border-bottom:1px #2a2a31 solid;
    }

    .footer {
        position: absolute;
        bottom:0px;
        left:0;
        right:0;
        margin:0 auto;
        text-align: center;
    }

    .copyRight {
        color:white;
    }

    .formPart {
        margin-right: 40px;
        margin-left: 40px;
        padding-top: 40px;
    }

    th {
        color:white;
        font-size:11px;
        text-align:center;
    }

    .userNamePart {
        color:white;
        text-align: center;
        margin-bottom: 20px;
    }

    .title {
        padding:0px;
        margin:20px;
    }

    .title h4 {
        padding:0px;
        margin:0px;
        width: 300px;
        font-size: 20px;
        color:#616161;
        font-weight: bold;
    }

    .inputPart {
        padding-top: 30px;
        background-color: #eeeeee;
        color:#a9a9a9;
        height: 350px;
        width: 600px;
        font-size: 11px;
    }

    .requireTitle {
        width: 150px;
        padding-left: 20px;
        float:left;
        padding-top: 5px;
    }

    .inputContent {
        overflow: hidden;
        margin-bottom: 30px;
    }

    fieldset {
        overflow: hidden
    }

    .radioButtonPart {
        float: left;
        clear: none;
    }

    label {
        float: left;
        clear: none;
        display: block;
        padding: 5px 4em 0 3px;
    }

    input[type=radio],
    input.radio {
        float: left;
        clear: none;
        padding-top: 5px;
        margin: 2px 0 0 2px;
        font-size: 11px !important;
        color:#616161;
    }

    .selectTeam {
        float: left;
        clear: none;
        margin: 2px 0 0 2px;
    }

    .dropdown {
        height: 40px;
        width: 50px;
    }

    select {
        border-radius: 3px;
        height: 30px;
        width: 80px;
    }

    .create {
        float:left;
        padding-left: 20px;
        margin-left: 0px;
    }

    .createButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: 100px;
        height: 30px;
        width: 100px;
    }

    .error-message a{
        color: red;
        font-size: 100%;
    }
</style>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div id="container">
    <div id="nav">
        <div class="logo">
            <?php
            echo '<img src="' . $logo1ImagePath . '"/>';
            ?>
        </div>
        <div class="userNamePart">
            <h4 id="userName"><?php echo $UserName;?></h4>
            <h8 id="position" style="font-size:10px;"><?php echo $_SESSION['AccountPosition'];?></h8>
        </div>
        <ul class="nav nav-pills nav-stacked">
            <li><?php echo '<a href="' . $filesURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;Files</a></li>
            <li><?php echo '<a href="' . $createMemberURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-blackboard"></span>&nbsp;&nbsp;Create Member</a></li>
            <li><?php echo '<a href="' . $memberInfoURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-th-large"></span>&nbsp;&nbsp;Member Info</a></li>
            <li><?php echo '<a href="' . $createSupplierURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Create Supplier</a></li>
            <li><?php echo '<a href="' . $supplierInfoURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;Supplier Info</a></li>
            <li><a href="?logout" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
        </ul>
        <div class="footer">
            <p class="copyRight" style="font-size:10px;">@copyright @2016<br/> Darren Liu All Rights Reserved</p>
        </div>
    </div>
    <div id="main">
        <div class="formPart">
            <div class="title"><h4>CREATE NEW ACCOUNT</h4></div>
            <form method="post">
                <div class="form-group inputPart">
                    <div class="requireTitle">MEMBER NAME</div>
                    <div class="inputContent">
                        <input class="prayer-first-name" type="text" name="firstName" id="firstName" placeholder=" FIRST NAME*" style="font-size:15px;" require/>
                        <input class="prayer-email" type="text" name="lastName" id="lastNmae" placeholder=" LAST NAME*" style="font-size:15px;" require/>
                    </div>
                    <div class="requireTitle">CONTACT NUMBER*</div>
                    <div class="inputContent contactNum">
                        <input class="prayer-email" type="text" name="contactNumber" id="contactNumber" placeholder="CONTACT NUMBER*" style="font-size:15px;" size="45" require/>
                    </div>
                    <div class="requireTitle">EAMIL ADDRESS*</div>
                    <div class="inputContent contactEmail">
                        <input class="prayer-email" type="email" name="email" id="emailAddress" placeholder="EAMIL ADDRESS*" style="font-size:15px;" size="45" require/>
                    </div>
                    <div class="requireTitle">ACCOUNT TYPE*</div>
                    <div class="inputContent" >
                        <fieldset>
                            <div class="radioButtonPart">
                                <input type="radio" class="radio" name="isTeamLeader" value="TRUE" checked="checked" onclick="teamLeaderChecked(this);" id="teamLeader" style="margin-top:5px;" />
                                <label for="teamLeader" style="font-weight:100 !important; ">TEAM LEADER</label>
                                <input type="radio" class="radio" name="isTeamLeader" value="FALSE" onclick="teamMemberChecked(this);" id="teamLeader" style="margin-top:5px;" />
                                <label for="teamLeader" style="font-weight:100 !important;">TEAM MEMBER</label>
                                <div class="selectTeam">
                                    <div class="dropdown">
                                        <select name="teamLeaderID" id="drop-down" disabled="isSelectDisabled">
                                            <?php
                                            foreach ($accountsResult as $account){
                                                $accountName = $account['FirstName'] . " " . $account['LastName'];
                                                if($account['AccountID'] === $selectedAccountID){
                                                    $isSelected = "selected";
                                                }else{
                                                    $isSelected = "";
                                                }
                                                echo '<option value="' . $account['AccountID'] . '" selected="' . $isSelected . '">', $accountName, '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="create">
                        <input class="createButton" type="submit" value="Create" name="create_account">
                        <?php
                        if($isError){
                            echo '<div class="error-message"><a>';
                                global $errorMessage;
                                echo $errorMessage;
                            echo '</a></div>';
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
