<?php
// Source database connection
$sourceHost = 'localhost';
$sourceUsername = 'root';
$sourcePassword = '';
$sourceDatabase = 'task_management';

$sourceConnection = new mysqli($sourceHost, $sourceUsername, $sourcePassword, $sourceDatabase);
if ($sourceConnection->connect_error) {
    die("Source database connection failed: " . $sourceConnection->connect_error);
}

// Destination database connection
$destHost = 'localhost';
$destUsername = 'root';
$destPassword = '';
$destDatabase = 'task_management';

$destConnection = new mysqli($destHost, $destUsername, $destPassword, $destDatabase);
if ($destConnection->connect_error) {
    die("Destination database connection failed: " . $destConnection->connect_error);
}

// Copy data from source to destination
$copyQuery = "INSERT INTO wcopy SELECT * FROM worder";
if ($sourceConnection->query($copyQuery) === TRUE) {
   //echo "Data copied successfully.";
} else {
    echo "Error copying data: " . $sourceConnection->error;
}

// Close connections
$sourceConnection->close();
$destConnection->close();

               header("Location: convertstockR.php");
               exit();
?>
