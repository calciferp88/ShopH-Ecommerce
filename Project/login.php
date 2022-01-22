<?php

	include('header.php');
	include('script\functions.php');
	$connect = mysqli_connect("localhost", "root", "", "shophdb");

	if

	$email = "";
	$password = "";
	$validator = 2;

	$emailvalidator = " ";
	$passwordvalidator = " ";

	$tempemail = "";

	if(isset($_POST['btnLogin'])){

		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$chkemail = preg_match('/@shoph.com/', $email);

		if(!$chkemail){
			if($email == ATTRIBUTE_CHECKER('Seller', 'SellerEmail', $email)){
				$validator = $validator - 1;
				$emailvalidator = "";
			} 
			else{
				$emailvalidator = "Email does not exist";
			}

			if(PASSWORD_VERIFY($password, PASSWORD_CHECKER('Seller', 'SellerEmail', 'SellerPassword', $email))){
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
				session_start();
				$_SESSION['user'] = $email;
				$_SESSION['btnchanger'] = 0;
				echo"
				<script>
					alert('Logged In');
					window.location.assign('seller_home.php');   
				</script>
				";
			}
		}

		else{

			if($email == ATTRIBUTE_CHECKER('Staff', 'StaffEmail', $email)){
				$validator = $validator - 1;
			} 
			else{
				$emailvalidator = "Email does not exist";
			}

			if(PASSWORD_VERIFY($password, PASSWORD_CHECKER('Staff', 'StaffEmail', 'StaffPassword', $email))){
				$validator = $validator - 1;
			}
			else{
				$passwordvalidator = "Password is wrong!";
			}

			if($validator == 0){
				session_start();
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


	}



?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>


	<div id='Register' class="form-style-5">
		<h4 class="title" align="center"><span class="text"><strong>Login</strong> Form</span></h4>
		<form  method='POST'>
			<table align="center">
				<tr>	
					<td>Email Address</td>
					<td><input type='email' name='email' value="<?php echo $email;?>" required></td>
				</tr>
				<tr><td colspan="3" style="text-align:center; color:#ff0000;"><?php echo $emailvalidator; ?></td></tr>
				<tr>	
					<td>Password</td>
					<td><input type='password' name='password' value="<?php echo $password;?>" required></td>
				</tr>
				<tr><td colspan="3" style="text-align:center; color:#ff0000;"><?php echo $passwordvalidator; ?></td></tr>
				<tr><td colspan="3" style="text-align:center;">Not a user? <a href="sellerregister.php">Register Here</a></p></td></tr>
				<tr><td colspan="3" style="text-align:center;"><input class="btn btn-inverse large" type="submit" name="btnLogin" value="Login"></td></tr>
			</table>
		</form>
	</div>			
</body>
</html>


<?php

	include('footer.php');


?>