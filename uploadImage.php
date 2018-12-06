<?php
//Charles Broderick
//Charwillbro@gmail.com
//10/9/2018
$imageName = "";
$inFile = " ";
$name_errMsg = "";
$inFile_errMsg = "";
$valid_form = false;


//configure the php.ini file to allow file uploads

if (isset($_POST['buttonUpload'])) {//has the form been seen by the user and they clicked submit
    //process form data
    $imageName = $_POST['imageName']; //Get the values from the post associative array and loads it into variables
    $inFile = $_FILES['inFile'];


    //Validate the data
    $valid_form = true; //this flag tells us if the form info is good

    //upload file settings found at w3 schools
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["inFile"]["name"]); //concatenate the target directory with the filename
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["inFile"]["tmp_name"]);
    if ($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if (empty($imageName)) {//validate name - Cannot be empty
        $name_errMsg = "You must enter a name";
        $valid_form = false;
    }

//    if( empty($inFile)) {//validate name - Cannot be empty
//        $inFile_errMsg = "You must select a file";
//        $valid_form = false;
//    }

    if ($uploadOk == 0) {
        //echo "Sorry, your file was not uploaded.";
        $inFile_errMsg = "Sorry, there was an error uploading your file.";
        $valid_form = false;
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["inFile"]["tmp_name"], $target_file)) { //actually moves the file
            echo "The file " . basename($_FILES["inFile"]["name"]) . " has been uploaded.";
        } else {
           // echo "Sorry, there was an error uploading your file.";
            $inFile_errMsg = "Sorry, there was an error uploading your file.";

            $valid_form = false;
        }
    }
    if ($valid_form) {


    }



}

?>
<script type="text/javascript">
    function validateMyForm() {
        // The field is empty, submit the form.
        if (!document.getElementById("meow").value) {
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
    <title>WDV341 Intro PHP upload image</title>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>Upload a file</h2>

<?php
if ($valid_form) {//displays if valid_form is true, does not display form
    ?>
    <h1>Form was successful </h1>
    <!--    <h2>Name you Submitted: --><?php //echo $imageName;
    ?><!--</h2>-->
    <!--    <h2>Email you Submitted: --><?php //echo $inFile;
    ?><!--</h2>-->
    <?php
} else { //if valid_form is false it will display the form

    ?>
    <form name="form1" method="post" enctype="multipart/form-data"
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateMyForm()">
        <p>
            <label for="imageName">Image Name:</label>
            <input type="text" name="imageName" id="imageName" value="<?php echo $imageName; ?>">
            <span id="errorName"><?php echo $name_errMsg; ?></span>
        </p>
        <p>
            <label for="inFile">Select Image</label>
            <input type="file" name="inFile" id="inFile" value="<?php echo $inFile; ?>">
            <span id="errorFile"><?php echo $inFile_errMsg; ?></span>
        </p>

        <p>
        <div style="display:none;"> <?php //this field checks for bots it will be hidden from real people
            ?>
            <label>Are You a Cat?</label>
            <input type="text" name="meow" id="meow"/>
        </div>
        </p>
        <p>
            <input type="submit" name="buttonUpload" id="form_submit" value="Submit">
            <!-- <input type="submit" name="button2" id="button2" value="Submit"> -->
        </p>
    </form>
    <?php
}
?>

</body>
</html>
