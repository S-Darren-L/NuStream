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
        $firstName = $createAccountArray['firstName'];
        $lastName = $createAccountArray['lastName'];
        $teamID = $createAccountArray['teamID'];
        $accountPosition = 'AGENT';
        $contactNumber = $createAccountArray['contactNumber'];
        $email = $createAccountArray['email'];
        $isTeamLeader = $createAccountArray['isTeamLeader'];

        $sql = "INSERT INTO accounts (FirstName, LastName, TeamID, AccountPosition, ContactNumber, Email, IsTeamLeader)
                        VALUES ('$firstName', '$lastName', '$teamID', '$accountPosition', '$contactNumber', '$email', '$isTeamLeader')";
        echo $sql;

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();
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
        $firstName = $updateAccountArray['firstName'];
        $lastName = $updateAccountArray['lastName'];
        $contactNumber = $updateAccountArray['contactNumber'];
        $email = $updateAccountArray['email'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE accounts SET FirstName = '$firstName', LastName = '$lastName', ContactNumber = '$contactNumber', IsTeamLeader = '$email'
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
    function deactivate_account_request($deactivateAccountArray){
        $accountID = $deactivateAccountArray['accountID'];
        $isActivate = $deactivateAccountArray['isActivate'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "UPDATE accounts SET IsActivate = '$isActivate'
                        WHERE AccountID = '$accountID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Log in
    function login_request($loginArray){
        $email = $loginArray['email'];
        $password = $loginArray['password'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();;

        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        $password = md5($password);
        //temp
        $password="";

        $sql = "SELECT * FROM accounts WHERE Email='$email' && Password='$password' && IsActivate=TRUE LIMIT 1";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;

    }
?>