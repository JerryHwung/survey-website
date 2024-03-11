<?php
// header not required (api)
include_once "../credentials.php";
// Declare some variables to store values
$answers = "";
$qID = "";
$response = "";

if (empty($_POST))
{
	// set the kind of data we're sending back and an error response code:
    header("Content-Type: application/json", NULL, 400);
    // and send:
    echo json_encode($response);
    // and exit this script: meaning the rest of the PHP in the script won't be executed
    exit;
}
// If there is a post request, extract data from it
else
{
	$answer = $_POST['answer'];
	$qID = $_POST['qID'];
}
// connect directly to our database
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// connection failed, return an internal server error:
if (!$connection)
{
    // set the kind of data we're sending back and a failure code:
    header("Content-Type: application/json", NULL, 500);
    // and send:
    echo json_encode($response);
    // and exit this script:
    exit;
}
// First check is there a similar answer and question uploaded
$query = "SELECT * FROM answers WHERE questionID='$qID' AND text='$answer'";
$result = mysqli_query($connection, $query);
$n = mysqli_num_rows($result);
// if there is a similar row
if($n>0)
{
	$query2 = "UPDATE answers SET count=count+1 WHERE questionID='$qID' AND text='$answer'";
	$result2 = mysqli_query($connection, $query2);
	if ($result2)
	{
		// Did any row changes?
		if (mysqli_affected_rows($connection) == 1)
		{
			header("Content-Type: application/json", NULL, 201);
			$response = $qID;
		}
		else
		{
			header("Content-Type: application/json", NULL, 400);
		}
	}
	else
	{
		header("Content-Type: application/json", NULL, 400);
	}
}
else
{
	$query2 = "INSERT INTO answers (questionID, text, count) VALUES ('$qID', '$answer', '1')";
	$result2 = mysqli_query($connection, $query2);
	if ($result2)
	{
		// Did any row changes?
		if (mysqli_affected_rows($connection) == 1)
		{
			header("Content-Type: application/json", NULL, 201);
			$response = $qID;
		}
		else
		{
			header("Content-Type: application/json", NULL, 400);
		}
	}
	else
	{
		header("Content-Type: application/json", NULL, 400);
	}
}
// we're finished, close the connection:
mysqli_close($connection);
// and send:
echo json_encode($response);
?>