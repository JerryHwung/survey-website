<?php

// Things to notice:
// The main job of this script is to end the user's session
// Meaning we want to destroy the current session data

// execute the header script:
require_once "header.php";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "<p class='mt-5'>You must be logged in to view this page.</p>";
}
else
{
	// user just clicked to logout, so destroy the session data:
	// first clear the session superglobal array:
	$_SESSION = array();
	// then the cookie that holds the session ID:
	setcookie(session_name(), "", time() - 2592000, '/');
	// then the session data on the server:
	session_destroy();

	echo "<p class='mt-5'>You have successfully logged out, please <a href='sign_in.php'>click here</a></p>";
}

// finish of the HTML for this page:
require_once "footer.php";

?>