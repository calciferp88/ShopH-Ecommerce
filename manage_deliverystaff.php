<?php

	include('delivery_header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');


	$staffidsession = $_SESSION['user'];
    $staffroletest   = ATTRIBUTE_EXTRACTOR('deliverystaff', 'DeliveryStaffEmail', $staffidsession, 'DeliveryStaffRole');

    if ($staffroletest != 'Admin') 
    {
    	echo "<script>
		alert('You do not have access permission to this page !');
		window.location.assign('delivery_staffpage.php');
		</script>";
    }

	if (isset($_GET['action']))    
		{		  
		  $staffid = $_GET['staffid'];

		  $DELETE = "DELETE FROM `deliverystaff` WHERE DeliveryStaffID = '$staffid'";
		  $run = mysqli_query($connect, $DELETE);   
		  
		      if ($run) 
		      {
		      echo "      	   
		           <script>   
		           alert('Staff Removed Successfully !');		
		           window.location = 'manage_deliverystaff.php' 
		           </script> 
		           ";
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

	<title>Manage Delivery Staff | ShopH</title>


</head>

<body>
		
		<h4 class="title" align="center"><span class="text"><strong>Manage</strong> Staff</span></h4>
		<h4><strong><span class="text">Staff List</span></strong></h4>
		<table border = '1'>
				<tr>
					<td>Staff ID</td>
					<td>Staff Name</td>
					<td>Role</td>
					<td>Email</td>
					<td>Action</td>
				</tr>
				<?php
					$select = "SELECT * FROM deliverystaff";
					$run = mysqli_query($connect, $select);
					$count = mysqli_num_rows($run);

					for ($i=0;$i<$count;$i++){
						$row = mysqli_fetch_array($run);
						$ID = $row['DeliveryStaffID'];
						$Name = $row['DeliveryStaffName'];
						$Role = $row['DeliveryStaffRole'];
						$Email = $row['DeliveryStaffEmail'];

					echo "
						<tr>
							<td>$ID</td>
							<td>$Name</td>
							<td>$Role</td>
							<td>$Email</td>
							<td><a href='manage_deliverystaff.php?action=delete&staffid=$ID'>Delete</a></td>
						</tr>";
					};

				?>
		</table>
	

</body>

</html>

<?php 	include('footer.php'); ?>

