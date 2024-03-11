<?php
require_once "header.php";
$show_delete_confirmation = false;
//default value of username
$username = "";
// message to output to user:
$message = "";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "<p class='mt-5'>You must be logged in to view this page.</p>";
}
elseif (isset($_POST['username']))
{
	// admin just tried to delete this profile
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	//check this user exist in database or not
	$query = "SELECT * FROM users WHERE username='$_GET[user]'";
	$result = mysqli_query($connection, $query);
	$n = mysqli_num_rows($result);
	//if yes, delete it
	if ($n > 0)
	{
		// query to delete
		$query = " DELETE FROM users WHERE username='$_GET[user]'";
		$result = mysqli_query($connection, $query);		
	}
	
	if ($result) 
	{
		// show a successful update message:
		$message = "<p class='mt-5'>Account successfully deleted</p>";
	} 
	else
	{
		// show an unsuccessful update message:
		$message = "<p class='mt-5'>Delete failed, it seems like this account does not exist.</p>";
	}
}
elseif(isset($_POST['surveyID']))
{
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	//check this user exist in database or not
	$query = "SELECT * FROM surveys WHERE surveyID='$_GET[survey]'";
	$result = mysqli_query($connection, $query);
	$n = mysqli_num_rows($result);
	//if yes, delete it
	if ($n > 0)
	{
		// query to delete
		$query = " DELETE FROM surveys WHERE surveyID='$_GET[survey]'";
		$result = mysqli_query($connection, $query);		
	}
	
	if ($result) 
	{
		// show a successful update message:
		$message = "<p class='mt-5'>Survey successfully deleted</p>";
	} 
	else
	{
		// show an unsuccessful update message:
		$message = "<p class='mt-5'>Delete failed, it seems like this survey does not exist.</p>";
	}
}
else
{
	if ($_SESSION['username'] == "admin")
	{
		$show_delete_confirmation = true;
	}
	else
	{
		echo "<p class='mt-5'>You don't have permission to view this page...</p>";
	}
}

if ($show_delete_confirmation && !empty($_GET['user']))
{
echo <<<_END
<h1 class="mt-5">Delete Confirmation</h1>
<form action="delete.php?user=$_GET[user]" method="post">
  Username: $_GET[user]
  <br>
  <input type="hidden" name="username" value="$_GET[user]">
  Are you sure you want to delete this account?
  <br>
  <input type="submit" value="Yes">
  <a href= 'admin.php'>Cancel</a>
</form>	
_END;
}
if ($show_delete_confirmation && !empty($_GET['survey'])) 
{
	echo <<<_END
<h1 class="mt-5">Delete Confirmation</h1>
<form action="delete.php?survey=$_GET[survey]" method="post">
  Survey ID: $_GET[survey]
  <br>
  <input type="hidden" name="surveyID" value="$_GET[survey]">
  Are you sure you want to delete this survey?
  <br>
  <input type="submit" value="Yes">
  <a href= 'surveys_manage.php'>Cancel</a>
</form>	
_END;
}

echo $message;

// finish of the HTML for this page:
require_once "footer.php";
?>