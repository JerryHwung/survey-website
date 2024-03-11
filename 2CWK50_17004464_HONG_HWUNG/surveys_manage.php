<?php

// Things to notice:
// This is the page where each user can MANAGE their surveys
// As a suggestion, you may wish to consider using this page to LIST the surveys they have created
// Listing the available surveys for each user will probably involve accessing the contents of another TABLE in your database
// Give users options such as to CREATE a new survey, EDIT a survey, ANALYSE a survey, or DELETE a survey, might be a nice idea
// You will probably want to make some additional PHP scripts that let your users CREATE and EDIT surveys and the questions they contain
// REMEMBER: Your admin will want a slightly different view of this page so they can MANAGE all of the users' surveys

// execute the header script:
require_once "header.php";


if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
else
{
    // a little extra text that only the admin will see!:
	if ($_SESSION['username'] == "admin")
	{
		echo "<br>";
		//Show survey list(all users') in a table
		//Connect to database first
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		//If connection fail
		 if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }
		//Query to search all surveys
		$query = "SELECT * FROM surveys";
		//Set returned data into $return
		$result = mysqli_query($connection, $query);
		//display survey list
		echo <<<_END
       <table class="table table-striped table-dark rounded text-center w-25 p-3">
	   <thead>
	   <tr>
	   <th>Survey ID</th><th>Title</th><th>Username</th>
	   </tr>
	   </thead>
_END;
		echo "<tbody>";
        // loop over all rows, adding them into the table:
        for ($i=0; $i<mysqli_num_rows($result); $i++)
        {
            // fetch one row as an associative array (elements named after columns):
            $row = mysqli_fetch_assoc($result);
            // add it as a row in our table:
            echo "<tr>";
			echo "<td>{$row['surveyID']}</td>";
			//View the survey based on the survey ID not title in case there are surveys that have same names 
			echo "<td><a href= 'survey_preview.php?survey={$row['surveyID']}'>{$row['title']}</td>";
            echo "<td><a href = 'view.php?user={$row['username']}'>{$row['username']}</a></td>";
			echo "<td><a class='btn btn-danger' href = 'delete.php?survey={$row['surveyID']}' role='button'>Delete</a></td>";
			echo "<td><a class='btn btn-info' href= 'survey_result.php?survey={$row['surveyID']}' role='button'>Results</a></td>";
			echo "<td><a class='btn btn-primary' href= 'survey_view.php?sID={$row['surveyID']}' role='button'>Try Me!!</a></td>";
		}
		echo "</tbody>";
        echo "</table>";
		//create not ready yet
		echo "<a class='btn btn-primary' href='#'>Create</a><br>";
	}
	else
	{
		//Show survey list(current user's) in a table
		//Connect to database first
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		//If connection fail
		 if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }
		//Query to search all surveys
		$query = "SELECT * FROM surveys WHERE username = '{$_SESSION["username"]}'";
		//Set returned data into $return
		$result = mysqli_query($connection, $query);
		//display survey list
		echo <<<_END
       <table class="table table-striped table-dark rounded text-center w-25 p-3">
	   <thead>
	   <tr>
	   <th>Survey ID</th><th>Title</th><th>Username</th>
	   </tr>
	   </thead>
_END;
		echo "<tbody>";
        // loop over all rows, adding them into the table:
        for ($i=0; $i<mysqli_num_rows($result); $i++)
        {
            // fetch one row as an associative array (elements named after columns):
            $row = mysqli_fetch_assoc($result);
            // add it as a row in our table:
            echo "<tr>";
			echo "<td>{$row['surveyID']}</td>";
			//View the survey based on the survey ID not title in case there are surveys that have same names 
			echo "<td><a href= 'survey_preview.php?survey={$row['surveyID']}'>{$row['title']}</td>";
            echo "<td><a href = 'account.php'>{$row['username']}</a></td>";
			echo "<td><a class='btn btn-danger' href = 'delete.php?survey={$row['surveyID']}' role='button'>Delete</a></td>";
			echo "<td><a class='btn btn-primary' href= 'survey_view.php?sID={$row['surveyID']}' role='button'>Try Me!!</a></td>";
		}
		echo "</tbody>";
        echo "</table>";
		echo "<a class='btn btn-primary' href='#'>Create</a><br>";
	}
    
}

// finish off the HTML for this page:
require_once "footer.php";

?>