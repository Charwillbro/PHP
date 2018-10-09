<?php
//Charles Broderick
//Charwillbro@gmail.com
//10/9/2018
$lab_name = "";
$lab_email = "";
$name_errMsg = "";
$email_errMsg = "";
$valid_form = false;



if( isset($_POST['form_submit'])) {
    //process form data
    $lab_name = $_POST['lab_name']; //Get the values from the post associative array and loads it into variables
    $lab_email = $_POST['lab_email'];

    //Validate the data
    $valid_form = true; //this flag tells us if the form info is good

    if( empty($lab_name)) {//validate name - Cannot be empty
        $name_errMsg = "Please enter a name";
        $valid_form = false;
    }

    //validate email using PHP filter
    if( !filter_var($lab_email, FILTER_VALIDATE_EMAIL)) {
        $email_errMsg = "Invalid email";
        $valid_form = false;
    }


    if ($valid_form) { //all fields passed validation, send to database
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
<script type="text/javascript">
    function validateMyForm() {
        // The field is empty, submit the form.
        if(!document.getElementById("meow").value) {
            return true;
        }
        // the field has a value it's a spam bot
        else {
            return false;
        }
    }
</script>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>WDV341 Intro PHP</title>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>Unit-7 and Unit-8 Form Validations and Self Posting Forms.</h2>
<h3>In Class Lab - Self Posting Form</h3>
<p><strong>Instructions:</strong></p>
<ol>
    <li>Modify this page as needed to convert it into a PHP self posting form.</li>
    <li>Use the validations provided on the page for the server side validation. You do NOT need to code any validations.</li>
    <li>Modify the page as needed to display any input errors.</li>
    <li>Include some form of form protection.</li>
    <li>You do NOT need to do any database work with this form. </li>
</ol>
<p>When complete:</p>
<ol>
    <li>Post a copy on your host account.</li>
    <li>Push a copy to your repo.</li>
    <li>Submit the assignment on Blackboard. Include a link to your page and to your repo.</li>
</ol>
<?php
if($valid_form){//displays if valid_form is true, does not display form
    ?>
    <h1>Form was successful </h1>
    <h2>Name you Submitted: <?php echo $lab_name; ?></h2>
    <h2>Email you Submitted: <?php echo $lab_email; ?></h2>
    <?php
}else{ //if valid_form is false it will display the form


    ?>
    <form name="form1" method="post" action="" onsubmit="return validateMyForm()">
        <p>
            <label for="lab_name">Name:</label>
            <input type="text" name="lab_name" id="lab_name"  value="<?php echo $lab_name; ?>">
            <span id="errorName"><?php echo $name_errMsg; ?></span>
        </p>
        <p>
            <label for="lab_email">Email:</label>
            <input type="text" name="lab_email" id="lab_email" value="<?php echo $lab_email; ?>">
            <span id="errorName"><?php echo $email_errMsg; ?></span>
        </p>
        <p>
        <div style="display:none;"> <?php //this field checks for bots it will be hidden from real people
            ?>
            <label>Are You a Cat?</label>
            <input type="text" name="meow" id="meow" />
        </div>
        </p>
        <p>
            <input type="submit" name="form_submit" id="form_submit" value="Submit">
            <!-- <input type="submit" name="button2" id="button2" value="Submit"> -->
        </p>
    </form>
    <?php
}
?>

</body>
</html>
