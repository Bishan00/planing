<?php

$host = 'localhost'; // The hostname of the database server (e.g., 'localhost')
$username = 'planatir_task_management'; // The username to access the database
$password = 'Bishan@1919'; // The password to access the database
$database = 'planatir_task_management'; // The name of the database

// Create a connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (mysqli_connect_errno()) {
    die('Failed to connect to the database: ' . mysqli_connect_error());
}




// Delete records from the quick_plan table
$deletetobe = "DELETE FROM merged_data";
mysqli_query($connection, $deletetobe);

// Delete records from the quick_plan table
$deletetobe = "DELETE FROM match_table";
mysqli_query($connection, $deletetobe);

// Close the database connection
mysqli_close($connection);


header("Location: indiview.php");
exit();

?>