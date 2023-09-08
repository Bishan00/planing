<!DOCTYPE html>
<html>
<head>
    <title>Matching Mold, Cavity, Press, and Cavity Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th {
            padding: 10px;
            text-align: left;
            background-color: #007BFF; /* Blue background color */
            color: white; /* White text color */
        }

        td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Mold Changing List</h1>

    <?php
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "task_management";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
// SQL query to retrieve matching mold_ids, cavity_ids, pressids, their corresponding first_start_date, press_name, and mold_name
$sql = "
SELECT DISTINCT m1.mold_id, m1.cavity_id, pc.press_id, p.press_name, m1.first_start_date, c.cavity_name, m.mold_name
FROM match_table m1
JOIN match_table m2 ON m1.cavity_id = m2.cavity_id
JOIN cavity c ON m1.cavity_id = c.cavity_id
JOIN press_cavity pc ON m1.cavity_id = pc.cavity_id
JOIN press p ON pc.press_id = p.press_id
JOIN mold m ON m1.mold_id = m.mold_id
WHERE m1.id != m2.id;
";
$result = $conn->query($sql);

if (!$result) {
die("Query failed: " . $conn->error);
}

if ($result->num_rows > 0) {
echo "<table>";
echo "<tr><th>Press Name</th><th>Cavity Name</th><th>Mold Name</th><th>First Start Date</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["press_name"] . "</td>";
    echo "<td>" . $row["cavity_name"] . "</td>";
    //echo "<td>" . $row["cavity_id"] . "</td>";
    //echo "<td>" . $row["press_id"] . "</td>";
   // echo "<td>" . $row["mold_id"] . "</td>";
    echo "<td>" . $row["mold_name"] . "</td>";
    echo "<td>" . $row["first_start_date"] . "</td>";
    echo "</tr>";
}

echo "</table>";
} else {
echo "No matching mold_ids, cavity_ids, pressids, and first_start_dates found.";
}

// Close the database connection
$conn->close();
?>
</div>
</body>
</html>
