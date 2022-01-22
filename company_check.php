<?php
	include('header.php');
	$connect = mysqli_connect("localhost", "root", "", "shophdb");

	$companyid = "";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div id='Register' class="form-style-5">

	<form action='customer_details.php' method='POST'>	
		<h4 class="title" align="center"><span class="text"><strong>Registeration</strong> Form</span></h4>
		<table align="center">
			<tr>
				<td>Find Your Company ID </td>
				<td><input type='text' name='companyid' value="<?php echo $companyid;?>" required></td>
			</tr>
			<tr><td colspan="3" style="text-align:center;"><input tabindex="9" class="btn btn-inverse large" type="submit" name="btnRegister" value="Next"></div></td></tr>
			<tr><td colspan="3">
				<p>If your company hasn't registered with us <a href="company_register.php">Click Here</a>.</p>
			</td></tr>
		</table>
	</form>			

</body>
</html>
<?php 
	include('footer.php');
?>