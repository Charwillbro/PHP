<?php
/**
 * User: Charles Broderick
 * Date: 8/28/2018
 * Time: 2:12 PM
 */
?>
<?php
/** variable declarations*/
$yourName = "Charles Broderick";
$number1 = 5;
$number2 = 6;
$total = $number1+$number2;


?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHP Basics</title>
</head>

<body>
    <script> document.write("<h1> PHP Basics </h1>");</script>
    <h2><?php echo"My name is $yourName "?></h2>

    <p><?php echo "Number 1: $number1 <p> Number 2: $number2 <p> $number1 + $number2 = $total</p>" ?></p>
    <!-- below, php is outputting javascript to initialize an array with 3 values -->
    <?php  echo "<script>var languageArray = ['PHP','HTML','Javascript'];</script>"?>
    <!-- below, javascript is printing the values of the array on the webpage -->
    <script> document.write( "The elements in the array are as follows: "+languageArray[0]+", "+languageArray[1]+","+languageArray[2] );</script>

</body>
</html>
