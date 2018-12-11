<?php
	session_start();
	
	//this affects the content of the $_SESSION variable(s)
	$_SESSION['validUser'] = "";
	session_unset();


	session_destroy();		//destroys the current session and all related session info


	header("index.html");		//redirects the sign on page or home page

?>