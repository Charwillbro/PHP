<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 9/20/2018
 * Time: 1:44 PM
 */
require "connection.php";

$event_name = $_POST['event_name']; //Remember the POST variable is an associative array. replace the index numbers with id names
$event_description = $_POST['event_description'];
$event_presenter = $_POST['event_presenter'];
$event_date = $_POST['event_date'];
$event_time = $_POST['event_time'];

// below are prepared statements.

$sql = "INSERT INTO wdv341_event (";
$sql .= "event_name, ";
$sql .= "event_description, ";
$sql .= "event_presenter, ";
$sql .= "event_date, ";
$sql .= "event_time "; //Last column does NOT have a comma after it.


// below are prepared statement placeholders
$sql .= ") VALUES (";
$sql .= ":eventName, ";
$sql .= ":eventDescription, ";
$sql .= ":event_presenter, ";
$sql .= ":event_date, ";
$sql .= ":event_time "; //Last column does NOT have a comma after it.
$sql .= ")";

try{
$stmt = $conn->prepare($sql); //always prepare the statement

$stmt ->bindParam(":eventName", $event_name); //bind the variables
$stmt ->bindParam(":eventDescription",$event_description);
$stmt ->bindParam(":event_presenter",$event_presenter);
$stmt ->bindParam(":event_date",$event_date);
$stmt ->bindParam(":event_time",$event_time);

$stmt ->execute(); // finally, execute the statement
    echo "<h1>Your record has been successfully added to the database.</h1>";
}
catch(PDOException $e){
    die();

}


?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Insert Events Form</title>
</head>

<body>
<h1>Inserting Data into a Database</h1>

<p>This page is called when the submit button is pressed on the form. <br> Thank you for your submission.</p>


</body>
</html>
