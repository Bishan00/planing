<?php
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$dbname = "planatir_task_management";



// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to copy data from 'process' table to 'new_process' table
$sql = "INSERT INTO old_process (
    id,
    icode,
    mold_id,
    tires_per_mold,
    cavity_id,
    mold_name,
    cavity_name,
    press_name,
    press_id,
    erp,
    serial
)
SELECT
    id,
    icode,
    mold_id,
    tires_per_mold,
    cavity_id,
    mold_name,
    cavity_name,
    press_name,
    press_id,
    erp,
    serial
FROM
    process";

if ($conn->query($sql) === TRUE) {
    echo "Data copied successfully.";
} else {
    echo "Error copying data: " . $conn->error;
}


// Close the connection
$conn->close();
header("Location: deleteall.php");
exit();
?>
