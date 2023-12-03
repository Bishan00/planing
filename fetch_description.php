<?php
$hostname = 'localhost';
$username = 'planatir_task_management';
$password = 'Bishan@1919';
$database = 'planatir_task_management';

// Create a connection to the database
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['icode'])) {
    $icode = $_GET['icode'];

    // Query the database to fetch the description based on the item code
    $sql = "SELECT description FROM tire WHERE icode = '$icode'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $description = $row['description'];
        echo $description;
    }
}

// Close the database connection
$conn->close();
?>
