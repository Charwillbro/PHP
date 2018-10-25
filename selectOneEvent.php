<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 10/23/2018
 * Time: 1:29 PM
 */
?>
<?php

include 'connection.php';			//connects to the database

$stmt = $conn->prepare("SELECT event_id,event_name,event_description FROM wdv341_event WHERE event_id = 1");
$stmt->execute();
?>
<table border='1'>
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Description</td>
        <td>UPDATE</td>
        <td>DELETE</td>
        <?php

            echo "<tr>";
            echo "<td>" . $row['event_id'] . "</td>";
            echo "<td>" . $row['event_name'] . "</td>";
            echo "<td>" . $row['event_description'] . "</td>";
            echo "<td><a href='updateEvent.php?eventID=" . $row['event_id'] . "'>Update</a></td>";
            echo "<td><a href='deleteEvent.php?eventID=" . $row['event_id'] . "'>Delete</a></td>";
            echo "</tr>";
        ?>
</table>
