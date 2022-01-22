<?php

	include('admin_header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

?>

<!DOCTYPE html>
<html>

<head>

	<title>Admin Dashboard | ShopH</title>
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
		
	<!-- Seach Form -->
	<form class="search-form" action="AdminHome.php" method="POST">
		<input type="number" name="txtsearch-order" placeholder="Input Order ID">	
		<button type="submit" name="btn-search">Search</button> 
		<button style="margin-left: 2px;" type="submit" name="btn-show-all">Show All
		</button>
	</form>	

	<!-- Result Table -->
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

	            	if (isset($_POST['btn-search'])) 
					{

					$searchid = $_POST['txtsearch-order'];
	                $select = "SELECT * FROM checkout WHERE CheckoutID = '$searchid' ";
	                $run    = mysqli_query($connect, $select);
					$count  = mysqli_num_rows($run);

					for ($i=0;$i<$count;$i++)
					{
						$row = mysqli_fetch_array($run);
						$orderid     = $row['CheckoutID'];		
						$orderdate   = $row['CheckoutDate'];	
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

            <?php } }  else if (isset($_POST['btn-show-all']))

            { ?>

            <?php 

            	// Show all button is clicked
                $select = "SELECT * FROM checkout";
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

        <?php } }  else 

            { ?>

            <?php 

                $select = "SELECT * FROM checkout";
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

            <?php }
        } ?>
			</table>


</body>

</html>

<?php 	include('footer.php'); ?>


