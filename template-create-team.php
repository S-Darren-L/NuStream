<?php

/*
Template Name: Create Team
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
    if(isset($_POST['create_team'])) {
        $createTeamArray = array (
            "teamName" => $_POST['teamName'],
            "teamLeaderID" => $_POST['teamLeaderID']);
//        echo "createTeamArray: " . $createTeamArray['teamName'] . " " . $createTeamArray['teamLeaderID'];
        $createTeamResult = create_team($createTeamArray);
        if($createTeamResult === true){
            $selectedAccountID = $_POST['teamLeaderID'];
        }
//        echo " result: " . var_dump($createTeamResult);
    }
?>

<div style="overflow-x:auto;">
    <form method="post">
        <table class="team-temp-table">
            <tr>
                <td class="title" colspan="1"><a>Team Name</a></td>
                <td class="content" colspan="2"><input class="input" type="text" name="teamName"></td>
            </tr>
            <tr>
                <td class="title" colspan="1"><a>Team Leader</a></td>
                <td class="content" colspan="2">
                    <?php
                        echo '<select class="drop-down" name="teamLeaderID">';
                            foreach ($accountsResult as $account){
                                $accountName = $account['FirstName'] . " " . $account['LastName'];
                                if($account['AccountID'] === $selectedAccountID){
                                    $isSelected = "selected";
                                }else{
                                    $isSelected = "";
                                }
                                echo '<option value="' . $account['AccountID'] . '" selected="' . $isSelected . '">', $accountName, '</option>';
                            }
                        echo '</select>';
                    ?>
                </td>
            </tr>
        </table>
        <input type="submit" value="Create" name="create_team">
    </form>
</div>

<?php
get_footer();

?>
