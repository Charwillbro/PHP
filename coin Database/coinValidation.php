<?php

function validateCurValue($inValue)
{
    //cannot be empty

    if (empty($inValue)) {
        return false;    //Failed validation
    } else {
        return true;    //Passes validation
    }
}

function validateCurYear($inYear)
{
    //cannot be empty
    //must be numeric
    //must be greater than zero

    if (empty($inYear)) {
        return false;    //Failed validation
    } else {
        if (is_numeric($inYear) && ($inYear > 1769) && (($inYear - 1) < date('Y'))) {
            return true;        //Passes validation
        } else {
            return false;
        }
    }
}

function validateCurDenomination($inDenomination)
{
    //must select a color
    if (empty($inDenomination)) {
        return false;
    } else {
        return true;
    }


}

function getFaceValue()
{
    $coinDenom = $_POST['cur_denomination'];

    switch ($coinDenom) {

        case $coinDenom == "Penny":
            $coinDenom = .01;
            break;
        case $coinDenom == "Nickel":
            $coinDenom = .05;
            break;
        case $coinDenom == "Dime":
            $coinDenom = .10;
            break;
        case $coinDenom == "Quarter":
            $coinDenom = .25;
            break;
        case $coinDenom == "Half-Dollar":
            $coinDenom = .50;
            break;
        case $coinDenom == "Dollar":
            $coinDenom = 1.00;
            break;

        default:
            $coinDenom = .999;
    }
    return $coinDenom;
}

?>