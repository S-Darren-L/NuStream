<?php

    // Start Session
    session_start();

    /*
    Template Name: Admin Create Agent Account
    */


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
                $url = get_home_url() . '/admin-member-info';
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
            <div class="title"><p class="titleSize">CREATE NEW ACCOUNT</div>
            <form method="post">
                <div class="form-group CMAInputPart">
                    <div class="CMAOneLineDiv">
                        <div class="requireTitle ">FIRST NAME *</br>
                            <input  type="text" name="firstName" id="firstName" class="CMAInput" require/></div>
                        <div class="requireTitle secondTitle">LAST NAME *</br>
                        <input class="CMAInput" type="text" name="lastName" id="lastNmae" require/></div>
                    </div>
                    <div class="CMAOneLineDiv">
                        <div class="requireTitle">CONTACT NUMBER*</br>
                            <input class="CMAInput" type="text" name="contactNumber" id="contactNumber" require/></div>
                        <div class="requireTitle secondTitle">EAMIL ADDRESS*</br>
                            <input class="CMAInput" type="email" name="email" id="emailAddress" require/></div>
                    </div>
                    <div class="CMAOneLineDiv">
                        <div class="requireTitle ">TEAM INFO*</br>
                            <input type="radio" name="isTeamLeader" value="TRUE" checked="checked" onclick="teamLeaderChecked(this);" id="teamLeader"  class="CMARadioButton"/>TEAM LEADER&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="isTeamLeader" value="FALSE" onclick="teamMemberChecked(this);" id="teamLeader" class="CMARadioButton"/>TEAM MEMBER
                            <div class="CMASelectPart">
                                <select name="teamLeaderID" id="drop-down" disabled="isSelectDisabled" class="CMASelect">
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
                    <div class="CMACreate">
                        <input class="CMACreateButton" type="submit" value="Create" name="create_account">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

