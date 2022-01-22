<?php
	include('header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

	$productname = "";
	$productprice = "";
	$productquantity = "";
	$productbrand = "";
	$productsubcategory = "";
	$uploaddate = "";
  $day1  = "";
  $day2  = "";
  $day3  = "";

  // Uploading Advertisement 
	if(isset($_POST['btnUpload']))
	{
		$adid       = ID_MAKER('advertisement', 'AdvertisementID'); 
		$cusemail   = $_SESSION['user'];
    $sellerid   = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $cusemail, 'CustomerID');
    $startdate  = $_POST['txtstartdate'];
    $datelength = $_POST['txtadlength'];
    $day1  = $startdate;

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

    // Date lentgh n payment
    if ($datelength == '1') 
    {
      $Purchaseamt = '50';
    }

    else if ($datelength == '2') 
    {
      $Purchaseamt = '100'; 
      $day1  = $startdate;
      $day2  = date('Y-m-d', strtotime($day1 .' +1 day'));
    }


    else if ($datelength == '3') 
    {
      $Purchaseamt = '150';
      $day1  = $startdate;  
      $day2  = date('Y-m-d', strtotime($day1 .' +1 day'));
      $day3  = date('Y-m-d', strtotime($day2 .' +1 day'));  
    }
		        
    
    $selectad = "SELECT * FROM advertisement 
               WHERE Day1 = '$startdate' 
               OR    Day2 = '$startdate'
               OR    Day3 = '$startdate'";

    $runad = mysqli_query($connect, $selectad);
    $countad = mysqli_num_rows($runad);

    if ($countad < 10) 
    {
      $insertadvertisement  = "INSERT INTO advertisement 
                             VALUES ('$adid','$sellerid', '$filename1', '$startdate', '$datelength', '$day1', '$day2', '$day3','$Purchaseamt', '', 'Purchased')";
      $run = mysqli_query($connect, $insertadvertisement);

      if($run)
      {
        echo "<script>
        alert('Advertising Completed !');       
        window.location.assign('home.php');
        </script>";
      } 

      else
      { 
        echo mysqli_error($connect);
      }
    }

    // it advertisement count reach 10
    else
    {
      echo "<script>
        alert('Advertisement Limit full. Please Choose Antoher Date  !');       
        window.location.assign('add_advertisement.php');
        </script>";
    }

		


	}


?>

<!DOCTYPE html>
<html>	   
<head>

	<!-- Put Shoph Icon in tab bar -->
    <link rel="icon"  href="themes/images/logo.png" >
	<title>Add Advertisement | ShopH</title>	

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

       .row        
      {
        display: flex;
      }

      .address-sec 
      {
        flex: 68%;
        padding: 10px;
      }

      .col-50
      {
        flex: 50%;
        padding-left: 20px;
      }

      .col-75
      {
        flex: 33.33%;
        padding-left: 20px;
      }

      .price-list
      {
        background-color: #f2f2f2;
        padding: 30px;
      }

      .price-list p
      {
        font-size: 16px;
        font-weight: bold;
      }

    </style>

</head>

<body>
 
	<div class="container-fluid pd-form" id="maindiv" >
		<form action="add_advertisement.php" method="POST" enctype="multipart/form-data">

			<div class="form-group">
				<h4 class="title" align="center"><span class="text"><strong>Advertisement</strong> form</span></h4>
			</div>

            <!-- Image Upload -->
            <label for="Image">Choose a suitable image for Advertisement  </label>  
            <img src="themes/images/image.png" width="7%"> 
            <input type="file" name="txtphoto" id="img-upload" required><br><br>
              
            <label for="Name">Enter Start Date </label>
            <input type='date' min="<?= date('Y-m-d'); ?>" name='txtstartdate' value="<?php echo $productname;?>" required><br>

            <label for="Price">Enter Advertise Time (Up to 3 days) </label>
            <input type='number' name='txtadlength' min="1" max="3" required/><br>

            <div class="price-list">
              <p>*Advertisement Fees*</p>
              <label class="price-list-o">
                  1 day - $50 <br>
                  2 day - $100 <br>
                  3 day - $150 <br>
              </label>
            </div>

            <div class="form-group">
              <h4 class="title" align="center"><span class="text"><strong>Payment</strong> form</span></h4>
            </div>

            <label for="CreditCard">Choose a card</label>
                      <select name="sel-card">
                        <option value="Visa">Visa</option>
                        <option value="Amex">Amex</option>
                        <option value="Discover">Discover</option>
                      </select>
                        

                      <div class="row">

                          <div class="col-50">
                              <label for="Name">Name On Card</label>
                              <input type='text' name='txtnameoncard' required><br>
                          </div>

                          <div class="col-50">
                              <label for="Name">Credit Card Number</label>
                              <input type='text' name='txtcardnumber' id="txtCardNumber" placeholder="Eg: 1111-2222-3333" required><br>
                          </div>

                      </div>

                        <div class="row">

                          <div class="col-75">
                              <label for="Name">Exp Month</label>
                               <select name="txtexpmonth">
                                  <option value=''>Select Exp Month</option>
                                  <option selected value='Janaury'>Janaury</option>
                                  <option value='February'>February</option>
                                  <option value='March'>March</option>
                                  <option value='April'>April</option>
                                  <option value='May'>May</option>
                                  <option value='June'>June</option>
                                  <option value='July'>July</option>
                                  <option value='August'>August</option>
                                  <option value='September'>September</option>
                                  <option value='October'>October</option>
                                  <option value='November'>November</option>
                                  <option value='December'>December</option>
                              </select><br>
                          </div>

                          <div class="col-75">
                              <label for="Name">Exp Year</label> 
                               <select name="txtexpyear">
                                  <option value=''>Select Exp Year</option>
                                  <option selected value='2020'>2020</option>
                                  <option value='2021'>2021</option>
                                  <option value='2022'>2022</option>
                                  <option value='2023'>2023</option>
                                  <option value='2024'>2024</option>
                                  <option value='2025'>2025</option>
                              </select>
                          </div>

                          <div class="col-75">
                              <label for="Name">CVV</label>
                              <input type='number' name='txtcvv' min="000" max="999" required><br>
                          </div>

                        </div>

			<button class="btnAdd" name="btnUpload">Confirm Advertisement</button>

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

