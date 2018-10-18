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
		if( isset($_POST['prod_color']) )	{
			$prod_color = $_POST['prod_color'];
		}
		$prod_wagon = $_POST['prod_wagon'];

		$valid_form = true;		//set validation flag assume all fields are valid

		include 'validationsAdvanced-Solution.php';	//get validation functions

		if( !validateProdName($prod_name) ) {
			$valid_form = false;
			$name_errMsg = "Please enter a product name";
		}

		if( !validateProdPrice($prod_price) )	{
			$valid_form = false;
			$price_errMsg = "Price must be numeric and greater than zero";
		}

		if( !validateProdColor( $prod_color ) )	{
			$valid_form = false;
			$color_errMsg = "Please select a color";
		}

		if( !validateProdWagon( $prod_wagon ) ) {
			$valid_form = false;
			$wagon_errMsg = "Please select a wagon";
				echo "<h1>Wagon errMsg: $wagon_errMsg</h1>";
		}


		if($valid_form) {
			//Form is good

            include "connection.php";

            $prod_name = $_POST['prod_name'];	//define variable
            $prod_price = $_POST['prod_price'];
            $prod_color = $_POST['prod_color'];
            $prod_wagon = $_POST['prod_wagon'];
            $date = date("Y-m-d");

            //prepared statements

            // below are prepared statements.

            $sql = "INSERT INTO lab_wagons (";
            $sql .= "prod_name, ";
            $sql .= "prod_wagon_ordered, ";
            $sql .= "prod_price, ";
            $sql .= "prod_color, ";
            $sql .= "prod_wagon ";

            // below are prepared statement placeholders
            $sql .= ") VALUES (";
            $sql .= ":prodName, ";
            $sql .= ":prodWagonOrdered, ";
            $sql .= ":prodPrice, ";
            $sql .= ":prodColor, ";
            $sql .= ":prodWagon ";
            $sql .= ")";


            try{
                $stmt = $conn->prepare($sql); //always prepare the statement

                $stmt ->bindParam(":prodName", $prod_name); //bind the variables
                $stmt ->bindParam(":prodWagonOrdered",$date);
                $stmt ->bindParam(":prodPrice",$prod_price);
                $stmt ->bindParam(":prodColor",$prod_color);
                $stmt ->bindParam(":prodWagon",$prod_wagon);

                $stmt ->execute(); // finally, execute the statement
                echo "<h1>Your record has been successfully added to the database.</h1>";
            }
            catch(PDOException $e){


                die();

            }

        }


	}//if submitted
?>
        <!doctype html>
        <html>
        <head>
        <meta charset="utf-8">
        <title>Untitled Document</title>

        <style>

			[id^="error"]	{
				color:red;
			}

		</style>

        <script>

			function resetForm() {
				alert("inside resetForm()");

			}

		</script>

        </head>

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
        <form name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
          <p>Product Color: <span id="errorColor"><?php echo $color_errMsg; ?></span></p>
          <p>
            <input type="radio" name="prod_color" id="prod_red" value="prod_red"
            	<?php if($prod_color == "prod_red"){ echo "checked"; } ?>>
            <label for="prod_red">Red</label>
            <input type="radio" name="prod_color" id="prod_green" value="prod_green"
            	<?php if($prod_color == "prod_green"){ echo "checked"; } ?>>
            <label for="prod_green">Green</label>
            <input type="radio" name="prod_color" id="prod_blue" value="prod_blue"
            	<?php if($prod_color == "prod_blue"){ echo "checked"; } ?>>
            <label for="prod_blue">Blue</label>
          </p>
          <p>Select Product:
          	<select name="prod_wagon" id="prod_wagon">
            	<option value="select" <?php if($prod_wagon == "select"){ echo "selected"; } ?>>Select Wagon</option>
            	<option value="wag_sm" <?php if($prod_wagon == "wag_sm"){ echo "selected"; } ?>>Small Wagon</option>
            	<option value="wag_md" <?php if($prod_wagon == "wag_md"){ echo "selected"; } ?>>Medium Wagon</option>
                <option value="wag_lg" <?php if($prod_wagon == "wag_lg"){ echo "selected"; } ?>>Large Wagon</option>
            </select>
            <span id="errorWagon"><?php echo $wagon_errMsg; ?></span>
          </p>
          <p>
            <input type="submit" name="prod_submit" id="prod_submit" value="Submit">
            <input type="reset" name="resetForm" id="resetForm" value="Reset" onClick="resetForm()">
          </p>
        </form>
        <?php
			}	//end valid form confirmation
		?>

        <p></p>
</body>
</html>