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
        echo "<table class='production-table'>";
        echo "<tr><th>Tire ID</th><th>Description</th><th>Press Name</th><th>Mold Name</th><th>Cavity Name</th><th>Start Date</th><th>End Date</th><th>Tobe Amount</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $icode = $row['icode'];
            $description = $row['description'];
            $press_name = $row['press_name'];
            $mold_name = $row['mold_name'];
            $cavity_name = $row['cavity_name'];
            $start_date = $row['start_date'];
            $end_date = $row['end_date'];

            // Retrieve the "tobe" amount from the "tobeplan" table
            $tobeSql = "SELECT tobe FROM tobeplan WHERE icode = '$icode'";
            $tobeResult = mysqli_query($conn, $tobeSql);

            // Check if a matching entry exists in the "tobeplan" table
            if (mysqli_num_rows($tobeResult) > 0) {
                $tobeRow = mysqli_fetch_assoc($tobeResult);
                $tobe= $tobeRow['tobe'];
            } else {
                $tobe = 'N/A'; // or any default value you want to display
            }

            echo "<tr>";
            echo "<td>$icode</td>";
            echo "<td>$description</td>";
            echo "<td>$press_name</td>";
            echo "<td>$mold_name</td>";
            echo "<td>$cavity_name</td>";
            echo "<td>$start_date</td>";
            echo "<td>$end_date</td>";
            echo "<td>$tobe</td>";
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
    <style>
        .production-table {
            width: 100%;
            border-collapse: collapse;
        }

        .production-table th, .production-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .production-table th {
            background-color: #f2f2f2;
        }

        .production-table tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="erp">Enter ERP ID:</label>
        <input type="text" id="erp" name="erp" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>
