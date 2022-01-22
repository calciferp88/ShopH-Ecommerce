<?php
	include('admin_header.php');
	$connect = mysqli_connect("localhost", "root", "", "shophdb");

	//VARIABLES
	$section = "";
	$selector = 0;
	$id = "";
	$name = "";

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

		elseif($action=='editsubcat'){
			$tempid = $_GET['csid'];
			$select = "SELECT * from subcategory WHERE SubCategoryID='$tempid'";
			$run = mysqli_query($connect, $select);
			$row = mysqli_fetch_array($run);
			$section = "SubCategory";
			$id = $row['SubCategoryID']; 
			$name = $row['SubCategoryName'];
		}

		elseif($action=='deletecat')
		{
			$tempid = $_GET['cid'];
			$delete = "DELETE from category WHERE CategoryID='$tempid'";
			$run = mysqli_query($connect, $delete);
			if($run){
				echo "<script>alert('Delete Successful');</script>";
			}
			else{
				echo "<script>alert('Delete Fail, SubCategory Exists');</script>";
			}
		}
		elseif($action == 'deletesubcat'){
			$tempid = $_GET['csid'];
			$delete = "DELETE from subcategory WHERE SubCategoryID='$tempid'";
			$run = mysqli_query($connect, $delete);
			if($run){
				echo "<script>alert('Delete Successful');</script>";
			}
			else{
				echo "<script>alert('Delete Fail, Products Exists');</script>";
			}			
		}
	}


	//TO INSERT CATEGORY OR SUBCATEGORY

	$bcchecker = "";
	$bcexists = "";
	$bcexist = "";
	if(isset($_GET['btnSave'])){
		$input = $_GET['input'];

		if($input == "Category"){
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
		elseif($input == "SubCategory"){
			$subcategoryname = $_GET['bcname'];
			$subcategoryid = ID_MAKER('subcategory', 'SubCategoryID');
			$categoryname = $_GET['inputcategory'];
			$categoryid = ATTRIBUTE_EXTRACTOR('category', 'CategoryName', $categoryname, 'CategoryID');
			$bcchecker = ATTRIBUTE_CHECKER('subcategory', 'SubCategoryName', $subcategoryname);

			if($subcategoryname == $bcchecker){
				$bcexists = "Name already exists!";
			}

			else{
				$insert = "INSERT INTO `subcategory`(`SubCategoryID`,`SubCategoryName`,`CategoryID`) VALUES ('$subcategoryid','$subcategoryname','$categoryid')";
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

	//TO UPDATE CATEGORY OR SUBCATEGORY
	if(isset($_GET['btnEdit'])){

		$catid = $_GET['bcid'];
		$catname = $_GET['bcname'];
		$catsection = $_GET['bcsection'];

		if($catsection == 'Category'){
			$bcchecker = ATTRIBUTE_CHECKER('category', 'CategoryName', $catname);
			if($catname == $bcchecker){
				$bcexist = "Name already exists!";
			}

			else{
				$update = "UPDATE Category SET CategoryName='$catname' WHERE CategoryID='$catid'";
				$run = mysqli_query($connect, $update);
				if($run){
					echo "<script>alert('Update Successful');</script>";
				}
				else{
					echo mysqli_error($connect);
				}
			}
			
		}
		elseif($catsection == 'SubCategory'){
			$bcchecker = ATTRIBUTE_CHECKER('subcategory', 'SubCategoryName', $catname);
			if($catname == $bcchecker){
				$bcexist = "Name already exists!";
			}

			else{
				$update = "UPDATE SubCategory SET SubCategoryName='$catname' WHERE SubCategoryID='$catid'";
				$run = mysqli_query($connect, $update);
				if($run){
					echo "<script>alert('Update Successful');</script>";
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
	<script>
		function myFunction() {
		  var x = document.getElementById("mySelect").value;
		  var y = document.getElementById("catSelect");
		  var n = document.getElementById("categorytitle");
		  if(x=="Category"){
		  	alert(x);
		  	n.style.display = "none";
			y.style.display = "none";
		  }
		  else if(x=="SubCategory"){
		  	alert(x);
		  	n.style.display = "block"; 
		  	y.style.display = "block";  
		  }
		  document.getElementById("demo").innerHTML = "You selected: " + x;
		}		
	</script>
</head>
<body>

		<h4 class="title" align="center"><span class="text"><strong>Manage</strong> Category</span></h4>


		<table><tr><td>
		<form action='manage_category.php' method='GET'>
			<ul><li><h4><strong><span class="text">INPUT FORM</span></strong></h4></li></ul>
			<ul>
				<li>Insert</li>
				<li><select name="input" id="mySelect" onchange="myFunction()">
					<option value="Category">Category</option>
					<option value="SubCategory">SubCategory</option>
				</select></li>
			</ul>
			<ul>
				<li id='categorytitle' name='inputcategory' style='display:none'>
					
			<?php
					echo "Category</li><li>";
					echo "<select id='catSelect' name='inputcategory' style='display:none'>";
					$selectcat = "SELECT * FROM Category";
					$runcat = mysqli_query($connect, $selectcat);
					$countcat = mysqli_num_rows($runcat);
					for ($i=0;$i<$countcat;$i++){
						$rowcat = mysqli_fetch_array($runcat);
						$categoryid = $rowcat['CategoryID'];
						$categoryname = $rowcat['CategoryName'];
						echo "<option value='$categoryname'>$categoryname</option>";
					}
					echo "";

			?>
					</select>
				</li>
			</ul>
			<ul>
			  	<li>Name</li>
			  	<li><input type='text' name='bcname' required/></li>
			</ul>
			<ul><li colspan="2" style="text-align:center; color:#ff0000;"><?php echo $bcexists; ?></li></ul>
			<ul><li><input type="submit" value="Save" name="btnSave"></li></ul>
		</form>
		</td>
		<td>	
		<form action='manage_category.php' method='GET'>
			<ul><li><h4><strong><span class="text">EDIT FORM</span></strong></h4></li></ul>
			<ul>
				<li>ID</li>
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


	  			<table layout="fixed" border='2' width='100%' vertical-align: text-top;>
	  			<tr style='font-weight:bold;'>
	  				<td>CategoryID</td>
	  				<td>CategoryName</td>
	  				<td>Action</td>
	  				<td>SubCategory Name</td>
	  				<td>Action</td>
	  			</tr>

	  			<?php 
	  				$selectcat = "SELECT * FROM Category";
					$runcat = mysqli_query($connect, $selectcat);
					$countcat = mysqli_num_rows($runcat);

					for ($i=0;$i<$countcat;$i++){
						$rowcat = mysqli_fetch_array($runcat);
						$categoryid = $rowcat['CategoryID'];
						$categoryname = $rowcat['CategoryName'];

						$selectsubcat = "SELECT * FROM SubCategory WHERE CategoryID='$categoryid'";
						$runsubcat = mysqli_query($connect, $selectsubcat);
						$countsubcat = mysqli_num_rows($runsubcat);

						echo "<tr><td>$categoryid</td><td>$categoryname</td>";
						echo "<td> <a href='manage_category.php?action=editcat&cid=$categoryid'>Edit</a> 
							<a href='manage_category.php?action=deletecat&cid=$categoryid'>Delete</a></td>";
						echo "<td>";

						for ($j=0; $j<$countsubcat;$j++){
							$rowsubcat = mysqli_fetch_array($runsubcat);
							$subcategoryid = $rowsubcat['SubCategoryID'];
							$subcategoryname = $rowsubcat['SubCategoryName'];
							echo "<ul><li>$subcategoryname</li></ul>";
						}
						echo "</td><td>";

						$selectsubcat = "SELECT * FROM SubCategory WHERE CategoryID='$categoryid'";
						$runsubcat = mysqli_query($connect, $selectsubcat);
						$countsubcat = mysqli_num_rows($runsubcat);

						for ($k=0; $k<$countsubcat; $k++){
							$rowsubcat = mysqli_fetch_array($runsubcat);
							$subcategoryid = $rowsubcat['SubCategoryID'];
							$subcategoryname = $rowsubcat['SubCategoryName'];
							echo "<ul><a href='manage_category.php?action=editsubcat&csid=$subcategoryid'>Edit</a> 
							<a href='manage_category.php?action=deletesubcat&csid=$subcategoryid'>Delete</a></li></ul>";
						}
						echo "</td></tr>";
					}

	  			?>

	  			</table>

	  <?php 	include('footer.php'); ?>
	</div>

</body>
</html>


