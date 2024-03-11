<?php
// this page redirected from surveys_manage.php to view a particular user's survey
// execute the header script:
require_once "header.php";
// a tester for trying out the nested query(?)
// Connect to db first
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// If connection fail
if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
    }

$query = "SELECT * FROM surveys WHERE surveyID = 5";
$result = mysqli_query($connection, $query);
$n = mysqli_num_rows($result);
if ($n > 0)
	{
		// use the identifier to fetch one row as an associative array:
		$row = mysqli_fetch_assoc($result);
		// extract the data for use in the HTML:
		$surveyID = $row['surveyID'];
		$title = $row['title'];
		$username = $row['username'];

	// Start 1st layer query
	$q1 = "SELECT * FROM questions WHERE surveyID = 5";
	$r1 = mysqli_query($connection, $q1);
	for($i=0; $i<mysqli_num_rows($r1); $i++)
	{
		$row = mysqli_fetch_assoc($r1);
		$type = $row['type'];
		$questionNum = $i+1;
		echo "<h3>Q" . $questionNum . " | ";
		echo "{$row['text']}";
		echo "<select name='surveyType'>";
		echo "<option value='' "; if($type==null){echo"selected";} echo">Select...</option>";
		echo "<option value='1' "; if($type==1){echo"selected";} echo">Checkboxes</option>";
		echo "<option value='2' "; if($type==2){echo"selected";} echo">Drop-down list</option>";
		echo "<option value='3' "; if($type==3){echo"selected";} echo">Radio buttons</option>";
		echo "<option value='4' "; if($type==4){echo"selected";} echo">Slider</option>";
		echo "<option value='5' "; if($type==5){echo"selected";} echo">Text box</option>";
		echo "</select></h3>";
		
		// Start 2nd query
		$q2 = "SELECT presetID, text FROM preset_answers WHERE questionID = {$row['questionID']}";
		$r2 = mysqli_query($connection, $q2);
		switch($type){
			case "1":
			for($j=0; $j<mysqli_num_rows($r2); $j++)
			{
				$row2 = mysqli_fetch_assoc($r2);
				echo "<input type='checkbox' name='{$row2['presetID']}' value='{$row2['text']}'>{$row2['text']}<br>";
			}	
			break;
			
			default:
			echo "No chosen type.";
		}
	
	}
	}
require_once "footer.php";
?>