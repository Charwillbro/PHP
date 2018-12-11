<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 9/18/2018
 * Time: 1:27 PM
 */


require_once('exception_handlers.php');// exception handling functions
$serverName = "localhost";
$username = "root";
$password = "";
$database = "wdv341";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $username, $password); //Creates a new PDO object to connect to a db
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e)
{
   // echo "Connection failed: " . $e->getMessage();
    set_connection_exception_handler($conn,$e);
    die();
}
?>