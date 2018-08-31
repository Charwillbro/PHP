<?php
/**
 * User: Charles Broderick
 * Date: 8/30/2018
 * Time: 6:32 PM
 */
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHP Functions</title>
</head>
<?php
//Variable Declarations

$originalDate=date_create("2013-03-15");
echo date_format($date,"Y/m/d");

function domesticDateFormat($date){ //function that accepts a date and outputs it in mm/dd/yyyy format
    $newDate =  date_format($date, "m/d/Y");
    echo "function is running";
    echo $date;
    echo $newDate;
}
function internationalDateFormat($date){ //function that accepts a date and outputs it in dd/mm/yyyy format
    $newDate =  date_format($date, "d/m/Y");
    echo "international function is running";
    echo $newDate;
}


?>
<body>
<h1>PHP Functions</h1>
 <?php  echo "<p> The original date format is ". $originalDate.".</p>"; //Original date
        echo "<p> The domestic date format is ". domesticDateFormat($originalDate).".</p>"; //domestic date mm/dd/yyyy
        echo "<p> The International date format is ". internationalDateFormat($originalDate).".</p>"; //international date dd/mm/yyyy
        echo "timmay";

?>


</body>
</html>
