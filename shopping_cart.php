  <?php
	include('header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');
	if (isset($_GET['productid']) && $_GET['productid'] != ''){
		$_SESSION['productid'] = $_GET['productid'];
	}

	// Delete From Cart
	 if(isset($_GET["action"]))  
	 {  
	      if($_GET["action"] == "delete")  
	      {  
	           foreach($_SESSION["shopping_cart"] as $keys => $values)  
	           {    
	                if($values["item_id"] == $_GET["id"])  
	                {  
	                     unset($_SESSION["shopping_cart"][$keys]);  
	                     echo 
	                     '
	                     <script>
	                     window.location="shopping_cart.php";  
	                     </script>';  
	                }  
	           }      
	      }   

	      if($_GET["action"] == "deleteall")   
	      {  
	          
	           unset($_SESSION["shopping_cart"]); 
	      }   	
	 }  



?>

	<!DOCTYPE html>
	<html>
	<head>
	    <meta charset="utf-8">
		<title>ShopH | Shopping Cart</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<!--[if ie]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
		<!-- bootstrap -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">   	
		<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="themes/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->	
		<link href="themes/css/flexslider.css" rel="stylesheet"/>
		<link href="themes/css/new.css" rel="stylesheet"/>
 			
		<!-- scripts -->
		<script src="themes/js/jquery-1.7.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>				
		<script src="themes/js/superfish.js"></script>	
		<script src="themes/js/jquery.scrolltotop.js"></script>



	</head>
	<body>

	<form action="shopping_cart.php" method="POST" class="cartitem" style="margin-top: 70px;">

    <h1>Shopping Cart</h1>
 
    <div class="top-button">
      <a href="shopping_cart.php?action=deleteall" class="cart-button">Clear Cart</a>
      <a href="Home.php" class="cart-button" >Continue Shopping</a>
    </div>


                <div class="table-responsive">  
                     <table >  
                          <tr>  
                               <th width="20%"></th> 
                               <th width="20%"></th>  
                               <th width="10%"></th>  		
                               <th width="15%"></th>    
                               <th width="15%"></th>   
                               <th width="9%"></th>  
                          </tr>  

                          <?php   
                          if(!empty($_SESSION["shopping_cart"]))   
                          {  
                               $total = 0;  
                              
                               foreach($_SESSION["shopping_cart"] as $keys => $values)  
                               {  
                          ?>  
                          <tr>   				
                               <td><img class="Product_img" src="<?php echo $values['item_image']; ?>"></td>

                               <td>
                                   <h4><a href="product.php?productid=<?php echo $values['item_id']; ?>"><?php echo $values["item_name"]; ?>	</a></h4>
                                </td>     
                              

                               <td><?php echo $values["item_quantity"]; ?> </td>  
                               <td>$ <?php echo $values["item_price"]; ?></td> 
                               <td><h4>Total : $ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></h4></td>  
                               <td><a class="" href="shopping_cart.php?action=delete&id=<?php echo $values["item_id"]; ?>" >Remove <i class="fa fa-trash-alt"></i></a></td>  
                          </tr>  
                          <?php  
                                    $total = $total + ($values["item_quantity"] * $values["item_price"]);  
                               }  
                          ?>  
  
                          <?php  
                          }  

                          else 
                          {
                              echo "  
                                 <script>
                                 alert('Your Cart Is Empty !'); 
                                 window.location = 'Home.php'; 
                                 </script>
                                 "; 
                          }
                          ?>  
                     </table>  

                </div>    

  </form>


         <div class="subtotal cf">
          <ul>
            <li class="totalRow"><span class="label">Subtotal</span><span class="value">$ <?php echo number_format($total, 2); ?></span></li>
            
              <li class="totalRow"><span class="label">Delivery Fee</span><span class="value">$3.00</span></li>
              <li class="totalRow"><span class="label">Service Charges</span><span class="value">$4.00</span></li>
              <li class="totalRow final"><span class="label">Grand Total</span><span class="value">$ <?php echo number_format($total + 3 + 4, 2); ?></span></li><br>
            <li class="totalRow"><a href="checkout.php" class="cart-button">Checkout</a></li><br>
          </ul>
        </div><br><br><br><br><br><br><br><br><br><br>

  

        
        <?php include('footer.php'); ?> 

	</body>

	</html>


