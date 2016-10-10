<?php

    // Create Team
    function create_team_request($createTeamArray){
        $teamLeaderID = $createTeamArray['teamLeaderID'];

        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT FirstName, LastName FROM accounts WHERE AccountID='$teamLeaderID'";
        $result = mysqli_query($conn, $sql);
        $getAccountArray = mysqli_fetch_array($result);
        $teamLeaderName = $getAccountArray['FirstName'] . " " . $getAccountArray['LastName'];

        $sql = "INSERT INTO teams (TeamLeaderID, TeamLeaderName)
                        VALUES ('$teamLeaderID', '$teamLeaderName')";
        $result = mysqli_query($conn, $sql);

        if($result === TRUE){
            $sql = "SELECT LAST_INSERT_ID()";
            $result = mysqli_query($conn, $sql);
        }

        mysqli_close($conn);
        return $result;
    }
    //Get Team ID By Tam Leader
    function get_team_id_by_team_leader_request($teamLeaderID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT TeamID FROM teams WHERE TeamLeaderID='$teamLeaderID'";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

    // Get Team By Team ID
    function get_team_by_team_id_request($teamID){
        // Require SQL Connection
        require_once(__DIR__ . '/mysql-connect.php');
        $conn = mysqli_connection();

        $sql = "SELECT * FROM teams WHERE TeamID='$teamID' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        return $result;
    }

?>