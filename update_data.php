<?php
$hostname = 'localhost';
$username = 'planatir_task_management';
$password = 'Bishan@1919';
$database = 'planatir_task_management';

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $icode = $_POST['icode'];
    $moldName = $_POST['moldName'];
    $cavityName = $_POST['cavity'];
    $isMold = $_POST['isMold'];
    
    
        // Fetch the mold_id corresponding to the selected mold_name
        $moldIdQuery = "SELECT mold_id FROM mold WHERE mold_name = '$moldName'";
        $moldIdResult = mysqli_query($connection, $moldIdQuery);

        if (mysqli_num_rows($moldIdResult) > 0) {
            $row = mysqli_fetch_assoc($moldIdResult);
            $moldId = $row['mold_id'];

            // Update the mold_id and mold_name in the process table
            $updateQuery = "UPDATE `process` SET `mold_id` = '$moldId', `mold_name` = '$moldName' WHERE `cavity_name` = '$cavityName' AND `icode` = '$icode'";
            mysqli_query($connection, $updateQuery);
        }
    
        // Fetch the cavity_id corresponding to the selected cavity_name
        $cavityIdQuery = "SELECT cavity_id FROM cavity WHERE cavity_name = '$cavityName'";
        $cavityIdResult = mysqli_query($connection, $cavityIdQuery);

        if (mysqli_num_rows($cavityIdResult) > 0) {
            $row = mysqli_fetch_assoc($cavityIdResult);
            $cavityId = $row['cavity_id'];

            
$updateQuery = "UPDATE `process` SET `cavity_id` = '$cavityId', `cavity_name` = '$cavityName' WHERE `mold_name` = '$moldName' AND `icode` = '$icode'";
mysqli_query($connection, $updateQuery);


        }
    
}

mysqli_close($connection);
?>
