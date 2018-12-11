<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 12/6/2018
 * Time: 2:30 PM
 */
session_start();

//this affects the content of the $_SESSION variable(s)
$_SESSION['validUser'] = "";
session_unset();


session_destroy();        //destroys the current session and all related session info


header('Location: index.php');        //redirects the sign on page or home page
?>