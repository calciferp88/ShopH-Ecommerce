<?php
	include('delivery_header.php');

	$connect = mysqli_connect("localhost", "root", "", "shophdb");

	$staffidsession = $_SESSION['user'];
    $staffroletest   = ATTRIBUTE_EXTRACTOR('deliverystaff', 'DeliveryStaffEmail', $staffidsession, 'DeliveryStaffRole');

    // Send delivery admin to delivery home
    if ($staffroletest == 'Admin') 
    {
    					echo "<script>
						window.location.assign('delivery_home.php');
						</script>";
    }

    if (isset($_SESSION['user'])) 
    {
		$staffidsession = $_SESSION['user'];
   		$staffid   = ATTRIBUTE_EXTRACTOR('deliverystaff', 'DeliveryStaffEmail', $staffidsession, 'DeliveryStaffID');
    	$staffname  = ATTRIBUTE_EXTRACTOR('deliverystaff', 'DeliveryStaffEmail', $staffidsession, 'DeliveryStaffName');
    	$staffphone = ATTRIBUTE_EXTRACTOR('deliverystaff', 'DeliveryStaffEmail', $staffidsession, 'DeliveryStaffPhone');
    }

    // Finish delivery case
    if (isset($_POST['finish-delivery'])) 
    {
    	$checkoutid = $_POST['txtorderid'];

    	$update = "UPDATE checkout SET Status = 'Finished' WHERE CheckoutID = '$checkoutid'";
		$runupdate = mysqli_query($connect, $update);

		$update2 = "UPDATE deliverystaff SET Status = 'Free' WHERE DeliveryStaffID = '$staffid'";
		$runupdate2 = mysqli_query($connect, $update2);

		if ($runupdate2) 
		{
			echo "<script>
			alert('Your Delivery is Done !');
			window.location.assign('delivery_staffpage.php');
			</script>";
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
	<title> <?php echo"$staffname";?>'s Delivery | ShopH</title>
	<style type="text/css">
		.section
		{
			padding: 30px;
			box-shadow: 0px 0px 10px #b3b3b3;
			margin:30px;
		}

		.section p
		{
			font-size: 17px;
		}

		.section p span
		{
			font-weight: bold;
		}

		.section button
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

		<h4 class="title" align="center"><span class="text"><strong>Your</strong> Deliverys</span></h4>

		<?php 
				$orderid = $_GET['orderid'];
				$select	= "SELECT * FROM delivery d, checkout c
						   WHERE d.OrderID = c.CheckoutID
						   AND c.CheckoutID = '$orderid'
						   AND c.Status = 'Delivered'
						   AND d.DeliveryStaffID = '$staffid'
						   ";
				$run    = mysqli_query($connect, $select);
				$count  = mysqli_num_rows($run);

				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($run);
					$orderid     = $row['OrderID'];	
					$Arrivedate  = $row['ArriveDate'];	
					$address     = ATTRIBUTE_EXTRACTOR('checkout', 'CheckoutID', $orderid, 'FullAddress');
					$total       = ATTRIBUTE_EXTRACTOR('checkout', 'CheckoutID', $orderid, 'TotalPrice');
					$customerid  = ATTRIBUTE_EXTRACTOR('checkout', 'CheckoutID', $orderid, 'CustomerID');
					$cuscontact  = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $customerid, 'CustomerPhone');
					$customername  = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $customerid, 'CustomerName');
		 ?>

		<div class="section">
			<form action="delivery_staffpage.php" method="POST">
				<p>Order ID  : <span>#<?php echo "$orderid"; ?></span></p>
				<p>Customer  : <span><?php echo "$customername"; ?></span></p>
				<p>Address   : <span><?php echo "$address"; ?></span></p>
				<p>Phone Number  : <span><?php echo "$cuscontact"; ?></span></p>
				<p>Deliver Until : <span style="color: red;"><?php echo "$Arrivedate"; ?></span></p><br>
				<input type="hidden" name="txtorderid" value="<?php echo($orderid) ?>">

				<button type="submit" name="finish-delivery">Delivery Finished</button><br><br>
				*click this button when your delivery is finished*
			</form>
		</div>


		<?php } ?>

		<?php 

			if ($count == 0) 
			{
				echo "<span style='color: red'>No Delivery Yet</span>";
			}

		 ?>

</body>
</html>
<?php 	include('footer.php'); ?>