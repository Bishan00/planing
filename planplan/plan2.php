<?php
// Assuming you have established a MySQL connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bishnplan";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to update the priority of a work order
function updateWorkOrderPriority($work_order_id, $priority) {
    global $conn;

    $sql = "UPDATE work_order SET priority = $priority WHERE work_order_id = $work_order_id";
    mysqli_query($conn, $sql);
}

// Function to update the production plan based on changed work order priorities
function updateProductionPlan() {
    global $conn;

    // Retrieve the work orders that are currently ongoing
    $sql = "SELECT DISTINCT work_order_id FROM production_plan WHERE DATE(start_date) >= CURDATE()";
    $result = mysqli_query($conn, $sql);

    // Iterate through the ongoing work orders
    while ($row = mysqli_fetch_assoc($result)) {
        $work_order_id = $row['work_order_id'];

        // Retrieve the details of the work order
        $sql = "SELECT wo.work_order_id, wo.tire_id, wo.quantity, t.time_taken
                FROM work_order wo
                INNER JOIN tire t ON wo.tire_id = t.tire_id
                WHERE wo.work_order_id = $work_order_id";
        $work_order_result = mysqli_query($conn, $sql);
        $work_order_row = mysqli_fetch_assoc($work_order_result);

        $tire_id = $work_order_row['tire_id'];
        $quantity = $work_order_row['quantity'];
        $time_taken = $work_order_row['time_taken'];

        // Retrieve the available molds that match the tire for the product and are not in use
        $sql = "SELECT m.mold_id
                FROM mold m
                WHERE m.tire_id = $tire_id
                AND m.mold_id NOT IN (
                    SELECT p.mold_id
                    FROM production_plan p
                    WHERE DATE(p.start_date) >= CURDATE()
                )";
        $mold_result = mysqli_query($conn, $sql);

        // Iterate through the molds
        while ($mold_row = mysqli_fetch_assoc($mold_result)) {
            $mold_id = $mold_row['mold_id'];

            // Retrieve the available presses for the mold and are not in use
            $sql = "SELECT p.press_id
                    FROM press p
                    WHERE p.mold_id = $mold_id
                    AND p.press_id NOT IN (
                        SELECT pp.press_id
                        FROM production_plan pp
                        WHERE DATE(pp.start_date) >= CURDATE()
                    )";
            $press_result = mysqli_query($conn, $sql);

            // Iterate through the presses
            while ($press_row = mysqli_fetch_assoc($press_result)) {
                $press_id = $press_row['press_id'];

                // Calculate the start date and end date for the production plan
                $sql = "SELECT MAX(start_date) AS last_start_date
                        FROM production_plan
                        WHERE press_id = $press_id";
                $date_result = mysqli_query($conn, $sql);
                $date_row = mysqli_fetch_assoc($date_result);
                $last_start_date = $date_row['last_start_date'];
                $start_date = date('Y-m-d H:i:s', strtotime($last_start_date. "') + (" . $time_taken . " * 60))";
                $end_date = calculateEndDate($start_date, $time_taken);

                            // Update the ongoing production plan with the new details
            $sql = "UPDATE production_plan
            SET mold_id = $mold_id, press_id = $press_id, start_date = '$start_date', end_date = '$end_date'
            WHERE work_order_id = $work_order_id";
    mysqli_query($conn, $sql);

    // Update the availability of the assigned press
    $sql = "UPDATE press
            SET is_available = 0
            WHERE press_id = $press_id";
    mysqli_query($conn, $sql);

    // Update the availability of the assigned mold
    $sql = "UPDATE mold
            SET is_available = 0
            WHERE mold_id = $mold_id";
    mysqli_query($conn, $sql);
}
}
}
}

// Handle the work order priority changes
if (isset($_POST['work_order_id']) && isset($_POST['priority'])) {
$work_order_id = $_POST['work_order_id'];
$priority = $_POST['priority'];

// Update the priority of the work order
updateWorkOrderPriority($work_order_id, $priority);

// Update the production plan based on changed work order priorities
updateProductionPlan();
}

// Rest of the code...

?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Work Order Priority</title>
</head>
<body>
    <h2>Change Work Order Priority</h2>
    <form method="POST" action="">
        <label for="work_order_id">Work Order ID:</label>
        <input type="text" name="work_order_id" id="work_order_id" required><br><br>
        <label for="priority">Priority:</label>
        <input type="text" name="priority" id="priority" required><br><br>
        <button type="submit">Change Priority</button>
    </form>
</body>
</html>

