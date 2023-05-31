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

// Function to calculate end date based on start date and time taken
function calculateEndDate($start_date, $time_taken) {
    $start_timestamp = strtotime($start_date);
    $end_timestamp = $start_timestamp + ($time_taken * 60);
    $end_date = date('Y-m-d H:i:s', $end_timestamp);
    return $end_date;
}

// Get the work order IDs from the button click
if (isset($_POST['work_order_ids'])) {
    $work_order_ids = $_POST['work_order_ids'];

    // Retrieve the work order details
    $sql = "SELECT wo.work_order_id, wo.tire_id, wo.quantity, t.time_taken
            FROM work_order wo
            INNER JOIN tire t ON wo.tire_id = t.tire_id
            WHERE wo.work_order_id IN ($work_order_ids)";
    $result = mysqli_query($conn, $sql);

    // Iterate through the work orders
    while ($row = mysqli_fetch_assoc($result)) {
        $work_order_id = $row['work_order_id'];
        $tire_id = $row['tire_id'];
        $quantity = $row['quantity'];
        $time_taken = $row['time_taken'];

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
                $start_date = date('Y-m-d H:i:s', strtotime($last_start_date) + ($time_taken * 60));
                $end_date = calculateEndDate($start_date, $time_taken);

                // Insert the production
                  // Insert the production plan into the database
$sql = "INSERT INTO production_plan (work_order_id, press_id, mold_id, start_date, end_date)
VALUES ($work_order_id, $press_id, $mold_id, '$start_date', '$end_date')";
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

// Close the database connection
mysqli_close($conn);

}

// Retrieve the planned tires, sizes, molds, and presses for a specific date
if (isset($_POST['specific_date'])) {
$specific_date = $_POST['specific_date'];

$sql = "SELECT w.work_order_id, t.tire_id, t.time_taken, w.quantity, p.mold_id, p.press_id
        FROM production_plan p
        INNER JOIN work_order w ON p.work_order_id = w.work_order_id
        INNER JOIN tire t ON w.tire_id = t.tire_id
        WHERE DATE(p.start_date) = '$specific_date'";
$result = mysqli_query($conn, $sql);

// Display the results
echo "<h2>Planned Tires for Date: $specific_date</h2>";
echo "<table>
        <tr>
            <th>Work Order ID</th>
            <th>Tire ID</th>
            <th>Time Taken (minutes)</th>
            <th>Quantity</th>
            <th>Mold ID</th>
            <th>Press ID</th>
        </tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['work_order_id'] . "</td>";
    echo "<td>" . $row['tire_id'] . "</td>";
    echo "<td>" . $row['time_taken'] . "</td>";
    echo "<td>" . $row['quantity'] . "</td>";
    echo "<td>" . $row['mold_id'] . "</td>";
    echo "<td>" . $row['press_id'] . "</td>";
    echo "</tr>";
}
echo "</table>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Production Plan</title>
</head>
<body>
    <h2>Generate Production Plan</h2>
    <form method="POST" action="">
        <label for="work_order_ids">Work Order IDs (comma-separated):</label>
        <input type="text" name="work_order_ids" id="work_order_ids" required>
        <button type="submit">Generate Production Plan</button>
    </form>

    <h2>View Planned Tires for Specific Date</h2>
<form method="POST" action="">
    <label for="specific_date">Specific Date:</label>
    <input type="date" name="specific_date" id="specific_date" required>
    <button type="submit">View Planned Tires</button>
</form>

</body>
</html>