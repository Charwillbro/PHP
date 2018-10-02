<?php
    if( isset($_POST['prod_submit'])){
        //process form data
        $prod_name = $POST['prod_name']; //Get the values from the post associative array and loads it into variables
        $prod_price = $POST['prod_price'];
        $prod_radio = $POST['prod_radio'];

        //Validate the data
        $valid_form = true; //this flag tells

        include 'formValidation.php';

        if(!validateProdName($prod_name)){
            $valid_form = false;
            $name_errMsg = "Please enter a Product Name.";
        }


        echo"<h1>Form has been submitted and should be processed</h1>";
    }else{
        //show the form to the user





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
<form name="form1" method="post" action="">
  <p>
    <label for="prod_name">Product Name: </label>
    <input type="text" name="prod_name" id="prod_name">
  </p>
  <p>
    <label for="prod_price">Product Price: </label>
    <input type="text" name="prod_price" id="prod_price">
  </p>
  <p>Product Color:</p>
  <p>
    <input type="radio" name="prod_radio" id="prod_red" value="prod_red"> <!-- sends the value when the submit is pressed -->
    <label for="prod_red">Red Wagon<br></label>
    <input type="radio" name="prod_radio" id="prod_green" value="prod_green">
    <label for="prod_green">Green Wagon</label>
  </p>
  <p>
    <input type="submit" name="prod_submit" id="prod_submit" value="Submit">
    <input type="reset" name="Reset" id="button" value="Reset">
  </p>
</form>
<p>&nbsp;</p>

</body>

</html>
<?php } //end of else statement
    ?>