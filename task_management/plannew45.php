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
            echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
            echo "<input type='hidden' name='erp' value='$erp'>";
            echo "<table>";
            echo "<tr><th>ICode</th><th>Description</th><th>Press</th><th>Mold</th><th>Cavity</th></tr>";

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

                echo "<tr>";
                echo "<td>$icode</td>";
                echo "<td>$description</td>";
                echo "<td><select name='press_$icode'>" . getDropdownOptions($pressOptions) . "</select></td>";
                echo "<td><select name='mold_$icode'>" . getDropdownOptions($moldOptions) . "</select></td>";
                echo "<td><select name='cavity_$icode'>" . getDropdownOptions($cavityOptions) . "</select></td>";
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

// Function to retrieve available press options for a given tire type
function getPressOptions($conn, $erp, $icode) {
    $sql = "SELECT DISTINCT p.press_id, p.press_name, p.availability_date FROM press p INNER JOIN production_plan pp ON p.press_id = pp.press_id WHERE pp.erp = '$erp' AND pp.icode = '$icode'";
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

// Function to retrieve available mold options for a given tire type
function getMoldOptions($conn, $erp, $icode) {
    $sql = "SELECT DISTINCT m.mold_id, m.mold_name, m.availability_date FROM mold m INNER JOIN production_plan pp ON m.mold_id = pp.mold_id WHERE pp.erp = '$erp' AND pp.icode = '$icode'";
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

// Function to retrieve available cavity options for a given tire type
function getCavityOptions($conn, $erp, $icode) {
    $sql = "SELECT DISTINCT c.cavity_id, c.cavity_name, c.availability_date FROM cavity c INNER JOIN production_plan pp ON c.cavity_id = pp.cavity_id WHERE pp.erp = '$erp' AND pp.icode = '$icode'";
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

// Function to generate the dropdown options HTML
function getDropdownOptions($options) {
    $html = "";
    foreach ($options as $value => $label) {
        $html .= "<option value='$value'>$label</option>";
    }
    return $html;
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Production Plan Editor</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h2>Production Plan Editor</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="erp">ERP ID:</label>
        <input type="text" id="erp" name="erp" required>
        <button type="submit">Generate Plan</button>
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

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
                echo "<h3>Selected Values:</h3>";
                echo "<table>";
                echo "<tr><th>ICode</th><th>Description</th><th>Press</th><th>Mold</th><th>Cavity</th></tr>";

                // Iterate over each row in the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    $icode = $row['icode'];
                    $description = $row['description'];

                    // Retrieve the selected press value
                    $press = isset($_POST['press_' . $icode]) ? $_POST['press_' . $icode] : '';

                    // Retrieve the selected mold value
                    $mold = isset($_POST['mold_' . $icode]) ? $_POST['mold_' . $icode] : '';

                    // Retrieve the selected cavity value
                    $cavity = isset($_POST['cavity_' . $icode]) ? $_POST['cavity_' . $icode] : '';
                          
                      // Save the selected values to the database
                saveSelectedValues($erp, $icode, $press, $mold, $cavity);
                 

                    echo "<tr>";
                    echo "<td>$icode</td>";
                    echo "<td>$description</td>";
                    echo "<td>$press</td>";
                    echo "<td>$mold</td>";
                    echo "<td>$cavity</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "No data found in the production plan for ERP: $erp";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Function to save the selected values to the database
function saveSelectedValues($erp, $icode, $press, $mold, $cavity) {
    // Re-establish the database connection
    $conn = mysqli_connect("localhost", "root", "", "task_management");

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the INSERT statement
    $sql = "INSERT INTO selected_data (erp, icode, press, mold, cavity) VALUES ('$erp', '$icode', '$press', '$mold', '$cavity')";

    // Execute the INSERT statement
    if (mysqli_query($conn, $sql)) {
        // Data inserted successfully
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
    ?>
</body>
</html>
