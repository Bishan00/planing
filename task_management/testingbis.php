<?php
// Replace these with your actual database credentials
$hostname = "localhost";
$username = "root";
$password = "";
$database = "task_management";

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to find the minimum date
$minDateQuery = "SELECT MIN(`date`) AS min_date FROM `wcopy`";
$minDateResult = $conn->query($minDateQuery);
$minDateRow = $minDateResult->fetch_assoc();
$minDate = $minDateRow["min_date"];

// SQL query to insert data into copied_work table
$insertQuery = "INSERT INTO `copied_work` (`id`, `date`, `Customer`, `wono`, `ref`, `erp`, `icode`, `t_size`, `brand`, `col`, `fit`, `rim`, `cons`, `fweight`, `ptv`, `new`, `cbm`, `kgs`)
                SELECT `id`, `date`, `Customer`, `wono`, `ref`, `erp`, `icode`, `t_size`, `brand`, `col`, `fit`, `rim`, `cons`, `fweight`, `ptv`, `new`, `cbm`, `kgs`
                FROM `wcopy`
                WHERE `date` = '$minDate'";

$resultInsert = $conn->query($insertQuery);

if ($resultInsert) {
    // Delete the copied data from wcopy table
    $deleteQuery = "DELETE FROM `wcopy` WHERE `date` = '$minDate'";
    $resultDelete = $conn->query($deleteQuery);

    if ($resultDelete) {
       // echo "Data moved to copied_work and deleted from wcopy successfully.";
    } else {
       // echo "Error deleting data from wcopy: " . $conn->error;
    }
} else {
    //echo "Error inserting data into copied_work: " . $conn->error;
}

// Close the connection
$conn->close();

header("Location: subtractR.php");
exit();
?>
