	<?php 
		include('header.php');
		$connect = mysqli_connect('localhost','root','','shophdb');

		if(isset($_SESSION['user']))
		{
		  $myemail = $_SESSION['user'];
		  $myid    = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $myemail, 'CustomerID');
		  $month   = date('m');
		  $year    = date('Y');

		  $selectsale_m = "
		  	SELECT * FROM checkout c, checkoutproduct cp, customer cus
		  	WHERE c.CheckoutID = cp.CheckoutID 
		  	AND c.CustomerID = cus.CustomerID 
		  	AND c.SellerID = '$myid'
		  	AND c.CheckoutMonth = '$month'	
		  	AND c.CheckoutYear  = '$year'		
		  ";

		    $runsale_m    = mysqli_query($connect, $selectsale_m); 
		    $countsale_m  = mysqli_num_rows($runsale_m);   

		    $selectsale = "
		  	SELECT * FROM checkout c, checkoutproduct cp, customer cus
		  	WHERE c.CheckoutID = cp.CheckoutID
		  	AND c.CustomerID = cus.CustomerID
		  	AND c.SellerID = '$myid'
		  ";

		    $runsale    = mysqli_query($connect, $selectsale); 		
		    $countsale  = mysqli_num_rows($runsale);  		
		    $totalincome = 0;

		    $selectincome = "
		  	SELECT * FROM checkout c, checkoutproduct cp, product p
		  	WHERE c.CheckoutID = cp.CheckoutID
		  	AND p.ProductID = cp.ProductID
		  	AND c.SellerID = '$myid'
		  ";											

			    $runincome    = mysqli_query($connect, $selectincome); 
			    $countincome  = mysqli_num_rows($runincome);   
		    for ($i=0; $i < $countincome; $i++) 
		    { 
			    $rowincome   = mysqli_fetch_array($runincome);
			    $price       = $rowincome['Price']; 
			    $quantity    = $rowincome['Quantity'];

			    $totalincome =$totalincome + ($price*$quantity);

			}

		}	

		else
		{
		  echo "<script>
				  alert('Please Login First !');
				  window.location.assign('login.php');		
				</script>";
	    }		

	    if (isset($_GET['deliverit']))
		{
			$checkoutid = $_GET['deliverit'];

			$update = "UPDATE checkout SET Status = 'Pending Deliver' WHERE CheckoutID = '$checkoutid'";
			$runup  = mysqli_query($connect, $update);

			if ($runup) 	
			{		
				echo "<script>
					alert('Thiese items are delivered');
					window.location.assign('seller_home.php');
				</script>";
			}

		}	


	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Seller Home | ShopH</title>

		<style type="text/css">
			.row 
			{
				display: flex;
			}

			.col-2
			{
				flex: 50%;
			}	

			.col-3
			{
				flex: 33.33%;
				background-color: #333333;
				margin: 30px;
				border-radius: 10px;
			}

			.col-3:hover
			{		
				background-color: black;
			}

			.col-3 label
			{	
				text-align: center;									
				font-size: 15px;
				font-weight: bold;
				color: white;
				text-shadow: 0px 0px 5px #ee3e0d;
				padding-top: 10px;
			}	

			.col-3 p
			{
				text-align: center;
				font-size: 15px;
				font-weight: bold;
				color: #f2f2f2;
			}			
			
			.col-3 p span	
			{	
				font-weight: bold;
				color: #ee3e0d;
				text-shadow: 0px 0px 2px black;
			}

			    tr th
				{	
					text-align: center;
					font-size: 15px;
					padding: 15px;
					background-color: white;
				}

				tr td 
				{
					text-align: center;
					font-size: 15px;
				}	

				tr:nth-child(even) 
				{
				  background-color: white;
				}

				.best-seller:hover
				{
					box-shadow: 0px 0px 5px #a6a6a6;
				}


		</style>

	</head>
		
	<body>

		<div class="container-fluid">
			<br><br>
			<div class="row">
				
				<div class="col-3">
					<label>Sales This Month</label><br>
					<p><span><?php echo "$countsale_m"; ?></span> Sales</p>
				</div>

				<div class="col-3">
					<label>Total Sales</label><br>		
					<p><span><?php echo "$countsale"; ?></span> Sales</p>
				</div>

				<div class="col-3">
					<label>Total Income This Month</label><br>		
					<p>US$ <span><?php echo "$totalincome"; ?></span></p>
				</div>

			</div>

			<div class="form-group">		
				<h4 class="title" align="center"><span class="text"> <strong> Pending </strong> Orders</span></h4>
		    </div>	

		    	<table layout="fixed" border='1' >

	  			<tr style='font-weight:bold;'>
	  				<td>OrderID</td>
	  				<td>Customer</td>
	  				<td>Checkout Date</td>
	  				<td>Payment Type</td>
	  				<td>Products</td>
	  				<td>Action</td>
	  			</tr>

	  			<?php 
	  				$selectcat = "
	  					SELECT * FROM checkout c, customer cus
					  	WHERE c.SellerID = cus.CustomerID
					  	AND c.Status = 'Pending'
					  	AND c.SellerID = '$myid'";
					$runcat = mysqli_query($connect, $selectcat);
					$countcat = mysqli_num_rows($runcat);

					for ($i=0;$i<$countcat;$i++)	
					{
						$rowcat = mysqli_fetch_array($runcat);
						$orderid      = $rowcat['CheckoutID'];
						$checkoutdate = $rowcat['CheckoutDate'];
						$payment     = $rowcat['PaymentType'];
						$customerid  = $rowcat['CustomerID'];
					    $customer    = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerID', $customerid, 'CustomerName');

						echo "<tr><td>Order. $orderid</td><td>$customer</td>";
						echo "<td>$checkoutdate</td><td>$payment</td>";
						echo "<td>";

						$selectsubcat = "
							SELECT * FROM checkout c, checkoutproduct cp, product p 
							WHERE c.CheckoutID = cp.CheckoutID
							AND   cp.ProductID = p.ProductID
							AND   c.CheckoutID = '$orderid' ";

						$runsubcat = mysqli_query($connect, $selectsubcat);
						$countsubcat = mysqli_num_rows($runsubcat);

						for ($j=0; $j<$countsubcat;$j++)
						{
							$rowsubcat = mysqli_fetch_array($runsubcat);
							$product = $rowsubcat['ProductName'];
							$quantity = $rowsubcat['Quantity'];
							$Price = $rowsubcat['Price'];
							echo "<ul>
									<li>$product ( $ $Price x $quantity )</li>
								 </ul>";
						}
						echo "</td><td>";

						echo "
						       <a href='seller_home.php?deliverit=$orderid'>Deliver</a> 
							 ";
					
						echo "</td></tr>";
					}

	  			?>

	  			</table><br><br>

	  			<div class="form-group">		
				<h4 class="title" align="center"><span class="text"> <strong> Completed </strong> Orders</span></h4>
		    </div>	

		    	<table layout="fixed" border='1' >

	  			<tr style='font-weight:bold;'>	
	  				<td>OrderID</td>
	  				<td>Customer</td>
	  				<td>Checkout Date</td>
	  				<td>Payment Type</td>
	  				<td>Products</td>
	  				<td>Action</td>
	  			</tr>

	  			<?php 
	  				$selectcat =	"SELECT * FROM checkout c, customer cus
					  	WHERE c.SellerID = cus.CustomerID
					  	AND   c.SellerID = '$myid'
					  	AND   c.Status = 'Finished' ";

					$runcat = mysqli_query($connect, $selectcat);
					$countcat = mysqli_num_rows($runcat);

					for ($i=0;$i<$countcat;$i++)	
					{
						$rowcat = mysqli_fetch_array($runcat);
						$orderid      = $rowcat['CheckoutID'];
						$checkoutdate = $rowcat['CheckoutDate'];
						$payment      = $rowcat['PaymentType'];
						$customerid   = $rowcat['CustomerID'];
					    $customer     = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerID', $customerid, 'CustomerName');

						echo "<tr><td>Order. $orderid</td><td>$customer</td>";
						echo "<td>$checkoutdate</td><td>$payment</td>";
						echo "<td>";

						$selectsubcat = "
							SELECT * FROM checkout c, checkoutproduct cp, product p 
							WHERE c.CheckoutID = cp.CheckoutID
							AND   cp.ProductID = p.ProductID
							AND   c.CheckoutID = '$orderid' ";

						$runsubcat = mysqli_query($connect, $selectsubcat);
						$countsubcat = mysqli_num_rows($runsubcat);

						for ($j=0; $j<$countsubcat;$j++)
						{
							$rowsubcat = mysqli_fetch_array($runsubcat);
							$product = $rowsubcat['ProductName'];
							$quantity = $rowsubcat['Quantity'];
							$Price = $rowsubcat['Price'];
							echo "<ul>
									<li>$product ( $ $Price x $quantity )</li>
								 </ul>";
						}
						echo "</td><td>";

						echo "
						       <a href='reciept.php?orderid=$orderid'>Track</a> 
							 ";
					
						echo "</td></tr>";
					}

	  			?>

	  			</table>

		      <h4>Best Sellers</h4> 
			  <hr>

		    <div class="div-best">

			    <?php 

			    	$selectbest = "SELECT * FROM `product` WHERE CustomerID = '$myid' AND TotalSale != '0' ORDER BY TotalSale LIMIT 3";
			    	$runbest    = mysqli_query($connect, $selectbest); 
					$countbest  = mysqli_num_rows(	$runbest);  

						    for ($i=0; $i < $countbest; $i++) 
				            { 
				                  $rowbest     = mysqli_fetch_array($runbest);
				                  $pid         = $rowbest['ProductID']; 
				                  $name        = $rowbest['ProductName']; 
				                  $image       = $rowbest['ProductPicture0']; 
				            		
			     ?>		

			     <a href="product.php?productid=<?php echo $pid ?>">
			     	<img class="best-seller" src="<?php echo($image) ?>" width="20%">
			     </a> 
				
				<?php 
				  }

				  if ($countbest == 0) 
				  {
				  	echo "<p style='color:red; font-weight:560; font-size:17px;'>Oops! You haven't made any sale yet.</p>";
				  }
				 ?>

			</div>


		</div>	
	</body>


	</html>
	<?php include('footer.php'); ?>