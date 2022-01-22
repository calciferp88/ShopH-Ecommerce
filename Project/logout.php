<?php
	session_start();
	//session_destroy();

	session_destroy();
	

	echo "
	<script>

		alert ('Logged out');
		window.location.assign('login.php');

	 </script>";
?>