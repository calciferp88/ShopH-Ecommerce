<?php
	include('header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

	$productname = "";
	$productprice = "";
	$productquantity = "";
	$productbrand = "";
	$productsubcategory = "";
	$uploaddate = "";
  $status = "";
  $productexist = "";
  $filename1= "";
  $filename2= "";
  $filename3= "";
  $filename4= "";
  $filename5= "";


  // Upload Product
	if(isset($_POST['btnUpload']))
	{    
		$productid = ID_MAKER('Product', 'ProductID');
		$productname = $_POST['productname'];
		$productprice = $_POST['productprice'];
		$productdesc = $_POST['txtdesc'];  
		$productquantity = $_POST['productquantity'];  
		$productbrand = $_POST['productbrand'];			 
		$productsubcategory = $_POST['productsubcategory'];	   
		$uploaddate = date('Y-m-d');
		$cusemail = $_SESSION['user'];     
    
		// Image upload cubrid_error_code()
		$image1 = $_FILES['txtphoto']['name'];
        $folder = "UploadImage/";	
        if ($image1) 
        {  
          $filename1 = $folder."_".$image1;
          $copied = copy($_FILES['txtphoto']['tmp_name'], $filename1);

          if (!$copied) 	
          { 						  
          	exit("Problem Occured. Cannot upload image");
          }   
        }

        // Image upload cubrid_error_code()         
		$image2 = $_FILES['txtphoto2']['name'];
        $folder = "UploadImage/";	
        if ($image2)  
        {  
          $filename2 = $folder."_".$image2;     
          $copied = copy($_FILES['txtphoto2']['tmp_name'], $filename2);

          if (!$copied) 	
          { 							
          	exit("Problem Occured. Cannot upload image");
          } 
        }
       
        // Image upload cubrid_error_code() 
		$image3 = $_FILES['txtphoto3']['name'];
        $folder = "UploadImage/";	    
        if ($image3) 
        {  
          $filename3 = $folder."_".$image3;
          $copied = copy($_FILES['txtphoto3']['tmp_name'], $filename3);

          if (!$copied) 	
          { 							 
          	exit("Problem Occured. Cannot upload image");  
          }
        } 

        // Image upload cubrid_error_code()
		$image4 = $_FILES['txtphoto4']['name'];
        $folder = "UploadImage/";	  
        if ($image4) 
        {  
          $filename4 = $folder."_".$image4;
          $copied = copy($_FILES['txtphoto4']['tmp_name'], $filename4);     

          if (!$copied) 	  
          { 							
          	exit("Problem Occured. Cannot upload image");   
          } 
        }

        // Image upload cubrid_error_code()  
		$image5 = $_FILES['txtphoto5']['name'];
        $folder = "UploadImage/";	    
        if ($image5)  
        {         142226795
          $filename5 = $folder."_".$image5;   
          $copied = copy($_FILES['txtphoto5']['tmp_name'], $filename5);

          if (!$copied) 	    
          { 							
          	exit("Problem Occured. Cannot upload image");    
          }
        }     

    // Get ID form email, and name
		$customerid = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $cusemail, 'CustomerID');    
		$subcategoryid = ATTRIBUTE_EXTRACTOR('SubCategory', 'SubCategoryName', $productsubcategory, 'SubCategoryID');	  
		$brandid = ATTRIBUTE_EXTRACTOR('Brand', 'BrandName', $productbrand, 'BrandID');xattr_get(filename, name)
    echo $subcategoryid;	
    
    $insertproduct = "INSERT INTO Product VALUES ('$productid','$productname', '$productdesc', '$productprice', '$productquantity', '', '$uploaddate', '$customerid', '0','$subcategoryid', '$brandid', '$filename1', '$filename2', '$filename3', '$filename4', '$filename5', '', '', '', '')";
    $run = mysqli_query($connect, $insertproduct);
        if($run){
          echo "<script>
          alert('Insert Successful');
          window.location.assign('products_list.php');
          </script>";
        } x
        else{
          echo mysqli_error($connect);
        }
    
	}


?>

<!DOCTYPE html>
<html>	
<head>

	<!-- Put Shoph Icon in tab bar -->
    <link rel="icon"  href="themes/images/logo.png" >
	<title>Add Product | ShopH</title>	

    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="themes/css/generalcss.css">	 

    <link rel="stylesheet" type="text/css" href="themes/css/maincss.css">


    <style type="text/css">
        .row1
        {
         display: flex;
        }

        .column1  
        {
         flex: 25%;
        }

	    #maindiv form .column
	    {
	      padding-left: 10px;
	    }
    </style>

</head>

<body>
  
  
	<div class="container-fluid pd-form" id="maindiv" >
		<form action="add_product.php" method="POST" enctype="multipart/form-data">

			<div class="form-group">
				<h4 class="title" align="center"><span class="text"><strong>Product</strong> form</span></h4>
			</div>   

            <label for="Name">Enter Product Name </label>
            <input type='text' name='productname' value="<?php echo $productname;?>" required><br>
            <ul><li colspan="2" style="text-align:center; color:#ff0000;"><?php echo $productexist;?></li></ul>

            <label for="Price">Enter Price </label>
            <input type='number' name='productprice' max='10000' value="<?php echo $productprice;?>" required/><br>

            <label for="Quantity">Enter Quantity </label> 
            <input type='number' name='productquantity' max='100000' required/><br><br>

            <div class="row">
            	<div class="column">
            		<label for="Category">Choose Category </label>
	            		<select name="productsubcategory">

						<?php 
							$select = "SELECT * FROM Category";
							$run = mysqli_query($connect, $select);
							$count = mysqli_num_rows($run);

							for ($i=0;$i<$count;$i++){
								$row = mysqli_fetch_array($run);
								$ID = $row['CategoryID'];
								$Name = $row['CategoryName'];
							  echo "
								<optgroup label='$Name'>";
                $select2 = "SELECT * FROM SubCategory WHERE CategoryID=$ID";
                $run2 = mysqli_query($connect, $select2);
                $count2 = mysqli_num_rows($run2);

                for ($j=0;$j<$count2;$j++){
                  $row2 = mysqli_fetch_array($run2);
                  $ID2 = $row2['SubCategoryID'];
                  $Name2 = $row2['SubCategoryName'];
                echo "
                    <option value='$Name2' >$Name2</option>
                  ";
                };3x  
                echo "</optgroup>";
							};
						?>
				    </select><br>	
            <br>	
            	</div>    

                <div class="column">
            		   <label for="Brand">Choose Brand </label>
            		   <select name="productbrand">
							<?php 
								$select = "SELECT * FROM Brand";
								$run = mysqli_query($connect, $select);
								$count = mysqli_num_rows($run);

								for ($i=0;$i<$count;$i++){
									$row = mysqli_fetch_array($run);
									$ID = $row['BrandID'];
									$Name = $row['BrandName'];
								echo "
									<option value='$Name'>$Name</option>";
								};
							?>
					    </select><br><br>
            	</div>
            </div>

            <!-- File input -->
            <!-- https://stackoverflow.com/questions/5813344/how-to-customize-input-type-file -->


            <label for="Image">Choose Main Product Image </label>
            <img src="themes/images/image.png" width="7%"> 
            <input type="file" name="txtphoto" id="img-upload" required><br><br>

            <div class="row1">
   
            	<div class="column1">
            		<label for="Image">Choose Product Image 2</label>
            		<img src="themes/images/image.png" width="7%"> 
            		<input type="file" name="txtphoto2" id="img-upload">   
            	</div>

            	<div class="column1">
            		<label for="Image">Choose Product Image 3</label>
            		<img src="themes/images/image.png" width="7%"> 
            		<input type="file" name="txtphoto3" id="img-upload">
            	</div>

            	<div class="column1">
            		<label for="Image">Choose Product Image 4</label>
            		<img src="themes/images/image.png" width="7%"> 
            		<input type="file" name="txtphoto4" id="img-upload">
            	</div>

            	<div class="column1">
            		<label for="Image">Choose Product Image 5</label>
            		<img src="themes/images/image.png" width="7%"> 
            		<input type="file" name="txtphoto5" id="img-upload">
            	</div>

            </div><br><br>

			<label for="Description">Enter Product Description </label>
			<textarea  name="txtdesc"></textarea>
            <br><br>
			
			<label for="Shipping">Shipping From</label>
            <select name="sellercountry">
			   <option value="Myanmar">Myanmar</option>
			</select><br>

			<button class="btnAdd" name="btnUpload">Upload Product</button>

		</form>
	</div>
 

 <!-- text Editor Link  -->
 <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
 <script type="text/javascript">			
	CKEDITOR.replace( 'txtdesc' );
	$(document).ready(function(){
	$(document).on('mousemove',function(e){
	$("#cords").html("Cords: Y: "+e.clientY);
	})
	});
 </script>

 <?php include('footer.php'); ?>



</body>
</html>

