<?php

	include('delivery_header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');


	$staffidsession = $_SESSION['user'];
    $staffroletest   = ATTRIBUTE_EXTRACTOR('deliverystaff', 'DeliveryStaffEmail', $staffidsession, 'DeliveryStaffRole');

    if ($staffroletest != 'Admin') 
    {
    	echo "<script>
		alert('You do not have access permission to this page !');
		window.location.assign('delivery_home.php');
		</script>";
    }

    // Order retrieve 
	if (isset($_GET['orderid']))
	{
		$orderid = $_GET['orderid'];

		$select  = "SELECT * FROM checkout WHERE CheckoutID = '$orderid' ";
		$run     = mysqli_query($connect, $select);
		$row     = mysqli_fetch_array($run);
		$customerid   = $row['SellerID'];
		$payment      = $row['PaymentType'];
		$add          = $row['FullAddress'];
		$totalprice   = $row['TotalPrice'];
		$status       = $row['Status'];
		$customer     = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerID', $customerid, 'CustomerName');	
	}

	// Confirm delivery 
	if (isset($_POST['delivery-com'])) 
	{	
		$deliveryid    = ID_MAKER('delivery', 'DeliveryID');
		$deliverystaff = $_POST['deliverystaff'];
		$checkoutid    = $_POST['orderid'];
		$deldate       = $_POST['arrivedate'];

		$insert = "INSERT INTO delivery 
				   VALUES('$deliveryid', '$checkoutid', '$deliverystaff', '$deldate')";
		$run = mysqli_query($connect, $insert);

			if($run)
			{
				$update = "UPDATE checkout SET Status = 'Delivered' WHERE CheckoutID = '$checkoutid'";
				$runupdate = mysqli_query($connect, $update);

				if ($runupdate) 
				{
					echo "<script>
					alert('Delivery is confirmed !');
					window.location.assign('delivery_home.php');
					</script>";
				}

				else
				{
					echo mysqli_error($connect);
				}
			}	
	}

?>

<!DOCTYPE html>
<html>

<head>

	<title>Action Delivery | ShopH</title>

	<style type="text/css">

		.order-detail, .order-manage
		{
			box-shadow: 0px 0px 10px #cccccc;
			margin:30px;
			padding: 30px;
		} 

		.order-detail p
		{
			font-size: 18px;
		}

		.order-detail p span
		{
			font-weight: bold;
		}

		.order-manage label	
		{
			font-size: 15px;
			padding-bottom: 10px;
			font-weight: bold;
		}


		.order-manage button
		{	
			margin-top: 10px; 
			padding: 8px;
			border: none;
			background-color: #ee3e0d;
			color: white;
		}

	</style>

</head>

<body>
		
	<!-- Display DElivery info -->
	<div class="order-detail"> 
		<p>OrderID : <span><?php echo "$orderid"; ?></span></p>
		<p>Total Price : <span>$ <?php echo "$totalprice"; ?></span></p>
		<p>Payment : <span><?php echo "$payment"; ?></span></p>
		<p>Address : <span><?php echo "$add"; ?></span></p>
	</div>

	<div class="order-manage">
		<form action="delivery_action.php?orderid=<?php echo($orderid) ?>" method="POST">
			
			<label for="deliverystaff">Choose Delivery Staff </label>
			<select name="deliverystaff">

						<?php 
							$select = "SELECT * FROM deliverystaff WHERE DeliveryStaffRole = 'Delivery Staff' ";
							$run = mysqli_query($connect, $select);
							$count = mysqli_num_rows($run);

							for ($i=0;$i<$count;$i++){
								$row = mysqli_fetch_array($run);
								$ID = $row['DeliveryStaffID'];
								$Name = $row['DeliveryStaffName'];
							echo "<option value='$ID'> $Name </option>";
							};
						?>
			</select>


			<label for="arrivedate">Choose Delivery Date </label>
			<input type="date" name="arrivedate" min="<?= date('Y-m-d'); ?>" required><br>
			<input type="hidden" name="orderid" value="<?php echo($orderid) ?>"><br>

			<button type="submit" name="delivery-com">
				Confirm Delivery
			</button>

		</form>
	</div>


</body>

</html>

<?php 	include('footer.php'); ?>

