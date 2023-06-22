<?php
// display.php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
include 'includes/App_Code.php';
$AppCodeObj = new App_Code();

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

// Retrieve the ERP from the URL parameter
$erp = $_GET['erp'];

// Fetch data from tobeplan table for the specified ERP
$sql = "SELECT * FROM tobeplan WHERE erp = '$erp'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display the fetched data in a table
    echo "<table>";
    echo "<tr><th>ICODE</th><th>TOBE</th><th>ERP</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['icode'] . "</td>";
        echo "<td>" . $row['tobe'] . "</td>";
        echo "<td>" . $row['erp'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Add a button to send the ERP number to another page
    echo "<form action='plannew34.php' method='get'>";
    echo "<input type='hidden' name='erp' value='" . $erp . "'>";
    echo "<button type='submit'>Generate Plan</button>";
    echo "</form>";
} else {
    echo "No data found for the provided ERP.";
}

$conn->close();
?>

