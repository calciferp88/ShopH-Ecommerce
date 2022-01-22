<?php
	include('header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');


	// -------- Product Delete code 			
	   
		if (isset($_GET['actionproduct']))    
		{		  
		  $pid = $_GET['pid'];

		  $DELETE = "DELETE FROM `product` WHERE ProductID = '$pid'";
		  $run = mysqli_query($connect, $DELETE);   
		  
		      if ($run) 
		      {
		      echo "      	   
		           <script>   
		           alert('Product Deleted Successfully !');		
		           window.location = 'products_list.php' 
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

	<!-- Put Shoph Icon in tab bar -->
    <link rel="icon"  href="themes/images/logo.png" >
	<title>Product Lists | ShopH </title>

    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>


    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="themes/css/css.css">

</head>
	
<body>
 		<div class="form-group">
			<h4 class="title" align="center"><span class="text"><strong>Product</strong> Lists</span></h4>
	    </div>

	<!-- Search Bar -->
	<div class="Search-bar">
		<div>
			<form method="POST" action="products_list.php">
				<input type="text" name="txtsearch" id="Search" placeholder="Search . . .">
				<button type="submit" id="searchbtn" name="btn-search"><i class="fa fa-search"></i></button>
				<button type="submit" id="searchbtn" name="btn-showall">Show All</button>
			</form>
		</div>
	</div>

	<!-- List By Table -->

	<table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Price</th>
          <th scope="col">In Stock</th>
          <th scope="col">Brand</th>
          <th scope="col">Category</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>

    <?php 

		$selleremail = $_SESSION['user'];

		$sellerid = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $selleremail, 'CustomerID');

		// Search function
      	if (isset($_POST['btn-search'])) 
      	{
      		$name = $_POST['txtsearch'];
      		$select = "SELECT * FROM product WHERE ProductName LIKE '%$name%'";  

      	      $run    = mysqli_query($connect, $select); 
	          $count  = mysqli_num_rows($run);   

	          for ($i=0; $i < $count; $i++) 
	          { 
	                  $row     = mysqli_fetch_array($run);
	                  $pid     = $row['ProductID']; 
	                  $name    = $row['ProductName'];  
	                  $price   = $row['Price'];  
			                  $stock   = $row['Stock'];
	                  $Bid     = $row['BrandID'];  
	                  $Cid     = $row['CategoryID']; 

	                  $select1 = "SELECT * FROM category WHERE CategoryID = '$Cid'";
	                  $run1    = mysqli_query($connect, $select1); 
	                  $row1    = mysqli_fetch_array($run1);
	                  $category  = $row1['CategoryName'];  

	                  $select2 = "SELECT * FROM brand WHERE BrandID = '$Bid'";
	                  $run2    = mysqli_query($connect, $select2); 
	                  $row2    = mysqli_fetch_array($run2);
	                  $brand   = $row2['BrandName']; 					

	                  $selectauction = "SELECT * FROM auction WHERE ProductID = '$pid'";
	                  $runauction = mysqli_query($connect, $selectauction);
				      $countauction = mysqli_num_rows($runauction);	

					  if ($countauction > 0)
					  {
					  	$statusa = "Auction";
					  }

					  else
					  {
					  	$statusa = "On Sale";
					  }

	       
					    echo "
					                 

					        <tr>
					          <td>$name</td>
					          <td>$ $price</td>
					          <td>$stock</td>
					          <td>$brand</td>
					          <td>$category</td>
					          <td>$statusa</td>
					          <td> 
					               <a href='product.php?productid&pid=$pid' class='btnlink'>View</a>
					               <a href='#' class='btnlink'>Edit</a>
					               <a href='products_list.php?actionproduct=delete&pid=$pid' class='btnlink-del'>DELETE</a>
					          </td>
					        </tr>

					        ";
	 		   } 
      	}

      	else if (isset($_POST['btn-showall']))
      	{
      	  $select = "SELECT * FROM product WHERE CustomerID = '$sellerid'";  

          $run    = mysqli_query($connect, $select); 
          $count  = mysqli_num_rows($run);   

          for ($i=0; $i < $count; $i++) 
          { 
                  $row     = mysqli_fetch_array($run);
                  $pid     = $row['ProductID']; 
                  $name    = $row['ProductName'];  
                  $price   = $row['Price'];  
                  $stock   = $row['Stock'];
                  $Bid     = $row['BrandID'];  
                  $Cid     = $row['SubCategoryID']; 

                  $select1 = "SELECT * FROM subcategory WHERE SubCategoryID = '$Cid'";
                  $run1    = mysqli_query($connect, $select1); 
                  $row1    = mysqli_fetch_array($run1);
                  $category  = $row1['SubCategoryName'];  

                  $select2 = "SELECT * FROM brand WHERE BrandID = '$Bid'";
                  $run2    = mysqli_query($connect, $select2); 
                  $row2    = mysqli_fetch_array($run2);
                  $brand   = $row2['BrandName'];

                    $selectauction = "SELECT * FROM auction WHERE ProductID = '$pid'";
	                  $runauction = mysqli_query($connect, $selectauction);
				      $countauction = mysqli_num_rows($runauction); 

                  if ($countauction > 0)
					  {
					  	$statusa = "Auction";
					  }

					  else
					  {
					  	$statusa = "On Sale";
					  }

       
				    echo "
				                 

				        <tr>
				          <td>$name</td>
				          <td>$ $price</td>
				          <td>$stock</td>
				          <td>$brand</td>
				          <td>$category</td>
					      <td>$statusa</td>
				          <td> 
				               <a href='product.php?productid=$pid' class='btnlink'>View</a>
				               <a href='#' class='btnlink'>Edit</a>
				               <a href='products_list.php?actionproduct=delete&pid=$pid' class='btnlink-del'>DELETE</a>
				          </td>
				        </tr>

				        ";
 		   } 
      	}

      	else
      	{
 
          $select = "SELECT * FROM product WHERE CustomerID = '$sellerid'";  

          $run    = mysqli_query($connect, $select); 
          $count  = mysqli_num_rows($run);   

          for ($i=0; $i < $count; $i++) 
          { 
                  $row     = mysqli_fetch_array($run);
                  $pid     = $row['ProductID']; 
                  $name    = $row['ProductName'];  
                  $price   = $row['Price'];  
                  $stock   = $row['Stock'];
                  $Bid     = $row['BrandID'];  
                  $Cid     = $row['SubCategoryID']; 

                  $select1 = "SELECT * FROM subcategory WHERE SubCategoryID = '$Cid'";
                  $run1    = mysqli_query($connect, $select1); 
                  $row1    = mysqli_fetch_array($run1);
                  $category  = $row1['SubCategoryName'];  

                  $select2 = "SELECT * FROM brand WHERE BrandID = '$Bid'";
                  $run2    = mysqli_query($connect, $select2); 
                  $row2    = mysqli_fetch_array($run2);
                  $brand   = $row2['BrandName']; 

                  $selectauction = "SELECT * FROM auction WHERE ProductID = '$pid'";
	              $runauction = mysqli_query($connect, $selectauction);
				  $countauction = mysqli_num_rows($runauction);

                  if ($countauction > 0)
				  {
					  $statusa = "Auction";
				  }

				  else
				  {
					  $statusa = "On Sale";
				  }

       
				    echo "
				                 

				        <tr>
				          <td>$name</td>
				          <td>$ $price</td>
				          <td>$stock</td>
				          <td>$brand</td>
				          <td>$category</td>
					      <td>$statusa</td>
				          <td> 
				               <a href='product.php?productid=$pid' class='btnlink'>View</a>
				               <a href='#' class='btnlink'>Edit</a>
				               <a href='products_list.php?actionproduct=delete&pid=$pid' class='btnlink-del'>DELETE</a>
				          </td>
				        </tr>

				        ";
 		   } 

 		}


    ?>
      </tbody>
    </table>

</body>



</html>



<?php include('footer.php');?>