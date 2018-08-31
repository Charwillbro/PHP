<?php
/**
 * User: Charles Broderick
 * Date: 8/30/2018
 * Time: 6:32 PM
 */
?>

<?php
//Variable Declarations
$originalDate = date_create("2013-03-15");//date to pass into functions
$originalString = " I attEND DMACC for school  ";
$originalNumber = 1234567890;
$originalCurrency = 123456;

//functions
function domesticDateFormat($date){ //--EX 1 function that accepts a date and outputs it in mm/dd/yyyy format
    return  date_format($date, "m/d/Y");

}

function internationalDateFormat($date){ //--EX 2 function that accepts a date and outputs it in dd/mm/yyyy format
    return  date_format($date, "d/m/Y");

}

function stringModifier($string){ //--EX 3 function that counts characters, trims whitespace, makes all lowercase, and checks if 'DMACC' is in the string --EX 3

   $stringLength = strlen($string);// --EX 3a counts the characters
   $lowercaseString = trim(strtolower($string)); // --EX 3b,3c goes lowercase and is trimmed
   $searchString =  "was not"; // --EX 3d  Searches for 'DMACC'
    if (strpos($string, 'DMACC') !== false) {
        $searchString =   "was";
    }

  echo "<p> There are ". $stringLength." characters in the original string.<br> The string in lowercase and trimmed: " . $lowercaseString.".<br> The word 'DMACC' ".$searchString." found in the string!</p>";

}

function numberModifier($number){// --EX 4 display a number as a formatted number
    return number_format($number);

}

function currencyModifier($currency){// --EX 5 display a number as US currency
    return "$".number_format( $currency,2);

}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHP Functions</title>
</head>
<body>
<h1>PHP Functions</h1>

<p><?php
    echo "<p>The original date format is " . date_format($originalDate,"Y/m/d") . ".<br> <!--//Original date-->
           The domestic date format is " . domesticDateFormat($originalDate) . ".<br> <!--//domestic date mm/dd/yyyy-->
           The International date format is " . internationalDateFormat($originalDate) . ".</p>"; //international date dd/mm/yyyy

    echo "<p> The unmodified string is: ".$originalString.".</p>";//displays original string
    stringModifier($originalString);//displays modified string

    echo "<p>The original number is ".$originalNumber.".<br> The formatted number is: ".numberModifier($originalNumber).".</p>"; //displays the number

    echo "<p>The original currency is ".$originalCurrency. ".<br> The formatted currency is: ".currencyModifier($originalCurrency).".</p>"; //displays the currency


    ?></p>
</body>
</html>
