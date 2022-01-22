<?php
	include('seller_header.php');
	include('script\functions.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

	$productname = "";
	$productprice = "";
	$productquantity = "";
	$productbrand = "";
	$productcategory = "";
	$uploaddate = "";


	if(isset($_GET['btnUpload'])){
		$productid = ID_MAKER('Product', 'ProductID');
		$productname = $_GET['productname'];
		$productprice = $_GET['productprice'];
		$productquantity = $_GET['productquantity'];
		$productbrand = $_GET['productbrand'];
		$productcategory = $_GET['productcategory'];
		$uploaddate = "";
		$selleremail = $_SESSION['user'];

		$sellerid = ATTRIBUTE_EXTRACTOR('Seller', 'SellerEmail', $selleremail, 'SellerID');
		$categoryid = ATTRIBUTE_EXTRACTOR('Category', 'CategoryName', $productcategory, 'CategoryID');
		$brandid = ATTRIBUTE_EXTRACTOR('Brand', 'BrandName', $productbrand, 'BrandID');

		$insertproduct = "INSERT INTO Product VALUES ('$productid','$productname', '', '$productprice', '$productquantity', '', '', '$sellerid', '$categoryid', '$brandid', '', '', '', '', '', '', '', '', '')";
		$run = mysqli_query($connect, $insertproduct);

			if($run){
				echo "<script>
				alert('Insert Successful');
				window.location.assign('add_product.php');
				</script>";
			}
			else{
				echo mysqli_error($connect);
		}
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<section class="header_text sub">
		<h4><span>Add Product</span></h4>
	</section>	
	

	<div id='add_product' class="form-style-5">
	<form action='' method='GET'>
	<h4 class="title" align="center"><span class="text"><strong>Product</strong> Form</span></h4>
	<table align="center">
		<tr>
			<td>Product Name</td>
			<td><input type='text' name='productname' value="<?php echo $productname;?>" required></td>
		</tr>
		<tr>
			<td>Price</td>
			<td><input type='number' name='productprice' value="<?php echo $productprice;?>" required/></td> 
		</tr>
		<tr>
			<td>Quantity</td>
			<td><input type='number' name='productquantity' required/></td>
		</tr>
		<tr>
			<td>Category</td>
			<td><select name="productcategory">

				<?php 
					$select = "SELECT * FROM Category";
					$run = mysqli_query($connect, $select);
					$count = mysqli_num_rows($run);

					for ($i=0;$i<$count;$i++){
						$row = mysqli_fetch_array($run);
						$ID = $row['CategoryID'];
						$Name = $row['CategoryName'];
					echo "
						<option value='$Name'>$Name</option>";
					};
				?>
				</select></td>
		</tr>
		<tr>
			<td>Brand</td>
			<td><select name="productbrand">
				<?php 
					$select = "SELECT * FROM Brand";
					$run = mysqli_query($connect, $select);
					$count = mysqli_num_rows($run);

					for ($i=0;$i<$count;$i++){
						$row = mysqli_fetch_array($run);
						$ID = $row['BrandID'];
						$Name = $row['BrandName'];
					echo "
						<option value='$Name'>$Name</option>";
					};
				?>
				</select></td>
		</tr>
		<tr>
			<td>Product Picture</td>
			<td><input type="file" name="productpicture0"></td>
		</tr>
		<tr>
			<td>Shipping From</td>
			<td><select name="sellercountry">
					<option value="China">China</option>
					<option value="Myanmar">Myanmar</option>
					<option value="Singapore">Singapore</option>
				</select></td>
		</tr>
		<tr><td colspan="3">
			<p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
		</td></tr>
		<tr><td colspan="3" style="text-align:center;"><input tabindex="9" class="btn btn-inverse large" type="submit" name="btnUpload" value="Upload"></div></td></tr>
	</table>
	</form>

	</div>

</body>
</html>

<?php include('footer.php');?>