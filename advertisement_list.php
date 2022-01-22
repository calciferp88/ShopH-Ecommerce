<?php
	include('header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

  $myemail = $_SESSION['user'];
  $myid    = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $myemail, 'CustomerID');

?>

<!DOCTYPE html>
<html>	   
<head>

	<!-- Put Shoph Icon in tab bar -->
    <link rel="icon"  href="themes/images/logo.png" >
	<title>Advertisement List | ShopH</title>	

    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="themes/css/generalcss.css">	 

    <link rel="stylesheet" type="text/css" href="themes/css/maincss.css">

    <style type="text/css">
       tr th
        {               
          text-align: center;
          font-size: 15px;
          padding: 15px;
          background-color: white;
        }

        tr td 
        {
          text-align: center;
          font-size: 15px;
        } 

        tr:nth-child(even) 
        {
          background-color: white;
        }x    
    </style>

</head>   

<body>
 
 <div class="form-group">   
        <h4 class="title" align="center"><span class="text"> <strong> Advertisement </strong> List</span></h4>
        </div>  
        
          <table layout="fixed" border='1' >

          <tr style='font-weight:bold;'>
            <td>AdvertisementID</td>
            <td>Image</td>  
            <td>Start Date</td>
            <td>Duration</td>
            <td>Purchased Amount</td>
            <td>Status</td>
          </tr>

          <?php 
            $selectcat = "
              SELECT * FROM advertisement
              WHERE SellerID = '$myid' ";
          $runcat = mysqli_query($connect, $selectcat);
          $countcat = mysqli_num_rows($runcat);

          for ($i=0;$i<$countcat;$i++)  
          {
            $rowcat = mysqli_fetch_array($runcat);
            $adid      = $rowcat['AdvertisementID'];
            $adimg     = $rowcat['Image'];
            $startdate = $rowcat['StartDate'];
            $length    = $rowcat['DateLength'];
            $purchase  = $rowcat['PurchasedAmount'];
            $status    = $rowcat['ActiveStatus'];

            echo " 
            <tr>
              <td>$adid</td>
              <td><a href='$adimg'>Image</a></td>
              <td>$startdate</td>
              <td>$length</td>
              <td>$purchase</td>
              <td>$status</td>
            </tr>";
            
          }

          ?>

          </table><br><br>

 <?php include('footer.php'); ?>



</body>
</html>

