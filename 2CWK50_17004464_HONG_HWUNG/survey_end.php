<?php
// database connection details:
require_once "header.php";
// create a completed message
echo <<<_END
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<h1> Thank you for completing the survey! </h1>
<div id='results'></div>
_END;
// declare some variables
$sID = $_GET['sID'];
$checkbox = array();
$answer = "";
$answer_val = "";
$errors = "";
// the user has just submitted the survey to try to call the answers.php API
// check if the user post the form post the form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Since I have named each input as their question ID
	// Looping through all questions of a certain survey ID will help me sort the answers into their questions
	// connect to database first
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	//Query to get question IDs and their type
	$query = "SELECT questionID, type FROM questions WHERE surveyID='$sID'";
	$result = mysqli_query($connection, $query);
	$n = mysqli_num_rows($result);
	if ($n > 0)
	{
		// Loop over every questionID
		for($i=0; $i<$n; $i++)
		{
			$row = mysqli_fetch_assoc($result);
			$type = $row['type'];
			$qID = $row['questionID'];
			
			// Check if there is any value post by this question ID
			if(!empty($_POST[$qID]))
			{
				if($type==1)
				{
					$checkbox = $_POST[$qID];
					// Convert array into string
					$answer = implode(", ",$checkbox);
				}
				else
				{
					$answer = $_POST[$qID];
					// SANITISATION
					$answer = sanitise($_POST[$qID], $connection);
					$answer_val = validateString($answer, 1, 128);
					$errors = $answer_val;
				}
				
				if ($errors==""){
				// execute the client request to the API using JQuery
				echo <<<_END
				<script>
				// wait for the script to load in the browser
				$(document).ready(function()
				{
					var request = {};
					request['answer'] = '$answer';
					request['qID'] = '$qID';
					// run the postJSON query, sending the values from the HTML form
					$.post('api/answers.php', request)
					.done(function(data) {
						// debug message to help during development:
						console.log('answers upload successful');
						$('#results').append("<b>Answers submitted to question ID</b>(" + request.qID+ ")<br>");
					})
					.fail(function(jqXHR) {
						// debug message to help during development:
						console.log('request returned failure, HTTP status code ' + jqXHR.status);
						$('#results').append("<b>Update failed</b> <br>");
					})
					.always(function() {
						// debug message to help during development:
						console.log('request completed');
					})
				});
				</script>
_END;
				}
			}
		}
	}
}
// we're finished, close the connection:
mysqli_close($connection);
require_once "footer.php";
?>