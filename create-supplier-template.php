<?php

/*
Template Name: Create Supplier Layout
*/

get_header();
?>
<?php
	if(isset($_POST['create_supplier']))
	{
		$createSupplierArray = array (
			"supplierName" => $_POST['supplierName'],
			"HSTNumber" => $_POST['HSTNumber'],
			"firstContactName" => $_POST['firstContactName'],
			"firstContactNumber" => $_POST['firstContactNumber'],
			"secondContactName" => $_POST['secondContactName'],
			"secondContactNumber" => $_POST['secondContactNumber'],
			"priceUnit" => $_POST['priceUnit'],
			"pricePerUnit" => $_POST['pricePerUnit'],
			"paymentTerm" => $_POST['paymentTerm'],
			"supportLocation" => $_POST['supportLocation']);

		create_supplier($createSupplierArray);
	}
?>
<div style="overflow-x:auto;">
	<form method="post">
		<table class="supplier-temp-table">
			<tr>
				<td class="primary-title" colspan="3"><a>Supplier Name</a></td>
				<td class="name" colspan="3"><input class="input" type="text" name="supplierName"></td>
				<td class="primary-title" colspan="3"><a>HST Number</a></td>
				<td class="number" colspan="6"><input class="input" type="text" name="HSTNumber"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Contact Name 1</a></td>
				<td class="name" colspan="3"><input class="input" type="text" name="firstContactName"></td>
				<td class="primary-title" colspan="3"><a>Contact Number 1</a></td>
				<td class="number" colspan="6"><input class="input" type="text" name="firstContactNumber"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Contact Name 2</a></td>
				<td class="name" colspan="3"><input class="input" type="text" name="secondContactName"></td>
				<td class="primary-title" colspan="3"><a>Contact Number 2</a></td>
				<td class="number" colspan="6"><input class="input" type="text" name="secondContactNumber"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Price Unit</a></td>
				<td class="small-sub-title" colspan="2"><a>by size</a></td>
				<td class="radio"><input type="radio" name="priceUnit"></td>
				<td class="small-sub-title" colspan="2"><a>by hour</a></td>
				<td class="radio"><input type="radio" name="priceUnit"></td>
				<td class="small-sub-title" colspan="2"><a>by house type</a></td>
				<td class="radio"><input type="radio" name="priceUnit"></td>
				<td class="small-sub-title" colspan="2"><a>by case</a></td>
				<td class="radio"><input type="radio" name="priceUnit"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Price Per Unit</a></td>
				<td class="" colspan="12"><input class="input" type="text" name="pricePerUnit"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Payment Term</a></td>
				<td class="large-sub-title" colspan="3"><a>monthly</a></td>
				<td class="radio"><input type="radio" name="paymentTerm"></td>
				<td class="large-sub-title" colspan="3"><a>semi-monthly</a></td>
				<td class="radio"><input type="radio" name="paymentTerm"></td>
				<td class="large-sub-title" colspan="3"><a>other</a></td>
				<td class="radio"><input type="radio" name="paymentTerm"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Support Location</a></td>
				<td class="" colspan="12"><input class="input" type="text" name="supportLocation"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Sample Photos</a></td>
				<td class="" colspan="12"></td>
			</tr>
		</table>
		<input type="submit" value="click" name="create_supplier">
	</form>
</div>
<?php
get_footer();

?>