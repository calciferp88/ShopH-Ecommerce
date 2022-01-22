<?php
	include('header.php');
	$connect = mysqli_connect("localhost", "root", "", "shophdb");

	$companyid = "";
	if(isset($_POST['btnRegister'])){
		$seller = 1;
		$user = $_SESSION['user'];

		$update = "UPDATE Customer SET CustomerasSeller='$seller' WHERE CustomerEmail='$user'";
		$run = mysqli_query($connect, $update);
		if($run){
			echo "<script>alert('Uploaded File');
			window.location.assign('home.php');</script>";

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

	<div id='Register' class="form-style-5">
	<form action='' method='POST'>
		<h4 class="title" align="center"><span class="text"><strong>Register As</strong> Seller</span></h4>
			<ul style="text-align:center; font-weight:bold;">
				<li>Please submit your NRIC or Passport for Verification</li>
            	<li>Choose File<img src="themes/images/image.png" width="7%"> 
            		<input type="file" name="customerverification" id="img-upload"></li>
				<li><input tabindex="9" class="btn btn-inverse large" type="submit" name="btnRegister" value="Submit"></div></li>
		</table>
	</form>

</body>
</html>
<?php 
	include('footer.php');
?>