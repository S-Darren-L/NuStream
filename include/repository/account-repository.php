<?php

    // Get All Agent Team Member Info
    function get_all_team_leaders_request(){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT AccountID, FirstName, LastName, TeamID, IsTeamLeader FROM accounts WHERE AccountPosition='AGENT' AND IsTeamLeader=TRUE AND IsActivate=TRUE ORDER BY FirstName";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Create Account
    function create_agent_account_request($createAccountArray){
        $password = $createAccountArray['password'];
        $firstName = $createAccountArray['firstName'];
        $lastName = $createAccountArray['lastName'];
        $teamID = $createAccountArray['teamID'];
        $accountPosition = 'AGENT';
        $contactNumber = $createAccountArray['contactNumber'];
        $email = $createAccountArray['email'];
        $isTeamLeader = $createAccountArray['isTeamLeader'];
        $isTeamLeader = (int)$isTeamLeader;

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $password = encrypt_password($conn, $password);

        $sql = "INSERT INTO accounts (Password, FirstName, LastName, TeamID, AccountPosition, ContactNumber, Email, IsTeamLeader)
                        VALUES ('$password', '$firstName', '$lastName', '$teamID', '$accountPosition', '$contactNumber', '$email', '$isTeamLeader')";

        $result = mysqli_query($conn, $sql);

        if($result === TRUE){
            $sql = "SELECT LAST_INSERT_ID()";
            $result = mysqli_query($conn, $sql);
        }

        mysqli_close($conn);
        return $result;
    }

    // Update Account Team ID
    function update_account_team_id_request($updateAccountTeamIdArray){
        $accountID = $updateAccountTeamIdArray['accountID'];
        $teamID = $updateAccountTeamIdArray['teamID'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE accounts SET TeamID = '$teamID'
                        WHERE AccountID = '$accountID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Update Account
    function update_account_request($updateAccountArray){
        $accountID = $updateAccountArray['accountID'];
        $contactNumber = $updateAccountArray['contactNumber'];
        $email = $updateAccountArray['email'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE accounts SET ContactNumber = '$contactNumber', IsTeamLeader = '$email'
                        WHERE AccountID = '$accountID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Get Agent Account
    function get_agent_account_request($accountID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT * FROM accounts WHERE AccountID='$accountID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Deactivate Account
    function deactivate_account_by_id_request($accountID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE accounts SET IsActivate = FALSE 
                        WHERE AccountID = '$accountID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Log in
    function login_request($loginArray){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $email = encrypt_email($conn, $loginArray['email']);
        $password = encrypt_password($conn, $loginArray['password']);

        $sql = "SELECT * FROM accounts WHERE Email='$email' && Password='$password' && IsActivate=TRUE LIMIT 1";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Check if account exist
    function is_account_exist_request($email){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $email = encrypt_email($conn, $email);

        $sql = "SELECT * FROM accounts WHERE Email='$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Get All Member Brief Info
    function get_agent_member_brief_info_request($orderVariable){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT AccountID, FirstName, LastName, TeamID, ContactNumber, Email FROM accounts WHERE AccountPosition='AGENT' AND IsActivate=TRUE ORDER BY '$orderVariable'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Get All Team Members By Team ID
    function get_all_team_members_by_team_id_request($teamID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT AccountID, FirstName, LastName FROM accounts WHERE TeamID='$teamID' AND IsActivate=TRUE AND IsTeamLeader=FALSE AND AccountPosition='AGENT' ";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
    }
?>