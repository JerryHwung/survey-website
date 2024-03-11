<?php
// This page can be access thru a link
// Note: this code has two <script>s, the 1st generates questions and the 2nd generates preset answers 
// Note: because both getJSONs starts to operate when the document is ready so sometimes the presets are not shown after refreshes
// execute the header script:
require_once "header.php";
// extract the survey ID sent by last page
$sID = $_GET['sID'];
// create the basic HTML and form on the page
echo <<<_END
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <h2><b>This is a sample survey</b></h2>
 <br>
 <form name="survey" action="survey_end.php?sID=$sID" method="post">
 <div id="test">
 </div>
 <input type=submit value="Submit">
</form>

<script>
// wait for the script to load in the browser
// this is the 1st part (questions)
$(document).ready(function()
{
	// run the getJSON query, sending the surveyID from this page
	$.getJSON('api/questions.php', {surveyID: '$sID'})
	.done(function(data) {
		// debug message
		console.log('questions request successful');
		// loop through what we got and add it to the form
		$.each(data, function(index, question) {
			// show the result from the API in the field named 'test' in the page HTML
			// Make question's index starts from 1
			index = index+1;
			// print out questions in a <div> with an id called "test"
			$('#test').append("<h3>Q"+index+". "+question.text+"</h3>");
			// create a div for preset answers to fill in
			$('#test').append("<div id='"+question.questionID+"'></div>");
		});
	})
	// if failed
	.fail(function(jqXHR) {
		console.log('request returned failure, HTTP status code ' + jqXHR.status);
		$('#test').append("<b>Questions not found</b> <br>");
	})
	// always do this no matter failed or successed
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
		// this is the 2nd part (preset answers)
		$(document).ready(function()
		{
			// perform getJSON and send question ID to get preset answers
			$.getJSON('api/presets.php', {qID: '$qID'})
			.done(function(data) {
				console.log('preset request successful');
				switch($type)
				{
					case 1:
					$.each(data, function(index, preset){
						$('#'+$qID).append("<input type='checkbox' value='"+preset.text+"' name='"+preset.questionID+"[]'>"+preset.text+"<br>");
					});
					break;
					case 2:
					$('#'+$qID).append("<select name='"+$qID+"'></select>");
					$.each(data, function(index, preset){
						$('select').append("<option value='"+preset.text+"'>"+preset.text+"</option><br>");
					});
					break;
					case 3:
					$.each(data, function(index, preset){
						$('#'+$qID).append("<input type='radio' name='"+preset.questionID+"' value='"+preset.text+"'>"+preset.text+"<br>");
					});
					break;
					case 4:
					$.each(data, function(index, preset){
						var avg = (1+preset.text)/2;
						$('#'+$qID).append(" 1 <input type='range' name='"+preset.questionID+"' min='1' max='"+preset.text+"'value='avg' class='slider' id='"+preset.presetID+"'>"+preset.text);
					});
					break;
					case 5:
					$.each(data, function(index, preset) {
						$('#'+$qID).append("<textarea name='"+preset.questionID+"' rows='4' cols='50' placeholder='"+preset.text+"'></textarea><br>");
					});
					break;
					default:
					$('#'+$qID).append("Ooops, no preset answers found<br>");
				}
			})
			.fail(function(jqXHR) {
				console.log('request returned failure, HTTP status code ' + jqXHR.status);
				$('#'+$qID).append("<b>Questions not found</b> <br>");
			})
			.always(function() {
				console.log('request completed');
			});
		});
		</script>
_END;
		
	}
}
// we're finished, close the connection:
mysqli_close($connection);
// execute the footer script:
require_once "footer.php";
?>