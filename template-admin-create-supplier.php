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
	$supplierInfoURL = get_home_url() . '/admin-info-centre';

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

	if(isset($_POST['create_supplier']))
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
				"supportLocation" => $_POST['supportLocation']);

			$result = create_supplier($createSupplierArray);

			$result_rows = [];
			while($row = mysqli_fetch_array($result))
			{
				$result_rows[] = $row;
			}
			$supplierID = $result_rows[0]["LAST_INSERT_ID()"];
			$url = get_home_url() . '/upload-files/?UType=Supplier&UID=' . $supplierID;

			if(!is_null($result) && $result !== false)
			{
				echo ("<script>window.location.assign(' . $url');</script>");
			}
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
		padding-top: 1px;
		padding-left: 15px;
		background-color: #eeeeee;
		color:#a9a9a9;
		height: 350px;
		width: 600px;
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

	.basicInfo {

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
		margin-left: 200px;
		margin-top: -212px;
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
	}

	.selectPriceUnit select {
		border-radius: 3px;
		height: 28px;
		width: 164px;
	}

	.selectPaymentTeam {
		float: left;
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
	}

	.priceOthers {
		margin-top: 10px;
		margin-left: 174px;
	}

	.ba{
		float: left;
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
		<div class="logo"><?php
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
			<div class="title"><h4>CREATE NEW SUPPLIER</h4></div>
			<form method="post">
				<div class="form-group inputPart">
					<div class="basicInfo">
						<div class="subTitle"><h5>BASIC INFOTMATION</h5></div>
						<div class="line" >
							<hr style="height:1px; width:565px;border:none;border-top:1px solid #a9a9a9; float:left; margin:2px 5px 15px 0px;" />
						</div>
						<div class="inputContent">
							<div class="ba">
								<input type="text" placeholder="SUPPLIER NAME*" style="font-size:11px; height:27px;" size="22" require/>
							</div>
							<div class="selectServerType">
								<div class="dropdown">
									<select>
										<option value="1">SELECTEAM</option>
										<option value="2">ONE</option>
									</select>
								</div>
							</div>
							<div class="HSTNumber">
								<input type="text" placeholder="HST NUMBER*" style="font-size:11px; height:27px;" size="30" require/>
							</div>
						</div>
					</div>
					<div class="contactAndPrice">
						<div class="contantInfo">
							<div class="subTitle" style="margin-top:20px;"><h5>CONTACT INFOTMATION</h5></div>
							<input type="text" value="CONTACT PERSON 1*" style="font-size:11px; margin-bottom:10px; margin-top:10px; height:27px;" size="30" require />
							<input type="text" value="CONTACT PERSON 1*" style="font-size:11px; margin-bottom:25px; height:27px;" size="30" require />
							<input type="text" value="CONTACT PERSON 1*" style="font-size:11px; margin-bottom:10px; height:27px;" size="30" require />
							<input type="text" value="CONTACT PERSON 1*" style="font-size:11px; margin-bottom:10px; height:27px;" size="30" require />
						</div>
						<div class="priceInfo">
							<div class="subTitle" style="margin-top:20px; width:400px; margin-bottom:13px;"><h5>PRICE INFOTMATION</h5></div>
							<div class="selectPriceUnit">
								<div class="dropdown">
									<select>
										<option value="1">PRICE UNIT*</option>
										<option value="2">CDA</option>
									</select>
								</div>
							</div>
							<div class="pricePerUnit">
								<input type="text" placeholder="PRICE PER UNIT*" style="font-size:11px; height:27px;" size="30" require/>
							</div>
							<div class="selectPaymentTeam">
								<div class="dropdown">
									<select>
										<option value="1">PAYMENT TEAM</option>
										<option value="2">LOL</option>
									</select>
								</div>
							</div>
							<div class="priceOthers">
								<input type="text" placeholder="IF OTHER PLEASE INDICATE" style="font-size:11px; height:27px;" size="30" require/>
							</div>
						</div>
					</div>
				</div>
				<div class="create">
					<button class="createButton">CREATE</button>
				</div>
			</form>
		</div>
	</div>
</div>
</body>



<!---->
<!---->
<!---->
<!--<div style="overflow-x:auto;">-->
<!--	<form method="post">-->
<!--		<table class="supplier-temp-table">-->
<!--			<tr>-->
<!--				<td class="primary-title" colspan="3"><a>Supplier Name</a></td>-->
<!--				<td class="name" colspan="3"><input class="input" type="text" name="supplierName"></td>-->
<!--				<td class="primary-title" colspan="3"><a>HST Number</a></td>-->
<!--				<td class="number" colspan="6"><input class="input" type="text" name="HSTNumber"></td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td class="primary-title" colspan="3"><a>Contact Name 1</a></td>-->
<!--				<td class="name" colspan="3"><input class="input" type="text" name="firstContactName"></td>-->
<!--				<td class="primary-title" colspan="3"><a>Contact Number 1</a></td>-->
<!--				<td class="number" colspan="6"><input class="input" type="text" name="firstContactNumber"></td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td class="primary-title" colspan="3"><a>Contact Name 2</a></td>-->
<!--				<td class="name" colspan="3"><input class="input" type="text" name="secondContactName"></td>-->
<!--				<td class="primary-title" colspan="3"><a>Contact Number 2</a></td>-->
<!--				<td class="number" colspan="6"><input class="input" type="text" name="secondContactNumber"></td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td class="primary-title" colspan="3" rowspan="2"><a>Supplier Type</a></td>-->
<!--				<td class="small-sub-title" colspan="2"><a>Staging</a></td>-->
<!--				<td class="radio"><input type="radio" name="supplierType" value="STAGING"></td>-->
<!--				<td class="small-sub-title" colspan="2"><a>Photography</a></td>-->
<!--				<td class="radio"><input type="radio" name="supplierType" value="PHOTOGRAPHY"></td>-->
<!--				<td class="small-sub-title" colspan="2"><a>Clean up</a></td>-->
<!--				<td class="radio"><input type="radio" name="supplierType" value="CLEANUP"></td>-->
<!--				<td class="small-sub-title" colspan="2"><a>Relocate home</a></td>-->
<!--				<td class="radio"><input type="radio" name="supplierType" value="RELOCATEHOME"></td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td class="small-sub-title" colspan="2"><a>Touch up</a></td>-->
<!--				<td class="radio"><input type="radio" name="supplierType" value="TOUCHUP"></td>-->
<!--				<td class="small-sub-title" colspan="2"><a>Inspection</a></td>-->
<!--				<td class="radio"><input type="radio" name="supplierType" value="INSPECTION"></td>-->
<!--				<td class="small-sub-title" colspan="2"><a>Yardwork</a></td>-->
<!--				<td class="radio"><input type="radio" name="supplierType" value="YARDWORK"></td>-->
<!--				<td class="small-sub-title" colspan="2"><a>Storage</a></td>-->
<!--				<td class="radio"><input type="radio" name="supplierType" value="STORAGE"></td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td class="primary-title" colspan="3"><a>Price Unit</a></td>-->
<!--				<td class="small-sub-title" colspan="2"><a>by size</a></td>-->
<!--				<td class="radio"><input type="radio" name="priceUnit" value="BYSIZE"></td>-->
<!--				<td class="small-sub-title" colspan="2"><a>by hour</a></td>-->
<!--				<td class="radio"><input type="radio" name="priceUnit" value="BYHOUR"></td>-->
<!--				<td class="small-sub-title" colspan="2"><a>by house type</a></td>-->
<!--				<td class="radio"><input type="radio" name="priceUnit" value="BYHOUSETYPE"></td>-->
<!--				<td class="small-sub-title" colspan="2"><a>by case</a></td>-->
<!--				<td class="radio"><input type="radio" name="priceUnit" value="BYCASE"></td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td class="primary-title" colspan="3"><a>Price Per Unit</a></td>-->
<!--				<td class="" colspan="12"><input class="input" type="text" name="pricePerUnit"></td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td class="primary-title" colspan="3"><a>Payment Term</a></td>-->
<!--				<td class="large-sub-title" colspan="3"><a>monthly</a></td>-->
<!--				<td class="radio"><input type="radio" name="paymentTerm" value="MONTHLY"></td>-->
<!--				<td class="large-sub-title" colspan="3"><a>semi-monthly</a></td>-->
<!--				<td class="radio"><input type="radio" name="paymentTerm" value="SEMIMONTHLY"></td>-->
<!--				<td class="large-sub-title" colspan="3"><a>other</a></td>-->
<!--				<td class="radio"><input type="radio" name="paymentTerm" value="OTHER"></td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td class="primary-title" colspan="3"><a>Support Location</a></td>-->
<!--				<td class="" colspan="12"><input class="input" type="text" name="supportLocation"></td>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<td class="primary-title" colspan="3"><a>Sample Photos</a></td>-->
<!--				<td class="" colspan="12"></td>-->
<!--			</tr>-->
<!--		</table>-->
<!--		<input type="submit" value="Create" name="create_supplier">-->
<!--	</form>-->
<!--</div>-->