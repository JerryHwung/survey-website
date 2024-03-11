<?php

// Things to notice:
// This script will let a logged-in user VIEW their account details and allow them to UPDATE those details
// The main job of this script is to execute an INSERT or UPDATE statement to create or update a user's account information...
// ... but only once the data the user supplied has been validated on the client-side, and then sanitised ("cleaned") and validated again on the server-side
// It's your job to add these steps into the code
// Both sign_up.php and sign_in.php do client-side validation, followed by sanitisation and validation again on the server-side -- you may find it helpful to look at how they work 
// HTML5 can validate all the account data for you on the client-side
// The PHP functions in helper.php will allow you to sanitise the data on the server-side and validate *some* of the fields... 
// There are fields you will want to add to allow the user to update them...
// ... you'll also need to add some new PHP functions of your own to validate email addresses, telephone numbers and dates

// execute the header script:
require_once "header.php";

// default values we show in the form:
$email = "";
$firstname = "";
$lastname = "";
$dob = "";
$telephone = "";
    
// strings to hold any validation error messages:
$email_val = "";
$firstname_val = "";
$lastname_val = "";
$dob_val = "";
$telephone_val = "";
 
// should we show the set profile form?:
$show_account_form = false;
// message to output to user:
$message = "";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "<p class='mt-5'>You must be logged in to view this page.</p>";
}
elseif (isset($_POST['email']))
{
	// user just tried to update their profile
	
	// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	
	// SANITISATION CODE MISSING:
	
	// ...
	$email = sanitise($_POST['email'], $connection);
	$firstname = sanitise($_POST['firstname'], $connection);
	$lastname = sanitise($_POST['lastname'], $connection);
	$dob = sanitise($_POST['dob'], $connection);
	$telephone = sanitise($_POST['telephone'], $connection);

	
	// SERVER-SIDE VALIDATION CODE MISSING:
	
	// ...
	$email_val = validateEmail($email);
	$firstname_val = validateString($firstname, 1, 32);
	$lastname_val = validateString($lastname,1,64);
	$dob_val = validateDate($dob);
	$telephone_val = validateTel($telephone,1,16);
	
	$errors = $email_val . $firstname_val . $lastname_val . $dob_val . $telephone_val;
	
	// check that all the validation tests passed before going to the database:
	if ($errors == "")
	{		
		// read their username from the session:
		$username = $_SESSION["username"];
		
		// now write the new data to our database table...
		
		// check to see if this user is in the database:
		$query = "SELECT * FROM users WHERE username='$username'";
		
		// this query can return data ($result is an identifier):
		$result = mysqli_query($connection, $query);
		
		// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
		$n = mysqli_num_rows($result);
			
		// if there was a match then UPDATE their profile data, otherwise INSERT it:
		if ($n > 0)
		{
			// we need an UPDATE:
			$query = "UPDATE users SET email='$email', firstname='$firstname', lastname='$lastname', dob='$dob', telephone='$telephone' WHERE username='$username'";
			$result = mysqli_query($connection, $query);		
		}
	

		// no data returned, we just test for true(success)/false(failure):
		if ($result) 
		{
			// show a successful update message:
			$message = "Profile successfully updated<br>";
		} 
		else
		{
			// show the set profile form:
			$show_account_form = true;
			// show an unsuccessful update message:
			$message = "Update failed<br>";
		}
	}
	else
	{
		// validation failed, show the form again with guidance:
		$show_account_form = true;
		// show an unsuccessful update message:
		$message = "Update failed, please check the errors above and try again<br>";
	}
	
	// we're finished with the database, close the connection:
	mysqli_close($connection);

}
else
{
	// arrived at the page for the first time, show any data already in the table:
	
	// read the username from the session:
	$username = $_SESSION["username"];
	
	// now read their profile data from the table...
	
	// connect directly to our database (notice 4th argument):
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	
	// check for a row in our profiles table with a matching username:
	$query = "SELECT * FROM users WHERE username='$username'";
	
	// this query can return data ($result is an identifier):
	$result = mysqli_query($connection, $query);
	
	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	$n = mysqli_num_rows($result);
		
	// if there was a match then extract their profile data:
	if ($n > 0)
	{
		// use the identifier to fetch one row as an associative array (elements named after columns):
		$row = mysqli_fetch_assoc($result);
		// extract their profile data for use in the HTML:
		$email = $row['email'];
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$dob = $row['dob'];
		$telephone = $row['telephone'];
	}
	
	// show the set profile form:
	$show_account_form = true;
	
	// we're finished with the database, close the connection:
	mysqli_close($connection);
	
}

if ($show_account_form)
{
echo <<<_END
<h1 class="mt-5">Update Account</h1>
<form action="account_set.php" method="post">
  Update your profile info:<br>
  Username: {$_SESSION['username']}
  <br>
  Email address: <input type="email" name="email" maxlength="64" value="$email" required> $email_val
  <br>
  First Name: <input type="text" name="firstname" maxlength="32" value="$firstname" required> $firstname_val
  <br>
  Last Name: <input type="text" name="lastname" maxlength="64" value="$lastname" required> $lastname_val
  <br>
  Date of Birth: <input type="date" name="dob" value="$dob" required> $dob_val
  <br>
  Telephone Number: <input type="tel" name="telephone" value="$telephone" minlength="9" maxlength="16" required> $telephone_val
  <br>
  <input type="submit" value="Update">
</form>	
_END;
}

// display our message to the user:
echo $message;

// finish of the HTML for this page:
require_once "footer.php";
?>