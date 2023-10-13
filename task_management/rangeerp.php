<!DOCTYPE html>
<html>
<head>
    <title>Production Plan Details</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        form input[type="text"],
        form input[type="submit"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        form input[type="submit"] {
            background-color: #007BFF; /* Change the background color to blue */
            color: white;
            cursor: pointer;
            /* Add hover effect */
            transition: background-color 0.3s ease-in-out;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .production-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        .production-table th,
        .production-table td {
            padding: 10px;
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
        }

        .erp-window span {
            display: block;
            margin-bottom: 4px;
        }

        .erp-number {
            font-weight: bold;
        }
   /* ... your existing styles ... */

   .erp-window span.green {
        color: green;
    }

    .erp-window span.red {
        color: red;
    }
        .stock-on-hand {
            font-weight: bold;
            color: #007BFF;
        }

        .total-requirement {
            font-weight: bold;
            color: #FFC107;
        }
    </style>
    
</head>
<body>
    <form method="get" action="">
        ERP Range: <input type="text" name="start_erp" placeholder="Start ERP">
        to <input type="text" name="end_erp" placeholder="End ERP">
        <input type="submit" value="Submit">
    </form>

    <?php
    // Check if the form is submitted with the ERP range
    if (isset($_GET['start_erp']) && isset($_GET['end_erp'])) {
        // Establish database connection
        $conn = mysqli_connect("localhost", "planatir_task_management", "Bishan@1919", "planatir_task_management");

        // Check if the connection is successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $start_erp = $_GET['start_erp'];
        $end_erp = $_GET['end_erp'];

        // Modify the ERP query to get ERP numbers within the specified range
        $erpSql = "SELECT DISTINCT erp FROM plannew WHERE erp BETWEEN '$start_erp' AND '$end_erp'";
        $erpResult = mysqli_query($conn, $erpSql);

        // Check if the query was successful
        if ($erpResult) {

             // Check if any ERP numbers exist
        if (mysqli_num_rows($erpResult) > 0) {
            // Retrieve all work orders
            $workOrderSql = "SELECT DISTINCT erp, icode, new FROM worder";
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

               

                foreach ($workOrders as $icode => $workOrderData) {
                    $total = 0;
                    foreach ($workOrderData as $erpData) {
                        $total += $erpData['new'];
                    }
                    $totals[$icode] = $total;
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
            // Close the database connection
            mysqli_close($conn);
        } else {
            echo "No ERP numbers found in the database for the specified range.";
        }
    } else {
        echo "Error executing ERP query: " . mysqli_error($conn);
    }
}}
?>
</body>
</html>
  
