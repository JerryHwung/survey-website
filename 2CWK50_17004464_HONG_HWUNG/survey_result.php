<?php
// execute the header script:
require_once "header.php";
// check if the user is logged in
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "<p class='mt-5'>You must be logged in to view this page.</p>";
}
else
{
	// admin can see others' surveys results
	if ($_SESSION['username'] == "admin")
	{
		// Find out which survey to look for
		$sID = $_GET['survey'];
		// create the basic HTML and table on the page
		echo <<<_END
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<h1><b>Results and Analysis</b></h1>
		<br>
		<div id="results"></div>
		<!--extract questions from database by API(questions.php)-->
		<script>
		// wait for the script to load in the browser
		$(document).ready(function()
		{
			// run the getJSON query, sending the surveyID from this page
			$.getJSON('api/questions.php', {surveyID: '$sID'})
			.done(function(data) {
				console.log('questions request successful');
				// loop through what we got and add it to the div
				$.each(data, function(index, question) {
					// Make question's index starts from 1
					index = index+1;
					$('#results').append("<h3>Q"+index+". "+question.text+"</h3>");
					// create a unique table for each question
					$('#results').append("<table class='table table-hover text-center w-25 p-3' id='"+question.questionID+"'></table>");
					$('#results').append("<a href='survey_result_chart.php?qID="+question.questionID+"'>Show graphs</a>");
				});
			})
			.fail(function(jqXHR) {
				console.log('request returned failure, HTTP status code ' + jqXHR.status);S
				$('#results').append("<b>Questions not found</b> <br>");
			})
			.always(function() {
				console.log('request completed');
			});
		});
		</script>
_END;
		// connect to database to get question IDs
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		if (!$connection)
		{
			die("Connection failed: " . $mysqli_connect_error);
		}
		//Query to get question IDs
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
				echo <<<_END
				<script>
				// get results by API (results.php)
				$(document).ready(function()
				{
					$.getJSON('api/results.php', {qID: '$qID'})
					.done(function(data) {
						console.log('result request successful');
						$('#'+$qID).append("<thead class='thead-dark'><tr><th>Answer</th><th>Count</th></tr></thead>");
						$.each(data, function(index, answer){
							$('#'+$qID).append("<tr><td>"+answer.text+"</td><td>"+answer.count+"</td></tr>");
						});
					})
					.fail(function(jqXHR) {
						console.log('request returned failure, HTTP status code ' + jqXHR.status);
						$('#'+$qID).append("<b>Results not found</b> <br>");
					})
					.always(function() {
						console.log('request completed');
					});
				});
				</script>
_END;
			}
		}
	}
}

require_once "footer.php";
?>