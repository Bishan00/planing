<?php
// Replace these variables with your database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the data sent via AJAX
    $icode = $_POST["icode"];
    $moldName = $_POST["moldName"];
    $cavity = $_POST["cavity"];
    $checked = $_POST["checked"];

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform update operations based on the checkbox state (checked/unchecked)
    if ($checked === "true") {
        // Get the mold_id and cavity_id for the selected mold_name and cavity_name
        $moldIdQuery = "SELECT mold_id FROM production_plan WHERE mold_name = '$moldName'";
        $moldIdResult = $conn->query($moldIdQuery);

        if ($moldIdResult->num_rows > 0) {
            $moldId = $moldIdResult->fetch_assoc()["mold_id"];

            $cavityIdQuery = "SELECT cavity_id FROM production_plan WHERE cavity_name = '$cavity'";
            $cavityIdResult = $conn->query($cavityIdQuery);

            if ($cavityIdResult->num_rows > 0) {
                $cavityId = $cavityIdResult->fetch_assoc()["cavity_id"];

                // Update the selected mold and cavity names with their corresponding mold_id and cavity_id in the process table
                $sqlUpdate = "UPDATE process SET mold_id='$moldId', cavity_id='$cavityId', mold_name = '$moldName', cavity_name = '$cavity'
                              WHERE icode='$icode' AND mold_id='$moldId'";
                $conn->query($sqlUpdate);
            } else {
                // Error: Could not find cavity_id for the selected cavity name
                echo "Error: Could not find cavity_id for the selected cavity name.";
            }
        } else {
            // Error: Could not find mold_id for the selected mold name
            echo "Error: Could not find mold_id for the selected mold name.";
        }
    } else {
      
    }

    // Close the connection
    $conn->close();
}
?>
