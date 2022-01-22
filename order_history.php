<?php 

	$connect = mysqli_connect('localhost','root','','shophdb');
	include('header.php');

	if (!isset($_SESSION['user'])) 
	{
	   echo "<script>
				alert('Please Login First');
				window.location.assign('login.php');
			</script>";
	}

	else
	{
	   $cusemail     = $_SESSION['user'];
	   $customerid   = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $cusemail, 'CustomerID');
	   $customername = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $cusemail, 'CustomerName');
	}
	
?>

<html>

	<head>

		<title>Your Orders | ShopH</title>	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">      
		<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="themes/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->			
		<link href="themes/css/flexslider.css" rel="stylesheet"/>
		<link href="themes/css/Main2.css" rel="stylesheet"/>	

    	<!-- Custom CSS -->
    	<link rel="stylesheet" type="text/css" href="themes/css/generalcss.css">
 			
		<!-- scripts -->
		<script src="themes/js/jquery-1.7.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>							
		<script src="themes/js/superfish.js"></script>	
		<script src="themes/js/jquery.scrolltotop.js"></script>

		<style type="text/css">

			table
			{
				margin-bottom: 40px;
			}

			tr th
			{
				text-align: center;
				font-size: 15px;
				padding: 15px;
			}


			tr td 
			{
				text-align: center;
				font-size: 15px;
			}

			tr:nth-child(even) 
			{
			  background-color: #f2f2f2;
			}

		</style>
 			
	</head>

    <body>		

	    <section class="header_text">	
			Welcome To <span>ShopH.com</span>
		</section>

		<div class="form-group">
			<h4 class="title" align="center"><span class="text"><strong> Your</strong> Won Auctions</span></h4>
		</div>


		<div class="table-responsive">  
			<table>
				<tr>  
                    <th width="30%">Product</th> 
                    <th width="20%">Final Bid</th>  
                    <th width="30%">End Date Time</th>  
                    <th width="20%">Action</th>  
                </tr> 

            <?php 

                $select = "SELECT * FROM Auction 
                		   WHERE EndDate<CURRENT_DATE 
                		   AND CustomerID = '$customerid' 
                		   AND Status = 'Payment Pending' ";
				$runau    = mysqli_query($connect, $select); 
				$count  = mysqli_num_rows($runau);

				if($count != NULL)
				{
					for ($i=0; $i < $count; $i++)
					{ 
						$row   = mysqli_fetch_array($runau);
						$auctionid = $row['AuctionID'];
						$productid = $row['ProductID'];
                 	    $enddate   = $row['EndDate']; 
                 	    $endtime   = $row['EndTime']; 
                  		$cbid      = $row['CurrentBid']; 
				   	    $product    = ATTRIBUTE_EXTRACTOR('product', 'ProductID', $productid, 'ProductName');
             ?> 

                <tr>
                	<td><?php echo "$product"; ?></td>
                	<td><?php echo "$cbid"; ?></td>
                	<td><?php echo "$enddate | $endtime"; ?></td>
                	<td><a href="checkout.php?auctioncheckout&&auctionid=<?php echo($auctionid) ?>">Purchase Now</a></td>
                </tr>

            <?php } }?>
			</table>

		</div>

		<div class="form-group">
			<h4 class="title" align="center"><span class="text"><strong> <?php echo "$customername"; ?>'s </strong> Order History</span></h4>
		</div>


		<div class="table-responsive">  
			<table>
				<tr>  
                    <th width="15%">OrderID</th> 
                    <th width="15%">Order Date</th>  
                    <th width="15%">PaymentTypet Type</th>  		
                    <th width="30%">Full Address</th>  
                    <th width="15%">Status</th>   
                    <th width="10%">Action</th>  
                </tr> 

            <?php 

                $select = "SELECT * FROM checkout WHERE CustomerID = '$customerid' ";
                $run    = mysqli_query($connect, $select);
				$count  = mysqli_num_rows($run);

				for ($i=0;$i<$count;$i++)
				{

					$row = mysqli_fetch_array($run);
					$orderid   = $row['CheckoutID'];
					$orderdate = $row['CheckoutDate'];
					$paymenttype = $row['PaymentType'];
					$Fulladdress = $row['FullAddress'];
					$status      = $row['Status'];

             ?> 

                <tr>
                	<td><?php echo "$orderid"; ?></td>
                	<td><?php echo "$orderdate"; ?></td>
                	<td><?php echo "$paymenttype"; ?></td>
                	<td><?php echo "$Fulladdress"; ?></td>
                	<td><?php echo "$status"; ?></td>
                	<td><a href="reciept.php?orderid=<?php echo($orderid) ?>">Track</a></td>
                </tr>

            <?php } ?>
			</table>

		</div>

	    <?php include('footer.php'); ?>

    </body>

    <script src="themes/js/common.js"></script>
		<script src="themes/js/jquery.flexslider-min.js"></script>
		<script type="text/javascript">
			$(function() {
				$(document).ready(function() {
					$('.flexslider').flexslider({
						animation: "fade",
						slideshowSpeed: 4000,
						animationSpeed: 600,
						controlNav: false,
						directionNav: true,
						controlsContainer: ".flex-container" // the container that holds the flexslider
					});
				});
			});

		</script>
</html>

