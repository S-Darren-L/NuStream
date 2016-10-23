<?php

// Start Session
session_start();

/*
Template Name: Agent Case Estimation
*/

    // Init Data

    $isNewPage = $_REQUEST['NEW'];
    $propertyTypes = get_property_types();
    set_init_value();

    //Estimate
    if(isset($_POST['estimate'])){
        $houseSize = $_POST['houseSize'];
        $propertyType = $_POST['propertyType'];
        $landSize = $_POST['landSize'];

        $isStagingChecked = $_POST['stagingCheckBox'];
        $isPhotographyChecked = $_POST['photographyCheckBox'];
        $isCleanUpChecked = $_POST['cleanUpCheckBox'];
        $isRelocateHomeChecked = $_POST['relocateHomeCheckBox'];
        $isTouchUpChecked = $_POST['touchUpCheckBox'];
        $isInspectionChecked = $_POST['inspectionCheckBox'];
        $isYardWordChecked = $_POST['yardWordCheckBox'];
        $isStorageChecked = $_POST['storageCheckBox'];

        //Estimate Staging
        if($isStagingChecked === 'checked')
            $stagingEstimatePrice = default_staging_price_estimate($houseSize);
        //Estimate Photography
        if($isPhotographyChecked === 'checked')
            $photographyEstimatePrice = default_photography_price_estimate($propertyType);
        //Estimate Clean Up
        if($isCleanUpChecked === 'checked')
            $cleanUpEstimatePrice = default_clean_up_price_estimate($houseSize);
        //Estimate Relocate Home
        if($isRelocateHomeChecked === 'checked')
            $relocateHomeEstimatePrice = default_relocate_home_price_estimate();
        //Estimate Touch Up
        if($isTouchUpChecked === 'checked')
            $touchUpEstimatePrice = default_touch_up_price_estimate();
        //Estimate Inspection
        if($isInspectionChecked === 'checked')
            $inspectionEstimatePrice = default_inspection_price_estimate($propertyType);
        //Estimate Yard Work
        if($isYardWordChecked === 'checked')
            $yardWorkEstimatePrice = default_yard_work_price_estimate();
        //Estimate Storage
        if($isStorageChecked === 'checked')
            $storageEstimatePrice = default_storage_price_estimate();
        // Total Cost
        $totalCost = $stagingEstimatePrice + $photographyEstimatePrice + $cleanUpEstimatePrice + $relocateHomeEstimatePrice + $touchUpEstimatePrice + $inspectionEstimatePrice + $yardWorkEstimatePrice + $storageEstimatePrice;

        $_SESSION['estimateHouseSize'] = $houseSize;
        $_SESSION['estimatePropertyType'] = $propertyType;
        $_SESSION['estimateLandSize'] = $landSize;

        $_SESSION['isStagingChecked'] = $isStagingChecked;
        $_SESSION['isPhotographyChecked'] = $isPhotographyChecked;
        $_SESSION['isCleanUpChecked'] = $isCleanUpChecked;
        $_SESSION['isRelocateHomeChecked'] = $isRelocateHomeChecked;
        $_SESSION['isTouchUpChecked'] = $isTouchUpChecked;
        $_SESSION['isInspectionChecked'] = $isInspectionChecked;
        $_SESSION['isYardWordChecked'] = $isYardWordChecked;
        $_SESSION['isStorageChecked'] = $isStorageChecked;
    }

    if(isset($_POST['clear_all'])){
        set_init_value();
    }

    function set_init_value(){
        global $isNewPage;

        global  $houseSize;
        global  $landSize;
        global  $propertyType;

        global  $stagingEstimatePrice;
        global  $photographyEstimatePrice;
        global  $cleanUpEstimatePrice;
        global  $touchUpEstimatePrice;
        global  $relocateHomeEstimatePrice;
        global  $inspectionEstimatePrice;
        global  $yardWorkEstimatePrice;
        global  $storageEstimatePrice;
        global  $totalCost;

        global $isStagingChecked;
        global $isPhotographyChecked;
        global $isCleanUpChecked;
        global $isRelocateHomeChecked;
        global $isTouchUpChecked;
        global $isInspectionChecked;
        global $isYardWordChecked;
        global $isStorageChecked;


        $stagingEstimatePrice =
        $photographyEstimatePrice =
        $cleanUpEstimatePrice =
        $touchUpEstimatePrice =
        $relocateHomeEstimatePrice =
        $inspectionEstimatePrice =
        $yardWorkEstimatePrice =
        $storageEstimatePrice =
        $totalCost = 0;
        if ($isNewPage === 0){
            $houseSize = $_SESSION['estimateHouseSize'];
            $propertyType = $_SESSION['estimatePropertyType'];
            $landSize = $_SESSION['estimateLandSize'];

            $isStagingChecked = $_SESSION['isStagingChecked'];
            $isPhotographyChecked = $_SESSION['isPhotographyChecked'];
            $isCleanUpChecked = $_SESSION['isCleanUpChecked'];
            $isRelocateHomeChecked = $_SESSION['isRelocateHomeChecked'];
            $isTouchUpChecked = $_SESSION['isTouchUpChecked'];
            $isInspectionChecked = $_SESSION['isInspectionChecked'];
            $isYardWordChecked = $_SESSION['isYardWordChecked'];
            $isStorageChecked = $_SESSION['isStorageChecked'];
        }
        else{
            $isStagingChecked = null;
            $isPhotographyChecked = null;
            $isCleanUpChecked = null;
            $isRelocateHomeChecked = null;
            $isTouchUpChecked = null;
            $isInspectionChecked = null;
            $isYardWordChecked = null;
            $isStorageChecked = null;
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
            <div class="title"><p class="titleSize"><strong>ESTIMATION</strong></p></div>
            <div class="ESRASelectPart">
		<div class="ESRAOneLineDiv">
                    <div class="ESRAHouseSizePart">HOUSE SIZE *<br/>
			<input type="text" class="ESRAHouseSize" require/>
	            </div>
		    <div class="ESRASelectPropertyType">PROPERTY TYPE *<br/>
			<select>
			   <option value="1">PROPERTY TYPE *</option>
			</select>
	             </div>
		     <div class="ESRAButtonPart"><br/>
			<button class="EDTASubmitButton">SUBMIT</button>
			<button class="EDTAClearButton">CLEAR</button>
		     </div>	
		 </div>
	    </div>
            <div class="ESTATablePart ESTAInputPart">
            <form method="post">
                        <table class="ESTATable-style">
                            <tbody>
                            <tr>
                                <td><input class="ESTACheckBox" type="checkbox" name="stagingCheckBox" value="checked" <?php echo $isStagingChecked; ?>></td>
                                <td>STAGING</td>
                                <td style="text-align:center;"><?php echo $stagingEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input class="ESTACheckBox" type="checkbox" name="touchUpCheckBox" value="checked" <?php echo $isTouchUpChecked; ?>></td>
                                <td>TOUCH UP</td>
                                <td style="text-align:center;"><?php echo $touchUpEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input class="ESTACheckBox" type="checkbox" name="cleanUpCheckBox" value="checked" <?php echo $isCleanUpChecked; ?>></td>
                                <td>CLEAN UP</td>
                                <td style="text-align:center;"><?php echo $cleanUpEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="ESTACheckBox" name="yardWordCheckBox" value="checked" <?php echo $isYardWordChecked; ?>></td>
                                <td>YARD WORK</td>
                                <td style="text-align:center;"><?php echo $yardWorkEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="ESTACheckBox" name="inspectionCheckBox" value="checked" <?php echo $isInspectionChecked; ?>></td>
                                <td>INSPECTION</td>
                                <td style="text-align:center;"><?php echo $inspectionEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="ESTACheckBox" name="storageCheckBox" value="checked" <?php echo $isStorageChecked; ?>></td>
                                <td>STORAGE</td>
                                <td style="text-align:center;"><?php echo $storageEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="ESTACheckBox" name="relocateHomeCheckBox" value="checked" <?php echo $isRelocateHomeChecked; ?>></td>
                                <td>RELOCATE HOME</td>
                                <td style="text-align:center;"><?php echo $relocateHomeEstimatePrice;?></td>
                            </tr>
                            <tr>
                                <td><input class="ESTACheckBox" type="checkbox" name="photographyCheckBox" value="checked" <?php echo $isPhotographyChecked; ?>></td>
                                <td>PHOTOGRAPHY</td>
                                <td style="text-align:center;"><?php echo $photographyEstimatePrice;?></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="ESTASpaceOne">
			    <span class="ESTATotalCostStyle">Total Cost:  <?php echo $totalCost; ?></span>
			</div>
                        <!--<h4 style="margin-left:20px;color:#a9a9a9; font-size:15px;">Total Cost:  <?php echo $totalCost; ?></h4>-->
                </div><!------- START COMMENT--------->
                <!--<div class="estimationPart">
                    <h4 style="padding:10px 0 0 10px;">ESTIMATION</h4>
                    <div class="line" >
                        <hr style="height:1px; width:240px;border:none;border-top:1px solid #fff; float:left; margin:2px 5px 5px 10px;" />	</br>
                    </div>
                    <input type="number" name="houseSize" value="<?php echo $houseSize; ?>" placeholder="HOUSE SIZE*" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;" size="30" require />
                    <select  name="propertyType" class="estimationAgentSelect" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;">
                        <?php
                                foreach ($propertyTypes as $propertyTypeItem){
                                    global $propertyType;
                                    $isSelected = $propertyTypeItem === $propertyType ? 'selected' : null;
                                    echo '<option class="estimationAgentOption" value="' . $propertyTypeItem . '" ' . $isSelected . '>', $propertyTypeItem, '</option>';
                                }
                                ?>
                    </select>
                    <input type="number" name="landSize" value="<?php echo $landSize; ?>" placeholder="LAND SIZE*" style="font-size:11px; margin:0 0 15px 10px; height:30px; border-radius:2px; border:1px #fff solid;" size="30" require />
                </div>
                <div class="estimateButtonPart">
                    <div class="estimatePart">
                        <input name="NEW" value="0" hidden="hidden">
                        <input type="submit" value="ESTIMATE" class="estimateButton" name="estimate">
                    </div>
                    <div class="clearAllPart">
                        <input type="submit" value="CLEAR ALL" class="clearAllButton" name="clear_all">
                    </div>-->
            </form>       <!------- END COMMENT--------->
        <!--</div>-->
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>