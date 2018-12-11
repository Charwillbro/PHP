<?php
/**
 * Created by PhpStorm.
 * User: charles Broderick
 * Date: 8/30/2018
 * Time: 1:51 PM
 */
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHP Mail</title>
</head>

<body>
<script> document.write("<h1> PHP Mail </h1>");</script>
<?php

function PHPMailer(){
    mail( "charwillbro@gmail.com","test email" , "This is a test email.", "From: charwillbro@charleswbroderick.com" );
    echo "Function is running";


    echo "Today is " . date("m/d/Y") . "<br>"; //displays the date in month, day, year
    echo "Today is " . date("l"); //displays the name of the day

    $from = "From: charwillbro@charleswbroderick.com"; //MUST BE LOWERCASE GOOD LORD
    $to = "charwillbro@gmail.com";
    $subject = "Subject";
    $body = "TEST";



}
PHPMailer();

?>

</body>
</html>