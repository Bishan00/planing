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
            echo "<tr><th>ICode</th><th>Description</th><th>Press</th><th>Mold</th><th>Cavity</th><th>Start Date</th><th>Finish Date</th></tr>";

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
                echo "<td></td>";
                echo "<td></td>";
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

    // Check if the query executed successfully
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pressId = $row['press_id'];
            $pressName = $row['press_name'];
            $availabilityDate = $row['availability_date'];
            $options[$pressId] = "Press $pressName (Available: $availabilityDate)";
        }
    }

    return $options;
}

// Function to retrieve available mold options for a given tire type
function getMoldOptions($conn, $erp, $icode) {
    $sql = "SELECT DISTINCT m.mold_id, m.mold_name, m.availability_date FROM mold m INNER JOIN production_plan pp ON m.mold_id = pp.mold_id WHERE pp.erp = '$erp' AND pp.icode = '$icode'";
    $result = mysqli_query($conn, $sql);
    $options = array();

    // Check if the query executed successfully
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $moldId = $row['mold_id'];
            $moldName = $row['mold_name'];
            $availabilityDate = $row['availability_date'];
            $options[$moldId] = "Mold $moldName (Available: $availabilityDate)";
        }
    }

    return $options;
}

// Function to retrieve available cavity options for a given tire type
function getCavityOptions($conn, $erp, $icode) {
    $sql = "SELECT DISTINCT c.cavity_id, c.cavity_name, c.availability_date FROM cavity c INNER JOIN production_plan pp ON c.cavity_id = pp.cavity_id WHERE pp.erp = '$erp' AND pp.icode = '$icode'";
    $result = mysqli_query($conn, $sql);
    $options = array();

    // Check if the query executed successfully
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cavityId = $row['cavity_id'];
            $cavityName = $row['cavity_name'];
            $availabilityDate = $row['availability_date'];
            $options[$cavityId] = "Cavity $cavityName (Available: $availabilityDate)";
        }
    }

    return $options;
}

// Function to generate HTML dropdown options
function getDropdownOptions($options) {
    $dropdown = '';

    foreach ($options as $value => $label) {
        $dropdown .= "<option value='$value'>$label</option>";
    }

    return $dropdown;
}

// Function to calculate the start and finish dates for each tire type
function calculateStartFinishDates($conn, $erp, $selectedData) {
    $dates = array();

    foreach ($selectedData as $icode => $values) {
        $press = $values['press'];
        $mold = $values['mold'];
        $cavity = $values['cavity'];

        // Retrieve the availability dates for the selected press, mold, and cavity
        $pressAvailabilityDate = getAvailabilityDate($conn, 'press', $press);
        $moldAvailabilityDate = getAvailabilityDate($conn, 'mold', $mold);
        $cavityAvailabilityDate = getAvailabilityDate($conn, 'cavity', $cavity);

        // Retrieve the time taken for the tire type from the tire table
        $timeTaken = getTimeTaken($conn, $icode);

        // Retrieve the amount of tires to be made for the tire type from the tobe table
        $amountToBeMade = getAmountToBeMade($conn, $erp, $icode);

        // Calculate the start date based on the availability dates
        $startDate = max($pressAvailabilityDate, $moldAvailabilityDate, $cavityAvailabilityDate);
        $total_time = $timeTaken * $amountToBeMade;
        // Calculate the finish date based on the start date and time taken
        $finishDate = date("Y-m-d H:i:s", strtotime("$startDate + $total_time minutes"));

        // Store the start and finish dates for the tire type
        $dates[$icode] = array(
            'start_date' => $startDate,
            'finish_date' => $finishDate
        );
    }

    return $dates;
}

// Function to retrieve the availability date for a given entity type (press, mold, cavity)
function getAvailabilityDate($conn, $entityType, $entityId) {
    $tableName = $entityType . 's'; // Assuming the table name follows the convention of appending 's' to the entity type
    $sql = "SELECT availability_date FROM $tableName WHERE ${entityType}_id = $entityId";
    $result = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['availability_date'];
    }

    return null;
}

// Function to retrieve the time taken for a given tire type from the tire table
function getTimeTaken($conn, $icode) {
    $sql = "SELECT time_taken FROM tire WHERE icode = '$icode'";
    $result = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['time_taken'];
    }

    return null;
}

// Function to retrieve the amount of tires to be made for a given tire type from the tobe table
function getAmountToBeMade($conn, $erp, $icode) {
    $sql = "SELECT  FROM tobe WHERE erp = '$erp' AND icode = '$icode'";
    $result = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['amount'];
    }

    return null;
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
</html>
<?php
// Check if the form is submitted with tire selections
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
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

    // Retrieve the selected tire data from the form submission
    $selectedData = array();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'press_') === 0) {
            $icode = substr($key, 6);
            $selectedData[$icode]['press'] = $value;
        } elseif (strpos($key, 'mold_') === 0) {
            $icode = substr($key, 5);
            $selectedData[$icode]['mold'] = $value;
        } elseif (strpos($key, 'cavity_') === 0) {
            $icode = substr($key, 7);
            $selectedData[$icode]['cavity'] = $value;
        }
    }

    // Calculate the start and finish dates for each tire type
    $startFinishDates = calculateStartFinishDates($conn, $erp, $selectedData);

    // Display the start and finish dates for each tire type
    echo "<h3>Start and Finish Dates for ERP: $erp</h3>";
    echo "<table>";
    echo "<tr><th>ICode</th><th>Description</th><th>Press</th><th>Mold</th><th>Cavity</th><th>Start Date</th><th>Finish Date</th></tr>";
    foreach ($selectedData as $icode => $values) {
        $description = getDescription($conn, $icode);
        $press = $values['press'];
        $mold = $values['mold'];
        $cavity = $values['cavity'];
        $startDate = $startFinishDates[$icode]['start_date'];
        $finishDate = $startFinishDates[$icode]['finish_date'];

        echo "<tr>";
        echo "<td>$icode</td>";
        echo "<td>$description</td>";
        echo "<td>$press</td>";
        echo "<td>$mold</td>";
        echo "<td>$cavity</td>";
        echo "<td>$startDate</td>";
        echo "<td>$finishDate</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Close the database connection
    mysqli_close($conn);
}

// Function to retrieve the description for a given tire type from the production_plan table
function getDescription($conn, $icode) {
    $sql = "SELECT description FROM production_plan WHERE icode = '$icode' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['description'];
    }

    return null;
}
?>
