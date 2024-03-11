<?php

// Things to notice:
// This script is called by every other script (via require_once)
// It begins the HTML output, with the customary tags, that will produce each of the pages on the web site
// It starts the session and displays a different set of menu links depending on whether the user is logged in or not...
// ... And, if they are logged in, whether or not they are the admin
// It also reads in the credentials for our database connection from credentials.php

// database connection details:
require_once "credentials.php";

// our helper functions:
require_once "helper.php";

// start/restart the session:
session_start();

if (isset($_SESSION['loggedInSkeleton']))
{
	// THIS PERSON IS LOGGED IN
	// show the logged in menu options:

echo <<<_END
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<title>A Survey Website</title>
</head>
<body data-gr-c-s-loaded="true">
<header>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <!-- Navbar content -->
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
  <ul class="navbar-nav mr-auto">
	  <li class="nav-item">
        <a class="nav-link active" href="account.php">My Account</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link active" href="surveys_manage.php">My Surveys</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link active" href="competitors.php">Design and Analysis</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link active" href="sign_out.php">Sign Out ({$_SESSION['username']})</a>
      </li>
_END;
// add an extra menu option if this was the admin:
	if ($_SESSION['username'] == "admin")
	{
		echo <<<_END
	  <li class="nav-item">
	    <a class="nav-link active" href="admin.php">Admin Tools</a>
	  </li>
_END;
	}
echo <<<_END
	</ul>
</div>
</nav>
</header>
<!--page content-->
<main role="main" class = "container">
<style>
body > .container {
  padding: 60px 15px 0;
}
</style>

_END;
}
else
{
	// THIS PERSON IS NOT LOGGED IN
	// show the logged out menu options:
	
echo <<<_END
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<title>A Survey Website</title>
</head>
<body data-gr-c-s-loaded="true">
<header>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <!-- Navbar content -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
  <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</span></a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="sign_up.php">Sign Up</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="sign_in.php">Sign In</a>
      </li>
	</ul>
</div>
</nav>
</header>
<!--page content-->
<main role="main" class = "container">
<style>
body > .container {
  padding: 60px 15px 0;
}
</style>

_END;
}
?>