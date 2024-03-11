<?php

// Things to notice:
// You need to add code to this script to implement the admin functions and features
// Notice that the code not only checks whether the user is logged in, but also whether they are the admin, before it displays the page content
// You can implement all the admin tools functionality from this script, or...

// execute the header script:
require_once "header.php";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "<p class='mt-5'>You must be logged in to view this page.</p>";
}
else
{
	// only display the page content if this is the admin account (all other users get a "you don't have permission..." message):
	if ($_SESSION['username'] == "admin")
	{
		
		echo "Implement the admin tools here... See the assignment specification for more details.<br>";
		//Show users in a table
		//Connect to database first
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		//If connection fail
		 if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }
		//Query to search all profiles
		$query = "SELECT username FROM users";
		//Set returned data into $return
		$result = mysqli_query($connection, $query);
		//display users in a table
		echo <<<_END
       <table class="table table-striped table-dark rounded text-center w-25 p-3">
	   <thead>
	   <tr><th colspan="2">Users</th></tr>
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
            echo "<td><a href = 'view.php?user={$row['username']}'>{$row['username']}</a></td>";
			echo "<td><a class='btn btn-danger' href = 'delete.php?user={$row['username']}' role='button'>Delete</a></td>";
		}
		echo "</tbody>";
        echo "</table>";
		echo "<a class='btn btn-primary' href='create.php'>Create</a><br>";
		echo "Survey management features coming soon......";
	}
	else
	{
		echo "<p class='mt-5'>You don't have permission to view this page...</p>";
	}
}

// finish off the HTML for this page:
require_once "footer.php";
?>