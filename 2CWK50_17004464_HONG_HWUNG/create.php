<?php

require_once "header.php";
// default values we show in the form:
$username = "";
$password = "";
$email = "";
$firstname = "";
$lastname = "";
$dob = "";
$telephone = "";

// strings to hold any validation error messages:
$username_val = "";
$password_val = "";
$email_val = "";
$firstname_val = "";
$lastname_val = "";
$dob_val = "";
$telephone_val = "";

$show_create_form = false;
// message to output to user:
$message = "";
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "<p class='mt-5'>You must be logged in to view this page.</p>";
}
elseif (isset($_POST['username']))
{
	// admin just tried to create an account
	
	// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	// SANITISATION
	$username = sanitise($_POST['username'], $connection);
	$password = sanitise($_POST['password'], $connection);
    $email = sanitise($_POST['email'], $connection);
	$firstname = sanitise($_POST['firstname'], $connection);
	$lastname = sanitise($_POST['lastname'], $connection);
	$dob = sanitise($_POST['dob'], $connection);
	$telephone = sanitise($_POST['telephone'], $connection);
	
	$username_val = validateString($username, 1, 16);
	$password_val = validateString($password, 1, 16);
    $email_val = validateEmail($email);
	$firstname_val = validateString($firstname, 1, 32);
	$lastname_val = validateString($lastname,1,64);
	$dob_val = validateDate($dob);
	$telephone_val = validateTel($telephone,1,16);
	
	$errors = $username_val . $password_val . $email_val . $firstname_val . $lastname_val . $dob_val . $telephone_val;
	if ($errors == "")
	{
		
		// try to insert the new details:
		$query = "INSERT INTO users (username, password, email, firstname, lastname, dob, telephone) VALUES ('$username', '$password', '$email', '$firstname', '$lastname', '$dob', '$telephone');";
		$result = mysqli_query($connection, $query);
		
		// no data returned, we just test for true(success)/false(failure):
		if ($result) 
		{
			// show a successful signup message:
			$message = "<p class='mt-5'>Account created!</p>";
		} 
		else 
		{
			// show the form:
			$show_create_form = true;
			// show an unsuccessful signup message:
			$message = "<p class='mt-5'>Create failed, please try again</p>";
		}
			
	}
	else
	{
		// validation failed, show the form again with guidance:
		$show_create_form = true;
		// show an unsuccessful signin message:
		$message = "<p class='mt-5'>Create failed, please check the errors shown above and try again</p>";
	}
	
	// we're finished with the database, close the connection:
	mysqli_close($connection);
}
else
{
	if ($_SESSION['username'] == "admin")
	{
		// just a normal visit to the page, show the signup form:
		$show_create_form = true;
	}
	else
	{
		echo "<p class='mt-5'>You don't have permission to view this page...</p>";
	}
}

if ($show_create_form)
{
	echo <<<_END
<form class='mt-5' action="create.php" method="post">
  Please insert the following details:<br>
  Username: <input type="text" name="username" maxlength="16" value="$username" required> $username_val
  <br>
  Password: <input type="password" name="password" maxlength="16" value="$password" required> $password_val
  <br>
  Email: <input type="email" name="email" maxlength="64" value="$email" required> $email_val
  <br>
  First Name: <input type="text" name="firstname" maxlength="32" value="$firstname" required> $firstname_val
  <br>
  Last Name: <input type="text" name="lastname" maxlength="64" value="$lastname" required> $lastname_val
  <br>
  Date of Birth: <input type="date" name="dob" value="$dob" required> $dob_val
  <br>
  Telephone Number: <input type="tel" name="telephone" value="$telephone" minlength="9" maxlength="16" required> $telephone_val
  <br>
  <input type="submit" value="Create">
</form>	
_END;
}

echo $message;

require_once "footer.php";
?>