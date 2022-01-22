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
	
	<form class="search-form" action="staff_message_home.php" method="POST">
		<input type="text" name="txtsearch-customer" placeholder="Input Customer Name . . .">
		<button type="submit" name="btn-search">Search</button> 
		<button style="margin-left: 2px;" type="submit" name="btn-show-all">Show All
		</button>
	</form>	

	<div class="table-responsive">  
			<table>

				<tr>  
                    <th width="15%">ID</th> 
                    <th width="15%">Name</th>  	
                    <th width="15%">Gender</th>  		
                    <th width="30%">Country</th>  
                    <th width="10%">Action</th>  	
                </tr> 

            <?php

            	if (isset($_POST['btn-search'])) 
				{
					$searchuser = $_POST['txtsearch-customer'];
	                $select = "SELECT * FROM customer WHERE CustomerName = '%$searchid%' ";
	                $run    = mysqli_query($connect, $select);
					$count  = mysqli_num_rows($run);

					for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($run);
					$customerID   = $row['CustomerID'];		
					$cusname      = $row['CustomerName'];	
					$gender       = $row['CustomerGender'];
					$country      = $row['CustomerCountry'];

             ?> 

                <tr>
                	<td><?php echo "$customerID"; ?></td>
                	<td><?php echo "$cusname"; ?></td>
                	<td><?php echo "$gender"; ?></td>
                	<td><?php echo "$country"; ?></td>
                	<td><a href="staff_message_chat.php?customerid=<?php echo($customerID) ?>">Message</a></td>
                </tr>

            <?php } }  else if (isset($_POST['btn-show-all']))

            { ?>

            <?php 

                $select = "SELECT * FROM customer";
                $run    = mysqli_query($connect, $select);
				$count  = mysqli_num_rows($run);

				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($run);
					$customerID   = $row['CustomerID'];		
					$cusname      = $row['CustomerName'];	
					$gender       = $row['CustomerGender'];
					$country      = $row['CustomerCountry'];

             ?> 

                <tr>
                	<td><?php echo "$customerID"; ?></td>
                	<td><?php echo "$cusname"; ?></td>
                	<td><?php echo "$gender"; ?></td>
                	<td><?php echo "$country"; ?></td>
                	<td><a href="staff_message_chat.php?customerid=<?php echo($customerID) ?>">Message</a></td>
                </tr>

        <?php } }  else 

            { ?>

            <?php 

                $select = "SELECT * FROM customer";
                $run    = mysqli_query($connect, $select);
				$count  = mysqli_num_rows($run);

				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($run);
					$customerID   = $row['CustomerID'];		
					$cusname      = $row['CustomerName'];	
					$gender       = $row['CustomerGender'];
					$country      = $row['CustomerCountry'];

             ?> 

                <tr>
                	<td><?php echo "$customerID"; ?></td>
                	<td><?php echo "$cusname"; ?></td>
                	<td><?php echo "$gender"; ?></td>
                	<td><?php echo "$country"; ?></td>
                	<td><a href="staff_message_chat.php?customerid=<?php echo($customerID) ?>">Message</a></td>
                </tr>

            <?php }
        } ?>
			</table>


</body>

</html>

<?php 	include('footer.php'); ?>


