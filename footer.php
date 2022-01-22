<!DOCTYPE html>
<html>
<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- global styles -->	
		<link href="themes/css/flexslider.css" rel="stylesheet"/>
		<link href="themes/css/maincss.css" rel="stylesheet"/>	
 			
		<!-- scripts -->
		<script src="themes/js/jquery-1.7.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>							
		<script src="themes/js/superfish.js"></script>	
		<script src="themes/js/jquery.scrolltotop.js"></script>

</head>
<body>	
			<section id="footer-bar">
				<div class="row">
					<div class="span3">	
						<h4 style="text-align: left; padding-left:15px; color: #ee3e0d; ">Navigation</h4>
						<ul class="nav"  id="foot-list">
							<li><a href="./home.php">Homepage</a></li>  
							<li><a href="./about.html">About Us</a></li>
							<li><a href="./message_inbox.php">Contact Us</a></li>						
						</ul>								
					</div>
					
					<div class="span5">
						<p class="logo"><img src="themes/images/favicon.png" width="50%" lass="site_logo" alt=""></p>
						<p class="foottext">ShopH.com is providing best services to both customers and sellers in their selling and buying processes. We gurantee the confidentiality of information so that users can confidently share their personal information in our website.</p>
					
					</div>					
				</div>	
			</section>
			<section id="copyright">
				<span>Copyright 2020 ShopH all rights reserved.</span>
			</section>
		</div>
		<script src="themes/js/common.js"></script>
		<script>
			$(document).ready(function() {
				$('#checkout').click(function (e) {
					document.location.href = "checkout.html";
				})
			});
		</script>	
</body>
</html>