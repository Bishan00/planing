<?php
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$source_dbname = "planatir_task_management"; // Source database containing 'press_sheet'
$destination_dbname = "planatir_task_management"; // Destination database for the vertical data

// Create a MySQL connection to the source database
$conn = new mysqli($servername, $username, $password, $source_dbname);

// Check connection
if ($conn->connect_error) {
    die("Source Connection failed: " . $conn->connect_error);
}

// Initialize an array to store the vertical data
$verticalData = array();

// Loop through columns 'Presses1' to 'Presses22'
for ($i = 1; $i <= 22; $i++) {
    $columnName = sprintf("Presses%d", $i);

    // Query to retrieve data from the current column
    $sql = "SELECT `$columnName` FROM `press_sheet`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Add data to the verticalData array
            $verticalData[] = $row[$columnName];
        }
    }
}

// Close the MySQL connection to the source database
$conn->close();

// Create a new MySQL connection to the destination database
$conn = new mysqli($servername, $username, $password, $destination_dbname);

// Check connection
if ($conn->connect_error) {
    die("Destination Connection failed: " . $conn->connect_error);
}

// Create the destination table 'vertical_press_data'
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS `vertical_press_data` (
    `Data` varchar(10) DEFAULT NULL
)";

if ($conn->query($sqlCreateTable) === TRUE) {
    // Insert vertical data into the 'vertical_press_data' table 10 times in sequence
    for ($i = 0; $i < 10; $i++) {
        foreach ($verticalData as $value) {
            $value = $conn->real_escape_string($value); // Sanitize input
            $sqlInsert = "INSERT INTO `vertical_press_data` (`Data`) VALUES ('$value')";
            $conn->query($sqlInsert);
        }
    }
    echo "Vertical data transferred to 'vertical_press_data' table successfully 10 times in sequence.";
} else {
    echo "Error creating 'vertical_press_data' table: " . $conn->error;
}

// Close the MySQL connection to the destination database
$conn->close();
?>
