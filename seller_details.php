<?php 
	include('seller_header.php');
	include('script\functions.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

	$tempemail = $_SESSION['user'];

	$select = "SELECT * FROM Seller WHERE SellerEmail='$tempemail'";
	$run = mysqli_query($connect, $select);
	$data = mysqli_fetch_array($run);

	$sellerid = $data['SellerID'];
	$sellercompany = $data['SellerCompany'];
	$selleremail = $data['SellerEmail'];
	$sellerpassword = $data['SellerPassword'];
	$sellerphone = $data['SellerPhone'];
	$sellerlogo = $data['SellerID'];
	$sellercountry = $data['SellerCountry'];
	$sellerpostalcode = $data['SellerPostalCode'];
	$selleraddress = $data['SellerAddress'];

	$emailexists ="";
	$emailchecker = 0;
	$phoneexists = "";
	$phonechecker = 0;
	$wrongpass = "";
	$passchecker = 0;

	$editchecker = 0;
	if(isset($_GET['btnEdit'])){
		$editchecker = 1;

	}
	if(isset($_GET['btnSave'])){
		$editchecker = 0;

	}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div id='Register' class="form-style-5">
	<form action='seller_details.php' method='GET'>
	<h4 class="title" align="center"><span class="text"><strong>User </strong>Details</span></h4>
	<table align="center">
		<tr>
			<td>Company Name</td>
			<td><input type='text' name='sellercompany' value="<?php echo $sellercompany;?>" 
				<?php if($editchecker==0){ echo "readonly";}?>/></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type='email' name='selleremail' value="<?php echo $selleremail;?>"
				<?php if($editchecker==0){ echo "readonly";} ?>/></td> 
		</tr>
		<?php echo $emailexists;?>
		<?php if($editchecker==1){
		echo "<tr>
				<td>Password</td>
				<td><input type='password' name='sellerpassword' placeholder='Enter Password'/></td>
			</tr>";
		echo $wrongpass;
		echo "<tr>
			<td>Confirm Password</td>
			<td><input type='password' name='sellerconfirmpassword' placeholder='Enter Password'/></td>
			</tr>";
		echo $wrongpass;
		}?>
		<tr>
			<td>Phone</td>
			<td><input type='text' name='sellerphone' value="<?php echo $sellerphone;?>"
				<?php if($editchecker==0){ echo "readonly";} ?>/></td>
		</tr>
		<?php echo $phoneexists;?>
		<tr>
			<td>Logo</td>
			<td><input type="file" name="sellerlogo"></td>
		</tr>
		<tr>
			<td>Country</td>
			<?php if($editchecker==0){ echo "<td><input type='text' name='sellercountry' value='$sellercountry' readonly/></td>";} 
				elseif($editchecker==1){
					echo "<td><select name='sellercountry'>
					<option value='China'>China</option>
					<option value='Myanmar'>Myanmar</option>
					<option value='Singapore'>Singapore</option>
					</select></td>";
				}
			?>

		</tr>
		<tr>
			<td>Postal Code</td>
			<td><input type='text' name='sellerpostalcode' value="<?php echo $sellerpostalcode;?>"
				<?php if($editchecker==0){ echo "readonly";} ?>/></td>
		</tr>
		<tr>
			<td>Address</td>
			<td><input type='text' name='selleraddress' value="<?php echo $selleraddress;?>"
				<?php if($editchecker==0){ echo "readonly";} ?>/></td>
		</tr>
		<tr>
			<?php 
				if($editchecker==0){
					echo "<td colspan='3' style='text-align:center;'><input tabindex='9' class='btn btn-inverse large' type='submit' name='btnEdit' value='Edit Details'></div></td>";
				}
				elseif($editchecker ==1){
					echo "<td colspan='3' style='text-align:center;'><input tabindex='9' class='btn btn-inverse large' type='submit' name='btnSave' value='Save'></div></td>";
				}
			?>
			</tr>
	</table>
	</form>

	</div>

</body>
</html>
<?php include('footer.php'); ?>