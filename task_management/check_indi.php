
<!DOCTYPE html>
<html>
<head>
<style>
table {
  border-collapse: collapse;
  width: 100%;
}

table, th, td {
  border: 1px solid black;
}

th, td {
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}
</style>
</head>
<body>

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

// SQL query to retrieve data
$sql = "SELECT iid, id, icode, id_count, start_date, end_date, cavity_id, mold_id, erp FROM merged_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>icode</th><th>id_count</th><th>start_date</th><th>end_date</th><th>cavity_id</th><th>mold_id</th><th>erp</th></tr>";
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["icode"]."</td><td>".$row["id_count"]."</td><td>".$row["start_date"]."</td><td>".$row["end_date"]."</td><td>".$row["cavity_id"]."</td><td>".$row["mold_id"]."</td><td>".$row["erp"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
</body>
</html>