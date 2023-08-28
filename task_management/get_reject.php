<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Retrieve and display data from the table
$sqlRetrieve = "SELECT * FROM daily_reject";
$result = $conn->query($sqlRetrieve);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>icode</th>
                <th>amount</th>
                <th>date</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["icode"]."</td>
                <td>".$row["amount"]."</td>
                <td>".$row["dates_c"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No data found.";
}

// Close the connection
$conn->close();
?>
