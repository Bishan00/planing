<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Production Plan Editor</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="erp">ERP ID:</label>
            <input type="text" id="erp" name="erp" required>
            <button type="submit">Generate Plan</button>
        </form>
    </div>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Establish database connection
        $conn = mysqli_connect("localhost", "root", "", "task_management");

        // Retrieve the ERP ID from the form submission
        $erp = isset($_POST['erp']) ? $_POST['erp'] : '';

        // Validate the ERP ID (you can add your own validation logic here)
        if (empty($erp)) {
            die("Please enter a valid ERP ID");
        }

        // Sanitize the ERP ID to prevent SQL injection
        $erp = mysqli_real_escape_string($conn, $erp);

        // Retrieve the data from the production_plan table for the given ERP ID
        $sql = "SELECT DISTINCT icode, description, cuing_group_name FROM production_plan WHERE erp = '$erp'";

        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            die("Query error: " . mysqli_error($conn));
        }
        // Check if the query executed successfully
        if ($result) {
            // Check if there are any rows returned
            if (mysqli_num_rows($result) > 0) {
                echo "<h3>Production Plan for ERP: $erp</h3>";
                echo "<form method='post' action='savedata.php'>";
                echo "<input type='hidden' name='erp' value='$erp'>";
                echo "<table>";
                echo "<tr>
                        <th>ICode</th>
                        <th>Description</th>
                        <th>Curing Group</th>
                        <th>Press</th>
                        <th>Mold</th>
                        <th>Cavity</th>
                        <th>Order Quantity</th>
                        <th>To Be Produced</th>
                    </tr>";

                // Iterate over each row in the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    $icode = $row['icode'];
                    $description = $row['description'];
                    $curingGroup = $row['cuing_group_name'];

                    // Retrieve available press options for the tire type
                    $pressOptions = getPressOptions($conn, $erp, $icode);

                    echo "<tr>";
                    echo "<td>$icode</td>";
                    echo "<td>$description</td>";
                    echo "<td>$curingGroup</td>";

                    // Display the press and mold options
                    foreach ($pressOptions as $press_id => $pressData) {
                        $press_name = $pressData['press_name'];
                        $availability_date = $pressData['availability_date'];
                        $moldOptions = $pressData['mold_options'];

                        echo "<td><b>$press_name</b> (Availability Date: $availability_date)</td>";
                        echo "<td>$moldOptions</td>";
                        echo "<td><select name='cavity_$icode'>" . getCavityOptions($conn, $erp, $icode) . "</select></td>";
                        echo "<td>" . getTireSize($conn, $icode) . "</td>";
                        echo "<td>" . getTireQuantity($conn, $icode) . "</td>";
                    }

                    echo "</tr>";
                }

                echo "</table>";
                echo "<button type='submit' name='submit'>Submit</button>";
                echo "</form>";
            } else {
                echo "No data found in the production plan for ERP: $erp";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    }

    function getPressOptions($conn, $erp, $icode) {
        $sql = "SELECT DISTINCT p.press_id, p.press_name, p.availability_date
                FROM press p
                INNER JOIN production_plan pp ON p.press_id = pp.press_id
                WHERE pp.erp = '$erp' AND pp.icode = '$icode'
                ORDER BY p.availability_date ASC"; // Order by availability_date in ascending order
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            die("Query error: " . mysqli_error($conn));
        }

        $options = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $press_id = $row['press_id'];
            $press_name = $row['press_name'];
            $availability_date = $row['availability_date'];

            // Retrieve available mold options for the tire type and press combination
            $moldOptions = getMoldOptions($conn, $erp, $icode, $press_id);

            $options[$press_id] = array(
                'press_name' => $press_name,
                'availability_date' => $availability_date,
                'mold_options' => $moldOptions
            );
        }

        return $options;
    }

    function getMoldOptions($conn, $erp, $icode, $press_id) {
        $sql = "SELECT DISTINCT m.mold_id, m.mold_name, m.availability_date, m.quantity
                FROM mold m
                INNER JOIN production_plan pp ON m.mold_id = pp.mold_id
                WHERE pp.erp = '$erp' AND pp.icode = '$icode' AND pp.press_id = '$press_id'
                ORDER BY m.availability_date ASC"; // Order by availability_date in ascending order
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            die("Query error: " . mysqli_error($conn));
        }

        $options = '';
        while ($row = mysqli_fetch_assoc($result)) {
            $mold_id = $row['mold_id'];
            $mold_name = $row['mold_name'];
            $availability_date = $row['availability_date'];
            $quantity = $row['quantity'];
            $options .= "<input type='checkbox' name='mold_" . $press_id . "[]' value='$mold_id'> $mold_name (Availability Date: $availability_date, Quantity: $quantity)<br>";
        }

        return $options;
    }

    function getCavityOptions($conn, $erp, $icode) {
        $sql = "SELECT DISTINCT c.cavity_id, c.cavity_name, c.availability_date
                FROM cavity c
                INNER JOIN production_plan pp ON c.cavity_id = pp.cavity_id
                WHERE pp.erp = '$erp' AND pp.icode = '$icode'
                ORDER BY c.availability_date ASC"; // Order by availability_date in ascending order
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            die("Query error: " . mysqli_error($conn));
        }

        $options = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $cavity_id = $row['cavity_id'];
            $cavity_name = $row['cavity_name'];
            $availability_date = $row['availability_date'];
            $options[$cavity_id] = $cavity_name . " (Availability Date: " . $availability_date . ")";
        }

        $dropdown = "";
        foreach ($options as $value => $label) {
            $dropdown .= "<option value='$value'>$label</option>";
        }

        return $dropdown;
    }

    function getTireQuantity($conn, $icode) {
        // Replace 'tobeplan' with the actual table name where the tire quantity is stored
        $sql = "SELECT tobe FROM tobeplan WHERE icode = '$icode'";
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            die("Query error: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['tobe'];
        }

        return 'N/A';
    }

    function getTireSize($conn, $icode) {
        // Replace 'tire' with the actual table name where tire sizes are stored
        $sql = "SELECT new FROM worder WHERE icode = '$icode'";
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            die("Query error: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['new'];
        }

        return 'N/A';
    }
    ?>
</body>
</html>
