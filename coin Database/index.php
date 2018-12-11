<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- All images were obtained free of copyright from pexels.com and were edited as needed by Charles Broderick-->
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="description"
          content="This is the homepage for Mostly Common Cents. A place for amateur coin collectors to show off their coin collections">
    <meta name="keywords" content="Coin, collection, collector">
    <meta name="author" content="Charles Broderick">
    <link href="images/favicon.ico" rel="icon" type="image/x-icon"/>
    <link href="coinStylesheet.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="helperFunctions.js"></script>

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
        <a class="active" href="index.php">Home</a>
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
        <a href="contactUs.php">Contact Us</a>
    </div>
    <!--End Navigation Bar-->

    <!-- The flexible grid (content) -->
    <div class="row">

        <div class="main">
            <h2>It's Time For Some Change!</h2>
            <p>For too long, to be considered a serious coin collector a person needed to have the
                <strong>rarest</strong> and <strong>most valuable</strong> coins.</p>
            <p>Some say you can't call your coins a collection unless there are foreign coins, bonus points if they are
                from a country that no longer exists.</p>
            <p>Mostly Common Cents is <strong>not</strong> for those people. We are for the casual coin collector.</p>

            <article>
                <h3>Is Mostly Common Cents For Me?</h3>
                <ul id="whyUs">

                    <li> Did you inherit a jar of change that your grandpa found in his old Studebaker? <strong>Join
                            us!</strong></li>
                    <br>
                    <li> Is your collection made up of coins you found abandoned in parking lots? <strong>Join
                            us!</strong></li>
                    <br>
                    <li> Is your oldest coin younger than Justin Beiber? <strong>Join us!</strong></li>
                    <br>
                    <li> When you say "I got this coin from a shipwreck!" Do you mean the Costa Concordia? <strong>Join
                            us!</strong></li>
                    <br>
                    <li> Do you have a diverse collection of many foreign currencies? <strong>Not Quite Our Style. Good
                            Day.</strong></li>
                    <br>
                </ul>
            </article>
            <p> Join us! Be proud of your coin collection!</p>

        </div>
        <div class="side">
            <h2>FAQ</h2>
            <h4>What is a coin?</h4>
            <p> A coin is a form of currency that normally has a metallic composition.</p>

            <h4>What Coins Will I Find Here?</h4>
            <p> We pride ourselves on only <em>moderately impressive</em> collections.
                As such we only accept U.S. Currency from year 1900 or newer.</p>

            <h4>Why can't I add my 1933 Double Eagle?</h4>
            <p> In accordance with our strict adherence to our policy of <em>moderate impressiveness</em> we only accept
                these denominations:</p>
            <ul>
                <li> Penny</li>
                <li> Nickel</li>
                <li> Dime</li>
                <li> Quarter</li>
                <li> Half-Dollar (Borderline Exotic)</li>
                <li> Dollar</li>
            </ul>
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
