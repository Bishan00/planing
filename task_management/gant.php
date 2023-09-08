
<!DOCTYPE html>
<html>
<head>
    <title>Graphical View</title>
</head>
<body>
    <h1>Select a Start Date</h1>
    <form method="POST" action="gant.php"> <!-- Replace "graph.php" with the name of your PHP file -->
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
        <button type="submit">Show Graph</button>
    </form>
</body>
</html>


<?php
// Replace with your database connection code
$mysqli = new mysqli("localhost", "root", "", "task_management");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST["start_date"];

    // SQL query to fetch data for the selected start_date
    $sql = "SELECT icode, id_count FROM merged_data WHERE start_date = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $start_date);
        $stmt->execute();
        $result = $stmt->get_result();

        // Create a PHP array to hold the data
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
    } else {
        echo "Error in SQL statement: " . $mysqli->error;
    }

    // Close the database connection
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Graphical View</title>
    <!-- Include Google Charts library -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load the Google Charts library
        google.charts.load('current', {'packages':['corechart']});

        // Set a callback to run when the Google Charts library is loaded
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            <?php
            if (isset($data) && !empty($data)) {
                // Convert the PHP array to a JSON string
                $jsonData = json_encode($data);
                echo "var jsonData = " . $jsonData . ";";
            } else {
                echo "var jsonData = null;";
            }
            ?>

            // Create a data table from the JSON data
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'icode');
            data.addColumn('number', 'id_count');

            if (jsonData) {
                for (var i = 0; i < jsonData.length; i++) {
                    data.addRow([jsonData[i].icode, parseInt(jsonData[i].id_count)]);
                }
            }

            // Set chart options
            var options = {
                title: ' ' + '<?php echo $start_date; ?>',
                chartArea: {width: '50%'},
                hAxis: {
                    title: 'tobe',
                    minValue: 0
                },
                vAxis: {
                    title: 'icode'
                }
            };

            // Create and draw the chart
            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <?php
    if (isset($data) && !empty($data)) {
        echo '<h1>Graphical View for ' . $start_date . '</h1>';
        echo '<div id="chart_div" style="width: 1800px; height: 1400px;"></div>';
    } else {
        echo '<h1>No data found for the selected date.</h1>';
    }
    ?>
</body>
</html>
