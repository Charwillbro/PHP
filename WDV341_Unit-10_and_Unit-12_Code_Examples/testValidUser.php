<?php
	session_start();
	
	if( !isset($_SESSION['validUser']) ) {
    header('Location: https://www.dmacc.edu');		//PHP redirect for invalid users
}




?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<h1>WDV341 Intro PHP </h1>
<h2>Unit-12 Session Variables</h2>
<h3>Protected Page Example!</h3>
<p>Congratulations you can see this page and its content.</p>
</body>
</html>