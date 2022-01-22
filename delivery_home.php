<?php

	include('delivery_header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

	$staffidsession = $_SESSION['user'];
    $staffroletest   = ATTRIBUTE_EXTRACTOR('deliverystaff', 'DeliveryStaffEmail', $staffidsession, 'DeliveryStaffRole');

    // It not admin , go to normal staff page

    if($staffroletest != 'Admin') 
    {	
    	echo "<script>
		window.location.assign('delivery_staffpage.php');
		</script>";
    }

?>

<!DOCTYPE html>
<html>

<head>

	<title>Manage Delivery | ShopH</title>
	<style type="text/css">
		.search-form
		{
			margin-top: 20px;	
		}

		.search-form input
		{
			padding: 8px;
			width: 60%;
		}

		.search-form button
		{
			padding:9px;
			margin-top: -10px;
			width: 80px;
			border: none;
			background-color: #ee3e0d;
			color: white;
			font-weight: bold;
			border-radius: 5px;
		}


		.search-form input::-webkit-outer-spin-button,
		.search-form input::-webkit-inner-spin-button {
		  -webkit-appearance: none;
		}

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

            	// Delivery Pending orders are selected
                $select = "SELECT * FROM checkout WHERE Status = 'Pending Deliver' ";
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
                	<td><a href="delivery_action.php?orderid=<?php echo($orderid) ?>">Manage Delivery</a></td>
                </tr>

            <?php } ?>
			</table>


</body>

</html>

<?php 	include('footer.php'); ?>


