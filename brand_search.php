<?php 

	$connect = mysqli_connect('localhost','root','','shophdb');
	include('header.php');

	if (isset($_GET['brand'])) 
	{
		$brandid       = $_GET['brand'];
		$brandname     =  ATTRIBUTE_EXTRACTOR('Brand', 'BrandID', $brandid, 'BrandName');
		$brandlogo     =  ATTRIBUTE_EXTRACTOR('Brand', 'BrandID', $brandid, 'BrandLogo');

		$select = "SELECT * FROM product WHERE BrandID = '$brandid' ";
	}



	?>

	<html>
		<head>
			<title><?php echo "$brandname "; ?> | ShopH</title>	
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
			.pd-img
			{
		        background-size: contain;
		        background-position: center;
		        background-repeat: no-repeat;
		        height: 200px;
			}

			#breadcrumb {
			  list-style: none;
			  display: inline-block;
			  margin-top: 30px;
			  margin-left: 0px;
			}
			#breadcrumb .icon {
			  font-size: 14px;
			}
			#breadcrumb li {
			  float: left;
			}
			#breadcrumb li a {
			  color: #FFF;
			  display: block;
			  background: #ee3e0d;
			  text-decoration: none;
			  position: relative;
			  height: 40px;
			  line-height: 40px;
			  padding: 0 10px 0 5px;
			  text-align: center;
			  margin-right: 23px;
			}
			#breadcrumb li:first-child a {
			  padding-left: 15px;
			  -moz-border-radius: 4px 0 0 4px;
			  -webkit-border-radius: 4px;
			  border-radius: 4px 0 0 4px;
			}
			#breadcrumb li:first-child a:before {
			  border: none;
			}
			#breadcrumb li:last-child a {
			  padding-right: 15px;
			  -moz-border-radius: 0 4px 4px 0;
			  -webkit-border-radius: 0;
			  border-radius: 0 4px 4px 0;
			}
			#breadcrumb li:last-child a:after {
			  border: none;
			}
			#breadcrumb li a:before, #breadcrumb li a:after {
			  content: "";
			  position: absolute;
			  top: 0;
			  border: 0 solid #ee3e0d;
			  border-width: 20px 10px;
			  width: 0;
			  height: 0;
			}
			#breadcrumb li a:before {
			  left: -20px;
			  border-left-color: transparent;
			}
			#breadcrumb li a:after {
			  left: 100%;
			  border-color: transparent;
			  border-left-color: #ee3e0d;
			}
			#breadcrumb li a:hover {
			  background-color: #f45225;
			}
			#breadcrumb li a:hover:before {
			  border-color: #f45225;
			  border-left-color: transparent;
			}
			#breadcrumb li a:hover:after {
			  border-left-color: #f45225;
			}
			#breadcrumb li a:active {
			  background-color: #f45225;
			}
			#breadcrumb li a:active:before {
			  border-color: #f45225;
			  border-left-color: transparent;
			}
			#breadcrumb li a:active:after {
			  border-left-color: #f45225;
			}
		</style>


	</head>

<body>	


			<ul id="breadcrumb">
			  <li><a href="home.php"> <i class="fa fa-home"></i> Home </a></li>
			  <li><a href="#"><i class="fa fa-search"></i> <?php echo "$brandname "; ?> </a></li>			
			</ul>
		

			<section class="main-content">
				<div class="row">
					<div class="span12">	
						<div class="row">
							<div class="span12">
								<h4 class="title">
									<span class="pull-left">
										<span class="text">
											<?php 

											// Search function
											if (isset($_POST['txtsearchShop'])) 
											{	
												echo "<span class='line'>Items for <strong>$searchtext</strong></span>";
											}

											else if ( isset($_GET['searchbycate']))
											{
												$searchbycate =  $_GET['searchbycate'];
												$category     =  ATTRIBUTE_EXTRACTOR('SubCategory', 'SubCategoryID', $searchbycate, 'SubCategoryName');
												echo "<span class='line'>Items for <strong>$category</strong></span>";
											}

											else if (isset($_GET['brand'])) 
											{
												echo "<span class='line'>Items for <strong>$brandname</strong></span>";
											}

											 ?>
											
										</span>
									</span>
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

										if (isset($_POST['txtsearchShop'])) 
										{

											$searchtext = $_POST['txtsearchShop'];

											$select = "SELECT * FROM product WHERE ProductName LIKE '%$searchtext%' ORDER BY UploadDate";

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

                                              $selectauction = "SELECT * FROM auction WHERE ProductID = '$pid'";
							                  $runauction = mysqli_query($connect, $selectauction);
										      $countauction = mysqli_num_rows($runauction);

										     
										?>

												<li class="span3">
												  <div class="product-box">
												  	<form method="POST" action="home.php?action=add&id=<?php echo $pid ?>">
													 <p>
													 	<a href="product.php?productid=<?php echo $pid ?>"><!-- 
													 		<img src="<?php echo($image)?>" class="pd-img" /> -->
													 		<div class="pd-img" style='background-image: url(<?php echo"$image"; ?>);'>
													 			
													 		</div>
													    </a>
													</p>
													 <a href="product.php?productid=<?php echo $pid ?>" class="title" style="color: #ee3e0d;"><?php echo $pname ?></a><br/>
													 <p class="category"><?php echo "$brandname"; ?> ( <?php echo "$category"; ?> )</p>
													 <p class="price">Price - $<?php echo $price ?></p>


													</form>   
												  </div>	
												</li>	

									<?php } }

									// Search by category
									elseif (isset($_GET['searchbycate']) )
									{
										$searchbycate = $_GET['searchbycate'];

							            $select = "SELECT * FROM product p, subcategory sc
							            		   WHERE sc.SubCategoryID = '$searchbycate' 
							            		   AND p.SubCategoryID = sc.SubCategoryID
							            		   ";

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

                                          $selectauction = "SELECT * FROM auction WHERE ProductID = '$pid'";
							              $runauction = mysqli_query($connect, $selectauction);
										  $countauction = mysqli_num_rows($runauction);

								    ?>

												<li class="span3">
												  <div class="product-box">
												  	<form method="POST" action="home.php?action=add&id=<?php echo $pid ?>">
													 <p>
													 	<a href="product.php?productid=<?php echo $pid ?>"><!-- 
													 		<img src="<?php echo($image)?>" class="pd-img" /> -->
													 		<div class="pd-img" style='background-image: url(<?php echo"$image"; ?>);'>
													 			
													 		</div>
													    </a>
													</p>
													 <a href="product.php?productid=<?php echo $pid ?>" class="title" style="color: #ee3e0d;"><?php echo $pname ?></a><br/>
													 <p class="category"><?php echo "$brandname"; ?> ( <?php echo "$category"; ?> )</p>
													 <p class="price">Price - $<?php echo $price ?></p>
													 
													</form>   
												  </div>	
												</li>	

								    <?php } }

									elseif (isset($_GET['brand']) )
									{

							            $select = "SELECT * FROM product 
							            		   WHERE BrandID = '$brandid' ";

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

                                          $selectauction = "SELECT * FROM auction WHERE ProductID = '$pid'";
							              $runauction = mysqli_query($connect, $selectauction);
										  $countauction = mysqli_num_rows($runauction);

								    ?>

												<li class="span3">
												  <div class="product-box">
												  	<form method="POST" action="home.php?action=add&id=<?php echo $pid ?>">
													 <p>
													 	<a href="product.php?productid=<?php echo $pid ?>"><!-- 
													 		<img src="<?php echo($image)?>" class="pd-img" /> -->
													 		<div class="pd-img" style='background-image: url(<?php echo"$image"; ?>);'>
													 			
													 		</div>
													    </a>
													</p>
													 <a href="product.php?productid=<?php echo $pid ?>" class="title" style="color: #ee3e0d;"><?php echo $pname ?></a><br/>
													 <p class="category"><?php echo "$brandname"; ?> ( <?php echo "$category"; ?> )</p>
													 <p class="price">Price - $<?php echo $price ?></p>
													 
													</form>   
												  </div>	
												</li>	

								    <?php } } ?>

											</ul>
										</div>
										
									</div>							 	
								</div>
							</div>						
						</div>												
			
							
					</div>				
				</div>
			</section>	

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
								<a href='brand_search.php?brand=$brandid'><img style='height:50px;' class='brand-sec' alt='$brandname' src='$brandlogo'></a>
							</div>";

						}
					 ?>		

				</div>

			</section>

			<?php include('footer.php'); ?>

		
    </body>
</html>

