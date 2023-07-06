
<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
include 'includes/App_Code.php';

// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "task_management");

// Check if the connection is successful
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
    $sql = "SELECT * FROM plannew WHERE erp = '$erp'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        // Check if any production plan entries exist
        if (mysqli_num_rows($result) > 0) {
            // Display the production plan details in a table
            echo "<h2>Production Plan Details for ERP ID: $erp</h2>";
            echo "<table class='production-table'>";
            echo "<tr><th>Tire ID</th><th>Description</th><th>Press Name</th><th>Mold Name</th>
            <th>Cavity Name</th><th>Start Date</th><th>End Date</th><th>Order Quantity</th><th>Stock On Hand</th><th>To Be Produce</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                $icode = $row['icode'];
                $pressId = $row['press'];
                $moldId = $row['mold'];
                $cavityId = $row['cavity'];
                $start_date = $row['start_date'];
                $end_date = $row['end_date'];

                // Retrieve the press name for the given press ID
                $pressSql = "SELECT press_name FROM press WHERE press_id = '$pressId'";
                $pressResult = mysqli_query($conn, $pressSql);
                $pressName = '';

                if ($pressResult && mysqli_num_rows($pressResult) > 0) {
                    $pressRow = mysqli_fetch_assoc($pressResult);
                    $pressName = $pressRow['press_name'];
                }

                
                // Retrieve the mold name for the given mold ID
                $moldSql = "SELECT mold_name FROM mold WHERE mold_id = '$moldId'";
                $moldResult = mysqli_query($conn, $moldSql);
                $moldName = '';

                if ($moldResult && mysqli_num_rows($moldResult) > 0) {
                    $moldRow = mysqli_fetch_assoc($moldResult);
                    $moldName = $moldRow['mold_name'];
                }

                
                // Retrieve the cavity name for the given cavity ID
                $cavitySql = "SELECT cavity_name FROM cavity WHERE cavity_id = '$cavityId'";
                $cavityResult = mysqli_query($conn, $cavitySql);
                $cavityName = '';

                if ($cavityResult && mysqli_num_rows($cavityResult) > 0) {
                    $cavityRow = mysqli_fetch_assoc($cavityResult);
                    $cavityName = $cavityRow['cavity_name'];
                }
  // Retrieve the description of the tire from the tire table
  $tireSql = "SELECT description FROM tire WHERE icode = '$icode'";
  $tireResult = mysqli_query($conn, $tireSql);
  $description = '';

  if ($tireResult && mysqli_num_rows($tireResult) > 0) {
      $tireRow = mysqli_fetch_assoc($tireResult);
      $description = $tireRow['description'];
  }

  // Retrieve the tobe value for the given tire type
  $tobeSql = "SELECT tobe FROM tobeplan WHERE icode = '$icode' AND erp = '$erp'";
  $tobeResult = mysqli_query($conn, $tobeSql);
  $tobeValue = '';

  if ($tobeResult && mysqli_num_rows($tobeResult) > 0) {
      $tobeRow = mysqli_fetch_assoc($tobeResult);
      $tobeValue = $tobeRow['tobe'];
  }

  // Retrieve the cstock value for the given tire type
  $cstockSql = "SELECT cstock FROM stock WHERE icode = '$icode'";

  $cstockResult = mysqli_query($conn, $cstockSql);
  $cstockValue = '';

  if ($cstockResult && mysqli_num_rows($cstockResult) > 0) {
      $cstockRow = mysqli_fetch_assoc($cstockResult);
      $cstockValue = $cstockRow['cstock'];
  }
  // Retrieve the new value for the given tire type
  $newSql = "SELECT new FROM worder WHERE icode = '$icode' AND erp = '$erp'";
  $newResult = mysqli_query($conn, $newSql);
  $newValue = '';

  if ($newResult && mysqli_num_rows($newResult) > 0) {
      $newRow = mysqli_fetch_assoc($newResult);
      $newValue = $newRow['new'];
  }

                echo "<tr>";
                echo "<td>$icode</td>";
                echo "<td>$description</td>";
                echo "<td>$pressName</td>";
                echo "<td>$moldName</td>";
                echo "<td>$cavityName</td>";
                echo "<td>$start_date</td>";
                echo "<td>$end_date</td>";
                echo "<td>$newValue</td>";
                echo "<td>$cstockValue</td>";
                echo "<td>$tobeValue</td>";
              
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No production plan details found for the provided ERP ID.";
        }
    } else {
        echo "Error executing query: " . mysqli_error($conn);
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