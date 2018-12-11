<?php
session_start();
include "connection.php";
if (isset($_GET['cur_id'])) {
    $updateRecID = $_GET['cur_id'];    //Record Id to be updated
    $_SESSION['updateID'] = $_GET['cur_id'];
} else {
    $updateRecID = $_SESSION['updateID'];
}
//echo $updateRecID;

try {
    $stmt = $conn->prepare("SELECT * FROM currency_database WHERE cur_id ='$updateRecID'");

    $stmt->execute();
} catch (PDOException $e) {
    //echo $e;
    // echo "<h1> There has been an Error. Please Try Again </h1>";
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$cur_faceValue = $row['cur_facevalue'];    //define variable
$cur_year = $row['cur_year'];
$cur_denomination = $row['cur_denomination'];
$cur_mint = $row['cur_mint'];
$cur_comments = $row['cur_comments'];
$cur_retailValue = $row['cur_retailvalue'];
$cur_condition = $row['cur_condition'];
$cur_isPrivate = '';
$cur_inFile = $row['cur_imagefront'];
$cur_inFileBack = $row['cur_imagefront'];
$user_id = $row['cur_ownerid'];
$user_username = $row['cur_username'];


$faceValue_errMsg = "";    //define variable
$year_errMsg = "";
$denomination_errMsg = "";
$mint_errMsg = "";
$comments_errMsg = "";
$condition_errMsg = "";
$retailValue_errMsg = "";
$inFile_errMsg = "";
$inFileBack_errMsg = "";

$valid_form = false;


// THINGS TO DO
//
// FINISH VALIDATION
// STYLE PAGE


if (isset($_POST['cur_submit'])) {
    //process form data

    include 'coinValidation.php';    //get validation functions

    $cur_faceValue = getFaceValue();
    $cur_year = $_POST['cur_year'];
    $cur_denomination = $_POST['cur_denomination'];
    $cur_mint = $_POST['cur_mint'];
    $cur_comments = $_POST['cur_comments'];
    $cur_retailValue = $_POST['cur_retailValue'];
    $cur_condition = $_POST['cur_condition'];
    $cur_isPrivate = $_POST['cur_isPrivate'];
    $cur_inFile = $_FILES['cur_inFile'];
    $cur_inFileBack = $_FILES['cur_inFileBack'];
    $user_id = $_SESSION['user_id'];
    $user_username = $_SESSION['user_username'];

    $valid_form = true;        //set validation flag assume all fields are valid

    if ($_FILES['cur_inFile']['size'] != 0) { //if the image file value has not changes from what was returned from the database, do not change it else use new photo
        //  echo("image is empty");
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["cur_inFile"]["name"]); //concatenate the target directory with the filename
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["cur_inFile"]["tmp_name"]);
        if ($check !== false) {
            //     echo "File is an image - " . $check["mime"] . ".";
            //     echo $target_file;
            $uploadOk = 1;
        } else {
            //  echo "File is not an image. Please try again.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
            $inFile_errMsg = "Sorry, there was an error uploading your file.";
            $valid_form = false;
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["cur_inFile"]["tmp_name"], $target_file)) { //actually moves the file
                //     echo "The file " . basename($_FILES["cur_inFile"]["name"]) . " has been uploaded.";
            } else {
                // echo "Sorry, there was an error uploading your file.";
                $inFile_errMsg = "Sorry, there was an error uploading your file.";

                $valid_form = false;
            }
        }
    } else {
        $target_file = $row['cur_imagefront'];
        // echo $target_file;
    }

//    image 2 'back of coin'
    if ($_FILES['cur_inFileBack']['size'] != 0) {
        $target_fileBack = $target_dir . basename($_FILES["cur_inFileBack"]["name"]); //concatenate the target directory with the filename
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["cur_inFileBack"]["tmp_name"]);
        if ($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            //  echo $target_file;
            $uploadOk = 1;
        } else {
            //   echo "File is not an image. Please try again.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
            $inFileBack_errMsg = "Sorry, there was an error uploading your file.";
            $valid_form = false;
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["cur_inFileBack"]["tmp_name"], $target_fileBack)) { //actually moves the file
                //  echo "The file " . basename($_FILES["cur_inFileBack"]["name"]) . " has been uploaded.";
            } else {
                // echo "Sorry, there was an error uploading your file.";
                $inFileBack_errMsg = "Sorry, there was an error uploading your file.";

                $valid_form = false;
            }
        }
    } else {
        $target_fileBack = $row['cur_imageback'];
    }
    if (!validateCurValue($cur_faceValue)) {
        $valid_form = false;
        $value_errMsg = "Please enter a value for the currency";
    }

    if (!validateCurYear($cur_year)) {
        $valid_form = false;
        $year_errMsg = "Year must be numeric and greater than 1770 and no greater than the current year.";
    }

    if (!validateCurDenomination($cur_denomination)) {
        $valid_form = false;
        $denomination_errMsg = "Please select a denomination";
    }
    if (empty($cur_comments)) {
        $cur_comments = "No additional comments.";
    }

    if ($valid_form) {
//Form is good


//prepared statements
        $sql = "UPDATE currency_database SET ";
        $sql .= "cur_denomination='$cur_denomination', ";
        $sql .= "cur_facevalue='$cur_faceValue', ";
        $sql .= "cur_mint='$cur_mint', ";
        $sql .= "cur_year='$cur_year', ";
        $sql .= "cur_condition='$cur_condition', ";
        $sql .= "cur_comments='$cur_comments', ";
        //$sql .= "cur_isprivate='$cur_isPrivate', ";
        $sql .= "cur_imagefront='$target_file', ";
        $sql .= "cur_imageback='$target_fileBack', ";
        $sql .= "cur_retailvalue='$cur_retailValue', ";
        $sql .= "cur_ownerid='$user_id', ";
        $sql .= "cur_username='$user_username' ";
        $sql .= "WHERE cur_id='$updateRecID'";


        try {
            $stmt = $conn->prepare($sql); //always prepare the statement
            // $stmt->debugDumpParams(); //view the pdo statement for debugging
            $stmt->execute(); // finally, execute the statement
            // echo "<h1>Your record has been successfully added to the database.</h1>";
        } catch (PDOException $e) {
            //  echo "<h1>Something went wrong</h1>";
            //  echo $e;
        }
    }
}//if submitted
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Charwillbro@gmail.com 12/5/2018-->
    <meta charset="UTF-8">
    <meta name="description"
          content="This page allows a user or an admin with the proper credentials to edit the coins in the database">
    <meta name="keywords" content="contact, email, name, message, subject">
    <meta name="author" content="Charles Broderick">
    <link href="images/favicon.ico" rel="icon" type="image/x-icon"/>
    <link href="coinStylesheet.css" rel="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="helperFunctions.js"></script>
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
            <h1>Add New Coins to the Database</h1>
            <h2>Enter the important coin information to the database.</h2>

            <?php
            if ($valid_form) {
                ?>

                <h2>You have successfully updated the coin!</h2>
                <?php
            }

            if (isset($_SESSION['validUser'])) {

                if ($_SESSION['validUser'] == true) {

                    // echo("<p> User ID:" . $_SESSION['user_id'] . "</p><br>");
                    // echo("<p> Username:" . $_SESSION['user_username'] . "</p><br>");
                    // echo("<p> Role Clearance: " . $_SESSION['user_role'] . "</p><br>");
                    ?>

                    <article>
                        <form id="form1" name="form1" method="post" enctype="multipart/form-data"
                              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                              onsubmit=" return validateMyForm()">
                            <fieldset>
                                <legend>Enter important information here.</legend>

                                <p> Coin Denomination: <span
                                            id="errorColor"><?php echo $denomination_errMsg; ?></span></p>
                                <p>
                                    <label for="penny">Penny</label>
                                    <input type="radio" name="cur_denomination" id="penny" value="Penny"
                                        <?php if ($cur_denomination == "Penny") {
                                            echo "checked";
                                        } ?>>
                                    <br>
                                    <label for="nickel">Nickel</label>
                                    <input type="radio" name="cur_denomination" id="nickel" value="Nickel"
                                        <?php if ($cur_denomination == "Nickel") {
                                            echo "checked";
                                        } ?>>
                                    <br>
                                    <label for="dime">Dime</label>
                                    <input type="radio" name="cur_denomination" id="dime" value="Dime"
                                        <?php if ($cur_denomination == "Dime") {
                                            echo "checked";
                                        } ?>>
                                    <br>
                                    <label for="quarter">Quarter</label>
                                    <input type="radio" name="cur_denomination" id="quarter" value="Quarter"
                                        <?php if ($cur_denomination == "Quarter") {
                                            echo "checked";
                                        } ?>>
                                    <br>
                                    <label for="half_Dollar">Half-Dollar</label>
                                    <input type="radio" name="cur_denomination" id="half_Dollar" value="Half-Dollar"
                                        <?php if ($cur_denomination == "Half-Dollar") {
                                            echo "checked";
                                        } ?>>
                                    <br>
                                    <label for="dollar">Dollar Coin</label>
                                    <input type="radio" name="cur_denomination" id="dollar" value="Dollar"
                                        <?php if ($cur_denomination == "Dollar") {
                                            echo "checked";
                                        } ?>>
                                    <br>
                                </p>

                                <p>
                                    <label for="cur_year">Year: </label>
                                    <input type="text" name="cur_year" id="cur_year"
                                           value="<?php echo $cur_year; ?>">
                                    <span id="errorYear"><?php echo $year_errMsg; ?></span>
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
                                    <label for="cur_mint">Mint Letter </label>
                                    <input type="text" name="cur_mint" id="cur_mint"
                                           value="<?php echo $cur_mint; ?>">
                                    <span id="errorComments"> <?php echo $mint_errMsg; ?></span>
                                </p>
                                <p>
                                    <label for="cur_condition">Condition Rating </label>
                                    <input type="text" name="cur_condition" id="cur_condition"
                                           value="<?php echo $cur_condition; ?>">
                                    <span id="errorComments"> <?php echo $condition_errMsg; ?></span>
                                </p>
                                <p>
                                    <label for="cur_retailValue">Retail Value </label>
                                    <input type="text" name="cur_retailValue" id="cur_retailValue"
                                           value="<?php echo $cur_retailValue; ?>">
                                    <span id="errorComments"> <?php echo $retailValue_errMsg; ?></span>
                                </p>

                                <p>
                                    <label for="cur_comments">Comments </label>
                                    <input type="text" name="cur_comments" id="cur_comments"
                                           value="<?php echo $cur_comments; ?>">
                                    <span id="errorComments"> <?php echo $comments_errMsg; ?></span>
                                </p>
                                <!--            Does the user want their coins publicly displayed -->

                                <fieldset>
                                    <legend>Add Images of the Coin</legend>

                                    <p>
                                        <label for="cur_inFile">Coin Front</label>
                                        <input type="file" name="cur_inFile" id="cur_inFile"
                                               value="<?php// echo $cur_inFile; ?>">
                                        <?php //echo $cur_inFile; ?>
                                        <span id="errorFile"><?php echo $inFile_errMsg; ?></span>
                                    </p>
                                    <br>
                                    </p>
                                    <p>
                                        <label for="cur_inFileBack">Coin Back</label>
                                        <input type="file" name="cur_inFileBack" id="cur_inFileBack"
                                               value="<?php// echo $cur_inFileBack; ?>">
                                        <span id="errorFile"><?php echo $inFile_errMsg; ?></span>
                                    </p>

                                </fieldset>
                                <fieldset>
                                    <legend>Can others see this coin?</legend>
                                    <p>
                                        <label for="yesPrivate">Keep This Coin Private</label>
                                        <input type="radio" name="cur_isPrivate" id="yesPrivate" value="1"
                                            <?php if ($cur_denomination == "1") {
                                                echo "checked";
                                            } ?>>

                                        <label for="noPrivate">Make Coin Public</label>
                                        <input type="radio" name="cur_isPrivate" id="noPrivate" value="0"
                                               checked="checked"
                                            <?php if ($cur_denomination == "0") {
                                                echo "checked";
                                            } ?>>
                                    </p><br>
                                </fieldset>
                                <p>
                                    <input type="submit" name="cur_submit" id="cur_submit" value="Submit">
                                    <input type="reset" name="resetForm" id="resetForm" value="Reset"
                                           onClick="resetForm()">
                                </p>

                            </fieldset>
                        </form>
                    </article>

                    <?php
                }
            } else {
                ?>
                <h1>It looks like you are not logged in. </h1>
                <h2>Please <a href="login.php">Login</a> to add coins! </h2>
                <?php
            }


            ?>
        </div>


        <div class="side">
            <h2>FAQ</h2>
            <h5>What is a coin?</h5>
            <!--<div class="sidebarImage"><img src="images/storefront.jpg" alt="Image of store front"-->
            <!--title="Our store front"></div>-->
            <p> A coin is a form of currency that normally has a metallic composition.</p>

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