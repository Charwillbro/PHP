<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 10/23/2018
 * Time: 1:29 PM
 */
?>
<?php

include 'connection.php';    //connects to the database

$indexVariable = 2;
//using the where statement in a select statement can filter the results
try {
    $stmt = $conn->prepare("SELECT event_id,event_name,event_description FROM wdv341_event WHERE event_id=:eventID");

//you must bind any place holders the first parameter is the placeholder and
// the second is a variable holding what you want to bind to the place holder

    $stmt->bindParam(':eventID', $indexVariable);

    $stmt->execute();
} catch (PDOException $e) {
    echo "<h1> There has been an Error. Please Try Again </h1>";
}
?>
<h1>Select One Event</h1>
<h3>The Select statement selects the row where the ID is '2'.</h3>
<h3>The result is displayed below.</h3>
<table border='1'>
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Description</td>
        <td>UPDATE</td>
        <td>DELETE</td>
        <?php
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<tr>";
        echo "<td>" . $row['event_id'] . "</td>";
        echo "<td>" . $row['event_name'] . "</td>";
        echo "<td>" . $row['event_description'] . "</td>";
        echo "<td><a href='updateEvent.php?eventID=" . $row['event_id'] . "'>Update</a></td>";
        echo "<td><a href='deleteEvent.php?eventID=" . $row['event_id'] . "'>Delete</a></td>";
        echo "</tr>";
        ?>
</table>
