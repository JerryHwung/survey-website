<?php
// Have to include crdentials first
include_once "../credentials.php";
// Declare some variables to store data
$thisRow = array();
$allRows = array();

if(!isset($_GET['qID']))
{
	header("Content-Type: application/json", NULL, 400);
	echo json_encode($allRows);
	exit;
}else{
	$qID = $_GET['qID'];
}
// Connect to database
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Connection checking
if(!$connection)
{
	header("Content-Type: application/json", NULL, 500);
	echo json_encode($allRows);
	exit;
}
// Query for getting results
$query="SELECT text, count FROM answers WHERE questionID='$qID'";
// Store returned data
$result = mysqli_query($connection, $query);
// Number of rows returned
$n = mysqli_num_rows($result);

if ($n > 0)
{
	for ($i=0; $i<$n; $i++)
	{
		// Fetch one row as an associative array
		$thisRow = mysqli_fetch_assoc($result);
		// Add it to the array we will send back
		$allRows[] = $thisRow;
	}
}
// we're finished with the database, close the connection:
mysqli_close($connection);

// set the kind of data we're sending back and a success code:
header("Content-Type: application/json", NULL, 200);

// and send - packed up as JSON:
echo json_encode($allRows);

?>