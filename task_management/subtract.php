<?php
ob_start(); // Start output buffering

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

if (isset($_POST['submit'])) {
    // Get the user-provided work order ID
    $erp = $_POST['erp'];

    // Perform subtraction and insert result into result_table
    $sql = "INSERT INTO tobeplan (icode, tobe, erp)
            SELECT t1.icode, t1.new - t2.cstock, t1.erp
            FROM worder t1
            INNER JOIN stock t2 ON t1.icode = t2.icode
            WHERE t1.erp = '$erp'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to another page to display the relevant data
        header("Location: display.php?erp=$erp");
        exit;
    } else {
        echo "Error performing subtraction: " . $conn->error;
    }
}

$conn->close();
ob_end_flush(); // Send output buffer and turn off output buffering
?>

<form method="POST" action="subtract.php">
    <label for="erp">Work Order ID:</label>
    <input type="text" name="erp" id="erp" required>
    <button type="submit" name="submit">Click Next</button>
</form>
