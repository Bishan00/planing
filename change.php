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

    // Iterate through the work orders and update their priorities
    foreach ($work_orders as $work_order) {
        $work_order_id = $work_order['work_order_id'];
        $priority = $work_order['priority'];

        // Update the priority in the production plan
        $sql = "UPDATE production_plan SET priority = $priority WHERE work_order_id = $work_order_id";
        mysqli_query($conn, $sql);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Work Order Priority</title>
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
        <button type="submit">Update Priority</button>
    </form>
</body>
</html>
