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
	else
		echo mysqli_num_rows($result);
	$result_rows = [];
	while($row = mysqli_fetch_array($result))
	{
		$result_rows[] = $row;
	}

	//test
	$js_result_array = json_encode($result_rows);
	echo $js_result_array;
	echo count($js_result_array);
	echo count(json_decode($js_result_array, true));
?>
<div style="overflow-x:auto;">
	<table id="admin-info-centre-temp-table">
		<thead>
		<tr>
			<th class=""><a>Supplier Name</a></th>
			<th class=""><a>Price Per Unit</a></th>
			<th class=""><a>Primary Contact Name</a></th>
			<th class=""><a>Primary Contact Number</a></th>
			<th class=""><a>Support Location</a></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		</tbody>
	</table>
	<script type="text/javascript">
		var suppliers = [<?php echo json_encode($result_rows); ?>];
		var suppliers_array = [];
		for(var i in suppliers)
			suppliers_array[i] = $.map(suppliers[i],function(v) {
				return v;
		alert(suppliers_array.length);
		// Call addRow() with the ID of a table
		addRow('admin-info-centre-temp-table', suppliers);
	</script>
</div>
<?php
get_footer();

?>