<?php
$name_errMsg = "";
$prod_name = "";
$prod_price = "";
$prod_radio = "";

    if( isset($_POST['prod_submit'])) {
        //process form data
        $prod_name = $_POST['prod_name']; //Get the values from the post associative array and loads it into variables
        $prod_price = $_POST['prod_price'];
        $prod_radio = $_POST['prod_radio'];

        //Validate the data
        $valid_form = true; //this flag tells

        include 'formValidation.php';

        if (!validateProdName($prod_name)) { //runs validation function
            $valid_form = false;
            $name_errMsg = "Please enter a Product Name.";
        }

        if ($valid_form) {//all fields passed validation, send to database
            //include dbconnect file
            //create the sql


            //try catch block
            //prepare the statement PDO prepared statement
            //bind the variables
            //execute statement
            //confirmation message and do NOT DISPLAY FORM

            //only do this if the database works
            //display confirmation instead of the form.
            //message "thank you for your order"

        }
            //display form with data fields and error messages if applicable


    }

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

<h1>WDV341 Intro PHP </h1>
<h2>Unit-8 Self Posting Form</h2>
<h3>Example Form</h3>
<p>Converting a form to a self posting form.</p>
<?php
if($valid_form){

}else {


    ?>
    <form name="form1" method="post" action="">
        <p>
            <label for="prod_name">Product Name: </label>
            <input type="text" name="prod_name" id="prod_name" value="<?php echo $prod_name; ?>">
            <span id="errorName"><?php echo $name_errMsg; ?></span>
        </p>
        <p>
            <label for="prod_price">Product Price: </label>
            <input type="text" name="prod_price" id="prod_price" value="<?php echo $prod_price; ?>">
        </p>
        <p>Product Color:</p>
        <p>
            <input type="radio" name="prod_radio" id="prod_red" value="prod_red">
            <!-- sends the value when the submit is pressed -->
            <label for="prod_red">Red Wagon<br></label>
            <input type="radio" name="prod_radio" id="prod_green" value="prod_green">
            <label for="prod_green">Green Wagon</label>
        </p>
        <p>
            <input type="submit" name="prod_submit" id="prod_submit" value="Submit">
            <input type="reset" name="Reset" id="button" value="Reset">
        </p>
    </form>
    <?php
}
    ?>
<p>&nbsp;</p>

</body>

</html>
<?php //} //end of else statement
    ?>