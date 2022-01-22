<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
		<title>Bootstrap E-commerce Templates</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<!--[if ie]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
		<!-- bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">      
		<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		
		<link href="themes/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->
		<link href="themes/css/flexslider.css" rel="stylesheet"/>
		<link href="themes/css/main.css" rel="stylesheet"/>

		<!-- scripts -->
		<script src="themes/js/jquery-1.7.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>				
		<script src="themes/js/superfish.js"></script>	
		<script src="themes/js/jquery.scrolltotop.js"></script>
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
						<?php  
							if (isset($_SESSION['user']) && $_SESSION['user'] != ''){
								$user = $_SESSION['user'];
								echo "<li><a href='#''>$user</a></li>";
							}
						?>			
						<?php  
							if (isset($_SESSION['user']) && $_SESSION['user'] != ''){
								echo "<li><a href='logout.php'>Logout</a></li>";
							}
							else{
								echo "<li><a href='login.php'>Login</a></li>";
							}
						?>						
								
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
							<li><a href="./products.html">Orders</a>					
								<ul>
									<li><a href="./products.html">Order List</a></li>									
									<li><a href="./products.html">Order Status</a></li>
									<li><a href="./products.html">Order Reports</a></li>									
								</ul>
							</li>															
							<li><a href="./products.html">Catalog</a>
								<ul>									
									<li><a href="./add_product.php">Add Product</a></li>
									<li><a href="./products_list.php">Product List</a></li>
								</ul>
							</li>	
							<li><a href="./products.html">Advertising</a>
								<ul>									
									<li><a href="./products.html">Gifts and Tech</a></li>
								</ul>
							</li>	
							<li><a href="./products.html">Sales</a></li>						
							<li><a href="./products.html">Users</a></li>
						</ul>
					</nav>
				</div>
			</section>			

</body>
</html>