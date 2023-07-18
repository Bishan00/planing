<?php
// MySQL database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Create a new MySQLi instance
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve unique cavity IDs matching each iCode
$sql = "SELECT icode, GROUP_CONCAT(DISTINCT cavity_id) AS cavity_ids
        FROM production_plan
        GROUP BY icode";

// Execute the query
$result = $conn->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Prepare the INSERT statement for the tire_molddd table
    $insertSql = "INSERT INTO tire_cavity(icode, cavity_id) VALUES ";

    // Loop through the result and build the VALUES part of the INSERT statement
    $values = [];
    while ($row = $result->fetch_assoc()) {
        $icode = $row["icode"];
        $moldIds = $row["cavity_ids"];
        
        // Split the mold_ids into an array
        $moldIdsArray = explode(",", $moldIds);
        
        // Remove any duplicate mold_ids
        $uniqueMoldIds = array_unique($moldIdsArray);
        
        // Build the values string for each unique mold_id
        foreach ($uniqueMoldIds as $moldId) {
            $values[] = "('$icode', '$moldId')";
        }
    }

    // Combine all the values into a single string
    $valuesString = implode(", ", $values);

    // Complete the INSERT statement
    $insertSql .= $valuesString;

    // Execute the INSERT statement
    if ($conn->query($insertSql) === TRUE) {
        echo "Data inserted into tire_molddd successfully.";
    } else {
        echo "Error inserting data into tire_molddd: " . $conn->error;
    }
} else {
    echo "No data found in the production_plan table.";
}

// Close the connection
$conn->close();

header("Location: tire_mold.php");
exit();
?>
