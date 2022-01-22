	<?php
	session_start();
	include('script\functions.php');
	$connect = mysqli_connect("localhost", "root", "", "shophdb");

	// Total item in cart
	if(!empty($_SESSION["shopping_cart"]))  
    {    
        $itemcount = 0;
        foreach($_SESSION["shopping_cart"] as $keys => $values)  
        {  
          $itemcount = $itemcount + 1;
        }

    }

    else
	{ 
        $itemcount = 0;
    }


    $select = "SELECT * FROM Auction WHERE EndDate<CURRENT_DATE ";
	$runau    = mysqli_query($connect, $select); 
	$count  = mysqli_num_rows($runau);

	if($count != NULL)
	{
		for ($i=0; $i < $count; $i++){ 
			$row   = mysqli_fetch_array($runau);
			$auctionid = $row['AuctionID'];
			$status = $row['Status'];
			$customerid = $row['CustomerID'];

			if($customerid == NULL){
				$update = "UPDATE Auction SET Status='Expired' WHERE AuctionID='$auctionid'";
				$run    = mysqli_query($connect, $update);
				if ($run){
				}else{	echo mysqli_error($connect);}
			}

			elseif($customerid != NULL && $status=="Bidding")
			{
				$update = "UPDATE Auction SET Status='Payment Pending' WHERE AuctionID='$auctionid'";
				$run    = mysqli_query($connect, $update);

				$productid  = $row['ProductID'];
				$senderid   = ATTRIBUTE_EXTRACTOR('product', 'ProductID', $productid, 'CustomerID');
				$receiverid = $row['CustomerID'];


				$select = "SELECT *
							FROM customer c, message m, messagereply mr
							WHERE CASE

							WHEN m.sender1 = '$senderid'
							THEN m.sender2 = '$receiverid'

							WHEN m.sender2 = '$senderid'
							THEN m.sender1= '$receiverid'	

							END
							";

				$run = mysqli_query($connect, $select);
				$count = mysqli_num_rows($run);

				if ($count == 0)  
				{	
					$messageid 	    = ID_MAKER('message', 'MessageID');
					$messagereplyid = ID_MAKER('messagereply', 'MessageReplyID');
		        	$date      = date('Y-m-d'); 
		        	$time      = date('H:i:s');

					$Insert    = "INSERT INTO `message` VALUES ('$messageid', '$senderid','$receiverid')";
		            $run = mysqli_query($connect, $Insert);  

		            $Insert2    = "INSERT INTO `messagereply` 
		            			  VALUES ('$messagereplyid', '$date','$time',
		            			   'Your won the auction. Please Check your Order History to checkout',
		            			    '', '$senderid', '$messageid')";

		            $run2 = mysqli_query($connect, $Insert2); 
				}

				else
				{	
					$rowmsg   = mysqli_fetch_array($run);
					$messagereplyid = ID_MAKER('messagereply', 'MessageReplyID');
					$messageid  = $rowmsg['MessageID'];
			        $date       = date('Y-m-d'); 
			        $time       = date('H:i:s');
			        $productid  = $row['ProductID'];
					$senderid   = ATTRIBUTE_EXTRACTOR('product', 'ProductID', $productid, 'CustomerID');
					$receiverid = $row['CustomerID'];

			        $Insert2    = "INSERT INTO `messagereply` 
			            		   VALUES ('$messagereplyid', '$date','$time', 'Your won the auction. Please Check your Order History to checkout', '', '$senderid', '$messageid')"; 
			        $run2 = mysqli_query($connect, $Insert2);   
				}
			}
		}
	} 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-with, initial-scale=1.0">	
		<meta name="description" content="">	
		
		<!-- Favicon -->
        <link rel="icon" href="themes/images/favicon.png">
		<!-- bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">      
		<link href="bootstrap/css/bootstrap-responsive.min.css"z rel="stylesheet">
		<link href="themes/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->
		<link href="themes/css/flexslider.css" rel="stylesheet"/>
		<link href="themes/css/maincss.css" rel="stylesheet"/>	

		<!-- scripts -->
		<script src="themes/js/jquery-1.7.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>				
		<script src="themes/js/superfish.js"></script>
		<script src="themes/js/jquery.scrolltotop.js"></script>
			
	    <!-- Custom CSS -->
	    <link rel="stylesheet" type="text/css" href="themes/css/style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">	
</head>
			
<body>
		<div id="top-bar" class="container">
			<div class="row">	
				<div class="span4">
					<form method="POST" class="search_form" action="search_result.php">
						<input type="text" name="txtsearchShop" class="input-block-level search-query" Placeholder="Search in shop . . .">
					</form>
				</div>
				<div class="span8">
					<div class="account pull-right">	

						<ul class="user-menu">

						<li><a href="home.php"><i class="fas fa-home"></i>	Home</a></li>

							<?php  
								if (isset($_SESSION['user']) && $_SESSION['user'] != '')
								{
									echo "<li><a href='customer_details.php'><i class='fas fa-user'></i> My Account</a></li>
									<li><a href='order_history.php'><i class='fas fa-history'></i> Order History</a></li>
									<li><a href='message_inbox.php'><i class='fas fa-envelope'></i> Message 0</a></li>";
								}
							?>			

								<li><a href="shopping_cart.php"><i class="fas fa-shopping-cart"></i>	<?php echo "$itemcount"; ?></a></li>

							<?php  
								if (isset($_SESSION['user']) && $_SESSION['user'] != ''){
									echo "
									<li><a href='logout.php'><i class='fas fa-sign-out-alt'></i> Logout</a></li>";
								}
								else{
									echo "<li><a href='login.php'><i class='fas fa-sign-in-alt'></i> Login</a></li>"; 
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
					<a href="home.php" class="logo pull-left"><img src="themes/images/logo.png" width="15%" height="15%" class="site_logo" alt=""></a>
					<nav id="menu" class="pull-right">
						<ul>

								<?php
								if (isset($_SESSION['user']) && $_SESSION['user'] != ''){
									$email = $_SESSION['user'];
									$selectseller = "SELECT * FROM Customer WHERE CustomerEmail='$email'";
									$runseller = mysqli_query($connect, $selectseller);
									$countseller = mysqli_num_rows($runseller);
									for ($j=0;$j<$countseller;$j++){
										$rowseller = mysqli_fetch_array($runseller);
										$verification = $rowseller['CustomerasSeller'];
										if($verification =='1'){
											echo "<li><a>Seller Tools </a><ul>";
											echo "<li><a>Catalog &#10148;</a>
													<ul><li><a href='add_product.php'>Add Product</a></li>
											            <li><a href='products_list.php'>Product List</a></li>
											            <li><a href='add_auction.php'>Create Auction</a></li>
											            <li><a href='auction_list.php'>Auction List</a></li>
											        </ul>	
											      </li>";

											echo "<li><a>Advertisement &#10148;</a>
													<ul><li><a href='add_advertisement.php'>Add Advertisement</a></li>	
											            <li><a href='advertisement_list.php'>Advertisement List</a></li>
											        </ul>	
											      </li>";

											echo "<li><a href='seller_home.php'>Seller Dashboard</a></li>";

									echo "	</ul></li>";
										}
									}
								}
							?>

							<li><a href="auction_home.php">Auctions</a></li>
							<?php

								$selectcat = "SELECT * FROM Category";
								$runcat = mysqli_query($connect, $selectcat);
								$countcat = mysqli_num_rows($runcat);
								for ($i=0;$i<$countcat;$i++){
									$rowcat = mysqli_fetch_array($runcat);
									$categoryid = $rowcat['CategoryID'];
									$categoryname = $rowcat['CategoryName'];
									echo "<li><a>$categoryname</a><ul>";

									$selectsubcat = "SELECT * FROM SubCategory WHERE CategoryID='$categoryid'";
									$runsubcat = mysqli_query($connect, $selectsubcat);
									$countsubcat = mysqli_num_rows($runsubcat);
									for ($j=0;$j<$countsubcat;$j++){
										$rowsubcat = mysqli_fetch_array($runsubcat);
										$subcategoryid = $rowsubcat['SubCategoryID'];
										$subcategoryname = $rowsubcat['SubCategoryName'];
										echo "<li><a href='search_result.php?searchbycate=$subcategoryid' >$subcategoryname</a></li>";
									}
									echo "</ul></li>";
								}
							?>


						
						</ul>
					</nav>
				</div>
			</section>		
	
</body>
</html>