
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
            echo "<tr><th>ICode</th><th>Description</th><th>Press</th><th>Mold</th><th>Cavity</th><th>Tire Quantity</th><th>Time Required</th><th>Start Date</th><th>Completion Date</th></tr>";

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

                // Retrieve time required for the tire type
                $timeRequired = getTimeRequired($conn, $icode);

                echo "<tr>";
                echo "<td>$icode</td>";
                echo "<td>$description</td>";
                echo "<td><select name='press_$icode'>" . getDropdownOptions($pressOptions) . "</select></td>";
                echo "<td><select name='mold_$icode'>" . getDropdownOptions($moldOptions) . "</select></td>";
                echo "<td><select name='cavity_$icode'>" . getDropdownOptions($cavityOptions) . "</select></td>";
                echo "<td>$tireQuantity</td>";
                echo "<td>$timeRequired</td>";

                // Retrieve the selected press value
                $selectedPress = isset($_POST['press_' . $icode]) ? $_POST['press_' . $icode] : '';

                // Retrieve the selected mold value
                $selectedMold = isset($_POST['mold_' . $icode]) ? $_POST['mold_' . $icode] : '';

                // Retrieve the selected cavity value
                $selectedCavity = isset($_POST['cavity_' . $icode]) ? $_POST['cavity_' . $icode] : '';
// Calculate the total time required for all the tires
$totalTimeRequired = $timeRequired * $tireQuantity;

// Calculate start date and completion date
$startDate = calculateStartDate($conn, $selectedPress, $selectedMold, $selectedCavity);
$completionDate = calculateCompletionDate($startDate, $totalTimeRequired);

echo "<td>$startDate</td>";
echo "<td>$completionDate</td>";
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

// Function to retrieve time required for a given tire type
function getTimeRequired($conn, $icode) {
    // Replace 'tire' with the actual table name where the time required is stored
    $sql = "SELECT time_taken FROM tire WHERE icode = '$icode'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['time_taken'];
    }

    return 'N/A';
}

// Function to calculate the start date based on selected options
function calculateStartDate($conn, $selectedPress, $selectedMold, $selectedCavity) {
    $pressAvailabilityDate = getAvailabilityDate($conn, 'press', $selectedPress);
    $moldAvailabilityDate = getAvailabilityDate($conn, 'mold', $selectedMold);
    $cavityAvailabilityDate = getAvailabilityDate($conn, 'cavity', $selectedCavity);

    // Start date is the maximum of the availability dates
    return max($pressAvailabilityDate, $moldAvailabilityDate, $cavityAvailabilityDate);
}

// Function to calculate the completion date based on start date and time required
function calculateCompletionDate($startDate, $timeRequired) {
    $startDate = strtotime($startDate);
    $completionDate = strtotime("+$timeRequired minutes", $startDate);
    return date('Y-m-d H:i:s', $completionDate);
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

// Function to generate dropdown options
function getDropdownOptions($options) {
    $dropdown = "";
    foreach ($options as $value => $label) {
        $dropdown .= "<option value='$value'>$label</option>";
    }
    return $dropdown;
}
?>
