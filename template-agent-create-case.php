<?php

// Start Session
session_start();

/*
Template Name: Agent Create Case
*/

    // Init Date
    $propertyTypes = get_property_types();
    $uploadBasePath = "wp-content/themes/NuStream/Upload/case/";
    $teamID = $_SESSION['TeamID'];
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
        echo var_dump($teamMembers);
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

    // Validate Mandatory Fields
    function date_validated()
    {
        global $isCoListingDisabled;
        global $teamLeaderID;
        $MLSNumber = test_input($_POST['MLSNumber']);
        $propertyType = test_input($_POST['propertyType']);
        $address = test_input($_POST['address']);
        $houseSize =test_input($_POST['houseSize']);
        $landSize = test_input($_POST['landSize']);
        $listingPrice = test_input($_POST['listingPrice']);
        $coStaffID = test_input($isCoListingDisabled === true ? $teamLeaderID : $_POST['coStaffID']);
        $ownerName = test_input($_POST['ownerName']);
        $contactNumber = test_input($_POST['contactNumber']);
        $commissionRate = test_input($_POST['commissionRate']);

        global $errorMessage;
        global $isError;
        if (empty($MLSNumber) || empty($propertyType) || empty($address) || empty($houseSize) || empty($landSize) ||
            empty($listingPrice) || empty($coStaffID) || empty($ownerName) || empty($contactNumber) || empty($commissionRate)) {
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
        $createCaseArray = array (
            "MLSNumber" => $_POST['MLSNumber'],
            "staffID" => $_SESSION['AccountID'],
            "coStaffID" => $isCoListingDisabled === true ? $teamLeaderID : $_POST['coStaffID'],
            "address" => $_POST['address'],
            "landSize" => $_POST['landSize'],
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
            <div class="title"><p class="titleSize"><strong>NEW LISTING</strong></p></div>
            <form method="post" enctype="multipart/form-data" name="FileUploadFrom">
                <div class="form-group inputPart">
                    <div class="oneLineDiv">
                        <div class="requireTitle mlsNumberTitle">MLS NUMBER* </div>
                            <div class="inputContent">
                                <input type="text" name="MLSNumber" id="MLSNumber" placeholder="&nbsp;&nbsp;MLS NUMBER" style="font-size:12px; height:30px;" size="20" require/>
                            </div>
                            <div class="requireTitle secondTitle">PROPERTY TYPE*</div>
                            <div class="selectPropertyType secondInput">
                                <div class="dropdown">
                                    <select name="propertyType">
                                        <?php
                                        foreach ($propertyTypes as $propertyTypeItem){
                                            echo '<option value="' . $propertyTypeItem . '">', $propertyTypeItem, '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="oneLineDiv">
                            <div class="requireTitle addressTitle">ADDRESS*</div>
                            <div class="inputContent addressInput">
                                <input type="text" name="address" id="address" style="font-size:12px; height:30px; width:420px !important;" size="70" require/>
                            </div>
                        </div>
                        <div class="oneLineDiv">
                            <div class="requireTitle houseSizeTitle">HOUSE SIZE*</div>
                            <div class="inputContent houseSizeInput">
                                <input type="number" step="any" name="houseSize" id="houseSize" placeholder="&nbsp;&nbsp;SQF" style="font-size:12px; height:30px;" size="20" require/>
                            </div>
                            <div class="requireTitle secondTitle landSizeTitle">LAND SIZE*</div>
                            <div class="secondInput landSizeInput">
                                <input type="number" step="any" name="landSize" id="landSize" placeholder="&nbsp;&nbsp;FT" style="font-size:12px; height:30px;" size="23" require/>
                            </div>
                        </div>
                        <div class="oneLineDiv">
                            <div class="requireTitle listingPriceTitle">LISTING PRICE*</div>
                            <div class="inputContent listingPriceInput">
                                <input type="number" step="any" name="listingPrice" id="listingPrice" style="font-size:12px; height:30px;" size="20" require/>
                            </div>
                            <div class="requireTitle secondTitle contactNumberTitle">COMMISSION RATE*</div>
                            <div class="secondInput contactNumberInput">
                                <input type="number" step="any" name="commissionRate" id="commissionRate" style="font-size:12px; height:30px;" size="20" require/>
                            </div>
                            <!--<div class="requireTitle secondTitle">TEAM</div>
                            <div class="secondInput showLeaderName">
                               <a style="font-size:11px; height:30px;" size="20" require><?php echo $teamLeaderName;?></a>
                            </div>-->
                            <!--<div class="requireTitle coListingTitle">CO-LISTING*</div>
                            <div class="selectTeam">
                                <a style="font-size:12px; height:30px;" size="20" require><?php echo $teamLeaderName;?></a>
                            </div>-->
                        </div>
                        <div class="oneLineDiv">
                            <div class="requireTitle owenweNameTitle">OWNER'S NAME*</div>
                            <div class="inputContent owenweNameInput">
                                <input type="text" name="ownerName" id="ownerName" style="font-size:12px; height:30px;" size="20" require/>
                            </div>
                            <div class="requireTitle secondTitle">TEAM</div>
                            <div class="secondInput howLeaderName">
                               <a style="font-size:12px; height:30px;" size="20" require><?php echo $teamLeaderName;?></a>
                            </div>
                            <!--<div class="selectTeamMember secondInput">
                                <div class="dropdown" >
                                <?php
                                    echo '<select name="coStaffID" disabled="' . (int)$isCoListingDisabled . '">';
                                        foreach ($teamMembers as $teamMemberItem){
                                            $teamMemberName = $teamMemberItem['FirstName'] . " " . $teamMemberItem['LastName'];
                                            echo '<option value="' . $teamMemberItem['AccountID'] . '" selected="' . $isSelected . '">', $teamMemberName, '</option>';
                                        }
                                    echo '</select>';
                                ?>
                                </div>
                            </div> -->
                        </div>
                        <div class="oneLineDiv">
                             <div class="requireTitle contactNumberTitle">CONTACT NUMBER*</div>
                             <div class="inputContent contactNumberInput">
                                <input type="text" name="contactNumber" id="contactNumber" style="font-size:12px; height:30px;" size="20" require/>
                             </div>
                             <div class="selectTeamMember secondInput">
                                <div class="dropdown" >
                                <?php
                                    echo '<select name="coStaffID" disabled="' . (int)$isCoListingDisabled . '">';
                                        foreach ($teamMembers as $teamMemberItem){
                                            $teamMemberName = $teamMemberItem['FirstName'] . " " . $teamMemberItem['LastName'];
                                            echo '<option value="' . $teamMemberItem['AccountID'] . '" selected="' . $isSelected . '">', $teamMemberName, '</option>';
                                        }
                                    echo '</select>';
                                ?>
                                </div>
                             </div>
                        </div>
                        <div class="oneLineDiv">
                            <!--<div class="requireTitle contactNumberTitle">COMMISSION RATE*</div>
                            <div class="inputContent contactNumberInput">
                                <input type="number" step="any" name="commissionRate" id="commissionRate" style="font-size:12px; height:30px;" size="20" require/>
                            </div>-->
                        <div class="requireTitle photoUploadTitle">PHOTO UPLOAD*</div>
                        <div class="inputContent ">
                            <input type="file" value="UPLOAD" name="case_image" class="photoUploadButton">
                        </div>
                    </div>
                    <div class="secondInput create">
                        <input class="createButton" type="submit" value="Create" name="create_case">
                    <?php
                    if($isError){
                        echo '<div class="error-message"><a>';
                        global $errorMessage;
                        echo $errorMessage;
                        echo '</a></div>';
                    }
                    ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>