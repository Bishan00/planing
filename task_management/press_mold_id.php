<?php
// Database connection information
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$database = "planatir_task_management";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
    SELECT 
        p.press_id AS press_id,
        m.mold_id AS mold_id
    FROM
        combinedd_data cd
    JOIN
        press p ON cd.press = p.press_name
    JOIN
        mold m ON cd.mold = m.mold_name
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Iterate through the query results
    while ($row = $result->fetch_assoc()) {
        $pressId = $row["press_id"];
        $moldId = $row["mold_id"];
        
        // Insert data into the mold_press table
        $insertSql = "INSERT INTO mold_presss (mold_id,press_id) VALUES ('$moldId','$pressId')";
        
        if ($conn->query($insertSql) === TRUE) {
            echo "Record inserted successfully.<br>";
        } else {
            echo "Error inserting record: " . $conn->error . "<br>";
        }
    }
} else {
    echo "No results found.";
}

// Close the database connection
$conn->close();
?>
