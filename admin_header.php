		<?php
	session_start();
	include('script\functions.php');

	//CHECK IF USER LOGGED IN OR NOT
	if ($_SESSION['user']!=NULL) {

		//SEND THE USER TO HIS PAGE
		$chkemail = preg_match('/@shoph.com/', $_SESSION['user']);
		if(!$chkemail){
			echo "<script>
				window.location.assign('seller_home.php');
			</script>";
		}

	} 
	else {
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
		<!--[if ie]><meta content='IE=8' http-	equiv='X-UA-Compatible'/><![endif]-->
		<!-- bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">      
		<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		
		<link href="themes/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->
		<link href="themes/css/flexslider.css" rel="stylesheet"/>
		<link href="themes/css/Main.css" rel="stylesheet"/>

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

						<li><a href='AdminHome.php'> <i class="fas fa-home"></i> Home</a></li>
						<?php  
							if (isset($_SESSION['user']) && $_SESSION['user'] != ''){
								$user = $_SESSION['user'];
								echo "<li><a href='adminhome.php''>$user</a></li>";
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
							<!-- Manage Staff Nav -->
							<li><a href="">Staff</a>					
								<ul>
									<li><a href="./manage_staff.php">Manage Staff</a></li>									
									<li><a href="./staff_register.php">Register Staff</a></li>									
								</ul>
							</li>					
							<!-- Product Nav -->
							<li><a href="">Products Information</a>			
								<ul>									
									<li><a href="./manage_brand.php">Manage Brand</a></li>
									<li><a href="./manage_category.php">Manage Category</a></li>
								</ul>
							</li>	
							<!-- Advertisement Nav -->
							<li><a href="">Advertisement</a>			
								<ul>									
									<li><a href="staff_advertisement_list.php">Advertisement List</a></li>
								</ul>
							</li>	
							<li><a href="">Message</a>
								<ul >									
									<li><a href="staff_message_home.php">Customer List</a></li>
									<li><a href="staff_message_chat.php">Chat</a></li>	
								</ul>
							</li>	
						</ul>
					</nav>
				</div>
			</section>			

</body>
</html>