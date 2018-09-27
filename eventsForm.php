<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 9/18/2018
 * Time: 2:36 PM
 */

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Events Form</title>

    <!-- //This is a date function that is used because the date form type is not supported by safari -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker();
        } );
    </script>
</head>

<body>
<h1>Inserting Data into a Database</h1>

<p>When this page is run, a user can input event data to a database via this form. <br> WDV 341 </p>

<form id="form1" name="form1" method="post" action="insertForm.php" onsubmit="return validateMyForm();">

    <p>Event Name:
        <input type="text" name="event_name" id="event_name" />
    </p>

    <p>Event Description:
        <input type="text" name="event_description" id="event_description" size="50"/>
    </p>

    <p>Event Presenter:
        <input type="text" name="event_presenter" id="event_presenter" />
    </p>

    <p>Event Date:
        <input type="date" name="event_date" id="event_date" />
    </p>

    <p>Event Time:
        <input type="time" name="event_time" id="event_time" />
    </p>

    <div style="display:none;">
        <label>Keep this field blank</label>
        <input type="text" name="honeypot" id="honeypot" />
    </div>
    <!-- buttons: reset and submit-->
    <p>
        <input type="submit" name="button" id="button" value="Submit" />
        <input type="reset" name="button2" id="button2" value="Reset" />
    </p>
</form>

<script type="text/javascript">
    function validateMyForm() {
        // The field is empty, submit the form.
        if(!document.getElementById("honeypot").value) {
            return true;
        }
        // the field has a value it's a spam bot
        else {
            return false;
        }
    }
</script>

</body>
</html>
