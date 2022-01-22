<?php
	include('delivery_header.php');

	$connect = mysqli_connect("localhost", "root", "", "shophdb");

	$staffidsession = $_SESSION['user'];
    $staffroletest   = ATTRIBUTE_EXTRACTOR('deliverystaff', 'DeliveryStaffEmail', $staffidsession, 'DeliveryStaffRole');

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

		<h4 class="title" align="center"><span class="text"><strong>Your</strong> Deliverys</span></h4>

	<div class="table-responsive">  
			<table>

				<tr>  
                    <th width="30%">Delivery Address</th> 
                    <th width="10%">Customer Name</th>  	
                    <th width="10%">Contact Number</th>  		
                    <th width="15%">Payment Type</th>  
                    <th width="15%">Total Amount</th>   
                    <th width="10%">Deliver Until</th>  
                    <th width="10%">Action</th>  	
                </tr> 


            <?php 

                $select	= "SELECT * FROM delivery d, checkout c
					   WHERE d.OrderID = c.CheckoutID
					   AND c.Status = 'Delivered'
					   AND d.DeliveryStaffID = '$staffid'
					   Order BY d.Arrivedate";
				$run    = mysqli_query($connect, $select);
				$count  = mysqli_num_rows($run);

			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($run);
				$orderid     = $row['OrderID'];	
				$Arrivedate  = $row['ArriveDate'];	
				$Payment  = $row['PaymentType'];	
				$address     = ATTRIBUTE_EXTRACTOR('checkout', 'CheckoutID', $orderid, 'FullAddress');
				$total       = ATTRIBUTE_EXTRACTOR('checkout', 'CheckoutID', $orderid, 'TotalPrice');
				$customerid  = ATTRIBUTE_EXTRACTOR('checkout', 'CheckoutID', $orderid, 'CustomerID');
				$cuscontact  = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $customerid, 'CustomerPhone');
				$customername  = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $customerid, 'CustomerName');

            ?> 

                <tr>
                	<td><?php echo "$address"; ?></td>
                	<td><?php echo "$customername"; ?></td>
                	<td><?php echo "$cuscontact"; ?></td>
                	<td><?php echo "$Payment"; ?></td>
                	<td><?php echo "$total"; ?></td>
                	<td><?php echo "$Arrivedate"; ?></td>
                	<td><a href="delivery_staffaction.php?orderid=<?php echo($orderid) ?>">Go</a></td>
                </tr>

            <?php } ?>
			</table>



</body>
</html>
<?php 	include('footer.php'); ?>