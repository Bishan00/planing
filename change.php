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

// Get the work order IDs and their updated priorities from the button click (assuming it's sent as an array)
if (isset($_POST['work_orders'])) {
    $work_orders = $_POST['work_orders'];

    // Iterate through the work orders and update their priorities and end dates
    foreach ($work_orders as $work_order) {
        $work_order_id = $work_order['work_order_id'];
        $priority = $work_order['priority'];

        // Retrieve the time taken to make each type of tire
        $sql = "SELECT time_taken FROM tire WHERE tire_id = (
            SELECT tire_id FROM work_order WHERE work_order_id = $work_order_id
        )";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $time_taken = $row['time_taken'];

        // Calculate the end date for the production plan
        $start_date = date('Y-m-d H:i:s');
        $end_date = date('Y-m-d H:i:s', strtotime($start_date) + ($time_taken * 60));

        // Update the priority and end date in the production plan
        $sql = "UPDATE production_plan SET priority = $priority, end_date = '$end_date' WHERE work_order_id = $work_order_id";
        mysqli_query($conn, $sql);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forward Work Orders</title>
</head>
<body>
    <form method="POST" action="">
        <label for="work_orders">Work Orders:</label>
        <table>
            <tr>
                <th>Work Order ID</th>
                <th>Priority</th>
            </tr>
            <tr>
                <td><input type="text" name="work_orders[0][work_order_id]" required></td>
                <td><input type="text" name="work_orders[0][priority]" required></td>
            </tr>
            <tr>
                <td><input type="text" name="work_orders[1][work_order_id]" required></td>
                <td><input type="text" name="work_orders[1][priority]" required></td>
            </tr>
            <!-- Add more rows for additional work orders -->
        </table>
        <button type="submit">Forward Work Orders</button>
    </form>
</body>
</html>
