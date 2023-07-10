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
    include './includes/admin_header.php';
    include './includes/data_base_save_update.php';
    include 'includes/App_Code.php';

    // Establish database connection
    $conn = mysqli_connect("localhost", "root", "", "task_management");

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve all unique ERP numbers
    $erpSql = "SELECT DISTINCT erp FROM plannew";
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

                // Retrieve the tobe values for each tire type
                $tobeSql = "SELECT icode, erp, tobe FROM tobeplan";
                $tobeResult = mysqli_query($conn, $tobeSql);

                // Check if the query was successful
                if ($tobeResult) {
                    // Iterate through each tobe value
                    while ($tobeRow = mysqli_fetch_assoc($tobeResult)) {
                        $icode = $tobeRow['icode'];
                        $erp = $tobeRow['erp'];
                        $tobe = $tobeRow['tobe'];

                        // Set the tobe value related to each tire type
                        if (isset($workOrders[$icode][$erp])) {
                            $workOrders[$icode][$erp]['tobe'] = $tobe;
                        }
                    }
                } else {
                    echo "Error executing tobe query: " . mysqli_error($conn);
                }

                // Display the production plan details in a table
                echo "<table class='production-table'>";
                echo "<tr><th>Tire ID</th>";
                echo "<th>Description</th>";
                echo "<th>Brand</th>";
                echo "<th>Color</th>";
                echo "<th>Curing Time</th>";
                echo "<th>Curing Group</th>";

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

                        foreach ($erpResult as $erpRow) {
                            $erp = $erpRow['erp'];
                            $new = isset($workOrderData[$erp]['new']) ? $workOrderData[$erp]['new'] : "";
                            $tobe = isset($workOrderData[$erp]['tobe']) ? $workOrderData[$erp]['tobe'] : "";

                            echo "<td>";
                            echo "<div class='erp-window'>";
                            echo "<span>New: $new</span><br>";
                            echo "<span>Tobe: $tobe</span><br>";
                            echo "</div>";
                            echo "</td>";
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

