
<html>
<head>
    <title>Production Plan Editor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            padding: 8px;
            width: 200px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            padding: 8px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        select {
            padding: 6px;
            width: 100%;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[name="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Colorful design */
        h2, button[type="submit"], button[name="submit"] {
            background-color: #2196F3;
        }

        th {
            background-color: #2196F3;
        }

        tr:nth-child(even) {
            background-color: #E3F2FD;
        }

        select[name^="press_"] {
            background-color: #BBDEFB;
            color: #000;
        }

        select[name^="mold_"] {
            background-color: #64B5F6;
            color: #fff;
        }

        select[name^="cavity_"] {
            background-color: #1976d1;
            color: #fff;
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

        <?php
        // ... The existing PHP code for generating the table ...
        ?>
    </div>
</body>
</html>


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
    $sql = "SELECT DISTINCT icode, description FROM production_plan WHERE erp = '$erp'";
    $result = mysqli_query($conn, $sql);

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
          
            <th>Press</th>
            <th>Mold</th>
            <th>Cavity</th>
            <th>Order Quantity</th>
            <th>To Be Produce</th>
          
          </tr>
          ";

            // Iterate over each row in the result set
            while ($row = mysqli_fetch_assoc($result)) {
                $icode = $row['icode'];
                $description = $row['description'];

                // Retrieve available press options for the tire type
                $pressOptions = getPressOptions($conn, $erp, $icode);

                // Retrieve available mold options for the tire type
                $moldOptions = getMoldOptions($conn, $erp, $icode);

                // Retrieve available cavity options for the tire type
                $cavityOptions = getCavityOptions($conn, $erp, $icode);

                // Retrieve tire quantity for the tire type
                $tireQuantity = getTireQuantity($conn, $icode);

             
// Retrieve tire size for the tire type
$tireSize = getTireSize($conn, $icode);

// ...

echo "<tr>";
echo "<td>$icode</td>";
echo "<td>$description</td>";

echo "<td><select name='press_$icode'>" . getDropdownOptions($pressOptions) . "</select></td>";
echo "<td><select name='mold_$icode'>" . getDropdownOptions($moldOptions) . "</select></td>";
echo "<td><select name='cavity_$icode'>" . getDropdownOptions($cavityOptions) . "</select></td>";
echo "<td>$tireSize</td>";
echo "<td>$tireQuantity</td>";



    
// Retrieve the selected press value
$selectedPress = isset($_POST['press_' . $icode]) ? $_POST['press_' . $icode] : '';

// Retrieve the selected mold value
$selectedMold = isset($_POST['mold_' . $icode]) ? $_POST['mold_' . $icode] : '';

// Retrieve the selected cavity value
$selectedCavity = isset($_POST['cavity_' . $icode]) ? $_POST['cavity_' . $icode] : '';



// ...


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

    $options = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $press_id = $row['press_id'];
        $press_name = $row['press_name'];
        $availability_date = $row['availability_date'];
        $options[$press_id] = $press_name . " (Availability Date: " . $availability_date . ")";
    }

    return $options;
}


function getMoldOptions($conn, $erp, $icode) {
    $sql = "SELECT DISTINCT m.mold_id, m.mold_name, m.availability_date
            FROM mold m
            INNER JOIN production_plan pp ON m.mold_id = pp.mold_id
            WHERE pp.erp = '$erp' AND pp.icode = '$icode'
            ORDER BY m.availability_date ASC"; // Order by availability_date in ascending order
    $result = mysqli_query($conn, $sql);

    $options = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $mold_id = $row['mold_id'];
        $mold_name = $row['mold_name'];
        $availability_date = $row['availability_date'];
        $options[$mold_id] = $mold_name . " (Availability Date: " . $availability_date . ")";
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

    $options = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $cavity_id = $row['cavity_id'];
        $cavity_name = $row['cavity_name'];
        $availability_date = $row['availability_date'];
        $options[$cavity_id] = $cavity_name . " (Availability Date: " . $availability_date . ")";
    }

    return $options;
}


// Function to retrieve tire quantity for a given tire type
function getTireQuantity($conn, $icode) {
    // Replace 'tobeplan' with the actual table name where the tire quantity is stored
    $sql = "SELECT tobe FROM tobeplan WHERE icode = '$icode'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['tobe'];
    }

    return 'N/A';
}



// Function to retrieve the availability date for a selected option
function getAvailabilityDate($conn, $table, $optionId) {
    $sql = "SELECT availability_date FROM $table WHERE $table"."_id = '$optionId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['availability_date'];
    }

    return 'N/A';
}
// Function to retrieve tire size for a given tire type
function getTireSize($conn, $icode) {
    // Replace 'tire' with the actual table name where tire sizes are stored
    $sql = "SELECT new FROM worder WHERE icode = '$icode'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['new'];
    }

    return 'N/A';
}



// Function to generate dropdown options
function getDropdownOptions($options) {
    $dropdown = "";
    foreach ($options as $value => $label) {
        $dropdown .= "<option value='$value'>$label</option>";
    }
    return $dropdown;
}



// Function to retrieve the number of tobes for a given tire type
function getTobeQuantity($conn, $icode) {
    // Replace 'tobeplan' with the actual table name where the tobe quantity is stored
    $sql = "SELECT tobe FROM tobeplan WHERE icode = '$icode'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['tobe'];
    }

    return 0; // Return 0 if no tobe quantity is found
}

?>

