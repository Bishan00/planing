<?php
// Assuming you have established a MySQL connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newr";

$conn = mysqli_connect($servername, $username, $password, $dbname);


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the work order IDs from the button click (assuming it's sent as a comma-separated string)
if (isset($_POST['work_order_ids'])) {
    $work_order_ids = explode(",", $_POST['work_order_ids']);

    // Sort the work order IDs based on priority (assuming you have a priority column in the 'work_order' table)
    $work_order_ids = array_map('trim', $work_order_ids);
    $work_order_ids = array_filter($work_order_ids);
    $work_order_ids = array_unique($work_order_ids);
    $work_order_ids = array_values($work_order_ids);

    // Retrieve the last production plan end date for referencing
    $sql = "SELECT MAX(end_date) AS last_end_date FROM production_plan";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $last_end_date = $row['last_end_date'];

    // Iterate through the work order IDs
    foreach ($work_order_ids as $work_order_id) {
        // Retrieve the work order details
        $sql = "SELECT tire_id, quantity, priority FROM work_order WHERE work_order_id = $work_order_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $tire_id = $row['tire_id'];
        $quantity = $row['quantity'];
        $priority = $row['priority'];

        // Retrieve the time taken to make each type of tire
        $sql = "SELECT time_taken FROM tire WHERE tire_id = $tire_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $time_taken = $row['time_taken'];

        // Retrieve the molds that match the tire for the product
        $sql = "SELECT mold_id FROM mold WHERE tire_id = $tire_id";
        $result = mysqli_query($conn, $sql);

        // Iterate through the molds
        while ($row = mysqli_fetch_assoc($result)) {
            $mold_id = $row['mold_id'];

            // Retrieve the available presses for the mold
            $sql = "SELECT press_id FROM press WHERE mold_id = $mold_id";
            $press_result = mysqli_query($conn, $sql);

            // Iterate through the presses
            while ($press_row = mysqli_fetch_assoc($press_result)) {
                $press_id = $press_row['press_id'];

                // Calculate the start date for the production plan
                if (strtotime($last_end_date) > time()) {
                    $start_date = $last_end_date;
                } else {
                    $start_date = date('Y-m-d H:i:s');
                }

                // Calculate the end date for the production plan
                $end_date = date('Y-m-d H:i:s', strtotime($start_date) + ($time_taken * 60));

                                // Update or insert the production plan based on work order priority
                                $sql = "SELECT * FROM production_plan WHERE work_order_id = $work_order_id";
                                $result = mysqli_query($conn, $sql);
                                $num_rows = mysqli_num_rows($result);
                
                                if ($num_rows > 0) {
                                    $existing_plan = mysqli_fetch_assoc($result);
                                    $existing_priority = $existing_plan['priority'];
                
                                    if ($priority != $existing_priority) {
                                        // Update the priority in the production plan
                                        $plan_id = $existing_plan['plan_id'];
                                        $sql = "UPDATE production_plan SET priority = $priority WHERE plan_id = $plan_id";
                                        mysqli_query($conn, $sql);
                                    }
                                } else {
                                    // Insert the production plan into the database
                                    $sql = "INSERT INTO production_plan (work_order_id, press_id, mold_id, start_date, end_date, priority) VALUES ($work_order_id, $press_id, $mold_id, '$start_date', '$end_date', $priority)";
                                    mysqli_query($conn, $sql);
                                }
                            }
                        }
                    }
                
                    // Close the database connection
                    mysqli_close($conn);
                }
                ?>
                
                
                