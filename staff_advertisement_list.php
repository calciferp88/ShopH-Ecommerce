<?php

	include('admin_header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

?>

<!DOCTYPE html>
<html>

<head>

	<title>Admin Dashboard | ShopH</title>
	
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
        }  
    </style>

</head>

<body>
	
	<div class="form-group">   
        <h4 class="title" align="center"><span class="text"> <strong> Active  </strong> Advertisements</span></h4>
        </div>  

          <table layout="fixed" border='1' >

          <tr style='font-weight:bold;'>
            <td>AdvertisementID</td>
            <td>Image</td>  
            <td>Start Date</td>
            <td>Duration</td>
            <td>Purchased Amount</td>
            <td>Seller</td>
          </tr>

          <?php 

          	$today = date('Y-m-d');
            $selectcat = "
              			   SELECT * FROM advertisement
              			   WHERE Day1 = '$today' 
    		  			   OR    Day2 = '$today'
    		  			   OR    Day3 = '$today'
              			";
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
            $sellerid  = $rowcat['SellerID'];
            $seller    = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $sellerid, 'CustomerName');

            echo " 
            <tr>
              <td># $adid</td>
              <td><a href='$adimg'>Ads Image</a></td>
              <td>$startdate</td>
              <td>$length</td>
              <td>$ 				$purchase</td>
              <td>$seller</td>
            </tr>";
            
          }

          ?>

          </table><br><br>

          <!-- Inactive Advertisements -->
            <div class="form-group">   
        <h4 class="title" align="center"><span class="text"> <strong> In Active  </strong> Advertisements</span></h4>
        </div>  

          <table layout="fixed" border='1' >

          <tr style='font-weight:bold;'>
            <td>AdvertisementID</td>
            <td>Image</td>  
            <td>Start Date</td>
            <td>Duration</td>
            <td>Purchased Amount</td>
            <td>Seller</td>
          </tr>

          <?php 

            $today = date('Y-m-d');
            $selectcat = "
                       SELECT * FROM advertisement
                       WHERE Day1 != '$today' 
                   OR    Day2 != '$today'
                   OR    Day3 != '$today'
                    ";
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
            $sellerid  = $rowcat['SellerID'];
            $seller    = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $sellerid, 'CustomerName');

            echo " 
            <tr>
              <td># $adid</td>
              <td><a href='$adimg'>Ads Image</a></td>
              <td>$startdate</td>
              <td>$length</td>
              <td>$         $purchase</td>
              <td>$seller</td>
            </tr>";
            
          }

          ?>

          </table><br><br>
</body>

</html>

<?php 	include('footer.php'); ?>


