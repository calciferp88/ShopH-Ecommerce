<?php 

	$connect = mysqli_connect('localhost','root','','shophdb');

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
	                     'item_image'          =>     $_POST["hidden_image"],    
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
                'item_id'            =>     $_GET["id"],  
	             'item_name'           =>     $_POST["hidden_name"],    
	             'item_price'          =>     $_POST["hidden_price"], 
	             'item_image'          =>     $_POST["hidden_image"],    
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