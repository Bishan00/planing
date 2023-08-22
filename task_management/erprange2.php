<!DOCTYPE html>
<html>
<head>
    <title>Production Plan Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 20px;
        }

        .production-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        .production-table th, .production-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .production-table th {
            background-color: #f2f2f2;
        }

        .erp-window {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            padding: 8px;
        }

        button[type="submit"] {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

          /* ... your existing styles ... */

    .erp-window span.green {
        color: green;
    }

    .erp-window span.red {
        color: red;
    }
    </style>
<form action="erprange2.php" method="get"> <!-- or method="post" -->
        <label for="icode">Enter iCode:</label>
        <input type="text" id="icode" name="icode">
        <button type="submit">Submit</button>
    </form>


    <?php
    // Establish database connection
    $conn = mysqli_connect("localhost", "root", "", "task_management");

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Add this at the beginning of your PHP code
    $icode = isset($_GET['icode']) ? $_GET['icode'] : '';

    // Sanitize the input to prevent SQL injection
    $icode = mysqli_real_escape_string($conn, $icode);

    // Retrieve all unique ERP numbers
    $erpSql = "SELECT DISTINCT erp FROM worder";
    $erpResult = mysqli_query($conn, $erpSql);

    // Check if the query was successful
    if ($erpResult) {
        // Check if any ERP numbers exist
        if (mysqli_num_rows($erpResult) > 0) {
            // Retrieve all work orders related to the provided icode
            $workOrderSql = "SELECT DISTINCT erp, icode, new FROM worder WHERE icode = '$icode'";
            $workOrderResult = mysqli_query($conn, $workOrderSql);

            // Check if the query was successful
            if ($workOrderResult) {
                // Create an array to store work order data
                $workOrders = [];

                // Iterate through each work order
                while ($workOrderRow = mysqli_fetch_assoc($workOrderResult)) {
                    $erp = $workOrderRow['erp'];
                    $icode = $workOrderRow['icode'];
                    $new = $workOrderRow['new'];

                    // Set the new value related to each tire type
                    if (!isset($workOrders[$icode])) {
                        $workOrders[$icode] = [];
                    }
                    $workOrders[$icode][$erp]['new'] = $new;
                }
// Display the production plan details in a table
echo "<table class='production-table'>";
echo "<tr><th>Tire ID</th>";
echo "<th>Description</th>";
echo "<th>Brand</th>";
echo "<th>Color</th>";
echo "<th>Curing Time</th>";
echo "<th>Curing Group</th>";
echo "<th>Stock on Hand</th>"; // New column for Stock on Hand

// Add a header for the total requirement column
echo "<th>Total Requirement</th>";
// Display the ERP numbers horizontally
while ($erpRow = mysqli_fetch_assoc($erpResult)) {
    $erp = $erpRow['erp'];
    echo "<th>ERP Number: $erp</th>";
}

echo "</tr>";

// Display the work order data vertically
foreach ($workOrders as $icode => $workOrderData) {
    echo "<tr>";
    echo "<td>$icode</td>";

    // Fetch the ERP numbers again for the inner loop
    $erpResult = mysqli_query($conn, $erpSql);

    // Retrieve Brand, Color, Curing Time, and Curing Group from the selectpress table
    $selectPressSql = "SELECT brand, col, curing_id, curing_group, description FROM selectpress WHERE icode = '$icode'";
    $selectPressResult = mysqli_query($conn, $selectPressSql);

    if ($selectPressResult) {
        $selectPressRow = mysqli_fetch_assoc($selectPressResult);
        $brand = $selectPressRow['brand'];
        $color = $selectPressRow['col'];
        $curingTime = $selectPressRow['curing_id'];
        $curingGroup = $selectPressRow['curing_group'];
        $description = $selectPressRow['description'];

        // Display the tire description, brand, color, curing time, and curing group in separate columns
        echo "<td>$description</td>";
        echo "<td>$brand</td>";
        echo "<td>$color</td>";
        echo "<td>$curingTime</td>";
        echo "<td>$curingGroup</td>";

        // Retrieve the suitable amount of cstock from the realstock table
        $realStockSql = "SELECT cstock FROM realstock WHERE icode = '$icode'";
        $realStockResult = mysqli_query($conn, $realStockSql);

        if ($realStockResult) { 
            $realStockRow = mysqli_fetch_assoc($realStockResult);
            $stockOnHand = $realStockRow['cstock'];

           // Display the stock on hand in a separate column
           echo "<td>$stockOnHand</td>";

           // Display the total requirement in a separate column
           $totalRequirement = isset($totals[$icode]) ? $totals[$icode] : "";
           echo "<td>$totalRequirement</td>";

           foreach ($erpResult as $erpRow) {
            $erp = $erpRow['erp'];
            $new = isset($workOrderData[$erp]['new']) ? $workOrderData[$erp]['new'] : "";
            $tobe = "";
        
            // Retrieve the "tobe" value from the tobeplan1 table
            $tobeSql = "SELECT tobe FROM tobeplan1 WHERE erp = '$erp' AND icode = '$icode'";
            $tobeResult = mysqli_query($conn, $tobeSql);
        
            if ($tobeResult && mysqli_num_rows($tobeResult) > 0) {
                $tobeRow = mysqli_fetch_assoc($tobeResult);
                $tobe = $tobeRow['tobe'];
            }
        
            echo "<td>";
            echo "<div class='erp-window'>";
            echo "<span class='" . ($new > 0 ? 'green' : '') . "'>Order Quantity: $new</span><br>";
            echo "<span class='" . ($tobe > 0 ? 'red' : '') . "'>Tobe: $tobe</span><br>";
            echo "</div>";
            echo "</td>";
        }
        } else {
            echo "Error executing realstock query: " . mysqli_error($conn);
        }
    } else {
        echo "Error executing selectpress query: " . mysqli_error($conn);
    }

    echo "</tr>";
}

echo "</table>";
} else {
echo "Error executing work order query: " . mysqli_error($conn);
}
} else {
echo "No ERP numbers found in the database.";
}
} else {
echo "Error executing ERP query: " . mysqli_error($conn);
}

                // Close the database connection
                mysqli_close($conn);
          
    ?>
</body>
</html>
