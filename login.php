<?php

	include('header.php');
	$connect = mysqli_connect("localhost", "root", "", "shophdb");			

	$email = "";
	$password = "";
	$validator = 2;

	$emailvalidator = " ";
	$passwordvalidator = " ";

	$tempemail = "";

	if(isset($_POST['btnLogin']))
	{

		$email = $_POST['email'];
		$password = $_POST['password'];
		$chkemaildel = preg_match('/@grab.com/', $email);
		$chkemail = preg_match('/@shoph.com/', $email);
 
		if($chkemail)
		{	
			if($email == ATTRIBUTE_CHECKER('staff', 'StaffEmail', $email))
			{
				$validator = $validator - 1;
			} 

			else
			{
				$emailvalidator = "Email does not exist";
			}

			if(PASSWORD_VERIFY($password, PASSWORD_CHECKER('Staff', 'StaffEmail', 'StaffPassword', $email))){
				$validator = $validator - 1;
			}
			else{
				$passwordvalidator = "Password is wrong!";
			}

			if($validator == 0)
			{
				$_SESSION['user'] = $email;
				echo "hi";
				echo"
				<script>
					alert('Logged In');
					window.location.assign('adminhome.php');   
				</script>
				";
			}
		}

		else if($chkemaildel)
		{
			if($email == ATTRIBUTE_CHECKER('deliverystaff', 'DeliveryStaffEmail', $email)){
				$validator = $validator - 1;
			} 
			else
			{
				$emailvalidator = "Email does not exist";
			}

			if(PASSWORD_VERIFY($password, PASSWORD_CHECKER('deliverystaff', 'DeliveryStaffEmail', 'DeliveryStaffPassword', $email)))
			{
				$validator = $validator - 1;
			}

			else
			{
				$passwordvalidator = "Password is wrong!";
			}

			if($validator == 0)
			{
				$_SESSION['user'] = $email;
				echo"
				<script>
					alert('Welcome !');
					window.location.assign('delivery_home.php');   
				</script>
				";
			}
		}


		else
		{
			if($email == ATTRIBUTE_CHECKER('Customer', 'CustomerEmail', $email)){
				$validator = $validator - 1;
				$emailvalidator = "";
			} 
			else{
				$emailvalidator = "Email does not exist";
			}

			if(PASSWORD_VERIFY($password, PASSWORD_CHECKER('Customer', 'CustomerEmail', 'CustomerPassword', $email))){
				$validator = $validator - 1;
			}
			else{
				if($emailvalidator == "Email does not exist"){
					$passwordvalidator == "";
				}
				else{
					$passwordvalidator = "Password is wrong";
				}
			}

			if($validator == 0){	
				$_SESSION['user'] = $email;
				$_SESSION['btnchanger'] = 0;
				echo"
				<script>
					alert('Logged In');
					window.location.assign('home.php');   
				</script>
				";
			}
		}	


	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login | ShopH</title>
</head>
<body>

<br><br>			
	<div id='Register' class="form-style-5">
		<h4 class="title" align="center"><span class="text"><strong>Login</strong> Form</span></h4>
		<form  method='POST' style="text-align:center; font-weight:bold;"  >
			<ul>
				<li>Email Address</li>
				<li><input type='email' name='email' value="<?php echo $email;?>" required></li>
				<li style="text-align:center; color:#ff0000;"><?php echo $emailvalidator; ?></li>
			</ul>
			<ul>		
				<li>Password</li>
				<li><input type='password' name='password' value="<?php echo $password;?>" required></li>
				<li style="color:#ff0000;"><?php echo $passwordvalidator; ?></li>
				<li >Not a user? <a href="customer_register.php">Register Here</a></p></li>
				<li ><input class="btn btn-inverse large" type="submit" name="btnLogin" value="Login"></li>
			</ul>
		</form>
	</div>			
</body>
</html>


<?php

	include('footer.php');


?>