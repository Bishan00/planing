<!DOCTYPE html>
<html>
<head>
<style>
    body {
        background-color: #f0f0f0; /* Light gray background for the page */
    }
    
    .container {
        text-align: center;
        margin-top: 20px;
        background-color: #ffffff; /* White background for the container */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
    }

    table {
        border-collapse: collapse;
        width: 50%;
        margin: auto;
        background-color: #f9f9f9; /* Light gray background for the table */
        border-radius: 8px;
        overflow: hidden; /* To clip the border-radius on the table */
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #3498db;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }
</style>
</head>
<body>
<div class="container">
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
                <caption>Daily Reject Data</caption>
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
</div>

</body>
</html>
