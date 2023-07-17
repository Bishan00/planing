<?php
// Assuming you have already established a MySQL connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query
$sql = "SELECT
            td.icode,
            td.mold_id,
            tp.tobe/td.mold_count AS tire_per_mold
        FROM
            (SELECT
                td.icode,
                td.mold_id,
                COUNT(td.mold_id) AS mold_count
            FROM
                quick_plan td
            JOIN
                tobeplan tp ON td.icode = tp.icode
            GROUP BY
                td.icode, td.mold_id) AS td
        JOIN
            tobeplan tp ON td.icode = tp.icode";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    die("Error executing the query: " . $conn->error);
}

// Process the query results
if ($result->num_rows > 0) {
    // Output the data
    while ($row = $result->fetch_assoc()) {
        echo "icode: " . $row['icode'] . "<br>";
        echo "mold_id: " . $row['mold_id'] . "<br>";
        echo "tire_per_mold: " . $row['tire_per_mold'] . "<br>";
        echo "<br>";
    }
} else {
    echo "No results found.";
}

// Close the connection
$conn->close();
?>
