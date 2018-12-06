<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 10/25/2018
 * Time: 1:18 PM
 */

include 'connection.php';            //connects to the database

try {
    $stmt = $conn->prepare("SELECT * FROM currency_Database WHERE cur_isprivate = '0'");

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
          content="This is a contact form. Anything entered in the form will be sent to the coffee house (my personal email.)The form also features a honeypot that can be used to see of a bot has filled out the fore and, if so, not send the form.">
    <meta name="keywords" content="contact, email, name, message, subject">
    <meta name="author" content="Charles Broderick">
    <!--    <link href="Images/favicon.ico" rel="icon" type="image/x-icon"/>-->
    <link href="coinStylesheet.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Coins</title>
    <style>

        .coinDisplay {

            display: flex;
            flex-wrap: wrap;
        }

        .coinDisplay > img {

            width: 50px;
            height: 50px;
        }

        article {
            max-width: 300px;
            padding: 3%;
        }


        .sideBySide {
            display: flex;
            height: 150px;

        }
        .sideBySide > img {
            display: block;
            object-fit: contain;
            max-width: 45%;
            /*height: 3;*/
            /*max-height: 45%;*/
            /*max-height: 150px;*/
        }
    </style>

</head>

<body>

<div class="content">
    <!-- Header -->
    <a href="index.html">
        <div class="header">
            <span class="background-image" role="img"
                  aria-label="The header background image shows the back counter of a modern styled coffee shop, with an espresso machine and various small plants pictured."></span>
            <h1>Mostly Common Cents </h1>
            <p>A place to be proud of your mostly ordinary coin collection!</p>
        </div>
    </a>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="index.html">Home</a>
        <a href="viewCoinCollection.php">About</a>
        <a class="active" href="viewCoinCollection.php">View Coins</a>
        <a href="coinDatabase.php">Add Coins</a>
        <a href="contactUs.html">Contact Us</a>
    </div>
    <!--End Navigation Bar-->
    <div class="row">
        <div class="main">

            <h2>Popular Coins</h2>
            <div class="coinDisplay">
                <?php

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo(" <article>");


                    echo("   <h3>" . $row['cur_year'] . " " . $row['cur_denomination'] . "</h3>");
                    echo("<div class=\"sideBySide\">");
                    echo("<img src=\"" . $row['cur_imagefront'] . " \">");
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
        </div>
        <div class="side">
            <h2>FAQ</h2>
<!--            <div class="sideBySide">-->
<!--                <img src="images/forInternetPosting/DimesFront001.jpg">-->
<!--                <img src="images/forInternetPosting/DimesBack001.jpg">-->
<!--            </div>-->
            <h5>What is a coin?</h5>
            <!--<div class="sidebarImage"><img src="images/storefront.jpg" alt="Image of store front"-->
            <!--title="Our store front"></div>-->
            <p> A coin is a form of currency that normally has a metallic composition.</p>

        </div>
    </div>


    <!-- Footer -->
    <div style="font-size: small" class="footer">
        <div class="a">

            <p></p>
        </div>
        <div class="b">
            <p>
                <strong>Not So Common Cents</strong> <br>
                198 Rare Coin Street<br>
                Currency City, District of Colombia<br>
                Phone: 555-843-2646 or 555-THE-COIN

            </p>
            <p>
                Copyright Charles Broderick <!-- Dynamic copyright date -->
                <script>document.write(copyrightDate)</script>
                Made For Educational Purposes
            </p>
        </div>

        <div class="c" style="font-size: small">
            <!--<a href="https://www.saintpaulchamber.com/"><img style="height: 100px" src="Images/chamberOfCommerce.png"-->
            <!--alt="Saint Paul Chamber of Commerce logo"-->
            <!--title="Saint Paul Chamber of Commerce logo"></a><br>-->
            <h6>Proud member of the Coin Collecting Olympic Committee</h6>
        </div>

    </div>
    <!-- Footer -->
</div>

</body>
</html>