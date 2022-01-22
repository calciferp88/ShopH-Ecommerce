	<?php
	include('delivery_header.php');

	$connect = mysqli_connect("localhost", "root", "", "shophdb");

	$staffidsession = $_SESSION['user'];
    $staffroletest   = ATTRIBUTE_EXTRACTOR('deliverystaff', 'DeliveryStaffEmail', $staffidsession, 'DeliveryStaffRole');

    if ($staffroletest != 'Admin') 
    {
    					echo "<script>
						alert('You do not have access permission to this page !');
						window.location.assign('delivery_home.php');
						</script>";
    }

	$staffid;		
	$staffname = "";
	$staffemail = "";
	$staffpassword = "";
	$staffposition = "";
	$staffphone = "";
	$staffaddress = "";
	$emailexists = "";
	$emailwrong = "";
	$phoneexists = "";
	$wrongpass = "";

	// inserting delivery staff
	if(isset($_GET['btnRegisterStaff'])){
		$staffname = $_GET['staffname'];
		$staffemail = $_GET['staffemail'];
		$checkstaffemail = ATTRIBUTE_CHECKER('deliverystaff', 'DeliveryStaffEmail', $staffemail);
		$staffpassword = $_GET['staffpassword'];
		$confirmstaffpassword = $staffpassword;	
		$staffposition = $_GET['staffposition'];
		$staffphone = $_GET['staffphone'];	

		if($staffemail != $checkstaffemail){
			if($staffpassword == $confirmstaffpassword){
				$chkemail = preg_match('/@grab.com/', $staffemail);	

				if(!$chkemail)
				{
					$emailwrong = "Email is wrong! Must end with @grab.com";
				}	

				else
				{
					$staffid = ID_MAKER('deliverystaff', 'DeliveryStaffID');
					$hapass = password_hash($staffpassword, PASSWORD_DEFAULT);
					$insertadmin = "INSERT INTO deliverystaff 
									VALUES ('$staffid','$staffname', '$staffemail', '$hapass', '$staffphone', '$staffposition', 'Free','1')";

					$run = mysqli_query($connect, $insertadmin);

					if($run){
						echo "<script>
						alert('Insert Successful');
						window.location.assign('delivery_home.php');
						</script>";
					}
					else{
						echo mysqli_error($connect);
					}
				}
			}

			else{
				$wrongpass = "The password you entered is wrong";
			}
		}

		// Check email exist or not
		elseif($staffemail == $checkstaffemail)
		{
			$emailexists = "Email already exists";
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register Delivery Staff | ShopH</title>
</head>
<body>

		<h4 class="title" align="center"><span class="text"><strong>Register</strong> Delivery Staff</span></h4>

	  <div id='Register' class="form-style-5">
		<form action='' method='GET' align='center'>

		<ul>
			<li>Staff Name</li>
			<li><input type='text' name='staffname' value="<?php echo $staffname;?>" required></li>
		</ul>

		<ul>
			<li>Email</li>
			<li><input type='email' name='staffemail' value="<?php echo $staffemail;?>" required/></li> 
		</ul>		
		<ul><li colspan="2" style="text-align:center; color:#ff0000;"><?php echo $emailexists;?></li></ul>
		<ul><li colspan="2" style="text-align:center; color:#ff0000;"><?php echo $emailwrong;?></li></ul>

		<ul>
			<li>Phone</li>
			<li><input type='text' name='staffphone' value="<?php echo $staffphone;?>" required/></li>
		</ul>


		<?php echo $phoneexists;?>

		<ul>
			<li>Password</li>
			<li><input type='password' name='staffpassword' placeholder='Enter Password' required/></li>
		</ul>


		<ul><li colspan="2" style="text-align:center; color:#ff0000;"> <?php echo $wrongpass;?></li></ul>
		<ul><li colspan="2" style="text-align:center; color:#ff0000;"><?php echo $wrongpass;?></li></ul>
		<ul>
			<li>Position</li>
			<li><select name="staffposition">
					<option value="Admin">Admin</option>
					<option value="Delivery Staff">Delivery Staff</option>
				</select></li>
		</ul>
		
		
		<ul><li colspan="3" style="text-align:center;"><input tabindex="9" class="btn btn-inverse large" type="submit" name="btnRegisterStaff" value="Register"></li></ul>


	</form>

	</div>

</body>
</html>
<?php 	include('footer.php'); ?>