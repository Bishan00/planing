<?php
// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "bishnplan");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Generate Production Plan
if (isset($_POST['work_order_ids'])) {
    $work_order_ids = $_POST['work_order_ids'];

    // Split the work order IDs into an array
    $work_order_ids = explode(",", $work_order_ids);

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

        // Calculate the total time for all tires in the work order
        $total_time = $time_taken * $quantity;

        // Calculate the start and end dates based on the total time
        $start_date = date("Y-m-d H:i:s");
        $end_date = date("Y-m-d H:i:s", strtotime("+$total_time minutes"));

        // Check for available press and mold
        $sql = "SELECT p.press_id, p.press_name, m.mold_id, m.mold_name
                FROM press p
                INNER JOIN mold m ON p.mold_id = m.mold_id
                WHERE p.is_available = 1
                LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $press_id = $row['press_id'];
            $press_name = $row['press_name'];
            $mold_id = $row['mold_id'];
            $mold_name = $row['mold_name'];

            // Insert the production plan into the database for the entire quantity
            $sql = "INSERT INTO production_plan (work_order_id, press_id, press_name, mold_id, mold_name, start_date, end_date)
                    VALUES ($work_order_id, $press_id, '$press_name', $mold_id, '$mold_name', '$start_date', '$end_date')";
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Production Planning</title>
</head>
<body>
    <h2>Generate Production Plan</h2>
    <form action="plan.php" method="post">
       
    <label for="work_order_ids">Work Order IDs (comma-separated):</label>
        <input type="text" name="work_order_ids" id="work_order_ids">
        <button type="submit">Generate Plan</button>
    </form>
</body>
</html>

