<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Charwillbro@gmail.com 9/25/2018-->
    <meta charset="UTF-8">
    <meta name="description"
          content="This is a contact form. Anything entered in the form will be sent to the coffee house (my personal email.)The form also features a honeypot that can be used to see of a bot has filled out the fore and, if so, not send the form.">
    <meta name="keywords" content="contact, email, name, message, subject">
    <meta name="author" content="Charles Broderick">
    <link href="images/favicon.ico" rel="icon" type="image/x-icon"/>
    <link href="coinStylesheet.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="helperFunctions.js"></script>
    <title>Contact Us</title>

    <style>

        #contact_form label { /* This aligns the form fields*/
            display: inline-block;
            width: 110px;
            text-align: right;
        }

        #contact_form { /* This aligns the form fields*/
            text-align: left;
        }

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
            <h2>Contact Us</h2>

            <p>If you have any questions, comments, or concerns, please do not hesitate to contact us! We will contect
                you
                as soon as we are able! (usually 1-2 business days)

                <article style="width: 95%">
                    <h4>An Email is the Best Way to Reach Us!</h4>
                    <form id="contact_form" name="contact_form" method="post"
                          onsubmit=" return validateMyForm()" action="coinEmailHandler.php">
                        <fieldset>
                            <legend>Send Us an Email!</legend>
            <p style="font-style:italic; color: #1e2a36">Send us a message. We would love to hear from you!</p>

            <div>
                <label for="firstname">First Name: </label>
                <input id="firstname" name="firstname" type="text">
            </div>
            <div id="kitten">
                <label for="keyboardType">Enter your favorite keyboard type</label>
                <input type="text" name="keyboardType" id="keyboardType"/>
            </div>
            <div id="midName">
                <label for="middleName">Enter your Middle Name</label>
                <input type="text" name="middleName" id="middleName"/>
            </div>
            <div>
                <label for="lastname">Last Name: </label>
                <input id="lastname" name="lastname" type="text">
            </div>
            <br>
            <div>
                <label for="email">Email Address: </label>
                <input id="email" name="email" type="text" placeholder="YourEmail@address.com">
            </div>
            <br>
            <div>
                <label for="topic">Topic: </label>
                <select id="topic" name="topic">
                    <option value="Comment">Comment</option>
                    <option value="Question">Question</option>
                    <option value="Concern">Concern</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <br>
            <div>
                <label for="message">Message: </label>
                <textarea id="message" name="message" rows="5" cols="40"></textarea>
            </div>
            <br>
            <div>
                <input type="submit" id="submit" name="submit" value="Send Email">
                <input type="reset" id="reset" name="reset" value="Clear Form">
            </div>
            </fieldset>

            </form>
            </article>
            <br>
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


    <script>
        document.getElementById('kitten').style.display = "none"; //hide this field
        document.getElementById('midName').style.display = "none"; //hide this field
    </script>
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