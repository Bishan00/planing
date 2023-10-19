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

                // Calculate the time difference in minutes
                if ($user_start_timestamp > $found_start_timestamp) {
                    // If user_start_time is less than found_start_time, calculate from user_start_time
                    $timeDifference = ($user_end_timestamp - $user_start_timestamp) / 60;
                } else {
                    // Otherwise, calculate from found_start_time
                    $timeDifference = ($user_end_timestamp - $found_start_timestamp) / 60;
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
            } elseif ($found_start_time <= $user_start_time && $found_end_time >= $user_end_time) {
                // Convert date and time strings to timestamps using strtotime
                $user_end_timestamp = strtotime($user_end_time);
                $user_start_timestamp = strtotime($user_start_time);
                $found_start_timestamp = strtotime($found_start_time);

                // Calculate the time difference in minutes
                if ($user_start_timestamp > $found_start_timestamp) {
                    // If user_start_time is less than found_start_time, calculate from user_start_time
                    $timeDifference = ($user_end_timestamp - $user_start_timestamp) / 60;
                } else {
                    // Otherwise, calculate from found_start_time
                    $timeDifference = ($user_end_timestamp - $found_start_timestamp) / 60;
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
                // Convert date and time strings to timestamps using strtotime
                $user_end_timestamp = strtotime($user_end_time);
                $user_start_timestamp = strtotime($user_start_time);
                $found_start_timestamp = strtotime($found_start_time);

                // Calculate the time difference in minutes
                if ($user_start_timestamp > $found_start_timestamp) {
                    // If user_start_time is less than found_start_time, calculate from user_start_time
                    $timeDifference = ($user_end_timestamp - $user_start_timestamp) / 60;
                } else {
                    // Otherwise, calculate from found_start_time
                    $timeDifference = ($user_end_timestamp - $found_start_timestamp) / 60;
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
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Plan Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:nth-child(odd) {
            background-color: #fff;
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

        <table>
            <thead>
                <tr>
                    <th>Tire Id</th>
                    <th>Description</th>
                    <th>Mold Name</th>
                    <th>Cavity Name</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Order Quantity</th>
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
                        <td><?php echo round($result['tobe']); ?></td>
                        <td><?php echo $result['time_given']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- Add this button below your table -->
<button id="goToOtherPage">Go to Another Page</button>
    </div>

    <script>
    // JavaScript code to handle the button click event
    document.getElementById("goToOtherPage").addEventListener("click", function() {
        // Define the URL of the other PHP page you want to go to
        var otherPageURL = "plan_edit.php";

        // Create a URL with parameters
        var parameters = "?user_start_time=" + encodeURIComponent("<?php echo $user_start_time; ?>") +
                         "&user_end_time=" + encodeURIComponent("<?php echo $user_end_time; ?>") +
                         "&table_data=" + encodeURIComponent(JSON.stringify(<?php echo json_encode($results); ?>));

        // Redirect to the other PHP page with parameters
        window.location.href = otherPageURL + parameters;
    });
</script>



</script>
</body>
</html>


