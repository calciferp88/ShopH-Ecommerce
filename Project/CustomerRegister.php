<?php
	include('header.php');

	$customerid = "";
	$customername = "";
	$customeremail = "";
	$customerpassword = "";
	$customerage = "";
	$customerdateofbirth = "";
	$customercountry = "";
	$customeraddress = "";
	$customerphone = "";

	if(isset($_POST['btnsave'])){
		$customerid = "";
		$customername = "";
		$customeremail = "";
		$customerpassword = "";
		$customerage = "";
		$customerdateofbirth = "";
		$customercountry = "";
		$customeraddress = "";
		$customerphone = "";
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>

</head>
<body>	

		<div id="top-bar" class="container">
			<div class="row">
				<div class="span4">
					<form method="POST" class="search_form">
						<input type="text" class="input-block-level search-query" Placeholder="eg. T-sirt">
					</form>
				</div>
				<div class="span8">
					<div class="account pull-right">
						<ul class="user-menu">				
							<li><a href="#">My Account</a></li>
							<li><a href="cart.html">Your Cart</a></li>
							<li><a href="checkout.html">Checkout</a></li>					
							<li><a href="register.html">Login</a></li>		
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="wrapper" class="container">
			<section class="navbar main-menu">
				<div class="navbar-inner main-menu">				
					<a href="index.html" class="logo pull-left"><img src="themes/images/logo.png" width="15%" height="15%" class="site_logo" alt=""></a>
					<nav id="menu" class="pull-right">
						<ul>
							<li><a href="./products.html">Woman</a>					
								<ul>
									<li><a href="./products.html">Lacinia nibh</a></li>									
									<li><a href="./products.html">Eget molestie</a></li>
									<li><a href="./products.html">Varius purus</a></li>									
								</ul>
							</li>															
							<li><a href="./products.html">Man</a></li>			
							<li><a href="./products.html">Sport</a>
								<ul>									
									<li><a href="./products.html">Gifts and Tech</a></li>
									<li><a href="./products.html">Ties and Hats</a></li>
									<li><a href="./products.html">Cold Weather</a></li>
								</ul>
							</li>							
							<li><a href="./products.html">Hangbag</a></li>
							<li><a href="./products.html">Best Seller</a></li>
							<li><a href="./products.html">Top Seller</a></li>
						</ul>
					</nav>
				</div>
			</section>			
			<section class="header_text sub">
			<img class="pageBanner" src="themes/images/pageBanner.png" alt="New products" >
				<h4><span>Login or Regsiter</span></h4>
			</section>	

	<div id='Register' class="form-style-5">
	<form action='CustomerHome.php' method='POST'>
	<table align="center">
		<tr>
			<td>Customer Name</td>
			<td><input type='text' name='cname' value="<?php echo $customername;?>" required></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type='email' name='cemail' value="<?php echo $customeremail;?>" required/></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type='password' name='cpassword' placeholder='Enter Password' required/></td>
		</tr>
		<tr>
			<td>Confirm Password</td>
			<td><input type='password' name='ccpassword' placeholder='Enter Password' required/></td>
		</tr>
		<tr>
			<td>Gender</td>
			<td>			
				<input type="Radio" name="cgender" value="cmale" <?php if($customergender=="Male"){ echo "checked=checked";}  ?> >Male
				<input type="Radio" name="cgender" value="cfemale" <?php if($customergender=="Female"){ echo "checked=checked";} ?> >Female</td>
		</tr>
		<tr>
			<td>Phone</td>
			<td><input type='text' name='cphone' value="<?php echo $customerphone;?>" required/></td>
		</tr>
		<tr>
			<td>Date of Birth</td>
			<td><input type="Date" name="cdate" value="<?php echo $customerdateofbirth; ?>" required/></td>
		</tr>
		<tr>
			<td>Country</td>
			<td><input type='text' name='ccountry' value="<?php echo $customercountry;?>" required/></td>
		</tr>
		<tr>
			<td>Address</td>
			<td><input type='text' name='caddress' value="<?php echo $customeraddress;?>" required/></td>
		</tr>
		<tr><td colspan="3" style="text-align:center;"><input type="submit" value="Save" name="btnSave"></td></tr>
	</table>
	</form>
	</div>

</body>
</html>