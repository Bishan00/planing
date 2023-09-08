<?php
// Replace with your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select distinct mold IDs, cavity IDs, and the first start date
$sql = "SELECT DISTINCT mold_id, cavity_id, MIN(start_date) AS first_start_date
        FROM merged_data
        GROUP BY mold_id, cavity_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Prepare an INSERT statement for the destination table
    $insertSql = "INSERT INTO match_table (mold_id, cavity_id, first_start_date, press_id, press_name) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);

    if (!$stmt) {
        die("Error preparing the INSERT statement: " . $conn->error);
    }

    while ($row = $result->fetch_assoc()) {
        $moldId = $row["mold_id"];
        $cavityId = $row["cavity_id"];
        $firstStartDate = $row["first_start_date"];

        // Retrieve press_id from the press_cavity table based on cavity_id
        $pressSql = "SELECT press_id FROM press_cavity WHERE cavity_id = $cavityId";
        $pressResult = $conn->query($pressSql);
        $pressRow = $pressResult->fetch_assoc();
        $pressId = $pressRow["press_id"];

        // Retrieve press_name from the press table based on press_id
        $pressNameSql = "SELECT press_name FROM press WHERE press_id = $pressId";
        $pressNameResult = $conn->query($pressNameSql);
        $pressNameRow = $pressNameResult->fetch_assoc();
        $pressName = $pressNameRow["press_name"];

        // Insert the data into the destination table
        $stmt->bind_param("iissi", $moldId, $cavityId, $firstStartDate, $pressId, $pressName);
        if (!$stmt->execute()) {
            die("Error inserting data: " . $stmt->error);
        }
    }

    // Close the statement
    $stmt->close();
} else {
    echo "No matching mold IDs found.";
}

// Close the database connections
$result->close();
$conn->close();

header("Location: inddelete2.php");
exit();
?>
