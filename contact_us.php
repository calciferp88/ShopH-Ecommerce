<?php
	include('header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

	$productname = "";
	$productprice = "";
	$productquantity = "";
	$productbrand = "";
	$productsubcategory = "";
	$uploaddate = "";


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

		$customerid = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $cusemail, 'CustomerID');
		$subcategoryid = ATTRIBUTE_EXTRACTOR('SubCategory', 'SubCategoryName', $productsubcategory, 'SubCategoryID');	
		$brandid = ATTRIBUTE_EXTRACTOR('Brand', 'BrandName', $productbrand, 'BrandID');	
		
		$insertproduct = "INSERT INTO Product VALUES ('$productid','$productname', '$productdesc', '$productprice', '$productquantity', '', '$uploaddate', '$customerid', '$subcategoryid', '$brandid', '$filename1', '', '', '', '', '', '', '', '')";
		$run = mysqli_query($connect, $insertproduct);

			if($run){
				echo "<script>
				alert('Insert Successful');
				window.location.assign('add_product.php');
				</script>";
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
	<title>Contact Us | ShopH</title>

    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="themes/css/generalcss.css">

</head>

<body>
 
	<div class="container-fluid pd-form" >
		<form action="add_product.php" method="POST" enctype="multipart/form-data">

			<div class="form-group">
			<h4 class="title" align="center"><span class="text"><strong>Contact</strong> Us</span></h4>
			</div>

            <label for="Name"> <i class="fa fa-question-circle"></i> Subject</label>
            <input type='text' name='txtsubject' value="<?php echo $productname;?>" required><br>	


			<label for="Description"> <i class="fa fa-envelope-open"></i> Discription	 </label>
			<textarea  name="txtdesc"></textarea>
            <br><br>
			


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



</body>
</html>



<?php include('footer.php');?>	