var copyrightDate = new Date().getFullYear(); //get copyright information

function resetForm() {
    alert("inside resetForm()");
}

function validateMyForm() { //this function checks the honeypot field(s) to see if a robot tried to fill out the form
    // The field is empty, submit the form.
    // causes some problem in a self posting form when the page form is not displayed. It seems the problem stems from the fact There is no object named 'keyboardType' or 'kitty' to find
    if (!document.getElementById("keyboardType").value && !document.getElementById("midName").value) {
        return true;
    }
    // the field has a value it's a spam bot
    else {
        //do nothing
        return false;
    }
}

// The logout function redirects a user to the logout page where their session is destroyed
// and the validUser session variable is also set to false.
function logoutUser() {
    location.href = "logoutUser.php";
}


