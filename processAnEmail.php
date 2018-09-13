<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 9/4/2018
 * Time: 2:00 PM
 */
require 'Emailer.php'; //access the class file
$businessEmail = new Emailer(); // instantiates a new instance of class Emailer()
$businessEmail->setMessageLine("This will hopefully be a really long string that will need to be broken up into smaller strings using wordwrap meow meow meow meow meow meow"); //loaded a value into the object
$businessEmail->setSenderAddress("charwillbro@charleswbroderick.com");
$businessEmail->setSendToAddress("charwillbro@gmail.com");
$businessEmail->setSubjectLine("Test Email");
//$businessEmail->sendPHPEmail();
$validEmail = $businessEmail->sendPHPEmail();//calling the function from the emailer class

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHP Email </title>
</head>


<body>

<h1>Email Class example</h1>
<p> Your email message is: <?php echo $businessEmail->getMessageLine(); ?><br>
    Your sender email is: <?php echo $businessEmail->getSenderAddress(); ?><br>
    Your Receiver email is: <?php echo $businessEmail->getSendToAddress(); ?> <br>
    Your subject line is: <?php echo $businessEmail->getSubjectLine(); ?> </p>

<?php
if ($validEmail) {
    ?>
    <p>Thank You for your Email. We will respond as soon as possible.</p>
    <?php
} else {
    ?>
    <p> We are sorry, There has been a problem. Please try again.</p>
    <?php
}
?>

</body>
</html>
