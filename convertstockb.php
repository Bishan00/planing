
<?php
// Establish a connection to the MySQL database
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$database = "planatir_task_management";

$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    // Copy data from "realstock" table to "stock" table
    $copyQuery = "INSERT INTO stock SELECT * FROM realstock";
    
    if ($conn->query($copyQuery) === TRUE) {
       header("Location:testingbisb.php");
exit();
    } else {
        echo "Error copying data: " . $conn->error;
        header("Location: testingbisb.php");
        exit();

    }

// Close the database connection

?>
