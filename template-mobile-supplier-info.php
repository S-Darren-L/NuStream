<?php

	// Start Session
	session_start();

	/*
	Template Name: Mobile Supplier Info
	*/

	// Set Sub-menu URL
	$subMenuURL = get_home_url() . "/supplier-info/?SType=";

	$homeURL = get_home_url();
	$mainPath = $homeURL . "/wp-content/themes/NuStream/";
	$goBackImagePath = $mainPath . "img/goBack.png";

	// Get Supplier Type
	$supplierType = $_GET['SType'];
	if($supplierType === null)
		$supplierType = "STAGING";

	// Get All Member Brief Info
	$strdInfoArray = get_supplier_brief_table('STAGING');
	$cledBriefInfoArray = get_supplier_brief_table('CLEANUP');
	$toudBriefInfoArray = get_supplier_brief_table('TOUCHUP');
	$yardBriefInfoArray = get_supplier_brief_table('YARDWORK');
	$reldBriefInfoArray = get_supplier_brief_table('RELOCATEHOME');
	$stodBriefInfoArray = get_supplier_brief_table('STORAGE');
	$insdBriefInfoArray = get_supplier_brief_table('INSPECTION');
	$phodBriefInfoArray = get_supplier_brief_table('PHOTOGRAPHY');

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
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>NUSTREAM</title>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/default.css">
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url');?>/css/styles.css">
	<script type="text/javascript" src="<?php bloginfo('template_url');?>/js/index.js"></script>
	<style>
		.buttonPart button:hover{
			color:white;
			background:black;
			cursor:pointer;
		}
	</style>
</head>
<body>
<div class='infoCentrePage'>
	<div class="goBack">
		<?php echo '<img class="goBackButton" src="' . $goBackImagePath . '">'; ?>
	</div><br/>
	<div class="buttonPart">
		<button class="buttonStyle buttonWhite stagingButtton" id="strd">STAGING</button>
		<button class="buttonStyle buttonWhite claenUpButtton" id="cled">CLEAN UP</button>
		<button class="buttonStyle buttonWhite touchUpButtton" id="toud">TOUCH UP</button>
		<button class="buttonStyle buttonWhite yardWorkButtton" id="yard">YARD WORK</button>
		<button class="buttonStyle buttonWhite relocationButtton" id="reld">RELOCATION HOME</button>
		<button class="buttonStyle buttonWhite storageButtton" id="stod">STORAGE</button>
		<button class="buttonStyle buttonWhite inspectionButtton" id="insd">INSPECTION</button>
		<button class="buttonStyle buttonWhite photographyButtton" id="phod">PHOTOGRAPHY</button>
	</div>


	<div id="strd" style="display:none;">
		<?php
		for($i = 0; $i < count($strdInfoArray); $i++) {
			echo '<div class="infoCentreInfoStyle">';
			echo '<table class="infoCentreInfoTable">';
			echo '<th>', $strdInfoArray[$i]["SupplierName"], '</th>';
			echo '<th>', $strdInfoArray[$i]["SupportLocation"], '</th>';
			echo '<th class="tableBorderColor">', $strdInfoArray[$i]["FirstContactName"], '</br>', $strdInfoArray[$i]["FirstContactNumber"], '</th>';
			echo '</table>';
			echo '</div>';
		}
		?>
	</div>
	<div id="cled" style="display:none;">
		<?php
		for($i = 0; $i < count($cledBriefInfoArray); $i++) {
			echo '<div class="infoCentreInfoStyle">';
			echo '<table class="infoCentreInfoTable">';
			echo '<th>', $cledBriefInfoArray[$i]["SupplierName"], '</th>';
			echo '<th>', $cledBriefInfoArray[$i]["SupportLocation"], '</th>';
			echo '<th class="tableBorderColor">', $cledBriefInfoArray[$i]["FirstContactName"], '</br>', $cledBriefInfoArray[$i]["FirstContactNumber"], '</th>';
			echo '</table>';
			echo '</div>';
		}
		?>
	</div>
	<div id="toud" style="display:none;">
		<?php
		for($i = 0; $i < count($toudBriefInfoArray); $i++) {
			echo '<div class="infoCentreInfoStyle">';
			echo '<table class="infoCentreInfoTable">';
			echo '<th>', $toudBriefInfoArray[$i]["SupplierName"], '</th>';
			echo '<th>', $toudBriefInfoArray[$i]["SupportLocation"], '</th>';
			echo '<th class="tableBorderColor">', $toudBriefInfoArray[$i]["FirstContactName"], '</br>', $toudBriefInfoArray[$i]["FirstContactNumber"], '</th>';
			echo '</table>';
			echo '</div>';
		}
		?>
	</div>
	<div id="yard" style="display:none;">
		<?php
		for($i = 0; $i < count($yardBriefInfoArray); $i++) {
			echo '<div class="infoCentreInfoStyle">';
			echo '<table class="infoCentreInfoTable">';
			echo '<th>', $yardBriefInfoArray[$i]["SupplierName"], '</th>';
			echo '<th>', $yardBriefInfoArray[$i]["SupportLocation"], '</th>';
			echo '<th class="tableBorderColor">', $yardBriefInfoArray[$i]["FirstContactName"], '</br>', $yardBriefInfoArray[$i]["FirstContactNumber"], '</th>';
			echo '</table>';
			echo '</div>';
		}
		?>
	</div>
	<div id="reld" style="display:none;">
		<?php
		for($i = 0; $i < count($reldBriefInfoArray); $i++) {
			echo '<div class="infoCentreInfoStyle">';
			echo '<table class="infoCentreInfoTable">';
			echo '<th>', $reldBriefInfoArray[$i]["SupplierName"], '</th>';
			echo '<th>', $reldBriefInfoArray[$i]["SupportLocation"], '</th>';
			echo '<th class="tableBorderColor">', $reldBriefInfoArray[$i]["FirstContactName"], '</br>', $reldBriefInfoArray[$i]["FirstContactNumber"], '</th>';
			echo '</table>';
			echo '</div>';
		}
		?>
	</div>
	<div id="stod" style="display:none;">
		<?php
		for($i = 0; $i < count($stodBriefInfoArray); $i++) {
			echo '<div class="infoCentreInfoStyle">';
			echo '<table class="infoCentreInfoTable">';
			echo '<th>', $stodBriefInfoArray[$i]["SupplierName"], '</th>';
			echo '<th>', $stodBriefInfoArray[$i]["SupportLocation"], '</th>';
			echo '<th class="tableBorderColor">', $stodBriefInfoArray[$i]["FirstContactName"], '</br>', $stodBriefInfoArray[$i]["FirstContactNumber"], '</th>';
			echo '</table>';
			echo '</div>';
		}
		?>
	</div>
	<div id="insd" style="display:none;">
		<?php
		for($i = 0; $i < count($insdBriefInfoArray); $i++) {
			echo '<div class="infoCentreInfoStyle">';
			echo '<table class="infoCentreInfoTable">';
			echo '<th>', $insdBriefInfoArray[$i]["SupplierName"], '</th>';
			echo '<th>', $insdBriefInfoArray[$i]["SupportLocation"], '</th>';
			echo '<th class="tableBorderColor">', $insdBriefInfoArray[$i]["FirstContactName"], '</br>', $insdBriefInfoArray[$i]["FirstContactNumber"], '</th>';
			echo '</table>';
			echo '</div>';
		}
		?>
	</div>
	<div id="phod" style="display:none;">
		<?php
		for($i = 0; $i < count($phodBriefInfoArray); $i++) {
			echo '<div class="infoCentreInfoStyle">';
			echo '<table class="infoCentreInfoTable">';
			echo '<th>', $phodBriefInfoArray[$i]["SupplierName"], '</th>';
			echo '<th>', $phodBriefInfoArray[$i]["SupportLocation"], '</th>';
			echo '<th class="tableBorderColor">', $phodBriefInfoArray[$i]["FirstContactName"], '</br>', $phodBriefInfoArray[$i]["FirstContactNumber"], '</th>';
			echo '</table>';
			echo '</div>';
		}
		?>
	</div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
	function hideAll() {
		$('#strd').css('display', 'none');
		$('#cled').css('display', 'none');
		$('#toud').css('display', 'none');
		$('#yard').css('display', 'none');
		$('#reld').css('display', 'none');
		$('#stod').css('display', 'none');
		$('#insd').css('display', 'none');
		$('#phod').css('display', 'none');
	}

	$('#strd').on('click', function () {
		hideAll();
		$('#strd').css('display', 'block');
	});
	$('#cled').on('click', function () {
		hideAll();
		$('#cled').css('display', 'block');
	});
	$('#toud').on('click', function () {
		hideAll();
		$('#toud').css('display', 'block');
	});
	$('#yard').on('click', function () {
		hideAll();
		$('#yard').css('display', 'block');
	});
	$('#reld').on('click', function () {
		hideAll();
		$('#reld').css('display', 'block');
	});
	$('#stod').on('click', function () {
		hideAll();
		$('#stod').css('display', 'block');
	});
	$('#insd').on('click', function () {
		hideAll();
		$('#insd').css('display', 'block');
	});
	$('#phod').on('click', function () {
		hideAll();
		$('#phod').css('display', 'block');
	});

</script>
</body>
</html>
