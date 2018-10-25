<?php

function validateProdValue( $inValue ) {
	//cannot be empty
	
	if( empty($inValue) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
}//end validateProdName()

function validateProdPrice( $inPrice) {
	//cannot be empty
	//must be numeric
	//must be greater than zero
	
	if( empty($inPrice) ) {
		return false;	//Failed validation
	}
	else {
		if( is_numeric($inPrice) && ($inPrice > 0) ){
			return true;		//Passes validation	
		}
		else {
			return false;	
		}
	}		
}//end validatePrice

function validateProdDenomination( $inDenomination) {
	//must select a color
	if( empty($inDenomination) ) {
		return false;
	}
	else {
		return true;	
	}
	
	
}//end validateProdColor()


function validateProdWagon( $inWagon ) {
	//must select a wagon
	//echo "<h1>validate Wagon </h1>";
	//echo "<h1>inWagon $inWagon </h1>";
	if( $inWagon == "select" )	{
		echo "<h1> wagon Validation returning false </h1>";
		return false;	
	}
	else {
			echo "<h1>Wagon validation returning true </h1>";
		return true;	
	}
	
}//end validateProdSize()
?>