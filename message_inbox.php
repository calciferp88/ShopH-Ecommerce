<?php 

	$connect = mysqli_connect('localhost','root','','shophdb');
	include('header.php');	

	if (isset($_GET['sender']) AND isset($_GET['receiver']))
	{
		$senderid = $_GET['sender'];
		$receiverid = $_GET['receiver'];


		$select = "SELECT *
					FROM customer c, message m, messagereply mr
					WHERE CASE

					WHEN m.sender1 = '$senderid'
					THEN m.sender2 = '$receiverid'

					WHEN m.sender2 = '$senderid'
					THEN m.sender1= '$receiverid'

					END
					";

		$run = mysqli_query($connect, $select);
		$count = mysqli_num_rows($run);

		if ($count == 0)  
		{	
			$messageid 	    = ID_MAKER('message', 'MessageID');
			$messagereplyid = ID_MAKER('messagereply', 'MessageReplyID');
        	$date      = date('Y-m-d'); 
        	$time      = date('H:i:s');

			$Insert    = "INSERT INTO `message` VALUES ('$messageid', '$senderid','$receiverid')";
            $run = mysqli_query($connect, $Insert);  

            $Insert2    = "INSERT INTO `messagereply` 
            			  VALUES ('$messagereplyid', '$date','$time', 'Hi', '', '$senderid', '$messageid')";
            $run2 = mysqli_query($connect, $Insert2); 

		}
	}

	if(isset($_POST['btn-send']))
	{	
		$messagereplyid = ID_MAKER('messagereply', 'MessageReplyID');
		$message   	= $_POST['txtmessage'];
		$msgid      = $_POST['txtmsgid'];
        $date       = date('Y-m-d'); 
        $time       = date('H:i:s');
        $senderid   = $_GET['sender'];
		$receiverid = $_GET['receiver'];

        $Insert2    = "INSERT INTO `messagereply` 
            		   VALUES ('$messagereplyid', '$date','$time', '$message', '', '$senderid', '$msgid')";
        $run2 = mysqli_query($connect, $Insert2); 
	}

	if (isset($_GET['StartAdminChat'])) 
	{
		$customerid = $_GET['customerid'];
		$adminmessageid = ID_MAKER('adminmessage', 'AdminMessageID');	
        $date       = date('Y-m-d'); 
        $time       = date('H:i:s');

        $Insert    = "INSERT INTO `adminmessage` 
            		   VALUES ('$adminmessageid', '$customerid', 'Hello', '', '$customerid', '$time', '$date')";
        $run = mysqli_query($connect, $Insert); 

        $update    = "UPDATE customer
            		   SET ChatWithAdmin = '1' 
            		   WHERE CustomerID = '$customerid'";
        $run2      = mysqli_query($connect, $update); 

	}

	if(isset($_POST['btn-send-to-admin']))
	{	
		$customerid = $_GET['customerid'];
		$adminmessageid = ID_MAKER('adminmessage', 'AdminMessageID');	
		$message =  $_POST['txtmessage'];
        $date       = date('Y-m-d'); 
        $time       = date('H:i:s');

        $Insert2    = "INSERT INTO `adminmessage` 
            		   VALUES ('$adminmessageid', '$customerid', '$message', '', '$customerid', '$time', '$date')";
        $run2 = mysqli_query($connect, $Insert2); 
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
				overflow-x: hidden;
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

					if (isset($_GET['sender']) AND isset($_GET['receiver']))
					{
						$senderid = $_GET['sender'];
					}

					else
					{
						$sender   = $_SESSION['user'];
			            $senderid = ATTRIBUTE_EXTRACTOR('customer', 'CustomerEmail', $sender, 'CustomerID');
					}

					$select1 = "SELECT *
					FROM customer c, message m
					WHERE CASE

					WHEN m.sender1 = '$senderid'	
					THEN m.sender2 = c.CustomerID

					WHEN m.sender2 = '$senderid'
					THEN m.sender1= c.CustomerID
					END
					AND (m.sender1 ='$senderid' OR m.sender2 = '$senderid') 

					ORDER BY m.MessageID DESC";			

					$run1 = mysqli_query($connect, $select1);
					$count1 = mysqli_num_rows($run1);

					// Select if chat with admin
					$selectadmin  = "SELECT * FROM customer 
									 WHERE CustomerID = '$senderid'
									 AND ChatWithAdmin = '1' ";			

					$runadmin = mysqli_query($connect, $selectadmin);
					$countadmin = mysqli_num_rows($runadmin);

					if ($countadmin == 1) 
					{
						echo "<ul>
							<li><a href='message_inbox.php?customerid=$senderid&&chatadmin'>Chat With ShopH</a></li>
						  </ul>
						";
					}

					else
					{
						echo "<ul>
							<li><a href='message_inbox.php?customerid=$senderid&&chatadmin&&StartAdminChat'>Start Chat With ShopH</a></li>
						  </ul>
						";
					}

				for ($i=0;$i<$count1;$i++)
				{

					$row1		 = mysqli_fetch_array($run1);
					$friend     = $row1['CustomerName'];
					$receiverid2     = $row1['CustomerID'];

							echo "<ul>
							<li><a href='message_inbox.php?sender=$senderid&&receiver=$receiverid2&&chat'>$friend</a></li>
						  </ul>
						";

				}

				 ?>
				

			</div>

			<div class='col-6 container-li' style="height: 450px;">

			<?php 

			if (isset($_GET['chat']))
			{

		
			 ?>	

			 	<?php 
					
						$senderid = $_GET['sender'];
						$receiverid = $_GET['receiver'];
			            $top = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $receiverid, 'CustomerName');
			            $selectc = "SELECT *
						FROM message m, messagereply mr
						WHERE CASE

						WHEN m.sender1 = '$senderid'
						THEN m.sender2 = '$receiverid'

						WHEN m.sender2 = '$senderid'
						THEN m.sender1= '$receiverid'
						END 

						AND
						m.MessageID = mr.MessageID

						ORDER BY m.MessageID DESC";

						$runc = mysqli_query($connect, $selectc);	
						$countc = mysqli_num_rows($runc);

							for ($i=0;$i<$countc;$i++)
							{

								$rowc		 = mysqli_fetch_array($runc);
								$messageidins = $rowc['MessageID'];
						    }
				?>

				<div class="msg-top"><p><?php echo "$top"; ?></p></div>
				<div class="msg-bottom">	
					<form method="POST" action="message_inbox.php?sender=<?php echo($senderid) ?>&&receiver=<?php echo($receiverid) ?>&&chat">
						<input type="text" name="txtmessage" class="input-block-level search-query input" Placeholder="Type message . . ." required>
						<input type="hidden" name="txtsender" value="<?php echo($senderid) ?>">
						<input type="hidden" name="txtreceiver" value="<?php echo($receiverid) ?>">
						<input type="hidden" name="txtmsgid" value="<?php echo($messageidins) ?>">
						<button type="submit" name="btn-send"><i class="fas fa-paper-plane"></i></button>
					</form>
				</div>
			
				<div class="message-main">

					<?php 

					$selectc = "SELECT *
					FROM message m, messagereply mr
					WHERE CASE

					WHEN m.sender1 = '$senderid'
					THEN m.sender2 = '$receiverid'

					WHEN m.sender2 = '$senderid'
					THEN m.sender1= '$receiverid'
					END 

					AND
					m.MessageID = mr.MessageID

					ORDER BY m.MessageID DESC";

					$runc = mysqli_query($connect, $selectc);	
					$countc = mysqli_num_rows($runc);

						for ($i=0;$i<$countc;$i++)
						{

							$rowc		 = mysqli_fetch_array($runc);
							$message     = $rowc['Message'];			
							$userid      = $rowc['Sender'];
			                $username = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $userid, 'CustomerName');
			                $userm    = substr($username,0,5);
							$date     = $rowc['SendDate'];
							$time     = $rowc['SendTime'];
							$messageidins = $rowc['MessageID'];

							echo "<p class='message'>$userm
										<span class='text'> $message </span>
										<span class='date'>  $date | $time 	</span>
								</p><br>";

						}		

					 ?>
					
				</div>


				

			<?php } 
			else if(isset($_GET['chatadmin'])) 
			{ ?>

			<div class="msg-top"><p>ShopH</p></div>
			<?php $customerid = $_GET['customerid']; ?>
			<div class="msg-bottom">	
					<form method="POST" action="message_inbox.php?customerid=<?php echo($customerid) ?>&&chatadmin">
						<input type="text" name="txtmessage" class="input-block-level search-query input" Placeholder="Type message . . ." required>
						<input type="hidden" name="txtsender" value="<?php echo($customerid) ?>">
						<button type="submit" name="btn-send-to-admin"><i class="fas fa-paper-plane"></i></button>
					</form>
				</div>
			
				<div class="message-main">

					<?php 

					$customerid = $_GET['customerid'];
					$selectc = "SELECT * FROM adminmessage 
								WHERE CustomerID = '$customerid'
					           ";

					$runc = mysqli_query($connect, $selectc);	
					$countc = mysqli_num_rows($runc);

						for ($i=0;$i<$countc;$i++)
						{

							$rowc		 = mysqli_fetch_array($runc);
							$message     = $rowc['Message'];			

							$userid      = $rowc['Sender'];

							if ($userid == 'Staff') 
							{
								$username = 'Staff';
							}

							else
							{
								$username = ATTRIBUTE_EXTRACTOR('customer', 'CustomerID', $userid, 'CustomerName');
							}
			 
			                $userm    = substr($username,0,5);
							$date     = $rowc['Date'];
							$time     = $rowc['Time'];

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


			

			
		<?php include('footer.php'); ?>

		
    </body>
</html>

		  
	</script>