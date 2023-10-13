
<!DOCTYPE html>
<html>
<head>
   



   
    <title>Select ERP Number</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        select {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        button:hover {
            background-color: darkblue;
        }
    </style>

</head>
<body>
    <form action="indwork.php" method="post">
        <label for="erpNumber">Select ERP Number:</label>
        <select id="erpNumber" name="erpNumber">
            <!-- Populate the dropdown menu with ERP numbers from your database -->
            <?php
            // Establish database connection
            $conn = mysqli_connect("localhost", "planatir_task_management", "Bishan@1919", "planatir_task_management");

            // Check if the connection is successful
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Retrieve all unique ERP numbers
            $erpSql = "SELECT DISTINCT erp FROM plannew";
            $erpResult = mysqli_query($conn, $erpSql);

            // Check if the query was successful and if there are any ERP numbers
            if ($erpResult && mysqli_num_rows($erpResult) > 0) {
                while ($erpRow = mysqli_fetch_assoc($erpResult)) {
                    $erp = $erpRow['erp'];
                    echo "<option value='$erp'>$erp</option>";
                }
            }
            ?>
        </select>
        <button type="submit">Submit</button>
    </form>
</body>
</html>



<!DOCTYPE html>
<html>
<head>
    <title>Production Plan Details</title>
    <style>
        .production-table {
            border-collapse: collapse;
            width: 100%;
        }

        .production-table th, .production-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .erp-window {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 4px;
        }
    </style>
</head>
<body>
<?php
    // Check if the form is submitted and the ERP number is selected
    if (isset($_POST['erpNumber'])) {
        $selectedErpNumber = $_POST['erpNumber'];

        

        // Establish database connection
        $conn = mysqli_connect("localhost", "planatir_task_management", "Bishan@1919", "planatir_task_management");

        // Check if the connection is successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve all work orders for the selected ERP number
        $workOrderSql = "SELECT DISTINCT icode, new FROM worder WHERE erp = '$selectedErpNumber'";
        $workOrderResult = mysqli_query($conn, $workOrderSql);

    // Check if the query was successful
    if ($workOrderResult) {
        // Create an array to store work order data
        $workOrders = [];

        // Iterate through each work order
        while ($workOrderRow = mysqli_fetch_assoc($workOrderResult)) {
            $icode = $workOrderRow['icode'];
            $new = $workOrderRow['new'];

            // Set the new value related to each tire type
            if (!isset($workOrders[$icode])) {
                $workOrders[$icode] = [];
            }
            $workOrders[$icode]['new'] = $new;
        }

        // Calculate the total requirement for each tire type
        $totals = [];
        foreach ($workOrders as $icode => $workOrderData) {
            $total = $workOrderData['new'];
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
        // Display the single ERP number horizontally (since there's only one)
        echo "<th>ERP Number: $selectedErpNumber</th>";

        echo "</tr>";

        // Display the work order data vertically (for the selected ERP number only)
        foreach ($workOrders as $icode => $workOrderData) {
            echo "<tr>";
            echo "<td>$icode</td>";

            // Fetch additional tire information from the selectpress table
            $selectPressSql = "SELECT brand, col, curing_id, curing_group, description FROM selectpress WHERE icode = '$icode'";
            $selectPressResult = mysqli_query($conn, $selectPressSql);

            if ($selectPressResult && mysqli_num_rows($selectPressResult) > 0) {
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

                // Fetch the stock on hand from the realstock table
                $realStockSql = "SELECT cstock FROM realstock WHERE icode = '$icode'";
                $realStockResult = mysqli_query($conn, $realStockSql);

                if ($realStockResult && mysqli_num_rows($realStockResult) > 0) {
                    $realStockRow = mysqli_fetch_assoc($realStockResult);
                    $stockOnHand = $realStockRow['cstock'];

                    // Display the stock on hand in a separate column
                    echo "<td>$stockOnHand</td>";

                    // Display the total requirement in a separate column
                    $totalRequirement = isset($totals[$icode]) ? $totals[$icode] : "";
                    echo "<td>$totalRequirement</td>";

                    // Display the new and tobe quantities for the selected ERP number
                    $new = $workOrderData['new'];
             // Fetch the "tobe" quantity from the "tobeplan1" table
             $tobePlanSql = "SELECT tobe FROM tobeplan1 WHERE erp = '$selectedErpNumber' AND icode = '$icode'";
             $tobePlanResult = mysqli_query($conn, $tobePlanSql);

             if ($tobePlanResult && mysqli_num_rows($tobePlanResult) > 0) {
                 $tobePlanRow = mysqli_fetch_assoc($tobePlanResult);
                 $tobeQuantity = $tobePlanRow['tobe'];

             
             } else {
                 echo "<td>Error: Tobe Quantity not available</td>";
             }

                    echo "<td>";
                    echo "<div class='erp-window'>";
                    echo "<span>Order Quantity: $new</span><br>";
                    echo "<span>Tobe: $tobeQuantity</span><br>";
                    echo "</div>";
                    echo "</td>";
                } else {
                    echo "<td colspan='3'>Error: Stock on Hand not available</td>";
                }
            } else {
                echo "<td colspan='8'>Error: Tire information not available</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Error executing work order query: " . mysqli_error($conn);
    }

     // Close the database connection
     mysqli_close($conn);
    } else {
        echo "Please select an ERP number.";
    }
    ?>
</body>
</html>