<?php 

	$connect = mysqli_connect('localhost','root','','shophdb');
	include('header.php');	

	// Add to cart 

	 if(isset($_POST["add_to_cart"]))  
     {  

        if (isset($_SESSION['user'])) 
        {

             if(isset($_SESSION["shopping_cart"]))  
            {  
                $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  

	            if(!in_array($_GET["id"], $item_array_id))  
	            {  	
	                $count = count($_SESSION["shopping_cart"]);  
	                $item_array = array(  
	                     'item_id'             =>     $_GET["id"],  
	                     'item_name'           =>     $_POST["hidden_name"],    
	                     'item_price'          =>     $_POST["hidden_price"], 
	                     'item_image'          =>     $_POST["hidgden_image"],    
	                     'item_quantity'       =>     $_POST["quantity"] 
	                );  

	                $_SESSION["shopping_cart"][$count] = $item_array; 
	                echo "  
				           <script>
				           window.location = 'home.php'; 
				           </script>
			           ";

	           }  

               else  
               {  
                    echo '<script>alert("Item Already Added")</script>'; 
                    echo '<script>window.location="home.php"</script>';  
               } 

           }  
        else  
        {  
           $item_array = array(  
                 'item_id'             =>     $_GET["id"],  
	             'item_name'           =>     $_POST["hidden_name"],    
	             'item_price'          =>     $_POST["hidden_price"], 
		             'item_image'      =>     $_POST["hidden_image"],    
	             'item_quantity'       =>     $_POST["quantity"]  
           );  

           $_SESSION["shopping_cart"][0] = $item_array;  
           echo "  
	           <script>
	           window.location = 'home.php'; 
	           </script>
           ";
         }  	
      }

        else

        {	
          echo "  
           <script>
           alert('You need to login First');    
           window.location = 'Login.php'; 
           </script>
           ";
        }

     }  

      if(!empty($_SESSION["shopping_cart"]))  
      {  
           $total = 0;  
           $itemcount = 0;
           foreach($_SESSION["shopping_cart"] as $keys => $values)  
           {  
	          	$itemcount = $itemcount + 1;
	       }

	      }
	?>

	<html>
		<head>	
			<title>Home | ShopH</title>	
			<meta name="viewport" content="width=device-width, initial-scale=1.0">

			<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">      
			<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
			<link href="themes/css/bootstrappage.css" rel="stylesheet"/>

		
		<!-- global styles -->	
		<link href="themes/css/flexslider.css" rel="stylesheet"/>

 			
		<!-- scripts -->
		<script src="themes/js/jquery-1.7.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>							
		<script src="themes/js/superfish.js"></script>	
		<script src="themes/js/jquery.scrolltotop.js"></script>

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
			  -webkit-animation-duration: 3s;
			  animation-name: fade;
			  animation-duration: 3s;
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
	<br>

<div class="slideshow-container">
	<div class="mySlides fade">
		<a href="home.php"><img src="themes/images/carousel/promo-banner.jpg" style="width:100%; max-height: 500px;"></a>
	</div>
	<?php 

    		$today = date('Y-m-d');

    		$selectad = "SELECT * FROM advertisement 
    					 WHERE Day1 = '$today' 
    					 OR    Day2 = '$today'
    					 OR    Day3 = '$today'";

            $runad = mysqli_query($connect, $selectad);
          	$countad = mysqli_num_rows($runad);


	        for ($i=0;$i<$countad;$i++)  
	        {
	          $rowad = mysqli_fetch_array($runad);
	          $adid  = $rowad['AdvertisementID'];
	          $adimg = $rowad['Image'];
	          $sellerid = $rowad['SellerID'];
	        ?>

			<div class="mySlides fade">
			  <a href="search_result.php?advertisement&&sellerid=<?php echo($sellerid) ?>">
			  	<img src="<?php echo($adimg); ?>" style="width:100%; max-height: 500px;">
			  </a>
			</div>

	<?php } ?>

<br>

<div style="text-align:center">
	<span class='dot'></span>
	<?php 

		for ($i=0;$i<$countad;$i++)  
	    {
	    	echo "<span class='dot'></span> ";
	    }
	 ?>
  
</div>

    <section class="header_text">	

				Welcome To <span>ShopH.com</span>
				<br>
				<p>We are providing best services to our customers with <span>24/7</span> available customer center</p>
			</section>
		

			<section class="main-content">
				<div class="row">
					<div class="span12">	
						<div class="row">
							<div class="span12">

								<h4 class="title">
									<span class="pull-left"><span class="text"><span class="line">Latest <strong>Products</strong></span></span></span>
									<span class="pull-right">
									<a class="left button" href="#myCarousel-2" data-slide="prev"></a><a class="right button" href="#myCarousel-2" data-slide="next"></a>
									</span>
								</h4>    		

								<div id="myCarousel-2" class="myCarousel carousel slide">
									<div class="carousel-inner">
										<div class="active item">
										<ul class="thumbnails">	

										    <!-- Single Products -->

											<?php 

											    $select = "SELECT * FROM product ORDER BY UploadDate";
											    $run    = mysqli_query($connect, $select); 
										        $count  = mysqli_num_rows($run);   

										        for ($i=0; $i < $count; $i++) 	
										        { 
										          $row    = mysqli_fetch_array($run);
										          $pid    = $row['ProductID'];
										          $pname  = $row['ProductName'];
										          $price  = $row['Price'];
										          $stock  = $row['Stock'];
										          $bid    = $row['BrandID'];
										          $sid    = $row['SubCategoryID'];
										          $image  = $row['ProductPicture0'];

	                                              $category    = ATTRIBUTE_EXTRACTOR('subcategory', 'SubCategoryID', $sid, 'SubCategoryName');
	                                              $brandname   = ATTRIBUTE_EXTRACTOR('Brand', 'BrandID', $bid, 'BrandName');

	                                              
										            
											?>

													<li class="span3">
													  <div class="product-box" style="height: 380px;">
													  	<form method="POST" action="home.php?action=add&id=<?php echo $pid ?>">
														 <p>
														 	<div  class="pd-img-container">

														 	   <!-- <img src="<?php echo($image)?>" class="pd-img" /> -->
														 	   <div class="pd-img" style="background-image: url(<?php  echo "$image" ?>);"></div>

															</div>
														</p>			
														 <a href="product.php?productid=<?php echo $pid ?>" class="title" style="color: #ee3e0d;"><?php echo $pname ?></a><br/>
														 <p class="category"><?php echo "$brandname"; ?> ( <?php echo "$category"; ?> )</p>
														 <p class="price">Price - $<?php echo $price ?></p>

														 <p><a href="product.php?productid=<?php echo $pid ?>" class="pdetail">See Details</a></p>

														</form>   
													  </div>	 

													</li>	

										<?php  } ?>		

										</ul>
										</div>
										
									</div>							 	
								</div>
							</div>						
						</div>	

							<section class="our_client">

				<h4 class="title"><span class="text">Top Brands</span></h4>

				<div class="row">	

					<?php 

						$select = "SELECT * FROM Brand";
						$run = mysqli_query($connect, $select);
						$count = mysqli_num_rows($run);
						for ($j=0;$j<$count;$j++)
						{
							$row = mysqli_fetch_array($run);
							$brandid = $row['BrandID'];
							$brandname = $row['BrandName'];
							$brandlogo = $row['BrandLogo'];

							echo "
							<div class='span2'>
								<a href='brand_search.php?brand=$brandid'><img class='brand-sec' alt='$brandname' src='$brandlogo'></a>
							</div>";

						}
					 ?>		

				</div><br>
				<hr>

			</section>											
						
						<div class="row feature_box">						
							<div class="span4">
								<div class="service">
									<div class="responsive">	
										<img src="themes/images/feature_img_2.png" alt="" />
										<h4>MODERN <strong>DESIGN</strong></h4>
										<p>We guarantee our customers with the products or items in our Websites.</p>									
									</div>
								</div>
							</div>

							<div class="span4">					
								<div class="service">
									<div class="customize"> 
										<img src="themes/images/feature_img_1.png" alt="" />
										<h4>FREE <strong>SHIPPING</strong></h4>
										<p>ShopH provides free Shipping fee for every items. But delivey fee varies with the location that you want to pick up.</p>
									</div>
								</div>
							</div>
									
							<div class="span4">
								<div class="service">
										<div class="support">	
										<img src="themes/images/feature_img_3.png" alt="" />
										<h4>24/7 LIVE <strong>Support</strong></h4>
										<p>We are active 24/7 for our customers and always ready to help their problems with our website</p>
									</div>
								</div>
							</div>	

						</div>		
					</div>				
				</div>
			</section>	

			<?php include('footer.php'); ?>

		
    </body>
</html>




<script>
var slideIndex = 0;

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 3000); // Change image every 2 seconds
}

window.onload = showSlides;
</script>