<?php
	include('admin_header.php');

	$connect = mysqli_connect("localhost", "root", "", "shophdb");
	//VARIABLES


//Delete Staff
	if (isset($_GET['action']) && $_GET['action'] != '') {
		if ($_GET['action']=='deletestaff') {
			$tempid = $_GET['id'];
			$tempemail = $_GET['semail'];

			if($tempid == 1){
					echo "<script>
					alert('Cannot Delete Admin Account');
					window.location.assign('manage_staff.php');
					</script>";
			}

			elseif($tempemail == $_SESSION['user']){
					echo "<script>
					alert('Unable to delete. Account Logged in');
					window.location.assign('manage_staff.php');
					</script>";				
			}

			else{
				$delete = "DELETE from Staff WHERE StaffID='$tempid'";
				$run = mysqli_query($connect, $delete);
				if($run){
					echo "<script>
					alert('Delete Successful');
					window.location.assign('manage_staff.php');
					</script>";
				}
				else{
					echo mysqli_error($connect);
				}
			}

		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
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
					<td>Phone</td>
					<td>Action</td>
				</tr>
				<?php
					$select = "SELECT * FROM staff";
					$run = mysqli_query($connect, $select);
					$count = mysqli_num_rows($run);

					for ($i=0;$i<$count;$i++){
						$row = mysqli_fetch_array($run);
						$ID = $row['StaffID'];
						$Name = $row['StaffName'];
						$Role = $row['StaffPosition'];
						$Email = $row['StaffEmail'];
						$Phone = $row['StaffPhone'];
						$Password = $row['StaffPassword'];

					echo "
						<tr>
							<td>$ID</td>
							<td>$Name</td>
							<td>$Role</td>
							<td>$Email</td>
							<td>$Phone</td>
							<td><a href='manage_staff.php?action=deletestaff&id=$ID&semail=$Email'>Delete</a></td>
						</tr>";
					};

				?>
		</table>
<?php 	include('footer.php'); ?>

</body>
</html>
