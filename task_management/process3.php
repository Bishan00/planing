<?php
// Assuming you have already established a database connection

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Create a connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT icode,  GROUP_CONCAT(DISTINCT mold_id) AS mold_ids, GROUP_CONCAT(DISTINCT press_id) AS press_ids 
        FROM new_table 
        GROUP BY icode";

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $icode = $row['icode'];
        $moldIds = $row['mold_ids'];
        $pressIds = $row['press_ids'];

        echo "iCode: $icode<br>";
        echo "Mold ID: $moldIds<br>";
        echo "Press ID: $pressIds<br>";

        // Get capacity for each mold ID and press ID combination
        $moldIdsArray = explode(',', $moldIds);
        $pressIdsArray = explode(',', $pressIds);

        foreach ($moldIdsArray as $moldId) {
            foreach ($pressIdsArray as $pressId) {
                $capacity = getCapacity($connection, $moldId, $pressId);
                echo "Capacity for Mold ID $moldId and Press ID $pressId: $capacity<br>";

                // Save the data in the task_data table
                $insertSql = "INSERT INTO task_data (icode, mold_id, press_id, capacity)
                              VALUES ('$icode', '$moldId', '$pressId', '$capacity')";
                mysqli_query($connection, $insertSql);
            }
        }

        // Count the number of mold_ids related to the icode
        $moldIdCount = count($moldIdsArray);
        echo "Number of Mold IDs: $moldIdCount<br>";

        echo "<br>";
    }
} else {
    echo "No records found.";
}

// Close the database connection
mysqli_close($connection);

function getCapacity($connection, $moldId, $pressId) {
    $sql = "SELECT capacity FROM press_quantity WHERE press_id = '$pressId'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['capacity'];
    } else {
        return "Unknown";
    }
}
?>
