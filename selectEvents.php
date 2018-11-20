<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 10/23/2018
 * Time: 2:03 PM
 */

	include 'connection.php';			//connects to the database

try {
    $stmt = $conn->prepare("SELECT event_id,event_name,event_description FROM wdv341_event");

    $stmt->execute();
}catch (PDOException $e){
    echo "<h1> There has been an Error. Please Try Again </h1>";
}
?>
<h1>Select Events</h1>
<table border='1'>
	<tr>
		<td>ID</td>
		<td>Name</td>
		<td>Description</td>
		<td>UPDATE</td>
		<td>DELETE</td>
<?php
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr>";
			echo "<td>" . $row['event_id'] . "</td>";
			echo "<td>" . $row['event_name'] . "</td>";
			echo "<td>" . $row['event_description'] . "</td>";
			echo "<td><a href='updateEvent.php?eventID=" . $row['event_id'] . "'>Update</a></td>"; //this has a get parameter that is sent to the linked page ?
			echo "<td><a href='deleteEvent.php?eventID=" . $row['event_id'] . "'>Delete</a></td>";
		echo "</tr>";
	}
?>
</table>