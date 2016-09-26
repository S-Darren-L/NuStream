<?php

/*
Template Name: Supplier Layout
*/

get_header();
?>
<?php
	if(isset($_POST['create_supplier']))
	{
		echo $_POST['supplierName'];
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
			<td class="primary-title" colspan="3"><a>Sample Photos</a></td>
			<td class="" colspan="12"></td>
		  </tr>
		</table>
		<input type="submit" value="click" name="create_supplier">
	</form>
</div>

<?php
$mysqli = mysqli_connect("localhost", "root", "", "nustream");
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}
mysqli_close($mysqli);
?>

<?php
echo "<h2>Your Input:</h2>";
echo $supplierName;
?>
<?php
get_footer();

?>