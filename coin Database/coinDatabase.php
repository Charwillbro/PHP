<?php
$cur_faceValue = "";    //define variable
$cur_year = "";
$cur_denomination = "";
$cur_mint = "";
$cur_comments = "";
$cur_retailValue = "";
$cur_condition = "";
$cur_isPrivate = "";
//$cur_imageName = "";
$cur_inFile = " ";
//$cur_imageNameBack = "";
$cur_inFileBack = " ";

$faceValue_errMsg = "";    //define variable
$year_errMsg = "";
$denomination_errMsg = "";
$mint_errMsg = "";
$comments_errMsg = "";
$condition_errMsg = "";
$retailValue_errMsg = "";
//$name_errMsg = "";
$inFile_errMsg = "";
//$nameBack_errMsg = "";
$inFileBack_errMsg = "";

$valid_form = false;


// THINGS TO DO
//
// FINISH VALIDATION
// STYLE PAGE
// add user ID from the session variable when user adds a coin
//


if (isset($_POST['cur_submit'])) {
    //process form data

    include 'coinValidation.php';    //get validation functions

    // $cur_faceValue = $_POST['cur_faceValue'];
    $cur_faceValue = getFaceValue();
    $cur_year = $_POST['cur_year'];
    $cur_denomination = $_POST['cur_denomination'];
    $cur_mint = $_POST['cur_mint'];
    $cur_comments = $_POST['cur_comments'];
    $cur_retailValue = $_POST['cur_retailValue'];
    $cur_condition = $_POST['cur_condition'];
    $cur_isPrivate = $_POST['cur_isPrivate'];
   // $cur_imageName = $_POST['cur_imageName'];
    $cur_inFile = $_FILES['cur_inFile'];
   // $cur_imageNameBack = $_POST['cur_imageNameBack'];
    $cur_inFileBack = $_FILES['cur_inFileBack'];

    if (isset($_POST['cur_denomination'])) {
        $cur_denomination = $_POST['cur_denomination'];
    }

    $valid_form = true;        //set validation flag assume all fields are valid


    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["cur_inFile"]["name"]); //concatenate the target directory with the filename
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["cur_inFile"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        echo $target_file;
        $uploadOk = 1;
    } else {
        echo "File is not an image. Please try again.";
        $uploadOk = 0;
    }

//    if (empty($cur_imageName)) {//validate name - Cannot be empty
//        $name_errMsg = "You must enter a name";
//        $valid_form = false;
//    }

    if ($uploadOk == 0) {
        //echo "Sorry, your file was not uploaded.";
        $inFile_errMsg = "Sorry, there was an error uploading your file.";
        $valid_form = false;
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["cur_inFile"]["tmp_name"], $target_file)) { //actually moves the file
            echo "The file " . basename($_FILES["cur_inFile"]["name"]) . " has been uploaded.";
        } else {
            // echo "Sorry, there was an error uploading your file.";
            $inFile_errMsg = "Sorry, there was an error uploading your file.";

            $valid_form = false;
        }
    }

//    image 2 'back of coin'
    $target_fileBack = $target_dir . basename($_FILES["cur_inFileBack"]["name"]); //concatenate the target directory with the filename
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["cur_inFileBack"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        echo $target_file;
        $uploadOk = 1;
    } else {
        echo "File is not an image. Please try again.";
        $uploadOk = 0;
    }

//    if (empty($cur_imageNameBack)) {//validate name - Cannot be empty
//        $name_errMsg = "You must enter a name";
//        $valid_form = false;
//    }

    if ($uploadOk == 0) {
        //echo "Sorry, your file was not uploaded.";
        $inFileBack_errMsg = "Sorry, there was an error uploading your file.";
        $valid_form = false;
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["cur_inFileBack"]["tmp_name"], $target_fileBack)) { //actually moves the file
            echo "The file " . basename($_FILES["cur_inFileBack"]["name"]) . " has been uploaded.";
        } else {
            // echo "Sorry, there was an error uploading your file.";
            $inFileBack_errMsg = "Sorry, there was an error uploading your file.";

            $valid_form = false;
        }
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

        include "connection.php";


//prepared statements
        $sql = "INSERT INTO currency_Database (";
        $sql .= "cur_denomination, ";
        $sql .= "cur_facevalue, ";
        $sql .= "cur_mint, ";
        $sql .= "cur_year, ";
        $sql .= "cur_condition, ";
        $sql .= "cur_comments, ";
        $sql .= "cur_isprivate, ";
        $sql .= "cur_imagefront, ";
        $sql .= "cur_imageback, ";
        $sql .= "cur_retailvalue ";


// below are prepared statement placeholders
        $sql .= ") VALUES (";
        $sql .= ":curDenomination, ";
        $sql .= ":curFaceValue, ";
        $sql .= ":curMint, ";
        $sql .= ":curYear, ";
        $sql .= ":curCondition, ";
        $sql .= ":curComments, ";
        $sql .= ":curIsPrivate, ";
        $sql .= ":curImageFront, ";
        $sql .= ":curImageBack, ";
        $sql .= ":curRetailValue ";
        $sql .= ")";


        try {
            $stmt = $conn->prepare($sql); //always prepare the statement

            $stmt->bindParam(":curDenomination", $cur_denomination);
            $stmt->bindParam(":curFaceValue", $cur_faceValue); //bind the variables
            $stmt->bindParam(":curMint", $cur_mint);
            $stmt->bindParam(":curYear", $cur_year);
            $stmt->bindParam(":curCondition", $cur_condition);
            $stmt->bindParam(":curComments", $cur_comments);
            $stmt->bindParam(":curIsPrivate", $cur_isPrivate);
            $stmt->bindParam(":curImageFront", $target_file);
            $stmt->bindParam(":curImageBack", $target_fileBack);
            $stmt->bindParam(":curRetailValue", $cur_retailValue);


            $stmt->execute(); // finally, execute the statement
            echo "<h1>Your record has been successfully added to the database.</h1>";
        } catch (PDOException $e) {

            echo "<h1>Something went wrong</h1>";
            echo $e;

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
          content="This is a contact form. Anything entered in the form will be sent to the coffee house (my personal email.)The form also features a honeypot that can be used to see of a bot has filled out the fore and, if so, not send the form.">
    <meta name="keywords" content="contact, email, name, message, subject">
    <meta name="author" content="Charles Broderick">
    <!--    <link href="Images/favicon.ico" rel="icon" type="image/x-icon"/>-->
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

    </style>
    <script>
        function resetForm() {
            alert("inside resetForm()");
        }

        function validateMyForm() { //this function checks the honeypot field to see if a robot tried to fill out the form
            // The field is empty, submit the form.
            // causes some problem in a self posting form when the page form is not displayed. It seems the problem stems from the fact There is no object named 'keyboardType' or 'kitty' to find
            if (!document.getElementById("keyboardType").value && !document.getElementById("midName").value) {
                return true;
            }
            // the field has a value it's a spam bot
            else {
                //do nothing
                return false;
            }
        }
    </script>
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
        <a href="aboutCoffee.html">About</a>
        <a href="viewCoinCollection.php">View Coins</a>
        <a class="active" href="coinDatabase.php">Add Coins</a>
        <a href="contactUs.html">Contact Us</a>
    </div>
    <!--End Navigation Bar-->
    <div class="row">
        <div class="main">
            <h1>Add New Coins to the Database</h1>
            <h2>Enter the important coin information to the database.</h2>

            <?php
            if ($valid_form) {
                ?>
                <h1>Form Was Successful</h1>
                <h2>Thank you for submitting your information</h2>
                <?php
            } else {
                ?>
                <article>
                    <form id="form1" name="form1" method="post" enctype="multipart/form-data"
                          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                          onsubmit=" return validateMyForm()">
                        <fieldset>
                            <legend>Enter important information here.</legend>


                            <p> Coin Denomination: <span id="errorColor"><?php echo $denomination_errMsg; ?></span></p>
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
                                <input type="text" name="cur_year" id="cur_year" value="<?php echo $cur_year; ?>">
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
                                <input type="text" name="cur_mint" id="cur_mint" value="<?php echo $cur_mint; ?>">
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

                                <!--                                Front of coin Image -->
<!--                                <p>-->
<!--                                    <label for="cur_imageName">Coin Front Image Name:</label>-->
<!--                                    <input type="text" name="cur_imageName" id="cur_imageName"-->
<!--                                           value="--><?php //echo $cur_imageName; ?><!--">-->
<!--                                    <span id="errorName">--><?php //echo $name_errMsg; ?><!--</span>-->
<!--                                </p>-->
                                <p>
                                    <label for="cur_inFile">Select Image</label>
                                    <input type="file" name="cur_inFile" id="cur_inFile"
                                           value="<?php echo $cur_inFile; ?>">
                                    <span id="errorFile"><?php echo $inFile_errMsg; ?></span>
                                </p>
                                <br>
                                <!--   Back of coin Image -->
<!--                                <p>-->
<!--                                    <label for="cur_imageNameBack">Coin Back Image Name:</label>-->
<!--                                    <input type="text" name="cur_imageNameBack" id="cur_imageNameBack"-->
<!--                                           value="--><?php //echo $cur_imageNameBack; ?><!--">-->
<!--                                    <span id="errorName">--><?php //echo $name_errMsg; ?><!--</span>-->
<!--                                </p>-->
                                <p>
                                    <label for="cur_inFileBack">Select Image</label>
                                    <input type="file" name="cur_inFileBack" id="cur_inFileBack"
                                           value="<?php echo $cur_inFileBack; ?>">
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
                                    <input type="radio" name="cur_isPrivate" id="noPrivate" value="0" checked="checked"
                                        <?php if ($cur_denomination == "0") {
                                            echo "checked";
                                        } ?>>
                                </p><br>
                            </fieldset>
                            <p>
                                <input type="submit" name="cur_submit" id="cur_submit" value="Submit">
                                <input type="reset" name="resetForm" id="resetForm" value="Reset" onClick="resetForm()">
                            </p>

                        </fieldset>
                    </form>
                </article>

                <?php
            }    //end valid form confirmation
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



<p></p>
<script>
    document.getElementById('kitten').style.display = "none"; //hide this field
    document.getElementById('midName').style.display = "none"; //hide this field
</script>
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