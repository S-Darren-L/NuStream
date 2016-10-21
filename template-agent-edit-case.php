<?php

// Start Session
session_start();

/*
Template Name: Agent Edit Case
*/

    // Get Case ID
    $MLS = $_GET['CID'];

    // Init Date
    init_data($MLS);
    $propertyTypes = get_property_types();
    $teamID = $_SESSION['TeamID'];
    $staffID = $_SESSION['AccountID'];
    $teamResult = mysqli_fetch_array(get_team_by_team_id($teamID));
    $teamLeaderID = $teamResult['TeamLeaderID'];
    $teamLeaderName = $teamResult['TeamLeaderName'];
    $teamMemberResult = get_all_team_members_by_team_id($teamID);
    $teamMembers = [];
    if($_SESSION['IsTeamLeader'] === true){
        $isCoListingDisabled = false;
        while($row = mysqli_fetch_array($teamMemberResult))
        {
            $teamMembers[] = $row;
        }
    }
    else{
        $isCoListingDisabled = true;
        $teamLeader = array (
            "AccountID" => $teamLeaderID,
            "FirstName" => $teamLeaderName,
            "LastName" => ""
        );
        array_push($teamMembers,$teamLeader);
    }

    function init_data($MLS){
        $getCaseResult = get_case_by_id($MLS);
        if($getCaseResult !== null){
            $getCaseArray = mysqli_fetch_array($getCaseResult);
            global $coStaffID;
            global $address;
            global $landSize;
            global $houseSize;
            global $propertyType;
            global $listingPrice;
            global $ownerName;
            global $contactNumber;
            global $commissionRate;

            $coStaffID = $getCaseArray['CoStaffID'];
            $address = $getCaseArray['Address'];
            $landSize = $getCaseArray['LandSize'];
            $houseSize = $getCaseArray['HouseSize'];
            $propertyType = $getCaseArray['PropertyType'];
            $listingPrice = $getCaseArray['ListingPrice'];
            $ownerName = $getCaseArray['OwnerName'];
            $contactNumber = $getCaseArray['ContactNumber'];
            $commissionRate = $getCaseArray['CommissionRate'];
        }
        else{
            echo die("Cannot find account");
        }
    }

    // Validate Mandatory Fields
    function date_validated()
    {
        $coStaffID = test_input($_POST['coStaffID']);
        $address = test_input($_POST['address']);
        $landSize = test_input($_POST['landSize']);
        $houseSize = test_input($_POST['houseSize']);
        $propertyType = test_input($_POST['propertyType']);
        $listingPrice = test_input($_POST['listingPrice']);
        $ownerName = test_input($_POST['ownerName']);
        $contactNumber = test_input($_POST['contactNumber']);
        $commissionRate = test_input($_POST['commissionRate']);

        global $errorMessage;
        global $isError;
        if ((empty($coStaffID) && $_SESSION['IsTeamLeader'] === true) || empty($address) || empty($landSize) || empty($houseSize) || empty($propertyType) || empty($listingPrice) || empty($ownerName) || empty($contactNumber) || empty($commissionRate)) {
            $errorMessage = "Mandatory fields are empty";
            $isError = true;
            return false;
        } else {
            $errorMessage = null;
            $isError = false;
            return true;
        }
    }

    // Update Case
    if(isset($_POST['update_case']) && date_validated() === true) {
        $updateCaseArray = array(
            "MLS" => $MLS,
            "staffID" => $staffID,
            "coStaffID" => $_POST['coStaffID'],
            "address" => $_POST['address'],
            "landSize" => $_POST['landSize'],
            "houseSize" => $_POST['houseSize'],
            "propertyType" => $_POST['propertyType'],
            "listingPrice" => $_POST['listingPrice'],
            "ownerName" => $_POST['ownerName'],
            "contactNumber" => $_POST['contactNumber'],
            "commissionRate" => $_POST['commissionRate']
        );
        $updateCaseResult = update_case($updateCaseArray);
        if($updateCaseResult === true){
            init_data($MLS);
        }
    }

    // Navigate Back
    if(isset($_POST['navigate_back'])){
        navigate_back();
    }

    function navigate_back(){
        global $adminMemberInfoURL;
        echo("<script>window.location.assign('$adminMemberInfoURL');</script>");
    }

?>

<!DOCTYPE html>
<style type="text/css">

    html, body {
        margin:0;
        padding:0;
    }

    #container {
        margin-left: 230px;
        _zoom: 1;
    }

    #nav {
        float: left;
        width: 230px;
        height: 100%;
        background: #32323a;
        margin-left: -230px;
        position:fixed;
    }

    #main {
        height: 400px;
    }

    /* style icon */
    .inner-addon .glyphicon {
        position: absolute;
        padding: 10px;
        pointer-events: none;
    }

    /* align icon */
    .left-addon .glyphicon {
        left: 0px;
    }

    /* add padding  */
    .left-addon input {
        padding-left: 30px;
    }

    a {
        letter-spacing: 1px;
    }

    .logo {
        height: 120px;
        width: 230px;
        padding-top: 20px;
        padding-left: 20px;
        padding-right:20px;
        padding-bottom: 20px;
        display: block;
        background-color: #28282e;
    }

    .logo img {
        width: 100%;
    }

    .nav-pills {
        background-color: #32323a;
        border-color: #030033;
    }

    .nav-pills > li > a {
        color: #95a0aa; /*Change active text color here*/
    }

    .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        color: #000;  /*Sets the text hover color on navbar*/
    }

    li {
        border-bottom:1px #2a2a31 solid;
    }

    .footer {
        position: absolute;
        bottom:0px;
        left:0;
        right:0;
        margin:0 auto;
        text-align: center;
    }

    .copyRight {
        color:white;
    }

    .formPart {
        margin-right: 40px;
        margin-left: 40px;
        padding-top: 40px;
    }

    th {
        color:white;
        font-size:11px;
        text-align:center;
    }

    .userNamePart {
        color:white;
        text-align: center;
        margin-bottom: 20px;
    }

    .title {
        padding:0px;
        margin:20px;
    }

    .title h4 {
        padding:0px;
        margin:0px;
        width: 300px;
        font-size: 20px;
        color:#616161;
        font-weight: bold;
    }

    .inputPart {
        padding-top: 30px;
        background-color: #eeeeee;
        color:#a9a9a9;
        height: 450px;
        width: 600px;
        font-size: 11px;
    }

    .requireTitle {
        width: 150px;
        padding-left: 20px;
        float:left;
        padding-top: 5px;
    }

    .inputContent {
        overflow: hidden;
        margin-bottom: 30px;
    }

    fieldset {
        overflow: hidden
    }

    .selectTeam {
        float: left;
        clear: none;
        margin: 2px 0 0 2px;
    }

    .dropdown {
        height: 40px;
        width: 50px;
    }

    select {
        border-radius: 3px;
        height: 30px;
        width: 80px;
    }

    .create {
        float:left;
        padding-left: 20px;
        margin-left: -20px;

    }

    .createButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: 100px;
        height: 30px;
        width: 100px;
    }

    .propertyTypeTitle {
        margin-top: -60px;
        margin-left: 290px;
    }

    .selectPropertyType {
        margin-top:-60px;
        margin-left: 430px;
    }

    .selectPropertyType select {
        border-radius: 3px;
        height: 30px;
        width: 120px;
    }

    .addressInput {
        margin-top:17px;
        margin-left: 150px;
    }

    .landSizeTitle {
        margin-top: -60px;
        margin-left: 290px;
    }

    .landSizeInput {
        margin-top:-60px;
        margin-left: 400px;

    }

    .coListingTitle {
        margin-top: -60px;
        margin-left: 290px;
    }

    .selectTeam {
        margin-top:-60px;
        margin-left: 420px;
    }

    .selectTeam select {
        border-radius: 3px;
        height: 30px;
        width: 130px;
    }

    .selectTeamMember {
        margin-top:-60px;
        margin-left: 420px;
    }

    .selectTeamMember select {
        border-radius: 3px;
        height: 30px;
        width: 130px;
    }

    .contactNumberTitle {
        font-size: 11px;
        color:#a9a9a9;
        margin-top: 20px;
    }

    .contactNumberInput {
        margin-top: 20px;
    }

    .photoUploadTitle {
        font-size: 11px;
        color:#a9a9a9;
    }

    .photoUploadButton {
        font-size: 11px;
        color:#a9a9a9;
        background-color: #fff;
        border:1px #a9a9a9 solid;
        width: 135px;
        height: 30px;
        border-radius: 3px;
    }

    .deleteButton {
        border-radius: 5px;
        background-color: #32323a;
        border: #32323a;
        color:#fff;
        font-weight: 100px;
        height: 30px;
        width: 100px;
    }

    .error-message a{
        color: red;
        font-size: 80%;
    }
</style>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div id="container">
    <?php
        include_once(__DIR__ . '/navigation.php');
    ?>
    <div id="main">
        <div class="formPart">
            <div class="title"><h4>EDIT LISTING</h4></div>
            <form method="post">
                <div class="form-group inputPart">
                    <div class="requireTitle mlsNumberTitle">MLS NUMBER* </div>
                    <div class="inputContent">
                        <input type="text" name="MLSNumber" value="<?php echo $MLS; ?>" id="MLSNumber" placeholder="MLS NUMBER*" style="font-size:11px; height:30px;" size="20" require/>
                    </div>
                    <div class="requireTitle propertyTypeTitle">PROPERTY TYPE*</div>
                    <div class="selectPropertyType">
                        <div class="dropdown">
                            <select name="propertyType">
                                <?php
                                foreach ($propertyTypes as $propertyTypeItem){
                                    global $propertyType;
                                    $isSelected = $propertyTypeItem === $propertyType ? 'selected' : null;
                                    echo '<option value="' . $propertyTypeItem . '" ' . $isSelected . '>', $propertyTypeItem, '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="requireTitle addressTitle">ADDRESS*</div>
                    <div class="inputContent addressInput">
                        <input type="text" name="address" value="<?php echo $address; ?>" id="address" placeholder="ADDRESS*" style="font-size:11px; height:30px;" size="70" require/>
                    </div>
                    <div class="requireTitle houseSizeTitle">HOUSE SIZE*</div>
                    <div class="inputContent houseSizeInput">
                        <input type="number" step="any" name="houseSize" value="<?php echo $houseSize; ?>" id="houseSize" placeholder="HOUSE SIZE*" style="font-size:11px; height:30px;" size="20" require/>
                    </div>
                    <div class="requireTitle landSizeTitle">LAND SIZE*</div>
                    <div class="inputContent landSizeInput">
                        <input type="number" step="any" name="landSize" value="<?php echo $landSize; ?>" id="landSize" placeholder="LAND SIZE*" style="font-size:11px; height:30px;" size="23" require/>
                    </div>
                    <div class="requireTitle listingPriceTitle">LISTING PRICE*</div>
                    <div class="inputContent listingPriceInput">
                        <input type="number" step="any" name="listingPrice" value="<?php echo $listingPrice; ?>" id="listingPrice" placeholder="LISTING PRICE*" style="font-size:11px; height:30px;" size="20" require/>
                    </div>
                    <div class="requireTitle coListingTitle">CO-LISTING*</div>
                    <div class="selectTeam">
                        <a style="font-size:11px; height:30px;" size="20" require><?php echo $teamLeaderName;?></a>
                    </div>
                    <div class="requireTitle owenweNameTitle">OWNER'S NAME*</div>
                    <div class="inputContent owenweNameInput">
                        <input type="text" name="ownerName" value="<?php echo $ownerName; ?>"id="ownerName" placeholder="OWNER'S NAME*" style="font-size:11px; height:30px;" size="20" require/>
                    </div>
                    <div class="selectTeamMember">
                        <div class="dropdown" >
                            <?php
                            echo '<select name="coStaffID" disabled="' . (int)$isCoListingDisabled . '">';
                            foreach ($teamMembers as $teamMemberItem){
                                global $coStaffID;
                                $isSelected = $teamMemberItem['AccountID'] === $coStaffID ? 'selected' : null;
                                $teamMemberName = $teamMemberItem['FirstName'] . " " . $teamMemberItem['LastName'];
                                echo '<option value="' . $teamMemberItem['AccountID'] . '" ' . $isSelected . '>', $teamMemberName, '</option>';
                            }
                            echo '</select>';
                            ?>
                        </div>
                    </div>
                    <div class="requireTitle contactNumberTitle">CONTACT NUMBER*</div>
                    <div class="inputContent contactNumberInput">
                        <input type="text" name="contactNumber" value="<?php echo $contactNumber; ?>" id="contactNumber" placeholder="CONTACT NUMBER*" style="font-size:11px; height:30px;" size="20" require/>
                    </div>
                    <div class="requireTitle contactNumberTitle">COMMISSION RATE*</div>
                    <div class="inputContent contactNumberInput">
                        <input type="number" step="any" value="<?php echo $commissionRate; ?>" name="commissionRate" id="commissionRate" placeholder="COMMISSION RATE*" style="font-size:11px; height:30px;" size="20" require/>
                    </div>
<!--                    <div class="requireTitle photoUploadTitle">PHOTO UPLOAD*</div>-->
<!--                    <div class="inputContent ">-->
<!--                        <button class="photoUploadButton">UPLOAD</button>-->
<!--                    </div>-->
                </div>
                <div class="create">
                    <input class="createButton" type="submit" value="Update" name="update_case">
                    <?php
                    if($isError){
                        echo '<div class="error-message"><a>';
                        global $errorMessage;
                        echo $errorMessage;
                        echo '</a></div>';
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>
</body>