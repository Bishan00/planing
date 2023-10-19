<!DOCTYPE html>
<html>
<head>
<style>
        .table-container {
            text-align: center; /* Center the table */
        }

        table {
            width: 80%; /* Make the table slightly smaller */
            margin: 0 auto; /* Center the table horizontally */
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #e6e6e6;
        }

        th, td {
            border: 1px solid #ccc;
        }

        td {
            color: #333;
        }

        /* Center the button within a table row */
        .button-container {
            text-align: center;
        }
    </style>
</head>
<body>
<?php
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$dbname = "planatir_task_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT template.id, template.icode, template.cstock, template.date, template.shift, tire.description
        FROM template
        JOIN tire ON template.icode = tire.icode";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ICode</th><th>Description</th><th>CStock</th><th>Date</th><th>Shift</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        
        echo "<td>" . $row['icode'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
       
        echo "<td>" . $row['cstock'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>" . $row['shift'] . "</td>";
        
        echo "</tr>";
    }
    
    // Add a button in the middle of the table
    echo "<tr class='button-container'><td colspan='5'>";
    //echo "<form action='dashboard.php' method='GET'>";
    echo "<form action='showdaily2.php' method='GET'>";
    echo "<input type='hidden' name='parameter_name' value='1'>";
    echo "<button type='submit'>OK</button>";
    echo "</form>";
    echo "</td></tr>";
    
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
</body>
</html>
