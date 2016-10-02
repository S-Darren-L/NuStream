<?php

/*
Template Name: Edit Supplier Layout
*/

get_header();
?>
<?php
	// Get Supplier ID
	$supplierID = $_GET['SID'];

	// Get Supplier Detail
	$result = get_supplier_detail($supplierID);
	if($result === null)
		echo 'result is null';

	$getSupplierArray = mysqli_fetch_array($result);


	// Update Supplier Detail
	if(isset($_POST['edit_supplier']))
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

//		echo var_dump($updateSupplierArray);

		edit_supplier($updateSupplierArray);
	}
?>
<div style="overflow-x:auto;">
	<form method="post">
		<table class="supplier-temp-table">
			<tr>
				<td class="primary-title" colspan="3"><a>Supplier Name</a></td>
				<td class="name" colspan="3"><input class="input" type="text" name="supplierName" value="<?php echo $getSupplierArray['SupplierName']; ?>"></td>
				<td class="primary-title" colspan="3"><a>HST Number</a></td>
				<td class="number" colspan="6"><input class="input" type="text" name="HSTNumber" value="<?php echo $getSupplierArray['HSTNumber']; ?>"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Contact Name 1</a></td>
				<td class="name" colspan="3"><input class="input" type="text" name="firstContactName" value="<?php echo $getSupplierArray['FirstContactName']; ?>"></td>
				<td class="primary-title" colspan="3"><a>Contact Number 1</a></td>
				<td class="number" colspan="6"><input class="input" type="text" name="firstContactNumber" value="<?php echo $getSupplierArray['FirstContactNumber']; ?>"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Contact Name 2</a></td>
				<td class="name" colspan="3"><input class="input" type="text" name="secondContactName" value="<?php echo $getSupplierArray['SecondContactName']; ?>"></td>
				<td class="primary-title" colspan="3"><a>Contact Number 2</a></td>
				<td class="number" colspan="6"><input class="input" type="text" name="secondContactNumber" value="<?php echo $getSupplierArray['SecondContactNumber']; ?>"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3" rowspan="2"><a>Supplier Type</a></td>
				<td class="small-sub-title" colspan="2"><a>Staging</a></td>
				<td class="radio"><input type="radio" name="supplierType" <?php echo ($getSupplierArray['SupplierType']=="STAGING")  ? 'checked':'';?>  value="STAGING"></td>
				<td class="small-sub-title" colspan="2"><a>Photography</a></td>
				<td class="radio"><input type="radio" name="supplierType" <?php echo ($getSupplierArray['SupplierType']=="PHOTOGRAPHY")  ? 'checked':'';?>  value="PHOTOGRAPHY"></td>
				<td class="small-sub-title" colspan="2"><a>Clean up</a></td>
				<td class="radio"><input type="radio" name="supplierType" <?php echo ($getSupplierArray['SupplierType']=="CLEANUP")  ? 'checked':'';?>  value="CLEANUP"></td>
				<td class="small-sub-title" colspan="2"><a>Relocation home</a></td>
				<td class="radio"><input type="radio" name="supplierType" <?php echo ($getSupplierArray['SupplierType']=="RELOCATIONHOME")  ? 'checked':'';?>  value="RELOCATIONHOME"></td>
			</tr>
			<tr>
				<td class="small-sub-title" colspan="2"><a>Touch up</a></td>
				<td class="radio"><input type="radio" name="supplierType" <?php echo ($getSupplierArray['SupplierType']=="TOUCHUP")  ? 'checked':'';?> value="TOUCHUP"></td>
				<td class="small-sub-title" colspan="2"><a>Inspection</a></td>
				<td class="radio"><input type="radio" name="supplierType" <?php echo ($getSupplierArray['SupplierType']=="INSPECTION")  ? 'checked':'';?> value="INSPECTION"></td>
				<td class="small-sub-title" colspan="2"><a>Yardwork</a></td>
				<td class="radio"><input type="radio" name="supplierType" <?php echo ($getSupplierArray['SupplierType']=="YARDWORK")  ? 'checked':'';?>  value="YARDWORK"></td>
				<td class="small-sub-title" colspan="2"><a>Storage</a></td>
				<td class="radio"><input type="radio" name="supplierType" <?php echo ($getSupplierArray['SupplierType']=="STORAGE")  ? 'checked':'';?>  value="STORAGE"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Price Unit</a></td>
				<td class="small-sub-title" colspan="2"><a>by size</a></td>
				<td class="radio"><input type="radio" name="priceUnit" <?php echo ($getSupplierArray['PriceUnit']=="BYSIZE")  ? 'checked':'';?>  value="BYSIZE"></td>
				<td class="small-sub-title" colspan="2"><a>by hour</a></td>
				<td class="radio"><input type="radio" name="priceUnit" <?php echo ($getSupplierArray['PriceUnit']=="BYHOUR")  ? 'checked':'';?>  value="BYHOUR"></td>
				<td class="small-sub-title" colspan="2"><a>by house type</a></td>
				<td class="radio"><input type="radio" name="priceUnit" <?php echo ($getSupplierArray['PriceUnit']=="BYHOUSETYPE")  ? 'checked':'';?>  value="BYHOUSETYPE"></td>
				<td class="small-sub-title" colspan="2"><a>by case</a></td>
				<td class="radio"><input type="radio" name="priceUnit" <?php echo ($getSupplierArray['PriceUnit']=="BYCASE")  ? 'checked':'';?>  value="BYCASE"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Price Per Unit</a></td>
				<td class="" colspan="12"><input class="input" type="text" name="pricePerUnit" value="<?php echo $getSupplierArray['PricePerUnit']; ?>"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Payment Term</a></td>
				<td class="large-sub-title" colspan="3"><a>monthly</a></td>
				<td class="radio"><input type="radio" name="paymentTerm" <?php echo ($getSupplierArray['PaymentTerm']=="MONTHLY")  ? 'checked':'';?> value="MONTHLY" ></td>
				<td class="large-sub-title" colspan="3"><a>semi-monthly</a></td>
				<td class="radio"><input type="radio" name="paymentTerm" <?php echo ($getSupplierArray['PaymentTerm']=="SEMIMONTHLY") ? 'checked':'';?> value="SEMIMONTHLY"></td>
				<td class="large-sub-title" colspan="3"><a>other</a></td>
				<td class="radio"><input type="radio" name="paymentTerm" <?php echo ($getSupplierArray['PaymentTerm']=="OTHER") ? 'checked':'';?> value="OTHER"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Support Location</a></td>
				<td class="" colspan="12"><input class="input" type="text" name="supportLocation" value="<?php echo $getSupplierArray['SupportLocation']; ?>"></td>
			</tr>
			<tr>
				<td class="primary-title" colspan="3"><a>Sample Photos</a></td>
				<td class="" colspan="12"></td>
			</tr>
		</table>
		<input type="submit" value="Update" name="edit_supplier">
	</form>
</div>
<?php
get_footer();

?>