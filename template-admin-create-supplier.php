<?php

	// Start Session
	session_start();

	/*
	Template Name: Admin Create Supplier
	*/

?>
<?php
	// Set Navigation URL
	$filesURL = get_home_url() . '/admin-files-management/';
	$createSupplierURL = get_home_url() . '/admin-create-supplier';
	$createMemberURL = get_home_url() . '/admin-create-agent-account';
	$memberInfoURL = get_home_url() . '/admin-member-info';
	$supplierInfoURL = get_home_url() . '/admin-supplier-info';

	// Check Session Exist
	if(!isset($_SESSION['AccountID'])){
		redirectToLogin();
	}

	// Logout User
	if(isset($_GET['logout'])) {
		logoutUser();
	}

	$UserName = $_SESSION['FirstName'] . " " . $_SESSION['LastName'];

	// Set URL
	$homeURL = get_home_url();
	$mainPath = $homeURL . "/wp-content/themes/NuStream/";
	$logo1ImagePath = $mainPath . "img/logo1.png";

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
	if(isset($_POST['create_supplier']) && date_validated() === true)
		{
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

	.selectPaymentTerm {
		float: left;
		margin-top: 0px;
	}

	.selectPaymentTerm select {
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
	<div id="nav">
		<div class="logo">
			<?php
			echo '<img src="' . $logo1ImagePath . '"/>';
			?>
		</div>
		<div class="userNamePart">
			<h4 id="userName"><?php echo $UserName;?></h4>
			<h8 id="position" style="font-size:10px;"><?php echo $_SESSION['AccountPosition'];?></h8>
		</div>
		<ul class="nav nav-pills nav-stacked">
			<li><?php echo '<a href="' . $filesURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;Files</a></li>
			<li><?php echo '<a href="' . $createMemberURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-blackboard"></span>&nbsp;&nbsp;Create Member</a></li>
			<li><?php echo '<a href="' . $memberInfoURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-th-large"></span>&nbsp;&nbsp;Member Info</a></li>
			<li><?php echo '<a href="' . $createSupplierURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Create Supplier</a></li>
			<li><?php echo '<a href="' . $supplierInfoURL . '" style="text-align:left;">'; ?>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;Supplier Info</a></li>
			<li><a href="?logout" style="text-align:left;">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
		</ul>
		<div class="footer">
			<p class="copyRight" style="font-size:10px;">@copyright @2016<br/> Darren Liu All Rights Reserved</p>
		</div>
	</div>
	<div id="main">
		<div class="formPart">
			<div class="title"><h4>CREATE SUPPLIER</h4></div>
			<form method="post">
				<div class="form-group inputPart">
					<div class="basicInfo">
						<div class="subTitle"><h5>BASIC INFOTMATION</h5></div>
						<div class="line" >
							<hr style="height:1px; width:565px;border:none;border-top:1px solid #a9a9a9; float:left; margin:2px 5px 15px 0px;" />
						</div>
						<div class="inputContent">
							<div class="ba">
								<input type="text" name="supplierName" placeholder="SUPPLIER NAME*" style="font-size:11px; height:27px;" size="22" require/>
							</div>
							<div class="selectServerType">
								<div class="dropdown">
									<select name="supplierType">
										<?php
											foreach ($supplierTypes as $supplierTypeItem){
												echo '<option value="' . $supplierTypeItem . '">', $supplierTypeItem, '</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="HSTNumber">
								<input type="text" name="HSTNumber" placeholder="HST NUMBER*" style="font-size:11px; height:27px;" size="30" require/>
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

							<input type="text" name="firstContactName" placeholder="FIRST CONTACT NAME*" style="font-size:11px; margin-bottom:10px; margin-top:10px; height:27px;" size="30" require />
							<input type="text" name="firstContactNumber" placeholder="FIRST CONTACT NUMBER*" style="font-size:11px; margin-bottom:25px; height:27px;" size="30" require />
							<input type="text" name="secondContactName" placeholder="SECOND CONTACT PERSON*" style="font-size:11px; margin-bottom:10px; height:27px;" size="30" require />
							<input type="text" name="secondContactNumber" placeholder="SECOND CONTACT NUMBER" style="font-size:11px; margin-bottom:10px; height:27px;" size="30" require />
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
												echo '<option value="' . $priceUnitItem . '">', $priceUnitItem, '</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="pricePerUnit">
								<input type="text" name="pricePerUnit" placeholder="PRICE PER UNIT*" style="font-size:11px; height:27px;" size="30" require/>
							</div>
							<div class="selectPaymentTerm">
								<div class="dropdown">
									<select name="paymentTerm" id="payment-term-drop-down" onchange="paymentTermChanged()">
										<?php
											foreach ($paymentTerms as $paymentTermItem){
												echo '<option value="' . $paymentTermItem . '">', $paymentTermItem, '</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="priceOthers">
								<input type="text" disabled="disabled" id="other-payment-term" name="otherPaymentTerm" placeholder="OTHER PAYMENT TERM" style="font-size:11px; height:27px;" size="30"/>
							</div>
						</div>
					</div>
				</div>
				<div class="create">
					<input class="createButton" type="submit" value="Create" name="create_supplier">
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