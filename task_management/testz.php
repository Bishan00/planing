<?php
// Replace with your actual database credentials
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$dbname = "planatir_task_management";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through submitted data to update press columns
    foreach ($_POST as $pid => $selectedPress) {
        $updateQuery = "UPDATE main_data SET `Presses 01` = '$selectedPress', `Presses 02` = '$selectedPress', `Presses 03` = '$selectedPress' WHERE PID = '$pid'";
        $conn->query($updateQuery);
    }
}

// Query to retrieve data from the main_data table
$sql = "SELECT PID, `pid` FROM main_data";

// Execute the query
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}


// Check if there are results
if ($result->num_rows > 0) {
    echo "<form method='post'>";
    // Loop through the main_data rows
    while ($row = $result->fetch_assoc()) {
        $icode = $row['pid'];

        // Query to retrieve mold_id options based on icode from tire_molddd table
        $moldQuery = "SELECT mold_id FROM tire_molddd WHERE icode = '$icode'";
        $moldResult = $conn->query($moldQuery);

        echo "PID: " . $row['PID'] . "<br>";

        // Create a select input for each PID to choose the press
        echo "<select name='{$row['PID']}'>";
        while ($moldRow = $moldResult->fetch_assoc()) {
            $selected = ""; // Check if this mold matches the selected press
            // Assuming you have a mold_order column in tire_molddd
            if ($moldRow['mold_id'] == $selectedPress) {
                $selected = "selected";
            }
            echo "<option value='{$moldRow['mold_id']}' $selected>{$moldRow['mold_id']}</option>";
        }
        echo "</select><br><br>";
    }
    echo "<input type='submit' value='Update Presses'>";
    echo "</form>";
} else {
    echo "No results found.";
}

// Close the connection
$conn->close();
?>
