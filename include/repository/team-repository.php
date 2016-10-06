<?php

    // Get All Agent Team Member Info
    function get_all_team_member_request(){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT AccountID, FirstName, LastName, TeamID, IsTeamLeader FROM accounts WHERE Position='AGENT' AND TeamID is NULL ORDER BY FirstName";
        $result = mysqli_query($conn, $sql);

        return $result;
    }

    // Create Team
    function create_team_request($createTeamArray){
        $teamName = $createTeamArray['teamName'];
        $teamLeaderID = $createTeamArray['teamLeaderID'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT FirstName, LastName FROM accounts WHERE AccountID='$teamLeaderID'";
        $result = mysqli_query($conn, $sql);
        $getAccountArray = mysqli_fetch_array($result);
        $teamLeaderName = $getAccountArray['FirstName'] . " " . $getAccountArray['LastName'];

        $sql = "INSERT INTO teams (TeamName, TeamLeaderID, TeamLeaderName)
                        VALUES ('$teamName', '$teamLeaderID', '$teamLeaderName')";
        $result = mysqli_query($conn, $sql);

        return $result;
    }
?>