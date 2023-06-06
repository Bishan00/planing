<!DOCTYPE html>
<html>
<head>
    <title>View Planned Tires</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <form method="POST" action="checkplan.php">
        <label for="specific_date">Enter Date:</label>
        <input type="date" id="specific_date" name="specific_date">
        <input type="submit" value="View Planned Tires">
    </form>

    <?php
        // Place the PHP code here (as provided in the previous response)
    ?>
</body>
</html>


<?php
// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "bishnplan");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// View Planned Tires for Specific Date
if (isset($_POST['specific_date'])) {
    $specific_date = $_POST['specific_date'];

    $sql = "SELECT p.work_order_id, t.tire_id, t.time_taken, p.quantity, m.mold_id, m.mold_name, pr.press_id, pr.press_name
            FROM production_plan p
            INNER JOIN work_order w ON p.work_order_id = w.work_order_id
            INNER JOIN tire t ON w.tire_id = t.tire_id
            INNER JOIN mold m ON p.mold_id = m.mold_id
            INNER JOIN press pr ON p.press_id = pr.press_id
            WHERE DATE(p.start_date) = '$specific_date'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Display the results
        echo "<h2>Planned Tires for Date: $specific_date</h2>";
        echo "<table>
                <tr>
                    <th>Work Order ID</th>
                    <th>Tire ID</th>
                    <th>Time Taken (minutes)</th>
                    <th>Quantity</th>
                    <th>Mold ID</th>
                    <th>Mold Name</th>
                    <th>Press ID</th>
                    <th>Press Name</th>
                </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['work_order_id'] . "</td>";
            echo "<td>" . $row['tire_id'] . "</td>";
            echo "<td>" . $row['time_taken'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['mold_id'] . "</td>";
            echo "<td>" . $row['mold_name'] . "</td>";
            echo "<td>" . $row['press_id'] . "</td>";
            echo "<td>" . $row['press_name'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        // Display an error message if the query fails or no rows are returned
        if ($result === false) {
            echo "Query error: " . mysqli_error($conn);
        } else {
            echo "No planned tires found for the specified date.";
        }
    }
}
