<?php
	include('header.php');

	$sellerid = "";
	$sellercompany = "";
	$selleremail = "";
	$sellerpassword = "";
	$sellerphone = "";
	$sellerlogo = "";
	$sellercountry = "";
	$sellerpostalcode = "";
	$selleraddress = "";

	$emailexists ="";
	$emailchecker = 0;
	$phoneexists = "";
	$phonechecker = 0;
	$wrongpass = "";
	$passchecker = 0;

	$connect = mysqli_connect("localhost", "root", "", "shophdb");
	$select = "SELECT * FROM seller";
	$run = mysqli_query($connect, $select);
	$num = mysqli_num_rows($run);

	//SELLERID CHECKER
	if($num==0){
		$sellerid = 1;
	}
	elseif($num>=1){
		for($a=0;$a<$num;$a++){
			$data1 = mysqli_fetch_array($run);
			$tempid = $data1['SellerID'];
			if($tempid-1==$a){
				$sellerid = $a+2;
			}
			elseif($tempid-1!=$a){
				$sellerid = $a+1;
				break;
			}
		}
	}

	if(isset($_POST['btnRegister'])){
		$sellercompany = $_POST['sellercompany'];
		$selleremail = $_POST['selleremail'];
		$sellerpassword = $_POST['sellerpassword'];
		$sellerconfirmpassword = $_POST['sellerconfirmpassword'];
		$sellerphone = $_POST['sellerphone'];
		$sellerlogo = $_POST['sellerlogo'];
		$sellercountry = $_POST['sellercountry'];
		$sellerpostalcode = $_POST['sellerpostalcode'];
		$selleraddress = $_POST['selleraddress'];

		//EMAIL EXISTENCE CHECKER
		$select = "SELECT * FROM seller";
		$run = mysqli_query($connect, $select);
		for($i=0;$i<$num;$i++){
			$data1 = mysqli_fetch_array($run);
			$tempemail = $data1['SellerEmail'];
			if($tempemail==$selleremail){
				$emailexists = "<tr><td></td><td><font color='red'>* Email Already Exists</font></td></tr>";
				$emailchecker = 1;
				break;
			}
			else{
				$emailchecker = 0;
			}
		}

		//PHONE EXISTENCE CHECKER
		$select = "SELECT * FROM seller";
		$run = mysqli_query($connect, $select);
		for($i=0;$i<$num;$i++){
			$data1 = mysqli_fetch_array($run);
			$tempphone = $data1['SellerPhone'];
			if($tempphone==$sellerphone){
				$phoneexists = "<tr><td></td><td><font color='red'>* Phone Already Exists</font></td></tr>";
				$phonechecker = 1;
				break;
			}
			else{
				$phonechecker = 0;
			}
		}

		//PASSWORD CHECKER
		if($sellerpassword == $sellerconfirmpassword){
			$passchecker = 0;
		}
		else{
			$passchecker = 1;
			$wrongpass = "<tr><td></td><td><font color='red'>* Passwords Do Not Match</font></td></tr>";
		}

		if($phonechecker ==0){
		if($emailchecker ==0){
		if($passchecker == 0){
			$hpass = password_hash($sellerpassword, PASSWORD_DEFAULT);
			$insert = "INSERT INTO `seller`(`SellerID`, `SellerCompany`, `SellerEmail`, `SellerPassword`, `SellerPhone`, `SellerLogo`, `SellerCountry`, `SellerPostalCode`, `SellerAddress`) VALUES ('$sellerid','$sellercompany','$selleremail','$hpass','$sellerphone','$sellerlogo','$sellercountry','$sellerpostalcode','$selleraddress')";
			$run = mysqli_query($connect, $insert);
			if($run){
				echo "<script>alert('Save');</script>";
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
	<title></title>

</head>
<body>	

			<section class="header_text sub">
				<h4><span>Register As Seller</span></h4>
			</section>	
	

	<div id='Register' class="form-style-5">
	<form action='SellerRegister.php' method='POST'>
	<h4 class="title" align="center"><span class="text"><strong>Registeration</strong> Form</span></h4>
	<table align="center">
		<tr>
			<td>Company Name</td>
			<td><input type='text' name='sellercompany' value="<?php echo $sellercompany;?>" required></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type='email' name='selleremail' value="<?php echo $selleremail;?>" required/></td> 
		</tr>
		<?php echo $emailexists;?>
		<tr>
			<td>Password</td>
			<td><input type='password' name='sellerpassword' placeholder='Enter Password' required/></td>
		</tr>
		<?php echo $wrongpass;?>
		<tr>
			<td>Confirm Password</td>
			<td><input type='password' name='sellerconfirmpassword' placeholder='Enter Password' required/></td>
		</tr>
		<?php echo $wrongpass;?>
		<tr>
			<td>Phone</td>
			<td><input type='text' name='sellerphone' value="<?php echo $sellerphone;?>" required/></td>
		</tr>
		<?php echo $phoneexists;?>
		<tr>
			<td>Logo</td>
			<td><input type="file" name="sellerlogo"></td>
		</tr>
		<tr>
			<td>Country</td>
			<td><select name="sellercountry">
					<option value="China">China</option>
					<option value="Myanmar">Myanmar</option>
					<option value="Singapore">Singapore</option>
				</select></td>
		</tr>
		<tr>
			<td>Postal Code</td>
			<td><input type='text' name='sellerpostalcode' value="<?php echo $sellerpostalcode;?>"></td>
		</tr>
		<tr>
			<td>Address</td>
			<td><input type='text' name='selleraddress' value="<?php echo $selleraddress;?>" required/></td>
		</tr>
		<tr><td colspan="3">
			<p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
		</td></tr>
		<tr><td colspan="3" style="text-align:center;"><input tabindex="9" class="btn btn-inverse large" type="submit" name="btnRegister" value="Register"></div></td></tr>
	</table>
	</form>

	</div>


</body>
</html>

<?php include('footer.php'); ?>