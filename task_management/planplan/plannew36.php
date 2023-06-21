<?php
// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "task_management");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the ERP ID from the form submission
    $erp = isset($_POST['erp']) ? $_POST['erp'] : '';

    // Validate the ERP ID (you can add your own validation logic here)
    if (empty($erp)) {
        die("Please enter a valid ERP ID");
    }

    // Sanitize the ERP ID to prevent SQL injection
    $erp = mysqli_real_escape_string($conn, $erp);

    // Generate Production Plan

    // Retrieve the tire IDs and quantities for the ERP
    $sql = "SELECT wt.icode, wt.tobe, t.time_taken
        FROM tobeplan wt
        INNER JOIN tire t ON wt.icode = t.icode
        WHERE wt.erp = '$erp'";
    $result = mysqli_query($conn, $sql);

    // Check if the ERP exists
    if (mysqli_num_rows($result) > 0) {
        // Split the tire IDs and quantities
        $tires = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $icode = $row['icode'];
            $tobe = $row['tobe'];
            $tires[] = array('icode' => $icode, 'tobe' => $tobe);
        }

        $previous_end_date = null; // Initialize the variable
        $available_press_ids = array(); // Initialize the array
        $next_start_date = null; // Initialize the variable for the next tire start date

        // Retrieve the maximum number of molds allowed for each press
        $sql = "SELECT press_id, molds_allowed FROM press_capacity";
        $result_capacity = mysqli_query($conn, $sql);

        if (!$result_capacity) {
            die("Query failed: " . mysqli_error($conn));
        }

        $press_capacities = array();

        while ($row_capacity = mysqli_fetch_assoc($result_capacity)) {
            $press_id = $row_capacity['press_id'];
            $molds_allowed = $row_capacity['molds_allowed'];

            $press_capacities[$press_id] = $molds_allowed;
        }

        // Iterate over each tire in the ERP
        foreach ($tires as $tire) {
            $icode = $tire['icode'];
            $tobe = $tire['tobe'];

            // Retrieve the time taken for the tire type
            $sql = "SELECT time_taken
                    FROM tire
                    WHERE icode = '$icode'";
            $result2 = mysqli_query($conn, $sql);

            if (!$result2) {
                die("Query failed: " . mysqli_error($conn));
            }

            $row2 = mysqli_fetch_assoc($result2);

            $time_taken = $row2['time_taken'];

            // Calculate the total time for all tires in the ERP
            $total_time = $time_taken * $tobe;

            // Calculate the start and end dates based on the total time
            $start_date = $previous_end_date ? $previous_end_date : date("Y-m-d H:i:s");
            $end_date = date("Y-m-d H:i:s", strtotime("$start_date + $total_time minutes"));

            // Check for available press and mold matching the tire_id
            $sql = "SELECT p.press_id, p.press_name, m.mold_id, m.mold_name, pc.molds_allowed
                    FROM press p
                    INNER JOIN mold_press mp ON p.press_id = mp.press_id
                    INNER JOIN mold m ON mp.mold_id = m.mold_id
                    INNER JOIN tire_mold tm ON m.mold_id = tm.mold_id
                    INNER JOIN tire t ON tm.icode = t.icode
                    INNER JOIN press_capacity pc ON p.press_id = pc.press_id
                    WHERE p.is_available = 1 AND m.is_available = 1 AND t.icode = '$icode'";

            // Add condition to match available presses at the end of previous ERPs
            if (!empty($available_press_ids)) {
                $press_ids_str = implode(",", $available_press_ids);
                $sql .= " AND p.press_id IN ($press_ids_str)";
            }

            $result3 = mysqli_query($conn, $sql);

            if (!$result3) {
                die("Query failed: " . mysqli_error($conn));
            }

            $row3 = mysqli_fetch_assoc($result3);

            if ($row3) {
                $press_id = $row3['press_id'];
                $press_name = $row3['press_name'];
                $mold_id = $row3['mold_id'];
                $mold_name = $row3['mold_name'];
                $molds_allowed = $row3['molds_allowed'];

                // Check for available molds matching the mold_id and consider the maximum number of molds allowed
                $sql = "SELECT m.mold_id, m.mold_name
                        FROM mold m
                        WHERE m.is_available = 1 AND m.mold_id = '$mold_id'
                        LIMIT $molds_allowed";

                $result4 = mysqli_query($conn, $sql);

                if (!$result4) {
                    die("Query failed: " . mysqli_error($conn));
                }

                $row4 = mysqli_fetch_assoc($result4);

                if ($row4) {
                    $mold_id = $row4['mold_id'];
                    $mold_name = $row4['mold_name'];

                    // Calculate the start date for the next tire
                    $next_start_date = $end_date;

                    // Insert the production plan into the database for the entire quantity
                    $sql = "INSERT INTO production_plan (erp, icode, press_id, press_name, mold_id, mold_name, start_date, end_date)
                            VALUES ('$erp', '$icode', '$press_id', '$press_name', '$mold_id', '$mold_name', '$start_date', '$end_date')";
                    mysqli_query($conn, $sql);

                    // Get the ID of the inserted production plan
                    $production_plan_id = mysqli_insert_id($conn);

                    // Update the production plan with the corresponding erp_id and tire_id
                    $sql = "UPDATE production_plan
                            SET erp = '$erp', icode = '$icode'
                            WHERE production_plan_id = '$production_plan_id'";
                    mysqli_query($conn, $sql);

                    // Update the availability of the assigned press and mold
                    $sql = "UPDATE press
                            SET availability_date = '$end_date'
                            WHERE press_id = '$press_id'
                            LIMIT $molds_allowed";
                    mysqli_query($conn, $sql);

                    $sql = "UPDATE mold
                            SET availability_date = '$end_date'
                            WHERE mold_id = '$mold_id'
                            LIMIT $molds_allowed";
                    mysqli_query($conn, $sql);

                    $previous_end_date = $end_date; // Update the previous end date
                    $available_press_ids[] = $press_id; // Add press ID to the available presses array
                }
            }
        }

        // Update the start date for the next tire
        $previous_end_date = $next_start_date;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Production Planning</title>
</head>
<body>
    <h2>Generate Production Plan</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="erp">ERP ID:</label>
        <input type="text" name="erp" id="erp" value="<?php echo isset($_GET['erp']) ? $_GET['erp'] : ''; ?>">
        <button type="submit">Generate Plan</button>
    </form>
</body>
</html>
