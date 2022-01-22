<?php
  include('header.php');
  $connect = mysqli_connect('localhost','root','','shophdb');

  if (isset($_GET['productid']) && $_GET['productid'] != '')
  {
    $_SESSION['productid'] = $_GET['productid'];
  }

  else
  {
    echo "<script>
        window.location.assign('shopping_cart.php');
      </script>";
  }

  $pid = $_SESSION['productid'];


  $select = "SELECT * FROM Product WHERE ProductID='$pid'";
  $run = mysqli_query($connect, $select);
  $data = mysqli_fetch_array($run);

  $productname        = $data['ProductName'];
  $productdescription = $data['ProductDescription'];
  $productprice       = $data['Price'];
  $productstock       = $data['Stock'];
  $productdate        = $data['UploadDate'];
  $productpicture     = $data['ProductPicture0']; 
  $productpicture1    = $data['ProductPicture1'];
  $productpicture2    = $data['ProductPicture2'];
  $productpicture3    = $data['ProductPicture3'];
  $productpicture4    = $data['ProductPicture4'];
  $brandid            = $data['BrandID'];
  $categoryid         = $data['SubCategoryID'];
  $sellerid           = $data['CustomerID'];

  $categoryname =  ATTRIBUTE_EXTRACTOR('Category', 'CategoryID', $categoryid, 'CategoryName');
  $brandname    =  ATTRIBUTE_EXTRACTOR('Brand', 'BrandID', $brandid, 'BrandName');

  if (isset($_SESSION['user'])) 
  {
    $userid       =  ATTRIBUTE_EXTRACTOR('customer', 'CustomerEmail', $_SESSION['user'], 'CustomerID');
  }
  
  $Seller       =  ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $sellerid, 'CustomerName');

  // Add to cart 

   if(isset($_POST["add_to_cart"]))  
     {  

        $selleridtest = $_POST["hidden_seller"];

             if(isset($_SESSION["shopping_cart"]))  
            {  
                $item_array_id    = array_column($_SESSION["shopping_cart"], "item_id");  
                $seller_array_id  = array_column($_SESSION["shopping_cart"], "seller_id");  

                if(!in_array($_GET["productid"], $item_array_id))  
                {   

                   if(in_array($selleridtest, $seller_array_id))
                  {

                    $count = count($_SESSION["shopping_cart"]);  
                    $item_array = array(  
                         'item_id'             =>     $_GET["productid"],  
                         'item_name'           =>     $_POST["hidden_name"],    
                         'item_price'          =>     $_POST["hidden_price"], 
                         'item_image'          =>     $_POST["hidden_image"],    
                         'item_quantity'       =>     $_POST["quantity"],
                         'seller_id'           =>     $_POST["hidden_seller"]  
                    );  

                    $_SESSION["shopping_cart"][$count] = $item_array; 

                     echo "  
                           <script>
                           window.location = 'shopping_cart.php'; 
                           </script>
                         ";
                  }

                  else  
                 {  
                      echo "
                  <script> 
                    alert('You cannot buy items from different seller at once !');
                    window.location.assign('home.php');
                  </script>";
                 } 


               }  

                 else  
                 {  
                      echo "
					        <script> 
					          alert('Item Already Exist !');
					          window.location.assign('home.php');
					        </script>";
                 } 
           }

        else  
        {  
           $item_array = array(  
                'item_id'           =>      $_GET["productid"],  
               'item_name'           =>     $_POST["hidden_name"],    
               'item_price'          =>     $_POST["hidden_price"], 
               'item_image'          =>     $_POST["hidden_image"],    
               'item_quantity'       =>     $_POST["quantity"],
               'seller_id'           =>     $_POST["hidden_seller"]  
           );  

           $_SESSION["shopping_cart"][0] = $item_array;  
           echo "  
             <script>
             window.location = 'shopping_cart.php'; 
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

<!DOCTYPE html>
<html>  
<head>

  <title>ShopH | <?php echo "$productname"; ?></title>  

  <!-- global styles -->  
    <link href="themes/css/flexslider.css" rel="stylesheet"/>
    <link href="themes/css/Main2.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="themes/css/style.css">

    <!-- Number Box -->
    <link rel="stylesheet" type="text/css" href="themes/css/jquery.nice-number.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>   
    <script src="themes/js/jquery.nice-number.js"></script>
    <script type="text/javascript">   
    $(function(){ 
      $('input[type="number"]').niceNumber();
    });
  </script>

  <style type="text/css">

    ul .thumbnail
    {
       height: 80px;
    }

    .contact-seller
    {
      font-size: 15px;
    }

  </style>
</head>
<body>  

      <h4 class="title" align="center"><span class="text"><strong>Product</strong> Details</span></h4>

      <section class="main-content">        
        <div class="row">           
          <div class="span9">
            <div class="row">
              <div class="span4">
                <a href="<?php echo($productpicture) ?>" class="thumbnail" data-fancybox-group="group1" title="<?php echo($productname) ?>">
                <img alt="" src="<?php echo($productpicture) ?>"></a>                       
                <ul class="thumbnails small">
                  
                <?php 
                  if ($productpicture1 != NULL) 
                  {
                    echo "
                    <li class='span1'>
                       <a href='$productpicture1' class='thumbnail' data-fancybox-group='group1' title='Description 2'><img src='$productpicture1' alt=''>
                       </a>
                    </li>";
                  }
                 ?>

                 <?php 
                  if ($productpicture2 != NULL) 
                  {
                    echo "
                    <li class='span1'>
                       <a href='$productpicture2' class='thumbnail' data-fancybox-group='group1' title='Description 2'><img src='$productpicture2' alt=''>
                       </a>
                    </li>";
                  }
                 ?>

                 <?php 
                  if ($productpicture3 != NULL)
                  {
                    echo "
                    <li class='span1'>
                       <a href='$productpicture3' class='thumbnail' data-fancybox-group='group1' title='Description 2'><img src='$productpicture3' alt=''>
                       </a>
                    </li>";
                  }
                 ?>


                 <?php 
                  if ($productpicture4 != NULL) 
                  {
                    echo "
                    <li class='span1'>
                       <a href='$productpicture4' class='thumbnail' data-fancybox-group='group1' title='Description 2'><img src='$productpicture4' alt=''>
                       </a>
                    </li>";
                  }
                 ?>
                
                </ul>
              </div>
              <div class="span5">
                <address>
                  <strong>Product :</strong> <span><?php echo $productname ?></span><br><br>
                  <strong>Brand :</strong> <span><?php echo $brandname ?></span><br><br>
                  <strong>In Stock :</strong> <span><?php if($productstock >=1){echo $productstock;} else{echo "Out of Stock";} ?></span><br><br>
                  <!-- <strong>Shipping From:</strong> <span><?php echo $productshipment ?></span><br>   -->
                  <strong>Sold By:</strong> <span><?php echo $Seller ?></span><br>  <br>              
                </address>                  

                 <?php 

                  if (isset($_SESSION['user'])) 
                    {
                          if ($userid != $sellerid) 
                          {   
                            $senderid  =  ATTRIBUTE_EXTRACTOR('customer', 'CustomerEmail', $_SESSION['user'], 'CustomerID');
                            echo "<a href='message_inbox.php?sender=$senderid&&receiver=$sellerid&&     chat' class='contact-seller'><i class='fas fa-envelope'></i> Contact Seller</a>";
                          }
                    }

                  ?><br>
                <h4><strong>Price: $<?php echo $productprice ?></strong></h4>
              </div>
              <div class="span5">
                <form method="POST" action="product.php?action=add&productid=<?php echo $_SESSION['productid'] ?>">
                  
                  <label>Quantity:</label>

                  <!-- Cart Data -->
                  <input type="hidden" name="hidden_image" value="<?php echo($productpicture)?>">
                  <input type="hidden" name="hidden_name" value="<?php echo($productname)?>">
                  <input type="hidden" name="hidden_price" value="<?php echo($productprice)?>">
                  <input type="hidden" name="hidden_seller" value="<?php echo($sellerid)?>">

                  <p class="numberbox">
                    <input type="number" name="quantity" max="<?php echo($productstock); ?>" min="1" class="form-control" value="1" required>
                  </p>

                  <?php 

                    if (isset($_SESSION['user'])) 
                    {
                          if ($userid != $sellerid) 
                          {
                            echo "<p><button type='submit' class='cart-button' name='add_to_cart'>Add to cart</button></p>";
                          }

                          else
                          {
                            echo "<p style='color:red; cursor:not-allowed;'>You can't buy your products.</p>";
                          }
                        }

                        else
                        {
                             echo "<p><button type='submit' class='cart-button' disabled name='add_to_cart'>Add to cart</button></p>";
                             echo "<p style='color:red;'>Please <a>login</a> First to buy a product.</p>";
                        }



                   ?>

                </form>
              </div>              
            </div>
            <div class="row">
              <div class="span9">
                <ul class="nav nav-tabs" id="myTab">
                  <li class="active"><a href="#home">Description</a></li>
                  
                </ul>              
                <div class="tab-content">
                  <div class="tab-pane active" id="home" style="background-color: #f2f2f2; padding:20px;"><?php echo $productdescription ?></div>   
                  
                </div>              
              </div>            
            
            </div>
          </div>
          <div class="span3 col">
            <div class="block"> 
              <ul class="nav nav-list" style="height: 240px; overflow-y: auto; border-bottom: 1px solid #f2f2f2;">
                <li class="nav-header">SUB CATEGORIES</li>
                <?php 

                      $select = "SELECT * FROM subcategory";
                    $run    = mysqli_query($connect, $select); 
                  $count  = mysqli_num_rows($run);   

                  for ($i=0; $i < $count; $i++)   
                  { 
                      $row    = mysqli_fetch_array($run);
                      $sid    = $row['SubCategoryID']; 
                      $sub    = $row['SubCategoryName'];   
                      echo "
                        <li><a href='search_result.php?searchbycate=$sid'>$sub</a></li>
                      ";
                                    }

                                ?>
              </ul><br>

              <ul class="nav nav-list below" style="height: 240px; overflow-y: auto;">
                <li class="nav-header">TOP BRANDS</li>
                <?php 

                      $select = "SELECT * FROM brand";
                    $run    = mysqli_query($connect, $select); 
                  $count  = mysqli_num_rows($run);   

                  for ($i=0; $i < $count; $i++)   
                  { 
                      $row    = mysqli_fetch_array($run);
                      $brand  = $row['BrandName'];
                      $brid   = $row['BrandID'];   
                      echo "
                        <li><a href='brand_search.php?brand=$brid'>$brand</a></li>
                      ";
                                    }
                                ?>

              </ul>
            </div>
  
            <div class="block">               
              <h4 class="title"><strong>Best</strong> Seller</h4>               
              <ul class="small-product">
                <li>
                  <a href="#" title="Praesent tempor sem sodales">
                    <img src="themes/images/ladies/1.jpg" alt="Praesent tempor sem sodales">
                  </a>
                  <a href="#">Praesent tempor sem</a>
                </li>
                <li>
                  <a href="#" title="Luctus quam ultrices rutrum">
                    <img src="themes/images/ladies/2.jpg" alt="Luctus quam ultrices rutrum">
                  </a>
                  <a href="#">Luctus quam ultrices rutrum</a>
                </li>
                <li>
                  <a href="#" title="Fusce id molestie massa">
                    <img src="themes/images/ladies/3.jpg" alt="Fusce id molestie massa">
                  </a>
                  <a href="#">Fusce id molestie massa</a>
                </li>   
              </ul>
            </div>
          </div>
        </div>
        <?php include('footer.php');?>
      </section>      
    </div>

    <script src="themes/js/common.js"></script>
    <script>
      $(function () {
        $('#myTab a:first').tab('show');
        $('#myTab a').click(function (e) {
          e.preventDefault();
          $(this).tab('show');
        })
      })
      $(document).ready(function() {
        $('.thumbnail').fancybox({
          openEffect  : 'none',
          closeEffect : 'none'
        });
        
        $('#myCarousel-2').carousel({
                    interval: 2500
                });               
      });
    </script> 

</body>
</html>


