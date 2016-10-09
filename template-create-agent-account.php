<?php

    // Start Session
    session_start();

    /*
    Template Name: Create Agent Account
    */

    get_header();
?>

<?php
    $getAllAccountsResult = get_all_team_leaders();

    if($getAllAccountsResult === null)
        echo 'result is null';

    $accountsResult = [];
    while($row = mysqli_fetch_array($getAllAccountsResult))
    {
        $accountsResult[] = $row;
    }

    $selectedAccountID = null;

    // Create Team
    if(isset($_POST['create_account'])) {
        $isTeamLeader = $_POST['isTeamLeader'] == 'TRUE' ? true : false;
        $teamLeaderID = $_POST['teamLeaderID'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];

        // If Is Not Team Leader, Get Team ID
        if(!$isTeamLeader){
            $getTeamIDResult = get_team_id_by_team_leader($teamLeaderID);
            $teamID = mysqli_fetch_array($getTeamIDResult)['TeamID'];
        }

        // Create Account
        $createAccountArray = array (
            "firstName" => $firstName,
            "lastName" => $lastName,
            "teamID" => $teamID,
            "contactNumber" => $_POST['contactNumber'],
            "email" => $_POST['email'],
            "isTeamLeader" => $isTeamLeader
        );

        $createAccountResult = create_agent_account($createAccountArray);
        $result_rows = [];
        while($row = mysqli_fetch_array($createAccountResult))
        {
            $result_rows[] = $row;
        }
        $accountID = $result_rows[0]["LAST_INSERT_ID()"];

        // If Is Team Leader, Create Team
        if($isTeamLeader && $accountID !== null){
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
        if($isTeamLeader && $newTeamID !== null && $accountID !== null) {
            $updateAccountTeamIdArray = array(
                "accountID" => $accountID,
                "teamID" => $newTeamID
            );
            $updateAccountResult = update_account_team_id($updateAccountTeamIdArray);
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

<div style="overflow-x:auto;">
    <form method="post">
        <table class="account-temp-table">
            <tr>
                <td class="title" colspan="2"><a>First Name</a></td>
                <td class="content" colspan="4"><input class="input" type="text" name="firstName"></td>
                <td class="title" colspan="2"><a>Last Name</a></td>
                <td class="content" colspan="4"><input class="input" type="text" name="lastName"></td>
            </tr>
            <tr>
                <td class="title" colspan="2"><a>Account Type</a></td>
                <td class="title" colspan="2"><a>Team Leader</a></td>
                <td class="radio" colspan="1">
                    <input type="radio" name="isTeamLeader" value="TRUE" onclick="teamLeaderChecked(this);"/>
                </td>
                <td class="title" colspan="2"><a>Team Member</a></td>
                <td class="radio" colspan="1">
                    <input type="radio" name="isTeamLeader" value="FALSE" onclick="teamMemberChecked(this);"/>
                </td>
                <td class="title" colspan="2"><a>Team</a></td>
                <td class="content" colspan="2">
                    <select class="drop-down" name="teamLeaderID" id="drop-down" disabled="isSelectDisabled">
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
                </td>
            </tr>
            <tr>
                <td class="title" colspan="2"><a>Contact Number</a></td>
                <td class="content" colspan="10"><input class="input" type="text" name="contactNumber"></td>
            </tr>
            <tr>
                <td class="title" colspan="2"><a>Email</a></td>
                <td class="content" colspan="10"><input class="input" type="text" name="email"></td>
            </tr>
        </table>
        <input type="submit" value="Create" name="create_account">
    </form>
</div>

<?php
get_footer();

?>
