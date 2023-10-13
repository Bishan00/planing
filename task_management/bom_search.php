<?php
$servername = "localhost";
$username = "planatir_task_management";
$password = "Bishan@1919";
$database = "planatir_task_management";

// Create a connection to MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $icode = $_POST["icode"];
    
    // SQL query to retrieve data for the given icode
    $sql = "SELECT * FROM `bom_new` WHERE `icode` = '$icode'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data in a table format
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Item</th><th>icode</th><th>t_size</th><th>Item Description</th><th>B-ATS 15</th><th>B-BNS 24</th><th>BG-BLS 12</th><th>CG - BS 901</th><th>C - SMS 501</th><th>C-ATS 20</th><th>C-SMS 702</th><th>T - TRS 102</th><th>T-ATNM S</th><th>T-ATS 30</th><th>T-ATS 35</th><th>T-KS 40</th><th>T-TRNMS 402</th><th>T-TRNMS 402G</th><th>T-TRS 202</th><th>Grand Totalcompound weight</th><th>Color</th><th>Brand</th><th>Green Tire weight</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["id"]."</td>";
            echo "<td>".$row["Item"]."</td>";
            echo "<td>".$row["icode"]."</td>";
            echo "<td>".$row["t_size"]."</td>";
            echo "<td>".$row["Item Description"]."</td>";
            echo "<td>".$row["B-ATS 15"]."</td>";
            echo "<td>".$row["B-BNS 24"]."</td>";
            echo "<td>".$row["BG-BLS 12"]."</td>";
            echo "<td>".$row["CG - BS 901"]."</td>";
            echo "<td>".$row["C - SMS 501"]."</td>";
            echo "<td>".$row["C-ATS 20"]."</td>";
            echo "<td>".$row["C-SMS 702"]."</td>";
            echo "<td>".$row["T - TRS 102"]."</td>";
            echo "<td>".$row["T-ATNM S"]."</td>";
            echo "<td>".$row["T-ATS 30"]."</td>";
            echo "<td>".$row["T-ATS 35"]."</td>";
            echo "<td>".$row["T-KS 40"]."</td>";
            echo "<td>".$row["T-TRNMS 402"]."</td>";
            echo "<td>".$row["T-TRNMS 402G"]."</td>";
            echo "<td>".$row["T-TRS 202"]."</td>";
            echo "<td>".$row["Grand Totalcompound weight"]."</td>";
            echo "<td>".$row["Color"]."</td>";
            echo "<td>".$row["Brand"]."</td>";
            echo "<td>".$row["Green Tire weight"]."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No records found for icode: $icode";
    }
}

// Close the database connection
$conn->close();
?>

