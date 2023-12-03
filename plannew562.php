<?php
// Establish database connection
$conn = mysqli_connect("localhost", "planatir_task_management", "Bishan@1919", "planatir_task_management");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch customer names for each ERP from the 'worder' table
$customerNames = array();
$sql = "SELECT erp, Customer FROM worder";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $erp = $row['erp'];
        $customer_name = $row['Customer'];
        $customerNames[$erp] = $customer_name;
    }
} else {
    die("Query failed: " . mysqli_error($conn));
}

// Retrieve all tire IDs, quantities, press, mold, and time_taken from the database table
$sql = "SELECT s.icode, s.tires_per_mold, s.mold_id, s.cavity_id, t.time_taken, p.erp, m.availability_date AS mold_availability, c.availability_date AS cavity_availability
        FROM process s
        INNER JOIN tire t ON s.icode = t.icode
        INNER JOIN tobeplan p ON s.icode = p.icode
        LEFT JOIN mold m ON s.mold_id = m.mold_id
        LEFT JOIN cavity c ON s.cavity_id = c.cavity_id";
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
        $mold_availability = $row['mold_availability'];
        $cavity_availability = $row['cavity_availability'];

        // Get the customer name corresponding to the current ERP from the associative array
        $customer_name = $customerNames[$erp_number];

        // Fetch the availability_date of the icode from the tire database table
        $sql = "SELECT availability_date FROM tire WHERE icode = '$icode'";
        $tireResult = mysqli_query($conn, $sql);
        if ($tireResult) {
            $tireRow = mysqli_fetch_assoc($tireResult);
            $tire_availability = $tireRow['availability_date'];
        } else {
            die("Query failed: " . mysqli_error($conn));
        }

        // Skip the tire if the 'tobe' value is 0
        if ($tobe == 0) {
            continue;
        }

        // Calculate the start date based on the latest end date of the previous tire type or the current time,
        // taking into account the availability_date of the icode
        $start_date = max(
            $latest_end_dates[$mold] ?? $mold_availability,
            $latest_end_dates[$cavity] ?? $cavity_availability,
            $tire_availability ?: date("Y-m-d H:i:s")
        );

        // Calculate the total time for all tires in the current iteration
        $total_time = $time_taken * $tobe;

        // Calculate the end date based on the total time
        $end_date = date("Y-m-d H:i:s", strtotime("$start_date + $total_time minutes"));

        // Update the next start dates for the next tire types of the same mold and cavity
        $latest_end_dates[$mold] = $end_date;
        $latest_end_dates[$cavity] = $end_date;

        // Insert the production plan into the database for the entire quantity, including the customer name
        $sql = "INSERT INTO plannew1 (icode, mold_id, cavity_id, start_date, end_date, erp, tires_per_mold, Customer)
                VALUES ('$icode', '$mold', '$cavity', '$start_date', '$end_date', '$erp_number', '$tobe', '$customer_name')";
        mysqli_query($conn, $sql);

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
header("Location: chek_date2.php");
exit();
?>