<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 11/30/2018
 * Time: 4:48 PM
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description"
          content="This is a contact Us form handler. Anything entered in the form will be sent to my personal email.">
    <meta name="keywords" content="contact, email, name, message, subject">
    <meta name="author" content="Charles Broderick">
    <link href="images/favicon.ico" rel="icon" type="image/x-icon"/>
    <link href="coinStylesheet.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Contact Us</title>

    <style>
        .validUser {
        <?php
        if (!isset($_SESSION['validUser'])) {
            echo(" display: none;");

        }
        ?>
        }
    </style>
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
        <a href="viewCoinCollection.php">Gallery</a>
        <a class="validUser" href="coinDatabase.php">Add Coins</a>
        <?php
        if (isset($_SESSION['validUser'])) {
            if (($_SESSION['user_role'] == 1)) {
                echo(" <a class=\"validUser\" href=\"myCollection.php\">Admin</a>");
            } else {
                echo(" <a class=\"validUser\" href=\"myCollection.php\">My Collection</a>");
            }
        } else {
            echo(" <a class=\"validUser\" href=\"myCollection.php\">My Collection</a>");
        }
        ?>
        <a class="active" href="contactUs.php">Contact Us</a>
    </div>
    <!--End Navigation Bar-->
    <div class="row">

        <div class="main">
            <p></p>
            <article>
                <h2>Thank you for your interest!</h2>

                <p>You can expect a reply in 1-2 business days!</p>


                <?php

                //It will create a table and display one set of name value pairs per row
                $fName = "default Value";
                $lName = "default Value";
                $email = "default Value";
                $subject = "default Value";
                $message = "default Value";
                $confirmationMessage = "Your email was processed successfully. You may expect a reply in 1-2 business days. \n\nLive Long And Prosper,\nCharles W. Broderick \n\nThe Mostly Common Cents CEO";

                $fName = $_POST['firstname'];
                $lName = $_POST['lastname'];
                $email = $_POST['email'];
                $subject = $_POST['topic'];
                $message = $_POST['message'];

                echo "<p>The details of your message are below:</p>";
                echo "<p>From: ", $fName, " ", $lName, ", ", $email;
                echo "<p>Subject: ", $subject;
                echo "<p>Message: ", $message;


                $toEmail = "charwillbro@gmail.com";


                $subject = "Sent From Mostly Common Cents";

                $fromEmail = "charwillbro@charleswbroderick.com";


                $emailBody = "Sent From Contact Me page at Mostly Common Cents\n\n ";
                foreach ($_POST as $key => $value) {
                    $emailBody .= $key . "=" . $value . "\n";
                }

                $headers = "From: $fromEmail" . "\r\n";

                if (mail($toEmail, $subject, $emailBody, $headers)) {
                    echo("<p>Message successfully sent!</p>");
                } else {
                    echo("<p>Message delivery failed, please try again.</p><p>If this problem persists, please call us, or email us directly at coffeeHouseEmail@email.com</p>");

                }
                $headers = "From: $fromEmail" . "\r\n";
                if (mail($email, $subject, $confirmationMessage, $headers)) {
                    echo("<p>A Confirmation Email has been sent to you!</p>");
                } else {
                    echo("<p>Message delivery failed, please try again.</p><p>If this problem persists, please call us, or email us directly at coffeeHouseEmail@email.com</p>");

                }
                ?>
            </article>
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
le=1">