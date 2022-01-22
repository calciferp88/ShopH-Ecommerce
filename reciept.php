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

	if (isset($_GET['orderid']))
	{
		$orderid = $_GET['orderid'];

		$select  = "SELECT * FROM checkout WHERE CheckoutID = '$orderid' ";
		$run     = mysqli_query($connect, $select);
		$row     = mysqli_fetch_array($run);
		$customerid   = $row['SellerID'];
		$payment      = $row['PaymentType'];
		$add         = $row['FullAddress'];	
		$totalprice   = $row['TotalPrice'];
		$status       = $row['Status'];
		$customer     = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerID', $customerid, 'CustomerName');
		$subtotal     = 0;

		$select2  = "SELECT * FROM delivery WHERE OrderID = '$orderid' ";
		$run2     = mysqli_query($connect, $select2);
		$row2     = mysqli_fetch_array($run2);
		if(isset($row2['DeliveryStaffID']) && $row2['DeliveryStaffID'] != ''){
			$staffid  = $row2['DeliveryStaffID'];
			$staffname    = ATTRIBUTE_EXTRACTOR('deliverystaff', 'DeliveryStaffID', $staffid, 'DeliveryStaffName');
			$staffphone   = ATTRIBUTE_EXTRACTOR('deliverystaff', 'DeliveryStaffID', $staffid, 'DeliveryStaffPhone');
			$arrivedate  = $row2['ArriveDate'];
		}

		
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
				background-color: white;
			}

			.form-group
			{
				width: 100%;

			}

			.shoph
			{
				display: block;
				margin-left: auto;
				margin-right: auto;
				width: 45%;
			}

			.reciept-form
			{
				background-color: #feece7;
				width: 70%;
				margin-left: auto;
				margin-right: auto;
				padding: 30px;
			}

			.container-lit p
			{
				font-size: 17px;

			}

			hr
			{
				border-color: black;
				height: 1px;
			}

			.print
			{
				background-color: #ee3e0d;
			    height: 45px;
			    width: 70px;
			    color: white;
			    font-size: 15px;
			    border-radius: 8px;
			}

			.rowx
			{
				display: flex;
				width: 95%;
				margin-left: auto;
				margin-right: auto;
			}

			.col-50
			{
				flex: 50%;
			}

			.container-li
			{
				margin-right: 15px;
				padding: 30px;
				box-shadow: 0px 0px 10px #bfbfbf;
				padding: 30px;
			}

			.container-li button
			{
				border: 1px solid #ee3e0d;
				margin: auto;
				display: block;
				margin-top: 30px;
				padding: 10px;
				width: 100px;
				font-weight: bold;
				color: #ee3e0d;
				font-size: 14px;
				box-shadow: 0px 0px 5px #ee3e0d;
			}

			.container-li button:hover
			{
				background-color: #ee3e0d;
				color: white;
				box-shadow: none;
			}

			.container-lit					
			{
				margin-right: 15px;
				padding: 30px;
				box-shadow: 0px 0px 10px #bfbfbf;
				padding: 30px;
			}

			td span, p span
			{
				font-weight: bold;
			}

			.table-responsive label
			{
				width: 100%;
				font-size: 15px;
				font-weight: bold;
				text-align: center;
				color: #ee3e0d;
			}

			.delivered-status
			{
				background-color: #f2f2f2;
				padding: 20px;	
			}

			.delivered-status p
			{
				font-size: 15px;
			}

	
		</style>
 			
	</head>

    <body>		

    	<br><br>

		<div class="rowx">

			<div class='col-50 container-li'>

				<?php 

					if ($status == 'Pending') 
					{
						echo "
			    			<img src='themes/images/order.gif' class='shoph'>
							<section class='header_text'>	
								Your Order is <span>$status</span><br>
								<span>Stay Tune</span><br>
							 	Your items will be delivered Soon !
							</section>	
	      					";
					}

					else if ($status == 'Delivered') 
					{
						echo "
			    			<img src='themes/images/deliver.gif' class='shoph'>
							<section class='header_text'>	
								Your Order is <span>$status</span><br>
							 	Please get ready to <span>Pick Up </span>these items !
							</section>

							<section class='delivered-status'>	
								<p>Delivery Staff : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span> &nbsp;&nbsp; $staffname</span></p>
								<p>Contact Number : &nbsp;&nbsp;<span>&nbsp; $staffphone</span></p>
								<p>Arrive Date : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>&nbsp; $arrivedate</span></p>
							</section>
						
						";
					}

					else if ($status == 'Pending Deliver')
					{
						echo "
			    			<img src='themes/images/calling.gif' class='shoph'>
							<section class='header_text'>	
								Your items are handed to <span>Grab Delivery</span> Company <br>
							 	Delivery Staff will <span>Contact You </span>soon !
							</section>
						
						";
					}

					else
					{
						echo "
			    			<img src='themes/images/thank.gif' class='shoph'>
							<section class='header_text'>	
								Your order is <span>Finished</span> <br>
							 	Thanks for shopping at ShopH.com
							</section>
						
						";
					}

				 ?>


				<button>
					Get Help
				</button>
			</div>
			

			<div class="col-50 container-lit">

				<h4>Order Details</h4>
				<h4 class="title" align="center"></h4>

				<p>OrderID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span> &nbsp;&nbsp; # <?php echo "$orderid"; ?></span></p>
				<p>Seller Name&nbsp;&nbsp;<span>&nbsp;&nbsp; <?php echo "$customer"; ?></span></p>
				<p> Payment &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span> &nbsp;&nbsp; <?php echo "$payment"; ?></span></p>
				<p>Delivery Address&nbsp;&nbsp;&nbsp;<span>&nbsp;&nbsp; <?php echo "$add"; ?></span></p>

				<h4 class="title" align="center"></h4>
				<div class="table-responsive">  

					<table>
						

		            <?php 

			                $select = "SELECT * FROM checkoutproduct WHERE CheckoutID = '$orderid' ";
			                $run    = mysqli_query($connect, $select);
							$count  = mysqli_num_rows($run);

							for ($i=0;$i<$count;$i++)
							{

								$row = mysqli_fetch_array($run);
									$pid   = $row['ProductID'];
			                        $product = ATTRIBUTE_EXTRACTOR('Product', 'ProductID', $pid, 'ProductName');
		                        $price   = ATTRIBUTE_EXTRACTOR('Product', 'ProductID', $pid, 'Price');
		                        $qty   = $row['Quantity'];
		                        $res   = $qty*$price;
		             ?> 

		                <tr>
		                	<td><?php echo "$product"; ?></td>
		                	<td>x <?php echo "$qty"; ?></td>
		                	<td>US Dollar <span><?php echo "$res"; ?></span></td>
		                </tr>

		              

		            <?php 

		            $subtotal = $subtotal + $res;

					}  ?>

		                <tr >
		                	<td style="border-bottom: none;"><span>Total</span></td>
		                	<td style="border-bottom: none;"></td>
		                	<td style="border-bottom: none;"> <span>US Dollar<?php echo "$subtotal"; ?></span>
		                </tr>
					</table>

					<label>Thanks for your shopping at Shop.com !</label>
			    </div>
			</div>

		</div><br><br>


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

