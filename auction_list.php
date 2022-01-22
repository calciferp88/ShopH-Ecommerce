            <?php     include('header.php');     $connect =
mysqli_connect('localhost','root','','shophdb');


	// -------- Auction Delete code 			
		if (isset($_GET['actionproduct']))    
		{		  
		  $pid = $_GET['pid'];

		  $DELETE = "DELETE FROM `auction` WHERE ProductID = '$pid'";
		  $run = mysqli_query($connect, $DELETE);   
		  
		      if ($run) 
		      {
		      echo "      	   
		           <script>   	
		           alert('This Auction is Deleted Successfully !');		
		           window.location = 'auction_list.php' 
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
		<h4 class="	title" align="center"><span class="text"><strong>Product</strong> on Auction</span></h4>
	</div>



	<!-- List By Table -->

	<table class="table table-striped">
      <thead>
        <tr>	
          <th scope="col">Product</th>
          <th scope="col">Current Bid</th>
          <th scope="col">Max Bid</th>
          <th scope="col">Bid Times</th>
          <th scope="col">End Date time</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>

      <tbody>
      	

        <?php 

          $selleremail = $_SESSION['user'];
		  $sellerid = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $selleremail, 'CustomerID');

          $select = "SELECT * FROM auction a, product p 
          			 WHERE p.ProductID = a.ProductID
          			 AND  p.CustomerID = '$sellerid'";  

          $run    = mysqli_query($connect, $select); 
          $count  = mysqli_num_rows($run);   

          for ($i=0; $i < $count; $i++) 
          { 
                  $row       = mysqli_fetch_array($run);
                  $pid       = $row['ProductID']; 
                  $name      = $row['ProductName'];  
                  $cbid      = $row['CurrentBid'];  
                  $mbid      = $row['Maxbid'];  
                  $time      = $row['BidTimes'];
                  $bidderid  = $row['CustomerID'];  
                  $status    = $row['Status'];  
                  $enddate   = $row['EndDate']; 
                  $endtime   = $row['EndTime']; 
				  $bidder    = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerID', $bidderid, 'CustomerName');

          		    echo "
				                
				        <tr>
				          <td>$name</td>
				          <td>$ $cbid</td>
				          <td>$ $mbid</td>
				          <td>$time bids</td>	
				          <td>$enddate | $endtime</td>
					      <td>$status</td>
				          <td> 
				               <a href='auction_product.php?productid=$pid' class='btnlink'>View</a> | 
				               <a href='products_list.php?actionproduct=delete&pid=$pid' class='btnlink-del'>DELETE</a>
				          </td>
				        </tr>

				        ";
 		   } 

          		 ?>

      </tbody>

    </table>

</body>



</html>



<?php include('footer.php');?>