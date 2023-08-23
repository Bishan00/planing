<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'task_management';

$connection = mysqli_connect($host, $username, $password, $database);

if (mysqli_connect_errno()) {
    die('Failed to connect to the database: ' . mysqli_connect_error());
}

// Check if there is data in the wcopy table
$checkWCopyData = "SELECT COUNT(*) as count FROM wcopy";
$result = mysqli_query($connection, $checkWCopyData);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];

if ($count > 0) {
    // If there is data in the wcopy table, redirect to testingbiz.php
    header("Location: testingbis.php");
    exit; // Make sure to exit after sending the header
}

// Delete records from different tables
$deleteProductionPlan = "DELETE FROM new_table1";
mysqli_query($connection, $deleteProductionPlan);

$deleteTireCavity = "DELETE FROM new_table2";
mysqli_query($connection, $deleteTireCavity);

$deleteTireMolddd = "DELETE FROM result_table";
mysqli_query($connection, $deleteTireMolddd);

$deleteQuickPlan = "DELETE FROM new_table";
mysqli_query($connection, $deleteQuickPlan);

$deleteProcess = "DELETE FROM new_table3";
mysqli_query($connection, $deleteProcess);

$deleteToBe = "DELETE FROM result_table";
mysqli_query($connection, $deleteToBe);

mysqli_close($connection);

// Redirect to planning.php
header("Location: planning.php");
exit;

?>
