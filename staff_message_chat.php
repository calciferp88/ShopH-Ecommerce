<?php

	include('admin_header.php');
	$connect = mysqli_connect('localhost','root','','shophdb');

	if (isset($_GET['customerid']))
	{	
		// to chat with customer, get id from status bar
		$senderid = $_GET['customerid'];
		$select = "SELECT *
				   FROM customer
				   WHERE CustomerID = '$senderid'
				   AND ChatWithAdmin = '1'
					";

		$run = mysqli_query($connect, $select);
		$count = mysqli_num_rows($run);

		if ($count == 0)  
		{	
			// it no previous message, send a message first
			$adminmessageid = ID_MAKER('adminmessage', 'AdminMessageID');	
        	$date      = date('Y-m-d'); 
        	$time      = date('H:i:s');

			$update    = "UPDATE `customer` SET ChatWithAdmin = '1' WHERE CustomerID = '$senderid' ";
            $run = mysqli_query($connect, $update );  			

            $Insert    = "INSERT INTO `adminmessage` VALUES ('$adminmessageid', '$senderid','Hello', '', 'Staff', '$time', '$date')";
            $run = mysqli_query($connect, $Insert);  
		}
	}

	// insert message
	if(isset($_POST['btn-send']))
	{	
	    $adminmessageid = ID_MAKER('adminmessage', 'AdminMessageID');	
		$message   	= $_POST['txtmessage'];	
		$customerid   	= $_GET['customerid'];  
        $date       = date('Y-m-d');   
        $time       = date('H:i:s');

        $Insert2    = "INSERT INTO `adminmessage` 
            		   VALUES ('$adminmessageid', '$customerid', '$message', '', 'Staff', '$time','$date')";
        $run2 = mysqli_query($connect, $Insert2); 
	}

?>

<!DOCTYPE html>
<html>

<head>

	<title>Admin Dashboard | ShopH</title>
	<style type="text/css">
   
			.rowx
			{
				display: flex;
				width: 95%;
				margin-left: auto;
				margin-right: auto;
			}

			.col-4
			{
				flex: 30%;
			}


			.col-6
			{
				flex: 70%;
			}

			.container-li
			{
				height: 430px;
				overflow-y: auto;
				
				box-shadow: 0px 0px 10px #d9d9d9;
				margin-right: 10px;
				margin-top: 20px;
				border-radius: 10px;
			}

			.container-li ul
			{
				padding:10px;
				border:1px solid #d9d9d9;
				margin-left: 0px;
				height: 30px;
				border-radius: 10px;
				margin-bottom: 5px;
			}

			.container-li ul:hover
			{
				background-color: #f2f2f2;
			}

			.container-li ul li a
			{
				font-size: 15px;
				font-weight: bold;
			} 

			.container-li ul li span
			{ 
				background-color: #f5653d;
				color: white;
				padding: 5px;
				border-radius: 10%;
				float: right;
			}

			.msg-top
			{
					width: 97.3%;
					height: 40px;
					top: 0px;
					position: sticky;
					padding: 10px;
					border-bottom: 1px solid #ccc;
					z-index: 1000;
					background-color: white;
			}

			.msg-top p
			{
				font-size: 17px;
				margin-top: 10px;
				font-weight: bold;
			}

			.msg-bottom
			{
				width: 97.3%;
				height: 40px;
				position: sticky;   	
				padding: 10px;		
				border-top: 1px solid #ccc;
				background-color: white;
			}

			.input
			{
				width: 93%;
			}

			form button
			{
				border: none;
				padding: 8px;
				background-color: transparent;
				color: #ee3e0d;
				font-size: 20px;

			}

			.message-main
			{
				width: 97.3%;
				height: 370px;
				padding:20px;
				-moz-box-shadow:    inset 0 0 10px #e6e6e6;
  				-webkit-box-shadow: inset 0 0 10px #e6e6e6;
 				box-shadow:         inset 0 0 10px #e6e6e6;	
			}

			.message
			{
				padding: 5px;
				font-size: 16px;
				display: inline-block;
				margin-bottom: 20px;
				font-weight: bold;

			}

			.message .text	
			{
				margin-left: 20px;
				background-color: #f2f2f2;
				padding: 10px;
				border-radius: 10px;
				font-weight: normal;
			}

			.message .date	
			{
				margin-left: 20px;
				font-weight: normal;
				font-size: 15px;
				color: #ee3e0d;
				display: none;
			}

			.message:hover .date
			{
				display: inline-grid;
			}


			/* width */
			.container-li::-webkit-scrollbar {
			  width: 5px;
			}

			/* Track */
			.container-li::-webkit-scrollbar-track {
			  background: #f1f1f1; 
			}
			 
			/* Handle */
			.container-li::-webkit-scrollbar-thumb {
			  background: #888; 
			}

			/* Handle on hover */
			.container-li::-webkit-scrollbar-thumb:hover {
			  background: #555; 
			}

			.gif
			{
				display: block;
				margin-left: auto;
				margin-right: auto;
				width: 45%;
				margin-top: 10%;
				border-radius: 20px;
			}

			.unchat p
			{
				font-size: 17px;
				text-align: center;
				padding-top: 20px;
			}

	</style>

</head>

<body>
	
		<div class="rowx">

			<div class='col-4 container-li' style="padding: 10px;"> 
				<br>

				<?php 

					// select customer who has chatted with admin
					$select1 = "SELECT *
				    FROM customer c
				    WHERE c.ChatWithAdmin = '1'";			

					$run1 = mysqli_query($connect, $select1);
					$count1 = mysqli_num_rows($run1);

				for ($i=0;$i<$count1;$i++)
				{

					$row1		 = mysqli_fetch_array($run1);
					$friend      = $row1['CustomerName'];
					$chathim   = $row1['CustomerID'];

							echo "<ul>
							<li><a href='staff_message_chat.php?customerid=$chathim'>$friend</a><span>3</span></li>
						  </ul>
						";

				}

				 ?>
				

			</div>

			<div class='col-6 container-li' style="height: 450px; 
 				overflow-x: hidden;			">


			 	<?php 

			 		if (isset($_GET['customerid'])) 
			 		{
						$receiverid = $_GET['customerid'];
			            $top = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $receiverid, 'CustomerName');			
				?>

				<div class="msg-top"><p><?php echo "$top"; ?></p></div>
				<div class="msg-bottom">	
					<form method="POST" action="staff_message_chat.php?customerid=<?php echo($receiverid) ?>">
						<input type="text" name="txtmessage" class="input-block-level search-query input" Placeholder="Type message . . ." required>	
						<input type="hidden" name="txtreceiver" value="<?php echo($receiverid) ?>">
						<button type="submit" name="btn-send"><i class="fas fa-paper-plane"></i></button>
					</form>		
				</div>
			
				<div class="message-main">

					<?php 


					$selectc = "SELECT *
				    FROM customer c, adminmessage m
				    WHERE c.ChatWithAdmin = '1' 	
				    AND m.CustomerID = '$receiverid'
				    AND c.CustomerID = m.CustomerID
				    ORDER BY m.AdminMessageID DESC";
                     
					$runc = mysqli_query($connect, $selectc);	
					$countc = mysqli_num_rows($runc);

						for ($i=0;$i<$countc;$i++)
						{
							$rowc		 = mysqli_fetch_array($runc);
							$message     = $rowc['Message'];	
							$sender      = $rowc['Sender'];

							if ($sender == 'Staff') 
							{
							  $username = "Staff";
							}

							else
							{
			                  $username = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $sender, 'CustomerName');
							}

			                $userm    = substr($username,0,6);
							$date     = $rowc['Date'];
							$time     = $rowc['Time'];
							$messageidins = $rowc['AdminMessageID'];

							echo "<p class='message'>$userm
										<span class='text'> $message </span>
										<span class='date'>  $date | $time 	</span>
								</p><br>";
						}		

					 ?>
					
				</div>

				

				<?php } else { ?>

			<div class="unchat">
				<img src="themes/images/chat.gif" class="gif">
				<p>Chosse a person to chat</p>
			</div>

			<?php } ?>

		

			</div>

		</div>


</body>

</html>

<?php 	include('footer.php'); ?>


