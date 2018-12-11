<?php
	$prod_name = "";	//define variable
    $prod_price = "";
    $prod_color = "";
    $prod_wagon = "";
	$name_errMsg = "";	//define variable
	$price_errMsg = "";
	$color_errMsg = "";
    $wagon_errMsg = "";
	$valid_form = false;

	if( isset($_POST['prod_submit']) )
	{
		//process form data	
		
		$prod_name = $_POST['prod_name'];
		$prod_price = $_POST['prod_price'];
		if(isset($_POST ['prod_color'])){ //this if statement checks to see if user suselected a radio dial
		    $prod_color = $_POST['prod_color'];
        }else{
		    $prod_color="";
        }
		$prod_wagon = $_POST['prod_wagon'];
		

		$valid_form = true;		//set validation flag assume all fields are valid
		
		include 'validationsAdvanced.php';	//get validation functions		
		
		if( !validateProdName($prod_name) ) {
			$valid_form = false;
			$name_errMsg = "Please enter a product name";
		}
		
		if( !validateProdPrice($prod_price) )	{
			$valid_form = false;
			$price_errMsg = "Price must be numeric and greater than zero";
		}

        if( !validateProdColor($prod_color) )	{
            $valid_form = false;
            $color_errMsg = "Color must be selected";
        }
        if( !validateProdSize($prod_wagon))	{
            $valid_form = false;
            $wagon_errMsg = "Wagon size must be selected";
        }

        if($valid_form) {
			//Form is good, send to database

		}
			//else display the form with original values and error messages

	}
//	else
//	{
		//show the form to the customer/user
?>
        <!doctype html>
        <html>
        <head>
        <meta charset="utf-8">
        <title>Untitled Document</title>
        </head>
        <!-- colors anything with id having the word "error"-->
        <style>
            [id^="error"]{
                color: red;
            }
        </style>
        <body>
        
        <h1>WDV341 Intro PHP </h1>
        <h2>Unit-8 Self Posting Form</h2>
        <h3>Example Form</h3>
        <p>Converting a form to a self posting form.</p>
        
        <?php
			if($valid_form)
			{
		?>
			<h1>Form Was Successful</h1>
            <h2>Thank you for submitting your information</h2>        
        <?php
			}
			else
			{
		?>
        <form name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>"><!-- This code precents someone redirecting the page to a different form-->
          <p>
            <label for="prod_name">Product Name: </label>
            <input type="text" name="prod_name" id="prod_name" value="<?php echo $prod_name; ?>">
            <span id="errorName"><?php echo $name_errMsg; ?></span>
          </p>
          <p>
            <label for="prod_price">Product Price: </label>
            <input type="text" name="prod_price" id="prod_price" value="<?php echo $prod_price; ?>">
            <span id="errorPrice"><?php echo $price_errMsg; ?></span>          
          </p>
          <p>Product Color:</p>
          <p>
            <input type="radio" name="prod_color" id="prod_red" value="prod_red"
                <?php if($prod_color == "prod_red") {echo "checked";}?> >
            <label for="prod_red">Red</label>
            <input type="radio" name="prod_color" id="prod_green" value="prod_green"
                <?php if($prod_color == "prod_green") {echo "checked";}?>
            >
            <label for="prod_green">Green</label>
            <input type="radio" name="prod_color" id="prod_blue" value="prod_blue"
                <?php if($prod_color == "prod_blue") {echo "checked";}?>
            >
            <label for="prod_blue">Blue</label>
              <span id="errorPrice"><?php echo $color_errMsg; ?></span>
          </p>
          <p>
          	<select name="prod_wagon" id="prod_wagon">
            	<option value=""<?php if($prod_wagon == ""){ echo "selected";} ?>>Select Wagon</option>
            	<option value="wag_sm"<?php if($prod_wagon == "wag_sm"){ echo "selected";} ?>>Small Wagon</option>
            	<option value="wag_md"<?php if($prod_wagon == "wag_md"){ echo "selected";} ?>>Medium Wagon</option>
                <option value="wag_lg"<?php if($prod_wagon == "wag_lg"){ echo "selected";} ?>>Large Wagon</option>
            </select>
              <span id="errorPrice"><?php echo $wagon_errMsg; ?></span>
          </p>
          <p>
            <input type="submit" name="prod_submit" id="prod_submit" value="Submit">
            <input type="reset" name="Reset" id="button" value="Reset">
          </p>
        </form>
        <?php
			}	//end valid form confirmation 
		?>
        
        <p>&nbsp;</p>

<?php
//	}//end of check for submit to display form
?>
</body>
</html>