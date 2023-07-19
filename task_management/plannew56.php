<?php
// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "task_management");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Retrieve all tire IDs, quantities, press, mold, and time_taken from the database table
$sql = "SELECT s.icode, s.tires_per_mold, s.mold_id, s.cavity_id, t.time_taken, p.erp
        FROM process s
        INNER JOIN tire t ON s.icode = t.icode
        INNER JOIN tobeplan p ON s.icode = p.icode";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Check if any tires are available for production
if (mysqli_num_rows($result) > 0) {
    // Initialize array to store the latest end date for each press, mold, and cavity
    $latest_end_dates = array();

    // Iterate over each tire in the database table
    while ($row = mysqli_fetch_assoc($result)) {
        $icode = $row['icode'];
        $tobe = $row['tires_per_mold'];
        $mold = $row['mold_id'];
        $cavity = $row['cavity_id'];
        $time_taken = $row['time_taken'];
        $erp_number = $row['erp'];

        // Skip the tire if the 'tobe' value is 0
        if ($tobe == 0) {
            continue;
        }

        // Retrieve the latest end dates for the current mold and cavity
        $latest_end_date_mold = isset($latest_end_dates[$mold]) ? $latest_end_dates[$mold] : null;
        $latest_end_date_cavity = isset($latest_end_dates[$cavity]) ? $latest_end_dates[$cavity] : null;

        // Calculate the start date based on the latest end date of the previous tire type or the current time
        $start_date = max($latest_end_date_mold, $latest_end_date_cavity) ? date("Y-m-d H:i:s", strtotime("$latest_end_date_mold $latest_end_date_cavity + 1 minute")) : date("Y-m-d H:i:s");

        // Calculate the total time for all tires in the current iteration
        $total_time = $time_taken * $tobe;

        // Calculate the end date based on the total time
        $end_date = date("Y-m-d H:i:s", strtotime("$start_date + $total_time minutes"));

        // Update the next start dates for the next tire types of the same mold and cavity
        $latest_end_dates[$mold] = $end_date;
        $latest_end_dates[$cavity] = $end_date;

        // Insert the production plan into the database for the entire quantity
        $sql = "INSERT INTO plannew (icode, mold_id, cavity_id, start_date, end_date, erp)
                VALUES ('$icode', '$mold', '$cavity', '$start_date', '$end_date', '$erp_number')";
        mysqli_query($conn, $sql);

        // Get the ID of the inserted production plan
        $production_plan_id = mysqli_insert_id($conn);

        // Update the availability date of mold
        $sql = "UPDATE mold SET availability_date = '$end_date' WHERE mold_id = '$mold'";
        mysqli_query($conn, $sql);

        // Update the availability date of cavity
        $sql = "UPDATE cavity SET availability_date = '$end_date' WHERE cavity_id = '$cavity'";
        mysqli_query($conn, $sql);
    }

    echo "Production plan generated successfully!";
} else {
    echo "No tires found in the database.";
}

// Close the database connection
mysqli_close($conn);
header("Location: deleteall.php");
exit();
?>

