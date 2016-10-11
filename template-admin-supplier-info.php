<?php

	// Start Session
	session_start();

	/*
	Template Name: Admin Supplier Info
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
	$subMenuURL = $homeURL . "/admin-supplier-info/?SType=";

	// Get Supplier Type
	$supplierType = $_GET['SType'];
	if($supplierType === null)
		$supplierType = "STAGING";

	// Get All Member Brief Info
	$supplerBriefInfoArray = get_supplier_brief_table($supplierType);

	function get_supplier_brief_table($supplierType){
		$result = get_supplier_brief_info($supplierType);
		if($result === null)
			echo 'result is null';
		$result_rows = [];
		while($row = mysqli_fetch_array($result))
		{
			$result_rows[] = $row;
		}
		return $result_rows;
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

	#main{
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
		padding:20px 20px 20px 20px;
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
		color:#a9a9a9;
		font-size:11px;
		text-align:center;
	}

	td {
		color:#a9a9a9;
	}

	.userNamePart {
		color:white;
		text-align: center;
		margin-bottom: 20px;
	}

	.table td {
		font-size:10px;
		vertical-align: middle;
	}

	.table-striped {
		width: 900px !important;
		margin:0 auto;
		padding-top: 0px;
	}

	.topNav {
		height: 20px;
		width: 900px;
		margin: 10px auto;
		background-color: #434343;
		padding:10px 10px 25px 10px;
		text-align: center;
		font-size: 10px;
	}

	.topNav a:link {
		text-decoration: none;
		color:white;
	}

	.topNav a:visited {
		text-decoration: underline;
		color:white;
	}

	.topNav a:hover {
		text-decoration: underline;
		color:white;
	}

	.topNav a:active {
		text-decoration: underline;
		color:white;
	}

	.topNav a {
		padding-left: 20px;
		padding-right: 20px;
		letter-spacing: 0px;
		margin-bottom: 10px;
	}

	.pageNum {
		text-align: center;
	}

	.pageNum a:link{
		font-size: 8px;
		color:black;
		text-decoration:underline;
	}

	.pageNum a:visited{
		color:black;
		text-decoration:underline;
	}

	.pageNum a:hover{
		color:black;
		text-decoration:underline;
	}

	.pageNum a:active{
		color:black;
		text-decoration:underline;
	}

	.table a:link {
		text-decoration: underline;
	}
</style>

<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
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
		<div class="formPart"><!-- There should be a dynamic table-->
			<div class="topNav" style="color:white;">
				<?php
					echo '<a href="' . $subMenuURL . "STAGING" . '" >', 'Stage</a>|';
					echo '<a href="' . $subMenuURL . "PHOTOGRAPHY" . '" >', 'Photography</a>|';
					echo '<a href="' . $subMenuURL . "CLEANUP" . '" >', 'Clean Up</a>|';
					echo '<a href="' . $subMenuURL . "RELOCATEHOME" . '" >', 'Relocate Home</a>|';
					echo '<a href="' . $subMenuURL . "TOUCHUP" . '" >', 'Touch Up</a>|';
					echo '<a href="' . $subMenuURL . "INSPECTION" . '" >', 'Inspection</a>|';
					echo '<a href="' . $subMenuURL . "YARDWORK" . '" >', 'Yard Work</a>|';
					echo '<a href="' . $subMenuURL . "STORAGE" . '" >', 'Storage</a>';
				?>
			</div>
			<table class="table table-striped" style="margin-top:-10px;">
				<thead style="background-color:ffffff;">
				<tr>
					<th>COMPANY NAME</th>
					<th>PRICE</th>
					<th>CONTACT NAME</th>
					<th>CONTACT NUMBER</th>
					<th>SUPPORT AREA</th>
					<th>DETAILS</th>
				</tr>
				</thead>
				<tbody>
				<?php
					for($i = 0; $i < count($supplerBriefInfoArray); $i++) {
						$supplierID = $supplerBriefInfoArray[$i]["SupplierID"];
						echo '<tr>';
							echo '<td >', $supplerBriefInfoArray[$i]["SupplierName"], '</td>';
							echo '<td>', $supplerBriefInfoArray[$i]["PricePerUnit"], '</td>';
							echo '<td>', $supplerBriefInfoArray[$i]["FirstContactName"], '</td>';
							echo '<td>', $supplerBriefInfoArray[$i]["FirstContactNumber"], '</td>';
							echo '<td>', $supplerBriefInfoArray[$i]["SupportLocation"], '</td>';
							echo '<td>', '<a href="' . $homeURL . '/admin-edit-supplier/?SID=' . $supplierID . '" >VIEW</a>', '</td>';
						echo '</tr>';
					}
				?>
				</tbody>
			</table>
			<div class="pageNum"><a href="#">BACK</a>&nbsp;&nbsp;&nbsp;<a href="#">NEXT</a></div>
		</div>
	</div>
</div>
</body>
