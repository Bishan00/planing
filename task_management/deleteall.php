<?php

$host = 'localhost'; // The hostname of the database server (e.g., 'localhost')
$username = 'root'; // The username to access the database
$password = ''; // The password to access the database
$database = 'task_management'; // The name of the database

// Create a connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (mysqli_connect_errno()) {
    die('Failed to connect to the database: ' . mysqli_connect_error());
}
// Delete records from the production_plan table
$deleteProductionPlan = "DELETE FROM production_plan";
mysqli_query($connection, $deleteProductionPlan);

// Delete records from the tire_cavity table
$deleteTireCavity = "DELETE FROM tire_cavity";
mysqli_query($connection, $deleteTireCavity);

// Delete records from the tire_molddd table
$deleteTireMolddd = "DELETE FROM tire_molddd";
mysqli_query($connection, $deleteTireMolddd);

// Delete records from the quick_plan table
$deleteQuickPlan = "DELETE FROM quick_plan";
mysqli_query($connection, $deleteQuickPlan);

// Delete records from the quick_plan table
$deleteprocess = "DELETE FROM process";
mysqli_query($connection, $deleteprocess);

// Close the database connection
mysqli_close($connection);


header("Location: planning.php")

?>
