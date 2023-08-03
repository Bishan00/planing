<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'task_management';

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $icode = $_POST['icode'];
    $moldName = $_POST['moldName'];
    $cavityName = $_POST['cavity'];
    $isMold = $_POST['isMold'];

    // Fetch the cavity_id corresponding to the selected cavity_name
    $cavityIdQuery = "SELECT cavity_id FROM cavity WHERE cavity_name = '$cavityName'";
    $cavityIdResult = mysqli_query($connection, $cavityIdQuery);

    if (mysqli_num_rows($cavityIdResult) > 0) {
        $row = mysqli_fetch_assoc($cavityIdResult);
        $cavityId = $row['cavity_id'];

        // Update the cavity_id and cavity_name in the process table
        $updateQuery = "UPDATE `process` SET `cavity_id` = '$cavityId', `cavity_name` = '$cavityName' WHERE `mold_name` = '$moldName'";
        mysqli_query($connection, $updateQuery);
    }
}

mysqli_close($connection);
