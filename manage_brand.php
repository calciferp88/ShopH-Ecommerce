<?php
	include('admin_header.php');

	$connect = mysqli_connect("localhost", "root", "", "shophdb");
	//VARIABLES
	$section = "";
	$id = "";
	$name = "";
	$bcchecker = "";
	$bcexists = "";
	$bcexist = "";


	if (isset($_GET['action']) && $_GET['action'] != '') {
		if ($_GET['action']=='editbr') {
			$tempid = $_GET['bid'];
			$select = "SELECT * from brand WHERE BrandID='$tempid'";	
			$run = mysqli_query($connect, $select);
			$row = mysqli_fetch_array($run);
			$section = "Brand";
			$id = $row['BrandID']; 
			$name = $row['BrandName'];
		}
		elseif($_GET['action']=='deletebr')
		{	
			$tempid = $_GET['bid'];
			$delete = "DELETE from brand WHERE BrandID='$tempid'";
			$run = mysqli_query($connect, $delete);
			if($run){
				echo "<script>
				alert('Delete Successful');
				window.location.assign('manage_brand.php');
				</script>";
			}
			else{
				echo "<script>
				alert('Delete Fail Product Exists');
				window.location.assign('manage_brand.php');
				</script>";
			}
		}
	}


	//TO EDIT BRAND OR CATEGORY
	if(isset($_GET['btnEdit'])){
		$tempid = $_GET['bcid'];	
		$tempname = $_GET['bcname'];
		$section = $_GET['bcsection'];
		$bcchecker = ATTRIBUTE_CHECKER('Brand', 'BrandName', $tempname);
		if($tempname == $bcchecker){
			$bcexist = "Name already exists!";
		}

		else{
			if($section == "Brand"){
				$update = "UPDATE brand SET 
				brandname='$tempname' WHERE brandid='$tempid'";
				$run = mysqli_query($connect, $update);
				if($run){
					echo "<script>
					alert('Update Successful');
					window.location.assign('manage_brand.php');
					</script>";
				}
				else{
					echo mysqli_error($connect);
				}
			}			
		}


	}

	if(isset($_POST['btnSave'])){
		$input = $_POST	['input'];

		if($input == "Brand"){

			$brandname = $_POST['bcname'];
			$brandid   = ID_MAKER('brand', 'BrandID'); 
			$bcchecker = ATTRIBUTE_CHECKER('Brand', 'BrandName', $brandname);

			if($brandname == $bcchecker)	
			{
				$bcexists = "Name already exists!";
			}

			else{
				   // Image upload cubrid_error_code()
					$image1 = $_FILES['txtlogo']['name'];
			        $folder = "UploadImage/";	
			        if ($image1) 
			        {  
			          $filename1 = $folder."_".$image1;
			          $copied = copy($_FILES['txtlogo']['tmp_name'], $filename1);

			          if (!$copied) 	
			          { 							
			          	exit("Problem Occured. Cannot upload image");
			          }
			        }
				$insert = "INSERT INTO `brand` VALUES ('$brandid','$brandname', '$filename1')";
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
<!-- 	Brand Logo CSS -->
		<style type="text/css">

			.pd-img-container
			{
				width: 267px;
				height: 200px;
				overflow: hidden;
    			position: relative;
			}

			.pd-img
			{
		        background-size: contain;
		        background-position: center;
		        background-repeat: no-repeat;
		        width: 100%;
    			height: 100%;
		        transition: all 1s;
			}

			.pd-img:hover
			{
				transform: scale(1.2);

			}

			.pdetail
			{
				background-color:;
				color: #ee3e0d;
				padding: 7px;
				margin-top: 10px;
				font-weight: bold;
			}

			.pdetail:hover
			{
				background-color:#ee3e0d;
				color: white;
				border: 1px solid #ee3e0d;
			}

			.brand-sec
			{
				height: 50px;
			}

			/* Slideshow container */
			.slideshow-container {
			  width: 100%;
			  margin: auto;
			}

			/* The dots/bullets/indicators */
			.dot {
			  height: 15px;
			  width: 15px;	
			  margin: 0 2px;
			  background-color: #bbb;
			  border-radius: 50%;
			  display: inline-block;
			  transition: background-color 0.6s ease;
			  display: none;
			}

			/* Fading animation */
			.fade {
			  -webkit-animation-name: fade;
			  -webkit-animation-duration: 1.5s;
			  animation-name: fade;
			  animation-duration: 1.5s;
			}

			@-webkit-keyframes fade {
			  from {opacity: .4} 
			  to {opacity: 1}
			}

			@keyframes fade {
			  from {opacity: .4} 
			  to {opacity: 1}
			}

			/* On smaller screens, decrease text size */
			@media only screen and (max-width: 300px) {
			  .text {font-size: 11px}
			}
		</style>
</head>
<body>

		<h4 class="title" align="center"><span class="text"><strong>Manage</strong> Brand</span></h4>

		<table><tr><td>
		<form action='manage_brand.php' method='POST' enctype="multipart/form-data">
			<ul><li><h4><strong><span class="text">INPUT FORM</span></strong></h4></li></ul>
			<ul>
				<li>Insert</li>
				<li><input type='text' name='input' value="Brand" readonly/></li>
			</ul>
			<ul>
			  	<li>Name</li>
			  	<li><input type='text' name='bcname' required/></li>
			</ul>

			<ul>
			  	<li>Choose Brand Logo</li>
			  	<li><input type='file' name="txtlogo" required/></li>
			</ul>
			<ul><li colspan="2" style="text-align:center; color:#ff0000;"><?php echo $bcexists; ?></li></ul>
			<ul><li><input type="submit" value="Save" name="btnSave"></li></ul>
		</form>
		</td>
		<td>	
		<form action='manage_brand.php' method='GET' >
			<ul><li><h4><strong><span class="text">EDIT FORM</span></strong></h4></li></ul>
			<ul>
				<li><?php echo $section;?> ID</li>
					<input type='hidden' name='bcsection' value="<?php echo $section;?>" readonly/>
				<li><input type='text' name='bcid' value="<?php echo $id;?>" readonly/></li>
			</ul>
			<ul>
			  	<li>Name</li>
			  	<li><input type='text' name='bcname' value="<?php echo $name;?>" required/></li>
			</ul>
			<ul><li colspan="2" style="text-align:center; color:#ff0000;"><?php echo $bcexist; ?></li></ul>
			<ul><li><input type="submit" value="Save" name="btnEdit"></li></ul>
		</form>
		</td></tr>
		</table>


	  			<table border='2' width = '100%' >
	  			<tr>
	  				<td>BrandName</td>
	  				<td>BrandLogo</td>
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
						$brandlogo = $row['BrandLogo'];
						echo "<tr><td>$brandname</td><td><img class='brand-sec' alt='$brandname' src='$brandlogo'></td>";
						echo "<td> <a href='manage_brand.php?action=editbr&bid=$brandid'>Edit</a> 
							<a href='manage_brand.php?action=deletebr&bid=$brandid'>Delete</a></td>"
						;}

	  			?>
	  			</table>

	 <?php 	include('footer.php'); ?>
	</div>

</body>
</html>
