<?php

	// Start Session
	session_start();

	/*
	Template Name: Admin Create Supplier
	*/

	//Init Data
	$supplierTypes = get_supplier_types();
	$priceUnits = get_price_units();
	$paymentTerms = get_payment_terms();

	// Validate Mandatory Fields
	function date_validated()
	{
		$supplierName = $_POST['supplierName'];
		$supplierType = $_POST['supplierType'];
		$HSTNumber = $_POST['HSTNumber'];
		$firstContactName = $_POST['firstContactName'];
		$firstContactNumber = $_POST['firstContactNumber'];
		$secondContactName = $_POST['secondContactName'];
		$secondContactNumber = $_POST['secondContactNumber'];
		$priceUnit = $_POST['priceUnit'];
		$ricePerUnit = $_POST['pricePerUnit'];
		$paymentTerm = $_POST['paymentTerm'];
		$otherPaymentTerm = $_POST['otherPaymentTerm'];
		$supportLocation = $_POST['supportLocation'];
		//temp
		$supportLocation = "location";

		global $errorMessage;
		global $isError;
		if (empty($supplierName) || empty($supplierType) || empty($HSTNumber) || empty($firstContactName) || empty($firstContactNumber) ||
			empty($secondContactName) || empty($secondContactNumber) || empty($priceUnit) || empty($ricePerUnit) || empty($paymentTerm) ||
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

	// Create Supplier
	if(isset($_POST['create_supplier']) && date_validated() === true){
			$createSupplierArray = array (
				"supplierName" => $_POST['supplierName'],
				"supplierType" => $_POST['supplierType'],
				"HSTNumber" => $_POST['HSTNumber'],
				"firstContactName" => $_POST['firstContactName'],
				"firstContactNumber" => $_POST['firstContactNumber'],
				"secondContactName" => $_POST['secondContactName'],
				"secondContactNumber" => $_POST['secondContactNumber'],
				"priceUnit" => $_POST['priceUnit'],
				"pricePerUnit" => $_POST['pricePerUnit'],
				"paymentTerm" => $_POST['paymentTerm'],
				"otherPaymentTerm" => $_POST['otherPaymentTerm'],
				"supportLocation" => $_POST['supportLocation']);

			$result = create_supplier($createSupplierArray);

			$result_rows = [];
			while($row = mysqli_fetch_array($result))
			{
				$result_rows[] = $row;
			}
			$supplierID = $result_rows[0]["LAST_INSERT_ID()"];
			$uploadFilesPath = get_home_url() . '/upload-files/?UType=Supplier&UID=' . $supplierID;

//			if(!is_null($result) && $result !== false)
//			{
//				echo ("<script>window.location.assign(' . $uploadFilesPath');</script>");
//			}
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
</head>
<body>
<div id="container">
    <?php
	include_once(__DIR__ . '/navigation.php');
    ?>
    <div id="main">
	<div class="formPart">
	    <div class="CNSTitle"><p class="titleSize">CREATE NEW SUPPLIER</h4></div>
		<form method="post">
		    <div class="form-group CNSInputPart">
			<div class="CNSOneLineDiv">
			    <div class="subTitle"><h5>BASIC INFOTMATION</h5></div>
			    <div class="CNSSuppliceNamePart">SUPPLIER NAME *<br/>
				<input type="text" class="CNSSuppliceName" name="supplierName"require/>
			    </div>
			    <div class="CNSSelectServerType">SERVICE TYPE *<br/>
			        <select name="supplierType">
			       	    <?php
				        foreach ($supplierTypes as $supplierTypeItem){
					echo '<option value="' . $supplierTypeItem . '">', $supplierTypeItem, '</option>';
					}
			            ?>
				</select>
			    </div>
		            <div class="CNSHSTNumberPart">HST NUMBER *<br/>
	          	        <input type="text" name="HSTNumber"  class="CNSHSTNumber" require/>
			    </div>
</div>
			    <div class="CNSOneLineDiv">
			        <div class="CNSContantInfo">
				    <div class="subTitle">
				        <h5>CONTACT INFOTMATION</h5> 
				    </div>
                                    CONTACT PERSON 1 *<br/>
				    <input type="text" name="firstContactName" class="CNSContactInput" require />
                                    <br/>CONTACT NUMBER *<br/>
			            <input type="text" name="firstContactNumber" class="CNSContactInput" require /><br/>
				    <br/>SUPPORT AREA *<br/>
			            <input type="text" name="secondContactName" class="CNSContactInput" require />
                                    <br/>CONTACT NUMBER *<br/>
				    <input type="text" name="secondContactNumber" class="CNSContactInput" require />
			        </div>
			        <div class="CNSPriceInfo">
				    <div class="subTitle"><h5>PRICE INFOTMATION</h5></div>
				    <div class="CNSSelectPriceUnit">PRICE UNIT *<br/>
				        <select class="CNSPriceUnitSelect" name="priceUnit">
				            <?php
					        foreach ($priceUnits as $priceUnitItem){
						echo '<option value="' . $priceUnitItem . '">', $priceUnitItem, '</option>';
					        }
				            ?>
				        </select>
                                        </br>MINIMUM PAYMENT</br>
                                        <input type="text" class="CNSMinimumPaymentInput" require/>
				        <br/><br/>PAYMENT TEAM *
                                        <select class="CNSPriceUnitSelect" name="paymentTerm" id="payment-term-drop-down" onchange="paymentTermChanged()">
					    <?php
					        foreach ($paymentTerms as $paymentTermItem){
						echo '<option value="' . $paymentTermItem . '">', $paymentTermItem, '</option>';
					    }
					    ?>
				        </select>
				    </div>
				    <div class="CNSPricePerUnit">PRICE PER UNIT *
				        <input type="text" name="pricePerUnit" class="CNSPricePerUintInput" require/>
                                        <div class="CNSSpace"></div>
			            
				    
			
				<!--<select name="paymentTerm" id="payment-term-drop-down" onchange="paymentTermChanged()">
					<?php
					foreach ($paymentTerms as $paymentTermItem){
					echo '<option value="' . $paymentTermItem . '">', $paymentTermItem, '</option>';
					}
					?>
			            </select>-->				
				    IF OTHER PLEASE INDICATE
				    <input type="text" disabled="disabled" id="other-payment-term" name="otherPaymentTerm" class="CNSPricePerUintInput" require/><br/><br/>
			            <input class="CNSCreateButton" type="submit" value="Create" name="create_supplier">
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
			</div>
		    </div>
	            <!--<div class="create">
			<input class="createButton" type="submit" value="Create" name="create_supplier">
					<?php
					if($isError){
						echo '<div class="error-message"><a>';
						global $errorMessage;
						echo $errorMessage;
						echo '</a></div>';
					}
					?>
				</div> -->
		</form>
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
</body>