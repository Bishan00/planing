<?php
include './includes/admin_header.php';
include './includes/data_base_save_update.php';
//include 'includes/App_Code.php';
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

// Check if the work order ID is provided by the user
if (isset($_POST['erp'])) {
    $workOrderID = $_POST['erp'];

    // Perform subtraction and insert result into result_table for the specific work order ID
    $sql = "INSERT INTO tobeplan (icode, tobe)
           SELECT t1.icode, t1.new - t2.cstock
           FROM worder t1
           INNER JOIN stock t2 ON t1.icode = t2.icode
           WHERE t1.erp = $workOrderID";

    if ($conn->query($sql) === TRUE) {
        echo "Subtraction performed successfully";
    } else {
        echo "Error performing subtraction: " . $conn->error;
    }
}

$conn->close();
?>

<form method="POST" action="planning.php">
    <label for="erp">Work Order ID:</label>
    <input type="text" name="erp" id="erp">
    <button type="submit" name="submit">Click Next</button>
</form>
