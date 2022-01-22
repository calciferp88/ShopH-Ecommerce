		<?php 

	$connect = mysqli_connect('localhost','root','','shophdb');
	include('header.php');	
	$enddatecount = 0;

	?>

	<html>
		<head>
			<title>Home | ShopH</title>	
			<meta name="viewport" content="width=device-width, initial-scale=1.0">

			<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">      
			<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
			<link href="themes/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->	
		<link href="themes/css/flexslider.css" rel="stylesheet"/>

 			
		<!-- scripts -->
		<script src="themes/js/jquery-1.7.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>							
		<script src="themes/js/superfish.js"></script>	
		<script src="themes/js/jquery.scrolltotop.js"></script>

		<style type="text/css">


			

			.pd-img-container
			{
				width: 267px;
				height: 200px;
				overflow: hidden;
    			position: relative;
			}


			.pd-img
			{
		        background-size: contain;
		        background-position: center;
		        background-repeat: no-repeat;
		        width: 100%;
    			height: 100%;
		        transition: all 1s;
			}

			.pd-img:hover
			{
				transform: scale(1.2);

			}

			.pdetail
			{
				background-color:#ee3e0d;
				color: white;
				padding: 10px;
				margin:20px;
				font-weight: bold;
			}

			.pdetail:hover
			{
				background-color:#ee3e0d;
				color: white;
				border: 1px solid #ee3e0d;
			}

			#breadcrumb {
			  list-style: none;
			  display: inline-block;
			  margin-top: 30px;
			  margin-left: 0px;
			}
			#breadcrumb .icon {
			  font-size: 14px;
			}
			#breadcrumb li {
			  float: left;
			}
			#breadcrumb li a {
			  color: #FFF;
			  display: block;
			  background: #ee3e0d;
			  text-decoration: none;
			  position: relative;
			  height: 40px;
			  line-height: 40px;
			  padding: 0 10px 0 5px;
			  text-align: center;
			  margin-right: 23px;
			}
			#breadcrumb li:first-child a {
			  padding-left: 15px;
			  -moz-border-radius: 4px 0 0 4px;
			  -webkit-border-radius: 4px;
			  border-radius: 4px 0 0 4px;
			}
			#breadcrumb li:first-child a:before {
			  border: none;
			}
			#breadcrumb li:last-child a {
			  padding-right: 15px;
			  -moz-border-radius: 0 4px 4px 0;
			  -webkit-border-radius: 0;
			  border-radius: 0 4px 4px 0;
			}
			#breadcrumb li:last-child a:after {
			  border: none;
			}
			#breadcrumb li a:before, #breadcrumb li a:after {
			  content: "";
			  position: absolute;
			  top: 0;
			  border: 0 solid #ee3e0d;
			  border-width: 20px 10px;
			  width: 0;
			  height: 0;
			}
			#breadcrumb li a:before {
			  left: -20px;
			  border-left-color: transparent;
			}
			#breadcrumb li a:after {
			  left: 100%;
			  border-color: transparent;
			  border-left-color: #ee3e0d;
			}
			#breadcrumb li a:hover {
			  background-color: #f45225;
			}
			#breadcrumb li a:hover:before {
			  border-color: #f45225;
			  border-left-color: transparent;
			}
			#breadcrumb li a:hover:after {
			  border-left-color: #f45225;
			}
			#breadcrumb li a:active {
			  background-color: #f45225;
			}
			#breadcrumb li a:active:before {
			  border-color: #f45225;
			  border-left-color: transparent;
			}
			#breadcrumb li a:active:after {
			  border-left-color: #f45225;
			}
		</style>

	</head>
<script>
	//https://codepen.io/MartinMuzatko/pen/GvgWJZ?editors=1010
function createCountDown(elementId, date) {
	// Set the date we're counting down to
	var countDownDate = new Date(date).getTime();

	// Update the count down every 1 second
	var x = setInterval(function() {

	  // Get todays date and time
	  var now = new Date().getTime();

	  // Find the distance between now an the count down date
	  var distance = countDownDate - now;

	  // Time calculations for days, hours, minutes and seconds
	  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

	  // Display the result in the element with id="demo"
	  document.getElementById(elementId).innerHTML = days + "d " + hours + "h "
	  + minutes + "m " + seconds + "s ";

	  // If the count down is finished, write some text 
	  if (distance < 0) {
		clearInterval(x);
		document.getElementById(elementId).innerHTML = "EXPIRED";
	  }
	}, 1000);
}

<?php 

	$today = date('Y-m-d');
	$now   = date('H:i:s');

	$select = "SELECT * FROM product p, auction a 
		WHERE a.ProductID = p.ProductID
		AND a.StartDate > CURRENT_DATE ";
	$run    = mysqli_query($connect, $select); 
	$count  = mysqli_num_rows($run);   

	for ($i=0; $i < $count; $i++) 	
	{ 
		$row    = mysqli_fetch_array($run);
		$startdate    = $row['StartDate']; 
		$starttime = $row['StartTime'];
								             
	?>

createCountDown('start'+'<?php echo $i; ?>', '<?php echo $startdate; ?>'+" "+'<?php echo $starttime; ?>');

<?php } ?>

<?php 

	$today = date('Y-m-d');
	$now   = date('H:i:s');

	$select = "SELECT * FROM product p, auction a 
				WHERE a.ProductID = p.ProductID
				AND a.StartDate <= CURRENT_DATE
				AND a.EndDate >= CURRENT_DATE";
	$run    = mysqli_query($connect, $select); 
	$count  = mysqli_num_rows($run);   

	for ($i=0; $i < $count; $i++) 	
	{ 
		$row    = mysqli_fetch_array($run);
		$enddate    = $row['EndDate']; 
		$endtime = $row['EndTime'];
								             
	?>

createCountDown('end'+'<?php echo $i; ?>', '<?php echo $enddate; ?>'+" "+'<?php echo $endtime; ?>');

<?php } ?>


</script>

<body>

			<ul id="breadcrumb">
			  <li><a href="home.php"> <i class="fa fa-home"></i> Home </a></li>
			  <li><a href="#"><i class="fa fa-search"></i> Auction Products </a></li>			
			</ul>

			<section class="main-content">

				<div class="row">
					<div class="span12">	
						
						<!-- Active Auctions  -->
						<div class="row">
							<div class="span12">
								<h4 class="title">
									<span class="pull-left"><span class="text"><span class="line">Active Products to <strong>Auction</strong></span></span></span>
									<span class="pull-right">
										<a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
									</span>
								</h4>
								
								<div id="myCarousel" class="myCarousel carousel slide">
									<div class="carousel-inner">
										<div class="active item">
										<ul class="thumbnails">	

									    <!-- Single Products -->

										<?php 

											// Current Date n Time
											$today = date('Y-m-d');
											$now   = date('H:i:s');

											// Selecting Active auctions
										    $select = "SELECT * FROM product p, auction a 
										    		   WHERE a.ProductID = p.ProductID
										    		   AND a.StartDate <= CURRENT_DATE
										    		   AND a.EndDate >= CURRENT_DATE";
										    $run    = mysqli_query($connect, $select); 
									        

									        if(!$run){

									        }
									        else{
									        	$count  = mysqli_num_rows($run);   

									        for ($i=0; $i < $count; $i++) 	
									        { 
									          $row    = mysqli_fetch_array($run);
									          $pid    = $row['ProductID'];   
									          $pname  = $row['ProductName'];
									          $price  = $row['Price'];
									          $stock  = $row['Stock']; 
									          $bid    = $row['BrandID'];
									          $sid    = $row['SubCategoryID'];
									          $image  = $row['ProductPicture0'];

                                              $category    = ATTRIBUTE_EXTRACTOR('subcategory', 'SubCategoryID', $sid, 'SubCategoryName');
                                              $brandname   = ATTRIBUTE_EXTRACTOR('Brand', 'BrandID', $bid, 'BrandName');

                                              $selectauction = "SELECT * FROM auction WHERE ProductID = '$pid'";
							                  $runauction = mysqli_query($connect, $selectauction);
										      $countauction = mysqli_num_rows($runauction);
										      $counter = $i;

											  if ($countauction > 0 )
											  {
											 	$rowa       = mysqli_fetch_array($runauction);
											 	$enddate    = $rowa['EndDate'];
											 	$endtime    = $rowa['EndTime'];
											 	$currentbid = $rowa['CurrentBid'];
											 	$aid = $rowa['AuctionID'];
											 	$arrayenddate[$counter] = $enddate[$counter]; 
											 	$enddatecount++;
									             
										?>

												<li class="span3">
												  <div class="product-box" style="height: 380px;">
												  	<form method="POST" action="home.php?action=add&id=<?php echo $aid ?>">
											  	<div  class="pd-img-container">
													 <p>
													 	<a href="auction_product.php?auctionid=<?php echo $aid ?>">
													 		<div class="pd-img" style='background-image: url(<?php echo"$image"; ?>);'>
													 			
													 		</div>
													 	</a>
													 </p>	
													</div>
													 <a href="auction_product.php?auctionid=<?php echo $aid ?>" class="title" style="color: #ee3e0d;"><?php echo $pname ?></a><br/>
													 <p class="category"><?php echo "$brandname"; ?> ( <?php echo "$category"; ?> )</p>

														 <?php $a = "end".$i; ?>
														 <p>Ending In : <span style="font-weight: bold; color: #ee3e0d;" id='<?php echo "$a"; ?>'></span></p>
													 <p>Current Bid  : <span style="font-weight: bold; color: #ee3e0d;">$ <?php echo "$currentbid"; ?></span></p><br>

													  <p><a href="auction_product.php?auctionid=<?php echo $aid ?>" class="pdetail">Bid Now</a></p>

													</form>
												  </div>	
												</li>

									<?php }} } ?>


											</ul>
										</div>
										
									</div>									
								</div>
							</div>						
						</div>

						<!-- Upcoming Auctions -->
						<div class="row">
							<div class="span12">
								<h4 class="title">
									<span class="pull-left"><span class="text"><span class="line">Upcoming  <strong>Auction</strong></span></span></span>
									<span class="pull-right">
										<a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
									</span>
								</h4>
								
								<div id="myCarousel" class="myCarousel carousel slide">
									<div class="carousel-inner">
										<div class="active item">
										<ul class="thumbnails">	

									    <!-- Single Products -->

										<?php 

											$today = date('Y-m-d');
											$now   = date('H:i:s');

										    $select = "SELECT * FROM product p, auction a 
										    		   WHERE a.ProductID = p.ProductID AND a.StartTime < CURRENT_TIME
										    		   AND a.StartDate > CURRENT_DATE ";
										    $run    = mysqli_query($connect, $select); 
									        if(!$run){

									        }
									        else{
									        $count  = mysqli_num_rows($run);   

									        for ($i=0; $i < $count; $i++) 	
									        { 
									          $row    = mysqli_fetch_array($run);
									          $pid    = $row['ProductID'];   
									          $pname  = $row['ProductName'];
									          $price  = $row['Price'];
									          $stock  = $row['Stock']; 
									          $bid    = $row['BrandID'];
									          $sid    = $row['SubCategoryID'];
									          $image  = $row['ProductPicture0'];
									          $start  = $row['StartDate'];
									          $aid = $row['AuctionID'];
                                              $category    = ATTRIBUTE_EXTRACTOR('subcategory', 'SubCategoryID', $sid, 'SubCategoryName');
                                              $brandname   = ATTRIBUTE_EXTRACTOR('Brand', 'BrandID', $bid, 'BrandName');
											  $startdate    = $row['StartDate']; 
											  $starttime = $row['StartTime'];
											  $currentbid = $row['CurrentBid']; 									             
										?>


												<li class="span3">
												  <div class="product-box" style="height: 380px;">
												  	<form method="POST" action="home.php?action=add&id=<?php echo $aid ?>">
												  	<div  class="pd-img-container">
														 <p>
														 	<a href="auction_product.php?auctionid=<?php echo $aid ?>">
														 		<div class="pd-img" style='background-image: url(<?php echo"$image"; ?>);'>
														 			
														 		</div>
														 	</a>
														 </p>	
														</div>
														 <a href="auction_product.php?auctionid=<?php echo $aid ?>" class="title" style="color: #ee3e0d;"><?php echo $pname ?></a><br/>
														 <p class="category"><?php echo "$brandname"; ?> ( <?php echo "$category"; ?> )</p>
														 <?php $a = "start".$i; ?>
														 <p>Starting In : <span style="font-weight: bold; color: #ee3e0d;" id='<?php echo "$a"; ?>'></span></p>
														 <p>Starting Bid  : <span style="font-weight: bold; color: #ee3e0d;">$ <?php echo "$currentbid"; ?></span></p><br>
														</form>
													</div>	
												</li>

									<?php }} ?>


											</ul>
										</div>
										
									</div>									
								</div>
							</div>						
						</div>
						<br/>
						
							
					</div>				
				</div>
			</section>	

	x	

			<?php include('footer.php'); ?>

    </body>
</html>
