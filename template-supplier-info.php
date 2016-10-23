<?php

	// Start Session
	session_start();

	/*
	Template Name: Supplier Info
	*/

	// Set Sub-menu URL
	$subMenuURL = get_home_url() . "/supplier-info/?SType=";

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
                                <div class="ICATitle">
					<p class="titleSize"><strong>SUPPLIER INFO</strong></p>
				</div>
			<div class="ICATopNav">
				<?php
					echo '<a href="' . $subMenuURL . "STAGING" . '" >', 'STAGING</a>|';
					echo '<a href="' . $subMenuURL . "PHOTOGRAPHY" . '" >', 'PHOTOGRAPHY</a>|';
					echo '<a href="' . $subMenuURL . "CLEANUP" . '" >', 'ClEAN UP</a>|';
					echo '<a href="' . $subMenuURL . "RELOCATEHOME" . '" >', 'RRLOCATE HOME</a>|';
					echo '<a href="' . $subMenuURL . "TOUCHUP" . '" >', 'TOUCH UP</a>|';
					echo '<a href="' . $subMenuURL . "INSPECTION" . '" >', 'INSPECTION</a>|';
					echo '<a href="' . $subMenuURL . "YARDWORK" . '" >', 'YARD WORK</a>|';
					echo '<a href="' . $subMenuURL . "STORAGE" . '" >', 'STORAGE</a>';
				?>
			</div>
			<table class="ICATable">
				<thead>
				<tr>
					<th class="ICATTableWidth ICATablePadding">COMPANY NAME</th>
					<th class="ICATableSmallWidth">PRICE</th>
					<th class="ICATTableWidth">CONTACT NAME</th>
					<th class="ICATTableWidth">CONTACT NUMBER</th>
					<th class="ICATTableWidth">SUPPORT AREA</th>
					<th>DETAILS</th>
				</tr>
				</thead>
				<tbody>
				<?php
					for($i = 0; $i < count($supplerBriefInfoArray); $i++) {
						$supplierID = $supplerBriefInfoArray[$i]["SupplierID"];
						echo '<tr>';
							echo '<td class="ICATablePadding">', $supplerBriefInfoArray[$i]["SupplierName"], '</td>';
							echo '<td>', $supplerBriefInfoArray[$i]["PricePerUnit"], '</td>';
							echo '<td>', $supplerBriefInfoArray[$i]["FirstContactName"], '</td>';
							echo '<td>', $supplerBriefInfoArray[$i]["FirstContactNumber"], '</td>';
							echo '<td>', $supplerBriefInfoArray[$i]["SupportLocation"], '</td>';
							echo '<td>', '<a href="' . get_home_url() . '/admin-edit-supplier/?SID=' . $supplierID . '" >VIEW</a>', '</td>';
						echo '</tr>';
					}
				?>
				</tbody>
			</table>
			<div class="ICAPageNum"><a href="#">BACK</a>&nbsp;&nbsp;&nbsp;<a href="#">NEXT</a></div>
		</div>
	</div>
</div>
<script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
