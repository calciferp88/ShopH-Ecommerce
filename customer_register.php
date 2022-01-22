	<?php
	include('header.php');

	$customerid = "";
	$custmervisibleid = "";
	$customername = "";
	$customeremail = "";
	$customerpassword = "";
	$customerphone = "";
	$custmerdateofbirth = "";
	$custmercountry = "";
	$customergender = "";
	$customeraddress = "";
	$customerpostalcode = "";
	$customerstatus = "";

	$emailexists ="";
	$emailchecker = 0;
	$phoneexists = "";
	$phonechecker = 0;
	$wrongpass = "";
	$passchecker = 0;

	$connect = mysqli_connect("localhost", "root", "", "shophdb");
	$select = "SELECT * FROM Customer";
	$run = mysqli_query($connect, $select);
	$num = mysqli_num_rows($run);

	//CUSTOMERID CHECKER
	if($num==0){
		$customerid = 1;
	}
	elseif($num>=1){
		for($a=0;$a<$num;$a++){
			$data1 = mysqli_fetch_array($run);
			$tempid = $data1['CustomerID'];
			if($tempid-1==$a){
				$customerid = $a+2;
			}
			elseif($tempid-1!=$a){
				$customerid = $a+1;
				break;
			}	
		}
	}
		
	// Insert Customer code
	if(isset($_POST['btnRegister'])){
		$custmervisibleid = "";
		$customername = $_POST['customername'];
		$customeremail = $_POST['customeremail'];
		$customerpassword = $_POST['customerpassword'];
		$customerconfirmpassword = $_POST['customerconfirmpassword'];
		$customerphone = $_POST['customerphone'];
		$customerdateofbirth = $_POST['customerdateofbirth'];
		$customercountry = $_POST['customercountry'];
		$customergender = $_POST['customergender'];
		$customeraddress = $_POST['customeraddress'];
		$customerpostalcode = $_POST['customerpostalcode'];	
		$customerstatus = "TRUE";

		//EMAIL EXISTENCE CHECKER
		$select = "SELECT * FROM customer";
		$run = mysqli_query($connect, $select);
		for($i=0;$i<$num;$i++){
			$data1 = mysqli_fetch_array($run);
			$tempemail = $data1['CustomerEmail'];
			if($tempemail==$customeremail){
				$emailexists = "<ul><li></li><li><font color='red'>* Email Already Exists</font></li></ul>";
				$emailchecker = 1;
				break;
			}

			else{
				$emailchecker = 0;
			}
		}

		//PHONE EXISTENCE CHECKER
		$select = "SELECT * FROM customer";
		$run = mysqli_query($connect, $select);
		for($i=0;$i<$num;$i++){
			$data1 = mysqli_fetch_array($run);
			$tempphone = $data1['CustomerPhone'];
			if($tempphone==$customerphone){
				$phoneexists = "<ul><li></li><li><font color='red'>* Phone Already Exists</font></li></ul>";
				$phonechecker = 1;
				break;
			}
			else{
				$phonechecker = 0;
			}
		}

		//PASSWORD CHECKER
		if($customerpassword == $customerconfirmpassword){
			$passchecker = 0;
		}
		else{
			$passchecker = 1;
			$wrongpass = "<ul><li></li><li><font color='red'>* Passwords Do Not Match</font></li></ul>";
		}

		if($phonechecker ==0){
		if($emailchecker ==0){
		if($passchecker == 0){
		$hpass = password_hash($customerpassword, PASSWORD_DEFAULT);
		$insert = "INSERT INTO `customer`(`CustomerID`, `CustomerVisibleID`, `CustomerName`, `CustomerEmail`, `CustomerPassword`, `CustomerPhone`, `CustomerDateofBirth`, `CustomerGender`, `CustomerCountry`, `CustomerPostalCode`, `CustomerAddress`, `CustomerasSeller`, `CustomerPicture`, `CustomerRating`, `CustomerVerification`, `Status`) VALUES ('$customerid','','$customername','$customeremail','$hpass','$customerphone','$customerdateofbirth','$customergender','$customercountry','$customerpostalcode','$customeraddress',NULL,'','', '', '$customerstatus')";

			$run = mysqli_query($connect, $insert);
			if($run){
				echo "<script>alert('Registration Complete');</script>";
				echo "<script>window.location.assign('login.php'); </script>";
			}
			else{
				echo mysqli_error($connect);
			}
		}}}

	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>ShopH | Register </title>

</head>
<body>		

	<div id='Register' class="form-style-5" >



	<h4 class="title" align="center"><span class="text"><strong>Register As</strong> Customer</span></h4>

	<form action='customer_register.php' method='POST' style="font-weight:bold;">

		<ul style="padding-left:35%;">
			<li>Your Name</li>
			<li><input type='text' name='customername' value="<?php echo $customername;?>" required></li>

			<li>Your Email</li>
			<li><input style="padding-right:10%;" type='email' name='customeremail' value="<?php echo $customeremail;?>" required/></li> 
		<?php echo $emailexists;?>

			<li>Password</li>
			<li><input style="padding-right:10%;" type='password' name='customerpassword' placeholder='Enter Password' required/></li>
		<?php echo $wrongpass;?>

			<li>Confirm Password</li>
			<li><input style="padding-right:10%;" type='password' name='customerconfirmpassword' placeholder='Enter Password' required/></li>
		<?php echo $wrongpass;?>

			<li>Phone</li>
			<li><input style="padding-right:10%;" type='text' name='customerphone' value="<?php echo $customerphone;?>" required/></li>
		<?php echo $phoneexists;?>

			<li>Gender</li>
			<li><select name="customergender">
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select></li>

			<li>Date of Birth</li>
			<li><input type="date" name="customerdateofbirth" max="<?= date('Y-m-d'); ?>"></li>

			<li>Country</li>
			<li><select name="customercountry">
					<option value="Myanmar">Myanmar</option>
				</select></li>

			<li>Postal Code</li>
			<li><input style="padding-right:10%;" type='text' name='customerpostalcode' value="<?php echo $customerpostalcode;?>"></li>

			<li>Address</li>
			<li ><input style="padding-bottom:10%; padding-right:10%;" " type='text' name='customeraddress' value="<?php echo $	customeraddress;?>" required/></li>
			
			<li><p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p></li>
		
			<li style="padding-left:15%;"><input tabindex="9" class="btn btn-inverse large" type="submit" name="btnRegister" value="Register"></li>
		</ul>


	</form>

	</div>


</body>
</html>

<?php include('footer.php'); ?>