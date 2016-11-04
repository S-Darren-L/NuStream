<?php

	// Start Session
	session_start();

	/*
	Template Name: Admin Edit Supplier
	*/

	// Get Supplier ID
	$supplierID = $_GET['SID'];

	// Init Data
	$supplierTypes = get_supplier_types();
	$priceUnits = get_price_units();
	$paymentTerms = get_payment_terms();
	init_date($supplierID);
	$isDisable = $_SESSION['AccountPosition'] !== ADMIN ?'disabled' : null;
	$isHidden = $_SESSION['AccountPosition'] !== ADMIN ?'hidden' : null;

	// //Init Data
	function init_date($supplierID){
		$result = get_supplier_detail($supplierID);
		if($result === null)
			echo 'result is null';

		$getSupplierArray = mysqli_fetch_array($result);

		global $supplierName;
		global $supplierType;
		global $priceUnit;
		global $pricePerUnit;
		global $firstContactName;
		global $firstContactNumber;
		global $secondContactName;
		global $secondContactNumber;
		global $supportLocation;
		global $HSTNumber;
		global $paymentTerm;
		global $otherPaymentTerm;
		global $minimumPrice;
		global $pricePerCondo;
		global $pricePerHouse;
		global $pricePerSemi;
		global $pricePerTownhouse;

		$supplierName = $getSupplierArray['SupplierName'];
		$supplierType = $getSupplierArray['SupplierType'];
		$priceUnit = $getSupplierArray['PriceUnit'];
		$pricePerUnit = $getSupplierArray['PricePerUnit'];
		$firstContactName = $getSupplierArray['FirstContactName'];
		$firstContactNumber = $getSupplierArray['FirstContactNumber'];
		$secondContactName = $getSupplierArray['SecondContactName'];
		$secondContactNumber = $getSupplierArray['SecondContactNumber'];
		$supportLocation = $getSupplierArray['SupportLocation'];
		$HSTNumber = $getSupplierArray['HSTNumber'];
		$paymentTerm = $getSupplierArray['PaymentTerm'];
		$otherPaymentTerm = $getSupplierArray['OtherPaymentTerm'];
		$minimumPrice = $getSupplierArray['MinimumPrice'];
		$pricePerCondo = $getSupplierArray['PricePerCondo'];
		$pricePerHouse = $getSupplierArray['PricePerHouse'];
		$pricePerSemi = $getSupplierArray['PricePerSemi'];
		$pricePerTownhouse = $getSupplierArray['PricePerTownhouse'];

	}

	// Validate Mandatory Fields
	function date_validated()
	{
		$firstContactName = $_POST['firstContactName'];
		$firstContactNumber = $_POST['firstContactNumber'];
		$priceUnit = $_POST['priceUnit'];
		$ricePerUnit = $_POST['pricePerUnit'];
		$paymentTerm = $_POST['paymentTerm'];
		$otherPaymentTerm = $_POST['otherPaymentTerm'];
		$supportLocation = $_POST['supportLocation'];

		global $errorMessage;
		global $isError;
		if (empty($firstContactName) || empty($firstContactNumber) ||
			empty($supportLocation) || empty($priceUnit) || empty($ricePerUnit) || empty($paymentTerm) ||
			($paymentTerm === 'OTHER' && empty($otherPaymentTerm)) || empty($supportLocation)) {
			$errorMessage = "Mandatory fields are empty";
			$isError = true;
			return false;
		} else {
			$errorMessage = null;
			$isError = false;
			return true;
		}
	}

	// Update Supplier Detail
	if(isset($_POST['update_supplier']) && date_validated() === true)
	{
		$updateSupplierArray = array (
			"supplierID" => $supplierID,
			"HSTNumber" => $_POST['HSTNumber'],
			"firstContactName" => $_POST['firstContactName'],
			"firstContactNumber" => $_POST['firstContactNumber'],
			"priceUnit" => $_POST['priceUnit'],
			"pricePerUnit" => $_POST['pricePerUnit'],
			"paymentTerm" => $_POST['paymentTerm'],
			"supportLocation" => $_POST['supportLocation'],
			"mimPayment" => $_POST['mimPayment'],
			"condoPrice" => $_POST['condoPrice'],
			"townPrice" => $_POST['townPrice'],
			"semiPrice" => $_POST['semiPrice'],
			"detachedPrice" => $_POST['detachedPrice']);

		$updateSupplierResult = edit_supplier($updateSupplierArray);

		if($updateSupplierResult === true){
			init_date($supplierID);
		}
	}

	// Deactivate Supplier
	if(isset($_POST['deactivate_supplier'])){
		$deactivateResult = deactivate_supplier_by_id($supplierID);
		navigate_back();
	}

	// Navigate Back
	if(isset($_POST['navigate_back'])){
		navigate_back();
	}

	function navigate_back(){
        header('Location: ' . get_home_url() . '/supplier-info');
	}
?>

<script type="text/javascript">
	function paymentTermChanged() {
		var paymentTerm = document.getElementById("payment-term-drop-down").value;
		if(paymentTerm === "OTHER"){
			document.getElementById("other-payment-term").disabled=false;
		}else {
			document.getElementById("other-payment-term").disabled = true;
		}
	}
</script>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/pcStyles.css">
    <style>
        #NoHouseTypeSelected{
            margin-bottom: 17px;
        }

        #HouseTypeSelected{
            display:none;
            position:absolute;
        }
        #empty{display:none;}
        #HouseTypeSelected > div{
            display:inline-block;
        }
        .Condo input{
            width:50px;
        }
                .Townhouse input{
            width:100px;
        }
                        .Semi input{
            width:50px;
        }
                                .Detached input{
            width:100px;
        }
    </style>
</head>
<body>
    <div id="container">
        <?php
        include_once(__DIR__ . '/navigation.php');
        ?>
        <div id="main">
            <div class="formPart">
                <div class="CNSTitle"><p class="titleSize"><strong>UPDATE SUPPLIER</strong></p></div>
                <form method="post">
                    <div class="form-group CNSInputPart">
                        <div class="CNSOneLineDiv">
                            <div class="subTitle"><h5>BASIC INFOTMATION</h5></div>
                            <div class="CNSSuppliceNamePart">SUPPLIER NAME *<br/>
                                <input type="text" <?php echo $isDisable; ?> name="supplierName" value="<?php echo $supplierName; ?>"  class="CNSSuppliceName" disabled="true" require/>
                            </div>
                            <div class="CNSSelectServerType">SERVICE TYPE *<br/>
                                <select disabled="disabled name="supplierType" <?php echo $isDisable; ?> >
										<?php
											foreach ($supplierTypes as $supplierTypeItem){
												global $supplierType;
												$isSelected = $supplierTypeItem === $supplierType ? 'selected' : null;
												echo '<option value="' . $supplierTypeItem . '" ' . $isSelected . '>', $supplierTypeItem, '</option>';
											}
										?>
				</select>    
                            </div>
                            <div class="CNSHSTNumberPart">HST NUMBER *<br/>
                                <input type="text" <?php echo $isDisable; ?> name="HSTNumber" value="<?php echo $HSTNumber; ?>" class="CNSHSTNumber" require/>
                            </div>
                        </div>
                        <div class="CNSOneLineDiv">
                            <div class="CNSContantInfo">
                                <div class="subTitle">
                                    <h5>CONTACT INFOTMATION</h5> 
                                </div>CONTACT PERSON 1 *<br/>
                                    <input type="text" <?php echo $isDisable; ?> name="firstContactName" value="<?php echo $firstContactName; ?>"  class="CNSContactInput" require /><br/>CONTACT NUMBER *<br/>
                                    <input type="text" <?php echo $isDisable; ?> name="firstContactNumber" value="<?php echo $firstContactNumber; ?>" class="CNSContactInput" require /><br/><br/>SUPPORT AREA *<br/>
                                    <input type="text" <?php echo $isDisable; ?> name="supportLocation" value="<?php echo $supportLocation; ?>" class="CNSContactInput" require /><br/>CONTACT NUMBER *<br/>
                                    <input type="text" <?php echo $isDisable; ?> name="secondContactNumber" value="<?php echo $secondContactNumber; ?>" class="CNSContactInput" require />
                            </div>
                            <div class="CNSPriceInfo">
                                <div class="subTitle">
                                    <h5>PRICE INFOTMATION</h5>
                                </div>
                                <div class="ESAPriceInfoLineOne">
                                    <div class="ESAPriceUnitSelect">PRICE UNIT *<br/>
                                        <select class="ESAPriceUnitSelect" name="priceUnit" id="priceUnit" <?php echo $isDisable; ?> >
					    <?php
						foreach ($priceUnits as $priceUnitItem){
						global $priceUnit;
						$isSelected = $priceUnitItem === $priceUnit ? 'selected' : null;
						echo '<option value="' . $priceUnitItem . '" ' . $isSelected . '>', $priceUnitItem, '</option>';
					        }
					    ?>
					</select>
                                        <div class="CNSSpace" id="empty"></div>
                                        <div id="NoHouseTypeSelected">
                                            <div>MINIMUM PAYMENT</div>
                                            <input type="text" name="mimPayment" value="<?php echo $minimumPrice; ?>" class="CNSMinimumPaymentInput" require />
                                        </div>
                                        <div id="HouseTypeSelected">
                                            <div class="Condo">
                                                <div>CONDO</div>
                                                <input name="condoPrice" value="<?php echo $pricePerCondo; ?>" type="text" />
                                            </div>
                                            <div class="Townhouse">
                                                <div>TOWNHOUSE</div>
                                                <input name="townPrice" value="<?php echo $pricePerTownhouse; ?>" type="text" />
                                            </div>
                                            <div class="Semi">
                                                <div>SEMI</div>
                                                <input name="semiPrice" value="<?php echo $pricePerSemi; ?>" type="text" />
                                            </div>
                                            <div class="Detached">
                                                <div>DETACHED</div>
                                                <input name="detachedPrice" value="<?php echo $pricePerHouse; ?>" type="text" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ESAPricePerUnit">PRICE PER UNIT *<br/>
                                        <input type="text" <?php echo $isDisable; ?> name="pricePerUnit" value="<?php echo $pricePerUnit; ?>" class="ESAPricePerUintInput" require/>
                                    </div>
                                </div>
                                <!--<div style="height:110px;"></div>-->
                                <div class="ESAPriceInfoLineOne ESALastSpace">
                                    <div class="ESASelectPaymentTeamPart ">PAYMENT TEAM *<br/>
                                        <select class="ESASelectPaymentTeam" name="paymentTerm" <?php echo $isDisable; ?>  id="payment-term-drop-down" onchange="paymentTermChanged()">
										<?php
											foreach ($paymentTerms as $paymentTermItem){
												global $paymentTerm;
												$isSelected = $paymentTermItem === $paymentTerm ? 'selected' : null;
												echo '<option value="' . $paymentTermItem . '" ' . $isSelected . '>', $paymentTermItem, '</option>';
											}
										?>
					</select>
                                    </div>
                                    <div class="ESAOthers">IF OTHER PLEASE INDICATE
                                        <input type="text" <?php echo $isDisable; ?> name="otherPaymentTerm" value="<?php echo $otherPaymentTerm; ?>" id="other-payment-term" class="ESAPricePerUintInput" require/><br/><br/>
                                        <input type="submit" <?php echo $isHidden; ?> value="Update" name="update_supplier" class="ESAUpdateButton">
                                        <input type="submit" <?php echo $isHidden; ?> value="Deactivate" name="deactivate_supplier" class="ESADeleteButton">
                                        <input type="submit" value="Back" name="navigate_back" class="ESABackButton">
                        <?php
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
                                </div>
                            </div>
                        </div>
                    <!--<div class="create">
                        <input type="submit" <?php echo $isHidden; ?> value="Update" name="update_supplier" class="ESAUpdateButton">
                        <input type="submit" <?php echo $isHidden; ?> value="Deactivate" name="deactivate_supplier" class="ESADeleteButton">
                        
                        <?php
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
                    </div>-->
                    <!--<input type="submit" value="Back" name="navigate_back">-->
                </form>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
	function paymentTermChanged() {
		var paymentTerm = document.getElementById("payment-term-drop-down").value;
		if(paymentTerm === "OTHER"){
			document.getElementById("other-payment-term").disabled=false;
		}else {
			document.getElementById("other-payment-term").disabled = true;
		}
	}
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $('#priceUnit').on('change', function (evt) {
            if (evt.target.value !== 'BYHOUSETYPE') {
                $('#empty').css('display', 'none');
                $('#NoHouseTypeSelected').css('display', 'inline-block');
                $('#HouseTypeSelected').css('display', 'none');
                
            } else {
                $('#empty').css('display', 'inline-block');
                $('#NoHouseTypeSelected').css('display', 'none');
                $('#HouseTypeSelected').css('display', 'inline-block');
        
            }
        });
    </script>
</body>