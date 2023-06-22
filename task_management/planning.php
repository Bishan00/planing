
<?php

include './includes/admin_header.php';
include './includes/data_base_save_update.php';
include 'includes/App_Code.php';
// Establish database connection (same as in the original file)
$conn = mysqli_connect("localhost", "root", "", "task_management");

// Check if the connection is successful (same as in the original file)
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the ERP number from the form input
    $erp = isset($_POST['erp']) ? $_POST['erp'] : '';

    // Validate the ERP number (you can add your own validation logic here)
    if (empty($erp)) {
        die("Invalid ERP ID");
    }

    // Retrieve the production plan details for the ERP number
    $sql = "SELECT * FROM production_plan WHERE erp = '$erp'";
    $result = mysqli_query($conn, $sql);

    // Check if any production plan entries exist
    if (mysqli_num_rows($result) > 0) {
        // Display the production plan details in a table
        echo "<h2>Production Plan Details for ERP ID: $erp</h2>";
        echo "<table>";
        echo "<tr><th>Tire ID</th><th>Press Name</th><th>Mold Name</th><th>Start Date</th><th>End Date</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $icode = $row['icode'];
            $press_name = $row['press_name'];
            $mold_name = $row['mold_name'];
            $start_date = $row['start_date'];
            $end_date = $row['end_date'];

            echo "<tr>";
            echo "<td>$icode</td>";
            echo "<td>$press_name</td>";
            echo "<td>$mold_name</td>";
            echo "<td>$start_date</td>";
            echo "<td>$end_date</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No production plan details found for the provided ERP ID.";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Production Plan Lookup</title>
</head>
<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="erp">Enter ERP ID:</label>
        <input type="text" id="erp" name="erp" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>
