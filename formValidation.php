<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 10/2/2018
 * Time: 1:48 PM
 */

function validateProdName($inName){
    //name field cannot be empty
    if(empty($inName) ){ //checks if the name variable is empty
        return false; //fails validation
    }else{
        return true; //passes validation
    }
}

?>