


<?php
// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "bishnplan");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to update the production plan based on work order priorities
function updateProductionPlan($conn, $work_order_ids)
{
    // Clear existing production plan
    $sql = "DELETE FROM production_plan";
    mysqli_query($conn, $sql);

    // Iterate over each work order ID
    foreach ($work_order_ids as $work_order_id) {
        // Retrieve the work order details
        $sql = "SELECT tire_id, quantity
                FROM work_order
                WHERE work_order_id = $work_order_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $tire_id = $row['tire_id'];
        $quantity = $row['quantity'];

        // Retrieve the time taken for the tire type
        $sql = "SELECT time_taken
                FROM tire
                WHERE tire_id = $tire_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $time_taken = $row['time_taken'];

        // Calculate the start and end dates based on the time taken
        $start_date = date("Y-m-d H:i:s");
        $end_date = date("Y-m-d H:i:s", strtotime("+{$time_taken} minutes"));

        // Check for available press and mold
        $sql = "SELECT press_id, mold_id
                FROM press
                WHERE availability_date <= '$start_date'
                AND is_available = 1
                LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $press_id = $row['press_id'];
            $mold_id = $row['mold_id'];

            // Insert the production plan into the database for the entire quantity
            $sql = "INSERT INTO production_plan (work_order_id, press_id, mold_id, start_date, end_date)
                    VALUES ($work_order_id, $press_id, $mold_id, '$start_date', '$end_date')";
            mysqli_query($conn, $sql);

            // Update the availability of the assigned press
            $sql = "UPDATE press
                    SET availability_date = '$end_date', is_available = 0
                    WHERE press_id = $press_id";
            mysqli_query($conn, $sql);

            // Update the availability of the assigned mold
            $sql = "UPDATE mold
                    SET availability_date = '$end_date', is_available = 0
                    WHERE mold_id = $mold_id";
            mysqli_query($conn, $sql);
        }
    }
}

// Handle work order priority changes
if (isset($_POST['work_order_priority'])) {
    $work_order_priority = $_POST['work_order_priority'];

    // Split the work order priorities into an array
    $work_order_ids = explode(",", $work_order_priority);

    // Update the production plan based on the new priorities
    updateProductionPlan($conn, $work_order_ids);
}

// View Planned Tires for Specific Date
// ...

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Update Work Order Priority</title>
</head>
<body>
    <h1>Update Work Order Priority</h1>

    <form action="plan2.php" method="POST">
        <label for="work_order_priority">Work Order Priority:</label>
        <input type="text" name="work_order_priority" id="work_order_priority" placeholder="Enter work order IDs separated by commas" required>

        <button type="submit">Update Priority</button>
    </form>
</body>
</html>
