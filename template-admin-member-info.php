<?php

// Start Session
session_start();

/*
Template Name: Admin Member Info
*/

    // Init Data
    $orderVariable = 'FirstName';
    $member_info_result_rows = [];
    $member_info_result_rows = get_member_info_table($orderVariable);
    $pagePath = get_home_url() . 'admin-member-info';

    // Get All Member Brief Info
    function get_member_info_table($orderVariable){
        $result = get_agent_member_brief_info($orderVariable);
        if($result === null)
            echo 'result is null';
        while($row = mysqli_fetch_array($result))
        {
            $result_rows[] = $row;
        }
        for($i = 0; $i < count($result_rows); $i++){
            $teamResult = mysqli_fetch_array(get_team_by_team_id($result_rows[$i]['TeamID']));
            $result_rows[$i]['TeamLeaderName'] = $teamResult['TeamLeaderName'];
        }
        return $result_rows;
    }

    // Deactivate Account
    if(isset($_POST['deactivate_account'])){
        $accountID = $_POST['accountID'];
        $deactivateResult = deactivate_account_by_id($accountID);
        header("Refresh:0");
    }

?>

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
            <div class="MIATitle">
           <p class="titleSize">FILES</p>
            </div>
            <?php
                echo '<table class="MIATable">';
                    // Table Head
                    echo '<thead>';
                        echo '<tr>';
                            echo '<th class="MIATableHeader MIATableFirstLine">';
                                echo '<a href="#" ng-click="orderByField()"; reverseSort = !reverseSort">MEMBER NAME <span ng-show="orderByField()"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>';
                            echo '</th>';
                            echo '<th  class="MIATableHeader">';
                                echo '<a href="#" ng-click="orderByField()"; reverseSort = !reverseSort">TEAM LEAD <span ng-show="orderByField()"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>';
                            echo '</th>';
                            echo '<th  class="MIATableHeader">';
                                echo '<a href="#" ng-click="orderByField()"; reverseSort = !reverseSort">CONTACT NUMBER <span ng-show="orderByField()"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>';
                            echo '</th>';
                            echo '<th class="MIATableHeader MIATableHeaderLarge">';
                                echo '<a href="#" ng-click="orderByField()"; reverseSort = !reverseSort">EMAIL <span ng-show="orderByField()"><span ng-show="!reverseSort"><div class="arrow-up"></div></span><span ng-show="reverseSort"><div class="arrow-down"></div></span></span></a>';
                            echo '</th>';
                            echo '<th class="MIATableHeader">';
                                echo '<a href="#">DEACTIVE </a>';
                            echo '</th>';
                        echo '</tr>';
                    echo '</thead>';
                    // Table Body
                    echo '<tbody id="tbody">';
                        for($i = 0; $i < count($member_info_result_rows); $i++) {
                            $accountID = $member_info_result_rows[$i]["AccountID"];
                                echo '<tr ng-repeat="info in data.infoAdmin|orderBy:orderByField:reverseSort">';
                                    echo '<td class="MIATableFirstLine">', '<a href="' . $homeURL . '/admin-edit-agent-account/?AID=' . $accountID . '" />', $member_info_result_rows[$i]["FirstName"] . " " . $member_info_result_rows[$i]["LastName"], '</td>';
                                    echo '<td>', $member_info_result_rows[$i]["TeamLeaderName"], '</td>';
                                    echo '<td>', $member_info_result_rows[$i]["ContactNumber"], '</td>';
                                    echo '<td>', $member_info_result_rows[$i]["Email"], '</td>';
                                    echo '<td  class="MIADective">';
                                        echo '<form method="post">';
                                            echo '<input type="text" hidden="hidden" name="accountID" value="' . $accountID . '">';
                                            echo '<input type="submit" value="Deactivate" name="deactivate_account">';
                                        echo '</form>';
                                    echo '</td>';
                                echo '</tr>';
                        }
                    echo '</tbody>';
                echo '</table>';
            ?>
            <div class="MIAPageNum"><a href="#">BACK</a>&nbsp;&nbsp;&nbsp;<a href="#">NEXT</a></div>
        </div>
    </div>
</div>
<script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>