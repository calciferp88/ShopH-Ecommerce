<?php
	include('header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

	$productname = "";
	$productprice = "";
	$productquantity = "";
	$productbrand = "";
	$productsubcategory = "";
	$uploaddate = "";


	// check logged in or not
	if(isset($_SESSION['user']))
	{
	  $selleremail = $_SESSION['user'];
	  $sellerid    = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $selleremail, 'CustomerID');
	}	

	else
	{
	  echo "<script>
			  alert('Please Login First !');
			  window.location.assign('login.php');
			</script>";
    }
	

    // insert auction
	if (isset($_POST['btn-auction'])) 
	{
		$auctionid     = ID_MAKER('auction', 'AuctionID');
		$startdate     = $_POST['txtstartdate'];
		$starttime     = $_POST['txtstarttime'];
		$enddate       = $_POST['txtenddate'];
		$endtime	   = $_POST['txtendtime'];
		$startbid      = $_POST['txtstartbid'];
		$increasebid   = $_POST['txtincreasebid'];
		$pid           = $_POST['sel-product'];
		$maxbid        = $_POST['txtmaxbid'];
        //$dt            	= date('Y-m-d H:i:s');

		$insertauction = "INSERT INTO auction 
		                  VALUES ('$auctionid', '$startdate', '$starttime', '$enddate', '$endtime','$startbid', '$increasebid', '$startbid', '0', '$maxbid','Bidding', '$pid', NULL)";
		$run = mysqli_query($connect, $insertauction);

			if($run){
				echo "<script>
				alert('Created Auction !');
				window.location.assign('products_list.php');
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
	<title>Create Auction | ShopH</title>

    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="themes/css/generalcss.css">

    <link rel="stylesheet" type="text/css" href="themes/css/maincss.css">

</head>

<body>
 
	<div class="container-fluid pd-form" >
		<form action="add_auction.php" method="POST" enctype="multipart/form-data">

			<div class="form-group">
			   <h4 class="title" align="center"><span class="text"><strong>Create</strong> Auction</span></h4>
			</div>

			<!-- Products sold by logged in Seller -->
			<label for="sel-product">Choose a product to auction </label>
            <select name="sel-product">
				<?php 
				  $select = "SELECT * FROM product WHERE CustomerID = $sellerid";
				  $run = mysqli_query($connect, $select);
				  $count = mysqli_num_rows($run);

				  for ($i=0;$i<$count;$i++)
				  {
					$row = mysqli_fetch_array($run);
					$ID = $row['ProductID'];
					$Name = $row['ProductName'];
					echo "
						<option value='$ID'>$Name</option>";
				  };
			    ?>
			</select>

			<label for="txtenddate">Choose Start Date for Auction </label>
            <input type='date' name='txtstartdate' min="<?= date('Y-m-d'); ?>" required><br>

            <label for="txtendtime">Choose Start Time for Auction </label>
            <input type='time' name='txtstarttime' required><br>

            <?php $tomorrow = date("Y-m-d", strtotime('tomorrow')); ?>
			<label for="txtenddate">Choose End Date for Auction </label>
            <input type='date' name='txtenddate' min="<?= $tomorrow; ?>" required><br>

            <label for="txtendtime">Choose End Time for Auction </label>
            <input type='time' name='txtendtime' required><br>

			<label for="txtstartbid">Enter Starting Bid for your product </label>
            <input type='number' name='txtstartbid' required><br>

			<label for="txtstartbid">Enter Increse Bid for your product </label>
            <input type='number' name='txtincreasebid' required><br>

            <label for="txtmaxbid">Enter Maximum Bid for your product </label>
            <input type='number' name='txtmaxbid' required><br>
           
			<br>
			<button class="btnAdd" name="btn-auction">Confirm Auction</button>

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
<?php echo date('y-m-d');?>


</body>
</html>

