<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plan";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle button click
if (isset($_POST['submit'])) {
    // Fetch work order details based on button ID
    $workOrderId = 7; // Replace with actual work order ID
    $workOrderQuery = "SELECT * FROM work_orders WHERE id = $workOrderId";
    $workOrderResult = $conn->query($workOrderQuery);

    if ($workOrderResult->num_rows > 0) {
        $workOrderData = $workOrderResult->fetch_assoc();

        // Fetch tire IDs and time estimates
        $tireIds = explode(",", $workOrderData['tire_ids']);
        $tireIds = array_map('trim', $tireIds);

        $tireQuery = "SELECT * FROM tires WHERE id IN (" . implode(",", $tireIds) . ")";
        $tireResult = $conn->query($tireQuery);

        // Fetch mold details based on tires
        $moldIds = array();
        while ($tireData = $tireResult->fetch_assoc()) {
            $moldId = $tireData['mold_id'];
            $moldIds[] = $moldId;
        }

        $moldQuery = "SELECT * FROM molds WHERE id IN (" . implode(",", $moldIds) . ")";
        $moldResult = $conn->query($moldQuery);

        // Fetch press information based on molds
        $pressIds = array();
        while ($moldData = $moldResult->fetch_assoc()) {
            $pressId = $moldData['press_id'];
            $pressIds[] = $pressId;
        }

        $pressQuery = "SELECT * FROM presses WHERE id IN (" . implode(",", $pressIds) . ")";
        $pressResult = $conn->query($pressQuery);

        // Select number of molds that can be placed in the presses
        $moldCountPerPress = array();
        while ($pressData = $pressResult->fetch_assoc()) {
            $pressId = $pressData['id'];
            $moldCountPerPress[$pressId] = $pressData['mold_capacity'];
        }

        // Calculate time needed to produce all tires
        $totalTime = 0;
        $completionDates = array();
        foreach ($tireIds as $tireId) {
            $timeQuery = "SELECT time_taken FROM tire_times WHERE tire_id = $tireId";
            $timeResult = $conn->query($timeQuery);
            


            if ($timeResult->num_rows > 0) {
                $timeData = $timeResult->fetch_assoc();
                $time = $timeData['time_taken'];
                $totalTime += $time;
            }

            // Automatically plan production dates and times
            $completionDate = date('Y-m-d', strtotime("+$totalTime days"));
            $completionTime = date('H:i:s', strtotime($workOrderData['start_time']));

            // Store the production schedule in another table
            $scheduleQuery = "INSERT INTO production_schedule (work_order_id, tire_id, mold_id, press_id, completion_date, completion_time)
                            VALUES ('$workOrderId', '$tireId', '$moldId', '$pressId', '$completionDate', '$completionTime')";
            $conn->query($scheduleQuery);

            // Update mold status as 'in production' in the molds table
            $updateMoldQuery = "UPDATE molds SET status = 'in production' WHERE id = '$moldId'";
            $conn->query($updateMoldQuery);
        }

        echo "Work order processed successfully!";
    } else {
        echo "Work order not found!";
    }
}

// Close the database connection
$conn->close();
?>
