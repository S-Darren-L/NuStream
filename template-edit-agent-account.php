<?php

    // Start Session
    session_start();

    /*
    Template Name: Edit Agent Account
    */

    get_header();
?>

<?php
//temp, should get account id from session
    $accountID = '19';
    // Init Date
    init_date($accountID);

    // Init Date
    function init_date($accountID){
        $getAgentAccountResult = get_agent_account($accountID);
        if($getAgentAccountResult !== null){
            $getAgentAccountArray = mysqli_fetch_array($getAgentAccountResult);
            global $accountID;
            global $firstName;
            global $lastName;
            global $contactNumber;
            global $email;

            $accountID = $getAgentAccountArray['AccountID'];
            $firstName = $getAgentAccountArray['FirstName'];
            $lastName = $getAgentAccountArray['LastName'];
            $contactNumber = $getAgentAccountArray['ContactNumber'];
            $email = $getAgentAccountArray['Email'];
        }
        else{
            echo die("Cannot find account");
        }
    }

    // Update Team
    if(isset($_POST['update_account'])) {
        $updateAccountArray = array(
            "accountID" => $accountID,
            "firstName" => $_POST['firstName'],
            "lastName" => $_POST['lastName'],
            "contactNumber" => $_POST['contactNumber'],
            "email" => $_POST['email']
        );
        $updateAccountResult = update_account($updateAccountArray);
        if($updateAccountResult === true){
            init_date($accountID);
        }
    }

?>

<div style="overflow-x:auto;">
    <form method="post">
        <table class="account-temp-table">
            <tr>
                <td class="title" colspan="2"><a>First Name</a></td>
                <td class="content" colspan="4"><input class="input" type="text" name="firstName" value="<?php echo $firstName; ?>"></td>
                <td class="title" colspan="2"><a>Last Name</a></td>
                <td class="content" colspan="4"><input class="input" type="text" name="lastName" value="<?php  echo $lastName; ?>"></td>
            </tr>
            <tr>
                <td class="title" colspan="2"><a>Contact Number</a></td>
                <td class="content" colspan="10"><input class="input" type="text" name="contactNumber" value="<?php echo $contactNumber; ?>"></td>
            </tr>
            <tr>
                <td class="title" colspan="2"><a>Email</a></td>
                <td class="content" colspan="10"><input class="input" type="text" name="email" value="<?php echo $email; ?>"></td>
            </tr>
        </table>
        <input type="submit" value="Update" name="update_account">
    </form>
</div>

<?php
get_footer();

?>
