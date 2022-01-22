<?php
	session_start();
	include('script\functions.php');

	//CHECK IF USER LOGGED IN OR NOT
	if (!$_SESSION['user']) 
	{

	            echo "<script>
				window.location.assign('login.php');
				</script>";

	} 
	

	//LOGOUT FUNCTION
	if(isset($_GET['btnlogout'])){
		session_destroy();
		echo "<script>
				window.location.assign('login.php');
				</script>";
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
		<!-- Favicon -->
        <link rel="icon" href="themes/images/favicon.png">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<!--[if ie]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
		<!-- bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">      
		<link href="bootstrap3/css/bootstrap-responsive.min.css" rel="stylesheet">
		
		<link href="themes/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->
		<link href="themes/css/flexslider.css" rel="stylesheet"/>
		<link href="themes/css/maincss.css" rel="stylesheet"/>

		<!-- scripts -->
		<script src="themes/js/jquery-1.7.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>				
		<script src="themes/js/superfish.js"></script>	
		<script src="themes/js/jquery.scrolltotop.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">	
		
</head>

<body>
		<div id="top-bar" class="container">
			<div class="row">
				<div class="span4">
					<!-- <form method="POST" class="search_form">
						<input type="text" class="input-block-level search-query" Placeholder="eg. T-sirt">
					</form> -->
				</div>
				<div class="span8">
					<div class="account pull-right">
						<ul class="user-menu">

						<!-- condition for login/ Logout link -->
						<li><a href='delivery_home.php'> <i class="fas fa-home"></i> Home</a></li>
						<?php  
							if (isset($_SESSION['user']) && $_SESSION['user'] != '')
							{
								$user = $_SESSION['user'];
								echo "<li><a href='delivery_home.php'>$user</a></li>";
							}
						?>			
						<?php  
							if (isset($_SESSION['user']) && $_SESSION['user'] != ''){
								echo "<li><a href='logout.php'>Logout</a></li>";
							}
							else
							{
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
							<li><a href="">Delivery Staff</a>					
								<ul>
									<li><a href="./manage_deliverystaff.php">Manage Delivery Staff</a></li>									
									<li><a href="./deliverystaff_register.php">Register Delivery Staff</a></li>									
								</ul>
							</li>	
						</ul>
					</nav>
				</div>
			</section>			

</body>
</html>	