<?php
// Assuming you have already established a database connection
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
// SQL query to select one press_id for each mold_id corresponding to each icode
$query = "SELECT icode, mold_id, press_id
          FROM task_data
          GROUP BY icode, mold_id";

$result = mysqli_query($connection, $query);

if ($result) {
    // Iterate through the result set
    while ($row = mysqli_fetch_assoc($result)) {
        $icode = $row['icode'];
        $moldId = $row['mold_id'];
        $pressId = $row['press_id'];
        
        // Display the press_id corresponding to the mold_id and icode
        echo "Press ID for iCode $icode and Mold ID $moldId: $pressId<br>";
    }
} else {
    // Handle any potential query errors
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
