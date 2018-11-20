<!DOCTYPE html>
<!-- Charles Broderick // Charwillbro@gmail.com-->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>WDV341 Intro PHP - Form Validation Example</title>
    <?php
    //Setup the variables used by the page
    $nameErrMsg = "";
    $sSNErrMsg = "";
    $responseErrMsg = "";

    $validForm = false;

    $inName = "";
    $inSSN = "";
    $responseRadio = "";


    function validateName()
    {
        global $inName, $validForm, $nameErrMsg;        //Use the GLOBAL Version of these variables instead of making them local
        $nameErrMsg = "";                                //Clear the error message.
        if ($inName == "") {
            $validForm = false;                    //Invalid name so the form is invalid
            $nameErrMsg = "Name is required";    //Error message for this validation
        }
    }

    function validateSSN()
    {
        global $inSSN, $validForm, $sSNErrMsg;    //Use the GLOBAL Version of these variables instead of making them local
        $sSNErrMsg = "";                                //Clear the error message.

        if ($inSSN == "")                            //REQUIRED FIELD VALIDATION TEST
        {
            $validForm = false;
            $sSNErrMsg .= "Social Security Number is required. ";    //append message to message variable to allow for possible multiple error messages
        }

        if (intVal($inSSN) == 0)                    //NUMERIC REQUIRED VALIDATION TEST  	intval() returns 0 if not an integer
        {
            $validForm = false;
            $sSNErrMsg .= "Social Security Number Must be a positive Whole Number  ";
        } else {
            if ($inSSN < 100000000 || $inSSN > 999999999)        //REASONABLE VALIDATION TEST
            {
                $validForm = false;
                $sSNErrMsg .= "Social Security Number must be 9 digits";
            }
        }
    }

    function validateResponse($responseRadio)
    {
        //cannot be empty

        if (empty($responseRadio)) {
            return false;    //Failed validation
        } else {
            return true;    //Passes validation
        }
    }//end validateProdName()


    if (isset($_POST['submit'])) {
        //process form data
        $inName = $_POST['inName'];
        $inSSN = $_POST['sSN'];
        $responseRadio = $_POST['RadioGroup1'];


        $validForm = true;        //set validation flag assume all fields are valid
        //echo "<script type='text/javascript'>alert('$validForm');</script>";
        if (validateName($inName)) {
            $validForm = false;
            //$nameErrMsg = "Please enter a product name";
        }

       // echo "<script type='text/javascript'>alert('$validForm');</script>";
        if (validateSSN(intval($inSSN))) {
            $validForm = false;
            //$sSNErrMsg = "Price must be numeric and greater than zero";
        }
       // echo "<script type='text/javascript'>alert('$validForm');</script>";
        if (!validateResponse($responseRadio)) {
            $validForm = false;
            $responseErrMsg = "Response Must Be Selected";
        }
        //echo "<script type='text/javascript'>alert('$validForm');</script>";

//        if($validForm) {
//            //Form is good, send to database
//
//        }
        //else display the form with original values and error messages

    }

    ?>
    <style>

        #orderArea {
            width: 600px;
            background-color: #CF9;
        }

        .error {
            color: red;
            font-style: italic;
        }
    </style>
</head>

<body>
<?php
if ($validForm) {
    ?>
    <h1>Form Was Successful</h1>
    <h2>Thank you for submitting your information</h2>
    <?php
} else {
    ?>
    <h1>WDV341 Intro PHP</h1>
    <h2>Form Validation Assignment


    </h2>
    <div id="orderArea">
        <h1><?php echo $validForm; ?></h1>
        <form id="form1" name="form1" method="post" action="formValidationAssignment.php">

            <h3>Customer Registration Form</h3>
            <table width="587" border="0">
                <tr>
                    <td width="117">Name:</td>
                    <td width="246"><input type="text" name="inName" id="inName" size="40"
                                           value="<?php echo $inName; ?>"/></td>
                    <td width="210" class="error"><?php echo $nameErrMsg; ?></td>
                </tr>
                <tr>
                    <td>Social Security</td>
                    <td><input type="text" name="sSN" id="sSN" size="40" value="<?php echo $inSSN; ?>"/></td>
                    <td class="error"><?php echo $sSNErrMsg; ?></td>
                </tr>
                <tr>
                    <td>Choose a Response</td>
                    <td><p>
                            <label>
                                <input type="radio" name="RadioGroup1" id="RadioGroup1_0"
                                       value="Phone" <?php if ($responseRadio == "Phone") {
                                    echo "checked";
                                } ?>>
                                Phone</label>
                            <br>
                            <label>
                                <input type="radio" name="RadioGroup1" id="RadioGroup1_1"
                                       value="Email" <?php if ($responseRadio == "Email") {
                                    echo "checked";
                                } ?>>
                                Email</label>
                            <br>
                            <label>
                                <input type="radio" name="RadioGroup1" id="RadioGroup1_2"
                                       value="US Mail" <?php if ($responseRadio == "US Mail") {
                                    echo "checked";
                                } ?>>
                                US Mail</label>
                            <br>
                        </p></td>
                    <td class="error"><?php echo $responseErrMsg; ?></td>
                </tr>
            </table>
            <p>
                <input type="submit" name="submit" id="submit" value="Register"/>
                <input type="reset" name="button2" id="button2" value="Clear Form"/>
            </p>
        </form>
    </div>
    <?php
}    //end valid form confirmation
?>
</body>
</html>