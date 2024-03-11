<?php

// Things to notice:
// This file is the first one we will run when we mark your submission
// Its job is to: 
// Create your database (currently called "skeleton", see credentials.php)... 
// Create all the tables you will need inside your database (currently it makes a simple "users" table, you will probably need more and will want to expand fields in the users table to meet the assignment specification)... 
// Create suitable test data for each of those tables 
// NOTE: this last one is VERY IMPORTANT - you need to include test data that enables the markers to test all of your site's functionality
// Side note: mysql -h localhost -u root -p(command line to check DB)
// (24/12/2018) Note: Tried setting up FK but too many problems occur

// read in the details of our MySQL server:
require_once "credentials.php";
echo <<<_END
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<!--Provide a link to about.php-->
<div class="alert alert-primary" role="alert">
<h4 class="alert-heading">Welcome!</h4><hr>
Click <a href = about.php class="alert-link">here </a>to get redirected to home page.
</div>
_END;
// We'll use the procedural (rather than object oriented) mysqli calls

// connect to the host:
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);

// exit the script with a useful message if there was an error:
if (!$connection)
{
	die("Connection failed: " . $mysqli_connect_error);
}
  
// build a statement to create a new database:
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Database created successfully, or already exists<br>";
} 
else
{
	die("Error creating database: " . mysqli_error($connection));
}

// connect to our database:
mysqli_select_db($connection, $dbname);
//User table
$tableName = 'users';

// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS ". $tableName;

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Dropped existing table: ". $tableName ."<br>";
} 
else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}

// make our table:
$sql = "CREATE TABLE " . $tableName ." (username VARCHAR(16), password VARCHAR(16),firstname VARCHAR(32), lastname VARCHAR(64), email VARCHAR(64), dob DATE, telephone VARCHAR(16), PRIMARY KEY(username))";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: ". $tableName ."<br>";
}
else 
{
	die("Error creating table: " . mysqli_error($connection));
}

// put some data in our table:
$usernames[] = 'barrym'; $passwords[] = 'letmein'; $emails[] = 'barry@m-domain.com'; $firstname[] = ''; $lastname[] = ''; $dob[] = ''; $telephone[] = '';
$usernames[] = 'mandyb'; $passwords[] = 'abc123'; $emails[] = 'webmaster@mandy-g.co.uk'; $firstname[] = ''; $lastname[] = ''; $dob[] = ''; $telephone[] = '';
$usernames[] = 'timmy'; $passwords[] = 'secret95'; $emails[] = 'timmy@lassie.com'; $firstname[] = ''; $lastname[] = ''; $dob[] = ''; $telephone[] = '';
$usernames[] = 'briang'; $passwords[] = 'password'; $emails[] = 'brian@quahog.gov'; $firstname[] = ''; $lastname[] = ''; $dob[] = ''; $telephone[] = '';
//admin account
$usernames[] = 'admin'; $passwords[] = 'secret'; $emails[] = 'admin@kantoi.gg'; $firstname[] = 'Admin'; $lastname[] = 'Fett'; $dob[] = '2018-01-01'; $telephone[] = '07447185155';
//test accounts
$usernames[] = 'a'; $passwords[] = 'test'; $emails[] = 'a@alphabet.test.com'; $firstname[] = ''; $lastname[] = ''; $dob[] = ''; $telephone[] = '';
$usernames[] = 'b'; $passwords[] = 'test'; $emails[] = 'b@alphabet.test.com'; $firstname[] = ''; $lastname[] = ''; $dob[] = ''; $telephone[] = '';
$usernames[] = 'c'; $passwords[] = 'test'; $emails[] = 'c@alphabet.test.com'; $firstname[] = ''; $lastname[] = ''; $dob[] = ''; $telephone[] = '';
$usernames[] = 'd'; $passwords[] = 'test'; $emails[] = 'd@alphabet.test.com'; $firstname[] = ''; $lastname[] = ''; $dob[] = ''; $telephone[] = '';

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($usernames); $i++)
{
	$sql = "INSERT INTO ". $tableName . "(username, password, firstname, lastname, email, dob, telephone) VALUES ('$usernames[$i]', '$passwords[$i]', '$firstname[$i]', '$lastname[$i]', '$emails[$i]', '$dob[$i]', '$telephone[$i]')";
	
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}
	else 
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

//Survey list table
$tableName = 'surveys';
//Drop existing survey table
$sql = "DROP TABLE IF EXISTS ". $tableName;
//To check if the dropping successful or not
if (mysqli_query($connection, $sql)) 
{
	echo "Dropped existing table: ". $tableName ."<br>";
} 
else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}
//Query for generating table
$sql = "CREATE TABLE " . $tableName ." (surveyID VARCHAR(2), title VARCHAR(64), username VARCHAR(16), PRIMARY KEY(surveyID))";
//Check the query working or not
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: ". $tableName ."<br>";
}
else 
{
	die("Error creating table: " . mysqli_error($connection));
}
//Insert some test data
$surveyID[] = '1'; $title[] = 'test'; $username[] = 'barrym';
$surveyID[] = '2'; $title[] = 'test'; $username[] = 'mandyb';
$surveyID[] = '3'; $title[] = 'test'; $username[] = 'a';
$surveyID[] = '4'; $title[] = 'test'; $username[] = 'b';
$surveyID[] = '5'; $title[] = 'Feedbacks'; $username[] = 'admin';
// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($surveyID); $i++)
{
	$sql = "INSERT INTO ". $tableName . "(surveyID, title, username) VALUES ('$surveyID[$i]', '$title[$i]', '$usernames[$i]')";
	
	//Just another test
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}
	else 
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

//Question table
$tableName = 'questions';
//Drop existing survey data table
$sql = "DROP TABLE IF EXISTS ". $tableName;
//To check if the dropping successful or not
if (mysqli_query($connection, $sql)) 
{
	echo "Dropped existing table: ". $tableName ."<br>";
} 
else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}
//Query for generating table
$sql = "CREATE TABLE " . $tableName ." (questionID VARCHAR(16),surveyID VARCHAR(2), text VARCHAR(128), type VARCHAR(16), PRIMARY KEY(questionID))";
//Check the query working or not
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: ". $tableName ."<br>";
}
else 
{
	die("Error creating table: " . mysqli_error($connection));
}
//Insert some test data
//checkboxes = 1, drop-down = 2, radio = 3, slider = 4, text = 5
$questionID[] = '5001'; $sID[] = '5'; $qtext[] = 'Type something in the text box please.'; $type[] = '5';
$questionID[] = '5002'; $sID[] = '5'; $qtext[] = 'How old are you?'; $type[] = '2';
$questionID[] = '5003'; $sID[] = '5'; $qtext[] = 'What is your gender?'; $type[] = '3';
$questionID[] = '5004'; $sID[] = '5'; $qtext[] = 'Day/days that you enjoy.'; $type[] = '1';
$questionID[] = '5005'; $sID[] = '5'; $qtext[] = 'Do you like this survey?'; $type[] = '4';
// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($questionID); $i++)
{
	$sql = "INSERT INTO ". $tableName . "(questionID, surveyID, text, type) VALUES ('$questionID[$i]', '$sID[$i]', '$qtext[$i]', '$type[$i]')";
	
	//Just another test
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}
	else 
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

//Preset answer table
$tableName = 'preset_answers';
//Drop existing table
$sql = "DROP TABLE IF EXISTS ". $tableName;
//To check if the dropping successful or not
if (mysqli_query($connection, $sql)) 
{
	echo "Dropped existing table: ". $tableName ."<br>";
} 
else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}
//Query for generating table
$sql = "CREATE TABLE " . $tableName ." (presetID VARCHAR(16), questionID VARCHAR(16), text VARCHAR(128), PRIMARY KEY(presetID))";
//Check the query working or not
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: ". $tableName ."<br>";
}
else 
{
	die("Error creating table: " . mysqli_error($connection));
}
//Insert some test data
$presetID[] = '1'; $qID[] = '5001'; $ptext[] = 'Please type in here...';
$presetID[] = '2'; $qID[] = '5002'; $ptext[] = 'Under 18';
$presetID[] = '10'; $qID[] = '5002'; $ptext[] = 'Above 18';
$presetID[] = '3'; $qID[] = '5003'; $ptext[] = 'Male';
$presetID[] = '4'; $qID[] = '5003'; $ptext[] = 'Female';
$presetID[] = '5'; $qID[] = '5003'; $ptext[] = 'Others';
$presetID[] = '6'; $qID[] = '5004'; $ptext[] = 'Yesterday';
$presetID[] = '7'; $qID[] = '5004'; $ptext[] = 'Today';
$presetID[] = '8'; $qID[] = '5004'; $ptext[] = 'Tomorrow';
$presetID[] = '9'; $qID[] = '5005'; $ptext[] = '5';
// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($ptext); $i++)
{
	$sql = "INSERT INTO ". $tableName . "(presetID, questionID, text) VALUES ('$presetID[$i]', '$qID[$i]', '$ptext[$i]')";
	
	//Just another test
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}
	else 
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

//Answer table
$tableName = 'answers';
//Drop existing table
$sql = "DROP TABLE IF EXISTS ". $tableName;
//To check if the dropping successful or not
if (mysqli_query($connection, $sql)) 
{
	echo "Dropped existing table: ". $tableName ."<br>";
} 
else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}
//Query for generating table
$sql = "CREATE TABLE " . $tableName ." (answerID int AUTO_INCREMENT, questionID VARCHAR(16), text VARCHAR(128), count int, PRIMARY KEY(answerID))";
//Check the query working or not
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: ". $tableName ."<br>";
}
else 
{
	die("Error creating table: " . mysqli_error($connection));
}
//Insert some test data
$questionID[] = 'test'; $atext[] = 'test'; $count[] = '0';
// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($atext); $i++)
{
	$sql = "INSERT INTO ". $tableName . "(questionID, text, count) VALUES ('$questionID[$i]', '$atext[$i]', '$count[$i]')";
	
	//Just another test
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}
	else 
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

// we're finished, close the connection:
mysqli_close($connection);
?>