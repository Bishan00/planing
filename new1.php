
 <!-- Add a button to go to another page -->
 <button id="goToOtherPage" class="styled-button">Click To Next</button>

<?php
// Database connection
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$database = "planatir_task_management";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle user input for start and end times
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_start_time = $_POST['start_time'];
    $user_end_time = $_POST['end_time'];

    // Remove the 'T' from the end date and time
    $user_end_time = str_replace('T', ' ', $user_end_time);

    // Remove the 'T' from the end date and time
    $user_start_time = str_replace('T', ' ', $user_start_time);
// SQL query to retrieve records from the database in ascending order of cavity_id
$sql = "SELECT p.plan_id, p.icode, p.start_date, p.end_date, p.mold_id, p.cavity_id, t.time_taken
        FROM plannew p
        JOIN tire t ON p.icode = t.icode
        ORDER BY p.cavity_id ASC";
$result = $conn->query($sql);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $plan_id = $row['icode'];
            $found_start_time = $row['start_date'];
            $found_end_time = $row['end_date'];
            $icode = $row['icode'];
            $time_given = $row['time_taken'];
            $mold_id = $row['mold_id'];
            $cavity_id = $row['cavity_id'];

            // Query to fetch mold_name from the mold table
            $mold_query = "SELECT mold_name FROM mold WHERE mold_id = $mold_id";
            $mold_result = $conn->query($mold_query);
            $mold_row = $mold_result->fetch_assoc();
            $mold_name = $mold_row['mold_name'];

            // Query to fetch cavity_name from the cavity table
            $cavity_query = "SELECT cavity_name FROM cavity WHERE cavity_id = $cavity_id";
            $cavity_result = $conn->query($cavity_query);
            $cavity_row = $cavity_result->fetch_assoc();
            $cavity_name = $cavity_row['cavity_name'];

            if ($found_start_time >= $user_start_time && $found_end_time <= $user_end_time) {
                // Convert date and time strings to timestamps using strtotime
                $user_end_timestamp = strtotime($user_end_time);
                $user_start_timestamp = strtotime($user_start_time);
                $found_start_timestamp = strtotime($found_start_time);
                
                // Ensure $found_end_timestamp is not greater than $user_end_timestamp
                $found_end_timestamp = min(strtotime($found_end_time), $user_end_timestamp);
            
                // Calculate the time difference in minutes
                if ($user_start_timestamp > $found_start_timestamp) {
                    // If user_start_time is less than found_start_time, calculate from user_start_time
                    $timeDifference = ($user_end_timestamp - $user_start_timestamp) / 60;
                } else {
                    // Otherwise, calculate from found_start_time
                    $timeDifference = ($found_end_timestamp - $found_start_timestamp) / 60;
                }
            
                // Calculate Time Taken / Time Difference
                $timeTaken = $time_given; // Assuming "time_given" should be used
                $timeTakenDividedByDifference = $timeDifference / $timeTaken;
            
                // Append the data to the results array
                $results[] = array(
                    'icode' => $icode,
                    'mold_id' => $mold_id,
                    'mold_name' => $mold_name,
                    'cavity_id' => $cavity_id,
                    'cavity_name' => $cavity_name,
                    'found_start_time' => $found_start_time,
                    'found_end_time' => $found_end_time,
                    'time_given' => $time_given,
                    'timeDifference' => $timeDifference,
                    'user_end_time' => $user_end_time,
                    'user_start_time' => $user_start_time,
                    'tobe' => $timeTakenDividedByDifference,
                    'description' => getDescription($icode, $conn),
                );
            }
             elseif ($found_start_time <= $user_start_time && $found_end_time >= $user_end_time) {
                // Convert date and time strings to timestamps using strtotime
                $user_end_timestamp = strtotime($user_end_time);
                $user_start_timestamp = strtotime($user_start_time);
                $found_start_timestamp = strtotime($found_start_time);
                
                // Ensure $found_end_timestamp is not greater than $user_end_timestamp
                $found_end_timestamp = min(strtotime($found_end_time), $user_end_timestamp);
            
                // Calculate the time difference in minutes
                if ($user_start_timestamp > $found_start_timestamp) {
                    // If user_start_time is less than found_start_time, calculate from user_start_time
                    $timeDifference = ($user_end_timestamp - $user_start_timestamp) / 60;
                } else {
                    // Otherwise, calculate from found_start_time
                    $timeDifference = ($found_end_timestamp - $found_start_timestamp) / 60;
                }
            
                // Calculate Time Taken / Time Difference
                $timeTaken = $time_given; // Assuming "time_given" should be used
                $timeTakenDividedByDifference = $timeDifference / $timeTaken;
            
                // Append the data to the results array
                $results[] = array(
                    'icode' => $icode,
                    'mold_id' => $mold_id,
                    'mold_name' => $mold_name,
                    'cavity_id' => $cavity_id,
                    'cavity_name' => $cavity_name,
                    'found_start_time' => $found_start_time,
                    'found_end_time' => $found_end_time,
                    'time_given' => $time_given,
                    'timeDifference' => $timeDifference,
                    'user_end_time' => $user_end_time,
                    'user_start_time' => $user_start_time,
                    'tobe' => $timeTakenDividedByDifference,
                    'description' => getDescription($icode, $conn),
                );
            } elseif ($found_start_time <= $user_end_time && $found_end_time >= $user_start_time) {
                $user_end_timestamp = strtotime($user_end_time);
                $user_start_timestamp = strtotime($user_start_time);
                $found_start_timestamp = strtotime($found_start_time);
                
                // Ensure $found_end_timestamp is not greater than $user_end_timestamp
                $found_end_timestamp = min(strtotime($found_end_time), $user_end_timestamp);
            
                // Calculate the time difference in minutes
                if ($user_start_timestamp > $found_start_timestamp) {
                    // If user_start_time is less than found_start_time, calculate from user_start_time
                    $timeDifference = ($user_end_timestamp - $user_start_timestamp) / 60;
                } else {
                    // Otherwise, calculate from found_start_time
                    $timeDifference = ($found_end_timestamp - $found_start_timestamp) / 60;
                }
            
                // Calculate Time Taken / Time Difference
                $timeTaken = $time_given; // Assuming "time_given" should be used
                $timeTakenDividedByDifference = $timeDifference / $timeTaken;
            
                // Append the data to the results array
                $results[] = array(
                    'icode' => $icode,
                    'mold_id' => $mold_id,
                    'mold_name' => $mold_name,
                    'cavity_id' => $cavity_id,
                    'cavity_name' => $cavity_name,
                    'found_start_time' => $found_start_time,
                    'found_end_time' => $found_end_time,
                    'time_given' => $time_given,
                    'timeDifference' => $timeDifference,
                    'user_end_time' => $user_end_time,
                    'user_start_time' => $user_start_time,
                    'tobe' => $timeTakenDividedByDifference,
                    'description' => getDescription($icode, $conn),
                );
            }
        }
    } else {
        echo "No records found in the database.";
    }

}

// Function to fetch the description from the tire table
function getDescription($icode, $conn) {
    $description = "";
    $description_query = "SELECT description FROM tire WHERE icode = '$icode'";
    $description_result = $conn->query($description_query);
    if ($description_result->num_rows > 0) {
        $description_row = $description_result->fetch_assoc();
        $description = $description_row['description'];
    }
    return $description;
}

// Query to retrieve work orders data and calculate total quantity
$sql = "SELECT icode, SUM(new) AS total_quantity, t_size FROM worder GROUP BY icode";
$result = $conn->query($sql);
$workOrders = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $icode = $row['icode'];
        $totalQuantity = $row['total_quantity'];
        $tSize = $row['t_size'];

        $workOrders[$icode] = array(
            'total_quantity' => $totalQuantity,
            't_size' => $tSize
        );
    }
}
// Query to retrieve the sum of positive "tobe" values for each "icode" in the "tobeplan1" database
$sql_total_tobe = "SELECT icode, SUM(CASE WHEN tobe > 0 THEN tobe ELSE 0 END) AS total_tobe FROM tobeplan1 GROUP BY icode";
$result_total_tobe = $conn->query($sql_total_tobe);
$totalTobeData = array();

if ($result_total_tobe->num_rows > 0) {
    while ($row_total_tobe = $result_total_tobe->fetch_assoc()) {
        $icode = $row_total_tobe['icode'];
        $totalTobe = $row_total_tobe['total_tobe'];

        $totalTobeData[$icode] = $totalTobe;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Plan Data</title>
    <style>       /* Your CSS styles */
        .container {
            margin: 0 auto;
            max-width: 1200px;
            padding: 20px;
            background-color: #f0f0f0;
            font-family: 'Cantarell', sans-serif; /* Use Cantarell as the default font */
        }

        .stock-table {
            width: 100%;
            border-collapse: collapse;
        }

        .stock-table th,
        .stock-table td {
            border: 1px solid #000000;
            padding: 10px;
            text-align: left;
        }

        .stock-table th {
            background-color: #F28018;
            color: #000000;
            font-family: 'Cantarell', sans-serif;
            font-weight: bold;
        }

        .button-container {
            text-align: left;
            margin: 10px;
            border-radius: 4px;
        }

        .button-container button {
            background-color: #000000;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 40px;
        }

        .search-form {
            text-align: center;
            margin: 10px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            width: 200px;
            border: 1px solid #CCCCCC;
            border-radius: 4px;
        }

        .search-form button {
            background-color: #000000;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        body {
            background-color: #f0f0f0;
            font-family: 'Cantarell', sans-serif; /* Set the default font for the entire page */
            text-align: center;
        }

        h4 {
            color: #F28018;
            font-family: 'Cantarell', sans-serif; /* Apply the Cantarell font to the h4 element */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000000;
            padding: 10px;
            text-align: left;
        }

        .styled-button {
    background-color: #F28018;
    color: #FFFFFF;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-family: 'Cantarell', sans-serif;
}

.styled-button:hover {
    background-color: #FFA500; /* Change the background color on hover */
}


        .table th {
            background-color: #F28018;
            color: #000000;
            font-weight: bold;
        }
        .button-container button {
            background-color: #000000;
            color: #FFFFFF;
            padding: 10px 20px;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            transition: background-color 0.3s; /* Add a smooth transition for the background color change */
        }

        .button-container button:hover {
            background-color: #333333; /* Change the background color on hover */
        }

    </style>
 
</head>
<body>
    <div class="container">
        <h1>Plan Data</h1>

        <!-- Display User End Time and User Start Time outside of the table -->
        <div>
            <strong>Your Start Time:</strong> <?php echo $user_start_time; ?><br>
            <strong>Your End Time:</strong> <?php echo $user_end_time; ?><br>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Tire Id</th>
                    <th>Description</th>
                    <th>Mold Name</th>
                    <th>Cavity Name</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Order Quantity</th>
                    <th>Tobeplan</th>
                    <th>Plan</th>
                    <th>Time Given</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result) { ?>
                    <tr>
                        <td><?php echo $result['icode']; ?></td>
                        <td><?php echo $result['description']; ?></td>
                        <td><?php echo $result['mold_name']; ?></td>
                        <td><?php echo $result['cavity_name']; ?></td>
                        <td><?php echo $result['found_start_time']; ?></td>
                        <td><?php echo $result['found_end_time']; ?></td>
                        <td><?php echo $workOrders[$result['icode']]['total_quantity']; ?></td>
                        <td><?php echo $totalTobeData[$result['icode']]; ?></td> <!-- Display total tobe for the corresponding icode -->
                        <td><?php echo round($result['tobe']); ?></td>
                        <td><?php echo $result['time_given']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
       

    <script>
        // JavaScript code to handle the button click event
        document.getElementById("goToOtherPage").addEventListener("click", function() {
            // Create an array to store the selected data
            var selectedData = [];
            
            <?php foreach ($results as $result) { ?>
                // Push the selected values to the array
                selectedData.push({
                    icode: "<?php echo $result['icode']; ?>",
                    mold_name: "<?php echo $result['mold_name']; ?>",
                    cavity_name: "<?php echo $result['cavity_name']; ?>",
                    tobe: "<?php echo round($result['tobe']); ?>"
                });
            <?php } ?>

            // Convert the selected data to a JSON string
            var selectedDataJSON = JSON.stringify(selectedData);

            // Define the URL of the other PHP page you want to go to
            var otherPageURL = "plan_edit.php";

            // Create a URL with parameters
            var parameters = "?user_start_time=" + encodeURIComponent("<?php echo $user_start_time; ?>") +
                             "&user_end_time=" + encodeURIComponent("<?php echo $user_end_time; ?>") +
                             "&selected_data=" + encodeURIComponent(selectedDataJSON);

            // Redirect to the other PHP page with parameters
            window.location.href = otherPageURL + parameters;
        });
    </script>
</body>
</html>


