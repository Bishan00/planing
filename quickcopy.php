<?php
// First, copy data from the source table to the destination table

// Database connection configuration for the source database
$sourceHost = 'localhost';
$sourceUsername = 'planatir_task_management';
$sourcePassword = 'Bishan@1919';
$sourceDatabase = 'planatir_task_management';

// Database connection configuration for the destination database
$destHost = 'localhost';
$destUsername = 'planatir_task_management';
$destPassword = 'Bishan@1919';
$destDatabase = 'planatir_task_management';

// Create connections to the source and destination databases
$sourceConn = new mysqli($sourceHost, $sourceUsername, $sourcePassword, $sourceDatabase);
if ($sourceConn->connect_error) {
    die("Connection to source database failed: " . $sourceConn->connect_error);
}

$destConn = new mysqli($destHost, $destUsername, $destPassword, $destDatabase);
if ($destConn->connect_error) {
    die("Connection to destination database failed: " . $destConn->connect_error);
}

// Name of the source and destination tables
$sourceTable = 'tobeplan';
$destTable = 'tobeplannew';

// Copy data from source table to destination table with positive values in 'tobe' column
$sql = "INSERT INTO $destTable 
        SELECT * 
        FROM $sourceTable 
        WHERE $sourceTable.tobe > 0"; // Only copy rows with positive 'tobe' values
if ($destConn->query($sql) === TRUE) {
    echo "Data copied successfully.";
} else {
    echo "Error copying data: " . $destConn->error;
}

// Close database connections
$sourceConn->close();
$destConn->close();

header("Location: quicktobe.php");
exit();
?>
