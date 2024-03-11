<?php
//this page redirected from surveys_manage.php to view a particular user's survey
// execute the header script:
require_once "header.php";

// default values we show:
$surveyID = "";
$title = "";
$username = "";
$questionNum = "";
$type = "";

// message to output to user:
$message = "";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "<p class='mt-5'>You must be logged in to view this page.</p>";
}
else
{
	//Connect to database first
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	//If connection fail
	if (!$connection)
    {
		die("Connection failed: " . $mysqli_connect_error);
    }
	//Query to search the particular profile
	$query = "SELECT * FROM surveys WHERE surveyID = '$_GET[survey]'";
	//Set returned data into $result
	$result = mysqli_query($connection, $query);
	$n = mysqli_num_rows($result);
	// if there was a match then extract the data:
	if ($n > 0)
	{
		// use the identifier to fetch one row as an associative array:
		$row = mysqli_fetch_assoc($result);
		// extract the data for use in the HTML:
		$surveyID = $row['surveyID'];
		$title = $row['title'];
		$username = $row['username'];
		
		// Start 1st layer query (to get questions' type in a particular survey ID)
		$q1 = "SELECT * FROM questions WHERE surveyID = {$row['surveyID']}";
		$r1 = mysqli_query($connection, $q1);
		for($i=0; $i<mysqli_num_rows($r1); $i++)
		{
			$row = mysqli_fetch_assoc($r1);
			$type = $row['type'];
			// set the starting question index as 1
			$questionNum = $i+1;
			echo "<h3>Q" . $questionNum . " | ";
			echo "{$row['text']}";
			// a drop down list to show current question's type and let user to choose 
			echo "<select name='surveyType'>";
			echo "<option value='' "; if($type==null){echo"selected";} echo">Select...</option>";
			echo "<option value='1' "; if($type==1){echo"selected";} echo">Checkboxes</option>";
			echo "<option value='2' "; if($type==2){echo"selected";} echo">Drop-down list</option>";
			echo "<option value='3' "; if($type==3){echo"selected";} echo">Radio buttons</option>";
			echo "<option value='4' "; if($type==4){echo"selected";} echo">Slider</option>";
			echo "<option value='5' "; if($type==5){echo"selected";} echo">Text box</option>";
			echo "</select></h3>";
			
			// Start 2nd query (to get preset answers)
			$q2 = "SELECT presetID, text FROM preset_answers WHERE questionID = {$row['questionID']}";
			$r2 = mysqli_query($connection, $q2);
			$n2 = mysqli_num_rows($r2);
			// If there are match data
			if($n2>0)
			{
				switch($type)
				{
					// this case prints out checkboxes
					case "1":
					for($j=0; $j<$n2; $j++)
					{
						$row2 = mysqli_fetch_assoc($r2);
						echo "<input type='checkbox' name='{$row2['presetID']}' value='{$row2['text']}'>{$row2['text']}<br>";
					}
					break;
					
					// this case prints out drop-down list
					case "2":
					echo "<select>";
					for($j=0; $j<$n2; $j++)
					{
						$row2 = mysqli_fetch_assoc($r2);
						echo "<option value='{$row2['text']}'>{$row2['text']}</option>";
					}
					echo "</select><br>";
					break;
					
					// this case prints out radio buttons
					case "3":
					for($j=0; $j<$n2; $j++)
					{
						$row2 = mysqli_fetch_assoc($r2);
						echo "<input type='radio' name='radio' value='{$row2['text']}'>{$row2['text']}<br>";
					}
					break;
					
					// this case prints out a simple range slider
					case "4":
					$row2 = mysqli_fetch_assoc($r2);
					$avg = (1+$row2['text'])/2;
					echo " 1 <input type='range' min='1' max='{$row2['text']}' value='$avg' class='slider' id='{$row2['presetID']}'> {$row2['text']}";
					break;
					
					// this case prints out a textbox
					case "5":
					$row2 = mysqli_fetch_assoc($r2);
					echo "<textarea rows='4' cols='50' placeholder='{$row2['text']}'></textarea>";
					break;
					
					// if user doesn't choose any
					default:
					echo"No chosen type.";
				}
			}
		}
	}
	echo "<br>";
	// This link redirect user to the active survey
	echo "<a href='survey_view.php?sID=$_GET[survey]'>Try Me!!</a></td>";
	//Disconnect the database
	mysqli_close($connection);

}

echo $message;

// finish off the HTML for this page:
require_once "footer.php";
?>