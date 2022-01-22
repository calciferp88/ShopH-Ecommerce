	<?php
	include('header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

	if (isset($_GET['auctionid']) && $_GET['auctionid'] != '')
	{
		$_SESSION['auctionid'] = $_GET['auctionid'];
	}

	// Get id form session
	$aid = $_SESSION['auctionid'];

	// Select auction with Got Acution ID
	$select = "SELECT * FROM Auction WHERE AuctionID='$aid'";
	$run = mysqli_query($connect, $select);
	$data = mysqli_fetch_array($run);
	$maxbid = $data['Maxbid'];
	$auctionid   = $data['AuctionID'];   
	$enddate     = $data['EndDate']; 
	$endtime     = $data['EndTime'];
	$startdate     = $data['StartDate'];
	$starttime	 = $data['StartTime']; 
	$increasebid = $data['IncreaseBid']; 
	$currentbid  = $data['CurrentBid']; 
	$bidtime	 = $data['BidTimes']; 
	$bidderid    = $data['CustomerID']; 
	$pid = $data['ProductID'];

	$select = "SELECT * FROM Product WHERE ProductID='$pid'";
	$run = mysqli_query($connect, $select);
	$data = mysqli_fetch_array($run);

	$productname        = $data['ProductName'];	
	$productdescription = $data['ProductDescription']; 
	$productprice       = $data['Price'];	
	$productstock       = $data['Stock'];	
	$productdate        = $data['UploadDate'];
	$productpicture     = $data['ProductPicture0'];
	$productpicture1    = $data['ProductPicture1'];
	$productpicture2    = $data['ProductPicture2'];
	$productpicture3    = $data['ProductPicture3'];
	$productpicture4    = $data['ProductPicture4'];
	$brandid            = $data['BrandID']; 
	$categoryid         = $data['SubCategoryID'];
	$sellerid           = $data['CustomerID'];

	$categoryname =  ATTRIBUTE_EXTRACTOR('Category', 'CategoryID', $categoryid, 'CategoryName');
	$brandname    =  ATTRIBUTE_EXTRACTOR('Brand', 'BrandID', $brandid, 'BrandName');

	if (isset($_SESSION['user'])) 
	{
		$userid = ATTRIBUTE_EXTRACTOR('customer', 'CustomerEmail', $_SESSION['user'], 'CustomerID');
	}
	
	$Seller = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $sellerid, 'CustomerName');

	$amttobid    = $currentbid + $increasebid;		
	$bidder = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $bidderid, 'CustomerName');											

	if (isset($_POST['btn-bit'])) 
	{
		$bitprice = $_POST['txtbidprice'];			
		$bidtime2 = $bidtime + 1;	

		$update = " UPDATE auction 						
					SET CurrentBid = '$bitprice', BidTimes = '$bidtime2', CustomerID = '$userid'
					WHERE AuctionID = '$auctionid'";

		$runupdate = mysqli_query($connect, $update);

			if($runupdate)
			{
				echo '
				<script>
					alert("Bidded Successfully");
					window.location.assign("auction_product.php");
				</script>';
			}		

			else
			{
			  echo mysqli_error($connect);
		    }
	}	

?>

<!DOCTYPE html>
<html> 	
<head>

	<title>ShopH | <?php echo "$productname"; ?></title>  

	<!-- global styles -->	
    <link href="themes/css/flexslider.css" rel="stylesheet"/>
    <link href="themes/css/Main2.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="themes/css/style.css">

    <script>
		// Set the date we're counting down to
		var strstartdate = "<?php echo $startdate; ?>";
		var strenddate = "<?php echo $enddate; ?>";

		var startdate = strstartdate.split("-",3);
		var startyear = startdate[0];
		var startmonth = startdate[1];
		var startday = startdate[2];
		var startime = "<?php echo $starttime; ?>";

		var enddate = strenddate.split("-", 3);
		var endyear = enddate[0];
		var endmonth = enddate[1];
		var endday = enddate[2];
		var endtime = "<?php echo $endtime; ?>";

		var startcountDownDate = new Date(startmonth+" "+startday+", "+startyear+" "+startime).getTime();
		var endcountDownDate = new Date(endmonth+" "+endday+", "+endyear+" "+endtime).getTime();
		//var countDownDate = new Date(<?php echo $enddate;?>).getTime();
		// Update the count down every 1 second
		var x = setInterval(function() {

		// Get today's date and time
		var now = new Date().getTime();

		// Find the distance between now and the count down date
		var startdistance = startcountDownDate - now;
		var enddistance = endcountDownDate - now;


		var startdays = Math.floor(startdistance / (1000 * 60 * 60 * 24));
		var starthours = Math.floor((startdistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var startminutes = Math.floor((startdistance % (1000 * 60 * 60)) / (1000 * 60));
		var startseconds = Math.floor((startdistance % (1000 * 60)) / 1000);
			    
		// Output the result in an element with id="demo"
		if(startdistance > 0){
			document.getElementById("demo").innerHTML = startdays + "d " + starthours + "h "
			+ startminutes + "m " + startseconds + "s ";
			document.getElementById("when").innerHTML = "Starting In :";
		}
		else if(startdistance < 0){  
				  // Time calculations for days, hours, minutes and seconds
			var enddays = Math.floor(enddistance / (1000 * 60 * 60 * 24));
			var endhours = Math.floor((enddistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var endminutes = Math.floor((enddistance % (1000 * 60 * 60)) / (1000 * 60));
			var endseconds = Math.floor((enddistance % (1000 * 60)) / 1000);
				    
				  // Output the result in an element with id="demo"
			document.getElementById("demo").innerHTML = enddays + "d " + endhours + "h "
			+ endminutes + "m " + endseconds + "s ";
			document.getElementById("when").innerHTML = "Ending In :";
				    
				  // If the count down is over, write some text 
			if (enddistance < 0) {
				clearInterval(x);
				document.getElementById("demo").innerHTML = "EXPIRED";
				document.getElementById("when").innerHTML = "Ending In :";
			}
		}
		}, 1000);
	</script>

</head>
<body>

			<h4 class="title" align="center"><span class="text"><strong>Product</strong> Details</span></h4>

			<section class="main-content">				
				<div class="row">						
          <div class="span9">
            <div class="row">
              <div class="span4">
                <a href="<?php echo($productpicture) ?>" class="thumbnail" data-fancybox-group="group1" title="<?php echo($productname) ?>">
                <img alt="" src="<?php echo($productpicture) ?>"></a>                       
                <ul class="thumbnails small">
                  
                <?php 
                	//  If product pic exit 
                  if ($productpicture1 != NULL) 
                  {
                    echo "
                    <li class='span1'>
                       <a href='$productpicture1' class='thumbnail' data-fancybox-group='group1' title='Description 2'><img src='$productpicture1' alt=''>
                       </a>
                    </li>";
                  }
                 ?>

                 <?php 
                  if ($productpicture2 != NULL) 
                  {
                    echo "
                    <li class='span1'>
                       <a href='$productpicture2' class='thumbnail' data-fancybox-group='group1' title='Description 2'><img src='$productpicture2' alt=''>
                       </a>
                    </li>";
                  }
                 ?>

                 <?php 
                  if ($productpicture3 != NULL)
                  {
                    echo "
                    <li class='span1'>
                       <a href='$productpicture3' class='thumbnail' data-fancybox-group='group1' title='Description 2'><img src='$productpicture3' alt=''>
                       </a>
                    </li>";
                  }
                 ?>


                 <?php 
                  if ($productpicture4 != NULL) 
                  {
                    echo "
                    <li class='span1'>
                       <a href='$productpicture4' class='thumbnail' data-fancybox-group='group1' title='Description 2'><img src='$productpicture4' alt=''>
                       </a>
                    </li>";
                  }
                 ?>
                
                </ul>
              </div>
							<div class="span5">
								<address>
									<strong>Product :</strong> <span><?php echo $productname ?></span><br><br>
									<strong>Brand :</strong> <span><?php echo $brandname ?></span><br><br><br>							
								</address>			
								<hr>
								<h4 class="title" align="center"><span class="text"><strong>Bidding</strong> Information</span></h4>
							  <form method="POST" action="auction_product.php?action=add&id=<?php echo $_SESSION['auctionid'] ?>">
								<address>	
							    	<!-- <strong>Ending in :</strong> <span><?php echo $enddate ?></span><br> -->
							    	<strong id="when"></strong> <span id="demo"></span><br>
							    	<strong>Current Bid :</strong> <span>$ <?php echo $currentbid ?></span><br>
							    	<strong>Buyout Price :</strong> <span>$ <?php echo $maxbid ?></span><br><br>
							    	<p style="font-size: 15px; color: blue; ">
							    		<input max="<?php echo($maxbid);?>" type="number" min="<?php echo($amttobid); ?>" name="txtbidprice" placeholder="Eg: $ <?php echo($amttobid) ?>" required	> 
							    		&nbsp; [ <?php echo "$bidtime"; ?> bids ]
							    	</p>
							    	<p style="font-size: 15px;">Enter <?php echo "$amttobid"; ?> US$ or more</p>
							    </address>								

							    <?php 
 
							    	if($startdate > date("Y-m-d") && $starttime < date("H:i:sa") ){
							    		echo "<p style='color:red; cursor:not-allowed;'>Auction has not started.</p>";
							    	}

							    	elseif ($enddate <= date("Y-m-d") && $endtime < date("H:i:sa")){
							    		echo "<p style='color:red; cursor:not-allowed;'>Auction Expired.</p>";
							    	}

							    	else{

										if (isset($_SESSION['user'])) 
										{	
								        	if ($userid != $sellerid) 
								        	{
								        		echo "<p><button type='submit' class='cart-button' name='btn-bit'>Place Bid</button></p>";
								        	}

								        	else
								        	{	
								        		echo "<p style='color:red; cursor:not-allowed;'>You can't buy your products.</p>";
								        	}
								        }

								        else
								        {
								        	 echo "<p><button type='submit' class='cart-button' name='btn-bit'>Place Bid</button></p>";
								             echo "<p style='color:red;'>Please <a>login</a> First to buy a product.</p>";
								        }

								    }

							    ?>
							    </form>
							</div>						
						</div>
						<div class="row">
							<div class="span9">
								<ul class="nav nav-tabs" id="myTab">
									<li class="active"><a href="#home">Description</a></li>
									
								</ul>							 
								<div class="tab-content">
									<div class="tab-pane active" id="home" style="background-color: #f2f2f2; padding:20px;"><?php echo $productdescription ?></div>		
									
								</div>							
							</div>						
						
						</div>	
					</div>

					<div class="span3 col">
            <div class="block"> 
              <ul class="nav nav-list" style="height: 240px; overflow-y: auto; border-bottom: 1px solid #f2f2f2;">
                <li class="nav-header">SUB CATEGORIES</li>
                <?php 

                      $select = "SELECT * FROM subcategory";
                    $run    = mysqli_query($connect, $select); 
                  $count  = mysqli_num_rows($run);   

                  for ($i=0; $i < $count; $i++)   
                  { 
                      $row    = mysqli_fetch_array($run);
                      $sid    = $row['SubCategoryID']; 
                      $sub    = $row['SubCategoryName'];   
                      echo "
                        <li><a href='search_result.php?searchbycate=$sid'>$sub</a></li>
                      ";
                                    }

                                ?>
              </ul><br>

              <ul class="nav nav-list below" style="height: 240px; overflow-y: auto;">
                <li class="nav-header">TOP BRANDS</li>
                <?php 

                      $select = "SELECT * FROM brand";
                    $run    = mysqli_query($connect, $select); 
                  $count  = mysqli_num_rows($run);   

                  for ($i=0; $i < $count; $i++)   
                  { 
                      $row    = mysqli_fetch_array($run);
                      $brand  = $row['BrandName'];
                      $brid   = $row['BrandID'];   
                      echo "
                        <li><a href='brand_search.php?brand=$brid'>$brand</a></li>
                      ";
                                    }
                                ?>

              </ul>
            </div>
	
						<div class="block">									
							<h4 class="title"><strong>Best</strong> Seller</h4>								
							<ul class="small-product">
								<li>
									<a href="#" title="Praesent tempor sem sodales">
										<img src="themes/images/ladies/1.jpg" alt="Praesent tempor sem sodales">
									</a>
									<a href="#">Praesent tempor sem</a> 	
								</li>
								<li>
									<a href="#" title="Luctus quam ultrices rutrum">
										<img src="themes/images/ladies/2.jpg" alt="Luctus quam ultrices rutrum">
									</a>
									<a href="#">Luctus quam ultrices rutrum</a>
								</li>
								<li>
									<a href="#" title="Fusce id molestie massa">
										<img src="themes/images/ladies/3.jpg" alt="Fusce id molestie massa">
									</a>
									<a href="#">Fusce id molestie massa</a>
								</li>   
							</ul>
						</div>
					</div>
				</div>
				<?php include('footer.php');?>
			</section>			
		</div>

		<script src="themes/js/common.js"></script>
		<script>
			$(function () {
				$('#myTab a:first').tab('show');
				$('#myTab a').click(function (e) {
					e.preventDefault();
					$(this).tab('show');
				})
			})
			$(document).ready(function() {
				$('.thumbnail').fancybox({
					openEffect  : 'none',
					closeEffect : 'none'
				});
				
				$('#myCarousel-2').carousel({
                    interval: 2500
                });								
			});
		</script>	

</body>
</html>


