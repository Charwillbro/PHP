<?php
session_start();
include "connection.php";
$cur_user = "";
$cur_password = "";
$minUsernameLength = 5;
$minPasswordLength = 6;

//define variable
$username_errMsg = "";
$password_errMsg = "";
$login_Message = "";

$valid_form = false;

if (isset($_POST['cur_submit'])) {
    //process form data

    include 'coinValidation.php';    //get validation functions

    $cur_user = $_POST['cur_user'];
    $cur_password = $_POST['cur_password'];

    $valid_form = true;        //set validation flag assume all fields are valid

    if (empty($cur_user)) {
        $valid_form = false;
        $username_errMsg = "Username can not be left blank.";
    }

    if (empty($cur_password)) {
        $valid_form = false;
        $password_errMsg = "Password can not be left blank.";
    }


    if ($valid_form) {
//Form is good

        include "connection.php";

        try {
            $stmt = $conn->prepare("SELECT user_password,user_role,user_id,user_username FROM user_coin_database WHERE user_username = '$cur_user'");

            $stmt->execute();
        } catch (PDOException $e) {
            echo "<h1> There has been an Error. Please Try Again </h1>";
            echo $e;
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['user_password'] == $cur_password) {
//            echo("You are logged in!");
            $_SESSION['validUser'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_username'] = $row['user_username'];
            $_SESSION['user_role'] = $row['user_role'];
            $login_Message = "You are logged in!";
        } else {
//            echo("Your Credentials are incorrect.");
            $login_Message = "Your Credentials are incorrect.";
        }


    }


} else if (isset($_POST['cur_addUser'])) {
    //process form data

    include 'coinValidation.php';    //get validation functions

    $cur_user = $_POST['cur_user'];
    $cur_password = $_POST['cur_password'];

    $valid_form = true;        //set validation flag assume all fields are valid

    if (strlen($cur_user) < $minUsernameLength) {
        $valid_form = false;
        $username_errMsg = "Username must be at least " . $minUsernameLength . " characters long.";
    }

    if (strlen($cur_password) < $minPasswordLength) {
        $valid_form = false;
        $password_errMsg = "Username must be at least " . $minPasswordLength . " characters long.";
    }

    if (preg_match("/[A-Z]/", $cur_password) == 0) {
        $valid_form = false;
        $password_errMsg = " Password must have at least one Uppercase letter.";
    }

    if (preg_match("/[0-9]/", $cur_password) == 0) {
        $valid_form = false;
        $password_errMsg = " Password must have at least one Number.";
    }
    if ($valid_form) {
        $checkUser = $conn->prepare("SELECT user_username FROM user_coin_database WHERE user_username = '$cur_user'");
        // $checkUser = $conn ->bindParam(':cur_user', $cur_user);
        $checkUser->execute();
        if ($checkUser->rowCount() > 0) {
            //  echo "exists! cannot insert";
            $username_errMsg .= " Username Exists, Please try another username.";
            $valid_form = false;
        }

    }
    if ($valid_form) {
//Form is good


//prepared statements
        $sql = "INSERT INTO user_coin_database (";
        $sql .= "user_password, ";
        $sql .= "user_username ";


// below are prepared statement placeholders
        $sql .= ") VALUES (";
        $sql .= ":curPassword, ";
        $sql .= ":curUser ";
        $sql .= ")";


        try {
            $stmt = $conn->prepare($sql); //always prepare the statement

            $stmt->bindParam(":curPassword", $cur_password);
            $stmt->bindParam(":curUser", $cur_user);

            $stmt->execute(); // finally, execute the statement
            //  echo "<h1>Your record has been successfully added to the database.</h1>";
        } catch (PDOException $e) {

            //  echo "<h1>Something went wrong</h1>";
            //  echo $e;
        }
    }
}//if submitted//if submitted
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Charwillbro@gmail.com 12/5/2018-->
    <meta charset="UTF-8">
    <meta name="description"
          content="This page allows users to log in or create a new account so they can have their own private database of coins.">
    <meta name="keywords" content="contact, email, name, message, subject">
    <meta name="author" content="Charles Broderick">
    <link href="images/favicon.ico" rel="icon" type="image/x-icon"/>
    <link href="coinStylesheet.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Add Coins</title>
    <style>
        [id^="error"] {
            color: red;
        }

        #form1 label { /* This aligns the form fields*/
            display: inline-block;
            width: 110px;
            text-align: right;
        }

        #form1 { /* This aligns the form fields*/
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
    <script src="helperFunctions.js"></script>

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
        <a class="active" href="login.php">Login</a>
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
    <div class="row">
        <div class="main">

            <h2>Welcome Back to Mostly Common Cents </h2>
            <h3>Please log in to view the best collections!</h3>

            <?php
            if ($valid_form) {
                echo("<h1>" . $login_Message . "</h1><br>");
//                echo("<h1> User ID:" . $_SESSION['user_id'] . "</h1><br>");
//                echo("<h1> Username:" . $_SESSION['user_username'] . "</h1><br>");
//                echo("<h1> Role Clearance: " . $_SESSION['user_role'] . "</h1><br>");
            }
            if (!isset($_SESSION['validUser'])) {
                ?>
                <article>
                    <form id="form1" name="form1" method="post" enctype="multipart/form-data"
                          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                          onsubmit=" return validateMyForm()">
                        <fieldset>
                            <legend>LogIn</legend>

                            <p>
                                <label for="cur_user">Username: </label>
                                <input type="text" name="cur_user" id="cur_user" value="<?php echo $cur_user; ?>">
                                <span id="errorYear"><?php echo $username_errMsg; ?></span>
                            </p>
                            <div id="kitten">
                                <label for="keyboardType">Enter your favorite keyboard type</label>
                                <input type="text" name="keyboardType" id="keyboardType"/>
                            </div>
                            <div id="midName">
                                <label for="middleName">Enter your Middle Name</label>
                                <input type="text" name="middleName" id="middleName"/>
                            </div>
                            <p>
                                <label for="cur_password">Password </label>
                                <input type="text" name="cur_password" id="cur_password"
                                       value="<?php echo $cur_password; ?>">
                                <span id="errorComments"> <?php echo $password_errMsg; ?></span>
                            </p>
                            <p>
                                <input type="submit" name="cur_submit" id="cur_submit" value="Submit">

                                <input type="reset" name="resetForm" id="resetForm" value="Reset" onClick="resetForm()">
                            </p>
                        </fieldset>
                        <fieldset>
                            <legend>New To Mostly Common Cents?</legend>
                            <h3></h3>
                            <p>Enter your desired username and password then click the button below to sign up!</p>
                            <input type="submit" name="cur_addUser" id="cur_addUser" value="Add New User">
                        </fieldset>
                    </form>
                </article>

                <?php
            } else {
                ?>
                <h3>Hello, <?php echo $_SESSION['user_username'] ?>. You are already logged in. </h3>
                <h3>If you are not <?php echo $_SESSION['user_username'] ?>, please <a href="logoutUser.php">Logout
                        Here</a>. </h3>
                <?php
            }
            ?>
        </div>
        <div class="side">
            <h2>FAQ</h2>
            <h5>What is a coin?</h5>
            <input type="button" name="logout" id="logout" value="Logout" onClick="logoutUser()">

            <p> A coin is a form of currency that normally has a metallic composition.</p>
            <div class="adminUser">

            </div>

        </div>
    </div>

    <p></p>
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