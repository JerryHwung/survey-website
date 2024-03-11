<?php
// Things to notice:
// The script queries the DB to get the contents of the results in 'answers'
// it then uses Google Charts scripts to plot the data
// The script produces two charts from the same set of data

// execute the header script:
require_once "header.php";
echo "<h3>Results and Analysis(Chart ver.)</h3>";
  // The following code simply gets the contents of the answers table
    // RETRIEVE TEXT AND COUNT DETAILS FROM THE DB
	// extract question ID from get request
	$qID = $_GET['qID'];
    // connect directly to our database:
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // if the connection fails, we need to know, so allow this exit:
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }
        //reset query and result variables as we used them earlier
        $query = $result = "";

        // get all answers from a specific question
        $query = "SELECT text, count FROM answers WHERE questionID='$qID'";
        // this query can return data ($result is an identifier):
        $result = mysqli_query($connection, $query);
        // how many rows of data come back?
        $n = mysqli_num_rows($result);

        // if we got some results then use them to plot a graph
        if ($n > 0) {

            // create a HEREDOC to hold the Google Charts script
            echo <<<_END
					<!--Back to previous page-->
					<script>document.write('<a href="' + document.referrer + '">Go Back</a>');</script>
                    <!--Load the AJAX API-->
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                
                      // Load the Visualization API and the corechart package - notice the 'controls' portion added
                      google.charts.load('current', {'packages':['corechart', 'controls']});
                
                      // Set a callback to run when the Google Visualization API is loaded.
                      google.charts.setOnLoadCallback(drawChart);
                
                      // Callback that creates and populates a data table,
                      // instantiates the pie chart, passes in the data and draws it.
                      function drawChart() {
                
                        // Create the data table.
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Answer');
                        data.addColumn('number', 'Count');
                        data.addRows([
                            
_END;

            // loop over all rows, to fill the DataTable
            for ($i = 0; $i < $n; $i++) {
                // fetch one row as an associative array (elements named after columns):
                $row = mysqli_fetch_assoc($result);
                // set the size of the bar to plot based upon number of count versus total counts
                echo "['{$row['text']}', {$row['count']}],";
            }

            echo <<<_END
                          
                          
                        ]);
                                       
                        // Set chart options
                        var options = {'title':'Answers',
                                       'width':600,
                                       'height':300,
                                       legend: {position: "left"},
                                       };
                                       
                         // Instantiate and draw our chart, passing in some options.
                        // this creates the normal bar chart
                        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                        chart.draw(data, options);
                        
                        //////////////////////////////
                        // CREATION OF THE PIE CHART
                        //////////////////////////////
                        
                        // Create a dashboard.
                            var dashboard = new google.visualization.Dashboard(
                            document.getElementById('dashboard_div'));
                    
                        // Create a range slider, passing some options
                               var slider = new google.visualization.ControlWrapper({
                              'controlType': 'NumberRangeFilter',
                              'containerId': 'filter_div',
                              'options': {
                              'filterColumnLabel': 'Count'
                              }
                            });
                        
                        // set pie chart options
                        var pieChart = new google.visualization.ChartWrapper({
                               'chartType': 'PieChart',
                               'containerId': 'pie_div',
                               'options': {
                                   'title':'Answers',
                                   'width': 600,
                                   'height': 300,
                                   'pieSliceText': 'value',
                                   'legend': 'right'
                                }
                        }); 
                        
                        // Establish dependencies, declaring that 'filter' drives 'pieChart',
                        // so that the pie chart will only display entries that are let through
                        // given the chosen slider range.
                        dashboard.bind(slider, pieChart);
                        dashboard.draw(data);
                        
                      }
                    </script>
                  </head>
                  <body>
                    <table bgcolor='#ffffff' cellspacing='0' cellpadding='2'><tr>
                    <!--Divs that will hold the bar charts-->
                    <td>
                        <div id="chart_div"></div>
                    </td>
                    
                    <!-- divs to hodl the pie chart -->
                    <td><div id="dashboard_div">
                        <div id="filter_div"></div>
                        <div id="pie_div"></div>
                    </div></td>
                    </tr></table>                
_END;

        }

        // if anything else happens indicate a problem
        else {
            echo "No data available to plot<br>";
        }

// finish off the HTML for this page:
require_once "footer.php";
?>