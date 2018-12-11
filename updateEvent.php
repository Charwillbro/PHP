<?php
session_start();
//Only allow a valid user access to this page
if ($_SESSION['validUser'] !== "yes") {
	header('Location: index.php');
}
		
	//Setup the variables used by the page
		//field data
		$event_title = "";
		$event_description = "";
		$event_city = "";
		$event_st = "";
		$event_email = "";
		$event_begin_date = "";
		$event_end_date = "";
		//error messages
		$titleErrMsg = "";
		$descriptionErrMsg = "";
		$cityErrMsg = "";
		$stErrMsg = "";
		$emailErrMsg = "";
		$beginDateErrMsg = "";
		$endDateErrMsg = "";
		
		$validForm = false;

		//mysql DATE stores data in a YYYY-MM-DD format
		$todaysDate = date("Y-m-d");		//use today's date as the default input to the date( )
		
		//The form needs to display the fields of the selected record
		$updateRecID = $_GET['recId'];	//Record Id to be updated
		//$updateRecId = 2;				//Hard code a key for testing purposes	
				
	if(isset($_POST["submit"]))
	{	
		//The form has been submitted and needs to be processed
		
		
		//Validate the form data here!
	
		//Get the name value pairs from the $_POST variable into PHP variables
		//This example uses PHP variables with the same name as the name atribute from the HTML form
		
		$event_title = $_POST['event_title'];
		$event_description = $_POST['event_description'];
		$event_city = $_POST['event_city'];
		$event_st = $_POST['event_st'];
		$event_email = $_POST['event_email'];
		$event_begin_date = $_POST['event_begin_date'];
		$event_end_date = $_POST['event_end_date'];		

		/*	FORM VALIDATION PLAN
		
			FIELD NAME		VALIDATION TESTS & VALID RESPONSES
			Event Title		Required Field		May not be empty
			Description				
			City			
			State			
			Email			Required Field		Format
			Begin Date		Required Field		Format
			End Date		Required Field		Format
		*/
		
		//VALIDATION FUNCTIONS		Use functions to contain the code for the field validations.  
			function validateTitle($inValue)
			{
				global $validForm, $titleErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
				$titleErrMsg = "";
				
				if($inValue == "")
				{
					$validForm = false;
					$titleErrMsg = "Name cannot be spaces";
				}
			}//end validateTitle()
			
			function validateDescription($inValue)
			{
				global $validForm, $descriptionErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
				$descriptionErrMsg = "";
				
				if($inValue == "")
				{
					$validForm = false;
					$descriptionErrMsg = "Name cannot be spaces";
				}
			}//end validateDescription()
		
			function validateCity($inValue)
			{
				global $validForm, $cityErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
				$cityErrMsg = "";
				
				if($inValue == "")
				{
					$validForm = false;
					$cityErrMsg = "Name cannot be spaces";
				}
			}//end validateCity()	
			
			function validateSt($inValue)
			{
				global $validForm, $stErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
				$stErrMsg = "";
				
				if($inValue == "")
				{
					$validForm = false;
					$stErrMsg = "Name cannot be spaces";
				}
			}//end validateSt()			
					
			function validateEmail()
			{
				global $validForm, $emailErrMsg, $event_email;	//Use the GLOBAL Version of these variables instead of making them local
				$emailErrMsg = "";								//Clear the error message. 
				
				// Remove all illegal characters from email
				$event_email = filter_var($event_email, FILTER_SANITIZE_EMAIL);

				// Validate e-mail
				$event_email = filter_var($event_email, FILTER_VALIDATE_EMAIL);

				if($event_email === false)
				{
					$validForm = false;
					$emailErrMsg = "Invalid email"; 					
				}
			}//end validateEmail()		
		
		//VALIDATE FORM DATA  using functions defined above
		$validForm = true;		//switch for keeping track of any form validation errors
		
		validateTitle($event_title);
		validateDescription($event_description);
		validateCity($event_city);
		validateSt($event_st);
		validateEmail($event_email);
		
		if($validForm)
		{
			$message = "All good";	
			
			try {
				
				require 'database/connectPDO.php';	//CONNECT to the database
				
				//Create the SQL command string
				$sql = "UPDATE pit_events SET ";
				$sql .= "event_title='$event_title', ";
				$sql .= "event_description='$event_description', ";
				$sql .= "event_city='$event_city', ";
				$sql .= "event_st='$event_st', ";
				$sql .= "event_email='$event_email', ";
				$sql .= "event_begin_date='$event_begin_date', ";
				$sql .= "event_end_date='$event_end_date', ";								
				$sql .= "event_setup_date='$todaysDate' "; //Last column does NOT have a comma after it.
				$sql .= "WHERE event_id='$updateRecID'";
				
				//PREPARE the SQL statement
				$stmt = $conn->prepare($sql);
				
				//BIND the values to the input parameters of the prepared statement
				/*
				$stmt->bindParam(':title', $event_title);
				$stmt->bindParam(':description', $event_description);				
				$stmt->bindParam(':city', $event_city);	
				$stmt->bindParam(':st', $event_st);
				$stmt->bindParam(':email', $event_email);				
				$stmt->bindParam(':beginDate', $event_begin_date);	
				$stmt->bindParam(':endDate',$event_end_date);				
				$stmt->bindParam(':setupDate',$todaysDate);
				*/
				
				//EXECUTE the prepared statement
				$stmt->execute();	
				
				$message = "The Event has been Updated.";
			}
			
			catch(PDOException $e)
			{
				$message = "There has been a problem. The system administrator has been contacted. Please try again later.";
	
				error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
				error_log(var_dump(debug_backtrace()));
			
				//Clean up any variables or connections that have been left hanging by this error.		
			
				header('Location: files/505_error_response_page.php');	//sends control to a User friendly page					
			}

		}
		else
		{
			$message = "Something went wrong";
		}//ends check for valid form		

	}
	else
	{
		//Form has not been seen by the user.  display the form with the selected event information	
		try {
		  
		  require 'database/connectPDO.php';	//CONNECT to the database
		  
		  //mysql DATE stores data in a YYYY-MM-DD format
		  $todaysDate = date("Y-m-d");		//use today's date as the default input to the date( )
		  
		  //Create the SQL command string
		  $sql = "SELECT ";
		  $sql .= "event_title, ";
		  $sql .= "event_description, ";
		  $sql .= "event_city, ";
		  $sql .= "event_st, ";
		  $sql .= "event_email, ";
		  $sql .= "event_begin_date, ";
		  $sql .= "event_end_date, ";	  	  
		  $sql .= "event_setup_date "; //Last column does NOT have a comma after it.
		  $sql .= "FROM pit_events ";
		  $sql .= "WHERE event_id=$updateRecID";
		  
		  //PREPARE the SQL statement
		  $stmt = $conn->prepare($sql);
		  
		  //EXECUTE the prepared statement
		  $stmt->execute();		
		  
		  //RESULT object contains an associative array
		  $stmt->setFetchMode(PDO::FETCH_ASSOC);	
		  
		  $row=$stmt->fetch(PDO::FETCH_ASSOC);	 
				
			$event_title=$row['event_title'];
			$event_description=$row['event_description'];
			$event_city=$row['event_city'];
			$event_st=$row['event_st'];
			$event_email=$row['event_email'];
			$event_begin_date=$row['event_begin_date'];
			$event_end_date=$row['event_end_date'];					
				 
	  }
	  
	  catch(PDOException $e)
	  {
		  $message = "There has been a problem. The system administrator has been contacted. Please try again later.";
	
		  error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
		  error_log($e->getLine());
		  error_log(var_dump(debug_backtrace()));
	  
		  //Clean up any variables or connections that have been left hanging by this error.		
	  
		  header('Location: files/505_error_response_page.php');	//sends control to a User friendly page					
	  }	
		
	}// ends if submit 
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Presenting Information Technology</title>
	<link rel="stylesheet" href="css/pit.css">  
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>    

	<script>
		$(function() {
			$('#event_begin_date').datepicker({dateFormat: "yy-mm-dd"});	//set datepicker format to yyyy-mm-dd to match database expected format
		} );
		
		$(function() {
			$('#event_end_date').datepicker({dateFormat: "yy-mm-dd"});		//set datepicker format to yyyy-mm-dd to match database expected format
		} );		
		
	</script>

    <script>
		function clearForm() {
			//alert("inside clearForm()");
			$('.errMsg').html("");					//Clear all span elements that have a class of 'errMsg'. 		
			$('input:text').removeAttr('value');	//REMOVE the value attribute supplied by PHP Validations
			$('textarea').html("");					//Clear the textarea innerHTML
		}
	</script>


</head>

<body>

<div id="container">

	<header>
    	<h1>Presenting Information Technology</h1>
    </header>
    
    <nav>
    
    	<ul>
        	<li><a href="index.html">Home</a></li>
            <li><a href="#">Presentations</a></li>
            <li><a href="displayPresenters.php">Presenters</a></li>
            <li><a href="addPresenter.php">Add Presenter</a></li>
        	<li><a href="#">Sign On</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
    	<div class="clearFloat"></div>
    
    </nav>
    
    <main>
    
        <h1>Setup a new Event</h1>
		<?php
            //If the form was submitted and valid and properly put into database display the INSERT result message
			if($validForm)
			{
        ?>
      <h1><?php echo $message ?></h1>
        
        <?php
			}
			else	//display form
			{
        ?>
        <form id="updateEventForm" name="updateEventForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?recId=$updateRecID"; ?>">
        	<fieldset>
              <legend>New Event</legend>
              <p>
                <label for="event_title">Event Title: </label>
                <input type="text" name="event_title" id="event_title" value="<?php echo $event_title;  ?>" /> 
                <span class="errMsg"> <?php echo $titleErrMsg; ?></span>
              </p>
              <p>
                <label for="event_description">Event Description:</label>
                  <textarea name="event_description" id="event_description" maxlength="700"><?php echo $event_description; ?></textarea>
                <span class="errMsg"><?php echo $descriptionErrMsg; ?></span>                
              </p>
              <p>
                <label for="event_city">City: </label>
                <input type="text" name="event_city" id="event_city" value="<?php echo $event_city;  ?>" />
                <span class="errMsg"><?php echo $cityErrMsg; ?></span>                      
              </p>
              <p>
                <label for="event_st">State: </label> 
                <input type="text" name="event_st" id="event_st" value="<?php echo $event_st;  ?>"/>
                <span class="errMsg"><?php echo $stErrMsg; ?></span>      
              </p>
              <p>
                <label for="event_email">Event Email: </label> 
                <input type="text" name="event_email" id="event_email" value="<?php echo $event_email;  ?>"/>
                <span class="errMsg"><?php echo $emailErrMsg; ?></span>                
              </p>
              <p>
                <label for="event_begin_date">Begin Date:</label>
                  <input type="text" name="event_begin_date" id="event_begin_date" required value="<?php echo $event_begin_date; ?>">
              </p>
              <p>
                <label for="event_end_date">End Date:</label>   
                  <input type="text" name="event_end_date" id="event_end_date" required value="<?php echo $event_end_date; ?>">
              </p>   
                       
              
          </fieldset>
         	<p>
            	<input type="submit" name="submit" id="submit" value="Add Event" />
            	<input type="reset" name="button2" id="button2" value="Clear Form" onClick="clearForm()" />
        	</p>  
      </form>
        <?php
			}//end else
        ?>    	
	</main>
    
	<footer>
    	<p>Copyright &copy; <script> var d = new Date(); document.write (d.getFullYear());</script> All Rights Reserved</p>
    
    </footer>



</div>
</body>
</html>
