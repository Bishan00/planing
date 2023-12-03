<?php
// Connection details
$host = 'localhost';
$username = 'planatir_task_management';
$password = 'Bishan@1919';
$database = 'planatir_task_management';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the total number of distinct erp values
$sql = "SELECT COUNT(DISTINCT erp) as total_erp FROM dwork2";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    echo "Total number of distinct erp values: " . $row["total_erp"];
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
