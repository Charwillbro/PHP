<?php
	
require_once('exception_handlers.php'); 

//	This file contains the PHP coding to connect to the database.    
//	Include this file in any page that needs to access the database.  
//	Use the PHP include command before doing any database accesses

$hostname = "localhost";	//the name of the server where the database is located.  Usually localhost
$username = "root";			//the username on the database.  Usually listed on the cPanel listing of databases
$password = "admin";				//the password of the account or database.  Set a seperate password for the database.  On the cPanel listing of databases
$database = "wdv341";				//the name of the database.  Usually the same as the username.  Located on the cPanel listing of databases

//Builds the connection object called $connection and selects the desired database.
//You will need to use the $connect variable in the mysqli_query() commands whenever you run a query against the database.
try 
{
	$connection = new mysqli($hostname, $username, $password, $database);
	if ($connection->connect_error) 
	{
		throw new Exception("Connection to database failed!");
	}
}
catch(Exception $e)
{
	set_connection_exception_handler($connection,$e);
	die();	
}
?>