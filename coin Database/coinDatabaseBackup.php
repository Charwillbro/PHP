<?php
$cur_faceValue = "";    //define variable
$cur_year = "";
$cur_denomination = "";
$cur_mint = "";
$cur_comment = "";
$cur_retailValue = "";
$cur_condition = "";

$faceValue_errMsg = "";    //define variable
$year_errMsg = "";
$denomination_errMsg = "";
$mint_errMsg = "";
$comments_errMsg = "";
$condition_errMsg = "";
$retailValue_errMsg = "";

$valid_form = false;

// THINGS TO DO
//
// FINISH VALIDATION
// STYLE PAGE
//












if (isset($_POST['cur_submit'])) {
    //process form data

    include 'coinValidation.php';    //get validation functions

   // $cur_faceValue = $_POST['cur_faceValue'];
   $cur_faceValue = getFaceValue();
    $cur_year = $_POST['cur_year'];
    $cur_denomination = $_POST['cur_denomination'];
    $cur_mint = $_POST['cur_mint'];
    $cur_comment = $_POST['cur_comment'];
    $cur_retailValue = $_POST['cur_retailValue'];
    $cur_condition = $_POST['cur_condition'];

    if (isset($_POST['cur_denomination'])) {
        $cur_denomination = $_POST['cur_denomination'];
    }

    $valid_form = true;        //set validation flag assume all fields are valid



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

    if ($valid_form) {
//Form is good

        include "connection.php";

      //  $cur_value = $_POST['cur_value'];    //define variable
      //  $cur_year = $_POST['cur_year'];
      //  $cur_denomination = $_POST['cur_denomination'];

//prepared statements
        $sql = "INSERT INTO currency_Database (";
        $sql .= "cur_denomination, ";
        $sql .= "cur_faceValue, ";
        $sql .= "cur_mint, ";
        $sql .= "cur_year, ";
        $sql .= "cur_condition, ";
        $sql .= "cur_comments, ";
        $sql .= "cur_retailValue ";


// below are prepared statement placeholders
        $sql .= ") VALUES (";
        $sql .= ":curDenomination, ";
        $sql .= ":curFaceValue, ";
        $sql .= ":curMint, ";
        $sql .= ":curYear, ";
        $sql .= ":curCondition, ";
        $sql .= ":curComments, ";
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
<html>
<head>
    <meta charset="utf-8">
    <title>Add Coins</title>
    <style>
        [id^="error"] {
            color: red;
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
    <form name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit=" return validateMyForm()">

        <p> Coin Denomination: <span id="errorColor"><?php echo $denomination_errMsg; ?></span></p>
        <p>
            <input type="radio" name="cur_denomination" id="penny" value="Penny"
                <?php if ($cur_denomination == "Penny") {
                    echo "checked";
                } ?>>
            <label for="penny">Penny</label><br>

            <input type="radio" name="cur_denomination" id="nickel" value="Nickel"
                <?php if ($cur_denomination == "Nickel") {
                    echo "checked";
                } ?>>
            <label for="nickel">Nickel</label><br>

            <input type="radio" name="cur_denomination" id="dime" value="Dime"
                <?php if ($cur_denomination == "Dime") {
                    echo "checked";
                } ?>>
            <label for="dime">Dime</label><br>

            <input type="radio" name="cur_denomination" id="quarter" value="Quarter"
                <?php if ($cur_denomination == "Quarter") {
                    echo "checked";
                } ?>>
            <label for="quarter">Quarter</label><br>

            <input type="radio" name="cur_denomination" id="half_Dollar" value="Half-Dollar"
                <?php if ($cur_denomination == "Half-Dollar") {
                    echo "checked";
                } ?>>
            <label for="half_Dollar">Half-Dollar</label><br>

            <input type="radio" name="cur_denomination" id="dollar" value="Dollar"
                <?php if ($cur_denomination == "Dollar") {
                    echo "checked";
                } ?>>
            <label for="dollar">Dollar Coin</label><br>

        </p>
<!--        This form field is no longer necessary, as it is generated based on the coin denomination-->
<!--        <p>
<!--            <!-- Currency value could auto populate for coins but bills would need entered-->-->
<!--            <label for="cur_faceValue">Currency Face Value </label>-->
<!--            <input type="text" name="cur_faceValue" id="cur_faceValue" value="--><?php //echo $cur_faceValue; ?><!--">-->
<!--            <span id="errorValue">--><?php //echo $faceValue_errMsg; ?><!--</span>-->
<!--        </p>-->

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
            <input type="text" name="cur_condition" id="cur_condition" value="<?php echo $cur_condition; ?>">
            <span id="errorComments"> <?php echo $condition_errMsg; ?></span>
        </p>
        <p>
            <label for="cur_retailValue">Retail Value </label>
            <input type="text" name="cur_retailValue" id="cur_retailValue" value="<?php echo $cur_retailValue; ?>">
            <span id="errorComments"> <?php echo $retailValue_errMsg; ?></span>
        </p>

        <p>
            <label for="cur_comments">Comments </label>
            <input type="text" name="cur_comment" id="cur_comment" value="<?php echo $cur_comment; ?>">
            <span id="errorComments"> <?php echo $comments_errMsg; ?></span>
        </p>


        <p>
            <input type="submit" name="cur_submit" id="cur_submit" value="Submit">
            <input type="reset" name="resetForm" id="resetForm" value="Reset" onClick="resetForm()">
        </p>


    </form>
    <?php
}    //end valid form confirmation
?>

<p></p>
<script>
    document.getElementById('kitten').style.display = "none"; //hide this field
    document.getElementById('midName').style.display = "none"; //hide this field
</script>
</body>
</html>