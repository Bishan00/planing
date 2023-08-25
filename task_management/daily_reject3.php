<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the date from dates table for id 1
$sql_get_date = "SELECT dates_c FROM dates WHERE date_id = 1";
$result = $conn->query($sql_get_date);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $date_to_update = $row['dates_c'];

    // Update daily_reject table with the fetched date
    $sql_update = "UPDATE daily_reject SET dates_c = '$date_to_update'";

    if ($conn->query($sql_update) === TRUE) {
        echo "Update successful";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Date not found in dates table.";
}

// Close the connection
$conn->close();


header("Location: daily_reject4.php");
exit();
?>
