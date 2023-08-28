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

        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 20px;
        }
 /* ... your existing styles ... */

 .erp-window span.green {
        color: green;
    }

    .erp-window span.red {
        color: red;
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
    </style>

    </style>
</head>
<body>
    <h1>Production Plan Details</h1>
    <form action="erprange2.php" method="get">
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

    // Retrieve all unique ERP numbers
    $erpSql = "SELECT DISTINCT erp FROM worder";
    $erpResult = mysqli_query($conn, $erpSql);

    // Check if the query was successful
    if ($erpResult) {
        // Check if any ERP numbers exist
        if (mysqli_num_rows($erpResult) > 0) {
            // Store ERP numbers in an array
            $erpNumbers = array();
            while ($erpRow = mysqli_fetch_assoc($erpResult)) {
                $erpNumbers[] = $erpRow['erp'];
            }

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
// Assuming you have the $workOrders array and a database connection $conn

// Assuming you have the $workOrders array and a database connection $conn

$tobeTotals = [];

foreach ($workOrders as $icode => $workOrderData) {
    $totalTobe = 0;

    foreach ($workOrderData as $erp => $erpData) {
        $tobe = isset($erpData['new']) ? $erpData['new'] : "";

        // Sanitize variables before using in SQL query to prevent SQL injection
        $icodeSafe = mysqli_real_escape_string($conn, $icode);
        $erpSafe = mysqli_real_escape_string($conn, $erp);

        // Retrieve the "tobe" value from the tobeplan1 table for positive transitions
        $tobeSql = "SELECT SUM(tobe) AS totalTobe FROM tobeplan1 WHERE erp = '$erpSafe' AND icode = '$icodeSafe' AND tobe > 0";
        $tobeResult = mysqli_query($conn, $tobeSql);

        if ($tobeResult && mysqli_num_rows($tobeResult) > 0) {
            $tobeRow = mysqli_fetch_assoc($tobeResult);
            $tobe = $tobeRow['totalTobe'];
        } else {
            $tobe = 0; // Set to 0 if no positive transitions found
        }

        $totalTobe += $tobe;
    }

    $tobeTotals[$icode] = $totalTobe;
}

// Now $tobeTotals array contains the total "tobe" values with positive transitions for each "icode"


// Now $tobeTotals array contains the total "tobe" values for each "icode"


               // Calculate the total requirement for each "icode"
$totalRequirements = [];
foreach ($workOrders as $icode => $workOrderData) {
    $totalRequirement = 0;
    foreach ($workOrderData as $erpData) {
        $totalRequirement += $erpData['new'];
    }
    $totalRequirements[$icode] = $totalRequirement;
}

    // Calculate the sum of all "Total Requirement" values
    $totalRequirementSum = array_sum($totalRequirements);

    

 // Display the sum of all "Total Requirement" values above the "Total Requirement" column
 echo "<th colspan='" . (count($erpNumbers) + 1) . "'>Total Requirement Sum: $totalRequirementSum</th>";


 // Calculate the sum of all "Total Requirement" values
$totalRequirementSum = array_sum($totalRequirements);

// Calculate the sum of all "Total Tobe" values
$totalTobeSum = array_sum($tobeTotals);



// Display the sum of all "Total Tobe" values above the "Total Tobe" column
echo "<th><br>Total Tobe Sum: $totalTobeSum</th>";


                // Display the production plan details in a table
                echo "<table class='production-table'>";
                echo "<tr><th>Tire ID</th>";
               //echo "<th>Description</th>";
                //echo "<th>Brand</th>";
                //echo "<th>Color</th>";
               // echo "<th>Curing Time</th>";
                //echo "<th>Curing Group</th>";
                echo "<th>Stock on Hand</th>";
                echo "<th>Total Tobe</th>"; // New column for Total Tobe
                echo "<th>Total Requirement</th>"; // New column for Total Requirement

                // Display the ERP numbers horizontally
                foreach ($erpNumbers as $erp) {
                    echo "<th>ERP Number: $erp</th>";
                }

                echo "</tr>";

                // Display the work order data vertically
                foreach ($workOrders as $icode => $workOrderData) {
                    echo "<tr>";
                    echo "<td>$icode</td>";

                    // Fetch the ERP numbers again for the inner loop
                    mysqli_data_seek($erpResult, 0);

                    // Retrieve Brand, Color, Curing Time, and Curing Group from the selectpress table
                    $selectPressSql = "SELECT brand, col, curing_id, curing_group, description FROM selectpress WHERE icode = '$icode'";
                    $selectPressResult = mysqli_query($conn, $selectPressSql);

                    if ($selectPressResult) {
                        $selectPressRow = mysqli_fetch_assoc($selectPressResult);
                     //  $brand = $selectPressRow['brand'];
                       // $color = $selectPressRow['col'];
                       // $curingTime = $selectPressRow['curing_id'];
                        //$curingGroup = $selectPressRow['curing_group'];
                        //$description = $selectPressRow['description'];

                        // Display the tire description, brand, color, curing time, and curing group in separate columns
                       // echo "<td>$description</td>";
                      // echo "<td>$brand</td>";
                        //echo "<td>$color</td>";
                        //echo "<td>$curingTime</td>";
                      //  echo "<td>$curingGroup</td>";

                        // Retrieve the suitable amount of cstock from the realstock table
                        $realStockSql = "SELECT cstock FROM realstock WHERE icode = '$icode'";
                        $realStockResult = mysqli_query($conn, $realStockSql);
                    
                        if ($realStockResult) {
                            $realStockRow = mysqli_fetch_assoc($realStockResult);
                    
                            if ($realStockRow && isset($realStockRow['cstock'])) {
                                $stockOnHand = $realStockRow['cstock'];
                                // Display the stock on hand in a separate column
                                echo "<td>$stockOnHand</td>";
                            } else {
                                echo "<td>No Stock Data</td>"; // Handle the case when data is not available
                            }
                    
                            // Display the total "tobe" value for this "icode"
                            $totalTobe = isset($tobeTotals[$icode]) ? $tobeTotals[$icode] : 0; // Set a default value if the key doesn't exist
                            echo "<td>";
                            if ($totalTobe >= 0) {
                                echo $totalTobe;
                            } else {
                                echo "-";
                            }
                            echo "</td>";

                            if (isset($totalRequirements[$icode])) {
                                $totalRequirement = $totalRequirements[$icode];
                            } else {
                                $totalRequirement = 0; // Set a default value if the key doesn't exist
                            }
                            echo "<td>$totalRequirement</td>";
                        

                            foreach ($erpNumbers as $erp) {
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

                                // Display the Total Tobe column specific changes here
                                if ($erp === "Total Tobe") {
                                    if ($tobe >= 0) {
                                        echo "<span class='" . ($tobe > 0 ? 'red' : '') . "'>Tobe: $tobe</span><br>";
                                    } else {
                                        echo "<span class='red'>Tobe: -</span><br>";
                                    }
                                } else {
                                    echo "<span class='" . ($tobe > 0 ? 'red' : '') . "'>Tobe: $tobe</span><br>";
                                }

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
