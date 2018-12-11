<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 10/25/2018
 * Time: 1:18 PM
 */
session_start();
include 'connection.php';            //connects to the database
$cur_user = $_SESSION['user_id'];
try {

    if (($_SESSION['user_role'] == 1)) {
        $stmt = $conn->prepare("SELECT * FROM currency_database");
    } else {
        $stmt = $conn->prepare("SELECT * FROM currency_database WHERE cur_ownerid = '$cur_user' ");
    }
    $stmt->execute();
} catch (PDOException $e) {
    echo "<h1> There has been an Error. Please Try Again </h1>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Charwillbro@gmail.com 12/5/2018-->
    <meta charset="UTF-8">
    <meta name="description"
          content="This page displays all the coins in the collection of a single user, so long as they are logged in.">
    <meta name="keywords" content="coin, rare coin, private, rare, collection">
    <meta name="author" content="Charles Broderick">
    <link href="images/favicon.ico" rel="icon" type="image/x-icon"/>
    <link href="coinStylesheet.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Your Coins</title>
    <script>
        function showCoinCollection() {

            document.getElementById("coinDisplay").style.display = "flex";
            document.getElementById("updateCoins").style.display = "none";
        }

        function updateCoinCollection() {

            document.getElementById("coinDisplay").style.display = "none";
            document.getElementById("updateCoins").style.display = "flex";
        }

        function addCoinsToDatabase() {
            location.href = "coinDatabase.php";
        }
    </script>
    <style>

        #coinDisplay {

            display: flex;
            flex-wrap: wrap;
        }

        article {
            max-width: 300px;
            padding: 2%;
        }
        article > h3{
            margin: 0px;
            margin-top: 5px;
        }
        article > h2{
            margin: 0px;
           margin-top: 5px;
        }

        .sideBySide {
            display: flex;
            height: 150px;

        }

        .sideBySide > img {
            width: 47%;
            margin: 5px;
            padding: 5px;

        }

        .sideBySide > img:hover {
            transform: scale(3);
            width: 47%;
            margin: 5px;
            padding: 5px;

        }

        .editImages img:hover {

            transform: scale(3);

        }

        .editImages img {
            margin: 5px;
            padding: 0px;
            width: 60px;
            height: 60px;

        }

        .side {
            flex: 25%;

        }

        /* Main column */
        .main {
            flex: 75%;

        }

        .validUser {
        <?php
        if (!isset($_SESSION['validUser'])) {
            echo(" display: none;");

        }
        ?>
        }
    </style>
    <script src="helperFunctions.js"></script>
</head>

<body>

<div class="content">
    <!-- Header -->
    <a href="index.php">
        <div class="header">
            <span class="background-image" role="img"
                  aria-label="The header background image shows the back counter of a modern styled coffee shop, with an espresso machine and various small plants pictured."></span>
            <h1>Mostly Common Cents </h1>
            <p>A place to be proud of your mostly ordinary coin collection!</p>
        </div>
    </a>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="viewCoinCollection.php">Gallery</a>
        <a class="validUser" href="coinDatabase.php">Add Coins</a>
        <?php
        if (isset($_SESSION['validUser'])) {
            if (($_SESSION['user_role'] == 1)) {
                echo(" <a class=\"validUser active\" href=\"myCollection.php\">Admin</a>");
            } else {
                echo(" <a class=\"validUser active\" href=\"myCollection.php\">My Collection</a>");
            }
        } else {
            echo(" <a class=\"validUser active\" href=\"myCollection.php\">My Collection</a>");
        }
        ?>
        <a href="contactUs.php">Contact Us</a>
    </div>
    <!--End Navigation Bar-->
    <div class="row">
        <div class="main">

            <?php
            if (!isset($_SESSION['validUser'])) {
                echo("<h2>It looks like you are not logged in.</h2>");
                echo("<h3>You may view the public collection as a guest, or <a href='login.php'>login</a> to view your private collection.</h3>");
            }
            ?>
            <h2>Your Collection</h2>
            <div id="coinDisplay">

                <?php
                $counter = 1;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $counter++;
                    $id = "'photofront" . $counter . "'";
                    $idBack = "photoback" . $counter;
                    echo(" <article>");

                    echo("   <h2>" . $row['cur_year'] . " " . $row['cur_denomination'] . "</h2>");
                    echo("   <h3> Submitted by: " . $row['cur_username'] . "</h3>");
                    echo("<div class=\"sideBySide\">");
                    echo("<img src=\"" . $row['cur_imagefront'] . "\">");
                    echo("<img src=\"" . $row['cur_imageback'] . " \">");
                    echo("</div>");
                    echo("   <h3>Mint:" . $row['cur_mint'] . "</h3>");
                    echo("   <h3>Sheldon Grading Scale:" . $row['cur_condition'] . "</h3>");
                    echo("   <h3>Estimated Retail Price: $" . $row['cur_retailvalue'] . "</h3>");
                    echo("   <h3>Additional Comments: " . $row['cur_comments'] . "</h3>");

                    echo("</article>");

                }
                ?>
            </div>
            <div style="display: none" id="updateCoins"> <!-- hidden by default -->

                <table class="editImages" border='1'>
                    <tr>
                        <td>ID</td>
                        <td>Denom</td>
                        <td>Face Value</td>
                        <td>Mint</td>
                        <td>Year</td>
                        <td>Cond</td>
                        <td>Comments</td>
                        <td>Retail</td>
                        <td>Front</td>
                        <td>Back</td>

                        <td>UPDATE</td>
                        <td>DELETE</td>
                        <?php
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['cur_id'] . "</td>";
                            //$_SESSION['cur_id'] = $row['cur_id'];
                            echo "<td>" . $row['cur_denomination'] . "</td>";
                            // $_SESSION['cur_denomination'] = $row['cur_denomination'];
                            echo "<td>" . $row['cur_facevalue'] . "</td>";
                            // $_SESSION['cur_facevalue'] = $row['cur_facevalue'];
                            echo "<td>" . $row['cur_mint'] . "</td>";
                            // $_SESSION['cur_mint'] = $row['cur_mint'];
                            echo "<td>" . $row['cur_year'] . "</td>";
                            /// $_SESSION['cur_year'] = $row['cur_year'];
                            echo "<td>" . $row['cur_condition'] . "</td>";
                            //  $_SESSION['cur_condition'] = $row['cur_condition'];
                            echo "<td>" . $row['cur_comments'] . "</td>";
                            //  $_SESSION['cur_comments'] = $row['cur_comments'];
                            echo "<td>" . $row['cur_retailvalue'] . "</td>";
                            //  $_SESSION['cur_retailvalue'] = $row['cur_retailvalue'];
                            echo "<td><img src=\"" . $row['cur_imagefront'] . "\"></td>";
                            // $_SESSION['cur_imagefront'] = $row['cur_imagefront'];
                            echo "<td><img src=\"" . $row['cur_imageback'] . "\"></td>";
                            // $_SESSION['cur_imageback'] = $row['cur_imageback'];
                            echo "<td><a href='updateCoin.php?cur_id=" . $row['cur_id'] . "'>Update</a></td>"; //this has a get parameter that is sent to the linked page ?
                            echo "<td><a href='deleteCoins.php?cur_id=" . $row['cur_id'] . "'>Delete</a></td>";
                            echo "</tr>";
                        }
                        ?>
                </table>


            </div>
        </div>
        <div class="side">
            <h2>FAQ</h2>

            <h4>Welcome <?php echo $_SESSION['user_username'] ?>.</h4>
            <p> This is your dashboard where you can add new coins, edit your current collection, or remove coins.</p>
            <button id="showCollection" name="showCollection" onclick="showCoinCollection()" value="Show Collection">
                Show Collection
            </button>
            <br>
            <button id="updateCollection" name="updateCollection" onclick="updateCoinCollection()"
                    value="Update Collection">Update Collection
            </button>
            <br>

            <button id="addCollection" name="addCollection" onclick="addCoinsToDatabase()" value="Add Coins">Add Coins
            </button>
        </div>
    </div>


    <!-- Footer -->
    <div style="font-size: small" class="footer">
        <div class="a">
            <p>
                <strong>Mostly Common Cents</strong> <br>
                198 Rare Coin Street<br>
                Currency City, District of Colombia<br>
                Phone: 555-843-2646 or 555-THE-COIN

            </p>
        </div>
        <div class="b">
            <p>
                Copyright Charles Broderick <!-- Dynamic copyright date -->
                <script>document.write(copyrightDate)</script>
                Made For Educational Purposes
            </p>
        </div>

        <div class="c" style="font-size: small">
            <a href="https://www.saintpaulchamber.com/"><img style="height: 100px" src="images/coinOlympics.png"
                                                             alt="Coin Collectors Olympic Committee logo"
                                                             title="Coin Collectors Olympic Committee logo"></a><br>
            <h6>Proud member of the Coin Collecting Olympic Committee</h6>
        </div>

    </div>
    <!-- Footer -->
</div>

</body>
</html>