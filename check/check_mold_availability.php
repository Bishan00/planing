<?php
// MySQL connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "check";

// Connect to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve all tire IDs from the "auto" table
$sql = "SELECT tire_id FROM auto";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tireId = $row['tire_id'];

        // Query to check if there is an available mold type for the current tire ID
        $moldSql = "SELECT COUNT(*) AS count FROM press_list WHERE tire_id = $tireId";
        $moldResult = $conn->query($moldSql);

        if ($moldResult->num_rows > 0) {
            $moldRow = $moldResult->fetch_assoc();
            $count = $moldRow['count'];

            if ($count > 0) {
                echo "There is an available mold type for the tire ID: $tireId<br>";
            } else {
                echo "No available mold type found for the tire ID: $tireId<br>";
            }
        } else {
            echo "Error retrieving mold information for tire ID: $tireId<br>";
        }
    }
} else {
    echo "No tire IDs found in the auto table.";
}

// Close the database connection
$conn->close();
?>
