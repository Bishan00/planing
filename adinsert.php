<?php
$hostname = 'localhost';
$username = 'planatir_task_management';
$password = 'Bishan@1919';
$database = 'planatir_task_management';

// Create a connection to the database
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputDate = $_POST["inputDate"];
    $shift = $_POST["shift"];
    $icodeArray = $_POST["icode"];
    $cstockArray = $_POST["cstock"];
    $reasonArray = $_POST["reason"]; // Add the Reason field

    // Iterate through the submitted data and insert it into the database
    for ($i = 0; $i < count($icodeArray); $i++) {
        $icode = $conn->real_escape_string($icodeArray[$i]);
        $cstock = $conn->real_escape_string($cstockArray[$i]);
        $reason = $conn->real_escape_string($reasonArray[$i]); // Get the Reason value

        // Prepare and execute the SQL query to insert data
        $sql = "INSERT INTO template (icode, cstock, date, shift, reason) VALUES ('$icode', '$cstock', '$inputDate', '$shift', '$reason')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
     
    header("Location: showdaily.php");
    exit();
}
?>
