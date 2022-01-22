<?php
	include('admin_header.php');

	$connect = mysqli_connect("localhost", "root", "", "shophdb");

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

	if(isset($_GET['btnRegisterStaff']))
	{
		$staffname = $_GET['staffname'];
		$staffemail = $_GET['staffemail'];
		$checkstaffemail = ATTRIBUTE_CHECKER('Staff', 'StaffEmail', $staffemail);
		$staffpassword = $_GET['staffpassword'];
		$confirmstaffpassword = $staffpassword;
		$staffposition = $_GET['staffposition'];
		$staffphone = $_GET['staffphone'];
		$checkstaffphone = ATTRIBUTE_CHECKER('Staff', 'StaffPhone', $staffphone);
		$staffaddress = $_GET['staffaddress'];
		

		if($staffemail != $checkstaffemail){
			if($staffpassword == $confirmstaffpassword){
				$chkemail = preg_match('/@shoph.com/', $staffemail);
				

				if(!$chkemail){
					$emailwrong = "Email is wrong! Must end with @shoph.com";
					
				}

				else{
					if($staffphone != $checkstaffphone){
						$staffid = ID_MAKER('Staff', 'StaffID');
						$hapass = password_hash($staffpassword, PASSWORD_DEFAULT);
						$insertadmin = "INSERT INTO Staff VALUES ('$staffid','$staffname', '$staffemail', '$hapass', '$staffposition', '', '$staffphone','$staffaddress')";

						$run = mysqli_query($connect, $insertadmin);

						if($run){
							echo "<script>
							alert('Insert Successful');
							window.location.assign('AdminHome.php');
							</script>";
						}
						else{
							echo mysqli_error($connect);
						}
					}
					else{
						$phoneexists = "Phone number already exists";
					}

				}
			}

			else{
				$wrongpass = "The password you entered is wrong";
			}
		}
		elseif($staffemail == $checkstaffemail){
			$emailexists = "Email already exists";
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

		<h4 class="title" align="center"><span class="text"><strong>Register</strong> Staff</span></h4>

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
			<li>Password</li>
			<li><input type='text' name='staffpassword' placeholder='Enter Password' required/></li>
		</ul>
		<ul><li colspan="2" style="text-align:center; color:#ff0000;"> <?php echo $wrongpass;?></li></ul>
		<ul><li colspan="2" style="text-align:center; color:#ff0000;"><?php echo $wrongpass;?></li></ul>
		<ul>
			<li>Position</li>
			<li><select name="staffposition">
					<option value="System Adminitrator">System Administrator</option>
					<option value="Customer Support">Customer Support</option>
				</select></li>
		</ul>
		<ul>
			<li>Phone</li>
			<li><input type='number' name='staffphone' value="<?php echo $staffphone;?>" required/></li>
		</ul>
		<ul><li colspan="2" style="text-align:center; color:#ff0000;"><?php echo $phoneexists;?></li></ul>
		<ul>
			<li>Address</li>
			<li><input type='text' name='staffaddress' value="<?php echo $staffaddress;?>" ></li>
		</ul>
		<ul><li colspan="3" style="text-align:center;"><input tabindex="9" class="btn btn-inverse large" type="submit" name="btnRegisterStaff" value="Register"></li></ul>


	</form>

	</div>

</body>
</html>
<?php 	include('footer.php'); ?>