<?php
// Database connection parameters
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$dbname = "planatir_task_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);


echo "Max Execution Time: " . ini_get('max_execution_time') . " seconds";

// Close the database connection
$conn->close();
}

?>
