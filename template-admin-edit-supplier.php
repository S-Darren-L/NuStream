<?php

	// Start Session
	session_start();

	/*
	Template Name: Admin Edit Supplier
	*/

?>
<?php
	// Get Supplier ID
	$supplierID = $_GET['SID'];

	// Init Data
	$supplierTypes = get_supplier_types();
	$priceUnits = get_price_units();
	$paymentTerms = get_payment_terms();
	init_date($supplierID);

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

	}

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

	// Update Supplier Detail
	if(isset($_POST['update_supplier']) && date_validated() === true)
	{
		$updateSupplierArray = array (
			"supplierID" => $supplierID,
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
			"supportLocation" => $_POST['supportLocation']);

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
		global $adminSupplierInfoURL;
		global $supplierType;
		$navigateBackURL = $adminSupplierInfoURL . "/?SType=" . $supplierType;
		echo("<script>window.location.assign('$navigateBackURL');</script>");
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
		padding-top: 1px;
		padding-left: 15px;
		background-color: #eeeeee;
		color:#a9a9a9;
		height: 350px;
		width: 680px;
		font-size: 11px;
	}

	.requireTitle {
		width: 150px;
		padding-left: 20px;
		float:left;
		padding-top: 5px;
	}

	.selectServerType {
		float: left;
	}

	.dropdown {
		height: 40px;
		width: 50px;
	}



	.create {
		float:left;
		padding-left: 20px;
		margin-left: 0px;
		margin-top: -80px;
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

	.subTitle h5{
		margin-top: 3px;
		margin-bottom: 2px;
		color:#808080;
	}

	.line {
		height: 10px;
	}

	.inputContent {
		position:relative;
	}

	.supplierName {
		width: 100px;
		float: left;
	}
	.selectServerType {
		margin-left: 10px;
		float: left;
	}

	.selectServerType select {
		border-radius: 3px;
		height: 28px;
		width: 210px;
	}

	.HSTNumber {
		margin-left: 170px;
		float: left;
	}

	.contactAndPrice {
		position: relative;

	}

	.contantInfo {
		display: absolute;
		margin-left: 0px;
		width: 200px;
	}

	.priceInfo {
		display: absolute;
		margin-left: 220px;
		margin-top: -222px;
		width: 200px;
	}

	.selectPrice {
		margin-left: 0px;
		float: left;
	}

	.selectPrice select {
		border-radius: 3px;
		height: 28px;
		width: 100px;
	}

	.selectPriceUnit {
		float: left;
		margin-top: -3px;
	}

	.selectPriceUnit select {
		border-radius: 3px;
		height: 28px;
		width: 164px;
	}

	.selectPaymentTeam {
		float: left;
		margin-top: 0px;
	}

	.selectPaymentTeam select {
		border-radius: 3px;
		height: 28px;
		width: 164px;
		margin-top: 10px;
		margin-left: -50px;
	}

	.pricePerUnit {
		margin-left: 174px;
		margin-top: -3px;

	}

	.priceOthers {
		margin-top: 10px;
		margin-left: 174px;
	}

	.ba{
		float: left;
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
			<div class="title"><h4>UPDATE SUPPLIER</h4></div>
			<form method="post">
				<div class="form-group inputPart">
					<div class="basicInfo">
						<div class="subTitle"><h5>BASIC INFOTMATION</h5></div>
						<div class="line" >
							<hr style="height:1px; width:565px;border:none;border-top:1px solid #a9a9a9; float:left; margin:2px 5px 15px 0px;" />
						</div>
						<div class="inputContent">
							<div class="ba">
								<input type="text" name="supplierName" value="<?php echo $supplierName; ?>" placeholder="SUPPLIER NAME*" style="font-size:11px; height:27px;" size="22" require/>
							</div>
							<div class="selectServerType">
								<div class="dropdown" >
									<select name="supplierType">
										<?php
											foreach ($supplierTypes as $supplierTypeItem){
												global $supplierType;
												$isSelected = $supplierTypeItem === $supplierType ? 'selected' : null;
												echo '<option value="' . $supplierTypeItem . '" ' . $isSelected . '>', $supplierTypeItem, '</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="HSTNumber">
								<input type="text" name="HSTNumber" value="<?php echo $HSTNumber; ?>" placeholder="HST NUMBER*" style="font-size:11px; height:27px;" size="30" require/>
							</div>
						</div>
					</div>
					<div class="contactAndPrice">
						<div class="contantInfo">
							<div class="subTitle" style="margin-top:20px;">
								<h5>CONTACT INFOTMATION</h5>
								<div class="line" >
									<hr style="height:1px; width:180px;border:none;border-top:1px solid #a9a9a9; float:left; margin:2px 5px 5px 0px;" />
								</div>
							</div>

							<input type="text" name="firstContactName" value="<?php echo $firstContactName; ?>" placeholder="FIRST CONTACT NAME*" style="font-size:11px; margin-bottom:10px; margin-top:10px; height:27px;" size="30" require />
							<input type="text" name="firstContactNumber" value="<?php echo $firstContactNumber; ?>" placeholder="FIRST CONTACT NUMBER*" style="font-size:11px; margin-bottom:25px; height:27px;" size="30" require />
							<input type="text" name="secondContactName" value="<?php echo $secondContactName; ?>" placeholder="SECOND CONTACT NAME*" style="font-size:11px; margin-bottom:10px; height:27px;" size="30" require />
							<input type="text" name="secondContactNumber" value="<?php echo $secondContactNumber; ?>" placeholder="SECOND CONTACT NUMBER*" style="font-size:11px; margin-bottom:10px; height:27px;" size="30" require />
						</div>
						<div class="priceInfo">
							<div class="subTitle" style="margin-top:20px; width:400px; margin-bottom:13px;">
								<h5>PRICE INFOTMATION</h5>
								<div class="line" >
									<hr style="height:1px; width:370px;border:none;border-top:1px solid #a9a9a9; float:left; margin:2px 5px 2px 0px;" />
								</div>
							</div>
							<div class="selectPriceUnit">
								<div class="dropdown">
									<select name="priceUnit">
										<?php
											foreach ($priceUnits as $priceUnitItem){
												global $priceUnit;
												$isSelected = $priceUnitItem === $priceUnit ? 'selected' : null;
												echo '<option value="' . $priceUnitItem . '" ' . $isSelected . '>', $priceUnitItem, '</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="pricePerUnit">
								<input type="text" name="pricePerUnit" value="<?php echo $pricePerUnit; ?>" placeholder="PRICE PER UNIT*" style="font-size:11px; height:27px;" size="30" require/>
							</div>
							<div class="selectPaymentTeam">
								<div class="dropdown">
									<select name="paymentTerm" id="payment-term-drop-down" onchange="paymentTermChanged()">
										<?php
											foreach ($paymentTerms as $paymentTermItem){
												global $paymentTerm;
												$isSelected = $paymentTermItem === $paymentTerm ? 'selected' : null;
												echo '<option value="' . $paymentTermItem . '" ' . $isSelected . '>', $paymentTermItem, '</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="priceOthers">
								<input type="text" name="otherPaymentTerm" value="<?php echo $otherPaymentTerm; ?>" id="other-payment-term" disabled="disabled" placeholder="OTHER PAYMENT TERM" style="font-size:11px; height:27px;" size="30" require/>
							</div>
						</div>
					</div>
				</div>
				<div class="create">
					<input type="submit" value="Update" name="update_supplier" class="createButton">
					<input type="submit" value="Deactivate" name="deactivate_supplier" class="deleteButton">
					<?php
					if($isError){
						echo '<div class="error-message"><a>';
						global $errorMessage;
						echo $errorMessage;
						echo '</a></div>';
					}
					?>
				</div>
				<input type="submit" value="Back" name="navigate_back">
			</form>
		</div>
	</div>
</div>
</body>