    <?php 

	$connect = mysqli_connect('localhost','root','','shophdb');
	include('header.php');	

  // Login or not
  if (!isset($_SESSION['user']))
  {
    echo "
    <script>
      alert('You need to login First');
      window.location = 'Login.php'; 
    </script>";
  }

  else
  {
    $useremail = $_SESSION['user'];
    $select = "SELECT * FROM customer WHERE CustomerEmail='$useremail'";
    $run = mysqli_query($connect, $select);
    $data = mysqli_fetch_array($run);

    // Got all necessary data of logged in Person
    $customerid = $data['CustomerID'];
    $customername = $data['CustomerName'];
    $customeremail = $data['CustomerEmail'];
    $customerphone = $data['CustomerPhone'];
    $customergender = $data['CustomerGender'];
    $customerdateofbirth = $data['CustomerDateofBirth'];
    $customercountry = $data['CustomerCountry'];
    $customerpostalcode = $data['CustomerPostalCode'];
    $customeraddress = $data['CustomerAddress'];

  }

  if(!empty($_SESSION["shopping_cart"]))   
  
  {  
      $total = 0;  
      
      // Total item 
      foreach($_SESSION["shopping_cart"] as $keys => $values)  
      { 
          $total = $total + ($values["item_quantity"] * $values["item_price"]);  
      }  
  }

  // Paid with cashon 
  if (isset($_POST['btn-checkout-cashon'])) 
  {

    // For auction
    if (isset($_GET['auctioncheckout'])) 
    {
        $checkoutid   = ID_MAKER('checkout', 'CheckoutID');
        $checkoutdate = date('Y-m-d');
        $checkoutday   = date('d');
        $checkoutmonth = date('m');
        $checkoutyear = date('Y');
        $paymenttype  = 'Cash On Delivery';
        $FullAddress  = $_POST['txtFullAddress'];
        $customerid   = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $useremail, 'CustomerID');

        $auctionid  = $_GET['auctionid'];
        $ProductID  = ATTRIBUTE_EXTRACTOR('auction', 'AuctionID', $auctionid, 'ProductID');
        $totalprice  = ATTRIBUTE_EXTRACTOR('auction', 'AuctionID', $auctionid, 'CurrentBid');
        $sellerid   = ATTRIBUTE_EXTRACTOR('product', 'ProductID', $ProductID, 'CustomerID');
       
        $insertcheckout = 
        "INSERT INTO checkout 
        VALUES ('$checkoutid','$checkoutdate', '$checkoutday', '$checkoutmonth', '$checkoutyear', '$totalprice', 'Cash On Delivery' ,'','','','','', '', '$FullAddress', 'Pending', '$customerid', '$sellerid')";

        $run = mysqli_query($connect, $insertcheckout);


        $Insert2 =  "INSERT INTO checkoutproduct  
                      VALUES ('$checkoutid','$ProductID', '1')";
        $run2 = mysqli_query($connect, $Insert2); 

        $minus = "UPDATE `product`  
                  SET `Stock` = `Stock`-'1', `TotalSale` = `TotalSale` + '1'  
                  WHERE `ProductID` = '$ProductID'  ";    
                         
        $run3 = mysqli_query($connect, $minus); 

        $change = "UPDATE `auction`  
                  SET `Status` = 'Paid'
                  WHERE `AuctionID` = '$auctionid'  ";    
                         
        $run4 = mysqli_query($connect, $change); 

    
          if($run4)
          {

            echo "
            <script>
              alert('Your Order is Successful');
              window.location.assign('home.php');
            </script>";

          } 

          else
          {
            echo mysqli_error($connect);
          }
    }

    // Cart Cehckout
    else
    {
        $checkoutid   = ID_MAKER('checkout', 'CheckoutID');
        $checkoutdate = date('Y-m-d');
        $checkoutday   = date('d');
        $checkoutmonth = date('m');
        $checkoutyear = date('Y');
        $totalprice   = $total;
        $paymenttype  = 'Cash On Delivery';
        $FullAddress  = $_POST['txtFullAddress'];
        $customerid   = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $useremail, 'CustomerID');

         foreach($_SESSION["shopping_cart"] as $keys => $values) 
        {  
          
          $ProductID  = $values["item_id"]; 
          $sellerid   = ATTRIBUTE_EXTRACTOR('product', 'ProductID', $ProductID, 'CustomerID');
          $selleridforupdate = $sellerid;
        }

        $insertcheckout = 
        "INSERT INTO checkout 
        VALUES ('$checkoutid','$checkoutdate', '$checkoutday', '$checkoutmonth', '$checkoutyear', '$totalprice', 'Cash On Delivery' ,'','','','','', '', '$FullAddress', 'Pending', '$customerid', '$selleridforupdate')";

        $run = mysqli_query($connect, $insertcheckout);

        foreach($_SESSION["shopping_cart"] as $keys => $values) 
        {  

          $ProductID  = $values["item_id"]; 
          $Quantity   = $values["item_quantity"]; 
          $sellerid   = ATTRIBUTE_EXTRACTOR('product', 'ProductID', $ProductID, 'CustomerID');

          $Insert2 =  "INSERT INTO checkoutproduct  
                       VALUES ('$checkoutid','$ProductID', '$Quantity')";
          $run2 = mysqli_query($connect, $Insert2); 

          $minus = "UPDATE `product`  
                    SET `Stock` = `Stock`-'$Quantity', `TotalSale` = `TotalSale` + '1'  
                    WHERE `ProductID` = '$ProductID'  ";    
                         
          $run3 = mysqli_query($connect, $minus); 

        }


          if($run3)
          {

            unset($_SESSION["shopping_cart"]); 
            echo "
            <script>
              alert('Your Order is Successful');
              window.location.assign('home.php');
            </script>";

          } 

          else
          {
            echo mysqli_error($connect);
          }
        }
   


  } 

  // Pay with credit card
  if (isset($_POST['btn-checkout-card'])) 
  {

    // Paid for auction
    if (isset($_GET['auctioncheckout'])) 
    {
        $checkoutid   = ID_MAKER('checkout', 'CheckoutID');
        $checkoutdate = date('Y-m-d');
        $checkoutday   = date('d');
        $checkoutmonth = date('m');
        $checkoutyear = date('Y');
        $totalprice  = ATTRIBUTE_EXTRACTOR('auction', 'AuctionID', $auctionid, 'CurrentBid');
        $cardtype     = $_POST['sel-card'];
        $Nameoncard   = $_POST['txtnameoncard'];
        $cardno       = $_POST['txtcardnumber'];
        $expmonth     = $_POST['txtexpmonth'];
        $expyear      = $_POST['txtexpyear'];         
        $expcvv       = $_POST['txtcvv'];
        $FullAddress  = $_POST['txtFullAddress2'];
        $customerid   = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $useremail, 'CustomerID');

        $auctionid  = $_GET['auctionid'];
        $ProductIDa  = ATTRIBUTE_EXTRACTOR('auction', 'AuctionID', $auctionid, 'ProductID');
        $totalprice  = ATTRIBUTE_EXTRACTOR('auction', 'AuctionID', $auctionid, 'CurrentBid');
        $sellerid   = ATTRIBUTE_EXTRACTOR('product', 'ProductID', $ProductIDa, 'CustomerID');

        $insertcheckout2 = 
        "INSERT INTO checkout 
         VALUES ('$checkoutid', '$checkoutdate', '$checkoutday', '$checkoutmonth', '$checkoutyear', '$totalprice', 'Credit Card' , '$cardtype', '$Nameoncard', '$cardno', '$expmonth', '$expyear', '$expcvv', '$FullAddress', 'Pending', '$customerid', '$sellerid')";

        $run = mysqli_query($connect, $insertcheckout2);

        $sellerid   = ATTRIBUTE_EXTRACTOR('product', 'ProductID', $ProductIDa, 'CustomerID');

        $Insert2 =  "INSERT INTO checkoutproduct  
                     VALUES ('$checkoutid','$ProductIDa', '1')";
        $run2 = mysqli_query($connect, $Insert2); 

        $minus = "UPDATE `product`  
                    SET `Stock` = `Stock`-'1', `TotalSale` = `TotalSale` + '1'  
                    WHERE `ProductID` = '$ProductIDa'  ";    
                         
        $run3 = mysqli_query($connect, $minus); 
     
        $change = "UPDATE `auction`  
                  SET `Status` = 'Paid'
                  WHERE `AuctionID` = '$auctionid'  ";    
                         
        $run4 = mysqli_query($connect, $change);  

          if($run4)
          { 
            echo "
            <script>
              alert('Your Order is Successful');
              window.location.assign('home.php');
            </script>";

          } 

          else
          {
            echo mysqli_error($connect);
          }

    } 


    else
    {
        $checkoutid   = ID_MAKER('checkout', 'CheckoutID');
        $checkoutdate = date('Y-m-d');
        $checkoutday   = date('d');
        $checkoutmonth = date('m');
        $checkoutyear = date('Y');
        $totalprice   = $total;
        $cardtype     = $_POST['sel-card'];
        $Nameoncard   = $_POST['txtnameoncard'];
        $cardno       = $_POST['txtcardnumber'];
        $expmonth     = $_POST['txtexpmonth'];
        $expyear      = $_POST['txtexpyear'];         
        $expcvv       = $_POST['txtcvv'];
        $FullAddress  = $_POST['txtFullAddress2'];
        $customerid   = ATTRIBUTE_EXTRACTOR('Customer', 'CustomerEmail', $useremail, 'CustomerID');

         foreach($_SESSION["shopping_cart"] as $keys => $values) 
        {  
          
          $ProductID  = $values["item_id"]; 
          $sellerid   = ATTRIBUTE_EXTRACTOR('product', 'ProductID', $ProductID, 'CustomerID');
          $selleridforupdate = $sellerid;
        }

        $insertcheckout2 = 
        "INSERT INTO checkout 
         VALUES ('$checkoutid', '$checkoutdate', '$checkoutday', '$checkoutmonth', '$checkoutyear', '$totalprice', 'Credit Card' , '$cardtype', '$Nameoncard', '$cardno', '$expmonth', '$expyear', '$expcvv', '$FullAddress', 'Pending', '$customerid', '$selleridforupdate')";

        $run = mysqli_query($connect, $insertcheckout2);

        foreach($_SESSION["shopping_cart"] as $keys => $values) 
        {  

          $ProductID  = $values["item_id"]; 
          $Quantity   = $values["item_quantity"]; 
          $sellerid   = ATTRIBUTE_EXTRACTOR('product', 'ProductID', $ProductID, 'CustomerID');

          $Insert2 =  "INSERT INTO checkoutproduct  
                       VALUES ('$checkoutid','$ProductID', '$Quantity')";
          $run2 = mysqli_query($connect, $Insert2); 

          $minus = "UPDATE `product`  
                    SET `Stock` = `Stock`-'$Quantity', `TotalSale` = `TotalSale` + '1'  
                    WHERE `ProductID` = '$ProductID'  ";    
                         
          $run3 = mysqli_query($connect, $minus); 
        }

          if($run3)
          {

            unset($_SESSION["shopping_cart"]); 
            echo "
            <script>
              alert('Your Order is Successful');
              window.location.assign('home.php');
            </script>";

          } 

          else
          {
            echo mysqli_error($connect);
          }
        }
   

  }

  if (isset($_GET['auctioncheckout'])) 
  {
   
  }

  else
  {   
     // if cart is empty 
     if(empty($_SESSION["shopping_cart"]))      
      {
         echo "  
                <script>
                alert('Your Cart Is Empty !'); 
                window.location = 'Home.php'; 
                </script>
              "; 
      }
  }

 

?>

<html>
	<head>

		<title>Checkout | ShopH</title>	

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">      
		<link href="themes/css/bootstrappage.css" rel="stylesheet"/>
		
		<!-- global styles -->	
		<link href="themes/css/flexslider.css" rel="stylesheet"/>
		<link href="themes/css/Main.css" rel="stylesheet"/>

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="themes/css/generalcss.css"> 

    <style type="text/css">
      
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

      [type="radio"]:checked,
      [type="radio"]:not(:checked) 
      {
          position: absolute;
          left: -9999px;
      }

      [type="radio"]:checked + label,
      [type="radio"]:not(:checked) + label
      {
          position: relative;
          padding-left: 28px;
          cursor: pointer;
          line-height: 20px;
          display: inline-block;
          color: #666;
      }

      [type="radio"]:checked + label:before,
      [type="radio"]:not(:checked) + label:before {
          content: '';
          position: absolute;
          left: 0;  
          top: 0;
          width: 18px;
          height: 18px;
          border: 1px solid #ee3e0d;
          border-radius: 100%;
          background: #fff;
        
        border: 1px #ee3e0d solid;
      }

      [type="radio"]:checked + label:after,
      [type="radio"]:not(:checked) + label:after {
          content: '';
          width: 12px;
          height: 12px;     
          background: #ee3e0d;
          position: absolute;
          top: 4px;
          left: 4px;
          border-radius: 100%;
          -webkit-transition: all 0.2s ease;
          transition: all 0.2s ease;
      }
      [type="radio"]:not(:checked) + label:after {
          opacity: 0;
          -webkit-transform: scale(0);
          transform: scale(0);
      }
      [type="radio"]:checked + label:after {
          opacity: 1; 
          -webkit-transform: scale(1);
          transform: scale(1);
      }

      .btncheck
      {
        background-color: #ee3e0d;
        padding:10px;
        color: white;
        font-weight: bold;
        border-radius: 5px;
        display: grid;
        font-family: ;
      }

      input[type="number"], input[type="password"], input[type="email"]
      {
        padding:10px;
        width: 95%;
        background-color: #f2f2f2;
        outline: none;
      }

      input[type="text"], textarea
      {    
        width: 98%;
      }

      .cart-sec
      { 

        padding: 10px;
        flex: 28%;
        margin-top: 60px;
        border-radius: 10px;
      }

      .cart-sec h4 span
      {
        float: right;
      }

      td
      {
        text-align: center;
      } 
    </style>
 			
	</head>
    <body>		    

          <div class="">
            
            <div class="address-sec">  


              <?php 

                // Auction or not

                if (isset($_GET['auctioncheckout'])) 
                { 
                  $auctionid = $_GET['auctionid'];
                  echo "<form action='checkout.php?auctioncheckout&&auctionid=$auctionid' method='POST'><br><br>";
                }

                else
                {
                  echo "<form action='checkout.php' method='POST'><br><br>";
                }


               ?>
                  <label for="Payment">Choose a Payment Method</label><br>

                  <input type="radio" id="card" onclick="myFunction()" name="radio-group" checked>
                  <label for="card">Credit Card</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                  <input type="radio" name="radio-group" id="del" onclick="myFunction()" >
                  <label for="del">Cash On Delivery</label>

                  <!-- Cash On form -->
                  <div id="del-div" style="display:none">
                  
                    <h4 class="title" align="center"><span class="text"><strong>Shipping</strong> Address</span></h4>
               
                    <label for="Name">Receiver Name</label>
                    <input type='text' name='' value="<?php echo($customername) ?>" readonly required><br>

                    <div class="row">

                      <div class="col-50">
                        <label for="Name">Receiver Email</label>
                        <input type='text' name='' value="<?php echo($useremail) ?>" readonly  required><br>
                      </div>

                      <div class="col-50">
                        <label for="Name">Receiver Phone</label>
                        <input type='number' name='' value="<?php echo($customerphone) ?>" readonly  required><br>
                      </div>

                    </div>
                    
                    <label for="Name">Full Address</label>
                    <textarea type='text' name='txtFullAddress'  required><?php echo"$customeraddress" ?></textarea>
                      
                   <div class="row">

                      <div class="col-50">
                        <label for="Postal Cod">Postal Code</label>
                        <input type='number' value="<?php echo($customerpostalcode) ?>" readonly required><br>
                      </div>

                      <div class="col-50">
                        <label for="Name">Country</label>
                        <input type='text' style="width: 96%;" value="<?php echo($customercountry) ?>" readonly required ><br>
                      </div>

                    </div><br>

                    <p style="font-size: 15px">
                      If you want to your details, Please go to 
                      <a href="customer_details.php">
                        <i class="fa fa-user"></i> User Information
                      </a>
                    </p>

                    <button class="btncheck" type="submit" name="btn-checkout-cashon">Checkout Now !</button>

              </form>

                  </div> 

                  <!-- Credit card Form -->
          <div id="card-div" >

                      <div class="form-group">
                         <h4 class="title" align="center"><span class="text"><strong>Payment </strong> Information</span></h4>
                      </div>

           <?php 

                if (isset($_GET['auctioncheckout'])) 
                { 
                  $auctionid = $_GET['auctionid'];
                  echo "<form action='checkout.php?auctioncheckout&&auctionid=$auctionid' method='POST'><br><br>";
                }

                else
                {
                  echo "<form action='checkout.php' method='POST'><br><br>";
                }


            ?>
                          
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
                              <input type='number' name='txtcvv' min="100" max="999" required><br>
                          </div>

                        </div>

                        <!-- ------------------------- -->

                        <div class="form-group">
                             <h4 class="title" align="center"><span class="text"><strong>Shipping </strong> Address</span></h4>
                        </div>

               
                    <label for="Name">Reciever Name</label>
                    <input type='text' name='' value="<?php echo($customername) ?>" readonly required><br>

                    <div class="row">

                      <div class="col-50">
                        <label for="Name">Reciever Email</label>
                        <input type='text' name='' value="<?php echo($useremail) ?>" readonly  required><br>
                      </div>

                      <div class="col-50">
                        <label for="Name">Reciever Phone</label>
                        <input type='number' name='' value="<?php echo($customerphone) ?>" readonly  required><br>
                      </div>

                    </div>
                    
                    <label for="Name">Full Address</label>
                    <textarea type='text' name='txtFullAddress2'  required><?php echo"$customeraddress" ?></textarea>
                      
                   <div class="row">

                      <div class="col-50">
                        <label for="Postal Cod">Postal Code</label>
                        <input type='number' value="<?php echo($customerpostalcode) ?>" readonly  required><br>
                      </div>

                      <div class="col-50">
                        <label for="Name">Country</label>
                        <input type='text' style="width: 96%;" value="<?php echo($customercountry) ?>" readonly required ><br>
                      </div>

                    </div><br>

                    <p style="font-size: 15px">
                      If you want to edit reciever details, Please go to 
                      <a href="customer_details.php">
                        <i class="fa fa-user"></i> User Information
                      </a>
                    </p>

                    <button class="btncheck" name="btn-checkout-card">Checkout Now !</button>

                     </form>

                  </div>

           
                  
          </div>




          </div>
          
        <?php include('footer.php'); ?>
        </div><br><br>

    </body>
    
    <script type="text/javascript">

      
      function myFunction() 
      {
          // Get the checkbox
          var checkBox = document.getElementById("card");
          // Get the output text
          var text = document.getElementById("card-div");

          // If the checkbox is checked, display the output text
          if (checkBox.checked == true)
          {
            text.style.display = "block";
          } 

          else    
          { 
            text.style.display = "none";
          }

           // Get the checkbox
          var checkBox2 = document.getElementById("del");

          // Get the output text
          var text2 = document.getElementById("del-div");   

          // If the checkbox is checked, display the output text
          if (checkBox2.checked == true)
          {
            text2.style.display = "block";  
          } 

          else  
          {
            text2.style.display = "none";
          }

        }
    </script>

    <!-- Credit Card Formatter 
    https://stackoverflow.com/questions/45312169/auto-format-credit-card-number-input-as-user-types-->
      
    <script type="text/javascript">
      var txtCardNumber = document.querySelector("#txtCardNumber");
      txtCardNumber.addEventListener("input", onChangeTxtCardNumber);

      function onChangeTxtCardNumber(e) {   
          var cardNumber = txtCardNumber.value;
       
          // Do not allow users to write invalid characters
          var formattedCardNumber = cardNumber.replace(/[^\d]/g, "");
          formattedCardNumber = formattedCardNumber.substring(0, 16);
        
          // Split the card number is groups of 4
          var cardNumberSections = formattedCardNumber.match(/\d{1,4}/g);
          if (cardNumberSections !== null) {
              formattedCardNumber = cardNumberSections.join(' '); 
          }
        
          console.log("'"+ cardNumber + "' to '" + formattedCardNumber + "'");
        
          // If the formmattedCardNumber is different to what is shown, change the value
          if (cardNumber !== formattedCardNumber) {
              txtCardNumber.value = formattedCardNumber;
          }
      }
    </script>
</html>
