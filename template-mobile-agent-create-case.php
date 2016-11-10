<?php

// Start Session
session_start();

/*
Template Name: Agent Mobile Create Case
*/

    // Init Date
$menuURL = get_home_url() . "/mobile-menu";
    $propertyTypes = get_property_types();
    $uploadBasePath = "wp-content/themes/NuStream/Upload/case/";
    $teamID = $_SESSION['TeamID'];
    $teamResult = mysqli_fetch_array(get_team_by_team_id($teamID));
    $teamLeaderID = $teamResult['TeamLeaderID'];
    $teamLeaderName = $teamResult['TeamLeaderName'];
    $teamMemberResult = get_all_team_members_by_team_id($teamID);
    $teamMembers = [];
    if($_SESSION['IsTeamLeader'] === '1'){
        $isCoListingDisabled = null;
        while($row = mysqli_fetch_array($teamMemberResult))
        {
            $teamMembers[] = $row;
        }
    }
    else{
        $isCoListingDisabled = 'disabled';
        $teamLeader = array (
            "AccountID" => $teamLeaderID,
            "FirstName" => $teamLeaderName,
            "LastName" => ""
        );
        array_push($teamMembers,$teamLeader);
    }

    // Validate Mandatory Fields
    function date_validated()
    {
        global $isCoListingDisabled;
        global $teamLeaderID;
        $MLSNumber = test_input($_POST['MLSNumber']);
        $propertyType = test_input($_POST['propertyType']);
        $address = test_input($_POST['address']);
        $houseSize =test_input($_POST['houseSize']);
    //        $landSize = test_input($_POST['landSize']);
        $listingPrice = test_input($_POST['listingPrice']);
    //        $coStaffID = test_input($isCoListingDisabled === true ? $teamLeaderID : $_POST['coStaffID']);
    //        $ownerName = test_input($_POST['ownerName']);
    //        $contactNumber = test_input($_POST['contactNumber']);
        $commissionRate = test_input($_POST['commissionRate']);

        global $errorMessage;
        global $isError;
        if (empty($MLSNumber) || empty($propertyType) || empty($address) || empty($houseSize) ||
            empty($listingPrice) || empty($commissionRate)) {
            $errorMessage = "Mandatory fields are empty";
            $isError = true;
            return false;
        } else {
            $errorMessage = null;
            $isError = false;
            return true;
        }
    }

    // Create Case
    if(isset($_POST['create_case']) && date_validated() === true){
        $MLS = $_POST['MLSNumber'];
        $caseImageTmp = $_FILES['case_image']['tmp_name'];
        $caseImageName = preg_replace("#[^a-z0-9.]#i", "",  time() . '_' . $_FILES['case_image']['name']);
        $uploadPath = $uploadBasePath . $MLS . "/HouseImage/";
        if(!empty($caseImageTmp)){

            if(!is_dir($uploadPath)){
                mkdir($uploadPath, 0777, true);
            }

            if (!$caseImageTmp) {
                die("No File Selected, Please Upload Again.");
            } else {
                $uploadResult = move_uploaded_file($caseImageTmp, $uploadPath . $caseImageName);
            }
        }
        if(empty($_POST['landSize']) || is_null($_POST['landSize']) || $_POST['landSize'] === ''){
            $landSize = '0';
        }else{
            $landSize = $_POST['landSize'];
        }
        $coStaffID = $isCoListingDisabled === true ? $teamLeaderID : $_POST['coStaffID'];
        if(is_null($coStaffID) || empty($coStaffID)){
            $coStaffID = $_SESSION['AccountID'];
        }
        $createCaseArray = array (
            "MLSNumber" => $_POST['MLSNumber'],
            "staffID" => $_SESSION['AccountID'],
            "coStaffID" => $coStaffID ,
            "address" => $_POST['address'],
            "landSize" => $landSize,
            "houseSize" => $_POST['houseSize'],
            "propertyType" => $_POST['propertyType'],
            "listingPrice" => $_POST['listingPrice'],
            "ownerName" => $_POST['ownerName'],
            "contactNumber" => $_POST['contactNumber'],
            "commissionRate" => $_POST['commissionRate'],
            "image" => $caseImageName);

        // Check If MLS Exist
        $isMLSExistResult = is_MLS_exist($_POST['MLSNumber']);
        $isMLSExistResultRow = mysqli_fetch_array($isMLSExistResult);
        if(!is_null($isMLSExistResultRow)){
            $errorMessage = "MLS already exist";
            $isError = true;
        }
        else{
            $result = create_case($createCaseArray);
//        $uploadFilesPath = get_home_url() . '/upload-files/?UType=Supplier&UID=' . $supplierID;
        }

    }
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NuStream 新勢力地產</title>
    <!--<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/default.css">-->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/styles.css">
</head>
<body>
<span style="color:white;">
    <?php echo '<a href="' . $menuURL . '" style="color:white;">', '<<', '</a>'; ?></span>
    <div class='newPage'>
        <div class="goBack">
        </div>
        <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
            
            <div class="newTitlePart">
                <h2>NEW LISTING</h2>
            </div>
            <div class='newInput'>
                <div class='newInputPart'>
                    <input class="newInputStyle" name="MLSNumber" id="MLSNumberInput" placeholder='MLS NUMBER *' type='text' size="30">
                    </input>
                </div>
                <div class='newInputPart'>
                    <select class="newSelectStyle" name="propertyType">
                        <?php
                        foreach ($propertyTypes as $propertyTypeItem){
                        echo '
                        <option value="' . $propertyTypeItem . '">', $propertyTypeItem, '</option>';
                        }
                        ?>
                    </select>
                    </input>
                </div>
                <div class='newInputPart'>
                    <input class="newInputStyle" name="address" id="addressInput" placeholder='ADDRESS *' type='text' size="30">
                </div>
                <div class='newInputPart'>
                    <input class="newInputStyle" name="houseSize" id="houseSizeInput" placeholder='HOUSE SIZE *' type='number' size="30">
                </div>
                <div class='newInputPart'>
                    <input class="newInputStyle" name="landSize" id="landSizeInput" placeholder='LAND SIZE ' type='number' size="30">
                </div>
                <div class='newInputPart'>
                    <input class="newInputStyle" name="listingPrice" id="listingPriceInput" placeholder='LISTING PRICE *' type='number' size="30">
                </div>
                <div class='newInputPart'>
                    <input class="newInputStyle" name="ownerName" id="owerNameInput" placeholder="OWNER'S NAME " type='text' size="30">
                </div>
                <div class='newInputPart'>
                    <input class="newInputStyle" name="contactNumber" id="contactNmuberInput" placeholder='CONTACT NUMBER ' type='text' size="30">
                </div>
                <div class="secondInput contactNumberInput">
                    <input class="newInputStyle" name="commissionRate" id="commissionRate" placeholder='SELLING LISTING RATE *' type="number" size="30" />
                </div>
                <div class='newInputPart'>
                    <?php echo $teamLeaderName;?>
                </div>
                <div class='newInputPart'>
                    <?php
                    echo '<select name="coStaffID" ' . isCoListingDisabled . '>
                        ';
                        foreach ($teamMembers as $teamMemberItem){
                        $teamMemberName = $teamMemberItem['FirstName'] . " " . $teamMemberItem['LastName'];
                        echo '
                        <option value="' . $teamMemberItem['AccountID'] . '" ' . $isSelected . '>', $teamMemberName, '</option>';
                        }
                        echo '
                    </select>';
                    ?>
                    <!-- <input class="newInputStyle" id="teamMemberInput" placeholder='TEAM MEMBER *' type='text' size="30"> -->
                </div>
                <div class="requireTitle photoUploadTitle">PHOTO UPLOAD*</div>
                <div class="inputContent ">
                    <input type="file" accept="image/*;capture=camera" value="UPLOAD" name="case_image" class="photoUploadButton">
                </div>
            </div>
            <div class="newButtonPart">
                <input class="newButton" type="submit" value="Create" name="create_case"><?php
                if($isError){
                echo '<div class="error-message">
                    <a>
                        ';
                        global $errorMessage;
                        echo $errorMessage;
                        echo '
                    </a>
                </div>';
                }
                ?>
            </div>
            </br>
            </br>
        </form>
    </div>
</body>
</html>
