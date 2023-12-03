<?php
// MySQL database credentials
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

// Delete all data from the copied_work table
$deleteCopiedWorkSql = "DELETE FROM copied_work";
$conn->query($deleteCopiedWorkSql);

$copyDataQuery = "INSERT INTO tobeplan1 SELECT * FROM tobeplan";
$conn->query($copyDataQuery);

// Delete all data from the tobeplan table
$deleteTobeplanSql = "DELETE FROM tobeplan";
$conn->query($deleteTobeplanSql);

$checkWCopyData = "SELECT COUNT(*) as count FROM wcopy";
$result = $conn->query($checkWCopyData);
$row = $result->fetch_assoc();
$count = $row['count'];

if ($count > 0) {
    header("Location: testingbisb.php");
    exit;
}

$conn->close();

header("Location: dashboard.php");
exit;
?>
