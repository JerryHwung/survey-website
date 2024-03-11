<?php
//this page redirected from admin.php to view a particular user's profile
// execute the header script:
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

$show_profile_form = false;
// message to output to user:
$message = "";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "<p class='mt-5'>You must be logged in to view this page.</p>";
}
elseif (isset($_POST['email']))
{
	// admin just tried to update this profile
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	//SANITISATION
	$password = sanitise($_POST['password'], $connection);
	$email = sanitise($_POST['email'], $connection);
	$firstname = sanitise($_POST['firstname'], $connection);
	$lastname = sanitise($_POST['lastname'], $connection);
	$dob = sanitise($_POST['dob'], $connection);
	$telephone = sanitise($_POST['telephone'], $connection);
	//SERVER-SIDE VALIDATION
	$password_val = validateString($firstname, 1, 32);
	$email_val = validateEmail($email);
	$firstname_val = validateString($firstname, 1, 32);
	$lastname_val = validateString($lastname,1,64);
	$dob_val = validateDate($dob);
	$telephone_val = validateTel($telephone,1,16);
	
	$errors = $password_val . $email_val . $firstname_val . $lastname_val . $dob_val . $telephone_val;
	
	if ($errors == "")
	{
		//check this user exist in database or not
		$query = "SELECT * FROM users WHERE username='$_GET[user]'";
		$result = mysqli_query($connection, $query);
		$n = mysqli_num_rows($result);
		//if yes, do the update
		if ($n > 0)
		{
			// we need an UPDATE:
			$query = "UPDATE users SET password='$password', email='$email', firstname='$firstname', lastname='$lastname', dob='$dob', telephone='$telephone' WHERE username='$_GET[user]'";
			$result = mysqli_query($connection, $query);		
		}
		
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
	// only display the page content if this is the admin account (all other users get a "you don't have permission..." message):
	if ($_SESSION['username'] == "admin")
	{
		//Connect to database first
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		//If connection fail
		 if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }
		
		//Query to search the particular profile
		$query = "SELECT * FROM users WHERE username = '$_GET[user]'";
		//Set returned data into $return
		$result = mysqli_query($connection, $query);
		$n = mysqli_num_rows($result);
		// if there was a match then extract their profile data:
		if ($n > 0)
		{
			// use the identifier to fetch one row as an associative array (elements named after columns):
			$row = mysqli_fetch_assoc($result);
			// extract their profile data for use in the HTML:
			$password = $row['password'];
			$email = $row['email'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$dob = $row['dob'];
			$telephone = $row['telephone'];
		}
		
		$show_profile_form = true;
		mysqli_close($connection);
		
	}
	else
	{
		echo "<p class='mt-5'>You don't have permission to view this page...</p>";
	}
}

if ($show_profile_form)
{
echo <<<_END
<h1 class="mt-5">{$_GET['user']}'s Account</h1>
<form action="view.php?user=$_GET[user]" method="post">
  Username: $_GET[user]
  <br>
  Password: <input type="text" name="password" maxlength="16" value="$password" required> $password_val
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
  <input type="submit" value="Edit">
</form>	
_END;
}

echo $message;

// finish of the HTML for this page:
require_once "footer.php";
?>