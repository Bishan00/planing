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

  
// Get the work order IDs from the button click
if (isset($_POST['work_order_ids'])) {
    $work_order_ids = explode(',', $_POST['work_order_ids']); // Convert comma-separated values to an array

    foreach ($work_order_ids as $work_order_id) {
        // Retrieve the work order details
        $sql = "SELECT tire_id, quantity FROM work_order WHERE work_order_id = $work_order_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $tire_id = $row['tire_id'];
        $quantity = $row['quantity'];

        // Retrieve the time taken to make each type of tire
        $sql = "SELECT time_taken FROM tire WHERE tire_id = $tire_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $time_taken = $row['time_taken'];

        // Retrieve the molds that match the tire for the product and are not in use
        $sql = "SELECT mold_id FROM mold WHERE tire_id = $tire_id AND mold_id NOT IN (SELECT mold_id FROM production_plan WHERE end_date IS NULL)";
        $result = mysqli_query($conn, $sql);

        // Iterate through the molds
        while ($row = mysqli_fetch_assoc($result)) {
            $mold_id = $row['mold_id'];

            // Retrieve the available presses for the mold
            $sql = "SELECT press_id FROM press WHERE mold_id = $mold_id AND press_id NOT IN (SELECT press_id FROM production_plan WHERE end_date IS NULL)";
            $press_result = mysqli_query($conn, $sql);

            // Iterate through the presses
            while ($press_row = mysqli_fetch_assoc($press_result)) {
                $press_id = $press_row['press_id'];

                // Calculate the start date for the production plan
                $sql = "SELECT MAX(end_date) AS last_end_date FROM production_plan WHERE press_id = $press_id";
                $date_result = mysqli_query($conn, $sql);
                $date_row = mysqli_fetch_assoc($date_result);
                $last_end_date = $date_row['last_end_date'];
                $start_date = date('Y-m-d H:i:s', strtotime($last_end_date) + ($time_taken * 60));

                // Calculate the end date for the production plan
                $end_date = date('Y-m-d H:i:s', strtotime($start_date) + ($time_taken * $quantity * 60));

                // Insert the production plan into the database
                $sql = "INSERT INTO production_plan (work_order_id, press_id, mold_id, start_date, end_date) VALUES ($work_order_id, $press_id, $mold_id, '$start_date', '$end_date')";
                mysqli_query($conn, $sql);
            }
        }
    }

  
    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Production Plan</title>
</head>
<body>
    <form method="POST" action="">
        <label for="work_order_ids">Work Order IDs (comma-separated):</label>
        <input type="text" name="work_order_ids" id="work_order_ids" required>
        <button type="submit">Generate Production Plan</button>
    </form>
</body>
</html>