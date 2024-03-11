<?php
// Have to include crdentials first
include_once "../credentials.php";

// Declare some variables to store data
$thisRow = array();
$allRows = array();

if(!isset($_GET['surveyID']))
{
	header("Content-Type: application/json", NULL, 400);
	echo json_encode($allRows);
	exit;
}
else
{
	$sID = $_GET['surveyID'];
}
// Connect to database
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$connection)
{
	header("Content-Type: application/json", NULL, 500);
	echo json_encode($allRows);
	exit;
}
// Query to find details about the survey
$query = "SELECT questionID, text, type FROM questions WHERE surveyID='$sID'";
$result = mysqli_query($connection, $query);
$n = mysqli_num_rows($result);
// If there's any match in database
if ($n>0)
{
	// loop over all rows, adding them into our array:
	for ($i=0; $i<$n; $i++)
	{
		$thisRow = mysqli_fetch_assoc($result);
		$allRows[] = $thisRow;
	}
}
else {
	header("Content-Type: application/json", NULL, 404);
	echo json_encode($allRows);
	exit;
}
// We're done, disconnect it
mysqli_close($connection);
// set the kind of data we're sending back and a success code:
header("Content-Type: application/json", NULL, 200);
// and send - packed up as JSON:
echo json_encode($allRows);

?>