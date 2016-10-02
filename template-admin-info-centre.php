<?php

/*
Template Name: Admin Info Centre Layout
*/

get_header();
?>
<?php
	//temp
	$supplierType = "STAGING";
	$result = get_supplier_brief_info($supplierType);
	if($result === null)
		echo 'result is null';
	$result_rows = [];
	while($row = mysqli_fetch_array($result))
	{
		$result_rows[] = $row;
	}
	$homeURL = get_home_url();
	echo '<h3>', $table, '</h3>';
	echo '<table cellpadding="0" cellspacing="0" class="admin-info-centre-temp-table">';
	echo '<tr><th class="primary-title">Supplier Name</th><th class="primary-title">Price Per Unit</th><th class="primary-title">Primary Contact Name</th><th class="primary-title">Primary Contact Number</th><th class="primary-title">Support Location</th></tr>';
	for($i = 0; $i < count($result_rows); $i++) {
		$supplierID = $result_rows[$i]["SupplierID"];
//		echo '<td>', $supplierID, '</td>';
		echo '<form method="post">';
		echo '<tr>';
		echo '<td >', '<a href="' . $homeURL . '/edit-supplier/?SID=' . $supplierID . '" />', $result_rows[$i]["SupplierName"], '</td>';
		echo '<td>', $result_rows[$i]["PricePerUnit"], '</td>';
		echo '<td>', $result_rows[$i]["FirstContactName"], '</td>';
		echo '<td>', $result_rows[$i]["FirstContactNumber"], '</td>';
		echo '<td>', $result_rows[$i]["SupportLocation"], '</td>';
		echo '<td>', '<input type="submit" value="View Detail" name="view_supplier_detail">' , '</td>';
		echo '</tr>';
		echo '</form>';
	}
	echo '</table><br />';
	if(isset($_POST['view_supplier_detail'])) {
		echo "try";
//		$supplierID = $_POST['SupplierID'];
		echo $supplierID;
	}
?>
<?php
get_footer();

?>