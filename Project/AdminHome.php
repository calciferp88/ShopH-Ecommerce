<?php

	include('header.php');
	include('script\functions.php');
	$connect = mysqli_connect("localhost", "root", "", "shophdb");

	//CHECK IF USER LOGGED IN OR NOT
	if ($_SESSION['user']!=NULL) {
    	echo $user = "Welcome".$_SESSION['user']."</br>";;
	} 
	else {
	    echo "<script>
				window.location.assign('login.php');
				</script>";
	}

	//LOGOUT FUNCTION
	if(isset($_GET['btnlogout'])){
		session_destroy();
		echo "<script>
				window.location.assign('login.php');
				</script>";
	}

	//VARIABLES
	$section = "";
	$id = "";
	$name = "";

	$select = "SELECT * FROM category";
	$run = mysqli_query($connect, $select);
	$num = mysqli_num_rows($run);
	for($i=0;$i<=$num;$i++){
		$row = mysqli_fetch_array($run);
		$catid[$i] = $row['CategoryID'];
		$catname[$i] = $row['CategoryName'];
	}



	if (isset($_GET['action']) && $_GET['action'] != '') {

		$action=$_GET['action'];
		if ($action=='editcat') {
			$tempid = $_GET['cid'];
			$select = "SELECT * from category WHERE CategoryID='$tempid'";
			$run = mysqli_query($connect, $select);
			$row = mysqli_fetch_array($run);
			$section = "Category";
			$id = $row['CategoryID']; 
			$name = $row['CategoryName'];
		}
		elseif($action=='deletecat')
		{
			$tempid = $_GET['cid'];
			$delete = "DELETE from category WHERE CategoryID='$tempid'";
			$run = mysqli_query($connect, $delete);
			if($run){
				echo "Success";
			}
			else{
				echo "Delete Fail";
			}
		}
		elseif ($action=='editbr') {
			$tempid = $_GET['bid'];
			$select = "SELECT * from brand WHERE BrandID='$tempid'";
			$run = mysqli_query($connect, $select);
			$row = mysqli_fetch_array($run);
			$section = "Brand";
			$id = $row['BrandID']; 
			$name = $row['BrandName'];
		}
		elseif($action=='deletebr')
		{
			$tempid = $_GET['bid'];
			$delete = "DELETE from brand WHERE BrandID='$tempid'";
			$run = mysqli_query($connect, $delete);
			if($run){
				echo "Success";
			}
			else{
				echo "Delete Fail";
			}
		}
		elseif($action=='deletestaff'){
			$tempid = $_GET['id'];
			$delete = "DELETE FROM Staff WHERE StaffID = '$tempid'";
			$run = mysqli_query($connect, $delete);
			if($run){
				echo "Success";
			}
			else{
				echo "Delete Fail";
			}
		}
	}


	//TO EDIT BRAND OR CATEGORY
	if(isset($_GET['btnEdit'])){
		$tempid = $_GET['bcid'];
		$tempname = $_GET['bcname'];
		$section = $_GET['bcsection'];

		if($section == "Category"){
			$update = "UPDATE category SET 
			categoryname='$tempname' WHERE categoryid='$tempid'";
			$run = mysqli_query($connect, $update);
			if($run){
				echo "<script>
				alert('Update Successful');
				window.location.assign('AdminHome.php');
				</script>";
			}
			else{
				echo mysqli_error($connect);
			}
		}

		elseif($section == "Brand"){
			$update = "UPDATE brand SET 
			brandname='$tempname' WHERE brandid='$tempid'";
			$run = mysqli_query($connect, $update);
			if($run){
				echo "<script>
				alert('Update Successful');
				window.location.assign('AdminHome.php');
				</script>";
			}
			else{
				echo mysqli_error($connect);
			}
		}
	}


	// REGISTER STAFF
	$staffid;
	$staffname = "";
	$staffemail = "";
	$staffpassword = "";
	$staffposition = "";
	$staffphone = "";
	$staffaddress = "";
	$emailexists = "";
	$emailwrong = "";
	$phoneexists = "";
	$wrongpass = "";

	if(isset($_GET['btnRegisterStaff'])){
		$staffname = $_GET['staffname'];
		$staffemail = $_GET['staffemail'];
		$checkstaffemail = ATTRIBUTE_CHECKER('Staff', 'StaffEmail', $staffemail);
		$staffpassword = $_GET['staffpassword'];
		$confirmstaffpassword = $_GET['confirmstaffpassword'];
		$staffposition = $_GET['staffposition'];
		$staffphone = $_GET['staffphone'];
		$staffaddress = $_GET['staffaddress'];
		echo "<script>alert('hello0');</script>";

		if($staffemail != $checkstaffemail){
			if($staffpassword == $confirmstaffpassword){
				$chkemail = preg_match('/@shoph.com/', $staffemail);
				echo "<script>alert('$staffemail');</script>";

				if(!$chkemail){
					$emailwrong = "Email is wrong! Must end with @shoph.com";
					echo "<script>alert('hello2');</script>";
				}

				else{
					$staffid = ID_MAKER('Staff', 'StaffID');
					$hapass = password_hash($staffpassword, PASSWORD_DEFAULT);
					$insertadmin = "INSERT INTO Staff VALUES ('$staffid','$staffname', '$staffemail', '$staffpassword', '$staffposition', '', '$staffphone','$staffaddress')";

					$run = mysqli_query($connect, $insertadmin);

					if($run){
						echo "<script>
						alert('Insert Successful');
						window.location.assign('AdminHome.php');
						</script>";
					}
					else{
						echo mysqli_error($connect);
					}
				}
			}

			else{
				$wrongpass = "The password you entered is wrong";
			}
		}
		elseif($staffemail == $checkstaffemail){
			$emailexists = "Email already exists";
		}
	}


	$bcchecker = "";
	$bcexists = "";
	if(isset($_GET['btnSave'])){
		$input = $_GET['input'];

		if($input == "Brand"){
			$brandname = $_GET['bcname'];
			$brandid = ID_MAKER('brand', 'BrandID'); 
			$bcchecker = ATTRIBUTE_CHECKER('Brand', 'BrandName', $brandname);

			if($brandname == $bcchecker){
				$bcexists = "Name already exists!";
			}

			else{
				$insert = "INSERT INTO `brand`(`BrandID`, `BrandName`) VALUES ('$brandid','$brandname')";
				$run = mysqli_query($connect, $insert);
				if($run){
					echo "<script>alert('Insert Successful');</script>";
				}
				else{
					echo mysqli_error($connect);
				}
			}
		}


		elseif($input == "Category"){
			$categoryname = $_GET['bcname'];
			$categoryid = ID_MAKER('category', 'CategoryID');
			$bcchecker = ATTRIBUTE_CHECKER('Category', 'CategoryName', $categoryname);

			if($categoryname == $bcchecker){
				$bcexists = "Name already exists!";
			}

			else{
				$insert = "INSERT INTO `category`(`CategoryID`, `CategoryName`) VALUES ('$categoryid','$categoryname')";
				$run = mysqli_query($connect, $insert);
				if($run){
					echo "<script>alert('Insert Successful');</script>";
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

	<style>
		body {font-family: Arial;}

		/* Style the tab */
		.tab {
		  overflow: hidden;
		  border: 1px solid #ccc;
		  background-color: #f1f1f1;
		}

		/* Style the buttons inside the tab */
		.tab button {
		  background-color: inherit;
		  float: left;
		  border: none;
		  outline: none;
		  cursor: pointer;
		  padding: 14px 16px;
		  transition: 0.3s;
		  font-size: 17px;
		}

		/* Change background color of buttons on hover */
		.tab button:hover {
		  background-color: #ddd;
		}

		/* Create an active/current tablink class */
		.tab button.active {
		  background-color: #ccc;
		}

		/* Style the tab content */
		.tabcontent {
		  display: none;
		  padding: 6px 12px;
		  border: 1px solid #ccc;
		  border-top: none;
		}
	</style>

</head>
<body>
		

	<div class="tab">
	  <button class="tablinks" onclick="openCity(event, 'London')">Manage Staff</button>
	  <button class="tablinks" onclick="openCity(event, 'Paris')">Brand Category</button>
	  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Register Staff</button>
	</div>

	<div id="London" class="tabcontent">
	  <h3>Staff Report</h3>
		<table border = '1'>
				<tr>
					<td>Staff ID</td>
					<td>Staff Name</td>
					<td>Role</td>
					<td>Email</td>
					<td>Password</td>
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
						$Password = $row['StaffPassword'];

					echo "
						<tr>
							<td>$ID</td>
							<td>$Name</td>
							<td>$Role</td>
							<td>$Email</td>
							<td>$Password</td>
							<td><a href='adminhome.php?action=deletestaff&id=$ID'>Delete</a></td>
						</tr>";
					};

				?>
		</table>
	</div>

	<div id="Paris" class="tabcontent" >
	  <h3>Category</h3>

	  	<table width=100% >
	  		<tr>
	  		<td>
	  			<table>
			  		<form action='AdminHome.php' method='GET'>
			  			<tr><td>INPUT FORM</td></tr>
						<tr>
							<td>Select Input</td>
								<td><select id="brandcategory" name="input" onchange="Myfunction()">
										<option value="Brand">Brand</option>
										<option value="Category">Category</option>
									</select>
							</td>
			  			</tr>
			  			<tr>
			  				<td>Name</td>
			  				<td><input type='text' name='bcname' required/></td>
			  			</tr>
			  			<tr><td colspan="2" style="text-align:center; color:#ff0000;"><?php echo $bcexists; ?></td></tr>
			  			<tr><td><input type="submit" value="Save" name="btnSave"></td></tr>
			  		</form>
	  			</table>
	  		</td><td>
				<table>
					<form action='AdminHome.php' method='GET'>
						<tr><td>EDIT FORM</td></tr>
						<tr>
							<td><?php echo $section;?> ID</td>
							<input type='hidden' name='bcsection' value="<?php echo $section;?>" readonly/>
							<td><input type='text' name='bcid' value="<?php echo $id;?>" readonly/></td>
			  			</tr>
			  			<tr>
			  				<td>Name</td>
			  				<td><input type='text' name='bcname' value="<?php echo $name;?>" required/></td>
			  			</tr>
			  			<tr><td><input type="submit" value="Save" name="btnEdit"></td></tr>
					</form>
				</table>
			</td>
		  	</tr>

	  	<tr>
	  		<td>CATEGORY</td>
	  		<td>BRAND</td>
	  	</tr>
	  	<tr>
	  		<td>
	  			<table layout="fixed" border='2' width='100%' vertical-align: text-top;>
	  			<tr>
	  				<td>CategoryID</td>
	  				<td>CategoryName</td>
	  				<td>Action</td>
	  			</tr>

	  			<?php 
	  				$selectcat = "SELECT * FROM category";
					$runcat = mysqli_query($connect, $selectcat);
					$countcat = mysqli_num_rows($runcat);

					for ($i=0;$i<$countcat;$i++){
						$rowcat = mysqli_fetch_array($runcat);
						$categoryid = $rowcat['CategoryID'];
						$categoryname = $rowcat['CategoryName'];
						echo "<tr><td>$categoryid</td><td>$categoryname</td>";
						echo "<td> <a href='adminhome.php?action=editcat&cid=$categoryid'>Edit</a> 
							<a href='adminhome.php?action=deletecat&cid=$categoryid'>Delete</a></td>";
						echo "</tr>";
					}
					//}
					

// //<td><table><tr><td>
// 									<form action='adminhome.php' method='GET'><input type='hidden' value='$categoryid' name='tempcatid'/><input type='submit' value='Add' name='btbcadd'></form></td><td>
// 									<form action='adminhome.php' method='GET'><input type='hidden' value='$categoryid' name='tempcatid'/><input type='submit' value='Edit' name='btncedit'></form></td><td>
// 									<form action='adminhome.php' method='GET'><input type='hidden' value='$categoryid' name='tempcatid'/><input type='submit' value='Delete' name='btncdelete'></form></td></tr></table>
// 									</td>"
// <form action='adminhome.php' method='GET'><input type='hidden' value='$categoryid' name='tempcatid'/><input type='submit' value='Edit' name='btncedit'></form></td><td>
// 									<form action='adminhome.php' method='GET'><input type='hidden' value='$categoryid' name='tempcatid'/><input type='submit' value='Delete' name='btncdelete'></form></td>

	  			?>

	  			</table>
	  		</td>
	  		<td>
	  			<table border='2' width = '100%' >
	  			<tr>
	  				<td>BrandID</td>
	  				<td>BrandName</td>
	  				<td>Action</td>
	  			</tr>

	  			<?php 
	  				$select = "SELECT * FROM brand";
					$run = mysqli_query($connect, $select);
					$count = mysqli_num_rows($run);

					for ($i=0;$i<$count;$i++){
						$row = mysqli_fetch_array($run);
						$brandid = $row['BrandID'];
						$brandname = $row['BrandName'];
						echo "<tr><td>$brandid</td><td>$brandname</td>";
						echo "<td> <a href='adminhome.php?action=editbr&bid=$brandid'>Edit</a> 
							<a href='adminhome.php?action=deletebr&bid=$brandid'>Delete</a></td>"
						;}

					// 	<td><table><tr><td>
					// <form action='adminhome.php' method='GET'><input type='hidden' value='$brandid' name='tempbrandid'/><input type='submit' value='Edit' name='btnbedit'></form></td><td>
					// <form action='adminhome.php' method='GET'><input type='hidden' value='$brandid' name='tempbrandid'/><input type='submit' value='Delete' name='btnbdelete'></form></td></tr></table>
					// </td></tr>

	  			?>
	  			</table>
	  		</td>
	  	</tr>
	  </table>
	</div>

	<div id="Tokyo" class="tabcontent">
	  <h3>Register Staff</h3>

	  <div id='Register' class="form-style-5">
		<form action='' method='GET'>
			<table align="center">
				<tr>
			<td>Name</td>
			<td><input type='text' name='staffname' value="<?php echo $staffname;?>" required></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type='email' name='staffemail' value="<?php echo $staffemail;?>" required/></td> 
		</tr>
		<tr><td colspan="2" style="text-align:center; color:#ff0000;"><?php echo $emailexists;?></td></tr>
		<tr><td colspan="2" style="text-align:center; color:#ff0000;"><?php echo $emailwrong;?></td></tr>
		<tr>
			<td>Password</td>
			<td><input type='password' name='staffpassword' placeholder='Enter Password' required/></td>
		</tr>
		<tr><td colspan="2" style="text-align:center; color:#ff0000;"> <?php echo $wrongpass;?></td></tr>
		<tr>
			<td>Confirm Password</td>
			<td><input type='password' name='confirmstaffpassword' placeholder='Enter Password' required/></td>
		</tr>
		<tr><td colspan="2" style="text-align:center; color:#ff0000;"><?php echo $wrongpass;?></td></tr>
		<tr>
			<td>Position</td>
			<td><select name="staffposition">
					<option value="System Adminitrator">System Administrator</option>
					<option value="Customer Support">Customer Support</option>
				</select></td>
		</tr>
		<tr>
			<td>Phone</td>
			<td><input type='number' name='staffphone' value="<?php echo $staffphone;?>" required/></td>
		</tr>
		<?php echo $phoneexists;?>

		<tr>
			<td>Address</td>
			<td><input type='text' name='staffaddress' value="<?php echo $staffaddress;?>" required/></td>
		</tr>
		<tr><td colspan="3" style="text-align:center;"><input tabindex="9" class="btn btn-inverse large" type="submit" name="btnRegisterStaff" value="Register"></td></tr>
	</table>
	</form>

	</div>
	</div>

	<script>
		function openCity(evt, cityName) {
		  var i, tabcontent, tablinks;
		  tabcontent = document.getElementsByClassName("tabcontent");
		  for (i = 0; i < tabcontent.length; i++) {
		    tabcontent[i].style.display = "none";
		  }
		  tablinks = document.getElementsByClassName("tablinks");
		  for (i = 0; i < tablinks.length; i++) {
		    tablinks[i].className = tablinks[i].className.replace(" active", "");
		  }
		  document.getElementById(cityName).style.display = "block";
		  evt.currentTarget.className += " active";
		}

		function Myfunction(){
			var x = document.getElementById("brandcategory").value;
			if(x=="SubCategory"){
				document.getElementById("demo").innerHTML = "Category";
				document.getElementById("demo2").innerHTML = "<?php for($i=0;$i<$num;$i++){?><option value='<?php echo $catid[$i]?>'><?php echo $catname[$i];echo '</option>';}?>";}
			;
		}
	</script>

</body>
</html>


