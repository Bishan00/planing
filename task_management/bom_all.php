<!DOCTYPE html>
<html>
<head>
    <title>Retrieve Data by icode</title>
</head>
<body>
    <h2>Retrieve Data by icode</h2>
    <form method="post" action="bom_search.php">
        <label for="icode">Enter icode: </label>
        <input type="text" id="icode" name="icode" required>
        <input type="submit" value="Retrieve Data">
    </form>
</body>
</html>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "task_management";

// Create a connection to MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
//if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["go"])) {
    // Redirect to another page when the button is clicked
   // header("Location: bom_search.php");
   
//}

// SQL query to retrieve all data from the 'bom_new' table
$sql = "SELECT * FROM `bom_new`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data in a table format

    //echo "<input type='submit' name='go' value='Enter Icode'>";
    echo "<form method='post'>";
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
  
    echo "</form>";
} else {
    echo "No records found.";
}

// Close the database connection
$conn->close();
?>
