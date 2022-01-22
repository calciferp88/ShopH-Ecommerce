<?php 
	include('header.php');

	$connect = mysqli_connect('localhost','root','','shophdb');

	$tempemail = $_SESSION['user'];

	$select = "SELECT * FROM customer WHERE CustomerEmail='$tempemail'";
	$run = mysqli_query($connect, $select);
	$data = mysqli_fetch_array($run);

	$customerid = $data['CustomerID'];
	$customername = $data['CustomerName'];
	$customeremail = $data['CustomerEmail'];
	$customerphone = $data['CustomerPhone'];
	$customergender = $data['CustomerGender'];
	$customerdateofbirth = $data['CustomerDateofBirth'];
	$customercountry = $data['CustomerCountry'];
	$customerpostalcode = $data['CustomerPostalCode'];
	$customeraddress = $data['CustomerAddress'];
	$customerasseller = $data['CustomerasSeller'];

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

	// Edit this
	if(isset($_GET['btnSave'])){
		$editchecker = 0;
		$cname = $_GET['customername'];
		$cemail = $_GET['customeremail'];
		$cphone = $_GET['customerphone'];
		$cpc = $_GET['customerpostalcode'];
		$ca = $_GET['customeraddress'];
		$customername = $cname;
		$customeremail = $cemail;
		$customerphone = $cphone;
		$customerpostalcode = $cpc;
		$customeraddress = $ca;
		$update = "UPDATE Customer SET CustomerName='$cname', CustomerEmail='$cemail', CustomerPhone='$cphone', CustomerPostalCode='$cpc', CustomerAddress='$ca' WHERE CustomerID='$customerid'";
		$run    = mysqli_query($connect, $update);
		if($run){
			echo "<script>
					alert('Updated Information');   
				</script>";
		}else{
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Details | ShopH</title>
</head>
<body>

	<div id='Register' class="form-style-5">
	<form action='customer_details.php' method='GET' align="center">
	<h4 class="title" align="center"><span class="text"><strong>User </strong>Details</span></h4>
		<ul>
			<li>Name</li>
			<li><input type='text' name='customername' value="<?php echo $customername;?>" 
				<?php if($editchecker==0){ echo "readonly";}?>/></li>
		</ul>
		<ul>
			<li>Email</li>
			<li><input type='email' name='customeremail' value="<?php echo $customeremail;?>"
				<?php if($editchecker==0){ echo "readonly";} ?>/></li> 
		</ul>
		<!-- email exit or not  -->
		<?php echo $emailexists;?>
		<?php if($editchecker==1){
		echo "<ul>
				<li>Password</li>
				<li><input type='password' name='sellerpassword' placeholder='Enter Password'/></li>
			</ul>";
		echo $wrongpass;
		echo "<ul>
			<li>Confirm Password</li>
			<li><input type='password' name='sellerconfirmpassword' placeholder='Enter Password'/></li>
			</ul>";
		echo $wrongpass;
		}?>
		<ul>
			<li>Phone</li>
			<li><input type='text' name='customerphone' value="<?php echo $customerphone;?>"
				<?php if($editchecker==0){ echo "readonly";} ?>/></li>
		</ul>
		<?php echo $phoneexists;?>
		<ul>
			<li>Country</li>
			<?php if($editchecker==0){ echo "<li><input type='text' name='customercountry' value='$customercountry' readonly/></li>";} 
				elseif($editchecker==1){
					echo "<li><select name='customercountry'>
					<option value='Myanmar'>Myanmar</option>>
					</select></li>";
				}
			?>

		</ul>
		<ul>
			<li>Date of Birth</li>
			<li><input type='text' name='customerdateofbirth' value="<?php echo $customerdateofbirth;?>" readonly/></li>
		</ul>
		<ul>
			<li>Gender</li>
			<li><input type='text' name='customergender' value="<?php echo $customergender;?>" readonly/></li>
		</ul>
		<ul>
			<li>Postal Code</li>	
			<li><input type='text' name='customerpostalcode' value="<?php echo $customerpostalcode;?>"
				<?php if($editchecker==0){ echo "readonly";} ?>/></li>
		</ul>
		<ul>
			<li>Address</li>
			<li><input type='text' name='customeraddress' value="<?php echo $customeraddress;?>"
				<?php if($editchecker==0){ echo "readonly";} ?>/></li>
		</ul>
		<ul><td colspan="3">
			<?php 
				if($customerasseller == 1){

				}

				else{
					echo "<p>Want to be a seller? <a href='./seller_register.php'>Register as seller</a>.</p>";
				}
			?>
		</li></ul>
		<ul>
			<?php 
				if($editchecker==0){
					echo "<td colspan='3' style='text-align:center;'><input tabindex='9' class='btn btn-inverse large' type='submit' name='btnEdit' value='Edit Details'></div></li>";
				}
				elseif($editchecker ==1){
					echo "<td colspan='3' style='text-align:center;'><input tabindex='9' class='btn btn-inverse large' type='submit' name='btnSave' value='Save'></div></li>";
				}
			?>
			</ul>
	</table>
	</form>
     <?php include('footer.php'); ?> 
	</div>

</body>
</html>
