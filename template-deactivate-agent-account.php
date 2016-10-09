<?php

    // Start Session
    session_start();

    /*
    Template Name: Deactivate Agent Account
    */

    get_header();
?>

<?php
//temp, should get account id from session
    $accountID = '3';
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
    if(isset($_POST['deactivate_account'])) {
        $deactivateAccountArray = array(
            "accountID" => $accountID,
            "isActivate" => false,
        );
        $deactivateAccountResult = deactivate_account($deactivateAccountArray);
        if($deactivateAccountResult === true){
            // Todo, pop back
//            echo $_SERVER['HTTP_REFERER'];
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
        <input type="submit" value="Deactivate" name="deactivate_account">
    </form>
</div>

<?php
get_footer();

?>
