<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 10/25/2018
 * Time: 1:18 PM
 */
session_start();
include 'connection.php';            //connects to the database

try {
    $stmt = $conn->prepare("SELECT * FROM currency_database WHERE cur_isprivate = '0' ORDER BY cur_year ASC");

    $stmt->execute();
} catch (PDOException $e) {
    echo "<h1> There has been an Error. Please Try Again </h1>";
    echo "<h1>" . $e . "</h1>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Charwillbro@gmail.com 12/5/2018-->
    <meta charset="UTF-8">
    <meta name="description"
          content="This page displays all the coins in the database of Mostly Common Cents">
    <meta name="keywords" content="coin, rare coin, private, rare, collection">
    <meta name="author" content="Charles Broderick">
    <link href="images/favicon.ico" rel="icon" type="image/x-icon"/>
    <link href="coinStylesheet.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Coins</title>
    <style>

        article {
            max-width: 350px;
            padding: 2%;
        }

        .coinDisplay {

            display: flex;
            flex-wrap: wrap;
        }

        .sideBySide {
            display: flex;
            height: 150px;

        }

        .sideBySide > img {
            width: 47%;
            margin: 2px;
            padding: 5px;

        }

        .sideBySide > img:hover {
            transform: scale(3);
        }

        #artBody {
            text-align: left;
            margin-top: 8px;
        }

        #artBody > h3 {
            text-align: left;
            margin: 0;
            padding: 0;
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
        article > h3{
            margin: 0px;
            margin-top: 5px;
        }
        article > h2{
            margin: 0px;
            margin-top: 5px;
        }
    </style>
    <script src="helperFunctions.js"></script>
    <script>


    </script>
</head>

<body>

<div class="content">
    <!-- Header -->
    <a href="index.php">
        <div class="header">
            <span class="background-image" role="img"
                  aria-label="The header background image shows a stately looking building supported by marble columns."></span>
            <h1>Mostly Common Cents </h1>
            <p>A place to be proud of your coin collection!</p>
        </div>
    </a>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a class="active" href="viewCoinCollection.php">Gallery</a>
        <a class="validUser" href="coinDatabase.php">Add Coins</a>
        <?php
        if (isset($_SESSION['validUser'])) {
            if (($_SESSION['user_role'] == 1)) {
                echo(" <a class=\"validUser\" href=\"myCollection.php\">Admin</a>");
            } else {
                echo(" <a class=\"validUser\" href=\"myCollection.php\">My Collection</a>");
            }
        }else{
            echo(" <a class=\"validUser\" href=\"myCollection.php\">My Collection</a>");
        }
        ?>
        <a href="contactUs.php">Contact Us</a>
    </div>
    <!--End Navigation Bar-->
    <div class="row">
        <div class="main">

            <h2>Popular Coins</h2>
            <div class="coinDisplay">
                <?php

                if (!isset($_SESSION['validUser'])) {
                    echo("<h2>It looks like you are not logged in.</h2>");
                    echo("<h3>You may view the public collection as a guest, or <a href='login.php'>login</a> to view your private collection.</h3>");
                }
                $counter = 1;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $counter++;
                    $id = "'photofront" . $counter . "'";
                    $idBack = "photoback" . $counter;
                    echo(" <article>");

                    echo("   <h2><strong>" . $row['cur_year'] . " " . $row['cur_denomination'] . "</strong></h2>");
                    echo("   <h3> Submitted by: " . $row['cur_username'] . "</h3>");
                    echo("<div class=\"sideBySide\">");
                    echo("<img src=\"" . $row['cur_imagefront'] . "\">");
                    echo("<img src=\"" . $row['cur_imageback'] . " \">");
                    echo("</div><div id=\"artBody\">");
                    echo("   <h3>Mint:" . $row['cur_mint'] . "</h3>");
                    echo("   <h3>Sheldon Grading Scale:" . $row['cur_condition'] . "</h3>");
                    echo("   <h3>Estimated Retail Price: $" . $row['cur_retailvalue'] . "</h3>");
                    echo("   <h3>Additional Comments: " . $row['cur_comments'] . "</h3>");

                    echo("</div></article>");

                }
                ?>
            </div>
        </div>
        <div class="side">
            <h2>FAQ</h2>

            <h5>What is a coin?</h5>
            <!--<div class="sidebarImage"><img src="images/storefront.jpg" alt="Image of store front"-->
            <!--title="Our store front"></div>-->
            <p> A coin is a form of currency that normally has a metallic composition.</p>
            <!--<img id="imgtochange" onmouseover="doubleImage('imgtochange')" onmouseout="normalSize('imgtochange')" src="images/DimesFront001.jpg">-->
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