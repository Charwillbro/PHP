<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 12/10/2018
 * Time: 4:10 PM
 */
try {
    include 'connection.php';    //connects to the database

    if (isset($_GET['cur_id'])) {

        $coinToDelete = $_GET['cur_id']; //pull ID from get variable

    } else {

        header('Location: myCollection.php'); //basically a php redirect
    }


    $stmt = $conn->prepare("DELETE FROM currency_database WHERE cur_id =:coinToDelete");
    $stmt->bindParam(":coinToDelete", $coinToDelete);
    $stmt->execute();
    header('Location: myCollection.php'); //basically a php redirect
} catch (PDOException $e) {
    echo "<h1> There has been an Error. Please Try Again </h1>";
} catch (Exception $e) {
    //something else broke
}
?>